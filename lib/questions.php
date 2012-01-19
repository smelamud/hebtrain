<?php
# Question variants

const QV_WORD_HE_RU = 1;
const QV_WORD_BARE_HE_RU = 2;
const QV_WORD_RU_HE = 3;
const QV_WORD_RU_HE_WRITE = 4;
const QV_WORD_RU_HE_NEKUDOT = 5;

$QV_PARAMS = array(
    QV_WORD_HE_RU => array(
        'word' => 'hebrew',
        'comment' => 'hebrew_comment',
        'answer' => 'russian'),
    QV_WORD_BARE_HE_RU => array(
        'word' => 'hebrew_bare',
        'comment' => 'hebrew_comment',
        'answer' => 'russian'),
    QV_WORD_RU_HE => array(
        'word' => 'russian',
        'comment' => 'russian_comment',
        'answer' => 'hebrew'),
    QV_WORD_RU_HE_WRITE => array(
        'word' => 'russian',
        'comment' => 'russian_comment',
        'answer' => 'hebrew_bare'),
    QV_WORD_RU_HE_NEKUDOT => array(
        'word' => 'russian',
        'comment' => 'russian_comment',
        'answer' => 'hebrew'));
?>
