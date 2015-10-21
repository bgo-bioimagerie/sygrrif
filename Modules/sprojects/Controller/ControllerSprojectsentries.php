<?php

require_once 'Framework/Controller.php';
require_once 'Framework/TableView.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/CoreTranslator.php';
require_once 'Modules/core/Model/Responsible.php';
require_once 'Modules/sprojects/Model/SpResponsible.php';
require_once 'Modules/sprojects/Model/SpItem.php';
require_once 'Modules/sprojects/Model/SpProject.php';

class ControllerSprojectsentries extends ControllerSecureNav {

	public function index($status = "all") {
		
		// get sort action
		$sortentry = "id";
		
		// get the user list
		$modelEntry = new SpProject();
		$entriesArray = array();
		if ($status == "all"){
			$entriesArray = $modelEntry->projects($sortentry);
			$_SESSION["sprojects_lastvisited"] = "opened";
		}
		else if ($status == "opened"){
			$entriesArray = $modelEntry->openedProjects($sortentry);
		}
		else if ($status == "closed"){
			$entriesArray = $modelEntry->closedProjects($sortentry);
		}
		
		$modelUser = "";
		$modelConfig = new CoreConfig();
		$sprojectsusersdatabase = $modelConfig->getParam ( "sprojectsusersdatabase" );
		if ($sprojectsusersdatabase == "local"){
			$modelUser = new SpUser();
		}
		else{
			$modelUser = new User();
		}
		
		for($i = 0 ; $i < count($entriesArray) ; $i++){
			$entriesArray[$i]["resp_name"] = $modelUser->getUserFUllName($entriesArray[$i]["id_resp"]);
			$entriesArray[$i]["user_name"] = $modelUser->getUserFUllName($entriesArray[$i]["id_user"]);
			if ($entriesArray[$i]["id_status"] == 1){
				$entriesArray[$i]["id_status"] = "Open";
			}
			else{
				$entriesArray[$i]["id_status"] = "Closed";
			}
		}
		
		$table = new TableView();
		$table->setTitle("Projects");
		$table->addLineEditButton("sprojectsentries/editentries");
		$table->addDeleteButton("sprojectsentries/deleteentries");
		$table->addPrintButton("sprojectsentries/index/");
		$tableHtml = $table->view($entriesArray, array("id" => "ID", "resp_name" => "Responsable", "name" => "No Projet", "user_name" => "Utilisateur", "id_status" => "status" , "date_open" => "Date ouverture", "date_close" => "Date cloture"));
		
		$print = $this->request->getParameterNoException("print");
		
		//echo "print = " . $print . "<br/>";
		if ($table->isPrint()){
			echo $tableHtml;
			return;
		}
		
		// view
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'table' => $tableHtml
		), "index");
	}
	
	public function openedentries() {
	
		$_SESSION["sprojects_lastvisited"] = "opened";
		$this->index("opened");
	}
	
	public function closedentries() {

		$_SESSION["sprojects_lastvisited"] = "closed";
		$this->index("closed");
	}
	
	public function deleteentries(){
		$id = 0;
		if ($this->request->isParameterNotEmpty('actionid')){
			$id = $this->request->getParameter("actionid");	
		}
		
		$model = new SpProject();
		$model->delete($id);
		
		$lastVisited = "all";
		if (isset($_SESSION["sprojects_lastvisited"])){
			$lastVisited = $_SESSION["sprojects_lastvisited"];
		}
		$this->index($lastVisited);
	}
	public function editentries(){
		
		// get sort action
		$idproject = "";
		if ($this->request->isParameterNotEmpty('actionid')){
			$idproject = $this->request->getParameter("actionid");
		}
		
		$project = array();
		$modelProject = new SpProject();
		if ($idproject == ""){
			$project = $modelProject->defaultProjectValues();
		}
		else{
			$project = $modelProject->getProject($idproject);
		}
		
		// get project entries
		$projectEntries = $modelProject->getProjectEntries($idproject);
		
		// get active items
		$modelItem = new SpItem();
		$activeItems = $modelItem->getActiveItems("display_order");
		
		// add unactive items that were ordered at the order time
		foreach ($projectEntries as $entry){
			$items_ids = $entry["content"]["items_ids"];
			//print_r($entry["content"]);
			foreach($items_ids as $itemID){
				$found = false;
				foreach ($activeItems as $item){
					if ($item["id"] == $itemID){
						$found = true;
					}
				}
				if ($found == false){
					$inter = $modelItem->getItem($itemID);
					$activeItems[] = $inter;
				}
			}
		}
		
		
		//print_r($itemsOrder);
		$modelConfig = new CoreConfig();
		$sprojectsusersdatabase = $modelConfig->getParam("sprojectsusersdatabase");
		$users = array();
		$resps = array();
		if ($sprojectsusersdatabase == "local"){
			$modelUser = new SpUser();
			$users = $modelUser->getUsersSummary("name");
			$modelResp = new SpResponsible();
			$resps = $modelResp->responsibleSummaries("name");
			
		}
		else{
			$modelUser = new User();
			$users = $modelUser->getUsersSummary("name");
			$modelResp = new Responsible();
			$resps = $modelResp->responsibleSummaries("name");
		}
		
		//print_r($projectEntries);
		
		// view
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'projectEntries' => $projectEntries,
				'items' => $activeItems,
				'users' => $users,
				'project' => $project,
				'responsibles' => $resps
		) );
	}
	
	public function editquery(){
		
		// Lang
		$lang = "En";
		if (isset($_SESSION["user_settings"]["language"])){
			$lang = $_SESSION["user_settings"]["language"];
		}
		
		// get form content
		$id = $this->request->getParameterNoException("id");
		$name = $this->request->getParameterNoException("name");
		$id_resp = $this->request->getParameter("id_resp");
		$id_user = $this->request->getParameter("id_user"); 
		$id_status = $this->request->getParameter("id_status"); 
		$date_open = $this->request->getParameter("date_open");
		$date_close = $this->request->getParameter("date_close");
		
		//print_r($id);
		//echo "id = " . $id . "<br/>"; 
		
		if ($date_open != ""){
			$date_open = CoreTranslator::dateToEn($date_open, $lang);
		}
		if ($date_close != ""){
			$date_close = CoreTranslator::dateToEn($date_close, $lang);
		}
		
		$modelProject = new SpProject();
		$id_project = $modelProject->setProject($id, $name, $id_resp, $id_user, $id_status, $date_open, $date_close);
		//echo "id_project = " . $id_project . "<br/>";
		// get items content
		$item_id = $this->request->getParameterNoException("item_id");
		$item_date = $this->request->getParameterNoException("item_date");
		
		
		
		
		// remove the items that are in the database but not in the request
		$databaseItemsIds = $modelProject->getProjectEntriesItemsIds($id_project);
		foreach ($databaseItemsIds as $dbID){
				
			$found = false;
			for( $i = 0 ; $i < count($item_id) ; $i++){
				if ($dbID["id"] == $item_id[$i]){
					$found = true;
					break;
				}
			}
			if (!$found){
				$modelProject->deleteProjectItem($dbID["id"]);
			}
		}
		
		// add/update items
		$modelItem = new SpItem();
		$activeItems = $modelItem->getActiveItems();
		for( $i = 0 ; $i < count($item_id) ; $i++){
			
			$content = "";
			foreach ($activeItems as $activeItem){
				$curentitem = $this->request->getParameterNoException("item_" . $activeItem['id']);
				//print_r($curentitem); echo "<br/>";
				//if ($curentitem[$i] != ""){
					$content .= $activeItem['id'] . "=" . $curentitem[$i] . ";";
				//}
			}
			//echo "content = " . $content . "<br/>";
			//echo "id = " . $item_id[$i] . "<br/>";
			$modelProject->setProjectEntry($item_id[$i], $id_project, CoreTranslator::dateToEn($item_date[$i], $lang), $content);
		}
		
		$this->redirect("sprojectsentries");
	}
	
	/**
	 * Remove an unit form confirm
	 */
	public function delete(){
	
		$unitId = 0;
		if ($this->request->isParameterNotEmpty('actionid')){
			$unitId = $this->request->getParameter("actionid");
		};
	
		// generate view
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'entryID' => $unitId
		) );
	}
	
	/**
	 * Remove an unit query to database
	 */
	public function deletequery(){
	
		$unitId = $this->request->getParameter("id");
		
		$modelEntry = new SpEntry();
		$modelEntry->delete($unitId);
	
		// generate view
		$this->redirect("sprojectsentries");
	}
	
	public function generateBill(){
		$projectId = 0;
		if ($this->request->isParameterNotEmpty('actionid')){
			$projectId = $this->request->getParameter("actionid");
		};
		
		$modelBill = new SpBillGenerator();
		$modelBill->generateBill($id_project);
	}
}