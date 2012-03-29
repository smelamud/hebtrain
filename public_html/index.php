<!DOCTYPE html>
<?php
require_once('parts/header.php');
?>
<html>
    <head>
        <title>Иврит</title>
        <?php displayPreamble('index'); ?>
    </head>
    <body>
        <?php displayMainMenu('index'); ?>
        <div class="container"><div class="content">
            <div id="totals">
                <img id="spinner" src="/pics/ajax.gif"><br/>
                <strong>Всего слов в словаре:</strong> <span id="words-total">0</span><br/>
                <strong>Вопросов в день:</strong> <span id="questions-day">0</span><br/>
                <strong>Тестов в день:</strong> <span id="tests-day">0</span><br/>
            </div>
            <div id="questions">
                <strong>По вопросам:</strong>
                <table class="table">
                    <tr>
                        <th class="span3">&nbsp;</th>
                        <th class="span1">Всего</th>
                        <th class="span1">Сейчас</th>
                        <th class="span7">&nbsp;</th>
                    </tr>
                    <tr class="template">
                        <td class="title span3">&nbsp;</td>
                        <td class="total span1">0</td>
                        <td class="now span1">0</td>
                        <td class="span7">&nbsp;</td>
                    </tr>
                    <tr>
                        <th class="span3">Все вопросы</td>
                        <td id="questions-total" class="span1">&nbsp;</td>
                        <td id="questions-now" class="span1">&nbsp;</td>
                        <td class="span7">&nbsp;</td>
                    </tr>
                </table>
            </div>
            <div id="stages">
                <strong>По этапам:</strong>
                <table class="table">
                    <tr>
                        <th class="span2">&nbsp;</th>
                        <th class="span1">Сейчас</th>
                        <th class="count0 span1">0</td>
                        <th class="count1 span1">1</td>
                        <th class="count2 span1">2</td>
                        <th class="span6" colspan="2">&nbsp;</th>
                    </tr>
                    <tr class="template">
                        <td class="name span2">&nbsp;</td>
                        <td class="count-ready span1">0</td>
                        <td class="count0 span1">&nbsp;</td>
                        <td class="count1 span1">&nbsp;</td>
                        <td class="count2 span1">&nbsp;</td>
                        <td class="count3 span1">&nbsp;</td>
                        <td class="span5">&nbsp;</td>
                    </tr>
                </table>
            </div>
        </div></div>
    </body>
</html>
