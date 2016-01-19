<?php
require_once 'Framework/Controller.php';
require_once 'Framework/TableView.php';
require_once 'Framework/Form.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/CoreBelonging.php';

/**
 * Manage the belongings (each user belongs to an belonging)
 * 
 * @author sprigent
 *
 */
class ControllerCorebelongings extends ControllerSecureNav {
	
	/**
	 * User model object
	 */
	private $belongingModel;
	
	/**
	 * Constructor
	 */
	public function __construct() {
		$this->belongingModel = new CoreBelonging();
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Controller::index()
	 */
	public function index() {
		$navBar = $this->navBar ();
		
		$lang = $this->getLanguage();
		
		// get sort action
		$sortentry = "id";
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$sortentry = $this->request->getParameter ( "actionid" );
		}
		
		// get the user list
		$belongingsArray = $this->belongingModel->getbelongings ( $sortentry );
		for($i = 0 ; $i < count($belongingsArray) ; $i++){
			if ($belongingsArray[$i]["type"] == 1){
				$belongingsArray[$i]["type"] = CoreTranslator::Academic($lang);
			}
			else{
				$belongingsArray[$i]["type"] = CoreTranslator::Company($lang);
			}
		}
		
		$table = new TableView();
		$table->ignoreEntry("id", 1);
		$table->setTitle(CoreTranslator::belongings($lang));
		$table->addLineEditButton("corebelongings/edit");
		$table->addDeleteButton("corebelongings/delete");
		$table->addPrintButton("corebelongings/index/");
		$table->setColorIndexes(array("color" => "color"));
		$tableHtml = $table->view($belongingsArray, array("id" => "ID", "name" => CoreTranslator::Name($lang),
				                                          "color" => CoreTranslator::color($lang), "type" => CoreTranslator::type($lang)  
		));
		
		$print = $this->request->getParameterNoException("print");
		
		//echo "print = " . $print . "<br/>";
		if ($table->isPrint()){
			echo $tableHtml;
			return;
		}
		
		$this->generateView ( array (
				'navBar' => $navBar,
				'tableHtml' => $tableHtml 
		) );
	}
	/**
	 * Edit an belonging form
	 */
	public function edit() {
		$navBar = $this->navBar ();
		
		// get id
		$belongingId = 0;
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$belongingId = $this->request->getParameter ( "actionid" );
		}
		
		// get belonging info
		$belonging = array("id" => 0, "name" => "", "color" => "#ffffff", "type" => 1);
		if ($belongingId > 0){
			$belonging = $this->belongingModel->getInfo( $belongingId );
		}
		
		// lang
		$lang = $this->getLanguage();
	
		// form
		// build the form
		$form = new Form($this->request, "Corebelongings/edit");
		$form->setTitle(CoreTranslator::Edit_unit($lang));
		$form->addHidden("id", $belonging["id"]);
		$form->addText("name", CoreTranslator::Name($lang), true, $belonging["name"]);
		$form->addColor("color", CoreTranslator::color($lang), false, $belonging["color"]);
		
		$choices = array( CoreTranslator::Academic($lang), CoreTranslator::Company($lang) );
		$choicesid = array(1,2);
		$form->addSelect("type", CoreTranslator::type($lang), $choices, $choicesid, $belonging["type"]);
		$form->setValidationButton(CoreTranslator::Ok($lang), "Corebelongings/edit");
		$form->setCancelButton(CoreTranslator::Cancel($lang), "Corebelongings");
		
		
		if ($form->check()){
			// run the database query
			$model = new CoreBelonging();
			$model->set($form->getParameter("id"), $form->getParameter("name"), $form->getParameter("color"), $form->getParameter("type"));
			
			$this->redirect("Corebelongings");
		}
		else{
			// set the view
			$formHtml = $form->getHtml();
			// view
			$navBar = $this->navBar();
			$this->generateView ( array (
					'navBar' => $navBar,
					'editForm' => $formHtml
			) );
		}
	
	}
		
	/**
	 * Remove an belonging query to database
	 */
	public function delete(){
	
		$belongingId = $this->request->getParameter("actionid");
		$user = $this->belongingModel->delete($belongingId);
	
		// generate view
		$this->redirect("corebelongings");
	}
}