<?php
require_once 'Framework/Controller.php';
require_once 'Framework/TableView.php';
require_once 'Framework/Form.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/supplies/Model/SuBelonging.php';

/**
 * Manage the belongings (each user belongs to an belonging)
 * 
 * @author sprigent
 *
 */
class ControllerSuppliesbelongings extends ControllerSecureNav {
	
	/**
	 * User model object
	 */
	private $belongingModel;
	
	/**
	 * Constructor
	 */
	public function __construct() {
		$this->belongingModel = new SuBelonging();
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
		
		$table = new TableView();
		$table->ignoreEntry("id", 1);
		$table->setTitle(CoreTranslator::belongings($lang));
		$table->addLineEditButton("suppliesbelongings/edit");
		$table->addDeleteButton("suppliesbelongings/delete");
		$table->addPrintButton("suppliesbelongings/index/");
		$tableHtml = $table->view($belongingsArray, array("id" => "ID", "name" => CoreTranslator::Name($lang)));
		
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
		$belonging = array("id" => 0, "name" => "");
		if ($belongingId > 0){
			$belonging = $this->belongingModel->getInfo( $belongingId );
		}
		
		// lang
		$lang = $this->getLanguage();
	
		// form
		// build the form
		$form = new Form($this->request, "suppliesbelongings/edit");
		$form->setTitle(CoreTranslator::Edit_unit($lang));
		$form->addHidden("id", $belonging["id"]);
		$form->addText("name", CoreTranslator::Name($lang), true, $belonging["name"]);
		$form->setValidationButton(CoreTranslator::Ok($lang), "suppliesbelongings/edit");
		$form->setCancelButton(CoreTranslator::Cancel($lang), "suppliesbelongings");
		
		
		if ($form->check()){
			// run the database query
			$model = new SuBelonging();
			$model->set($form->getParameter("id"), $form->getParameter("name"));
			
			$this->redirect("suppliesbelongings");
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
		$this->redirect("suppliesbelongings");
	}
}