<?php
require_once('conf/hebtrain.conf');

require_once('lib/post.php');
require_once('lib/database.php');
require_once('lib/items.php');
require_once('lib/questions.php');
require_once('lib/stages.php');

function loadTest($qv) {
    global $mysqli, $QV_PARAMS;

    if ($qv == QV_WORD_RANDOM) {
        $qv = rand(QV_WORD_MIN, QV_WORD_MAX);
    }
    if ($qv == QV_WORD_MIX) {
        $qvFilter = '';
    } else {
        $qvFilter = 'and question=?';
    }
    $st = $mysqli->prepare(
        "select item_id, hebrew, hebrew_bare, hebrew_comment,
                russian, russian_comment, abbrev, question, priority
         from questions inner join items
              on questions.item_id = items.id
         where questions.active = 1 $qvFilter and items.next_test <= now()
               and questions.next_test <= now()
         order by priority
         limit ?");
    dbFailsafe($mysqli);
    $limit = CFG_QUESTIONS_LOAD_LIMIT;
    if ($qv == QV_WORD_MIX) {
        $limit *= QV_WORD_MAX - QV_WORD_MIN + 1;
        $st->bind_param('i', $limit);
    } else {
        $st->bind_param('ii', $qv, $limit);
    }
    $st->execute();

    $questions = array();
    $st->bind_result($itemId, $hebrew, $hebrewBare, $hebrewComment,
        $russian, $russianComment, $abbrev, $question, $priority);
    while ($st->fetch()) {
        if (!array_key_exists($itemId, $questions)) {
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
                'abbrev' => $abbrev,
                'question' => $question,
                'priority' => $priority));
    }
    
    srand();
    $itemIds = array_keys($questions);
    shuffle($itemIds);
    $result = array();
    $usedIds = array();
    while (true) {
        for ($i = 0; $i < count($itemIds); $i++) {
            if (count($result) >= CFG_QUESTIONS_PER_TEST
                || count($result) >= count($itemIds)) {
                return $result;
            }
            
            $itemId = $itemIds[$i];
            if (!isset($usedIds[$itemId]) || !$usedIds[$itemId]) {
                $n = rand(0, count($questions[$itemId]) - 1);
                $q = $questions[$itemId][$n];

                // Penalty for lower-priority questions
                if (rand(0, LS_PRIORITY_MAX + 1) < $q['priority']) {
                    continue;
                }

                $question = $q['question'];
                $test = array(
                    'item_id' => $q['item_id'],
                    'question' => $question,
                    'word' => $q[$QV_PARAMS[$question]['word']],
                    'comment' => $q[$QV_PARAMS[$question]['comment']],
                    'input' => $QV_PARAMS[$question]['input']);
                
                $answers = $QV_PARAMS[$question]['answer'];
                if (is_array($answers)) {
                    $test['answer'] = array();
                    foreach ($answers as $answer) {
                        $test['answer'][] = $q[$answer];
                    }
                } else {
                    $test['answer'] = $q[$answers];
                }
                
                array_push($result, $test);
                $usedIds[$itemId] = true;
            }
        }
    }
}

$mysqli = dbConnect();

$result = array(
    'max_correct' => CFG_MAX_CORRECT_ANSWERS,
    'min_questions' => CFG_MIN_QUESTIONS_IN_TEST,
    'tests' => loadTest(getIntVar('qv')));

dbClose($mysqli);

header('Content-Type: application/json');
echo json_encode($result);
?>
