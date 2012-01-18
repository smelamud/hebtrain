<!DOCTYPE html>
<?php
require_once('parts/header.php');
?>
<html>
    <head>
        <title>Иврит - Тест</title>
        <link rel="stylesheet" type="text/css" href="/css/common.css"/>
        <link rel="stylesheet" type="text/css" href="/css/run.css"/>
        <script type="text/javascript"
                src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <script type="text/javascript" src="/js/run.js"></script>
    </head>
    <body>
        <?php displayMainMenu('run'); ?>
        <div id="main">
            <img id="spinner" src="/pics/ajax.gif"><br/>
            <span id="loading">Загрузка теста</span>
            <span id="loaded">Тест готов</span>
            <p id="buttons-start">
                <button id="button-start">Начать тест</button>
            </p>
        </div>
    </body>
</html>
