<?php

require_once 'Framework/Controller.php';
require_once 'Framework/Form.php';
require_once 'Framework/TableView.php';

require_once 'Modules/bioseapp/Model/BiProject.php';
require_once 'Modules/bioseapp/Model/BiProjectData.php';
require_once 'Modules/bioseapp/Model/BiTranslator.php';
require_once 'Modules/bioseapp/Model/BiRunInfo.php';
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
            
            // project info
            $id = $this->request->getParameterNoException ( "id" );
            if ($id==""){$id = 0;}
            $name = $this->request->getParameter ( "name" );
            $desc = $this->request->getParameter ( "description" );
            
            $modelProjects = new BiProject();
            $idProject = $modelProjects->set($id, $name, $desc, $_SESSION["id_user"]);
            
            // create project dir if not exists
            $projectDir = "data/bioseapp/proj_" . $idProject;
            if (!is_dir($projectDir)){
                mkdir($projectDir);
            }           
            // create main column if not exists
            $modelProjectData = new BiProjectData();
            $idMainColumn = $modelProjectData->createDataColumnIfNotExists($idProject);
            $modelProjectData->createDataSubColumnIfNotExists($idProject, $idMainColumn);
            
            // tags
            $tags_name = $this->request->getParameter ( "item_name");
            $tags_content = $this->request->getParameter ( "item_content");
            
            $modelProjectData->setProjectTags($idProject, $tags_name, $tags_content, $idMainColumn);
            
            $this->redirect("bioseproject", "import" . "/" . $idProject);
        }
        
        public function import(){
            
            // action
            $id = "";
            if ($this->request->isParameterNotEmpty ( 'actionid' )) {
            	$id = $this->request->getParameter ( "actionid" );
            }
            
            $lang = $this->getLanguage();
            
            // queries
            $headerInfo = array("curentTab" => "import", "projectId" => $id);
            
            $projectModel = new BiProjectData();
            $tags = $projectModel->tags($id);
            
            // view
            $navBar = $this->navBar();
            $this->generateView ( array (
                        	'navBar' => $navBar,
                                'headerInfo' => $headerInfo,  
                                'lang' => $lang,  
                                'tags' => $tags,
                                'id_proj' => $id    
            ) );
        }
        
        public function importquery(){
            
            // get request parameters
            $id_proj = $this->request->getParameter("id_proj");
            $dataList = $this->request->getParameter("selected_data");
            
            /*
            echo "id_proj = " . $id_proj . "<br/>";
            echo "data list = <br/>";
            print_r($dataList);
             */
            
            $modelProjectData = new BiProjectData();
            $tags = $modelProjectData->tags($id_proj);
            
            // get project Info
            // get the mainColumnID
            $id_main_col = $modelProjectData->getMainColumnId($id_proj);
            $id_sub_col = $modelProjectData->getSubColumnDataId($id_proj, $id_main_col);
            
            $line_idx = $modelProjectData->getLastLineIdx($id_proj);
            //echo "last line idx = " . $line_idx . "<br/>";    
            
            // import data
            //$line_idx = 0;
            foreach($dataList as $url){
                $line_idx++;
                $fullUrl = "data/storage/" . $_SESSION["login"] . "/" . $url;
                $thumbnail_url = ""; /// \todo create thumbnail
                $modelProjectData->addData($id_proj, $line_idx, $fullUrl, $thumbnail_url, $id_main_col, $id_sub_col);
            
                // add tags
                foreach($tags as $tag){
                    $url = $this->request->getParameter($tag["name"]);
                    $thumbnail_url = "";
                    $modelProjectData->addData($id_proj, $line_idx, $url, $thumbnail_url, $id_main_col, $tag["id"]);
                }
            }
            
            $this->redirect("bioseproject/data/".$id_proj);
        }
        
        public function data(){
            // action
            $id_proj = "";
            if ($this->request->isParameterNotEmpty ( 'actionid' )) {
            	$id_proj = $this->request->getParameter ( "actionid" );
            }
            
            // get the columns info
            $modelProjectData = new BiProjectData();
            $mainCols = $modelProjectData->getMainColumns($id_proj, true);
            $subCols = $modelProjectData->getSubColumns($id_proj);
            
            // get the data
            $lineIdxs = $modelProjectData->getProjectLineIdxs($id_proj);
            
            // header
            $headerInfo = array("curentTab" => "data", "projectId" => $id_proj);
            $lang = $this->getLanguage();
            // view
            $navBar = $this->navBar();
            $this->generateView ( array (
                        	'navBar' => $navBar,
                                'headerInfo' => $headerInfo,  
                                'lang' => $lang,  
                                'mainCols' => $mainCols,
                                'subCols' => $subCols,
                                'lineIdxs' => $lineIdxs,   
                                'id_proj' => $id_proj   
            ) );
        }
        
        public function process(){
            
                $this->openprocess();
        }
        
        public function openprocess(){
            // action
            $id_proj = "";
            if ($this->request->isParameterNotEmpty ( 'actionid' )) {
            	$id_proj = $this->request->getParameter ( "actionid" );
            }
            
            // get project info for the parameters bar
            $modelProjectData = new BiProjectData();
            $projColumns = $modelProjectData->getSubColumnsForProcess($id_proj);
            $projTagsColumns = $modelProjectData->getTagsForProcess($id_proj);
 
            //print_r($projColumns);
            
            // header
            $headerInfo = array("curentTab" => "process", "projectId" => $id_proj);
            $lang = $this->getLanguage();
            // view
            $navBar = $this->navBar();
            $this->generateView ( array (
                        	'navBar' => $navBar,
                                'headerInfo' => $headerInfo,  
                                'lang' => $lang,  
                                'id_proj' => $id_proj,
                                'projColumns' => $projColumns,
                                'projTagsColumns' => $projTagsColumns
                
            ), "openprocess" );
        }
        
        public function runprocess(){
            
            $id_proj = $this->request->getParameter ( "id_proj" );
            $processname = $this->request->getParameter ( "processname" );
            
            if($processname == "tophhatdetector"){
                
                // inputs
                $dataColId = $this->request->getParameter ( "inputimage" );
                $condition = $this->request->getParameter ( "condition" );
                if($condition != "all"){
                    $tagId = $condition;
                    $inputcondition = $this->request->getParameter ( "inputcondition" );
                }
                
                // parameters
                $smooth_radius = $this->request->getParameter ( "smooth_radius" );
                $tophat_radius = $this->request->getParameter ( "tophat_radius" );
                $threshold_method = $this->request->getParameter ( "threshold_method" );
               
                // create the Main column
                $modelProjectData = new BiProjectData();
                $mainColId = $modelProjectData->addMainColumn($id_proj, $processname);
                // create the sub columns
                $maskColumnId = $modelProjectData->addSubColumn($id_proj, "mask", $mainColId, "image");
                $floatColumnId = $modelProjectData->addSubColumn($id_proj, "count", $mainColId, "number");
                
                /// create the column dir
                $columnDir = "data/bioseapp/proj_" . $id_proj . "/col_" . $mainColId . "/";
                mkdir($columnDir);
                
                /// create the info file
                $processInfo = new BiRunInfo();
                $processInfo->addProcessInfo($processname, "1.0");
                $processInfo->addParameters(array("smooth_radius", "tophat_radius", "threshold_method"), 
                                            array($smooth_radius, $tophat_radius, $threshold_method));
                $processInfo->save($columnDir . "info.txt");
                
                /// copy data
                // 1- get the data image file name list
                $imagesList = $modelProjectData->getSubColumnsDataList($id_proj, $dataColId);
                
                // 2- add to database the result image
                foreach($imagesList as $data){
                    $dataArray = explode("/", $data["url"]);
                    $fileName = $dataArray[count($dataArray)-1];
                    if($threshold_method == "Default"){
                        $urlMaskOrigin = "/Users/sprigent/www/biose/sygrrif/data/precalcul/bad/".$fileName;
                    }
                    else{
                        $urlMaskOrigin = "/Users/sprigent/www/biose/sygrrif/data/precalcul/good/".$fileName;
                    }
                    $urlMask = "data/bioseapp/proj_". $id_proj . "/col_" . $mainColId . "/" . $fileName;
                    copy($urlMaskOrigin, $urlMask);
                    $urlfloat = file_get_contents($urlMaskOrigin . "_count.txt");
                    $thumbnail_url = "";        
                    $modelProjectData->addData($id_proj, $data["line_idx"], $urlMask, $thumbnail_url, $mainColId, $maskColumnId);
                    $modelProjectData->addData($id_proj, $data["line_idx"], $urlfloat, $thumbnail_url, $mainColId, $floatColumnId);
                }
                
            }
            
            $this->redirect("bioseproject/data/".$id_proj);
        }
}