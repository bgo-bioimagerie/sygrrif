<?php


require_once 'Framework/Controller.php';
require_once 'Framework/Form.php';
require_once 'Framework/TableView.php';

require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/catalog/Model/CaCategory.php';
require_once 'Modules/catalog/Model/CaEntry.php';
require_once 'Modules/catalog/Model/CaTranslator.php';

require_once 'Modules/anticorps/Model/Status.php';
require_once 'Modules/anticorps/Model/Anticorps.php';
		
class ControllerCatalog extends ControllerSecureNav {

	public function index() {
	
                $lang = $this->getLanguage();
            
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
                
                $modelCoreConfig = new CoreConfig();
            
                $useAntibodies = $modelCoreConfig->getParam("ca_use_antibodies");
                if ($useAntibodies == 1){
                    $categories[count($categories)]["id"] = -12;  
                    $categories[count($categories)-1]["name"] = CaTranslator::Antibodies($lang);
                }
		
                if($idCategory == -12 || ( $idCategory == 0 && $categories[0]["id"] == -12)){
                    $this->antibodies($categories);
                    return;
                }
		// view
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'categories' => $categories,
				'entries' => $entries,
				'lang' => $this->getLanguage(),
                                'activeCategory' => $idCategory   
		) );
	}
        
        public function antibodies($categories){
            
            $lang = $this->getLanguage();
            
            $modelAntibody = new Anticorps();
            $entries = $modelAntibody->getAnticorpsInfoCatalog();
           
            $statusModel = new Status();
            $status = $statusModel->getStatus();
            //print_r();
            
            // view
            $navBar = $this->navBar();
            $this->generateView ( array (
			'navBar' => $navBar,
			'categories' => $categories,
			'entries' => $entries,
			'lang' => $lang,
                        'activeCategory' => -12,
                        'status' => $status
		), "antibodies" );
        }
}