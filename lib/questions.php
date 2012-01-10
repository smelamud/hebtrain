<?php
# Question variants

const QV_WORD_HE_RU = 1;
const QV_WORD_BARE_HE_RU = 2;
const QV_WORD_RU_HE = 3;
const QV_WORD_RU_HE_WRITE = 4;
const QV_WORD_RU_HE_NEKUDOT = 5;

function bareHebrew($s) {
    $ss = iconv('UTF-8', 'UCS-2', $s);
    $out = '';
    $len = strlen($ss);
    for ($i = 0; $i < $len; $i += 2) {
        $fb = ord($ss[$i]);
        $sb = ord($ss[$i + 1]);
        if ($sb != 0x05 || $fb < 0x91 || $fb > 0xcf) {
            $out .= $ss[$i];
            $out .= $ss[$i + 1];
        }
    }
    return iconv('UCS-2', 'UTF-8', $out);
}
?>
