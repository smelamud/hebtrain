<?php
function displayMainMenuItem($current, $page, $title, $href) {
    if ($current == $page) {
        echo "<li class=\"active\"><a href=\"$href\">$title</a></li>";
    } else {
        echo "<li><a href=\"$href\">$title</a></li>";
    }
}

function displayMainMenu($current) {?>
    <div class="topbar">
        <div class="fill">
            <div class="container">
                <a class="brand" href="/">Иврит</a>
                <ul class="nav"><?php
                    displayMainMenuItem($current, 'index', 'Начало', '/');
                    displayMainMenuItem($current, 'run', 'Тест', '/run.php');
                    displayMainMenuItem($current, 'items', 'Слова', '/items.php');
                ?></ul>
            </div>
        </div>
    </div><?php
}
?>
