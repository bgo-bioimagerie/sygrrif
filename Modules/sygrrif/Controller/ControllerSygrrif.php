<?php
require_once 'Framework/Controller.php';
require_once 'Modules/core/Model/CoreUnit.php';
require_once 'Modules/core/Model/CoreUser.php';
require_once 'Modules/core/Model/CoreTranslator.php';
require_once 'Modules/sygrrif/Model/SyTranslator.php';
require_once 'Modules/sygrrif/Controller/ControllerBooking.php';
require_once 'Modules/sygrrif/Model/SyGraph.php';
require_once 'Modules/sygrrif/Model/SyPricing.php';
require_once 'Modules/sygrrif/Model/SyResourcePricing.php';
require_once 'Modules/sygrrif/Model/SyVisa.php';
require_once 'Modules/sygrrif/Model/SyAuthorization.php';
require_once 'Modules/sygrrif/Model/SyResourcesCategory.php';
require_once 'Modules/sygrrif/Model/SyBillGenerator.php';
require_once 'Modules/sygrrif/Model/SyArea.php';
require_once 'Modules/sygrrif/Model/SyResourceType.php';
require_once 'Modules/core/Model/UserSettings.php';

/**
 * SyGRRif management pages
 * @author sprigent
 *
 */
class ControllerSygrrif extends ControllerBooking {

	/**
	 * Check if the user have the right to view SyGRRif pages
	 * @return boolean
	 */
	private function secureCheck(){
		if ( $_SESSION["user_status"] < 3){
			echo "Permission denied "; 
			return true;
		}
		return false;
	}
	
