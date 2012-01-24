<!DOCTYPE html>
<?php
require_once('parts/header.php');
?>
<html>
    <head>
        <title>Иврит - Тест</title>
        <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css"/>
        <link rel="stylesheet" type="text/css" href="/css/common.css"/>
        <link rel="stylesheet" type="text/css" href="/css/run.css"/>
        <script type="text/javascript"
                src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <script type="text/javascript" src="/js/run.js"></script>
    </head>
    <body>
        <?php displayMainMenu('run'); ?>
        <div class="container">
            <div id="main" class="content">
                <img id="spinner" src="/pics/ajax.gif"><br/>
                <div id="start">
                    <div class="message">
                        <span id="loading">Загрузка теста</span>
                        <span id="loaded">Тест готов</span>
                    </div>
                    <div id="buttons-start" class="buttons">
                        <button id="button-start" class="btn primary">Начать тест</button>
                    </div>
                </div>
                <div id="run">
                    <div class="message">
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
                    </div>
                    <div class="word">
                        <span id="question-word">&nbsp;</span>
                        &#x200e;<span id="question-comment">&nbsp;</span>
                    </div>
                    <div id="buttons-answer" class="buttons">
                        <button id="button-answer" class="btn primary">Ответ</button>
                    </div>
                    <div id="answer" class="word"></div>
                    <div id="buttons-correct" class="buttons">
                        <button id="button-incorrect" class="btn large danger">Неверно</button>
                        <button id="button-correct" class="btn large success">Верно</button>
                    </div>
                </div>
                <div id="stop">
                    <div class="message">
                        <span id="finished">Тест завершен</span>
                    </div>
                    <div id="buttons-stop" class="buttons">
                        <button id="button-save" class="btn primary">Записать результаты</button>
                    </div>
                </div>
                <div id="restart">
                    <div class="message">
                        <span id="saved">Результаты теста сохранены</span>
                    </div>
                    <div id="buttons-restart" class="buttons">
                        <button id="button-restart" class="btn primary">Загрузить новый тест</button>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
