<?php
require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/sheet/Model/ShTemplate.php';

class ControllerShtemplates extends ControllerSecureNav {

	//private $billet;
	public function __construct() {
		//$this->billet = new Billet ();
	}

	// Affiche la liste de tous les billets du blog
	public function index() {

		$navBar = $this->navBar();
		
		$modelTemplates = new ShTemplate();
		$templates = $modelTemplates->getTemplates("name");

		$this->generateView ( array (
				'navBar' => $navBar, 'templates' => $templates
		) );
	}

	public function edit(){
		
		$templateID = 0;
		if ($this->request->isParameterNotEmpty('actionid')){
			$templateID = $this->request->getParameter("actionid");
		}
	
		$modelTemplate = new ShTemplate();
		$itemstypes = $modelTemplate->getElementTypes();
		
		$items = array();
		$name = "";
		if ($templateID > 0){
			$items = $modelTemplate->getTemplateElements($templateID);
			$name = $modelTemplate->getTemplateName($templateID);
		}
	
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar, "itemstypes" => $itemstypes, "items" => $items, "id" => $templateID, "name" => $name
		) );
	
	}
	
	public function editquery(){
		
		$id_template = $this->request->getParameterNoException("id");
		$name = $this->request->getParameter("name");
		
		// add the template if not exists
		$modelTemplate = new ShTemplate();
		if ($id_template == "" || $id_template == 0){
			$id_template = $modelTemplate->addTemplate($name);
		}
		else{
			$modelTemplate->editTemplate($id_template, $name);
		}
		
		// remove all the existing items
		//$modelTemplate->removeTemplateItems($id_template);
		
		// add items
		$id_element = $this->request->getParameter("id_element");
		$id_element_type = $this->request->getParameter("id_element_type");
		$caption = $this->request->getParameter("caption"); 
		$default_values = $this->request->getParameter("default_values");
		$display_order = $this->request->getParameter("display_order"); 
		$mandatory = $this->request->getParameter("mandatory");
		$who_can_modify = $this->request->getParameter("who_can_modify"); 
		$who_can_see  = $this->request->getParameter("who_can_see");
		$add_to_summary  = $this->request->getParameter("add_to_summary");
		
		for($i = 0 ; $i < count($id_element_type) ; $i++){
			if ($id_element[$i] != "" && $id_element[$i] > 0){
				$modelTemplate->editTemplateElement($id_element[$i], $id_template, $id_element_type[$i], $caption[$i], $default_values[$i],
						$display_order[$i], $mandatory[$i], $who_can_modify[$i], $who_can_see[$i],
						$add_to_summary[$i]);
			}
			else{
				$modelTemplate->addTemplateElement($id_template, $id_element_type[$i], $caption[$i], $default_values[$i],
						$display_order[$i], $mandatory[$i], $who_can_modify[$i], $who_can_see[$i],
						$add_to_summary[$i]);
			}
		}
		
		$this->redirect("shtemplates");
	}
}