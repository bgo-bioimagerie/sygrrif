<?php

require_once 'Framework/Controller.php';
require_once 'Framework/Form.php';
require_once 'Framework/TableView.php';

require_once 'Modules/bioseapp/Model/BiProject.php';
require_once 'Modules/bioseapp/Model/BiProjectData.php';
require_once 'Modules/bioseapp/Model/BiTranslator.php';
require_once 'Modules/core/Model/CoreTranslator.php';

require_once 'Modules/core/Controller/ControllerSecureNav.php';

class ControllerBioseproject extends ControllerSecureNav {

	public function index() {
		
                $headerInfo = "";
                
                // view
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'headerInfo' => $headerInfo
		) );
	}
        
        public function info(){
            
            // action
            $id = "";
            if ($this->request->isParameterNotEmpty ( 'actionid' )) {
            	$id = $this->request->getParameter ( "actionid" );
            }
            
            //echo "id = " . $id . "</br>"; 
            $lang = $this->getLanguage();
            
            // queries
            $headerInfo = array("curentTab" => "info", "projectId" => $id);
            
            $projectModel = new BiProjectData();
            if ($id == ""){
                $project = $projectModel->getDefaultInfo();
            }
            else{
                $project = $projectModel->getInfo($id);
                //"echo project info = ";
                //print_r($project);
                //echo "<br/>";
            }
            
            if ($id == ""){
                $tags = array();
            }
            else{
                $tags = $projectModel->tags($id);
            }
            
            // view
            $navBar = $this->navBar();
            $this->generateView ( array (
                        	'navBar' => $navBar,
				'headerInfo' => $headerInfo,
                                'project' => $project,
                                'lang' => $lang,
                                'tags' => $tags    
            ) );
        }
        
        public function infoquery(){
            
            // roject info
            $id = $this->request->getParameterNoException ( "id" );
            if ($id==""){$id = 0;}
            $name = $this->request->getParameter ( "name" );
            $desc = $this->request->getParameter ( "description" );
            
            $modelProjects = new BiProject();
            $idProject = $modelProjects->set($id, $name, $desc, $_SESSION["id_user"]);
            
            // tags
            $tags_name = $this->request->getParameter ( "item_name");
            $tags_content = $this->request->getParameter ( "item_content");
            
            $modelProjectData = new BiProjectData();
            $modelProjectData->setProjectTags($idProject, $tags_name, $tags_content);
        }
        

}