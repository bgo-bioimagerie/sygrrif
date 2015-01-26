<?php

require_once 'Framework/Controller.php';
require_once 'Modules/core/Model/Unit.php';
require_once 'Modules/core/Model/User.php';
require_once 'Modules/sygrrif/Controller/ControllerBooking.php';
require_once 'Modules/sygrrif/Model/SyGraph.php';
require_once 'Modules/sygrrif/Model/SyPricing.php';
require_once 'Modules/sygrrif/Model/SyInstall.php';
require_once 'Modules/sygrrif/Model/SyUnitPricing.php';
require_once 'Modules/sygrrif/Model/SyResourcePricing.php';
require_once 'Modules/sygrrif/Model/SyVisa.php';
require_once 'Modules/sygrrif/Model/SyAuthorization.php';
require_once 'Modules/sygrrif/Model/SyResourcesCategory.php';
require_once 'Modules/sygrrif/Model/SyBillGenerator.php';
require_once 'Modules/sygrrif/Model/SyArea.php';
require_once 'Modules/sygrrif/Model/SyResourceType.php';

class ControllerSygrrif extends ControllerBooking {

	public function __construct() {
	}

	// Affiche la liste de tous les billets du blog
	public function index() {
		
		$navBar = $this->navBar();

		$this->generateView ( array (
				'navBar' => $navBar
		) );
	}
	
