<!DOCTYPE html>
<?php
require_once('parts/header.php');
?>
<html>
    <head>
        <title>Иврит - Слова</title>
        <link rel="stylesheet" type="text/css" href="/css/common.css"/>
        <link rel="stylesheet" type="text/css" href="/css/items.css"/>
        <script type="text/javascript"
                src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <script type="text/javascript" src="/js/items.js"></script>
    </head>
    <body>
        <?php displayMainMenu('items'); ?>
        <form id="items-form">
            <table id="items">
                <tr class="headline">
                    <th>&nbsp;</th>
                    <th colspan="2" class="russian">Русский</th>
                    <th>&nbsp;</th>
                    <th colspan="2" class="hebrew">עברית</th>
                </tr>
                <tr id="editor">
                    <td>
                        <img id="spinner" src="/pics/ajax-cyan.gif">
                        <input type="hidden" name="id" value="0">
                    </td>
                    <td class="russian" colspan="2"><input type="text" name="russian" maxlength="63" autofocus/></td>
                    <td class="separator">&mdash;</td>
                    <td class="hebrew" colspan="2"><input type="text" name="hebrew" maxlength="63"/></td>
                    <td>
                        <button id="add">Добавить</button>
                        <button id="modify">Изменить</button>
                        <button type="button" id="delete">Удалить</button>
                        <button type="reset" id="reset">Сброс</button>
                    </td>
                </tr>
                <tr class="headline">
                    <td colspan="3">
                        <span id="found-title"><span id="found-loaded">0</span> из <span id="found-total">0</span></span>
                        <span id="added-title">Добавлено: <span id="added-total">0</span></span>
                    </td>
                    <td colspan="3">&nbsp;</td>
                </tr>
                <tr class="template item">
                    <td>&nbsp;</td>
                    <td class="russian">&nbsp;</td>
                    <td class="russian-comment">&nbsp;</td>
                    <td class="separator">&mdash;</td>
                    <td class="hebrew-comment">&nbsp;</td>
                    <td class="hebrew">&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </form>
    </body>
</html>
