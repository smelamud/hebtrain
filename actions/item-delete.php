<?php
require_once('lib/database.php');
require_once('lib/items.php');

$mysqli = dbConnect();

$st = $mysqli->prepare(
    'delete from items
     where id = ?');
dbFailsafe($mysqli);
$st->bind_param('i', $_POST['id']);
$st->execute();
$st->close();

$st = $mysqli->prepare(
    'delete from questions
     where item_id = ?');
dbFailsafe($mysqli);
$st->bind_param('i', $_POST['id']);
$st->execute();
$st->close();

dbClose($mysqli);

$result = array(
    'id' => postIntVar('id')
);

header('Content-Type: application/json');
echo json_encode($result);
?>
