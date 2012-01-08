<?php
function displayMainMenuItem($current, $page, $title, $href) {
    if ($current == $page) {
        echo "<li>$title</li>";
    } else {
        echo "<li><a href=\"$href\">$title</a></li>";
    }
}

function displayMainMenu($current) {?>
    <header>
        <div class="site-title">Иврит</div>
        <ul class="menu"><?php
          displayMainMenuItem($current, 'index', 'Начало', '/');
          displayMainMenuItem($current, 'run', 'Тест', '/run.php');
          displayMainMenuItem($current, 'add', 'Добавить', '/add.php');
          displayMainMenuItem($current, 'list', 'Список', '/list.php');
      ?></ul>
    </header><?php
}
?>
