<!DOCTYPE html>
<?php
require_once('parts/header.php');
?>
<html>
    <head>
        <title>Иврит - Добавить</title>
        <link rel="stylesheet" type="text/css" href="/css/common.css"/>
        <link rel="stylesheet" type="text/css" href="/css/add.css"/>
    </head>
    <body>
        <?php displayMainMenu('add'); ?>
        <form>
            <table id="adder">
                <tr>
                    <td class='spinner'>&nbsp;</td>
                    <td class='hebrew'><input type="text" maxlength="63"/></td>
                    <td class='hebrew-comment'>&nbsp;</td>
                    <td class='russian'><input type="text" maxlength="63"/></td>
                    <td class='russian-comment'>&nbsp;</td>
                    <td><button>Добавить</button></td>
                </tr>
            </table>
        </form>
    </body>
</html>
