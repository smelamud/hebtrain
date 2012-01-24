<?php
function displayPreamble($page, $bootstrapScripts = array()) {
    ?>
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="/css/common.css"/>
    <link rel="stylesheet" type="text/css" href="/css/<?php echo $page; ?>.css"/>
    <script type="text/javascript"
            src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
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
