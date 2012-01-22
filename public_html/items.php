<!DOCTYPE html>
<?php
require_once('parts/header.php');
?>
<html>
    <head>
        <title>Иврит - Слова</title>
        <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css"/>
        <link rel="stylesheet" type="text/css" href="/css/common.css"/>
        <link rel="stylesheet" type="text/css" href="/css/items.css"/>
        <link rel="stylesheet" type="text/css"
              href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.17/themes/redmond/jquery-ui.css"/>
        <script type="text/javascript"
                src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <script type="text/javascript"
                src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
        <script type="text/javascript" src="/js/items.js"></script>
    </head>
    <body>
        <?php displayMainMenu('items'); ?>
        <div class="container"><div class="content">
            <table id="found" class="items condensed-table">
                <tr class="headline">
                    <th>&nbsp;</th>
                    <th colspan="2" class="russian">Русский</th>
                    <th>&nbsp;</th>
                    <th colspan="2" class="hebrew">עברית</th>
                    <th>&nbsp;</th>
                </tr>
                <form id="items-form">
                    <tr id="editor">
                        <td>
                            <img id="spinner" src="/pics/ajax-cyan.gif">
                            <input type="hidden" name="id" value="0">
                        </td>
                        <td class="russian" colspan="2"><input type="text" name="russian" maxlength="63" autofocus/></td>
                        <td class="separator">&mdash;</td>
                        <td class="hebrew" colspan="2"><input type="text" name="hebrew" maxlength="63"/></td>
                        <td>
                            <button id="add" class="btn primary">Добавить</button>
                            <button id="modify" class="btn primary">Изменить</button>
                            <button type="button" id="delete" class="btn">Удалить</button>
                            <button type="reset" id="reset" class="btn">Сброс</button>
                        </td>
                    </tr>
                </form>
                <tr class="headline">
                    <td colspan="3">
                        <span id="found-title"><span id="found-loaded">0</span> из <span id="found-total">0</span></span>
                        <span id="added-title">Добавлено: <span id="added-total">0</span></span>
                    </td>
                    <td colspan="3" id="search">
                        <form id="search-form">
                            <input type="text" name="q" maxlength="63"/>
                        </form>
                    </td>
                    <td>&nbsp;</td>
                </tr>
                <tr class="template">
                    <td>&nbsp;</td>
                    <td class="russian">&nbsp;</td>
                    <td class="russian-comment">&nbsp;</td>
                    <td class="separator">&mdash;</td>
                    <td class="hebrew-comment">&nbsp;</td>
                    <td class="hebrew">&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr id="continue">
                    <td>
                        <img id="spinner-continue" src="/pics/ajax.gif">
                    </td>
                    <td colspan="5">&#x25be; Больше &#x25be;</td>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </div></div>

        <div id="similar-dialog" title="Похожие слова">
            <table id="similar" class="items">
                <tr class="headline">
                    <th colspan="2" class="russian">Русский</th>
                    <th><img id="spinner-similar" src="/pics/ajax.gif"></th>
                    <th colspan="2" class="hebrew">עברית</th>
                </tr>
                <form id="similar-form">
                    <tr class="template">
                        <input type="hidden" form="similar-form" name="id[]"/>
                        <td class="russian">&nbsp;</td>
                        <td class="russian-comment">
                            <input type="text" form="similar-form"
                                   name="russian_comment[]" maxlength="63"/>
                        </td>
                        <td class="separator">&mdash;</td>
                        <td class="hebrew-comment">
                            <input type="text" form="similar-form"
                                   name="hebrew_comment[]" maxlength="63"/>
                        </td>
                        <td class="hebrew">&nbsp;</td>
                    </tr>
                </form>
            </table>
        </div>
    </body>
</html>
