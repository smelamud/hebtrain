<?php
require_once('lib/questions.php');

# Types of vocabulary items

const VI_WORD = 0;
const VI_NOUN_UNI = 1;
const VI_NOUN_MULTI = 2;
const VI_ADJECTIVE = 3;
const VI_VERB = 4;
const VI_ADVERB = 5;
const VI_ADVERB_PHRASE = 6;
const VI_PREP = 7;
const VI_QUESTION = 8;
const VI_NUMERAL = 9;
const VI_FOREIGN = 10;
const VI_GEO = 11;
const VI_PHRASE = 12;
const VI_SLANG = 13;
const VI_VERB_PREP = 14;

$VI_QUESTIONS = array(
    // This one is used for 'hard' words
    VI_WORD => array(QV_WORD_BARE_HE_RU, QV_WORD_RU_HE, QV_WORD_RU_HE_WRITE),
    //
    VI_NOUN_UNI => array(QV_WORD_BARE_HE_RU, QV_WORD_RU_HE, QV_WORD_RU_HE_WRITE),
    VI_NOUN_MULTI => array(QV_WORD_BARE_HE_RU, QV_WORD_RU_HE, QV_WORD_RU_HE_WRITE),
    VI_ADJECTIVE => array(QV_WORD_BARE_HE_RU, QV_WORD_RU_HE, QV_WORD_RU_HE_WRITE),
    VI_VERB => array(QV_WORD_BARE_HE_RU, QV_WORD_RU_HE, QV_WORD_RU_HE_WRITE),
    VI_ADVERB => array(QV_WORD_BARE_HE_RU, QV_WORD_RU_HE, QV_WORD_RU_HE_WRITE),
    VI_ADVERB_PHRASE => array(QV_WORD_RU_HE),
    VI_PREP => array(QV_WORD_BARE_HE_RU, QV_WORD_RU_HE, QV_WORD_RU_HE_WRITE),
    VI_QUESTION => array(QV_WORD_BARE_HE_RU, QV_WORD_RU_HE, QV_WORD_RU_HE_WRITE),
    VI_NUMERAL => array(QV_WORD_BARE_HE_RU, QV_WORD_RU_HE, QV_WORD_RU_HE_WRITE),
    VI_FOREIGN => array(QV_WORD_RU_HE, QV_WORD_RU_HE_WRITE),
    VI_GEO => array(QV_WORD_RU_HE),
    VI_PHRASE => array(QV_WORD_RU_HE),
    VI_SLANG => array(QV_WORD_BARE_HE_RU, QV_WORD_RU_HE, QV_WORD_RU_HE_WRITE),
    VI_VERB_PREP => array(QV_WORD_RU_HE)
);

# Genders

const VIG_NONE = 0;
const VIG_M = 1;
const VIG_F = 2;
const VIG_MP = 3;
const VIG_FP = 4;
?>
