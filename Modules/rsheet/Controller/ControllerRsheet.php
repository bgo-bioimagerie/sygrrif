<?php


require_once 'Framework/Controller.php';
require_once 'Framework/Form.php';

require_once 'Modules/core/Controller/ControllerSecureNav.php';

class ControllerRsheet extends ControllerSecureNav {

	public function index() {
		

		// build the form
		$myform = new Form($this->request, "formtemplate");
		$myform->setTitle("User informations");
		$myform->addText("name", "name", true, "toto");
		$myform->addSelect("gender", "gender", array("male", "female"), array(0,1), 1);
		$myform->addNumber("age", "Age", true, "12");
		$myform->addEmail("email", "Email", true);
		$myform->addTextArea("description", "Description");
		$myform->setValidationButton("Ok", "template/index");
		
		
		if ($myform->check()){
			// run the database query
			echo "fill the database with: ". "<br/>";
			echo "	name = " . $myform->getParameter("name") . "<br/>";
			echo "	gender = " . $myform->getParameter("gender"). "<br/>";
			echo "	age = " . $myform->getParameter("age"). "<br/>";
			echo "	email = " . $myform->getParameter("email"). "<br/>";
			echo "	description = " . $myform->getParameter("description"). "<br/>";
			return;
		}
		else{
			// set the view
			$formHtml = $myform->getHtml();
			// view
			$navBar = $this->navBar();
			$this->generateView ( array (
					'navBar' => $navBar,
					'formHtml' => $formHtml
			) );
		}
	}
}