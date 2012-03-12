<?php
require_once('lib/post.php');
require_once('lib/database.php');
require_once('lib/items.php');
require_once('lib/questions.php');
require_once('lib/hebrew.php');
require_once('lib/stages.php');

function insertItem(&$item) {
    global $mysqli;

    $st = $mysqli->prepare(
        'insert into items(`group`, hebrew, hebrew_bare, hebrew_comment,
                           russian, russian_comment, next_test)
         values(?, ?, ?, ?, ?, ?, now())');
    dbFailsafe($mysqli);
    $group = VI_WORD;
    $item['hebrew_bare'] = bareHebrew($item['hebrew']);
    $st->bind_param('isssss', $group, $item['hebrew'], $item['hebrew_bare'],
        $item['hebrew_comment'], $item['russian'], $item['russian_comment']);
    $st->execute();
    $item['id'] = $st->insert_id;
    $st->close();

    $st = $mysqli->prepare(
        'insert into questions(item_id, question, stage, next_test, active)
         values(?, ?, ?, now() + interval ? day, 1)');
    dbFailsafe($mysqli);
    for($variant = QV_WORD_MIN; $variant <= QV_WORD_MAX; $variant++) {
        if (!$item['familiar']) {
            $stage = LS_1_DAY;
            $delay = 0;
        } else {
            $stage = LS_2_WEEKS;
            $delay = rand(0, 13);
        }
        $st->bind_param('iiii', $item['id'], $variant, $stage, $delay);
        $st->execute();
    }
    $st->close();
}

function modifyItem(&$item) {
    global $mysqli;

    $st = $mysqli->prepare(
        'update items
         set hebrew = ?, hebrew_bare = ?, hebrew_comment = ?, russian = ?,
             russian_comment = ?
         where id = ?');
    dbFailsafe($mysqli);
    $item['hebrew_bare'] = bareHebrew($item['hebrew']);
    $st->bind_param('sssssi', $item['hebrew'], $item['hebrew_bare'],
        $item['hebrew_comment'], $item['russian'], $item['russian_comment'],
        $item['id']);
    $st->execute();
    $st->close();
}

function getSimilarItems(&$item) {
    global $mysqli;

    $st = $mysqli->prepare(
        'select id, hebrew, hebrew_comment, russian, russian_comment
         from items
         where russian = ? or hebrew_bare = ?
         order by hebrew_bare');
    dbFailsafe($mysqli);
    $st->bind_param('ss', $item['russian'], $item['hebrew_bare']);
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
    'hebrew_comment' => postVar('hebrew_comment'),
    'russian' => postVar('russian'),
    'russian_comment' => postVar('russian_comment'),
    'familiar' => postBoolVar('familiar')
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
