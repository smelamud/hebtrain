<!DOCTYPE html>
<?php
require_once('parts/header.php');
require_once('parts/keyboard.php');
?>
<html>
    <head>
        <title>Иврит - Тест</title>
        <?php displayPreamble('run', array('buttons')); ?>
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
                <div id="underflow" class="alert-message block-message info">
                    <strong>Недостаточно вопросов для теста.</strong><br/>
                    Ваши успехи в изучении иврита несомненны. Предлагаю пополнить словарь новыми словами.
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
                    </div>
                    <div class="word">
                        <span id="question-word">&nbsp;</span>
                        &#x200e;<span id="question-comment">&nbsp;</span>
                    </div>
                    <div class="word">
                        <input id="answer-input" type="text" class="keyboard-enabled" data-keyboard-positioning="right"/>
                        <span id="answer-input-text"></span>
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
                <div id="intermezzo" class="message">
                    <span id="loop-number">&nbsp;</span>-й проход
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
                <?php displayKeyboard(); ?>
            </div>
        </div>
    </body>
</html>
