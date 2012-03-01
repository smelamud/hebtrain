<?php
require_once('lib/database.php');
require_once('lib/items.php');
require_once('lib/stages.php');
require_once('lib/questions.php');

function getStatistics() {
    global $mysqli, $LS_PARAMS, $QV_PARAMS;

    $result = array();

    $st = $mysqli->prepare(
        'select count(*)
         from items');
    dbFailsafe($mysqli);
    $st->execute();
    $st->bind_result($result['words_total']);
    $st->fetch();
    $st->close();

    $result['questions'] = array();

    $result['questions_total'] = 0;

    $st = $mysqli->prepare(
        'select question, count(*)
         from questions left join items
              on questions.item_id = items.id
         where active = 1
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

    $result['questions_now'] = 0;

    $st = $mysqli->prepare(
        'select question, count(*)
         from questions left join items
              on questions.item_id = items.id
         where active = 1 and items.next_test <= now()
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
    $st->fetch();
    $st->close();

    $st = $mysqli->prepare(
        'select stage, step, count(*)
         from questions left join items
              on questions.item_id = items.id
         where active = 1
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

    return $result;
}

$mysqli = dbConnect();

$result = getStatistics();

dbClose($mysqli);

header('Content-Type: application/json');
echo json_encode($result);

