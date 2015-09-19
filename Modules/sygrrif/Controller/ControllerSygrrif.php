<?php
require_once 'Framework/Controller.php';
require_once 'Modules/core/Model/Unit.php';
require_once 'Modules/core/Model/User.php';
require_once 'Modules/core/Model/CoreTranslator.php';
require_once 'Modules/sygrrif/Model/SyTranslator.php';
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
	
	/**
	 * List of the areas
	 */
	public function areas(){
		
		if($this->secureCheck()){
			return;
		}
		
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
	
	/**
	 * Delete an area
	 */
	public function deletearea(){
		
		if($this->secureCheck()){
			return;
		}
		
		$id = "";
		if ($this->request->isParameterNotEmpty('actionid')){
			$id = $this->request->getParameter("actionid");
		}
		
		$model = new SyArea();
		$model->delete($id);
		
		$this->redirect("sygrrif", "areas");
	}
	
	/**
	 * Form to edit an area
	 */
	public function editarea(){
		
		if($this->secureCheck()){
			return;
		}
		
		$id = "";
		if ($this->request->isParameterNotEmpty('actionid')){
			$id = $this->request->getParameter("actionid");
		}
		
		$model = new SyArea();
		$area = $model->getArea($id);
		
		$modelCss = new SyBookingTableCSS();
		$css = $modelCss->getAreaCss($id);
		
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'area' => $area,
				'css' => $css
		) );
	}
	
	/*
	 * query to edit the area in the database
	 */
	public function editareaquery(){
		
		if($this->secureCheck()){
			return;
		}
		
		$id = $this->request->getParameter ( "id" );
		$name = $this->request->getParameter ( "name" );
		$display_order = $this->request->getParameter ( "display_order" );
		$restricted = $this->request->getParameter ( "restricted" );
		
		$model = new SyArea();
		$model->updateArea($id, $name, $display_order, $restricted);
		
		
		// set the css
		$header_background = $this->request->getParameter ( "header_background" );
		$header_color = $this->request->getParameter ( "header_color" );
		$header_font_size = $this->request->getParameter ( "header_font_size" );
		$resa_font_size = $this->request->getParameter ( "resa_font_size" );
		$header_height = $this->request->getParameter ( "header_height" );
		$line_height = $this->request->getParameter ( "line_height" );
		$modelCss = new SyBookingTableCSS();
		$modelCss->setAreaCss($id, $header_background, $header_color, $header_font_size,
				$resa_font_size, $header_height, $line_height);
		
		$this->redirect("sygrrif", "areas");
	}
	
	/**
	 * Form to add an area
	 */
	public function addarea(){
		
		if($this->secureCheck()){
			return;
		}
		
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar
		) );
	}
	
	/**
	 * Query to add an area in the database
	 */
	public function addareaquery(){
		
		if($this->secureCheck()){
			return;
		}
		
		
		//$id = $this->request->getParameter ( "id" );
		$name = $this->request->getParameter ( "name" );
		$display_order = $this->request->getParameter ( "display_order" );
		$restricted = $this->request->getParameter ( "restricted" );
		
		$model = new SyArea();
		$id = $model->addArea($name, $display_order, $restricted);
		
		// set the css
		$header_background = $this->request->getParameter ( "header_background" );
		$header_color = $this->request->getParameter ( "header_color" );
		$header_font_size = $this->request->getParameter ( "header_font_size" );
		$resa_font_size = $this->request->getParameter ( "resa_font_size" );
		$header_height = $this->request->getParameter ( "header_height" );
		$line_height = $this->request->getParameter ( "line_height" );
		$modelCss = new SyBookingTableCSS();
		$modelCss->setAreaCss($id, $header_background, $header_color, $header_font_size,
				$resa_font_size, $header_height, $line_height);
		

		
		$this->redirect("sygrrif", "areas");
	}
	
	/**
	 * Statistics form pages
	 */
	public function statistics(){
		
		if($this->secureCheck()){
			return;
		}
		
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar
		) );
	} 
	
	/**
	 * Calculate an view the statistics
	 */
	public function statisticsquery(){
		
		$lang = "En";
		if (isset($_SESSION["user_settings"]["language"])){
			$lang = $_SESSION["user_settings"]["language"];
		}

		if($this->secureCheck()){
			return;
		}
		
		$year = $this->request->getParameter ( "year" );
		$export_type = $this->request->getParameter ( "export_type" );
		
		$modelGraph = new SyGraph();
		$graphArray = $modelGraph->getYearNumResGraph($year);
		$graphTimeArray = $modelGraph->getYearNumHoursResGraph($year);
		
		if($export_type == 1){
			
			$camembertContent = $modelGraph->getCamembertContent($year, $graphArray['numTotal']);
			$camembertTimeContent = $modelGraph->getCamembertTimeContent($year, $graphTimeArray['timeTotal']);
			
			$navBar = $this->navBar();
			$this->generateView ( array (
					'navBar' => $navBar,
					'annee' => $year,
					'numTotal' => $graphArray['numTotal'],
			        'graph' => $graphArray['graph'],
					'graphTimeArray' => $graphTimeArray,
					'camembertContent' => $camembertContent,
					'camembertTimeContent' => $camembertTimeContent
			) );
		}
		else{
			
			$camembertCount = $modelGraph->getCamembertArray($year);
			$camembertTimeCount = $modelGraph->getCamembertTimeArray($year);
			
			header("Content-Type: application/csv-tab-delimited-table");
			header("Content-disposition: filename=rapport.csv");
			
			$content = "";
			// annual number
			$content .= SyTranslator::Annual_review_of_the_number_of_reservations_of($lang) . " " . Configuration::get("name") . "\r\n";
			$i = 0;
			foreach ($graphArray['graph'] as $g){
				$i++;
				$content .= $i . " ; " . $g . "\r\n"; 
			}
			
			// annual number
			$content .= "\r\n";
			$content .= SyTranslator::Annual_review_of_the_time_of_reservations_of($lang) . " " . Configuration::get("name") . "\r\n";
			$i=0;
			foreach ($graphTimeArray['graph'] as $g){
				$i++;
				$content .= $i . " ; " . $g . "\r\n";
			}
			
			// annual resources
			$content .= "\r\n";
			$content .= SyTranslator::Booking_number_year($lang) . " " . Configuration::get("name") . "\r\n";
			foreach ($camembertCount as $g){
				$content .= $g[0] . " ; " . $g[1] . "\r\n";
			}
			
			// annual resources
			$content .= "\r\n";
			$content .= SyTranslator::Booking_time_year($lang) . " " . Configuration::get("name") . "\r\n";
			foreach ($camembertTimeCount as $g){
				$content .= $g[0] . " ; " . $g[1] . "\r\n";
			}
			echo $content;
			return;
			
		}
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
	 * List of pricing per unit
	 */
	public function unitpricing(){
		
		if($this->secureCheck()){
			return;
		}
		
		$modelUnitPricing = new SyUnitPricing();
		$pricingArray = $modelUnitPricing->allPricingTable();
		
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar, 'pricingArray' => $pricingArray
		) );
	}
	
	/**
	 * Form to add a pricing for a unit
	 */
	public function addunitpricing(){
		
		if($this->secureCheck()){
			return;
		}
		
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
		
		$modelUnit = new Unit();
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
	 * List of all the resources
	 */
	public function resources(){
		
		if($this->secureCheck()){
			return;
		}
		
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
	
	/**
	 * Form to add a resource
	 */
	public function addresource(){
		
		if($this->secureCheck()){
			return;
		}
		
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
	
	/**
	 * List of the resources categories
	 */
	public function resourcescategory(){
		
		if($this->secureCheck()){
			return;
		}
		
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
	
	/**
	 * Form to add a resource category
	 */
	public function addresourcescategory(){
		
		if($this->secureCheck()){
			return;
		}
		
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
		) );
	}
	
	/**
	 * Query to add a resource category
	 */
	public function addresourcescategoryquery(){
	
		if($this->secureCheck()){
			return;
		}
		
		// get form variables
		$name = $this->request->getParameter ( "name" );
	
		// get the user list
		$rcModel = new SyResourcesCategory();
		$rcModel->addResourcesCategory ( $name );
	
		$this->redirect ( "sygrrif", "resourcescategory" );
	}
	
	/**
	 * Form to edit a resource category
	 */
	public function editresourcescategory(){
	
		if($this->secureCheck()){
			return;
		}
		
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
	
	/**
	 * Query to edit a resources category
	 */
	public function editresourcescategoryquery(){
	
		if($this->secureCheck()){
			return;
		}
		
		// get form variables
		$id = $this->request->getParameter ( "id" );
		$name = $this->request->getParameter ( "name" );
	
		// get the user list
		$rcModel = new SyResourcesCategory();
		$rcModel->editResourcesCategory ( $id, $name );
	
		$this->redirect ( "sygrrif", "resourcescategory" );
	}
	
	/**
	 * delete a resource category
	 */
	public function deleteresourcecategory(){
		
		if($this->secureCheck()){
			return;
		}
		
		$id = "";
		if ($this->request->isParameterNotEmpty('actionid')){
			$id = $this->request->getParameter("actionid");
		}
		
		$model = new SyResourcesCategory();
		$model->delete($id);
		
		$this->redirect("sygrrif", "resourcescategory");
	}
	
	/**
	 * List of Visa
	 */
	public function visa(){
		
		if($this->secureCheck()){
			return;
		}
		
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
	
	/**
	 * Form to add a visa
	 */
	public function addvisa(){
	
		if($this->secureCheck()){
			return;
		}
		
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
		) );
	}
	
	/**
	 * query to add a visa
	 */
	public function addvisaquery(){
		
		if($this->secureCheck()){
			return;
		}
		
		// get form variables
		$name = $this->request->getParameter ( "name" );
		
		// get the user list
		$visaModel = new SyVisa();
		$visaModel->addVisa ( $name );
		
		$this->redirect ( "sygrrif", "visa" );
	}
	
	/**
	 * Form to edit a visa
	 */
	public function editvisa(){
		
		if($this->secureCheck()){
			return;
		}
		
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
	
	/**
	 * Query to edit a visa
	 */
	public function editvisaquery(){
		
		if($this->secureCheck()){
			return;
		}
		
		// get form variables
		$id = $this->request->getParameter ( "id" );
		$name = $this->request->getParameter ( "name" );
		
		// get the user list
		$visaModel = new SyVisa();
		$visaModel->editVisa ( $id, $name );
		
		$this->redirect ( "sygrrif", "visa" );
	} 
	
	/**
	 * Delete  visa
	 */
	public function deletevisa(){
		
		if($this->secureCheck()){
			return;
		}

		$id = 0;
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$id = $this->request->getParameter ( "actionid" );
		}
		
		// get the user list
		$visaModel = new SyVisa();
		$visaModel->delete( $id );
		
		$this->redirect ( "sygrrif", "visa" );
	}
	
	/**
	 * List of all authorizations
	 */
	public function authorizations(){
		
		if($this->secureCheck()){
			return;
		}
		
		// get user id
		$sortentry = 0;
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$sortentry = $this->request->getParameter ( "actionid" );
		}
		
		// query
		$authModel = new SyAuthorization();
		$authorizationTable = $authModel->getActiveAuthorizations ( $sortentry );
		
		// view
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'authorizationTable' => $authorizationTable
		) );
	}
	
	/**
	 * List of unactive authorizations
	 */
	public function uauthorizations(){
		
		if($this->secureCheck()){
			return;
		}
		
		// get user id
		$sortentry = 0;
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$sortentry = $this->request->getParameter ( "actionid" );
		}
	
		// query
		$authModel = new SyAuthorization();
		$authorizationTable = $authModel->getActiveAuthorizations ( $sortentry,0 );
	
		// view
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'authorizationTable' => $authorizationTable,
				'isInactive' => true
		),"authorizations" );
	}
	
	/**
	 * Form to add an authorization
	 */
	public function addauthorization(){
		
		if($this->secureCheck()){
			return;
		}
		
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
	
	/**
	 * Form to edit an authorization
	 */
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
	
	/**
	 * Query to edit an authorization
	 */
	public function editauthorizationsquery(){
		
		$lang = "En";
		if (isset($_SESSION["user_settings"]["language"])){
			$lang = $_SESSION["user_settings"]["language"];
		}
		
		$id = $this->request->getParameter('id');
		$user_id = $this->request->getParameter('user_id');
		$unit_id = $this->request->getParameter('unit_id');
		$date = $this->request->getParameter('date');
		$visa_id = $this->request->getParameter('visa_id');
		$resource_id = $this->request->getParameter('resource_id');
		$is_active = $this->request->getParameter('is_active');
		
		if ($date != ""){
			$date = CoreTranslator::dateToEn($date, $lang);
		}
		
		$model = new SyAuthorization();
		$model->editAuthorization($id, $date, $user_id, $unit_id, $visa_id, $resource_id);
		//echo "is active = " . (int)$is_active . "<br/>";
		if ($is_active > 0){
			$model->activate($id);
		}
		else{
			$model->unactivate($id);
		}
		//$model->setActive($id, (int)$is_active);
		
		$this->redirect ( "sygrrif", "authorizations" );
	}
	
	/**
	 * Query to add an authorization
	 */
	public function addauthorizationsquery(){
		
		$lang = "En";
		if (isset($_SESSION["user_settings"]["language"])){
			$lang = $_SESSION["user_settings"]["language"];
		}
		
		$user_id = $this->request->getParameter('user_id');
		//$unit_id = $this->request->getParameter('unit_id');
		$date = $this->request->getParameter('date');
		$visa_id = $this->request->getParameter('visa_id');
		$resource_id = $this->request->getParameter('resource_id');
		
		if ($date != ""){
			$date = CoreTranslator::dateToEn($date, $lang);
		}
		
		$modelUser = new User();
		$unit_id = $modelUser->getUserUnit($user_id);
		
		$model = new SyAuthorization();
		$model->addAuthorization($date, $user_id, $unit_id, $visa_id, $resource_id);
		
		$this->redirect ( "sygrrif", "authorizations" );
	}
	
	/**
	 * Form to generate a bill for a unit
	 */
	public function statpriceunits(){
		
		$lang = "En";
		if ( isset($_SESSION["user_settings"]["language"])){
			$lang = $_SESSION["user_settings"]["language"];
		}
		
		// get the form parameters
		$searchDate_start = $this->request->getParameterNoException('searchDate_start');
		$searchDate_end = $this->request->getParameterNoException('searchDate_end');
		$unit_id = $this->request->getParameterNoException('unit');
		$responsible_id = $this->request->getParameterNoException('responsible');
		$export_type = $this->request->getParameterNoException('export_type');

		if ($searchDate_start != ""){
			$searchDate_start = CoreTranslator::dateToEn($searchDate_start, $lang);
		}
		if ($searchDate_end != ""){
			$searchDate_end = CoreTranslator::dateToEn($searchDate_end, $lang);
		}
		
		//echo "date start = " . $searchDate_start . "<br/>";
		//echo "date end = " . $searchDate_end . "<br/>";
		
		// get the selected unit
		$selectedUnitId = 0;
		if ($unit_id != ""){
			$selectedUnitId = $unit_id; 
		}
		
		// get the responsibles for this unit
		$responsiblesList = array();
		$modelCalEntry = new SyCalendarEntry();
		if ($selectedUnitId > 0){
			$modeluser = new User();
			
			$responsiblesListInter = $modeluser->getResponsibleOfUnit($selectedUnitId);
			foreach ($responsiblesListInter as $respi){
				
				//print_r($respi);
				$startdate = explode("-", $searchDate_start);
				$startdate = mktime(0, 0, 0, $startdate[1], $startdate[2], $startdate[0]);
				
				$enddate = explode("-", $searchDate_end);
				$enddate = mktime(23, 59, 59, $enddate[1], $enddate[2], $enddate[0]);
				
				if ( $modelCalEntry->hasResponsibleEntry($respi["id"], $startdate, $enddate) == true){
					$responsiblesList[] = $respi;
				}
			}
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
				//return;
				if ($export_type > 0 && $export_type < 4 ){
					$this->output($export_type, $searchDate_start, $searchDate_end, $selectedUnitId, $responsible_id);
					return;
				}
			}
		}
		
		// get units list
		$modelUnit = new Unit();
		$unitsListTmp = $modelUnit->unitsIDName();
		$unitsList = array();
		
		if (	$searchDate_start!= "" && $searchDate_end!= "" ){
			$startdate = explode("-", $searchDate_start);
			$startdate = mktime(0, 0, 0, $startdate[1], $startdate[2], $startdate[0]);
			$enddate = explode("-", $searchDate_end);
			$enddate = mktime(0, 0, 0, $enddate[1], $enddate[2], $enddate[0]);
			foreach ($unitsListTmp as $unit){
				if ($modelCalEntry->hasUnitEntry($unit["id"], $startdate, $enddate) == true){
					$unitsList[] = $unit;
				}
			}
		}
		
		//echo "date start = " . $searchDate_start . "<br/>";
		//echo "date end = " . $searchDate_end . "<br/>";
		
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
	
	/**
	 *  Generate bill query
	 */
	public function output($export_type, $searchDate_start, $searchDate_end, $selectedUnitId, $responsible_id){
		
		ob_end_clean();
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
		}
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
			//echo "book action = " . $actionName . "<br/>";
			$controller->runAction($actionName);
		
	}
	
	/**
	 * Shows the color codes table
	 */
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
	
	/**
	 * Form to add a color code
	 */
	public function addcolorcode(){
	
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
		) );
	}
	
	/**
	 * Quey to add a color code
	 */
	public function addcolorcodequery(){
	
		// get form variables
		$name = $this->request->getParameter ( "name" );
		$color = $this->request->getParameter ( "color" );
		$text_color = $this->request->getParameter ( "text_color" );
		$display_order = $this->request->getParameter ( "display_order" );
		
		
		// get the user list
		$ccModel = new SyColorCode();
		$ccModel->addColorCode($name, $color, $text_color, $display_order);
	
		$this->redirect ( "sygrrif", "colorcodes" );
	}
	
	/**
	 * Form to edit a color code
	 */
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
	
	/**
	 * Query to edit a color code
	 */
	public function editcolorcodequery(){
		$navBar = $this->navBar ();
	
		// get form variables
		$id = $this->request->getParameter ( "id" );
		$name = $this->request->getParameter ( "name" );
		$color = $this->request->getParameter ( "color" );
		$text_color = $this->request->getParameter ( "text_color" );
		$display_order = $this->request->getParameter ( "display_order" );
		
		// get the user list
		$ccModel = new SyColorCode();
		$ccModel->editColorCode($id, $name, $color, $text_color, $display_order);
	
		$this->redirect ( "sygrrif", "colorcodes" );
	}
	
	/**
	 * Query to delete a color code
	 */
	public function deletecolorcode(){
		// get user id
		$ccId = 0;
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$ccId = $this->request->getParameter ( "actionid" );
		}
		
		// get the user list
		$ccModel = new SyColorCode();
		$ccModel->delete($ccId);
		
		$this->redirect ( "sygrrif", "colorcodes" );
	}
	
	/**
	 * Form to make several resources unavailable
	 * @param string $errormessage
	 */
	public function blockresources($errormessage = ""){
		
		$modelResources = new SyResource();
		$resources = $modelResources->resources("name");
		
		$modelColor = new SyColorCode();
		$colorCodes = $modelColor->getColorCodes();
		
		$navBar = $this->navBar ();
		$this->generateView ( array (
				'navBar' => $navBar,
				'resources' => $resources,
				'colorCodes' => $colorCodes,
				'errormessage' => $errormessage
		) );
	}
	
	/**
	 * Query to make several resources unavailable
	 */
	public function blockresourcesquery(){
		$lang = "En";
		if (isset($_SESSION["user_settings"]["language"])){
			$lang = $_SESSION["user_settings"]["language"];
		}
		$navBar = $this->navBar ();
		
		// get form variables
		$short_description = $this->request->getParameter ( "short_description" );
		$resources = $this->request->getParameter ( "resources" );
		$begin_date = $this->request->getParameter ( "begin_date" );
		$begin_hour = $this->request->getParameter ( "begin_hour" );
		$begin_min = $this->request->getParameter ( "begin_min" );
		$end_date = $this->request->getParameter ( "end_date" );
		$end_hour = $this->request->getParameter ( "end_hour" );
		$end_min = $this->request->getParameter ( "end_min" );
		$color_type_id = $this->request->getParameter ( "color_code_id" );
		
		$beginDate = CoreTranslator::dateToEn($begin_date, $lang);
		$beginDate = explode("-", $beginDate);
		$start_time = mktime(intval($begin_hour), intval($begin_min), 0, $beginDate[1], $beginDate[2], $beginDate[0]);
		
		$endDate = CoreTranslator::dateToEn($end_date, $lang);
		$endDate = explode("-", $endDate);
		$end_time = mktime(intval($end_hour), intval($end_min), 0, $endDate[1], $endDate[2], $endDate[0]);
		
		if ($end_time <= $start_time){
			$errormessage = "Error: The begin time must be before the end time";
			$modelResources = new SyResource();
			$resources = $modelResources->resources("name");
			$modelColor = new SyColorCode();
			$colorCodes = $modelColor->getColorCodes();
			$this->generateView ( array (
				'navBar' => $navBar,
				'resources' => $resources,
				'colorCodes' => $colorCodes,	
				'errormessage' => $errormessage
			),"blockresources");
			return;
		}
		
		// Add the booking
		$modelCalEntry = new SyCalendarEntry();
		$userID = $_SESSION["id_user"];
		foreach ($resources as $resource_id){
		
			$conflict = $modelCalEntry->isConflict($start_time, $end_time, $resource_id);
				
			if ($conflict){
				$errormessage = "Error: There is already a reservation for the given slot, please remove it before booking";
				$modelResources = new SyResource();
				$resources = $modelResources->resources("name");
				$modelColor = new SyColorCode(); 
				$colorCodes = $modelColor->getColorCodes();
				$this->generateView ( array (
					'navBar' => $navBar,
					'resources' => $resources,
					'colorCodes' => $colorCodes,	
					'errormessage' => $errormessage
				),"blockresources");
				return;
			}
			$booked_by_id = $userID;
			$recipient_id = $userID;
			$last_update = date("Y-m-d H:i:s", time()); 
			$full_description = "";
			$quantity = "";
			$modelCalEntry->addEntry($start_time, $end_time, $resource_id, $booked_by_id, $recipient_id,
						$last_update, $color_type_id, $short_description, $full_description, $quantity);
		}
		
		$this->redirect ( "sygrrif" );
	}
}
