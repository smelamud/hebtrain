<?php
require_once('lib/database.php');

function modifyComments($id, $hebrewComment, $russianComment) {
    global $mysqli;

    $st = $mysqli->prepare(
        'update items
         set hebrew_comment = ?, russian_comment = ?
         where id = ?');

    $result = array();

    for ($i = 0; $i < count($id); $i++) {
        if (isset($hebrewComment[$i]) && isset($russianComment[$i])) {
            $st->bind_param('ssi', $hebrewComment[$i], $russianComment[$i],
                $id[$i]);
            $st->execute();

            array_push(
                $result,
                array(
                    'hebrew_comment' => $hebrewComment[$i],
                    'russian_comment' => $russianComment[$i],
                    'id' => $id[$i]));
        } else {
            break;
        }
    }

    $st->close();

    return $result;
}

$mysqli = dbConnect();

$result = modifyComments($_POST['id'], $_POST['hebrew_comment'],
    $_POST['russian_comment']);

dbClose($mysqli);

header('Content-Type: application/json');
echo json_encode($result);
?>
