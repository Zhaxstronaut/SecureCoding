<?php

function scanf($f, &...$v) {
    $i = trim(fgets(STDIN));
    $p = explode(" ", $i);
    foreach ($v as $k => &$a) {
        if (isset($p[$k])) {
            $a = $p[$k];
        }
    }
}


function _($x){$y=explode(" ",$x);for($z=0;$z<count($y);$z++){echo $y[$z];if($z!=count($y)-1)echo" ";}echo"\n";}

echo"Input string: ";$a="";scanf(['s'],$a);_($a);
?>