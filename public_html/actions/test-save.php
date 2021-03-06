<?php
require_once('conf/hebtrain.conf');

require_once('lib/database.php');
require_once('lib/stages.php');

function saveResult($data) {
    global $mysqli, $LS_PARAMS;

    foreach ($data as $item) {
        if ($item['answers_total'] < CFG_MIN_ANSWERS_TO_ADVANCE) {
            continue;
        }

        $st = $mysqli->prepare(
            'select stage, step,
                    least(datediff(now(), questions.next_test),
                          datediff(now(), items.next_test))
             from questions
                  left join items
                       on questions.item_id = items.id
             where item_id = ? and question = ?');
        dbFailsafe($mysqli);
        $st->bind_param('ii', $item['item_id'], $item['question']);
        $st->execute();
        $st->bind_result($stage, $step, $period);
        $st->fetch();
        $st->close();

        if ($item['answers_correct'] == $item['answers_total']) {
            if ($item['answers_correct'] >= CFG_MAX_CORRECT_ANSWERS) {
                $realStage = getStageByPeriod($period, $stage, $step);
                if ($realStage > $stage) {
                    $step = 0;
                    $stage = $realStage;
                } else {
                    $step++;
                    if ($step >= $LS_PARAMS[$stage]['steps']) {
                        $step = 0;
                        $stage++;
                    }
                }
            }
        } else if ($item['answers_total'] - $item['answers_correct'] > CFG_MAX_INCORRECT_ANSWERS) {
            $step--;
            if ($step < 0) {
                $step = 0;
                $stage--;
                if ($stage < 0) {
                    $stage = 0;
                }
            }
        }

        $st = $mysqli->prepare(
            'update questions
             set stage = ?, step = ?, next_test = now() + interval ? day,
                 priority = ?
             where item_id = ? and question = ?');
        dbFailsafe($mysqli);
        $st->bind_param('iiiiii', $stage, $step, $LS_PARAMS[$stage]['period'],
            $LS_PARAMS[$stage]['priority'], $item['item_id'], $item['question']);
        $st->execute();
        $st->close();

        $st = $mysqli->prepare(
            'update items
             set next_test = now() + interval ? minute
             where id = ?');
        dbFailsafe($mysqli);
        $period = CFG_ITEM_QUESTIONS_PERIOD;
        $st->bind_param('ii', $period, $item['item_id']);
        $st->execute();
        $st->close();
    }

    $st = $mysqli->prepare(
        'insert into tests(completed)
         values(now())');
    dbFailsafe($mysqli);
    $st->execute();
    $st->close();
}

$mysqli = dbConnect();

if (isset($_POST['data'])) {
    saveResult($_POST['data']);
}

dbClose($mysqli);

header('Content-Type: application/json');
echo json_encode(array());
?>
