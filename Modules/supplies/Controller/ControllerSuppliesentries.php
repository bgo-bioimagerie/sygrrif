<?php

require_once 'Framework/Controller.php';
require_once 'Framework/TableView.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/CoreTranslator.php';
require_once 'Modules/supplies/Model/SuTranslator.php';
require_once 'Modules/supplies/Model/SuEntry.php';
require_once 'Modules/supplies/Model/SuItem.php';

class ControllerSuppliesentries extends ControllerSecureNav {

	public function index($status = "") {
		
		// get sort action
		$sortentry = "id";
		$lang = $this->getLanguage();
		
		// get the commands list
		$modelEntry = new SuEntry();
		$entriesArray = array();
		if ($status == ""){
			if (isset($_SESSION["supplies_lastvisited"])){
				$status = $_SESSION["supplies_lastvisited"];
			}
			else{
				$status = "all";
			}
		}
		
		if ($status == "all"){
			$entriesArray = $modelEntry->entries($sortentry);
		}
		else if ($status == "opened"){
			$entriesArray = $modelEntry->openedEntries($sortentry);
		}
		else if ($status == "closed"){
			$entriesArray = $modelEntry->closedEntries($sortentry);
		}
		
		$table = new TableView();
		$table->setTitle(SuTranslator::Supplies_Orders($lang));
		$table->addLineEditButton("suppliesentries/editentries");
		$table->addDeleteButton("suppliesentries/delete", "id", "id");
		$table->addPrintButton("suppliesentries/index/");
		$table->addExportButton("suppliesentries/index/");
		
		$headersArray = array(
				"no_identification" => SuTranslator::No_identification($lang), 
				"user_name" => CoreTranslator::User($lang), 
				"id_status" => CoreTranslator::Status($lang), 
				"date_open" => SuTranslator::Opened_date($lang),
				"date_close" => SuTranslator::Closed_date($lang),
				"date_last_modified" => SuTranslator::Last_modified_date($lang),
				);
				
				
		for($i = 0 ; $i < count($entriesArray) ; $i++){
			if ($entriesArray[$i]["id_status"]){
				$entriesArray[$i]["id_status"] = SuTranslator::Open($lang);
			}
			else{
				$entriesArray[$i]["id_status"] = SuTranslator::Closed($lang);
			}
			$entriesArray[$i]["date_open"] = CoreTranslator::dateFromEn($entriesArray[$i]["date_open"], $lang);
			$entriesArray[$i]["date_close"] = CoreTranslator::dateFromEn($entriesArray[$i]["date_close"], $lang);
			$entriesArray[$i]["date_last_modified"] = CoreTranslator::dateFromEn($entriesArray[$i]["date_last_modified"], $lang);
		}
		$tableHtml = $table->view($entriesArray, $headersArray);
		
		if ($table->isPrint()){
			echo $tableHtml;
			return;
		}
		if ($table->isExport()){
			echo $table->exportCsv($entriesArray, $headersArray);
			return;
		}
			
		// view
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'tableHtml' => $tableHtml
		) , "index");
	}
	
	public function openedentries() {
	
		$_SESSION["supplies_lastvisited"] = "opened";
		$this->index("opened");
	}
	
	public function closedentries() {
	
		$_SESSION["supplies_lastvisited"] = "closed";
		$this->index("closed");
	}
	
	public function allentries() {
	
		$_SESSION["supplies_lastvisited"] = "all";
		$this->index("all");
	}
	
	public function editentries(){
		
		// get sort action
		$identry = "";
		if ($this->request->isParameterNotEmpty('actionid')){
			$identry = $this->request->getParameter("actionid");
		}
		
		$entry = array();
		$modelEntry = new SuEntry();
		if ($identry == ""){
			$entry = $modelEntry->defaultEntryValues();
		}
		else{
			$entry = $modelEntry->getEntry($identry);
		}
		
		$modelItem = new SuItem();
		// parse content
		$content = $entry["content"];
		$contentArray = explode(";", $content);
		$itemsOrderC = array();
		for ($i = 0 ; $i < count($contentArray) ; $i++){
			$val = explode("=", $contentArray[$i]);
			if (count($val) > 1){
                            if ($modelItem->getItemName($val[0]) != ""){
				$itemsOrderC[$i]['id'] = $val[0];
				$itemsOrderC[$i]['quantity'] = $val[1];
				$itemsOrderC[$i]['name'] = $modelItem->getItemName($val[0]);
                            }
			}
		}
		
		// add active items 
		$activeItems = $modelItem->getActiveItems();
		$itemsOrderA = array();
		 
		$index = -1;
		foreach ($activeItems as $activeItem ){
			// test if not exists
			$alreadyFounded = false;
			foreach($itemsOrderC as $itemo){
				if ($itemo["id"] == $activeItem["id"]){
					$alreadyFounded = true;
					break;
				}
			}
			if ($alreadyFounded == false){
				$index++;
				$itemsOrderA[$index]['id'] = $activeItem["id"];
				$itemsOrderA[$index]['quantity'] = 0;
				$itemsOrderA[$index]['name'] = $activeItem["name"];
			}
		}
		
		$itemsOrder = array_merge($itemsOrderA, $itemsOrderC);
		
		//print_r($itemsOrder);
		$modelConfig = new CoreConfig();
		$supliesusersdatabase = $modelConfig->getParam("supliesusersdatabase");
		$users = array();
		if ($supliesusersdatabase == "local"){
			$modelUser = new SuUser();
			$users = $modelUser->getUsersSummary();
		}
		else{
			$modelUser = new CoreUser();
			$users = $modelUser->getUsersSummary();
		}
		
		// view
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'entry' => $entry,
				'itemsOrder' => $itemsOrder,
				'users' => $users
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
		$id_user = $this->request->getParameter("id_user"); 
		$id_status = $this->request->getParameter("id_status"); 
		$date_open = $this->request->getParameter("date_open");
		$date_close = $this->request->getParameter("date_close");
		$date_last_modified = $this->request->getParameter("date_last_modified"); 
                $no_identification = $this->request->getParameter("no_identification");
		
		if ($date_open != ""){
			$date_open = CoreTranslator::dateToEn($date_open, $lang);
		}
		if ($date_close != ""){
			$date_close = CoreTranslator::dateToEn($date_close, $lang);
		}
		if ($date_last_modified != ""){
			$date_last_modified = CoreTranslator::dateToEn($date_last_modified, $lang);
		}
		
		// get items content
		$modelItem = new SuItem();
		$allItems = $modelItem->getItems();
		$content = "";
		foreach($allItems as $item){
			$itemID = $item["id"];
			$value = $this->request->getParameterNoException("item_" . $itemID);
			if ($value != ""){
				$content .= $itemID . "=" . $value . ";";
			}
		}
		
		$modelEntry = new SuEntry();
		if ($id == ""){
			$modelEntry->addEntry($id_user, $no_identification, $content, $id_status, $date_open);
		}
		else{
			$date_last_modified = date("Y-m-d", time());
			$modelEntry->updateEntry($id, $id_user, $no_identification, $content, $id_status, $date_open, $date_last_modified,$date_close);
		}
		
		$this->redirect("suppliesentries");
	}
	
	/**
	 * Remove an entry query to database
	 */
	public function delete(){
	
		$id = $this->request->getParameter("actionid");
		
		$modelEntry = new SuEntry();
		$modelEntry->delete($id);
	
		// generate view
		$this->redirect("suppliesentries");
	}
}