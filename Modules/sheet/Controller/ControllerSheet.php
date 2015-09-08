<?php
require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/sheet/Model/ShTemplate.php';
require_once 'Modules/sheet/Model/ShSheet.php';

class ControllerSheet extends ControllerSecureNav {

    /**
     * Constructor
     */
	public function __construct() {

	}

	/**
	 * (non-PHPdoc)
	 * @see Controller::index()
	 */
	public function index() {

		$navBar = $this->navBar();

		$this->generateView ( array (
				'navBar' => $navBar
		) );
	}
	
	
	/**
	 * Add a new sheet using a template ID in the request
	 */
	public function listsheet() {
	
		$templateID = 0;
		if ($this->request->isParameterNotEmpty('actionid')){
			$templateID = $this->request->getParameter("actionid");
		}
	
		$modelTemplate = new ShTemplate();
		$templateName = $modelTemplate->getTemplateName($templateID);
		
		$modelSheet = new ShSheet();
		$sheets = $modelSheet->getSheets($templateID);
	
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar, 'sheets' => $sheets, 'templateID' => $templateID, 'templateName' => $templateName
		), "listsheet" );
	}
	
	/**
	 * Add a new sheet using a template ID in the request
	 */
	public function add() {
	
		$templateID = 0;
		if ($this->request->isParameterNotEmpty('actionid')){
			$templateID = $this->request->getParameter("actionid");
		}
		
		echo "template ID = " . $templateID;
		
		$modelTemplate = new ShTemplate();
		$elements = $modelTemplate->getTemplateElements($templateID);
		
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar, 'elements' => $elements, 'templateID' => $templateID 
		), "edit" );
	}
	
	public function edit(){
		
		$sheetID = 0;
		if ($this->request->isParameterNotEmpty('actionid')){
			$sheetID = $this->request->getParameter("actionid");
		}
		
		$modelSheet = new ShSheet();
		$sheetInfos = $modelSheet->getSheetElements($sheetID);
		
		$modelTemplate = new ShTemplate();
		$elements = $modelTemplate->getTemplateElements($sheetInfos["id_template"]);
		
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar, 'elements' => $elements, 'templateID' => $sheetInfos["id_template"], "sheet_id" => $sheetID, "sheetInfos" => $sheetInfos
		), "edit" );
	}
	
	public function editquery(){
		
		// get the template from form
		$id_template = $this->request->getParameter("id_template");
		$id_sheet = $this->request->getParameterNoException("id_sheet");
		
		echo "sheet id = " . $id_sheet;
		
		$modelSheet = new ShSheet();
		if ($id_sheet == "" || $id_sheet == 0){
			$id_sheet = $modelSheet->addSheet($id_template, date("Y-m-d"), date("Y-m-d"), "open");
		}
		
		// delete all the sheet elements
		$modelSheet->removeSheetElements($id_sheet);
		
		// get the elements for the template
		$modelTemplate = new ShTemplate();
		$elements = $modelTemplate->getTemplateElements($id_template);
		foreach($elements as $element){
			$elementVal = $this->request->getParameter("id".$element["id"]);
			$modelSheet->addSheetElement($element["id"], $elementVal, $id_sheet);
		}
		
		$this->redirect("sheet", "listsheet/" . $id_template);
	}
	
	/**
	 * Remove an unit form confirm
	 */
	public function delete(){
	
		$id_sheet = 0;
		if ($this->request->isParameterNotEmpty('actionid')){
			$id_sheet = $this->request->getParameter("actionid");
		};
	
		// generate view
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'id_sheet' => $id_sheet
		) );
	}
	
	/**
	 * Remove an unit query to database
	 */
	public function deletequery(){
	
		
		$sheetID = $this->request->getParameter("id");
		
		$modelSheet = new ShSheet();
		$modelSheet->delete($sheetID);
	
		// generate view
		$this->redirect("sheet");
	}
}