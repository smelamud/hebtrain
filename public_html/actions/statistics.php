<?php
require_once('lib/database.php');
require_once('lib/items.php');
require_once('lib/stages.php');
require_once('lib/questions.php');

function getStatistics() {
    global $mysqli, $LS_PARAMS, $QV_PARAMS;

    $result = array();

    /* Total number of items */
    $st = $mysqli->prepare(
        'select count(*)
         from items');
    dbFailsafe($mysqli);
    $st->execute();
    $st->bind_result($result['words_total']);
    $st->fetch();
    $st->close();

    /* Total number of active items */
    $st = $mysqli->prepare(
        'select count(*)
         from items
         where active = 1');
    dbFailsafe($mysqli);
    $st->execute();
    $st->bind_result($result['words_active']);
    $st->fetch();
    $st->close();

    /* Number of questions per type */
    $result['questions'] = array();

    $result['questions_total'] = 0;
    $result['questions_per_test'] = CFG_QUESTIONS_PER_TEST;

    $st = $mysqli->prepare(
        'select question, count(*)
         from questions left join items
              on questions.item_id = items.id
         where questions.active = 1
         group by question
         order by question');
    dbFailsafe($mysqli);
    $st->execute();
    $st->bind_result($question, $count);
    while ($st->fetch()) {
        array_push(
            $result['questions'],
            array(
                'title' => $QV_PARAMS[$question]['title'],
                'total' => $count
            ));
        $result['questions_total'] += $count;
    }
    $st->close();

    /* Number of questions to ask per type */
    $result['questions_now'] = 0;

    $st = $mysqli->prepare(
        'select question, count(*)
         from questions left join items
              on questions.item_id = items.id
         where questions.active = 1 and items.next_test <= now()
               and questions.next_test <= now()
         group by question
         order by question');
    dbFailsafe($mysqli);
    $st->execute();
    $st->bind_result($question, $count);
    while ($st->fetch()) {
        $result['questions'][$question - QV_WORD_MIN]['now'] = $count;
        $result['questions_now'] += $count;
    }
    $st->close();

    /* Total number of distinct items in questions to ask */
    $st = $mysqli->prepare(
        'select count(distinct questions.item_id)
         from questions left join items
              on questions.item_id = items.id
         where questions.active = 1 and items.next_test <= now()
               and questions.next_test <= now()');
    dbFailsafe($mysqli);
    $st->execute();
    $st->bind_result($result['items_now']);
    $st->fetch();
    $st->close();

    /* Number of questions per stage */
    $st = $mysqli->prepare(
        'select stage, step, count(*)
         from questions left join items
              on questions.item_id = items.id
         where questions.active = 1
         group by stage, step
         order by stage, step');
    dbFailsafe($mysqli);
    $st->execute();
    $st->bind_result($stage, $step, $count);
    $result['stages'] = array();
    $info = array('stage' => -1);
    while ($st->fetch()) {
        if ($stage != $info['stage']) {
            if ($info['stage'] >= 0) {
                array_push(
                    $result['stages'],
                    $info);
            }
            $info = array(
                'stage' => $stage,
                'name' => $LS_PARAMS[$stage]['name'],
                'period' => $LS_PARAMS[$stage]['period'],
                'count' => 0,
                'steps' => array_fill(0, $LS_PARAMS[$stage]['steps'], 0));
        }
        $info['count'] += $count;
        $info['steps'][$step] = $count;
    }
    if ($info['stage'] >= 0) {
        array_push(
            $result['stages'],
            $info);
    }
    $st->close();

    /* Number of questions to ask per stage */
    $st = $mysqli->prepare(
        'select stage, count(*)
         from questions left join items
              on questions.item_id = items.id
         where questions.active = 1 and items.next_test <= now()
               and questions.next_test <= now()
         group by stage
         order by stage');
    dbFailsafe($mysqli);
    $st->execute();
    $st->bind_result($stage, $count);
    $result['ready'] = array();
    while ($st->fetch()) {
        $info = array(
            'stage' => $stage,
            'count' => $count);
        array_push(
            $result['ready'],
            $info);
    }
    $st->close();

    /* Total number of tests completed today */
    $st = $mysqli->prepare(
        'select count(*)
         from tests
         where date(completed) = curdate()');
    dbFailsafe($mysqli);
    $st->execute();
    $st->bind_result($result['tests_done_today']);
    $st->fetch();
    $st->close();

    return $result;
}

$mysqli = dbConnect();

$result = getStatistics();

dbClose($mysqli);

header('Content-Type: application/json');
echo json_encode($result);
?>
