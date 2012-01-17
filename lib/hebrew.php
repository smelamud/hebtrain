<?php
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

function isHebrew($s) {
    $ss = iconv('UTF-8', 'UCS-2', $s);
    $fb = ord($ss[0]);
    $sb = ord($ss[1]);
    return $sb == 0x05 && $fb >= 0x91;
}
?>
