<?php
require_once('lib/questions.php');
require_once('lib/util.php');

function displayPreamble($page, $mobile=false, $bootstrapScripts = array()) {
    if ($mobile) {
    ?>
        <meta name="viewport" content="width=400 user-scalable=no"/>
    <?php
    }
    ?>
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="/css/common.css"/>
    <link rel="stylesheet" type="text/css" href="/css/<?php echo $page; ?>.css"/>
    <script type="text/javascript" src="/js/jquery.min.js"></script>
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
    if (substr($current, 0, strlen($page)) == $page &&
        (strlen($current) == strlen($page) ||
         substr($current, strlen($page), 1) == '-')) {
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
    if ($title == '-') {
        echo '<li class="divider"></li>';
    } elseif (count($subMenu) > 0) {
        echo "<a href=\"$href\" class=\"dropdown-toggle\""
            ." data-toggle=\"dropdown\">$title <b class=\"caret\"></b></a>";
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

function displayCountdown() {
    $currentDate = new DateTime();
    $alyahDate = new DateTime('2013-01-29');
    $interval = $alyahDate->diff($currentDate)->days;
    $diffDays = $interval->days;
    if (!$interval->$invert) {
    ?>
        <p class="pull-right">��������, � �-���� �������, <?php echo getPlural($diffDays, '����', '���', '����'); ?></p>
    <?php } else { ?>
        <p class="pull-right">��� <?php echo getPlural($diffDays, '����', '���', '����'); ?> � �������</p>
    <?php }
}

function displayMainMenu($current) {
    global $QV_PARAMS, $QV_IDENTS;

    ?>
    <div class="navbar navbar-fixed-top" data-dropdown="dropdown">
        <div class="navbar-inner">
            <div class="container">
                <a class="brand" href="/">�����</a>
                <ul class="nav"><?php
                    displayMainMenuItem($current, 'index', '������', '/');
                    $testMenu = array(
                        array('run-mix', '����',
                            '/run.php?qv=' . QV_WORD_MIX),
                        array('run-random', '���������',
                            '/run.php?qv=' . QV_WORD_RANDOM),
                        array('', '-', '')
                    );
                    foreach ($QV_PARAMS as $index => $qv) {
                        $testMenu[] = array('run-' . $qv['ident'], $qv['title'],
                            '/run.php?qv=' . $index);
                    }
                    displayMainMenuItem($current . '-' . $QV_IDENTS[$_GET['qv']],
                        'run', '����', '#', $testMenu);
                    displayMainMenuItem($current, 'exercise', '����������', '#', array(
                        array('exercise-keyboard', '����������', '/exercise-keyboard.php'),
                        array('exercise-flexion', '���������� �������', '/exercise-flexion.php')
                    ));
                    displayMainMenuItem($current, 'items', '�������', '/items.php');
                ?></ul>
                <?php displayCountdown(); ?>
            </div>
        </div>
    </div><?php
}
?>
