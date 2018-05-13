<?php

namespace phauto\https;

include_once("http.php");

class Exception extends \phauto\AnException{
  public function __toString() {
    return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
  }
}

class Post extends \phauto\http\Post{
  public function __construct($u, $a = array()){
    parent::__construct($u, $a);
  }
  public function send(){
    // $this->post("https://".$this->u);
    $o = array(
        'https' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($this->a),
        ),
    );
    $c  = stream_context_create($o);
    $r = file_get_contents("https://".$this->u, false, $c);
    return var_dump($r);
  }
}


// namespace \phauto\https;

?>