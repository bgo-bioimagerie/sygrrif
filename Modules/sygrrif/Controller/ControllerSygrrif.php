<?php

require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/sygrrif/Model/SyGraph.php';
require_once 'Modules/sygrrif/Model/SyPricing.php';
require_once 'Modules/sygrrif/Model/SyInstall.php';
require_once 'Modules/sygrrif/Model/SyUnitPricing.php';
require_once 'Modules/core/Model/Unit.php';

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
		
		/**
		 *  @todo remove this and do install module
		 */
		$installModel = new SyInstall();
		$installModel->createDatabase();
		
		
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
	
	public function addresourcecalendar(){
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar
		) );
	}
}