	public function areas(){
		
		$sort = "id";
		if ($this->request->isParameterNotEmpty('actionid')){
			$sort = $this->request->getParameter("actionid");
		}
		
		$model = new SyArea();
		$areas = $model->areas($sort);
		
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'areas' => $areas
		) );
	}
	
	public function editarea(){
		$id = "";
		if ($this->request->isParameterNotEmpty('actionid')){
			$id = $this->request->getParameter("actionid");
		}
		
		$model = new SyArea();
		$area = $model->getArea($id);
		
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'area' => $area
		) );
	}
	
	public function editareaquery(){
		$id = $this->request->getParameter ( "id" );
		$name = $this->request->getParameter ( "name" );
		$display_order = $this->request->getParameter ( "display_order" );
		$restricted = $this->request->getParameter ( "restricted" );
		
		$model = new SyArea();
		$model->updateArea($id, $name, $display_order, $restricted);
		
		$this->redirect("sygrrif", "areas");
	}
	
	public function addarea(){
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar
		) );
	}
	
	public function addareaquery(){
		$id = $this->request->getParameter ( "id" );
		$name = $this->request->getParameter ( "name" );
		$display_order = $this->request->getParameter ( "display_order" );
		$restricted = $this->request->getParameter ( "restricted" );
		
		$model = new SyArea();
		$model->setArea($name, $display_order, $restricted);
		
		$this->redirect("sygrrif", "areas");
	}
	
	
	public function statistics(){
		
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar
		) );
	} 
	
	public function statisticsquery(){

		$year = $this->request->getParameter ( "year" );
		
		$modelGraph = new SyGraph();
		$graphArray = $modelGraph->getYearNumResGraph($year);
		$camembertContent = $modelGraph->getCamembertContent($year, $graphArray['numTotal']);
		
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'annee' => $year,
				'numTotal' => $graphArray['numTotal'],
		        'graph' => $graphArray['graph'],
				'camembertContent' => $camembertContent
		) );
	}
	
	// pricing
	public function pricing(){	
		
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
	
	
	public function addpricing(){
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar
		) );
	}
	
	public function addpricingquery(){

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
	
	public function editpricing(){
		
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
	
	public function editpricingquery(){
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
	
	public function unitpricing(){
		
		$modelUnitPricing = new SyUnitPricing();
		$pricingArray = $modelUnitPricing->allPricingTable();
		
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar, 'pricingArray' => $pricingArray
		) );
	}
	
	public function addunitpricing(){
		
		$modelUnit = new Unit();
		$unitsList = $modelUnit->unitsIDName();
		
		$modelPricing = new SyPricing();
		$pricingList = $modelPricing->pricingsIDName();
		
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar, 'unitsList' => $unitsList,
				'pricingList' => $pricingList
		) );
	}
	
	public function addunitpricingquery(){
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
	
	public function editunitpricing(){
		// get unit id
		$unit_id = 0;
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$unit_id = $this->request->getParameter ( "actionid" );
		}
		
		$modelUnit = new Unit();
		$unitName = $modelUnit->getUnitName($unit_id);
		
		$modelPricing = new SyPricing();
		$pricingList = $modelPricing->pricingsIDName();
		$curentPricingId = $modelPricing->getPricing($unit_id);
		
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar, 'unitName' => $unitName[0],
				'unitId' => $unit_id, 'curentPricingId' => $curentPricingId,
				'pricingList' => $pricingList
		) );
	}
	
	public function editunitpricingquery(){
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
	
	public function resources(){
		
		$sortEntry = 'id';
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$sortEntry = $this->request->getParameter ( "actionid" );
		}
		
		$modelResources = new SyResource();
		$resourcesArray = $modelResources->resourcesInfo($sortEntry);
		
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar, 'resourcesArray' => $resourcesArray
		) );
		
	}
	
	public function addresource(){
		
		$resource_type = "";
		if ($this->request->isParameterNotEmpty ( 'resource_type' )) {
			$resource_type = $this->request->getParameter ( "resource_type" );
		}

		$modelResourcesTypes = new SyResourceType();
		if ($resource_type == ""){
			$resourcesTypes = $modelResourcesTypes->typesIDNames("name");
			
			$navBar = $this->navBar();
			$this->generateView ( array (
					'navBar' => $navBar,
					'resourcesTypes' => $resourcesTypes
			) );
		}
		else{
			$typeInfo = $modelResourcesTypes->getType($resource_type);
			
			$this->redirect($typeInfo["controller"], $typeInfo["edit_action"]);
		}
	}
	
	public function resourcescategory(){
		// get sort action
		$sortentry = "id";
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$sortentry = $this->request->getParameter ( "actionid" );
		}
		
		// get the user list
		$categoriesModel = new SyResourcesCategory();
		$categoriesTable = $categoriesModel->getResourcesCategories ( $sortentry );
		
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'categoriesTable' => $categoriesTable
		) );
	}
	
	public function addresourcescategory(){
		
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
		) );
	}
	
	public function addresourcescategoryquery(){
	
		// get form variables
		$name = $this->request->getParameter ( "name" );
	
		// get the user list
		$rcModel = new SyResourcesCategory();
		$rcModel->addResourcesCategory ( $name );
	
		$this->redirect ( "sygrrif", "resourcescategory" );
	}
	
	public function editresourcescategory(){
	
		// get user id
		$rcId = 0;
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$rcId = $this->request->getParameter ( "actionid" );
		}
	
		// get unit info
		$rcModel = new SyResourcesCategory();
		$rc = $rcModel->getResourcesCategory ( $rcId );
	
		$navBar = $this->navBar ();
		$this->generateView ( array (
				'navBar' => $navBar,
				'rc' => $rc
		) );
	}
	
	public function editresourcescategoryquery(){
	
		// get form variables
		$id = $this->request->getParameter ( "id" );
		$name = $this->request->getParameter ( "name" );
	
		// get the user list
		$rcModel = new SyResourcesCategory();
		$rcModel->editResourcesCategory ( $id, $name );
	
		$this->redirect ( "sygrrif", "resourcescategory" );
	}
	
	public function visa(){
		
		// get sort action
		$sortentry = "id";
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$sortentry = $this->request->getParameter ( "actionid" );
		}
		
		// get the user list
		$visaModel = new SyVisa();
		$visaTable = $visaModel->getVisas ( $sortentry );
		
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'visaTable' => $visaTable
		) );
	}
	
	public function addvisa(){
	
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
		) );
	}
	
	public function addvisaquery(){
		
		// get form variables
		$name = $this->request->getParameter ( "name" );
		
		// get the user list
		$visaModel = new SyVisa();
		$visaModel->addVisa ( $name );
		
		$this->redirect ( "sygrrif", "visa" );
	}
	
	public function editvisa(){
		
		// get user id
		$visaId = 0;
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$visaId = $this->request->getParameter ( "actionid" );
		}
		
		// get unit info
		$visaModel = new SyVisa();
		$visa = $visaModel->getVisa ( $visaId );
		
		$navBar = $this->navBar ();
		$this->generateView ( array (
				'navBar' => $navBar,
				'visa' => $visa
		) );
	}
	
	public function editvisaquery(){
		$navBar = $this->navBar ();
		
		// get form variables
		$id = $this->request->getParameter ( "id" );
		$name = $this->request->getParameter ( "name" );
		
		// get the user list
		$visaModel = new SyVisa();
		$visaModel->editVisa ( $id, $name );
		
		$this->redirect ( "sygrrif", "visa" );
	} 
	
	public function authorizations(){
		// get user id
		$sortentry = 0;
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$sortentry = $this->request->getParameter ( "actionid" );
		}
		
		// query
		$authModel = new SyAuthorization();
		$authorizationTable = $authModel->getAuthorizations ( $sortentry );
		
		// view
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'authorizationTable' => $authorizationTable
		) );
	}
	
	public function addauthorization(){
		
		// get users list
		$modelUser = new User();
		$users = $modelUser->getUsersSummary('name');
		
		// get unit list
		$modelUnit = new Unit();
		$units = $modelUnit->unitsIDName();
		
		// get visa list
		$modelVisa = new SyVisa();
		$visas = $modelVisa->visasIDName();
		
		// get resource list
		$modelResource = new SyResourcesCategory();
		$resources = $modelResource->getResourcesCategories("name");
		
		// view
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'users' => $users,
				'units' => $units,
				'visas' => $visas,
				'resources' => $resources
		) );
	
	}
	
	public function editauthorization(){
		
		// get sort action
		$id = 0;
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$id = $this->request->getParameter ( "actionid" );
		}
		
		// get the authorization info
		$modelAuth = new SyAuthorization();
		$authorization = $modelAuth->getAuthorization($id);
		
		//print_r($authorization);
		
		// get users list
		$modelUser = new User();
		$users = $modelUser->getUsersSummary('name');
		
		// get unit list
		$modelUnit = new Unit();
		$units = $modelUnit->unitsIDName();
		
		// get visa list
		$modelVisa = new SyVisa();
		$visas = $modelVisa->visasIDName();
		
		// get resource list
		$modelResource = new SyResourcesCategory();
		$resources = $modelResource->getResourcesCategories("name");
		
		// view
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'users' => $users,
				'units' => $units,
				'visas' => $visas,
				'resources' => $resources,
				'authorization' => $authorization
		) );
	}
	
	public function editauthorizationsquery(){
		$id = $this->request->getParameter('id');
		$user_id = $this->request->getParameter('user_id');
		$unit_id = $this->request->getParameter('unit_id');
		$date = $this->request->getParameter('date');
		$visa_id = $this->request->getParameter('visa_id');
		$resource_id = $this->request->getParameter('resource_id');
		
		$model = new SyAuthorization();
		$model->editAuthorization($id, $date, $user_id, $unit_id, $visa_id, $resource_id);
		
		$this->redirect ( "sygrrif", "authorizations" );
	}
	
	public function addauthorizationsquery(){
		
		$user_id = $this->request->getParameter('user_id');
		$unit_id = $this->request->getParameter('unit_id');
		$date = $this->request->getParameter('date');
		$visa_id = $this->request->getParameter('visa_id');
		$resource_id = $this->request->getParameter('resource_id');
		
		$model = new SyAuthorization();
		$model->addAuthorization($date, $user_id, $unit_id, $visa_id, $resource_id);
		
		$this->redirect ( "sygrrif", "authorizations" );
	}
	
	public function statpriceunits(){
		
		// get the form parameters
		$searchDate_start = $this->request->getParameterNoException('searchDate_start');
		$searchDate_end = $this->request->getParameterNoException('searchDate_end');
		$unit_id = $this->request->getParameterNoException('unit');
		$responsible_id = $this->request->getParameterNoException('responsible');
		$export_type = $this->request->getParameterNoException('export_type');
		
		// get the selected unit
		$selectedUnitId = 0;
		if ($unit_id != ""){
			$selectedUnitId = $unit_id; 
		}
		
		// get the responsibles for this unit
		$responsiblesList = array();
		if ($selectedUnitId > 0){
			$modeluser = new User();
			$responsiblesList = $modeluser->getResponsibleOfUnit($selectedUnitId);
		}
		
		// test if it needs to calculate output
		$errorMessage = '';
		if ($selectedUnitId != 0 && $responsible_id != ''){
			
			// test the dates
			$testPass = true;
			if ( $searchDate_start == ''){
				$errorMessage = "Please set a start date";
				$testPass = false;
			}
			if ( $searchDate_end == ''){
				$errorMessage = "Please set an end date";
				$testPass = false;
			}
			if ( $searchDate_end < $searchDate_start){
				$errorMessage = "The start date must be before the end date";
				$testPass = false;
			}
			
			// if the form is correct, calculate the output
			if ($testPass){
				if ($export_type > 0 && $export_type < 4 ){
					$this->output($export_type, $searchDate_start, $searchDate_end, $selectedUnitId, $responsible_id);
					return;
				}
			}
		}
		
		// get units list
		$modelUnit = new Unit();
		$unitsList = $modelUnit->unitsIDName();
		
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'selectedUnitId' => $selectedUnitId,
				'responsiblesList' => $responsiblesList,
				'unitsList' => $unitsList,
				'errorMessage' => $errorMessage,
				'searchDate_start' => $searchDate_start,
				'searchDate_end' => $searchDate_end
		) );
	}
	
	public function output($export_type, $searchDate_start, $searchDate_end, $selectedUnitId, $responsible_id){
		
		if ($export_type == 1){
			// generate decompte
			$billgenaratorModel = new SyBillGenerator();
			$billgenaratorModel->generateCounting($searchDate_start, $searchDate_end, $selectedUnitId, $responsible_id);
			//$errorMessage = "counting functionality not yet available";
		}
		if ($export_type == 2){
			// generate detail
			$billgenaratorModel = new SyBillGenerator();
			$billgenaratorModel->generateDetail($searchDate_start, $searchDate_end, $selectedUnitId, $responsible_id);
			//$errorMessage = "detail functionality not yet available";
		}
		if ($export_type == 3){
			// generate bill
			$billgenaratorModel = new SyBillGenerator();
			$billgenaratorModel->generateBill($searchDate_start, $searchDate_end, $selectedUnitId, $responsible_id);
			//$errorMessage = "bill not yet implemented";
		}
	}
	
	public function statauthorizations(){
		
		// get form info
		$searchDate_start = $this->request->getParameterNoException('searchDate_start');
		$searchDate_end = $this->request->getParameterNoException('searchDate_end');
		$user_id = $this->request->getParameterNoException('user');
		$curentunit_id = $this->request->getParameterNoException('curentunit'); 
		$trainingunit_id = $this->request->getParameterNoException('trainingunit');
		$visa_id = $this->request->getParameterNoException('visa');
		$resource_id = $this->request->getParameterNoException('resource');
		
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
		if ($resource_id == 1){$resource_id = "0";}
		
		// users
		$modeluser = new User();
		$users = $modeluser->getUsersSummary('name');
		
		// units
		$modelunits = new Unit();
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
	
	public function statauthorizationsdetailcsv(){
		
		$searchDate_start = $this->request->getSession()->getAttribut('searchDate_start');
		$searchDate_end = $this->request->getSession()->getAttribut('searchDate_end');
		$t = $this->request->getSession()->getAttribut('dsData');
		
		$filename = $t['nom_fic'];
		$datas = $t["data"];
		
		header('Content-Type: text/csv;'); //Envoie le résultat du script dans une feuille excel
		header('Content-Disposition: attachment; filename='.$filename.''); //Donne un nom au fichier exel
		$i = 0;
		foreach($datas as $v){
			if($i==0){
				echo '"From '.$searchDate_start.' to '.$searchDate_end.'"'."\n";
				echo '"'.implode('";"',array_keys($v)).'"'."\n";
			}
			echo '"'.implode('";"',$v).'"'."\n";
			$i++;
		}
	}
	
	public function statauthorizationscountingcsv(){
		$searchDate_start = $this->request->getSession()->getAttribut('searchDate_start');
		$searchDate_end = $this->request->getSession()->getAttribut('searchDate_end');
		$msData = $this->request->getSession()->getAttribut('msData');
		
		$filename = "authorizations_count.csv";
		header('Content-Type: text/csv;'); //Envoie le résultat du script dans une feuille excel
		header('Content-Disposition: attachment; filename='.$filename.''); //Donne un nom au fichier exel
		
		echo "Search criteria \n";
		echo str_replace("<br/>", "\n", $msData["criteres"]) ;
		
		echo    " \n Results \n";
		echo   	"Number of training :" . $msData["numOfRows"] . "\n";
		echo 	"Nomber of users :" . $msData["distinct_nf"]  . "\n";
		echo 	"Nomber of units :" . $msData["distinct_laboratoire"]  . "\n";
		echo 	"Nomber of VISAs :" . $msData["distinct_visa"]  . "\n";
		echo 	"Nomber of resources :" . $msData["distinct_machine"] . "\n";
		echo 	"Nomber of new user :" . $msData["new_people"] . "\n";
		
	}
	
	public function booking(){

		$id_resource = $this->request->getParameterNoException('id_resource');
		$id_area = $this->request->getParameterNoException('id_area');
		
		//echo "id_area a= " . $id_area . "</br>";
		//echo "id_resource a= " . $id_resource . "</br>";
		//echo "id_resource begin = " . $id_resource . "</br>";
		
		if ($id_resource == "" || $id_resource == 0){ // booking home page
			
			
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
			$modelResource = new SyResource();
			$id_resource = $modelResource->firstResourceIDForArea($id_area);
			
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
			$controller->runAction($actionName);
		
	}
	
	public function colorcodes(){
		// get sort action
		$sortentry = "id";
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$sortentry = $this->request->getParameter ( "actionid" );
		}
		
		// get the user list
		$colorModel = new SyColorCode();
		$colorTable = $colorModel->getColorCodes( $sortentry );
		
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'colorTable' => $colorTable
		) );
	}
	
	public function addcolorcode(){
	
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
		) );
	}
	
	public function addcolorcodequery(){
	
		// get form variables
		$name = $this->request->getParameter ( "name" );
		$color = $this->request->getParameter ( "color" );
		
		
		// get the user list
		$ccModel = new SyColorCode();
		$ccModel->addColorCode($name, $color);
	
		$this->redirect ( "sygrrif", "colorcodes" );
	}
	
	public function editcolorcode(){
	
		// get user id
		$ccId = 0;
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$ccId = $this->request->getParameter ( "actionid" );
		}
		
		// get unit info
		$ccModel = new SyColorCode();
		$colorcode = $ccModel->getColorCode( $ccId );
	
		$navBar = $this->navBar ();
		$this->generateView ( array (
				'navBar' => $navBar,
				'colorcode' => $colorcode
		) );
	}
	
	public function editcolorcodequery(){
		$navBar = $this->navBar ();
	
		// get form variables
		$id = $this->request->getParameter ( "id" );
		$name = $this->request->getParameter ( "name" );
		$color = $this->request->getParameter ( "color" );
		
		// get the user list
		$ccModel = new SyColorCode();
		$ccModel->editColorCode($id, $name, $color);
	
		$this->redirect ( "sygrrif", "colorcodes" );
	}
	
}
