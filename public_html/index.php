<!DOCTYPE html>
<?php
require_once('parts/header.php');
?>
<html>
    <head>
        <title>Иврит</title>
        <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css"/>
        <link rel="stylesheet" type="text/css" href="/css/common.css"/>
        <link rel="stylesheet" type="text/css" href="/css/index.css"/>
        <script type="text/javascript"
                src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <script type="text/javascript" src="/js/index.js"></script>
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
                        <td class="count span1">&nbsp;</td>
                        <td class="span13">&nbsp;</td>
                    </tr>
                </table>
            </div>
        </div></div>
    </body>
</html>
