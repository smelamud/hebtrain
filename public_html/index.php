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
            </div>
            <div id="questions">
                <strong>По вопросам:</strong>
                <table>
                    <tr>
                        <th class="span4">&nbsp;</th>
                        <th class="span1">&nbsp;</th>
                        <th class="span1">Всего</th>
                        <th class="span1">Сейчас</th>
                        <th class="span9">&nbsp;</th>
                    </tr>
                    <tr class="template">
                        <td class="title span4">&nbsp;</td>
                        <td class="span1">&nbsp;</td>
                        <td class="total span1">&nbsp;</td>
                        <td class="now span1">&nbsp;</td>
                        <td class="span9">&nbsp;</td>
                    </tr>
                    <tr>
                        <th class="span4">Все вопросы</td>
                        <td class="span1">&nbsp;</td>
                        <td id="questions-total" class="span1">&nbsp;</td>
                        <td id="questions-now" class="span1">&nbsp;</td>
                        <td class="span9">&nbsp;</td>
                    </tr>
                </table>
            </div>
            <div id="stages">
                <strong>По этапам:</strong>
                <table>
                    <tr class="template">
                        <td class="name span1">&nbsp;</td>
                        <td class="span1">&nbsp;</td>
                        <td class="count0 span1">&nbsp;</td>
                        <td class="count1 span1">&nbsp;</td>
                        <td class="count2 span1">&nbsp;</td>
                        <td class="count3 span1">&nbsp;</td>
                        <td class="span10">&nbsp;</td>
                    </tr>
                </table>
            </div>
        </div></div>
    </body>
</html>
