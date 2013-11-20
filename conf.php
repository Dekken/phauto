<?

namespace phautoop;

session_start();



include_once("./dbg.php");
$GLOBALS["DBG"] = new Debugger(4);

$GLOBALS["DBG"]->inf(__FILE__, __LINE__, session_id());
if(isset($GLOBALS))

include_once("inc/orm.php");
$db = DB::create2("root", "whogivesashit", "eclation_local");
$GLOBALS["ORM"] = new ORMManager($db);


?>