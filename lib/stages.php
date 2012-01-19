<?php
# Stages of learning

const LS_1_DAY = 0;
const LS_3_DAYS = 1;
const LS_1_WEEK = 2;
const LS_2_WEEKS = 3;
const LS_1_MONTH = 4;
const LS_3_MONTHS = 5;
const LS_6_MONTHS = 6;
const LS_1_YEAR = 7;
const LS_PERMANENT = 8;

$LS_PARAMS =
    array(
        LS_1_DAY => array(
            'steps' => 3,
            'period' => 1),
        LS_3_DAYS => array(
            'steps' => 2,
            'period' => 3),
        LS_1_WEEK => array(
            'steps' => 2,
            'period' => 7),
        LS_2_WEEKS => array(
            'steps' => 2,
            'period' => 14),
        LS_1_MONTH => array(
            'steps' => 2,
            'period' => 28),
        LS_3_MONTHS => array(
            'steps' => 2,
            'period' => 3 * 28),
        LS_6_MONTHS => array(
            'steps' => 2,
            'period' => 6 * 28 + 3),
        LS_1_YEAR => array(
            'steps' => 3,
            'period' => 12 * 28 + 6),
        LS_PERMANENT => array(
            'steps' => 1000000,
            'period' => 10 * (12 * 28 + 6)));
?>
