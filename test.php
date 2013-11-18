<?
error_reporting(E_ALL);


include_once("page.php");
include_once("inc/orm.php");

class Test extends phautoop\Page{
	function __construct(){
		$dbg = $GLOBALS["DBG"];
		$dbg->inf(__FILE__, __LINE__, "INFO");
		$dbg->err(__FILE__, __LINE__, "ERROR");
		$dbg->dbg(__FILE__, __LINE__, "DEBUG");
		$dbg->sdbg(__FILE__, __LINE__, "SUPER DEBUG");		

		//$dbg->inf(__FILE__, __LINE__, sha1("username", "password"));
		$db = phautoop\DB::create2("root", "whogivesashit", "eclation_local");
		$dbg->inf(__FILE__, __LINE__, "INFO");
		$orm = new phautoop\ORMManager(__DIR__, $db);
		
		foreach($orm->all() as $t){
			$dbg->inf(__FILE__, __LINE__, $t->table());
			foreach($t->cols() as $col)
				$dbg->inf(__FILE__, __LINE__, $col->name());
		}
	}
	function __destruct() {
		$GLOBALS["DBG"]->inf(__FILE__, __LINE__, "DESTROYING " .__CLASS__);		
	}

	protected function handleFrom($form){}

}

(new Test)->display();
?>