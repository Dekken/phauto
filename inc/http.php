<?php

namespace phauto\http;

include_once("except.php");

class Exception extends \phauto\AnException{
	public function __toString() {
		return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
	}
}

class Post{
	protected $u;
	protected $a;
	public function __construct($u, $a = array()){
		$this->u = $u;
		$this->a = $a;
	}
	protected function post($u){
		$o = array(
		    'http' => array(
		        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
		        'method'  => 'POST',
		        'content' => http_build_query($this->a),
		    ),
		);
		$c  = stream_context_create($o);
		$r = file_get_contents($u, false, $c);
		return var_dump($r);
	}
	public function send(){
		return $this->post("http://".$this->u);
	}
	public function __toString() {
		return __CLASS__ . ": [{$this->u}]: {".print_r($this->a).")}\n";
	}
}


// namespace \phauto\https;

?>