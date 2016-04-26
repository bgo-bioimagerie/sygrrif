<?php
require_once 'Framework/Controller.php';
require_once 'Framework/TableView.php';
require_once 'Framework/Form.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/CoreSite.php';

/**
 * Manage the units (each user belongs to an unit)
 * 
 * @author sprigent
 *
 */
class ControllerCoresites extends ControllerSecureNav {
	
	/**
	 * User model object
	 */
	private $siteModel;
	
	/**
	 * Constructor
	 */
	public function __construct() {
            parent::__construct();
            $this->siteModel = new CoreSite ();
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
		$unitsArray = $this->siteModel->getAll ( $sortentry );
		
		$table = new TableView();
		$table->ignoreEntry("id", 1);
		$table->setTitle(CoreTranslator::Sites($lang));
		$table->addLineEditButton("coresites/edit");
		$table->addDeleteButton("coresites/delete");
		$table->addPrintButton("coresites/index/");
		$tableHtml = $table->view($unitsArray, array("id" => "ID", "name" => CoreTranslator::Name($lang)));
		
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
		$id = 0;
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$id = $this->request->getParameter ( "actionid" );
		}
		
		// get belonging info
		$site = array("id" => 0, "name" => "");
		if ($id > 0){
			$site = $this->siteModel->get( $id );
		}
		
                // lang
		$lang = $this->getLanguage();

		// form
		// build the form
		$form = new Form($this->request, "coresites/edit");
		$form->setTitle(CoreTranslator::Edit_Site($lang));
		$form->addHidden("id", $site["id"]);
		$form->addText("name", CoreTranslator::Name($lang), true, $site["name"]);
		
		$form->setValidationButton(CoreTranslator::Ok($lang), "coresites/edit");
		$form->setCancelButton(CoreTranslator::Cancel($lang), "coresites");
		
		if ($form->check()){
			// run the database query
			$model = new CoreSite();
			$model->set($form->getParameter("id"), $form->getParameter("name"));
			$this->redirect("coresites");
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
	 * Remove an unit query to database
	 */
	public function delete(){
	
		$unitId = $this->request->getParameter("actionid");
		$this->siteModel->delete($unitId);
	
		// generate view
		$this->redirect("coresites");
	}
}