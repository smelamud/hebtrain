<?php
function dbConnect() {
    $mysqli = new mysqli('localhost', 'root', 'mu8dhrse', 'hebtrain');
    if ($mysqli->connect_error) {
        header('HTTP/1.0 500');
        die('Connect Error (' . $mysqli->connect_errno . ') '
                . $mysqli->connect_error);
    }

    $mysqli->query("set names 'utf8'");

    return $mysqli;
}

function dbClose($mysqli) {
    $mysqli->close();
}

function dbFailsafe($mysqli) {
    if ($mysqli->errno != 0) {
        header('HTTP/1.0 500');
        die('MySQL Error (' . $mysqli->errno . ') ' . $mysqli->error);
    }
}
?>
