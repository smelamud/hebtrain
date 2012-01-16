<?php
function postVar($name) {
    return isset($_POST[$name]) ? $_POST[$name] : '';
}

function postIntVar($name) {
    return isset($_POST[$name]) ? (int)$_POST[$name] : 0;
}

function getVar($name) {
    return isset($_GET[$name]) ? $_GET[$name] : '';
}

function getIntVar($name) {
    return isset($_GET[$name]) ? (int)$_GET[$name] : 0;
}
?>
