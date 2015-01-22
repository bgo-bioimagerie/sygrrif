<?php

require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/sygrrif/Model/SyAuthorization.php';

abstract class ControllerBooking extends ControllerSecureNav {

	public function calendarMenuData($curentAreaId, $curentResourceId, $curentDate){
	
		$modelArea = new SyArea();
		$areas = array();
		if ($_SESSION["user_status"] < 3){
			$areas = $modelArea->getUnrestrictedAreasIDName();
		}
		else{
			$areas = $modelArea->getAreasIDName();
		}
		
		$modelResource = new SyResource();
		$resources = $modelResource->resourceIDNameForArea($curentAreaId);
		
		/*
		echo "curentAreaId id = " . $curentAreaId . "</br>"; 
		print_r($resources);
		echo "areas </br>";
		print_r($areas);
		*/
		
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
		
		//echo "resource access = " . $resourceAccess . "</br>"; 
		//echo "userStatus = " . $userStatus . "</br>";
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
			//echo "pass 1 </Br>";
			if ($userStatus > 2){
				$isUserAuthorizedToBook = true;
			}
			if ($userStatus == 2){
				//echo "pass </Br>";
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
}
