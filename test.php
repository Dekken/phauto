<?
error_reporting(E_ALL);


include_once("page.php");
include_once("inc/orm.php");


class UserTable extends phautoop\ORMTable{
	public function __construct($arr = null){
		$fs = array(
				"o_id", 
				"pass", 
				"fName", 
				"sName", 
				"pEmail", 
				"sEmail", 
				"mobile", 
				"valid",
				"online"
			);
		if(!is_null($arr)){
			$i = 0;
			foreach($t->cols() as $f){
				$fs[$fs[$i]] = $arr[$i];
				$i++;		
			}
		}
		parent::__construct("users", $fs);
	}
}

class Test extends phautoop\Page{
	function __construct(){
		$dbg = $GLOBALS["DBG"];
		$dbg->inf(__FILE__, __LINE__, "INFO");
		$dbg->err(__FILE__, __LINE__, "ERROR");
		$dbg->dbg(__FILE__, __LINE__, "DEBUG");
		$dbg->sdbg(__FILE__, __LINE__, "SUPER DEBUG");		

		//$dbg->inf(__FILE__, __LINE__, sha1("username", "password"));
		
		$orm = $GLOBALS["ORM"];
		$db = $orm->db();
		$arr = array(1234567891234567, 'password', 'fName', 'sName', 'pEmail', 'sEmail', 987654231, 0);
		$orm->addTable("user", new UserTable());

		$user = new phautoop\ORMObject($orm->table("user"), $arr);
		$user->save();

		foreach($orm->tables() as $t){
			$dbg->inf(__FILE__, __LINE__, $t->name());
			foreach($t->cols() as $col)
				$dbg->inf(__FILE__, __LINE__, $col);
		}
		foreach($db->query("SHOW TABLES") as $r)
			foreach($r as $k => $v)
				$dbg->inf(__FILE__, __LINE__, "$k : $v");

		$test = $orm->table("user")->get(1234567891234567);
		foreach($test->all() as $k => $v)
			$dbg->inf(__FILE__, __LINE__, "$k $v");

		$q = "DELETE FROM users where o_id = 1234567891234567";
		$orm->delete($user);

	}
	function __destruct() {
		$GLOBALS["DBG"]->inf(__FILE__, __LINE__, "DESTROYING " .__CLASS__);	
	}
}

(new Test)->display();
?>