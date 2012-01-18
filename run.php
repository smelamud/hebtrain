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
            <div id="start">
                <span id="loading">Загрузка теста</span>
                <span id="loaded">Тест готов</span>
                <p id="buttons-start">
                    <button id="button-start">Начать тест</button>
                </p>
            </div>
            <div id="run">
                <span id="question-title-1" class="question-title-hide">
                    Переведите на русский язык
                </span>
                <span id="question-title-2" class="question-title-hide">
                    Переведите на русский язык
                </span>
                <span id="question-title-3" class="question-title-hide">
                    Переведите на иврит
                </span>
                <span id="question-title-4" class="question-title-hide">
                    Напишите на иврите без огласовок
                </span>
                <span id="question-title-5" class="question-title-hide">
                    Напишите на иврите с огласовками
                </span>
                <p>
                    <span id="question-word">&nbsp;</span>
                    &#x200e;<span id="question-comment">&nbsp;</span>
                </p>
                <p id="buttons-answer">
                    <button id="button-answer">Ответ</button>
                </p>
            </div>
        </div>
    </body>
</html>
