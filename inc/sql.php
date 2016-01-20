<?php

namespace phauto;

class DB{
	private $pdo;

	public static function create1($pdo){
		return new DB($pdo);
	}
	public static function create2($u, $p, $d, $h = "localhost", $dbt = "mysql"){
		try {
			return new DB(new \PDO("$dbt:dbname=$d;host=$h", $u, $p));
		} catch (PDOException $e) {
			$dbg->err(__FILE__, __LINE__, "Connection failed: " . $e->getMessage());
		}
	}
	private function __construct($pdo){		
		$this->pdo = $pdo;
	}
	public function __destruct(){
		$this->pdo = null;
	}
	
	public function query($q){
		$rows;

		try {
			if(is_string($q)){
				$GLOBALS["DBG"]->inf(__FILE__, __LINE__, $q);
				$rows = $this->pdo->query($q);
			}else{
				$q->execute();
				$rows = $q->fetch(\PDO::FETCH_ASSOC);
			}
		} catch (PDOException $e) {
			$GLOBALS["DBG"]->err(__FILE__, __LINE__, "Connection failed: " . $e->getMessage());
		}
		foreach($this->pdo->errorInfo() as $s)
			$GLOBALS["DBG"]->inf(__FILE__, __LINE__, "Error: " . $s);
		return $rows;
	}
	public function prepare($q){
		return $this->pdo->prepare($q);
	}
	public function exec($q){
		try {
			$this->pdo->beginTransaction();
			$q->execute();
			$this->pdo->commit();
		} catch (PDOException $e) {
			$GLOBALS["DBG"]->err(__FILE__, __LINE__, "Connection failed: " . $e->getMessage());
		}		
	}
}

?>