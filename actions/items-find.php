<?php
require_once('lib/post.php');
require_once('lib/database.php');
require_once('lib/items.php');

function findItems($keyword, $offset) {
    global $mysqli;

    $result = array(
        'offset' => $offset,
        'count' => 0,
        'total' => 0,
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
    $st->bind_result($result['total']);
    $st->fetch();
    $st->close();

    $st = $mysqli->prepare(
        'select id, hebrew, hebrew_comment, russian, russian_comment
         from items
         where `group` = ?
         order by hebrew_bare
         limit ?, ?');
    dbFailsafe($mysqli);
    $group = VI_WORD;
    $limit = 10;
    $st->bind_param('iii', $group, $offset, $limit);
    $st->execute();

    $st->store_result();
    $result['count'] = $st->num_rows;

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

$result = findItems(getVar('q'), getIntVar('offset'));

dbClose($mysqli);

header('Content-Type: application/json');
echo json_encode($result);
?>
