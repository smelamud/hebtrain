<!DOCTYPE html>
<?php
require_once('parts/header.php');
require_once('parts/keyboard.php');
?>
<html>
    <head>
        <title>Иврит - Клавиатурный тренажер</title>
        <?php displayPreamble('exercise-keyboard'); ?>
    </head>
    <body>
        <?php displayMainMenu('exercise-keyboard'); ?>
        <div class="container"><div class="content">
            <div id="letters">
                <div id="not-entered"></div>
                <div id="entered"></div>
            </div>
            <div id="entering" class="keyboard-enabled"><div>
        </div></div>
        <?php displayKeyboard(); ?>
    </body>
</html>
