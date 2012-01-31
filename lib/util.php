<?php
function getPlural($n, $form1, $form2, $form5) {
    $a = $n % 10;
    $b = ((int) $n / 10) % 10;
    $s = $b == 1 || $a >= 5 || $a == 0 ? $form5 : ($a == 1 ? $form1 : $form2);
    return "$n $s";
}
?>
