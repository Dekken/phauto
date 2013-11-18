<?

namespace phautoop;

include_once("xml.php");
include_once("sql.php");
include_once("except.php");

class ORMException extends AnException{
	public function __toString() {
		return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
	}
}

class ORMObject{
	private $c; //Columns in table
	private $t; //Table in db
	private $d; //DB type	
	public function __construct($t = "", $c = array(), $dbt = "mysql"){
		$this->c = $c;
		$this->t = $t;
		$this->dbt = $dbt;		
	}
	public function cols(){
		return $this->c;
	}
	public function table(){
		return $this->t;
	}
}

class ORMColumn{
	private $t;
	private $n;
	private $null;
	private $pk;
	private $ai;
	public function __construct($v){
		$this->t 	= $v["type"];
		$this->n 	= $v["name"];
		$this->null = isset($v["null"])		? $v["null"]	: true;
		$this->pk 	= isset($v["pk"])		? $v["pk"]		: false;
		$this->ai 	= isset($v["autoInc"]) 	? $v["autoInc"] : false;
	}
	public function name(){ return $this->n;}
}

class ORMManager{
	private $classes;
	private $db;
	public function __construct($d, $db){
		if(!OS::isDir($d)) throw new OSException("$d is not a file on local machine");
		$this->db = $db;
		$this->handleDirectory($d);
	}

	public function get($t){
		if(!isset($this->classes[$t]))
			throw new ORMException("No object $t found");
		return $this->classes[$t];
	}
	public function all(){
		return $this->classes;
	}
	private function handleDirectory($d){
		$ls = scandir($d);
		foreach($ls as $e){
			if(substr($e, 0, 1) === ".") continue;			
			if(OS::isDir($e))
				$this->handleDirectory($e);
			else
			if($e === "phautorm.xml")
				$this->handleORMFile($d . "/" . $e);			
		}		
	}
	private function handleORMFile($f){		
		$GLOBALS["DBG"]->inf(__FILE__, __LINE__, "$f");
		$xp = new XPather($f);

		$xml = array("settings", "class");
		foreach($xp->query("/phautorm/*") as $p)
			if(!in_array($p->localName, $xml)) 
				throw new XMLException("Malformed XML, unknown tag : " . $p->localName);
		
		$i = 1;
		foreach($xp->get("/phautorm/class") as $c){
			if(isset($c["text"]) && strlen($c["text"]) > 0)
				throw new XMLException("Malformed XML, no text expected for class tag");
			
			if(!isset($c["atts"]["name"]))
				throw new XMLException("Malformed XML, class tag requires name attribute");

			$cols = array();
			$xml = array("type" => 1, "name" => 1, "pk" => 0, "null" => 0, "autoInc" =>0);
			$tf = array("pk", "null", "autoInc");
			foreach($xp->get("/phautorm/class[$i]/*") as $f){
				foreach($tf as $x)
					if(isset($f["atts"][$x]))
						if(strcasecmp($f["atts"][$x], "true") != 0 && strcasecmp($f["atts"][$x], "false") != 0)
							throw new XMLException("Malformed XML, attribute $x is must be true or false");
				
				foreach($xml as $k => $v){
					if(!isset($f["atts"][$k]) && $v)
						throw new XMLException("Malformed XML, field tag requires $k attribute");
					if(isset($f["atts"][$k]))
						$col[$k] = $f["atts"][$k];					
				}					
				$cols[] = new ORMColumn($col);
			}
			
			if(isset($c["atts"]["table"]) && isset($c["atts"]["db-type"]))
				$this->classes[$c["atts"]["name"]] = new ORMObject($c["atts"]["table"], $cols, $c["atts"]["db-type"]);
			else if(isset($c["atts"]["table"]))
				$this->classes[$c["atts"]["name"]] = new ORMObject($c["atts"]["table"], $cols);
			else if(isset($c["atts"]["db-type"]))
				$this->classes[$c["atts"]["name"]] = new ORMObject($c["atts"]["name"], $cols, $c["atts"]["db-type"]);
			else
				$this->classes[$c["atts"]["name"]] = new ORMObject($c["atts"]["name"], $cols);

			foreach($xp->query("/phautorm/class[$i]/*") as $p)
				if($p->localName !== "field")
					throw new XMLException("Malformed XML, unknown tag : " . $p->localName);
			
			
			$i++;
		}
	}

	
	

}





?>