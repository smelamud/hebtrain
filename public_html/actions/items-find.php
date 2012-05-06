<?php
require_once('conf/hebtrain.conf');

require_once('lib/post.php');
require_once('lib/database.php');
require_once('lib/items.php');
require_once('lib/hebrew.php');

function findItems($keyword, $offset) {
    global $mysqli;

    $result = array(
        'offset' => $offset,
        'count' => 0,
        'total' => 0,
        'items' => array()
    );

    $st = $mysqli->prepare(
        'select count(*)
         from items
         where russian like ? and hebrew_bare like ?');
    dbFailsafe($mysqli);
    if (isHebrew($keyword)) {
        $russian_like = '%';
        $hebrew_like = $keyword . '%';
    } else {
        $russian_like = $keyword . '%';
        $hebrew_like = '%';
    }
    $st->bind_param('ss', $russian_like, $hebrew_like);
    $st->execute();
    $st->bind_result($result['total']);
    $st->fetch();
    $st->close();

    $st = $mysqli->prepare(
        'select id, hebrew, hebrew_comment, russian, russian_comment,
                root, `group`, gender, feminine, plural, smihut, abbrev, hard
         from items
         where russian like ? and hebrew_bare like ?
         order by hebrew_bare
         limit ?, ?');
    dbFailsafe($mysqli);
    $limit = CFG_ITEMS_LOAD_LIMIT;
    $st->bind_param('ssii', $russian_like, $hebrew_like, $offset, $limit);
    $st->execute();

    $st->store_result();
    $result['count'] = $st->num_rows;

    $st->bind_result($id, $hebrew, $hebrew_comment, $russian, $russian_comment,
        $root, $group, $gender, $feminine, $plural, $smihut, $abbrev, $hard);
    while ($st->fetch()) {
        array_push(
            $result['items'],
            array('id' => $id,
                  'hebrew' => $hebrew,
                  'hebrew_comment' => $hebrew_comment,
                  'russian' => $russian,
                  'russian_comment' => $russian_comment,
                  'root' => $root,
                  'group' => (int)$group,
                  'gender' => (int)$gender,
                  'feminine' => $feminine,
                  'plural' => $plural,
                  'smihut' => $smihut,
                  'abbrev' => $abbrev,
                  'hard' => (int)$hard));
    }

    $st->close();

    return $result;
}

$mysqli = dbConnect();

$result = findItems(getVar('q'), getIntVar('offset'));

dbClose($mysqli);

header('Content-Type: application/json');
echo json_encode($result);
?>
