<?php
require_once('lib/database.php');
require_once('lib/items.php');

function insertItem() {
    global $mysqli, $itemId;

    $st = $mysqli->prepare(
        'insert into items(`group`, hebrew, russian)
         values(?, ?, ?)');
    dbFailsafe($mysqli);
    $group = VI_WORD;
    $st->bind_param('iss', $group, $_POST['hebrew'], $_POST['russian']);
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

    $itemId = $_POST['id'];

    $st = $mysqli->prepare(
        'update items
         set hebrew = ?, russian = ?
         where id = ?');
    dbFailsafe($mysqli);
    $st->bind_param('ssi', $_POST['hebrew'], $_POST['russian'], $itemId);
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
    'hebrew' => $_POST['hebrew'],
    'russian' => $_POST['russian']
);

header('Content-Type: application/json');
echo json_encode($result);
?>
