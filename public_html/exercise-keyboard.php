<!DOCTYPE html>
<?php
require_once('parts/header.php');
require_once('parts/keyboard.php');
?>
<html>
    <head>
        <title>Иврит - Тренажер клавиатуры</title>
        <?php displayPreamble('exercise-keyboard'); ?>
    </head>
    <body>
        <?php displayMainMenu('exercise-keyboard'); ?>
        <div class="container"><div class="content">
            <div id="letters">
                <div id="not-entered"></div>
                <div id="entered"></div>
            </div>
            <div id="entering" class="keyboard-enabled" data-keyboard-positioning="bottom-center"><div>
        </div></div>
        <?php displayKeyboard(); ?>
    </body>
</html>
