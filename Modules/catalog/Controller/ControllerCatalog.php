<?php


require_once 'Framework/Controller.php';
require_once 'Framework/Form.php';
require_once 'Framework/TableView.php';

require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/catalog/Model/CaCategory.php';
require_once 'Modules/catalog/Model/CaEntry.php';
require_once 'Modules/catalog/Model/CaAntibodyEntry.php';
require_once 'Modules/catalog/Model/CaTranslator.php';
		
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
				'lang' => $this->getLanguage()
		) );
	}
        
        public function antibodies($categories){
            
            $lang = $this->getLanguage();
            
            $modelAntibody = new CaAntibodyEntry();
            $entries = $modelAntibody->getAllInfo();
            
            /*
            $table = new TableView();
            $tableHtml = $table->view($entries, array("no_h2p2" => "No", 
                                                            "nom" => CaTranslator::Name($lang), 
							    "fournisseur" => CaTranslator::Provider($lang), 
						            "reference" => CaTranslator::Reference($lang),
                                                            "especes" => CaTranslator::Spices($lang),
                                                            "comment" => CaTranslator::Comment($lang)
		));
            */
            // view
            $navBar = $this->navBar();
            $this->generateView ( array (
			'navBar' => $navBar,
			'categories' => $categories,
			'entries' => $entries,
			'lang' => $this->getLanguage()
		), "antibodies" );
        }
}