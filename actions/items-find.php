<?php
require_once('lib/database.php');
require_once('lib/items.php');

function findItems($keyword) {
    global $mysqli;

    $st = $mysqli->prepare(
        'select id, hebrew, hebrew_comment, russian, russian_comment
         from items
         where `group` = ?
         order by hebrew_bare');
    dbFailsafe($mysqli);
    $group = VI_WORD;
    $st->bind_param('i', $group);
    $st->execute();

    $st->bind_result($id, $hebrew, $hebrew_comment, $russian, $russian_comment);
    $result = array();
    while ($st->fetch()) {
        array_push(
            $result,
            array('id' => $id,
                  'hebrew' => $hebrew,
                  'hebrew_comment' => $hebrew_comment,
                  'russian' => $russian,
                  'russian_comment' => $russian_comment));
    }

    return $result;
}

$mysqli = dbConnect();

$result = findItems($_POST['q']);

dbClose($mysqli);

header('Content-Type: application/json');
echo json_encode($result);
?>
