<?php
require_once('lib/database.php');
require_once('lib/items.php');
require_once('lib/stages.php');

function getStatistics() {
    global $mysqli, $LS_PARAMS;

    $result = array();

    $st = $mysqli->prepare(
        'select count(*)
         from items
         where `group` = ?');
    dbFailsafe($mysqli);
    $group = VI_WORD;
    $st->bind_param('i', $group);
    $st->execute();
    $st->bind_result($result['words_total']);
    $st->fetch();
    $st->close();

    $st = $mysqli->prepare(
        'select count(*)
         from questions left join items
              on questions.item_id = items.id
         where `group` = ?');
    dbFailsafe($mysqli);
    $group = VI_WORD;
    $st->bind_param('i', $group);
    $st->execute();
    $st->bind_result($result['questions_total']);
    $st->fetch();
    $st->close();

    $st = $mysqli->prepare(
        'select count(*)
         from questions left join items
              on questions.item_id = items.id
         where `group` = ? and next_test <= now()');
    dbFailsafe($mysqli);
    $group = VI_WORD;
    $st->bind_param('i', $group);
    $st->execute();
    $st->bind_result($result['questions_now']);
    $st->fetch();
    $st->close();

    $st = $mysqli->prepare(
        'select stage, step, count(*)
         from questions left join items
              on questions.item_id = items.id
         where `group` = ?
         group by stage, step
         order by stage, step');
    dbFailsafe($mysqli);
    $group = VI_WORD;
    $st->bind_param('i', $group);
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

