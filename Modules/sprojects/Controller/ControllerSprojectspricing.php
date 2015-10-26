<?php

require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/sprojects/Model/SpPricing.php';
require_once 'Modules/sprojects/Model/SpUnitPricing.php';
require_once 'Modules/sprojects/Model/SpUnit.php';
require_once 'Modules/core/Model/Unit.php';


class ControllerSprojectspricing extends ControllerSecureNav {

	public function __construct() {
	}

	public function index() {

		$sort = "id";
		if ($this->request->isParameterNotEmpty('actionid')){
			$sort = $this->request->getParameter("actionid");
		}
	
		$modelPricing = new SpPricing();
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
		$color = $this->request->getParameter ( "color" );
	
		$modelPricing = new SpPricing();
		$modelPricing->addPricing($nom, $color);
		
		$this->redirect('sprojectspricing');
	
	}

	public function editpricing(){
	
		// get user id
		$id = 0;
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$id = $this->request->getParameter ( "actionid" );
		}
	
		$modelPricing = new SpPricing();
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
		$color = $this->request->getParameter ( "color" );
	
		$modelPricing = new SpPricing();
		$modelPricing->editPricing($id, $nom, $color);
	
	
		$this->redirect('sprojectspricing');
	}

	public function unitpricing(){
	
		$modelUnitPricing = new SpUnitPricing();
		$pricingArray = $modelUnitPricing->allPricingTable();
	
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar, 'pricingArray' => $pricingArray
		) );
	}

	public function addunitpricing(){
			
		$modelConfig = new CoreConfig();
		$sprojectsusersdatabase = $modelConfig->getParam("sprojectsusersdatabase");
		
		$unitsList = array();
		if ($sprojectsusersdatabase == "local"){
			$modelUnit = new SpUnit();
			$unitsList = $modelUnit->unitsIDName();
		}
		else{
			$modelUnit = new Unit();
			$unitsList = $modelUnit->unitsIDName();
		}
	
		$modelPricing = new SpPricing();
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
	
		$modelPricing = new SpUnitPricing();
		$modelPricing->setPricing($id_unit, $id_pricing);
	
		$this->redirect("sprojectspricing", "unitpricing");
	}

	public function editunitpricing(){
		// get unit id
		$unit_id = 0;
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$unit_id = $this->request->getParameter ( "actionid" );
		}
	
		$modelConfig = new CoreConfig();
		$sprojectsusersdatabase = $modelConfig->getParam("sprojectsusersdatabase");
		$unitName = "";
		if ($sprojectsusersdatabase == "local"){
			$modelUnit = new SpUnit();
			$unitName = $modelUnit->getUnitName($unit_id);
		}
		else{
			$modelUnit = new Unit();
			$unitName = $modelUnit->getUnitName($unit_id);
		}
	
		$modelPricing = new SpPricing();
		$pricingList = $modelPricing->pricingsIDName();
		
		$modelPricing = new SpUnitPricing();
		$curentPricingId = $modelPricing->getPricing($unit_id);
	
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar, 'unitName' => $unitName,
				'unitId' => $unit_id, 'curentPricingId' => $curentPricingId,
				'pricingList' => $pricingList
		) );
	}

	public function editunitpricingquery(){
		// get form variables
		$id_unit = $this->request->getParameter ( "id_unit" );
		$id_pricing = $this->request->getParameter ( "id_pricing" );
	
		$modelPricing = new SpUnitPricing();
		$modelPricing->setPricing($id_unit, $id_pricing);
	
		$this->redirect("sprojectspricing", "unitpricing");
	}
}
