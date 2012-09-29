<!DOCTYPE html>
<?php
require_once('parts/header.php');
require_once('parts/keyboard.php');
?>
<html>
    <head>
        <title>Иврит - Тест</title>
        <?php displayPreamble('run', true, array('button')); ?>
    </head>
    <body class="mobile">
        <img id="spinner" src="/pics/ajax.gif"><br/>
        <div id="start">
            <div class="message">
                <span id="loading">Загрузка теста</span>
                <span id="loaded">Тест готов</span>
            </div>
            <div id="buttons-start" class="buttons">
                <button id="button-start" class="btn btn-large btn-primary">Начать тест</button>
                &nbsp;
                <a class="btn btn-large" href="/mobile/index.php">Статистика</a>
            </div>
        </div>
        <div id="underflow" class="alert alert-block alert-info">
            <strong class="alert-heading">Недостаточно вопросов для теста.</strong><br/>
            Ваши успехи в изучении иврита несомненны. Предлагаю пополнить словарь новыми словами.
        </div>
        <div id="run">
            <div class="message">
                <span id="question-title-1" class="question-title-hide">
                    Расшифруйте <i>аббревиатуру</i>
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
                    Переведите на иврит <i>аббревиатурой</i>
                </span>
            </div>
            <div class="word">
                <span id="question-word">&nbsp;</span>
                &#x200e;<span id="question-comment">&nbsp;</span>
            </div>
            <div class="word">
                <input id="answer-input" type="text" class="keyboard-enabled"/>
                <span id="answer-input-text"></span>
            </div>
            <div id="buttons-answer" class="buttons">
                <button id="button-answer" class="btn btn-large btn-primary">Ответ</button>
            </div>
            <div id="answer" class="word"></div>
            <div id="buttons-correct" class="buttons">
                <button id="button-incorrect" class="btn btn-large btn-danger">Неверно</button>
                <button id="button-correct" class="btn btn-large btn-success">Верно</button>
            </div>
        </div>
        <div id="intermezzo" class="message">
            <span id="loop-number">&nbsp;</span>-й проход
        </div>
        <div id="stop">
            <div class="message">
                <span id="finished">Тест завершен</span>
            </div>
            <div id="buttons-stop" class="buttons">
                <button id="button-save" class="btn btn-large btn-primary">Записать результаты</button>
            </div>
        </div>
        <div id="restart">
            <div class="message">
                <span id="saved">Результаты теста сохранены</span>
            </div>
            <div id="buttons-restart" class="buttons">
                <button id="button-restart" class="btn btn-large btn-primary">Загрузить новый тест</button>
                &nbsp;
                <a class="btn btn-large" href="/mobile/index.php">Статистика</a>
            </div>
        </div>
    </body>
</html>
