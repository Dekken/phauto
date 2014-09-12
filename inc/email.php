<?

namespace phautop;

include_once("./os.php");

abstract class AnEmail{
	$atts = array();
	public function __construct(){}
	public function addAttachment($att){
		if(!OS::isFile($att)) throw new OSException("$att is not a file on local machine");
		$atts[] = $att;
	}
}

class Email extends AnEmail{

	public function __construct(){}
	public function send(){
		/*
		$to = "someone@example.com";
		$subject = "Test mail";
		$message = "Hello! This is a simple email message.";
		$from = "someonelse@example.com";
		$headers = "From:" . $from;
		mail($to,$subject,$message,$headers);
		echo "Mail Sent.";
		*/
	}
}

class Emailer{}



?>