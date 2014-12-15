<?php

require_once 'Framework/Controller.php';
require_once 'Modules/core/Model/Unit.php';
require_once 'Modules/core/Model/User.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/sygrrif/Model/SyGraph.php';
require_once 'Modules/sygrrif/Model/SyPricing.php';
require_once 'Modules/sygrrif/Model/SyInstall.php';
require_once 'Modules/sygrrif/Model/SyUnitPricing.php';
require_once 'Modules/sygrrif/Model/SyResourceGRR.php';
require_once 'Modules/sygrrif/Model/SyResourcePricing.php';
require_once 'Modules/sygrrif/Model/SyVisa.php';
require_once 'Modules/sygrrif/Model/SyAuthorization.php';
require_once 'Modules/sygrrif/Model/SyResourcesCategory.php';
require_once 'Modules/sygrrif/Model/SyBillGenerator.php';

class ControllerSygrrif extends ControllerSecureNav {

	public function __construct() {
	}

	// Affiche la liste de tous les billets du blog
	public function index() {
		
		$navBar = $this->navBar();

		$this->generateView ( array (
				'navBar' => $navBar
		) );
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
		
		$modelResources = new SyResourceGRR();
		$resourcesArray = $modelResources->resourcesInfo($sortEntry);
		
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar, 'resourcesArray' => $resourcesArray
		) );
		
	}
	
	public function addresource(){
		
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar
		) );
	}
	
	public function addresourcecalendar(){
	
		// get the pricings
		$modelPricing = new SyPricing();
		$pricingTable = $modelPricing->getPrices();
		
		$modelArea = new SyAreaGRR();
		$domainesList = $modelArea->getAreasIDName();
		
		$modelCategories = new SyResourcesCategory();
		$categoriesArray = $modelCategories->getResourcesCategories("name");
	
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar, 'pricingTable' => $pricingTable,
				'domainesList' => $domainesList,
				'categoriesList' => $categoriesArray
		) );
	}
	
	public function addresourcecalendarquery(){
		
		// GRR
		// get GRR form variables
		$room_name = $this->request->getParameter ("room_name");
		$description = $this->request->getParameter ("description");
		$id_domaine = $this->request->getParameter ("id_domaine");
		$id_category = $this->request->getParameter("id_category");
		$order_display = $this->request->getParameter ("order_display");
		$who_can_see = $this->request->getParameter ("who_can_see");
		$statut_room = $this->request->getParameterNoException("statut_room");
		if ($statut_room == ""){$statut_room = 1;}else{$statut_room = 0;} 
		
		$type_affichage_reser = $this->request->getParameter ("type_affichage_reser");
		$capacity = $this->request->getParameter ("capacity");
		$max_booking = $this->request->getParameter ("max_booking");
		$delais_max_resa_room = $this->request->getParameter ("delais_max_resa_room");
		$delais_min_resa_room = $this->request->getParameter ("delais_min_resa_room");
		$delais_option_reservation = $this->request->getParameter ("delais_option_reservation");
		
		$moderate = $this->request->getParameterNoException ("moderate");
		if ($moderate == ""){$moderate = 0;}else{$moderate = 1;}
		$allow_action_in_past = $this->request->getParameterNoException ("allow_action_in_past");
		if ($allow_action_in_past == ""){$allow_action_in_past = 'n';}else{$allow_action_in_past = 'y';}  
		$dont_allow_modify = $this->request->getParameterNoException ("dont_allow_modify");
		if ($dont_allow_modify == ""){$dont_allow_modify = 'n';}else{$dont_allow_modify = 'y';}  
		
		$qui_peut_reserver_pour = $this->request->getParameter ("qui_peut_reserver_pour");
		$active_ressource_empruntee = $this->request->getParameterNoException ("active_ressource_empruntee");
		if ($active_ressource_empruntee == ""){$active_ressource_empruntee = 'n';}else{$active_ressource_empruntee = 'y';}
		
		// run GRR query
		$modelResources = new SyResourceGRR();
		$resourceID = $modelResources->addResource($room_name, $description, $id_domaine, $order_display, $who_can_see, $statut_room,
				                     $type_affichage_reser, $capacity, $max_booking, $delais_max_resa_room, $delais_min_resa_room,
				                     $delais_option_reservation, $moderate, $allow_action_in_past, $dont_allow_modify,
				                     $qui_peut_reserver_pour, $active_ressource_empruntee);
		
		// category query
		$modelResourcesCategory = new SyResourcesCategory();
		$modelResourcesCategory->setCategory($resourceID, $id_category);
		
		// Pricing
		// get pricing variables
		$modelResourcePricing = new SyResourcePricing();
		$modelPricing = new SyPricing();
		$pricingTable = $modelPricing->getPrices();
		foreach ($pricingTable as $pricing){
			$pid = $pricing['id'];
			$pname = $pricing['tarif_name'];
			$punique = $pricing['tarif_unique'];
			$pnight = $pricing['tarif_night'];
			$pwe = $pricing['tarif_we'];
			$priceDay = $this->request->getParameter ($pid. "_day");
			$price_night = 0;
			if ($pnight){
				$price_night = $this->request->getParameter ($pid . "_night");
			}
			$price_we = 0;
			if ($pwe){
				$price_we = $this->request->getParameter ($pid . "_we");
			}
			
			echo "start set pricing";
			$modelResourcePricing->setPricing($resourceID, $pid, $priceDay, $price_night, $price_we);
		}
		
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar
		) );
	}
	
	public function editresource(){
		$id = 0;
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$id = $this->request->getParameter ( "actionid" );
		}
		
		$model = new SyResourceTypeGRR();
		$typeID = $model->getResourceTypeID($id);
		if ($typeID == 1){
			$modelResources = new SyResourceGRR();
			$resource = $modelResources->getResource($id);
			
			$modelPricing = new SyPricing();
			$pricingTable = $modelPricing->getPrices();
			
			$modelCategories = new SyResourcesCategory();
			$categoriesArray = $modelCategories->getResourcesCategories("name");
			
			// fill the pricing table with the prices for this resource
			$modelResourcesPricing = new SyResourcePricing();
			for ($i = 0 ; $i < count($pricingTable) ; ++$i){
				$pid = $pricingTable[$i]['id'];
				$inter = $modelResourcesPricing->getPrice($id, $pid);
				$pricingTable[$i]['val_day'] = $inter['price_day'];
				$pricingTable[$i]['val_night'] = $inter['price_night'];
				$pricingTable[$i]['val_we'] = $inter['price_we'];
			}
			
			$modelArea = new SyAreaGRR();
			$domainesList = $modelArea->getAreasIDName();
			
			
			//print_r($resource);
			$navBar = $this->navBar();
			$this->generateView ( array (
					'navBar' => $navBar, 'resource' => $resource,
					'pricingTable' => $pricingTable,
					'categoriesList' => $categoriesArray,
					'typeEdit' => 1, 'domainesList' => $domainesList
			) );
		}
	}
	
	public function editresourcecalendarquery(){
	
		// GRR
		// get GRR form variables
		$resourceID = $this->request->getParameter('resource_id');
		$room_name = $this->request->getParameter ("room_name");
		$description = $this->request->getParameter ("description");
		$id_domaine = $this->request->getParameter ("id_domaine");
		$id_category = $this->request->getParameter("id_category");
		$order_display = $this->request->getParameter ("order_display");
		$who_can_see = $this->request->getParameter ("who_can_see");
		$statut_room = $this->request->getParameterNoException("statut_room");
		if ($statut_room == ""){$statut_room = 1;}else{$statut_room = 0;}
	
		$type_affichage_reser = $this->request->getParameter ("type_affichage_reser");
		$capacity = $this->request->getParameter ("capacity");
		$max_booking = $this->request->getParameter ("max_booking");
		$delais_max_resa_room = $this->request->getParameter ("delais_max_resa_room");
		$delais_min_resa_room = $this->request->getParameter ("delais_min_resa_room");
		$delais_option_reservation = $this->request->getParameter ("delais_option_reservation");
	
		$moderate = $this->request->getParameterNoException ("moderate");
		if ($moderate == ""){$moderate = 0;}else{$moderate = 1;}
		$allow_action_in_past = $this->request->getParameterNoException ("allow_action_in_past");
		if ($allow_action_in_past == ""){$allow_action_in_past = 'n';}else{$allow_action_in_past = 'y';}
		$dont_allow_modify = $this->request->getParameterNoException ("dont_allow_modify");
		if ($dont_allow_modify == ""){$dont_allow_modify = 'n';}else{$dont_allow_modify = 'y';}
	
		$qui_peut_reserver_pour = $this->request->getParameter ("qui_peut_reserver_pour");
		$active_ressource_empruntee = $this->request->getParameterNoException ("active_ressource_empruntee");
		if ($active_ressource_empruntee == ""){$active_ressource_empruntee = 'n';}else{$active_ressource_empruntee = 'y';}
	
		// run GRR query
		$modelResources = new SyResourceGRR();
		$modelResources->editResource($resourceID, $room_name, $description, $id_domaine, $order_display, $who_can_see, $statut_room,
				$type_affichage_reser, $capacity, $max_booking, $delais_max_resa_room, $delais_min_resa_room,
				$delais_option_reservation, $moderate, $allow_action_in_past, $dont_allow_modify,
				$qui_peut_reserver_pour, $active_ressource_empruntee);
		
		// category query
		$modelResourcesCategory = new SyResourcesCategory();
		$modelResourcesCategory->setCategory($resourceID, $id_category);
	
		// Pricing
		// get pricing variables
		$modelResourcePricing = new SyResourcePricing();
		$modelPricing = new SyPricing();
		$pricingTable = $modelPricing->getPrices();
		foreach ($pricingTable as $pricing){
			$pid = $pricing['id'];
			$pname = $pricing['tarif_name'];
			$punique = $pricing['tarif_unique'];
			$pnight = $pricing['tarif_night'];
			$pwe = $pricing['tarif_we'];
			$priceDay = $this->request->getParameter ($pid. "_day");
			$price_night = 0;
			if ($pnight){
				$price_night = $this->request->getParameter ($pid . "_night");
			}
			$price_we = 0;
			if ($pwe){
				$price_we = $this->request->getParameter ($pid . "_we");
			}
				
			$modelResourcePricing->setPricing($resourceID, $pid, $priceDay, $price_night, $price_we);
		}
		
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar
		) );
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
		
		print_r($authorization);
		
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
				$errorMessage = "The start date must be before the start date";
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
		

}
