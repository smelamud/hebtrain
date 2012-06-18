<?php
# Question variants

const QV_WORD_RANDOM = -1;
const QV_WORD_MIX = 0;
const QV_WORD_ABBR_HE = 1;
const QV_WORD_BARE_HE_RU = 2;
const QV_WORD_RU_HE = 3;
const QV_WORD_RU_HE_WRITE = 4;
const QV_WORD_RU_ABBR = 5;

const QV_WORD_MIN = QV_WORD_ABBR_HE;
const QV_WORD_MAX = QV_WORD_RU_ABBR;

$QV_PARAMS = array(
    QV_WORD_ABBR_HE => array(
        'ident' => 'abbr_he',
        'title' => 'Сокращ. → иврит',
        'word' => 'abbrev',
        'comment' => 'hebrew_comment',
        'answer' => 'hebrew',
        'input' => false),
    QV_WORD_BARE_HE_RU => array(
        'ident' => 'bare_he_ru',
        'title' => 'Иврит б/о → русский',
        'word' => 'hebrew_bare',
        'comment' => 'hebrew_comment',
        'answer' => array('hebrew', 'russian'),
        'input' => false),
    QV_WORD_RU_HE => array(
        'ident' => 'ru_he',
        'title' => 'Русский → иврит',
        'word' => 'russian',
        'comment' => 'russian_comment',
        'answer' => 'hebrew',
        'input' => false),
    QV_WORD_RU_HE_WRITE => array(
        'ident' => 'ru_he_write',
        'title' => 'Русский → иврит б/о',
        'word' => 'russian',
        'comment' => 'russian_comment',
        'answer' => 'hebrew',
        'input' => true),
    QV_WORD_RU_ABBR => array(
        'ident' => 'ru_abbr',
        'title' => 'Русский → сокращ.',
        'word' => 'russian',
        'comment' => 'russian_comment',
        'answer' => 'abbrev',
        'input' => false));

$QV_IDENTS = array(
    QV_WORD_RANDOM => 'random',
    QV_WORD_MIX => 'mix',
    QV_WORD_ABBR_HE => 'abbr_he',
    QV_WORD_BARE_HE_RU => 'bare_he_ru',
    QV_WORD_RU_HE => 'ru_he',
    QV_WORD_RU_HE_WRITE => 'ru_he_write',
    QV_WORD_RU_ABBR => 'ru_abbr'
);

require_once('lib/items.php');

function enableQuestions($mysqli, $item_id, $group, $isHard, $hasAbbrev,
                         $activate) {
    global $VI_QUESTIONS;

    $st = $mysqli->prepare(
        'select active
         from items
         where id = ?');
    dbFailsafe($mysqli);
    $st->bind_param('i', $item_id);
    $st->execute();
    $st->bind_result($active);
    $st->fetch();
    $st->close();

    if (!$active) {
        if (!$activate) {
            return 0;
        }

        $st = $mysqli->prepare(
            'update items
             set active = 1, activated = now()
             where id = ?');
        dbFailsafe($mysqli);
        $st->bind_param('i', $item_id);
        $st->execute();
        $st->close();
    }

    if ($isHard) {
        $group = VI_WORD;
    }

    $questions = $VI_QUESTIONS[$group];
    if ($hasAbbrev) {
        $questions[] = QV_WORD_ABBR_HE;
        $questions[] = QV_WORD_RU_ABBR;
    }

    $conds = array();
    foreach($questions as $q) {
        $conds[] = "question = $q";
    }

    $st = $mysqli->prepare(
        'update questions
         set active = 1
         where item_id = ? and (' . join(' or ', $conds) . ')');
    dbFailsafe($mysqli);
    $st->bind_param('i', $item_id);
    $st->execute();
    $st->close();
    
    return count($questions);
}
?>
