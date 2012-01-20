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
        'select stage, count(*)
         from questions left join items
              on questions.item_id = items.id
         where `group` = ?
         group by stage
         order by stage');
    dbFailsafe($mysqli);
    $group = VI_WORD;
    $st->bind_param('i', $group);
    $st->execute();
    $st->bind_result($stage, $count);
    $result['stages'] = array();
    while ($st->fetch()) {
        array_push(
            $result['stages'],
            array(
                'name' => $LS_PARAMS[$stage]['name'],
                'count' => $count));
    }
    $st->close();

    return $result;
}

$mysqli = dbConnect();

$result = getStatistics();

dbClose($mysqli);

header('Content-Type: application/json');
echo json_encode($result);

