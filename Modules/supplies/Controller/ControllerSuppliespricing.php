<?php

require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/supplies/Model/SuPricing.php';
require_once 'Modules/supplies/Model/SuUnitPricing.php';
require_once 'Modules/supplies/Model/SuUnit.php';
require_once 'Modules/core/Model/CoreUnit.php';


class ControllerSuppliespricing extends ControllerSecureNav {

	public function __construct() {
	}

	public function index() {

		$sort = "id";
		if ($this->request->isParameterNotEmpty('actionid')){
			$sort = $this->request->getParameter("actionid");
		}
	
		$modelPricing = new SuPricing();
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
	
		$modelPricing = new SuPricing();
		$modelPricing->addPricing($nom);
		
		$this->redirect('suppliespricing');
	
	}

	public function editpricing(){
	
		// get user id
		$id = 0;
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$id = $this->request->getParameter ( "actionid" );
		}
	
		$modelPricing = new SuPricing();
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
	
		$modelPricing = new SuPricing();
		$modelPricing->editPricing($id, $nom);
	
	
		$this->redirect('suppliespricing');
	}

	public function unitpricing(){
	
		$modelUnitPricing = new SuUnitPricing();
		$pricingArray = $modelUnitPricing->allPricingTable();
	
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar, 'pricingArray' => $pricingArray
		) );
	}

	public function addunitpricing(){
			
		$modelConfig = new CoreConfig();
		$supliesusersdatabase = $modelConfig->getParam("supliesusersdatabase");
		
		$unitsList = array();
		if ($supliesusersdatabase == "local"){
			$modelUnit = new SuUnit();
			$unitsList = $modelUnit->unitsIDName();
		}
		else{
			$modelUnit = new CoreUnit();
			$unitsList = $modelUnit->unitsIDName();
		}
	
		$modelPricing = new SuPricing();
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
	
		$modelPricing = new SuUnitPricing();
		$modelPricing->setPricing($id_unit, $id_pricing);
	
		$this->redirect("suppliespricing", "unitpricing");
	}

	public function editunitpricing(){
		// get unit id
		$unit_id = 0;
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$unit_id = $this->request->getParameter ( "actionid" );
		}
	
		$modelConfig = new CoreConfig();
		$supliesusersdatabase = $modelConfig->getParam("supliesusersdatabase");
		$unitName = "";
		if ($supliesusersdatabase == "local"){
			$modelUnit = new SuUnit();
			$unitName = $modelUnit->getUnitName($unit_id);
		}
		else{
			$modelUnit = new CoreUnit();
			$unitName = $modelUnit->getUnitName($unit_id);
		}
	
		$modelPricing = new SuPricing();
		$pricingList = $modelPricing->pricingsIDName();
		
		$modelPricing = new SuUnitPricing();
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
	
		$modelPricing = new SuUnitPricing();
		$modelPricing->setPricing($id_unit, $id_pricing);
	
		$this->redirect("suppliespricing", "unitpricing");
	}
}
