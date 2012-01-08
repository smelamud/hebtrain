<?php
require_once('lib/database.php');
require_once('lib/items.php');

$mysqli = dbConnect();

$st = $mysqli->prepare(
    'insert into items(`group`, hebrew, russian) 
     values(?, ?, ?)');
dbFailsafe($mysqli);
$group = VI_WORD;
$st->bind_param('iss', $group, $_POST['hebrew'], $_POST['russian']);
$st->execute();
$st->close();

dbClose($mysqli);

$result = array(
    'hebrew' => $_POST['hebrew'],
    'russian' => $_POST['russian']
);

header('Content-Type: application/json');
echo json_encode($result);
?>
