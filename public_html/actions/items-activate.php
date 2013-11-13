<?php
require_once('conf/hebtrain.conf');

require_once('lib/database.php');
require_once('lib/questions.php');

function activateItems() {
    global $mysqli;

    $st = $mysqli->prepare(
        'select count(*)
         from tests
         where completed >= now() - interval 1 day');
    dbFailsafe($mysqli);
    $st->execute();
    $st->bind_result($tests_count);
    $st->fetch();
    $st->close();

    if ($tests_count < CFG_MIN_TESTS_PER_DAY)
    	return array();

    $st = $mysqli->prepare(
        'select count(*)
         from questions left join items
              on questions.item_id = items.id
         where questions.active = 1 and items.active = 1
               and activated >= now() - interval 1 day');
    dbFailsafe($mysqli);
    $st->execute();
    $st->bind_result($activated_count);
    $st->fetch();
    $st->close();

    $to_activate = CFG_NEW_QUESTIONS_PER_DAY - $activated_count;
    $activated = array();

    while ($to_activate > 0) {
        $id = 0;

        $st = $mysqli->prepare(
            'select id, `group`, hard, abbrev
             from items
             where active = 0
             order by added asc
             limit 1');
        dbFailsafe($mysqli);
        $st->execute();
        $st->bind_result($id, $group, $hard, $abbrev);
        $st->fetch();
        $st->close();

        if ($id <= 0) {
            break;
        }

        $to_activate -= enableQuestions(
            $mysqli, $id, $group, $hard, $abbrev != '', true);
        $activated[] = $id;
    }

    return $activated;
}

$mysqli = dbConnect();

$activated = activateItems();

dbClose($mysqli);

header('Content-Type: application/json');
echo json_encode($activated);
?>
