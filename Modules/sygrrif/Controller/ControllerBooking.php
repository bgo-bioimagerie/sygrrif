<?php

require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/sygrrif/Model/SyAuthorization.php';

abstract class ControllerBooking extends ControllerSecureNav {

	public function calendarMenuData($curentAreaId, $curentResourceId, $curentDate){
	
		$modelArea = new SyArea();
		$areas = "";
		if ($_SESSION["user_status"] < 3){
			$areas = $modelArea->getUnrestrictedAreasIDName();
		}
		else{
			$areas = $modelArea->getAreasIDName();
		}
		
		$modelResource = new SyResource();
		$resources = $modelResource->resourceIDNameForArea($curentAreaId);
	
		return array('areas' => $areas, 
				'resources' => $resources,
				'curentAreaId' => $curentAreaId, 
				'curentResourceId' => $curentResourceId, 
				'curentDate' => $curentDate
		);
	}
	
	protected function hasAuthorization($id_resourcecategory, $resourceAccess, $id_user, $userStatus, $curentDateUnix){

		//echo "curentDateUnix = " .$curentDateUnix . "</br>";
		//echo "time = " .time() . "</br>";
		// user cannot book in the past
		if ($curentDateUnix < time() && $userStatus < 3){
			return false;
		}
		
		// test depending the user status and resource
		$isUserAuthorizedToBook = false;
		if ($resourceAccess == 1){
			if ($userStatus > 1){
				$isUserAuthorizedToBook = true;
			}
		}
		if ($resourceAccess == 2){
			if ($userStatus > 2){
				$isUserAuthorizedToBook = true;
			}
			if ($userStatus == 2){
				// check if the user has been authorized
				$modelAuth = new SyAuthorization();
				$isUserAuthorizedToBook = $modelAuth->hasAuthorization($id_resourcecategory, $id_user);
				//echo "authorized user = " . $isUserAuthorizedToBook . "";
			}
		}
		if ($resourceAccess == 3){
			if ($userStatus >= 3){
				$isUserAuthorizedToBook = true;
			}
		}
		if ($resourceAccess == 4){
			if ($userStatus >= 4){
				$isUserAuthorizedToBook = true;
			}
		}
		return $isUserAuthorizedToBook;
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
