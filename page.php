<?

namespace phauto;

// include_once("./conf.php");
include_once("./inc/tag.php");

abstract class Page{
	private $ff		= false;
	private $title	= "";
	private $head 	= array();
	private $body 	= array();

	public function __construct($title){
		$this->title = $title;
		if(isset($_SESSION['form'])){
			$this->ff = true;
			$this->handleFrom(unserialize($_SESSION['form']));
			unset($_SESSION['form']);
		}
	}

	public function formFound(){return $this->ff;}

	public function addHeadTag($tag){
		$this->head[] = $tag;
		return $this;
	}
	public function addBodyTag($tag){
		$this->body[] = $tag;
		return $this;
	}

	public function display(){
		$html = new Tag("html");
		$head = new Tag("head");
		$body = new Tag("body");
		$head->addTag(new Tag("title", $this->title));
		foreach($this->head as $tag) $head->addTag($tag);
		foreach($this->body as $tag) $body->addTag($tag);
		$html->addTag($head);
		$html->addTag($body);	
		print "<!doctype html>\n";
		$html->display();
	}
	abstract protected function handleFrom($form);
}

?>