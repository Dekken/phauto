<?php

error_reporting(E_ALL);

include_once(dirname(__FILE__)."/dbg.php");
if(!isset($GLOBALS["dbg"]))       $GLOBALS["dbg"] = new phauto\Debugger(3);

if(!isset($GLOBALS["PHAUTO_SALT"]))   $GLOBALS["PHAUTO_SALT"] = "SALTY";

?>