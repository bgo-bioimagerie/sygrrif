<?php

require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';

abstract class ControllerBooking extends ControllerSecureNav {

	public function calendarMenuData($curentAreaId, $curentResourceId, $curentDate){
	
		$modelArea = new SyArea();
		$areas = $modelArea->getAreasIDName();
	
		$modelResource = new SyResource();
		$resources = $modelResource->resourceIDNameForArea($curentAreaId);
	
		return array('areas' => $areas, 
				'resources' => $resources,
				'curentAreaId' => $curentAreaId, 
				'curentResourceId' => $curentResourceId, 
				'curentDate' => $curentDate
		);
	}
	
	
	/*
	public function week() {
	
		$buttonId = "";
		if ($this->request->isParameterNotEmpty('actionid')){
			$buttonId = $this->request->getParameter("actionid");
		}
		
		$t = $this->request->getSession()->getAttribut("date");
		
		$ty = date("Y",$t);
		$tm = date("m",$t);
		$td = date("d",$t);
		
		echo "<p> buttonId =" . $buttonId . "</p>";
		echo "<p> t =" . $t . "</p>";
		echo "<p> ty =" . $ty . "</p>";
		echo "<p> tm =" . $tm . "</p>";
		echo "<p> td =" . $td . "</p>";
		
		if ($buttonId == 0){

			$t = date( "Y-m-d", mktime(0, 0, 0, $tm, $td-1, $ty));
		}
		if ($buttonId == 1){
			$t = date( "Y-m-d", mktime(0, 0, 0, $tm, $td+1, $ty));
		}
		
	
		$this->generateView ( array (
				't' => $t
		) );
	}
	*/
}
