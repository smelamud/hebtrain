<!DOCTYPE html>
<?php
require_once('parts/header.php');
?>
<html>
    <head>
        <title>Иврит - Внутренняя флексия</title>
        <?php displayPreamble('exercise-flexion'); ?>
    </head>
    <body>
        <?php displayMainMenu('exercise-flexion'); ?>
        <div class="container"><div class="content">
            <div id="example">
                <div id="progress"><span id="current"></span> из <span id="total"></span></div>
                <div class="row">
                    <div class="span1 offset3"><button id="prev-example" class="btn">&#x2190;</button></div>
                    <div id="example-text" class="span4"></div>
                    <div class="span1"><button id="next-example" class="btn">&#x2192;</button></div>
                </div>
            </div>
            <ul id="roots" class="unstyled">
                <li class="template"></li>
            </ul>
        </div></div>
    </body>
</html>
