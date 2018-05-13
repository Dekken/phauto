<?php

namespace phauto\secret;



class TimeBased{
  public static function GENERATE($s = "salt", $a = "sha256", $t = 10){
    $time = strtotime("now");
    $minutes = date('i', $time);
    return hash($a, $s.date('G', $time).str_pad(($minutes - ($minutes % $t)), 2, '0', STR_PAD_LEFT));
  }
}

?>