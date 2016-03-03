<?php

require_once 'Framework/Controller.php';
require_once 'Framework/TableView.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/CoreTranslator.php';
require_once 'Modules/core/Model/CoreResponsible.php';
require_once 'Modules/core/Model/CoreUser.php';
require_once 'Modules/core/Model/CoreUnit.php';
require_once 'Modules/core/Model/CoreBelonging.php';
require_once 'Modules/sprojects/Model/SpResponsible.php';
require_once 'Modules/sprojects/Model/SpItem.php';
require_once 'Modules/sprojects/Model/SpProject.php';
require_once 'Modules/sprojects/Model/SpTranslator.php';
require_once 'Modules/sprojects/Model/SpItemPricing.php';
require_once 'Modules/sprojects/Model/SpBillGenerator.php';

class ControllerSprojectsentries extends ControllerSecureNav {

	public function index($status = "") {
		
		$lang = $this->getLanguage();
		
		// get sort action
		$sortentry = "id";
		
		// get the user list
		$modelEntry = new SpProject();
		$entriesArray = array();
		if ($status == ""){
			if (isset($_SESSION["sprojects_lastvisited"])){
				$status = $_SESSION["sprojects_lastvisited"];
			}
			else{
				$status = "all";
			}
		}
		
		if ($status == "all"){
			$title = SpTranslator::All_orders($lang);
			$entriesArray = $modelEntry->projects($sortentry);
		}
		else if ($status == "opened"){
			$title = SpTranslator::Opened_orders($lang);
			$entriesArray = $modelEntry->openedProjects($sortentry);
		}
		else if ($status == "closed"){
			$title = SpTranslator::Closed_orders($lang);
			$entriesArray = $modelEntry->closedProjects($sortentry);
		}
		
		$modelUser = "";
		$modelUnit = "";
		$modelBelonging = "";
		$modelConfig = new CoreConfig();
		$sprojectsusersdatabase = $modelConfig->getParam ( "sprojectsusersdatabase" );
		if ($sprojectsusersdatabase == "local"){
			$modelUser = new SpUser();
			$modelUnit = new SpUnit();
			$modelBelonging = new SpBeloning();
		}
		else{
			$modelUser = new CoreUser();
			$modelUnit = new CoreUnit();
			$modelBelonging = new CoreBelonging();
		}
		
		for($i = 0 ; $i < count($entriesArray) ; $i++){
			$entriesArray[$i]["resp_name"] = $modelUser->getUserFUllName($entriesArray[$i]["id_resp"]);
			$entriesArray[$i]["user_name"] = $modelUser->getUserFUllName($entriesArray[$i]["id_user"]);
			
			
			// get the pricing color
			$id_unit = $modelUser->getUserUnit($entriesArray[$i]["id_resp"]);
			$id_belonging = $modelUnit->getBelonging($id_unit);
			$pricingInfo = $modelBelonging->getInfo($id_belonging);
			$entriesArray[$i]["color"] = $pricingInfo["color"];
			
			$entriesArray[$i]["time_color"] = "#ffffff";
			if ($entriesArray[$i]["time_limit"] != ""){
				
				if (strval($entriesArray[$i]["time_limit"]) != "0000-00-00"){
					$entriesArray[$i]["time_color"] = "#FFCC00";
				}
			}
			
			
			$entriesArray[$i]["closed_color"] = "#ffffff";
			if ($entriesArray[$i]["date_close"] != "0000-00-00"){
				$entriesArray[$i]["closed_color"] = "#99CC00";
			}
			
			// translate date
			$entriesArray[$i]["date_open"] = CoreTranslator::dateFromEn($entriesArray[$i]["date_open"], $lang);
			$entriesArray[$i]["time_limit"] = CoreTranslator::dateFromEn($entriesArray[$i]["time_limit"], $lang);
			if ($entriesArray[$i]["date_close"] == "0000-00-00"){
				$entriesArray[$i]["date_close"] = "";
			}
			else{
				$entriesArray[$i]["date_close"] = CoreTranslator::dateFromEn($entriesArray[$i]["date_close"], $lang);
			}
		}
		
		//print_r($entriesArray);
		
		$table = new TableView();
		$table->setTitle($title);
		$table->addLineEditButton("sprojectsentries/editentries");
		$table->addDeleteButton("sprojectsentries/deleteentries");
		$table->addPrintButton("sprojectsentries/index/");
		$table->addExportButton("sprojectsentries/index/", $title);
		$table->setColorIndexes(array("all" => "color", "time_limit" => "time_color", "date_close" => "closed_color"));
		
		$headersArray = array("id" => "ID", "resp_name" => CoreTranslator::Responsible($lang), "name" => SpTranslator::No_Projet($lang), "user_name" => CoreTranslator::User($lang), "date_open" => SpTranslator::Opened_date($lang), "time_limit" => SpTranslator::Time_limite($lang), "date_close" => SpTranslator::Closed_date($lang));
		$tableHtml = $table->view($entriesArray, $headersArray);
		
		//$print = $this->request->getParameterNoException("print");
		
		//echo "print = " . $print . "<br/>";
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
				'table' => $tableHtml
		), "index");
	}
	
	public function allentries(){
		$_SESSION["sprojects_lastvisited"] = "all";
		$this->index("all");
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
		$activeItems = $this->getProjectItems($projectEntries);
               
		
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
			$modelUser = new CoreUser();
			$users = $modelUser->getUsersSummary("name");
			$modelResp = new CoreResponsible();
			$resps = $modelResp->responsibleSummaries("name");
		}
		/*
		print_r($projectEntries);
                 echo "<br/>";
		echo "active items = <br/>"; 
                print_r($activeItems);
                 * 
                 */
		
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
	protected function getProjectItems($projectEntries){
		// get active items
		$modelItem = new SpItem();
		$activeItems = $modelItem->getActiveItems("display_order");
		/*
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
		*/
		return $activeItems;
	}
	
	public function expoertxls(){
		
		// Lang
		$lang = "En";
		if (isset($_SESSION["user_settings"]["language"])){
			$lang = $_SESSION["user_settings"]["language"];
		}
		
		// action
		$idproject = "";
		if ($this->request->isParameterNotEmpty('actionid')){
			$idproject = $this->request->getParameter("actionid");
		}
		
		// get project entries
		$modelProject = new SpProject();
		$projectEntries = $modelProject->getProjectEntries($idproject);
		
		// get active items
		$activeItems = $this->getProjectItems($projectEntries);
		
		// select the items with not null data
		for($i = 0 ; $i < count($activeItems) ; $i++){
			$qi = 0;
			foreach ($projectEntries as $order){
				if (isset($order["content"]["item_".$activeItems[$i]["id"]])){
					$qi += $order["content"]["item_".$activeItems[$i]["id"]];
				}
			}
			$activeItems[$i]["pos"] = 0;
			if ($qi > 0){
				$activeItems[$i]["pos"] = 1;
				$activeItems[$i]["sum"] = $qi;
			}
		}
		
		// write into string
		$content = "Date;";
		foreach($activeItems as $item){
			if ($item["pos"] > 0){
				$content .= $item["name"] . ";";
			}
		}
		$content .= " total (€ HT) ; \n";
		foreach ($projectEntries as $order){
			$content .= CoreTranslator::dateFromEn($order['date'], $lang) . ";";
			foreach($activeItems as $item){
					
				if ($item["pos"] > 0){
					$quantity = "";
					if (isset($order["content"]["item_".$item["id"]])){
						$quantity = $order["content"]["item_".$item["id"]];
					}
					
					$content .= $quantity . ";";
				}	
			}
			$content .= "\n";
		}
		
		// calculate total sum and price HT
		$modelUser = "";

		$modelUnit = "";
		$modelBelonging = "";

		$modelConfig = new CoreConfig();
		$sprojectsusersdatabase = $modelConfig->getParam ( "sprojectsusersdatabase" );
		if ($sprojectsusersdatabase == "local"){
			$modelUser = new SpUser();
			$modelBelonging = new SpBelonging();
			$modelUnit = new SpUnit();
		}
		else{
			$modelUser = new CoreUser();
			$modelBelonging = new CoreBelonging();
			$modelUnit = new CoreUnit();
		}
		$id_resp = $modelProject->getResponsible($idproject);
		$id_unit = $modelUser->getUserUnit($id_resp);
		
		$LABpricingid = $modelUnit->getBelonging($id_unit);

		$itemPricing = new SpItemPricing();
		
		$content .= "Total ;";
		$totalHT = 0;
		$numActivItem = 0;
		foreach($activeItems as $item){
				
			if ($item["pos"] > 0){
				$unitaryPrice = $itemPricing->getPrice($item["id"], $LABpricingid);
				$content .= $item["sum"] . ";";
				$totalHT += (float)$item["sum"]*(float)$unitaryPrice["price"];
				$numActivItem++;
			}
		}
		$content .= "\r\n";
		for($i = 0 ; $i <= $numActivItem ; $i++){
			$content .= " ; ";
		}
		$content .= $totalHT . "\r\n";
		
		header("Content-Type: application/csv-tab-delimited-table");
		header("Content-disposition: filename=projet.csv");
		echo $content;
	}
	
	public function editquery($redirectToIndex = true){
		
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
		$date_open = $this->request->getParameter("date_open");
		$date_close = $this->request->getParameterNoException("date_close");
		$new_team = $this->request->getParameter("new_team");
		$new_project = $this->request->getParameter("new_project");
		$time_limit = $this->request->getParameter("time_limit");
		
		//print_r($id);
		//echo "id = " . $id . "<br/>"; 
		
		if ($date_open != ""){
			$pos = strpos($date_open, "-");
			if ($pos === false){
				$date_open = CoreTranslator::dateToEn($date_open, $lang);
			}
		}
		if ($date_close != ""){
			$pos = strpos($date_close, "-");
			if ($pos === false){
				$date_close = CoreTranslator::dateToEn($date_close, $lang);
			}
		}
		
		$modelProject = new SpProject();
		$id_project = $modelProject->setProject($id, $name, $id_resp, $id_user, $date_open, $date_close,
				                                $new_team, $new_project, $time_limit);
		//echo "id_project = " . $id_project . "<br/>";
		// get items content
		$cdate = $this->request->getParameterNoException("cdate");
                $ciditem = $this->request->getParameterNoException("ciditem");
                $cquantity = $this->request->getParameterNoException("cquantity");
                $cinvoiceid = $this->request->getParameterNoException("cinvoiceid");
                
                //echo 
		//print_r($cid);
                //return;
		if ($cdate != ""){
		
                    // remove the items that are in the database
                    $modelProject->deleteAllProjetItems($id_project);
                    // add/update items
                    for($it = 0 ; $it < count($cdate) ; $it++){
                        $modelProject->setProjectEntry($id_project, $cdate[$it], $ciditem[$it], $cquantity[$it], $cinvoiceid[$it]);
                    }
                }
		
                if ($redirectToIndex){
                    $this->redirect("sprojectsentries");
                }
	}
        
        public function saveandbill(){
            // save the project informations
            $this->editquery(false);
            
            // close project
            $id_project = $this->request->getParameterNoException("id");
            $modelProject = new SpProject();
            $modelProject->closeProject($id_project);
            
            // generate bill
            $modelBill = new SpBillGenerator();
            $fileName = $modelBill->generateBill($id_project);
            $fileUrl = "data/sproject/" . $fileName;

            // send the bill file    
            header('Content-Transfer-Encoding: binary'); //Transfert en binaire (fichier).
            header('Content-Disposition: attachment; filename='. $fileName); //Nom du fichier.
            header('Content-Length: '.filesize($fileUrl)); //Taille du fichier.
            readfile($fileUrl);
            
        }
	
	/**
	 * Remove an unit form confirm
	 */
	public function delete(){
	
		$unitId = 0;
		if ($this->request->isParameterNotEmpty('actionid')){
			$unitId = $this->request->getParameter("actionid");
		}
	
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