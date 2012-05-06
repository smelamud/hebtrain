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
            <button id="add-item" class="btn btn-primary">Добавить слово</button>

            <table id="found" class="items table table-condensed">
                <thead>
                    <tr>
                        <th colspan="3">
                            <span id="found-title"><span id="found-loaded">0</span> из <span id="found-total">0</span></span>
                            <span id="added-title">Добавлено: <span id="added-total">0</span></span>
                        </th>
                        <th colspan="3" id="search">
                            <form id="search-form" class="form-search">
                                <img id="spinner" src="/pics/ajax.gif">
                                <input type="text" name="q" maxlength="63" class="keyboard-enabled search-query"/>
                            </form>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="template">
                        <td class="spinner-space">&nbsp;</td>
                        <td class="russian span4">&nbsp;</td>
                        <td class="russian-comment span4">&nbsp;</td>
                        <td class="separator">&mdash;</td>
                        <td class="hebrew-comment span4">&nbsp;</td>
                        <td class="hebrew span4">&nbsp;</td>
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

        <div id="edit-dialog" class="modal">
            <div class="modal-header">
                <a class="close" href="#">×</a>
                <h3>Слово</h3>
            </div>
            <form id="edit-form" class="form-inline">
                <div class="modal-body">
                    <input type="hidden" name="id" value="0">
                    <label>
                        <span class="main-label">עברית</span>
                        <input type="text" class="hebrew keyboard-enabled" name="hebrew" maxlength="63"/>
                    </label>
                    <input type="text" name="hebrew_comment" maxlength="63"/><br/>
                    <label>
                        <span class="main-label">Русский</span>
                        <input type="text" name="russian" maxlength="63"/>
                    </label>
                    <input type="text" name="russian_comment" maxlength="63"/><br/>
                    <label id="edit-dialog-familiar">
                        <input type="checkbox" name="familiar" value="1"/>
                        <span class="checkbox-label">Знакомое слово</span>
                    </label>&nbsp;&nbsp;
                    <label>
                        <input type="checkbox" name="hard" value="1"/>
                        <span class="checkbox-label">Сложное слово</span>
                    </label><br/><br/>
                    <label>
                        <select name="group">
                            <option value="0">Прочее</option>
                            <option value="1">Существительное однополое</option>
                            <option value="2">Существительное двуполое</option>
                            <option value="3">Прилагательное</option>
                            <option value="4">Глагол</option>
                            <option value="5">Наречие</option>
                            <option value="6">Наречие-оборот</option>
                            <option value="7">Связка</option>
                            <option value="12">Оборот</option>
                            <option value="8">Вопросительное слово</option>
                            <option value="9">Числительное</option>
                            <option value="10">Иностранное слово</option>
                            <option value="11">Географическое название</option>
                            <option value="13">Сленг</option>
                        </select>
                    </label>
                    <label id="gender-section">
                        &nbsp;&nbsp;&nbsp;Род&nbsp;
                        <select name="gender">
                            <option value="0">Нет</option>
                            <option value="1">Мужской</option>
                            <option value="2">Женский</option>
                            <option value="3">Мужской множественный</option>
                            <option value="4">Женский множественный</option>
                        </select>
                    </label><br/>
                    <label>
                        <span class="main-label">Корень</span>
                        <input type="text" class="hebrew keyboard-enabled input-mini" name="root" maxlength="10"/>
                    </label><br/>
                    <label>
                        <span class="main-label">Сокращ.</span>
                        <input type="text" class="hebrew keyboard-enabled input-mini" name="abbrev" maxlength="10"/>
                    </label><br/>
                    <label id="feminine-section">
                        <span class="main-label">Она</span>
                        <input type="text" class="hebrew keyboard-enabled" name="feminine" maxlength="63"/>
                    </label><br/>
                    <label id="plural-section">
                        <span class="main-label">Много</span>
                        <input type="text" class="hebrew keyboard-enabled" name="plural" maxlength="63"/>
                    </label><br/>
                    <label id="smihut-section">
                        <span class="main-label">Смихут</span>
                        <input type="text" class="hebrew keyboard-enabled" name="smihut" maxlength="63"/>
                    </label>
                </div>
                <div class="modal-footer">
                    <button id="edit-dialog-add" class="btn btn-primary">Добавить</button>
                    <button id="edit-dialog-modify" class="btn btn-primary">Изменить</button>
                    <button type="button" id="edit-dialog-delete" class="btn">Удалить</button>
                    <button id="edit-dialog-cancel" class="btn">Отмена</button>
                </div>
            </form>
        </div>

        <div id="similar-dialog" class="modal">
            <div class="modal-header">
                <a class="close" href="#">×</a>
                <h3>Похожие слова</h3>
            </div>
            <form id="similar-form">
                <div class="modal-body">
                    <table id="similar" class="items table table-condensed">
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
                    <button id="similar-dialog-save" class="btn btn-primary" type="submit">Сохранить</button>
                    <button id="similar-dialog-cancel" class="btn">Отмена</button>
                </div>
            </form>
        </div>
    </body>
</html>
