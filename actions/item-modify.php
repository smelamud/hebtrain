<?php
require_once('lib/post.php');
require_once('lib/database.php');
require_once('lib/items.php');
require_once('lib/questions.php');

function insertItem() {
    global $mysqli, $itemId, $VI_VARIANTS;

    $st = $mysqli->prepare(
        'insert into items(`group`, hebrew, hebrew_bare, russian)
         values(?, ?, ?, ?)');
    dbFailsafe($mysqli);
    $group = VI_WORD;
    $hebrewBare = bareHebrew(postVar('hebrew'));
    $st->bind_param('isss', $group, $_POST['hebrew'], $hebrewBare,
        $_POST['russian']);
    $st->execute();
    $itemId = $st->insert_id;
    $st->close();

    $st = $mysqli->prepare(
        'insert into questions(item_id, question, next_test)
         values(?, ?, now())');
    dbFailsafe($mysqli);
    foreach($VI_VARIANTS[VI_WORD] as $variant) {
        $st->bind_param('ii', $itemId, $variant);
        $st->execute();
    }
    $st->close();
}

function modifyItem() {
    global $mysqli, $itemId;

    $itemId = postIntVar('id');

    $st = $mysqli->prepare(
        'update items
         set hebrew = ?, hebrew_bare = ?, russian = ?
         where id = ?');
    dbFailsafe($mysqli);
    $hebrewBare = bareHebrew(postVar('hebrew'));
    $st->bind_param('sssi', $_POST['hebrew'], $hebrewBare, $_POST['russian'],
        $itemId);
    $st->execute();
    $st->close();
}

$mysqli = dbConnect();

if (empty($_POST['id'])) {
    insertItem();
} else {
    modifyItem();
}

dbClose($mysqli);

$result = array(
    'id' => $itemId,
    'hebrew' => postVar('hebrew'),
    'russian' => postVar('russian')
);

header('Content-Type: application/json');
echo json_encode($result);
?>
