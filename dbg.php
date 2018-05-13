<?php

namespace phauto;

// USAGE
// $dbg->inf(__FILE__, __LINE__, "MESSAGE");

class Debugger{

  private $i = 0;  //INFO
  private $e = 0; //ERROR
  private $d = 0; //DEBUG

  public function __construct($i, $e = 0, $d  = 0){
    $this->i = $i;
    $this->e = $i > 1 ? 1 : $e;
    $this->d = $i > 2 ? 1 : $d;
  }

  public function inf($f, $l, $m = "") { if($this->i) $this->write($f, $l, $m, "INFO");   }
  public function err($f, $l, $m = "") { if($this->e) $this->write($f, $l, $m, "ERROR");   }
  public function dbg($f, $l, $m = "") { if($this->d) $this->write($f, $l, $m, "DEBUG");   }

  private function write($f, $l, $m, $t){
    $s = date('d-m-Y G:i:s') . " $f : $l $t - $m";
    php_sapi_name() == 'cli' ? $s .= "\n" : $s .= "<br/>";
    print $s;
  }
}


?>