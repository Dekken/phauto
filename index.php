<?

namespace phautoop;

include_once("./page.php");
include_once("./inc/orm.php");

class Index extends Page{

	public function __construct(){
		parent::__construct("Homepage");

		if(!$this->formFound()){
			$form = new Form("", "input", "post", false);
			$form->addTag(new TextLabel("TxT"));
			$form->addTag(new TextInput("text"));
			$form->addTag(new PassInput("pass"));
			$form->addTag(new TextArea("area", 10, 10));
			$form->addTag(new ComboBox("combo"));
			$form->addTag(new CheckBox("name", "value", "text"));
			$form->addTag(new RadioButton("name", "value", "text"));		
			$form->addTag(new SubmitButton("TxT"));
			$this->addBodyTag($form);
			$_SESSION['form'] = serialize($form);
		}
	}

	protected function handleFrom($form){


		$GLOBALS["DBG"]->inf(__FILE__, __LINE__, "INFO");
	}
}

(new Index)->display();
?>