<!DOCTYPE html>
<?php
require_once('parts/header.php');
require_once('parts/keyboard.php');
?>
<html>
    <head>
        <title>Иврит - Слова</title>
        <?php displayPreamble('items', array('modal')); ?>
    </head>
    <body>
        <?php displayMainMenu('items'); ?>
        <div class="container"><div class="content">
            <table class="condensed-table">
                <thead>
                    <tr>
                        <th>&nbsp;</th>
                        <th class="russian">Русский</th>
                        <th>&nbsp;</th>
                        <th class="hebrew">עברית</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <form id="items-form">
                        <tr id="editor">
                            <td>
                                <img id="spinner" src="/pics/ajax-cyan.gif">
                                <input type="hidden" name="id" value="0">
                            </td>
                            <td class="russian span8"><input type="text" name="russian" maxlength="63" autofocus/></td>
                            <td class="separator">&mdash;</td>
                            <td class="hebrew span8"><input type="text" class="keyboard-enabled" name="hebrew" maxlength="63"/></td>
                            <td class="span7">
                                <button id="add" class="btn primary">Добавить</button>
                                <button id="modify" class="btn primary">Изменить</button>
                                <button type="button" id="delete" class="btn">Удалить</button>
                                <button type="reset" id="reset" class="btn">Сброс</button>
                            </td>
                        </tr>
                    </form>
                </tbody>
            </table>

            <table id="found" class="items condensed-table">
                <thead>
                    <tr>
                        <th colspan="3">
                            <span id="found-title"><span id="found-loaded">0</span> из <span id="found-total">0</span></span>
                            <span id="added-title">Добавлено: <span id="added-total">0</span></span>
                        </th>
                        <th colspan="3" id="search">
                            <form id="search-form">
                                <input type="text" name="q" maxlength="63"/>
                            </form>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="template">
                        <td class="spinner-space">&nbsp;</td>
                        <td class="russian span6">&nbsp;</td>
                        <td class="russian-comment span6">&nbsp;</td>
                        <td class="separator">&mdash;</td>
                        <td class="hebrew-comment span6">&nbsp;</td>
                        <td class="hebrew span6">&nbsp;</td>
                    </tr>
                    <tr id="continue">
                        <td class="spinner-space">
                            <img id="spinner-continue" src="/pics/ajax.gif">
                        </td>
                        <td colspan="5">&#x25be; Больше &#x25be;</td>
                    </tr>
                </tbody>
            </table>
            <?php displayKeyboard(); ?>
        </div></div>

        <div id="similar-dialog" class="modal">
            <div class="modal-header">
                <a class="close" href="#">×</a>
                <h3>Похожие слова</h3>
            </div>
            <form id="similar-form">
                <div class="modal-body">
                    <table id="similar" class="items condensed-table">
                        <thead>
                            <tr>
                                <th colspan="2" class="russian">Русский</th>
                                <th><img id="spinner-similar" src="/pics/ajax.gif"></th>
                                <th colspan="2" class="hebrew">עברית</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="template">
                                <input type="hidden" form="similar-form" name="id[]"/>
                                <td class="russian span6">&nbsp;</td>
                                <td class="russian-comment span6">
                                    <input type="text" form="similar-form"
                                           name="russian_comment[]" maxlength="63"/>
                                </td>
                                <td class="separator">&mdash;</td>
                                <td class="hebrew-comment span6">
                                    <input type="text" form="similar-form"
                                           name="hebrew_comment[]" maxlength="63"/>
                                </td>
                                <td class="hebrew span6">&nbsp;</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button id="similar-dialog-save" class="btn primary" type="submit">Сохранить</button>
                    <button id="similar-dialog-cancel" class="btn secondary">Отмена</button>
                </div>
            </form>
        </div>
    </body>
</html>
