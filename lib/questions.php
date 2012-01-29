<?php
# Question variants

const QV_WORD_RANDOM = -1;
const QV_WORD_MIX = 0;
const QV_WORD_HE_RU = 1;
const QV_WORD_BARE_HE_RU = 2;
const QV_WORD_RU_HE = 3;
const QV_WORD_RU_HE_WRITE = 4;
const QV_WORD_RU_HE_NEKUDOT = 5;

const QV_WORD_MIN = QV_WORD_HE_RU;
const QV_WORD_MAX = QV_WORD_RU_HE_NEKUDOT;

$QV_PARAMS = array(
    QV_WORD_HE_RU => array(
        'ident' => 'he_ru',
        'title' => 'Иврит → русский',
        'word' => 'hebrew',
        'comment' => 'hebrew_comment',
        'answer' => 'russian',
        'input' => false),
    QV_WORD_BARE_HE_RU => array(
        'ident' => 'bare_he_ru',
        'title' => 'Иврит б/о → русский',
        'word' => 'hebrew_bare',
        'comment' => 'hebrew_comment',
        'answer' => 'russian',
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
        'answer' => 'hebrew_bare',
        'input' => true),
    QV_WORD_RU_HE_NEKUDOT => array(
        'ident' => 'ru_he_nekudot',
        'title' => 'Русский → иврит с/о',
        'word' => 'russian',
        'comment' => 'russian_comment',
        'answer' => 'hebrew',
        'input' => true));

$QV_IDENTS = array(
    QV_WORD_RANDOM => 'random',
    QV_WORD_MIX => 'mix',
    QV_WORD_HE_RU => 'he_ru',
    QV_WORD_BARE_HE_RU => 'bare_he_ru',
    QV_WORD_RU_HE => 'ru_he',
    QV_WORD_RU_HE_WRITE => 'ru_he_write',
    QV_WORD_RU_HE_NEKUDOT => 'ru_he_nekudot'
);
?>