	/**
	 * Constructor
	 */
	public function __construct() {
		ob_end_clean();
	}

	
	/**
	 * (non-PHPdoc)
	 * @see Controller::index()
	 */
	public function index() {
		
		if($this->secureCheck()){
			return;
		}
		
		$navBar = $this->navBar();

		$this->generateView ( array (
				'navBar' => $navBar
		) );
	}
	
	
	// pricing
	/**
	 * List of pricings
	 */
	public function pricing(){	
		
		if($this->secureCheck()){
			return;
		}
		
		$sort = "id";
		if ($this->request->isParameterNotEmpty('actionid')){
			$sort = $this->request->getParameter("actionid");
		}
		
		$modelPricing = new SyPricing();
		$pricingArray = $modelPricing->getPrices($sort);
		
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'pricingArray' => $pricingArray
		) );
	}
	
	/**
	 * Form to add a pricing
	 */
	public function addpricing(){
		
		if($this->secureCheck()){
			return;
		}
		
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar
		) );
	}
	
	/**
	 * Query to add a pricing
	 */
	public function addpricingquery(){
		
		if($this->secureCheck()){
			return;
		}

		// get form variables
		$nom = $this->request->getParameter ( "name" );
		$tarif_unique = $this->request->getParameter ( "tarif_unique" );
		$tarif_nuit = $this->request->getParameter ( "tarif_nuit" );
		$night_start = $this->request->getParameter ( "night_start" );
		$night_end = $this->request->getParameter ( "night_end" );
		$tarif_we = $this->request->getParameter ( "tarif_we" );
		
	    $lundi = $this->request->getParameterNoException ( "lundi");
		$mardi = $this->request->getParameterNoException ( "mardi");
		$mercredi = $this->request->getParameterNoException ( "mercredi");
		$jeudi = $this->request->getParameterNoException ( "jeudi");
		$vendredi = $this->request->getParameterNoException ( "vendredi");
		$samedi = $this->request->getParameterNoException ( "samedi");
		$dimanche = $this->request->getParameterNoException ( "dimanche");
		
		$modelPricing = new SyPricing();
		if ($tarif_unique == "oui"){
			$modelPricing->addUnique($nom);
		}
		else{
			if ($lundi != ""){$lundi = "1";}else{$lundi = "0";}
			if ($mardi != ""){$mardi = "1";}else{$mardi = "0";}
			if ($mercredi != ""){$mercredi = "1";}else{$mercredi = "0";}
			if ($jeudi != ""){$jeudi = "1";}else{$jeudi = "0";}
			if ($vendredi != ""){$vendredi = "1";}else{$vendredi = "0";}
			if ($samedi != ""){$samedi = "1";}else{$samedi = "0";}
			if ($dimanche != ""){$dimanche = "1";}else{$dimanche = "0";}
			
			if ($tarif_unique == "oui"){$tarif_unique = 1;}else{$tarif_unique = 0;}
			if ($tarif_nuit == "oui"){$tarif_nuit = 1;}else{$tarif_nuit = 0;}
			if ($tarif_we == "oui"){$tarif_we = 1;}else{$tarif_we = 0;}
			
			$we_char = $lundi . "," . $mardi . "," . $mercredi . "," . $jeudi . "," . $vendredi . "," . $samedi . "," . $dimanche; 
			
			$modelPricing->addPricing($nom, $tarif_unique, $tarif_nuit, $night_start, $night_end, $tarif_we, $we_char);
		}
		
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar
		) );
	}
	
	/**
	 * Form to edit a pricing
	 */
	public function editpricing(){
		
		if($this->secureCheck()){
			return;
		}
		
		// get user id
		$id = 0;
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$id = $this->request->getParameter ( "actionid" );
		}
		
		$modelPricing = new SyPricing();
		$pricing = $modelPricing->getPricing($id);
		
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'pricing' => $pricing
		) );
	}
	
	/**
	 * Query to edit a pricing
	 */
	public function editpricingquery(){
		
		if($this->secureCheck()){
			return;
		}
		
		// get form variables
		$id = $this->request->getParameter ( "id" );
		$nom = $this->request->getParameter ( "name" );
		$tarif_unique = $this->request->getParameter ( "tarif_unique" );
		$tarif_nuit = $this->request->getParameter ( "tarif_nuit" );
		$night_start = $this->request->getParameter ( "night_start" );
		$night_end = $this->request->getParameter ( "night_end" );
		$tarif_we = $this->request->getParameter ( "tarif_we" );
		
		$lundi = $this->request->getParameterNoException ( "lundi");
		$mardi = $this->request->getParameterNoException ( "mardi");
		$mercredi = $this->request->getParameterNoException ( "mercredi");
		$jeudi = $this->request->getParameterNoException ( "jeudi");
		$vendredi = $this->request->getParameterNoException ( "vendredi");
		$samedi = $this->request->getParameterNoException ( "samedi");
		$dimanche = $this->request->getParameterNoException ( "dimanche");
		
		if ($lundi != ""){$lundi = "1";}else{$lundi = "0";}
		if ($mardi != ""){$mardi = "1";}else{$mardi = "0";}
		if ($mercredi != ""){$mercredi = "1";}else{$mercredi = "0";}
		if ($jeudi != ""){$jeudi = "1";}else{$jeudi = "0";}
		if ($vendredi != ""){$vendredi = "1";}else{$vendredi = "0";}
		if ($samedi != ""){$samedi = "1";}else{$samedi = "0";}
		if ($dimanche != ""){$dimanche = "1";}else{$dimanche = "0";}
				
		if ($tarif_unique == "oui"){$tarif_unique = 1;}else{$tarif_unique = 0;}
		if ($tarif_nuit == "oui"){$tarif_nuit = 1;}else{$tarif_nuit = 0;}
		if ($tarif_we == "oui"){$tarif_we = 1;}else{$tarif_we = 0;}
				
		$we_char = $lundi . "," . $mardi . "," . $mercredi . "," . $jeudi . "," . $vendredi . "," . $samedi . "," . $dimanche;

		$modelPricing = new SyPricing();
		$modelPricing->editPricing($id, $nom, $tarif_unique, $tarif_nuit, $night_start, $night_end, $tarif_we, $we_char);

		
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar
		) );
	}
	
	
	/**
	 * Form to add a pricing for a unit
	 */
	public function addunitpricing(){
		
		if($this->secureCheck()){
			return;
		}
		
		$modelUnit = new CoreUnit();
		$unitsList = $modelUnit->unitsIDName();
		
		$modelPricing = new SyPricing();
		$pricingList = $modelPricing->pricingsIDName();
		
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar, 'unitsList' => $unitsList,
				'pricingList' => $pricingList
		) );
	}
	
	
	/**
	 * Query to add a pricing for a unit
	 */
	public function addunitpricingquery(){
		
		if($this->secureCheck()){
			return;
		}
		
		// get form variables
		$id_unit = $this->request->getParameter ( "id_unit" );
		$id_pricing = $this->request->getParameter ( "id_pricing" );
		
		$modelPricing = new SyUnitPricing();
		$modelPricing->setPricing($id_unit, $id_pricing);
		
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar
		) );
	}
	
	/**
	 * Form to edit a pricing to a unit
	 */
	public function editunitpricing(){
		
		if($this->secureCheck()){
			return;
		}
		
		// get unit id
		$unit_id = 0;
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$unit_id = $this->request->getParameter ( "actionid" );
		}
		
		echo "unit_id = " . $unit_id . "<br />";
		
		$modelUnit = new CoreUnit();
		$unitName = $modelUnit->getUnitName($unit_id);
		
		$modelPricing = new SyPricing();
		$pricingList = $modelPricing->pricingsIDName();
		
		$modelUnitPricing = new SyUnitPricing();
		$curentPricingId = $modelUnitPricing->getPricing($unit_id);
		//$curentPricingId = $modelPricing->getPricing($unit_id);
		//$curentPricingId = $curentPricingId[0];
		
		//echo "curentPricingId = " . $curentPricingId . "<br />";
		//return;
		print_r($pricingList);
		
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar, 'unitName' => $unitName,
				'unitId' => $unit_id, 'curentPricingId' => $curentPricingId,
				'pricingList' => $pricingList
		) );
	}
	
	/**
	 * Query to edit a pricing for a unit
	 */
	public function editunitpricingquery(){
		
		if($this->secureCheck()){
			return;
		}
		
		// get form variables
		$id_unit = $this->request->getParameter ( "id_unit" );
		$id_pricing = $this->request->getParameter ( "id_pricing" );
		
		$modelPricing = new SyUnitPricing();
		$modelPricing->setPricing($id_unit, $id_pricing);
		
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar
		) );
	}	

	
	
	
	/**
	 * Form to generate statistics for authorizations
	 */
	public function statauthorizations(){
		
		$lang = "En";
		if (isset($_SESSION["user_settings"]["language"])){
			$lang = $_SESSION["user_settings"]["language"];
		}
		
		// get form info
		$searchDate_start = $this->request->getParameterNoException('searchDate_start');
		$searchDate_end = $this->request->getParameterNoException('searchDate_end');
		$user_id = $this->request->getParameterNoException('user');
		$curentunit_id = $this->request->getParameterNoException('curentunit'); 
		$trainingunit_id = $this->request->getParameterNoException('trainingunit');
		$visa_id = $this->request->getParameterNoException('visa');
		$resource_id = $this->request->getParameterNoException('resource');
		
		if ($searchDate_start != ""){
			$searchDate_start = CoreTranslator::dateToEn($searchDate_start, $lang);
		}
		if ($searchDate_end != ""){
			$searchDate_end = CoreTranslator::dateToEn($searchDate_end, $lang);
		}
		
		$view_pie_chart = $this->request->getParameterNoException('view_pie_chart');
		$view_counting = $this->request->getParameterNoException('view_counting');
		$view_details = $this->request->getParameterNoException('view_details');
		$save_details = $this->request->getParameterNoException("save_details");
		
		// format form info
		if ($user_id == ''){$user_id = "0";}
		if ($curentunit_id == ''){$curentunit_id = "0";}
		if ($trainingunit_id == ''){$trainingunit_id = "0";}
		if ($visa_id == ''){$visa_id = "0";}
		if ($resource_id == ''){$resource_id = "0";}
		
		if ($user_id == 1){$user_id = "0";}
		if ($curentunit_id == 1){$curentunit_id = "0";}
		if ($trainingunit_id == 1){$trainingunit_id = "0";}
		if ($visa_id == 1){$visa_id = "0";}
		//if ($resource_id == 0){$resource_id = "0";}
		
		// users
		$modeluser = new CoreUser();
		$users = $modeluser->getUsersSummary('name');
		
		// units
		$modelunits = new CoreUnit();
		$units = $modelunits->unitsIDName();
		
		// visa
		$modelvisa = new SyVisa();
		$visas = $modelvisa->visasIDName();
		
		// resources categories
		$modelresource = new SyResourcesCategory();
		$resourcesList = $modelresource->getResourcesCategories('name'); 
		 
		
		// on form change
		$testPass = true;
		$resultsVisible = false;
		if ( $searchDate_start == ''){
			$errorMessage = "Please set a start date";
			$testPass = false;
		}
		if ( $searchDate_end == ''){
			$errorMessage = "Please set an end date";
			$testPass = false;
		}
		if ($searchDate_end != '' && $searchDate_end != '' ){
			if ( $searchDate_end < $searchDate_start){
				$errorMessage = "The start date must be before the start date";
				$testPass = false;
			}
		}
		
		$msData = "";
		$dsData = "";
		$camembert = "";
		if ($testPass){
			$modelAuth = new SyAuthorization();
			
			if ($view_counting != ""){
				$msData = $modelAuth->minimalStatistics($searchDate_start, $searchDate_end, $user_id, $curentunit_id, 
			                          $trainingunit_id, $visa_id, $resource_id);
			}
			
			if ($view_details != ""){
				$dsData = $modelAuth->statsDetails($searchDate_start, $searchDate_end, $user_id, $curentunit_id, 
			                          $trainingunit_id, $visa_id, $resource_id);
			}
			
			if ($view_pie_chart != ""){
				$camembert = $modelAuth->statsResources($searchDate_start, $searchDate_end);
			}
			
			$resultsVisible = true;
		}
		
		$errorMessage = '';
		
		// put some data to cession
		$_SESSION['searchDate_start']=$searchDate_start;
		$_SESSION['searchDate_end']=$searchDate_end;
		if ($dsData != ""){
			$_SESSION['dsData']=$dsData;
		}
		if ($msData != ""){
			$_SESSION['msData']=$msData;
		}
		
		if ( $searchDate_end < $searchDate_start){
			$errorMessage = "The start date must be before the end date";
		}
		
		// view
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'errorMessage' => $errorMessage,
				'searchDate_start' => $searchDate_start,
				'searchDate_end' => $searchDate_end,
				'user_id' => $user_id,
				'curentunit_id' => $curentunit_id,
				'trainingunit_id' => $trainingunit_id,
				'visa_id' => $visa_id,
				'resource_id' => $resource_id,
				'usersList' => $users,
				'unitsList' => $units,
				'visasList' => $visas,
				'resourcesList' => $resourcesList,
				'trainingunit_id' => $trainingunit_id,
				'resultsVisible' => $resultsVisible,
				'msData' => $msData,
				'dsData' => $dsData,
				'camembert' => $camembert,
				'view_pie_chart' => $view_pie_chart,
				'view_counting' => $view_counting,
				'view_details' => $view_details,
				'save_details' => $save_details
		) );
	
	}
	
	/**
	 * Query that generates the authorizations detailled statistics file
	 */
	public function statauthorizationsdetailcsv(){
		
		$lang = "En";
		if (isset($_SESSION["user_settings"]["language"])){
			$lang = $_SESSION["user_settings"]["language"];
		}
		
		$searchDate_start = $this->request->getSession()->getAttribut('searchDate_start');
		$searchDate_end = $this->request->getSession()->getAttribut('searchDate_end');
		$t = $this->request->getSession()->getAttribut('dsData');
		
		$filename = $t['nom_fic'];
		$datas = $t["data"];
		
		header('Content-Type: text/csv;'); //Envoie le résultat du script dans une feuille excel
		header('Content-Disposition: attachment; filename='.$filename.''); //Donne un nom au fichier exel

		// print table header
		echo '"' . SyTranslator::Fromdate($lang). ' '. CoreTranslator::dateFromEn($searchDate_start, $lang) .' ' . SyTranslator::Todate($lang). ' ' . CoreTranslator::dateFromEn($searchDate_end, $lang) . '"'."\n";
		echo SyTranslator::Date($lang) . ";";
		echo SyTranslator::User($lang) . ";";
		echo SyTranslator::Unit($lang) . ";";
		echo SyTranslator::Visa($lang) . ";";
		echo SyTranslator::Resource($lang) . ";";
		echo SyTranslator::Responsible($lang) . ";";
		echo "\n";	
		foreach($datas as $v){
			echo CoreTranslator::dateFromEn($v['Date'], $lang) . ";";
			echo $v['Utilisateur'] . ";";
			echo $v['Laboratoire'] . ";";
			echo $v['Visa'] . ";";
			echo $v['machine'] . ";";
			echo $v['responsable'] . ";";
			echo "\n";
		}

	}
	
	/**
	 * Query that generates the authorizations counting statistics file
	 */
	public function statauthorizationscountingcsv(){
		$searchDate_start = $this->request->getSession()->getAttribut('searchDate_start');
		$searchDate_end = $this->request->getSession()->getAttribut('searchDate_end');
		$msData = $this->request->getSession()->getAttribut('msData');
		
		$lang = "En";
		if (isset($_SESSION["user_settings"]["language"])){
			$lang = $_SESSION["user_settings"]["language"];
		}
		
		$filename = "authorizations_count.xls";
		header('Content-Type: text/csv; charset=utf-8;'); //Envoie le résultat du script dans une feuille excel
		header('Content-Disposition: attachment; filename='.$filename.''); //Donne un nom au fichier exel
		
		echo  SyTranslator::Search_criteria($lang) . " \n";
		echo str_replace("<br/>", "\n", $msData["criteres"]) ;
		
		echo    " \n " . SyTranslator::Results($lang) . " \n";
		echo   	SyTranslator::Number_of_training($lang) . ":" . $msData["numOfRows"] . "\n";
		echo 	SyTranslator::Nomber_of_users($lang). ":" . $msData["distinct_nf"]  . "\n";
		echo 	SyTranslator::Nomber_of_units($lang) . ":" . $msData["distinct_laboratoire"]  . "\n";
		echo 	SyTranslator::Nomber_of_VISAs($lang) . ":" . $msData["distinct_visa"]  . "\n";
		echo 	SyTranslator::Nomber_of_resources($lang) . ":" . $msData["distinct_machine"] . "\n";
		echo 	SyTranslator::Nomber_of_users($lang) . ":" . $msData["new_people"] . "\n";
		
	}
	
	/**
	 * View the booking calendar
	 * 
	 * @throws Exception
	 */
	public function booking(){

		$id_resource = $this->request->getParameterNoException('id_resource');
		$id_area = $this->request->getParameterNoException('id_area');
		
		//echo "id_area a= " . $id_area . "</br>";
		//echo "id_resource a= " . $id_resource . "</br>";
		//echo "id_resource begin = " . $id_resource . "</br>";
		
		$modelResource = new SyResource();
		if ($id_resource == "" || $id_resource == 0){ // booking home page
			
			$userSettingsModel = new UserSettings();
			$calendarDefaultResource = $userSettingsModel->getUserSetting($_SESSION["id_user"], "calendarDefaultResource");
			if ($calendarDefaultResource != ""){
				$id_resource = $calendarDefaultResource;
				$id_area = $modelResource->getAreaID($id_resource);
			}
			else{
				if ($id_area == "" || $id_area ==0){
					$modelArea = new SyArea();
					if ($_SESSION["user_status"] < 3){
						$id_area=$modelArea->getSmallestUnrestrictedID();
					}
					else{
						$id_area=$modelArea->getSmallestID();
					}
				}
				// get the resource with the smallest id
				
				$id_resource = $modelResource->firstResourceIDForArea($id_area);
			}
			//echo "id_area = " . $id_area . "</br>";
			//echo "id_resource = " . $id_resource . "</br>";
				
			
			//$menuData = $this->calendarMenuData($id_area, $id_resource, date("Y-m-d", time()));
			$_SESSION['id_resource'] = $id_resource;
			$_SESSION['id_area'] = $id_area;
			$_SESSION['curentDate'] = date("Y-m-d", time());
			

			if ($id_resource == 0){
				$menuData = $this->calendarMenuData($id_area, $id_resource, date("Y-m-d", time()));
				$navBar = $this->navBar();
				$this->generateView ( array (
						'navBar' => $navBar,
						'menuData' => $menuData
				) );
				return;
			}
				
		}
		 // redirect to the resource page
			// redirect given the resource type
			$modelRes = new SyResource();
			$idType = $modelRes->getResourceType($id_resource);
			
			$modelType = new SyResourceType();
			$typInfo = $modelType->getType($idType);
			
			// call the controller like the rooter does
			$controller = ucfirst ( strtolower ( $typInfo['controller'] ) );
			$classController = "Controller" . $controller;
			
			$modulesNames = Configuration::get("modules");
			$count = count($modulesNames);
			
			$controllerFound = false;
			for($i = 0; $i < $count; $i++) {
				$fileController = 'Modules/' . $modulesNames[$i] . "/Controller/" . $classController . ".php";
				if (file_exists($fileController)){
					// Instantiate controler
					$controllerFound = true;
					require ($fileController);
					$controller = new $classController ();
					$controller->setRequest ( $this->request );
				}
			}
			if (!$controllerFound){
				throw new Exception ( "Unable to find the file '$fileController' " );
			}
			
			// call the action
			$actionName = $typInfo['book_action'];	
			//echo "book action = " . $actionName . "<br/>";
			$controller->runAction($actionName);
		
	}
	
}
