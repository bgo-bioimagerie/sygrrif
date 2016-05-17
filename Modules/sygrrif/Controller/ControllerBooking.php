<?php
require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/sygrrif/Model/SyAuthorization.php';
require_once 'Modules/core/Model/CoreSite.php';

/**
 * Controller containing the common methods for the calendar booking pages
 * 
 * @author sprigent
 *
 */
abstract class ControllerBooking extends ControllerSecureNav {
	
	/**
	 * Get the content of of the booking menu for the calendar pages
	 * @param number $curentAreaId ID of the curent area
	 * @param number $curentResourceId ID of the current resource
	 * @param date $curentDate Curent date
	 * @return array: booking menu content
	 */
	public function calendarMenuData($curentSiteId, $curentAreaId, $curentResourceId, $curentDate){
	
                $modelSite = new CoreSite();
                $sites = $modelSite->getAll("name");
            
		$modelArea = new SyArea();
		$areas = array();
		if ($_SESSION["user_status"] < 3){
			$areas = $modelArea->getUnrestrictedAreasIDName($curentSiteId);
		}
		else{
			$areas = $modelArea->getAreasIDName($curentSiteId);
		}
		
		$modelResource = new SyResource();
		$resources = $modelResource->resourceIDNameForArea($curentAreaId);
                
		return array(   'sites' => $sites,
                                'areas' => $areas, 
				'resources' => $resources,
                                'curentSiteId' => $curentSiteId,
				'curentAreaId' => $curentAreaId, 
				'curentResourceId' => $curentResourceId, 
				'curentDate' => $curentDate
		);
	}
	
	/**
	 * Check if a given user is allowed to book a ressource
	 * @param number $id_resourcecategory ID of the resource category
	 * @param number $resourceAccess Type of users who can access the resource
	 * @param number $id_user User ID
	 * @param number $userStatus User status
	 * @param number $curentDateUnix Curent date in unix format 
	 * @return boolean
	 */
	protected function hasAuthorization($id_resourcecategory, $resourceAccess, $id_user, $userStatus, $curentDateUnix){

		// user cannot book in the past
		if ($curentDateUnix < mktime(0, 0, 0, date("m", time()), date("d", time()), date("Y", time()) ) && $userStatus < 3){
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
