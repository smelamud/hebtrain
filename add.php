<!DOCTYPE html>
<?php
require_once('parts/header.php');
?>
<html>
    <head>
        <title>Иврит - Добавить</title>
        <link rel="stylesheet" type="text/css" href="/css/common.css"/>
        <link rel="stylesheet" type="text/css" href="/css/add.css"/>
        <script type="text/javascript"
                src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <script type="text/javascript" src="/js/add.js"></script>
    </head>
    <body>
        <?php displayMainMenu('add'); ?>
        <form id="addform">
            <table id="adder">
                <tr>
                    <td class='spinner'><img src="/pics/ajax.gif"></td>
                    <td class='hebrew'><input type="text" name="hebrew" maxlength="63"/></td>
                    <td class='hebrew-comment'>&nbsp;</td>
                    <td class='russian'><input type="text" name="russian" maxlength="63"/></td>
                    <td class='russian-comment'>&nbsp;</td>
                    <td><button id="add">Добавить</button></td>
                </tr>
                <tr class="template">
                    <td class='spinner'>&nbsp;</td>
                    <td class='hebrew'>&nbsp;</td>
                    <td class='hebrew-comment'>&nbsp;</td>
                    <td class='russian'>&nbsp;</td>
                    <td class='russian-comment'>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </form>
    </body>
</html>
