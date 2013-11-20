<?

namespace phautoop;

//class TextLabel 		__construct(text = "")
//class TextInput 		__construct(name)
//class PassInput 		__construct(name)
//class TextArea 		__construct(rows = 1, columns = 10)
//class ComboBox		__construct(name){
//class CheckBox 		__construct(name, value, text)
//class RadioButton 	__construct(name, value, text)
//class SubmitButton 	__construct(value = "Submit")
//class Form 			__construct(action = "", name = "input", method = "post", submit = true)


class Tag{
	private $c;
	private $n;
	private $v;
	private $atts;
	private $tags = array();
	public function __construct($n, $v = "", $c = true){
		$this->c = $c;
		$this->n = $n;
		$this->v = $v;
	}
	public function addAtt($k, $v){
		$this->atts[$k] = $v;
	}
	public function addTag($tag){
		$this->tags[] = $tag;
		return $this;
	}
	public function display($tabs = 0){
		for($t = 0; $t < $tabs; $t++) print "\t";

		print "<$this->n";
		if(count($this->atts))
			foreach($this->atts as $k => $v) print " $k=\"$v\"";
		
		if(count($this->tags) == 0 && strlen($this->v) == 0 && $this->c) print "/>";
		else print ">";

		if(strlen($this->v) > 0){
			if(($tabs * 5) + strlen($this->v) > 70){
				print "\n";
				for($t = 0; $t < $tabs + 1; $t++) print "\t";
			}
			print "$this->v";
		} 
		
		if(count($this->tags) > 0)
			print "\n";
		foreach($this->tags as $tag) $tag->display($tabs + 1);
		
		if(count($this->tags) > 0)
			for($t = 0; $t < $tabs; $t++) print "\t";
		if(count($this->tags) > 0 || strlen($this->v) > 0 && $this->c)print "</$this->n>\n";
		else 		print "\n";
	}
}

class TextLabel extends Tag{
	public function __construct($t = ""){
		parent::__construct("label", $t);
	}
}
class TextArea extends Tag{
	public function __construct($t, $r = 1, $c = 10){
		parent::__construct("textarea", $t);
	}
}
class TextInput extends Tag{
	public function __construct($n){
		parent::__construct("input", "", false);
		$this->addAtt("type", "text");
		$this->addAtt("name", $n);
	}
}
class PassInput extends Tag{
	public function __construct($n){
		parent::__construct("input", "", false);
		$this->addAtt("type", "password");
		$this->addAtt("name", $n);
	}
}

class ComboBox extends Tag{	
	public function __construct($n){
		parent::__construct("select", "");
		$this->addAtt("name", $n);
	}
}
class CheckBox extends Tag{
	public function __construct($n, $v, $t){
		parent::__construct("input", $t, false);
		$this->addAtt("type", "checkbox");
		$this->addAtt("name", $n);
		$this->addAtt("value", $v);
	}
}
class RadioButton extends Tag{
	public function __construct($n, $v, $t){
		parent::__construct("input", $t, false);
		$this->addAtt("type", "radio");
		$this->addAtt("name", $n);
		$this->addAtt("value", $v);
	}
}
class SubmitButton extends Tag{
	private $ph;
	public function __construct($v = "Submit"){
		parent::__construct("input", "", false);
		$this->addAtt("type", "submit");
		$this->addAtt("value", $v);
	}
}

class Form extends Tag{
	private $a;
	private $n;
	private $m;
	private $s;
	public function __construct($a = "", $n = "input", $m = "post", $s = true){
		$this->a = $a;
		$this->n = $n;
		$this->m = $m;
		$this->s = $s;
		parent::__construct("form");
		$this->addAtt("action"	, $a);
		$this->addAtt("name"	, $n);
		$this->addAtt("method"	, $m);
	}
	public function display($tabs = 0){
		if($this->s)
			$this->addTag(new SubmitButton());
		parent::display($tabs);
	}
}
?>