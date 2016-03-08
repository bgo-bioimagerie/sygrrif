<?php

require_once 'Framework/Controller.php';
require_once 'Framework/Form.php';
require_once 'Framework/TableView.php';

require_once 'Modules/bioseapp/Model/BiProject.php';
require_once 'Modules/bioseapp/Model/BiTranslator.php';
require_once 'Modules/core/Model/CoreTranslator.php';

require_once 'Modules/core/Controller/ControllerSecureNav.php';

class ControllerBioseprojects extends ControllerSecureNav {

	public function index() {
		
                // query
                $modelProject = new BiProject();
                $projectsArray = $modelProject->all();
                if (count($projectsArray) > 0){
                    $modelUser = new CoreUser();
                    for($i = 0 ; $i < count($projectsArray) ; $i++){
                        $projectsArray[$i]["owner"] = $modelUser->getUserFUllName($projectsArray[$i]["id_owner"]);
                       
                    }

                    // table view
                    $lang = $this->getLanguage();
                    $table = new TableView();
                    $table->setTitle(BiTranslator::Projects($lang));
                    $table->addLineEditButton("bioseproject/info");
                    $table->addDeleteButton("bioseprojects/delete");
                    $tableHtml = $table->view($projectsArray, array("id" => "ID", 
                                                                 "name" => CoreTranslator::Name($lang),
                                                                 "owner" => BiTranslator::Owner($lang)
                                                                         ));
                }
                else{
                    $tableHtml = "";
                }
                // view
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'tableHtml' => $tableHtml
		) );
	}
        
        public function delete(){
            
            $id = "";
            if ($this->request->isParameterNotEmpty ( 'actionid' )) {
            	$id = $this->request->getParameter ( "actionid" );
            }
            
            $modelProject = new BiProject();
            $modelProject->delete($id);
            
            $this->redirect("bioseprojects");
        }
}