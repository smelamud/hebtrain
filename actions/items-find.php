<?php
require_once('lib/database.php');
require_once('lib/items.php');

function findItems($keyword) {
    global $mysqli;

    $result = array(
        'count' => 0,
        'items' => array()
    );

    $st = $mysqli->prepare(
        'select count(*)
         from items
         where `group` = ?');
    dbFailsafe($mysqli);
    $group = VI_WORD;
    $st->bind_param('i', $group);
    $st->execute();
    $st->bind_result($result['count']);
    $st->fetch();
    $st->close();

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
    while ($st->fetch()) {
        array_push(
            $result['items'],
            array('id' => $id,
                  'hebrew' => $hebrew,
                  'hebrew_comment' => $hebrew_comment,
                  'russian' => $russian,
                  'russian_comment' => $russian_comment));
    }
    $st->close();

    return $result;
}

$mysqli = dbConnect();

$result = findItems($_POST['q']);

dbClose($mysqli);

header('Content-Type: application/json');
echo json_encode($result);
?>
