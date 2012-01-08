<?php
function dbConnect() {
    $mysqli = new mysqli('localhost', 'root', 'mu8dhrse', 'hebtrain');
    if ($mysqli->connect_error) {
        header('HTTP/1.0 500');
        error_log('Connect Error (' . $mysqli->connect_errno . ') '
                . $mysqli->connect_error);
        die();
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
        error_log('MySQL Error (' . $mysqli->errno . ') ' . $mysqli->error);
        die();
    }
}
?>
