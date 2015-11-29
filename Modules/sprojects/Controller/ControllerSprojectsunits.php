<?php
require_once 'Framework/Controller.php';
require_once 'Framework/TableView.php';
require_once 'Framework/Form.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/sprojects/Model/SpUnit.php';
require_once 'Modules/sprojects/Model/SpBelonging.php';

/**
 * Manage the units (each user belongs to an unit)
 * 
 * @author sprigent
 *
 */
class ControllerSprojectsunits extends ControllerSecureNav {
	
	/**
	 * User model object
	 */
	private $unitModel;
	
	/**
	 * Constructor
	 */
	public function __construct() {
		$this->unitModel = new SpUnit ();
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
		$unitsArray = $this->unitModel->getUnits ( $sortentry );
		
		$table = new TableView();
		$table->ignoreEntry("id", 1);
		$table->setTitle(CoreTranslator::Units($lang));
		$table->addLineEditButton("suppliesunits/edit");
		$table->addDeleteButton("suppliesunits/delete");
		$table->addPrintButton("suppliesunits/index/");
		$tableHtml = $table->view($unitsArray, array("id" => "ID", "name" => CoreTranslator::Name($lang), "address" => CoreTranslator::Address($lang), "belonging" => CoreTranslator::Belonging($lang)));
		
		$print = $this->request->getParameterNoException("print");
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
	 * Edit an unit form
	 */
	public function edit() {
		$navBar = $this->navBar ();
		
		// get user id
		$unitId = 0;
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$unitId = $this->request->getParameter ( "actionid" );
		}
		
		// get belonging info
		$unit = array("id" => 0, "name" => "", "address" => "", "id_belonging" => 0 );
		if ($unitId > 0){
			$unit = $this->unitModel->getInfo( $unitId );
		}
		
		// belongings
		$modelBelonging = new SuBelonging();
		$belongingsid = $modelBelonging->getIds();
		$belongingsnames = $modelBelonging->getNames();
		
		// lang
		$lang = $this->getLanguage();

		// form
		// build the form
		$form = new Form($this->request, "suppliesunits/edit");
		$form->setTitle(CoreTranslator::Edit_belonging($lang));
		$form->addHidden("id", $unit["id"]);
		$form->addText("name", CoreTranslator::Name($lang), true, $unit["name"]);
		$form->addTextArea("address", CoreTranslator::Address($lang), false, $unit["address"]);
		$form->addSelect("id_belonging", CoreTranslator::Belonging($lang), $belongingsnames, $belongingsid, $unit["id_belonging"]);
		
		$form->setValidationButton(CoreTranslator::Ok($lang), "suppliesunits/edit");
		$form->setCancelButton(CoreTranslator::Cancel($lang), "suppliesunits");
		
		
		if ($form->check()){
			// run the database query
			$model = new SuUnit();
			$model->set($form->getParameter("id"), $form->getParameter("name"), 
					    $form->getParameter("address"), $form->getParameter("id_belonging"));
			
			$this->redirect("suppliesunits");
		}
		else{
			// set the view
			$formHtml = $form->getHtml();
			// view
			$navBar = $this->navBar();
			$this->generateView ( array (
					'navBar' => $navBar,
					'formHtml' => $formHtml
			) );
		}
	}

	/**
	 * Edit an unit to database
	 */
	public function editquery() {
		$navBar = $this->navBar ();
		
		// get form variables
		$id = $this->request->getParameter ( "id" );
		$name = $this->request->getParameter ( "name" );
		$address = $this->request->getParameter ( "address" );
		
		// get the user list
		$unitsArray = $this->unitModel->editUnit ( $id, $name, $address );
		
		$this->redirect ( "suppliesunits" );
	}
		
	/**
	 * Remove an unit query to database
	 */
	public function delete(){
	
		$unitId = $this->request->getParameter("actionid");
		$user = $this->unitModel->delete($unitId);
	
		// generate view
		$this->redirect("suppliesunits");
	}
}