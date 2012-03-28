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
            'name' => '1 день',
            'steps' => 3,
            'priority' => 2,
            'period' => 1),
        LS_3_DAYS => array(
            'name' => '3 дня',
            'steps' => 2,
            'priority' => 1,
            'period' => 3),
        LS_1_WEEK => array(
            'name' => '1 неделя',
            'steps' => 2,
            'priority' => 0,
            'period' => 7),
        LS_2_WEEKS => array(
            'name' => '2 недели',
            'steps' => 2,
            'priority' => 3,
            'period' => 14),
        LS_1_MONTH => array(
            'name' => '1 месяц',
            'steps' => 2,
            'priority' => 4,
            'period' => 28),
        LS_3_MONTHS => array(
            'name' => '3 месяца',
            'steps' => 2,
            'priority' => 5,
            'period' => 3 * 28),
        LS_6_MONTHS => array(
            'name' => '6 месяцев',
            'steps' => 2,
            'priority' => 6,
            'period' => 6 * 28 + 3),
        LS_1_YEAR => array(
            'name' => '1 год',
            'steps' => 2,
            'priority' => 7,
            'period' => 12 * 28 + 6),
        LS_PERMANENT => array(
            'name' => 'навсегда',
            'steps' => 1000000,
            'priority' => 8,
            'period' => 10 * (12 * 28 + 6)));

function getStageByPeriod($period, $currentStage, $currentStep) {
    global $LS_PARAMS;

    if ($currentStage == 0 && $currentStep == 0) {
        $fullPeriod = $period;
    } else {
        $fullPeriod = $period + $LS_PARAMS[$currentStage]['period'];
    }

    $maxStage = LS_1_DAY;
    foreach ($LS_PARAMS as $stage => $info) {
        if ($info['period'] > $fullPeriod) {
            return $maxStage;
        } else {
            $maxStage = $stage;
        }
    }
    return $maxStage;
}
?>
