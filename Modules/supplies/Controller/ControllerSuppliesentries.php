<?php


require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/CoreTranslator.php';
require_once 'Modules/supplies/Model/SuEntry.php';
require_once 'Modules/supplies/Model/SuItem.php';

class ControllerSuppliesentries extends ControllerSecureNav {

	public function index() {
		
		// get sort action
		$sortentry = "id";
		if ($this->request->isParameterNotEmpty('actionid')){
			$sortentry = $this->request->getParameter("actionid");
		}
		
		// get the user list
		$modelEntry = new SuEntry();
		$entriesArray = $modelEntry->entries($sortentry);
		
		// view
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'entriesArray' => $entriesArray
		) );
	}
	
	public function openedentries() {
	
		// get sort action
		$sortentry = "id";
		if ($this->request->isParameterNotEmpty('actionid')){
			$sortentry = $this->request->getParameter("actionid");
		}
	
		// get the user list
		$modelEntry = new SuEntry();
		$entriesArray = $modelEntry->openedEntries($sortentry);
	
		// view
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'entriesArray' => $entriesArray
		), "index" );
	}
	
	public function closedentries() {
	
		// get sort action
		$sortentry = "id";
		if ($this->request->isParameterNotEmpty('actionid')){
			$sortentry = $this->request->getParameter("actionid");
		}
	
		// get the user list
		$modelEntry = new SuEntry();
		$entriesArray = $modelEntry->closedEntries($sortentry, 0);
	
		// view
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'entriesArray' => $entriesArray
		), "index" );
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
				$itemsOrderC[$i]['id'] = $val[0];
				$itemsOrderC[$i]['quantity'] = $val[1];
				$itemsOrderC[$i]['name'] = $modelItem->getItemName($val[0]);
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
		
		$modelUser = new SuUser();
		$users = $modelUser->getUsersSummary();
		
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
			$modelEntry->addEntry($id_user, $content, $id_status, $date_open);
		}
		else{
			$date_last_modified = date("Y-m-d", time());
			$modelEntry->updateEntry($id, $id_user, $content, $id_status, $date_open, $date_last_modified,$date_close);
		}
		
		$this->redirect("suppliesentries");
	}
	
}