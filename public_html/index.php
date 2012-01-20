<!DOCTYPE html>
<?php
require_once('parts/header.php');
?>
<html>
    <head>
        <title>Иврит</title>
        <link rel="stylesheet" type="text/css" href="/css/common.css"/>
        <link rel="stylesheet" type="text/css" href="/css/index.css"/>
        <script type="text/javascript"
                src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <script type="text/javascript" src="/js/index.js"></script>
    </head>
    <body>
        <?php displayMainMenu('index'); ?>
        <img id="spinner" src="/pics/ajax.gif"><br/>
        <strong>Всего слов в словаре:</strong> <span id="words-total">0</span><br/>
        <strong>Всего вопросов:</strong> <span id="questions-total">0</span>,
        <strong>требуют ответа сейчас</strong>:  <span id="questions-now">0</span>
        <p>
        <strong>По этапам:</strong>
        <table id="stages">
            <tr class="template">
                <td class="name">&nbsp;</td>
                <td>&mdash;</td>
                <td class="count">&nbsp;</td>
            </tr>
        </table>
    </body>
</html>
