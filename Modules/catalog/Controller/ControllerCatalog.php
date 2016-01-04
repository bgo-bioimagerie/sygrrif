<?php


require_once 'Framework/Controller.php';
require_once 'Framework/Form.php';

require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/catalog/Model/CaCategory.php';
require_once 'Modules/catalog/Model/CaEntry.php';		
		
class ControllerCatalog extends ControllerSecureNav {

	public function index() {
		
		$idCategory = 0;
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$idCategory = $this->request->getParameter ( "actionid" );
		}

		// get all the categories
		$modelCategory = new CaCategory();
		$categories = $modelCategory->getAll();
		
		// get the entries
		if ($idCategory == 0 && count($categories)>0){
			$idCategory = $categories[0]["id"];
		}
		
		$modelEntry = new CaEntry();
		$entries = $modelEntry->getCategoryEntries($idCategory);
		
		// view
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'categories' => $categories,
				'entries' => $entries,
				'lang' => $this->getLanguage()
		) );
	}
}