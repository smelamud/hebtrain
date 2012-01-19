<?php
require_once('conf/hebtrain.conf');

require_once('lib/database.php');
require_once('lib/items.php');
require_once('lib/questions.php');

function loadTest() {
    global $mysqli, $QV_PARAMS;

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
        $q = $questions[$itemIds[$i]][$n];
        $question = $q['question'];
        array_push(
            $result,
            array(
                'item_id' => $q['item_id'],
                'question' => $question,
                'word' => $q[$QV_PARAMS[$question]['word']],
                'comment' => $q[$QV_PARAMS[$question]['comment']],
                'answer' => $q[$QV_PARAMS[$question]['answer']]));
    }

    return $result;
}

$mysqli = dbConnect();

$result = array(
    'max_correct' => CFG_MAX_CORRECT_ANSWERS,
    'min_questions' => CFG_MIN_QUESTIONS_IN_TEST,
    'tests' => loadTest());

dbClose($mysqli);

header('Content-Type: application/json');
echo json_encode($result);
?>
