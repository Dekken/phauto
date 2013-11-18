<?

namespace phautoop;

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
			$rows = $this->pdo->query($q);
		} catch (PDOException $e) {
			$dbg->err(__FILE__, __LINE__, "Connection failed: " . $e->getMessage());
		}
		return $rows;
	}
}

?>