<?

namespace phautoop;

include_once("./os.php");

abstract class AnEmail{
	$atts = array();
	public function __construct(){}
	public function addAttachment($att){
		if(!OS::isFile($att)) throw new OSException("$att is not a file on local machine");
		$atts[] =
	}
}

class Email extends AnEmail{

	public function __construct(){}
}

class Emailer{}



?>