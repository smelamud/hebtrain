<?php
require_once('lib/post.php');
require_once('lib/database.php');
require_once('lib/items.php');
require_once('lib/questions.php');
require_once('lib/hebrew.php');

function insertItem(&$item) {
    global $mysqli, $VI_VARIANTS;

    $st = $mysqli->prepare(
        'insert into items(`group`, hebrew, hebrew_bare, russian, next_test)
         values(?, ?, ?, ?, now())');
    dbFailsafe($mysqli);
    $group = VI_WORD;
    $item['hebrew_bare'] = bareHebrew($item['hebrew']);
    $st->bind_param('isss', $group, $item['hebrew'], $item['hebrew_bare'],
        $item['russian']);
    $st->execute();
    $item['id'] = $st->insert_id;
    $st->close();

    $st = $mysqli->prepare(
        'insert into questions(item_id, question, next_test)
         values(?, ?, now())');
    dbFailsafe($mysqli);
    foreach($VI_VARIANTS[VI_WORD] as $variant) {
        $st->bind_param('ii', $item['id'], $variant);
        $st->execute();
    }
    $st->close();
}

function modifyItem(&$item) {
    global $mysqli;

    $st = $mysqli->prepare(
        'update items
         set hebrew = ?, hebrew_bare = ?, russian = ?
         where id = ?');
    dbFailsafe($mysqli);
    $item['hebrew_bare'] = bareHebrew($item['hebrew']);
    $st->bind_param('sssi', $item['hebrew'], $item['hebrew_bare'],
        $item['russian'], $item['id']);
    $st->execute();
    $st->close();
}

function getSimilarItems(&$item) {
    global $mysqli;

    $st = $mysqli->prepare(
        'select id, hebrew, hebrew_comment, russian, russian_comment
         from items
         where `group` = ? and (russian = ? or hebrew_bare = ?)
         order by hebrew_bare');
    dbFailsafe($mysqli);
    $group = VI_WORD;
    $st->bind_param('iss', $group, $item['russian'], $item['hebrew_bare']);
    $st->execute();

    $st->bind_result($id, $hebrew, $hebrew_comment, $russian, $russian_comment);
    $similar = array();
    while ($st->fetch()) {
        if ($id != $item['id']) {
            array_push(
                $similar,
                array('id' => $id,
                      'hebrew' => $hebrew,
                      'hebrew_comment' => $hebrew_comment,
                      'russian' => $russian,
                      'russian_comment' => $russian_comment));
        } else {
            $item['hebrew'] = $hebrew;
            $item['hebrew_comment'] = $hebrew_comment;
            $item['russian'] = $russian;
            $item['russian_comment'] = $russian_comment;
        }
    }

    $st->close();

    return $similar;
}

$item = array(
    'id' => postIntVar('id'),
    'hebrew' => postVar('hebrew'),
    'russian' => postVar('russian')
);

$mysqli = dbConnect();

if (empty($item['id'])) {
    insertItem($item);
} else {
    modifyItem($item);
}

$item['similar'] = getSimilarItems($item);

dbClose($mysqli);

header('Content-Type: application/json');
echo json_encode($item);
?>
