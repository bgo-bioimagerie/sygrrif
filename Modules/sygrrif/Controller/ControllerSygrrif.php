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



class ControllerSygrrif extends ControllerSecureNav {

	//private $billet;
	public function __construct() {
		//$this->billet = new Billet ();
	}

	// Affiche la liste de tous les billets du blog
	public function index() {
		
		$navBar = $this->navBar();

		$this->generateView ( array (
				'navBar' => $navBar
		) );
	}
	
	public function statistics(){

		$year = 2014;
		if ($this->request->isParameterNotEmpty('actionid')){
			$year = $this->request->getParameter("actionid");
		}
		
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
		
		print_r($pricing);
		
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
		
		print_r($unitName);
		
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
	
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar, 'pricingTable' => $pricingTable,
				'domainesList' => $domainesList
		) );
	}
	
	public function addresourcecalendarquery(){
		
		// GRR
		// get GRR form variables
		$room_name = $this->request->getParameter ("room_name");
		$description = $this->request->getParameter ("description");
		$id_domaine = $this->request->getParameter ("id_domaine");
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
		$modelResource = new SyResource();
		$resources = $modelResource->resources();
		
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
	
}
