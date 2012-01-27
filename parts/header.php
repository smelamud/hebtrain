<?php
function displayPreamble($page, $bootstrapScripts = array()) {
    ?>
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="/css/common.css"/>
    <link rel="stylesheet" type="text/css" href="/css/<?php echo $page; ?>.css"/>
    <script type="text/javascript"
            src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script type="text/javascript" src="/js/bootstrap-dropdown.js"></script>
    <script type="text/javascript" src="/js/common.js"></script>
    <?php
    foreach ($bootstrapScripts as $script) {
        ?>
        <script type="text/javascript" src="/js/bootstrap-<?php echo $script; ?>.js"></script>
        <?php
    }
    ?>
    <script type="text/javascript" src="/js/<?php echo $page; ?>.js"></script>
    <?php
}

function displayMainMenuItem($current, $page, $title, $href, $subMenu = array()) {
    $classes = array();
    if ($current == $page) {
        $classes[] = 'active';
    }
    if (count($subMenu) > 0) {
        $classes[] = 'dropdown';
    }
    if (count($classes) > 0) {
        echo "<li class=\"" . join(' ', $classes) . "\">";
    } else {
        echo '<li>';
    }
    if (count($subMenu) > 0) {
        echo "<a href=\"$href\" class=\"dropdown-toggle\">$title</a>";
        echo '<ul class="dropdown-menu">';
        foreach ($subMenu as $item) {
            displayMainMenuItem($current, $item[0], $item[1], $item[2]);
        }
        echo '</ul>';
    } else {
        echo "<a href=\"$href\">$title</a>";
    }
    echo '</li>';
}

function displayMainMenu($current) {?>
    <div class="topbar" data-dropdown="dropdown">
        <div class="fill">
            <div class="container">
                <a class="brand" href="/">Иврит</a>
                <ul class="nav"><?php
                    displayMainMenuItem($current, 'index', 'Начало', '/');
                    displayMainMenuItem($current, 'run', 'Тест', '#', array(
                        array('', 'Микс', '/run.php'),
                        array('', 'Случайный', '/run.php')
                    ));
                    displayMainMenuItem($current, 'items', 'Слова', '/items.php');
                ?></ul>
            </div>
        </div>
    </div><?php
}
?>
