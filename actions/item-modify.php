<?php
require_once('lib/database.php');

$mysqli = dbConnect();

$st = $mysqli->prepare('insert into items(hebrew, russian) values(?, ?)');
dbFailsafe($mysqli);
$st->bind_param('ss', $_POST['hebrew'], $_POST['russian']);
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
