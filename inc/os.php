<?

namespace phautoop;

include_once("except.php");

class OSException extends AnException{
	public function __toString() {
		return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
	}
}

class OS{	
	public static function isFile($f){ return is_file($f); }
	public static function isDir($d) { return is_dir($d); }
}





?>