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
                <strong>Всего вопросов:</strong> <span id="questions-total">0</span>,
                <strong>требуют ответа сейчас</strong>:  <span id="questions-now">0</span>
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
