<?php


require_once 'Framework/Controller.php';
require_once 'Framework/Form.php';
require_once 'Framework/TableView.php';

require_once 'Modules/core/Controller/ControllerSecureNav.php';

require_once 'Modules/networking/Controller/NtTranslator.php';
require_once 'Modules/networking/Controller/NtGroup.php';

class ControllerNetworking extends ControllerSecureNav {

    public function index(){
        // last inserted informations
    }
    
    public function groups(){
        
        $lang = $this->getLanguage();
        
        $modelGroups = new NtGroup();
        $groups = $modelGroups->getAll();
        
        $table = new TableView();
		
	$table->setTitle(NtTranslator::Groups($lang));
	$table->addLineEditButton("networking/edit");
	$table->addDeleteButton("coreusers/delete");
	$table->addPrintButton("coreusers/index/");
	if ($authorisations_location == 2){
		$table->addLineButton("Sygrrifauthorisations/userauthorizations", "id", CoreTranslator::Authorizations($lang));
	}
	$tableContent =  array(
			"id" => "ID",
			"name" => CoreTranslator::Name($lang),
			"firstname" => CoreTranslator::Firstname($lang),
			"login" => CoreTranslator::Login($lang),
			"email" => CoreTranslator::Email($lang),
			"tel" => CoreTranslator::Phone($lang),
			"unit" => CoreTranslator::Unit($lang),
			"resp_name" => CoreTranslator::Responsible($lang),
			"status" => CoreTranslator::Status($lang),
			"is_responsible" => CoreTranslator::is_responsible($lang),
		);
        
        $tableHtml = $table->view($usersArray,$tableContent);
		
        
        // view
        $navBar = $this->navBar();
        $this->generateView ( array (
            'navBar' => $navBar,
            'tableHtml' => $tableHtml
	) );
    }
    
    public function projects(){
        
    }
    
    /*
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
     
     */
}