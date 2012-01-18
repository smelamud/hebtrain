<?php
require_once('conf/hebtrain.conf');

require_once('lib/database.php');
require_once('lib/items.php');

function loadTest() {
    global $mysqli;

    $st = $mysqli->prepare(
        'select item_id, hebrew, hebrew_bare, hebrew_comment,
                russian, russian_comment, question
         from questions inner join items
              on questions.item_id = items.id
         where `group` = ? and next_test <= now()
         order by item_id
         limit ?');
    dbFailsafe($mysqli);
    $group = VI_WORD;
    $limit = CFG_QUESTIONS_LOAD_LIMIT;
    $st->bind_param('ii', $group, $limit);
    $st->execute();

    $itemIds = array();
    $questions = array();
    $st->bind_result($itemId, $hebrew, $hebrewBare, $hebrewComment,
        $russian, $russianComment, $question);
    while ($st->fetch()) {
        $count = count($itemIds);
        if ($count == 0 || $itemIds[$count - 1] != $itemId) {
            $itemIds[] = $itemId;
            $questions[$itemId] = array();
        }
        array_push(
            $questions[$itemId],
            array(
                'item_id' => $itemId,
                'hebrew' => $hebrew,
                'hebrew_bare' => $hebrewBare,
                'hebrew_comment' => $hebrewComment,
                'russian' => $russian,
                'russian_comment' => $russianComment,
                'question' => $question));
    }
    
    srand();
    shuffle($itemIds);
    $result = array();
    for ($i = 0; $i < CFG_QUESTIONS_PER_TEST && $i < count($itemIds); $i++) {
        $n = rand(0, count($questions[$itemIds[$i]]) - 1);
        array_push(
            $result,
            $questions[$itemIds[$i]][$n]);
    }

    return $result;
}

$mysqli = dbConnect();

$result = loadTest();

dbClose($mysqli);

header('Content-Type: application/json');
echo json_encode($result);
?>
