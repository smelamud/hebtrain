<!DOCTYPE html>
<?php
require_once('parts/header.php');
?>
<html>
    <head>
        <title>Иврит</title>
        <?php displayPreamble('index'); ?>
    </head>
    <body class="mobile">
        <div id="totals">
            <a class="btn btn-large btn-primary" href="/mobile/run.php?qv=<?= QV_WORD_MIX ?>">Начать тест</a><br/>
            <img id="spinner" src="/pics/ajax.gif"><br/>
            <strong>Всего слов в словаре:</strong>
            <span id="words-total">0</span>
            (активных: <span id="words-active">0</span>)<br/>
            <strong>Всего вопросов:</strong>&nbsp;
            <span id="questions-total">&nbsp;</span>, сейчас -
            <span class="questions-now">0</span>
            (<span id="items-now">0</span> слов
             = <span id="tests-now">0</span> тестов)<br/>
            <strong>Вопросов в день:</strong>
            <span id="questions-day">0</span>
            = <span id="tests-day">0</span> тестов<br/>
            <strong>Сегодня закончено тестов:</strong>
            <span id="tests-done-today">0</span>
        </div>
    </body>
</html>
