<?

namespace phautoop;

include_once("os.php");
include_once("except.php");

class XMLException extends AnException{
	public function __toString() {
		return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
	}
}

//class XPather  	__construct(file) get($query){}

class XPather{
	private $doc;
	public function __construct($f){
		if(!OS::isFile($f)) throw new OSException("$f is not a file on local machine");
		$this->doc = new \DOMDocument();
		$this->doc->load($f);
	}

	public function get($q){		
		$r = array();
		$i = 0;
		foreach((new \Domxpath($this->doc))->query($q) as $v){
			$r[] = array("text" => "", "atts" => array());
			if(strlen(trim($v->textContent)))
				$r[$i]["text"] = trim($v->textContent);
			
			if($v->hasAttributes())		
				foreach($v->attributes as $a)
					$r[$i]["atts"][$a->name] = $a->value;

			$i++;
		}
		return $r;
	}
	public function query($q){
		return (new \Domxpath($this->doc))->query($q);
	}
}

?>