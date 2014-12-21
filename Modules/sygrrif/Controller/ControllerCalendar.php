<?php

require_once 'Framework/Controller.php';
require_once 'Modules/core/Model/User.php';
require_once 'Modules/sygrrif/Controller/ControllerBooking.php';
require_once 'Modules/sygrrif/Model/SyResourceCalendar.php';
require_once 'Modules/sygrrif/Model/SyResource.php';
require_once 'Modules/sygrrif/Model/SyResourceType.php';
require_once 'Modules/sygrrif/Model/SyPricing.php';
require_once 'Modules/sygrrif/Model/SyResourcesCategory.php';
require_once 'Modules/sygrrif/Model/SyArea.php';
require_once 'Modules/sygrrif/Model/SyResourcePricing.php';
require_once 'Modules/sygrrif/Model/SyResourceCalendar.php';
require_once 'Modules/sygrrif/Model/SyCalendarEntry.php';
require_once 'Modules/sygrrif/Model/SyCalendarEntry.php';

class ControllerCalendar extends ControllerBooking {

	public function index() {
		
	}
	
	public function editcalendarresource(){
		
		$id = "";
		if ($this->request->isParameterNotEmpty("actionid")) {
			$id = $this->request->getParameter ( "actionid" );
		}
		
		// default values
		$name = "";
		$description = "";
		$accessibility_id = 4;
		$category_id = 0;
		$area_id = 0;
		// default values specific
		$nb_people_max = -1;
		$available_days = "1,1,1,1,1,1,1";
		$day_begin = 8;
		$day_end = 19;
		$size_bloc_resa = 1800;
		
		// type id
		$mrs = new SyResourceType();
		$type_id = $mrs->getTypeId("Calendar");
		
		if ($id != ""){ // get the resource informations
			
			// get common info
			$modelResource = new SyResource();
			$resourceInfo = $modelResource->resource($id);
			$name = $resourceInfo["name"]; 
			$description = $resourceInfo["description"]; 
			$accessibility_id = $resourceInfo["accessibility_id"]; 
			$type_id = $resourceInfo["type_id"]; 
			$category_id = $resourceInfo["category_id"]; 
			$area_id = $resourceInfo["area_id"]; 
			
			$modelCResource = new SyResourceCalendar();
			$resourceCInfo = $modelCResource->resource($id);
			$nb_people_max = $resourceCInfo["nb_people_max"];
			$available_days = $resourceCInfo["available_days"];
			$day_begin = $resourceCInfo["day_begin"];
			$day_end = $resourceCInfo["day_end"];
			$size_bloc_resa = $resourceCInfo["size_bloc_resa"];
		}
		
		// parse de days
		$days_array = explode(",", $available_days);

		// pricing
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
		
		// resources categories
		$modelcategory = new SyResourcesCategory();
		$cateoriesList = $modelcategory->getResourcesCategories("name");
		
		// areas list
		$modelArea = new SyArea();
		$areasList = $modelArea->getAreasIDName();
		
		// view
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'id' => $id,
				'name' => $name,
				'description' => $description,
				'accessibility_id' => $accessibility_id,
				'type_id' => $type_id,
				'category_id' => $category_id,
				'nb_people_max' => $nb_people_max,
				'available_days' => $available_days,
				'day_begin' => $day_begin,
				'day_end' => $day_end,
				'size_bloc_resa' => $size_bloc_resa,
				'days_array' => $days_array,
				'pricingTable'=> $pricingTable,
				'cateoriesList' => $cateoriesList,
				'areasList' => $areasList,
				'area_id' => $area_id
		) );
		
	}
	
	public function editcalendarresourcequery(){
		
		// general data
		$id = $this->request->getParameterNoException('id');
		$name = $this->request->getParameter("name");
		$description = $this->request->getParameter("description");
		$accessibility_id = $this->request->getParameter("accessibility_id");
		$category_id = $this->request->getParameter("category_id");
		$area_id = $this->request->getParameter("area_id");
		
		// type id
		$mrs = new SyResourceType();
		$type_id = $mrs->getTypeId("Calendar");
		
		$modelResource = new SyResource();
		$id_resource = $id;
		if ($id == ""){
			$id_resource = $modelResource->addResource($name, $description, $accessibility_id, $type_id, $area_id, $category_id);
		}
		else{
			$modelResource->editResource($id, $name, $description, $accessibility_id, $type_id, $area_id, $category_id);
		}
		
		// specific to calendar query
		$nb_people_max = $this->request->getParameter("nb_people_max");
		$day_begin = $this->request->getParameter("day_begin");
		$day_end = $this->request->getParameter("day_end");
		$size_bloc_resa = $this->request->getParameter("size_bloc_resa");

		$lundi = $this->request->getParameterNoException ( "monday");
		$mardi = $this->request->getParameterNoException ( "tuesday");
		$mercredi = $this->request->getParameterNoException ( "wednesday");
		$jeudi = $this->request->getParameterNoException ( "thursday");
		$vendredi = $this->request->getParameterNoException ( "friday");
		$samedi = $this->request->getParameterNoException ( "saturday");
		$dimanche = $this->request->getParameterNoException ( "sunday");
		
		if ($lundi != ""){$lundi = "1";}else{$lundi = "0";}
		if ($mardi != ""){$mardi = "1";}else{$mardi = "0";}
		if ($mercredi != ""){$mercredi = "1";}else{$mercredi = "0";}
		if ($jeudi != ""){$jeudi = "1";}else{$jeudi = "0";}
		if ($vendredi != ""){$vendredi = "1";}else{$vendredi = "0";}
		if ($samedi != ""){$samedi = "1";}else{$samedi = "0";}
		if ($dimanche != ""){$dimanche = "1";}else{$dimanche = "0";}
		
		$available_days = $lundi . "," . $mardi . "," . $mercredi . "," . $jeudi . "," . $vendredi . "," . $samedi . "," . $dimanche;
		
		$modelCResource = new SyResourceCalendar();
		$modelCResource->setResource($id_resource, $nb_people_max, $available_days, $day_begin, $day_end, $size_bloc_resa);
		
		// pricing
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
		
			$modelResourcePricing->setPricing($id_resource, $pid, $priceDay, $price_night, $price_we);
		}
		
		$this->redirect("sygrrif", "resources");
	}
	
	public function editunitaryresource(){
	
		$id = "";
		if ($this->request->isParameterNotEmpty("actionid")) {
			$id = $this->request->getParameter ( "actionid" );
		}
	
		// default values
		$name = "";
		$description = "";
		$accessibility_id = 4;
		$category_id = 0;
		$area_id = 0;
		// default values specific
		$quantity_name = "Quantity";
		$available_days = "1,1,1,1,1,1,1";
		$day_begin = 8;
		$day_end = 19;
		$size_bloc_resa = 1800;
	
		// type id
		$mrs = new SyResourceType();
		$type_id = $mrs->getTypeId("Calendar");
	
		if ($id != ""){ // get the resource informations
				
			// get common info
			$modelResource = new SyResource();
			$resourceInfo = $modelResource->resource($id);
			$name = $resourceInfo["name"];
			$description = $resourceInfo["description"];
			$accessibility_id = $resourceInfo["accessibility_id"];
			$type_id = $resourceInfo["type_id"];
			$category_id = $resourceInfo["category_id"];
			$area_id = $resourceInfo["area_id"];
				
			$modelCResource = new SyResourceCalendar();
			$resourceCInfo = $modelCResource->resource($id);
			$quantity_name = $resourceCInfo["quantity_name"];
			$available_days = $resourceCInfo["available_days"];
			$day_begin = $resourceCInfo["day_begin"];
			$day_end = $resourceCInfo["day_end"];
			$size_bloc_resa = $resourceCInfo["size_bloc_resa"];
		}
	
		// parse de days
		$days_array = explode(",", $available_days);
	
		// pricing
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
	
		// resources categories
		$modelcategory = new SyResourcesCategory();
		$cateoriesList = $modelcategory->getResourcesCategories("name");
	
		// areas list
		$modelArea = new SyArea();
		$areasList = $modelArea->getAreasIDName();
	
		// view
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'id' => $id,
				'name' => $name,
				'description' => $description,
				'accessibility_id' => $accessibility_id,
				'type_id' => $type_id,
				'category_id' => $category_id,
				'quantity_name' => $quantity_name,
				'available_days' => $available_days,
				'day_begin' => $day_begin,
				'day_end' => $day_end,
				'size_bloc_resa' => $size_bloc_resa,
				'days_array' => $days_array,
				'pricingTable'=> $pricingTable,
				'cateoriesList' => $cateoriesList,
				'areasList' => $areasList,
				'area_id' => $area_id
		) );
	
	}
	
	public function editunitaryresourcequery(){
	
		// general data
		$id = $this->request->getParameterNoException('id');
		$name = $this->request->getParameter("name");
		$description = $this->request->getParameter("description");
		$accessibility_id = $this->request->getParameter("accessibility_id");
		$category_id = $this->request->getParameter("category_id");
		$area_id = $this->request->getParameter("area_id");
	
		// type id
		$mrs = new SyResourceType();
		$type_id = $mrs->getTypeId("Unitary Calendar");
	
		$modelResource = new SyResource();
		$id_resource = $id;
		if ($id == ""){
			$id_resource = $modelResource->addResource($name, $description, $accessibility_id, $type_id, $area_id, $category_id);
		}
		else{
			$modelResource->editResource($id, $name, $description, $accessibility_id, $type_id, $area_id, $category_id);
		}
	
		// specific to calendar query
		$quantity_name = $this->request->getParameter("quantity_name");
		$day_begin = $this->request->getParameter("day_begin");
		$day_end = $this->request->getParameter("day_end");
		$size_bloc_resa = $this->request->getParameter("size_bloc_resa");
	
		$lundi = $this->request->getParameterNoException ( "monday");
		$mardi = $this->request->getParameterNoException ( "tuesday");
		$mercredi = $this->request->getParameterNoException ( "wednesday");
		$jeudi = $this->request->getParameterNoException ( "thursday");
		$vendredi = $this->request->getParameterNoException ( "friday");
		$samedi = $this->request->getParameterNoException ( "saturday");
		$dimanche = $this->request->getParameterNoException ( "sunday");
	
		if ($lundi != ""){$lundi = "1";}else{$lundi = "0";}
		if ($mardi != ""){$mardi = "1";}else{$mardi = "0";}
		if ($mercredi != ""){$mercredi = "1";}else{$mercredi = "0";}
		if ($jeudi != ""){$jeudi = "1";}else{$jeudi = "0";}
		if ($vendredi != ""){$vendredi = "1";}else{$vendredi = "0";}
		if ($samedi != ""){$samedi = "1";}else{$samedi = "0";}
		if ($dimanche != ""){$dimanche = "1";}else{$dimanche = "0";}
	
		$available_days = $lundi . "," . $mardi . "," . $mercredi . "," . $jeudi . "," . $vendredi . "," . $samedi . "," . $dimanche;
	
		$modelCResource = new SyResourceCalendar();
		$modelCResource->setResource($id_resource, 0, $available_days, $day_begin, $day_end, $size_bloc_resa, $quantity_name);
	
		// pricing
		$modelResourcePricing = new SyResourcePricing();
		$modelPricing = new SyPricing();
		$pricingTable = $modelPricing->getPrices();
		foreach ($pricingTable as $pricing){
			$pid = $pricing['id'];
			$pname = $pricing['tarif_name'];
			$punique = 1;
			$pnight = 0;
			$pwe = 0;
			$priceDay = $this->request->getParameter ($pid. "_day");
			$price_night = 0;
			$price_we = 0;
			$modelResourcePricing->setPricing($id_resource, $pid, $priceDay, $price_night, $price_we);
		}
	
		$this->redirect("sygrrif", "resources");
	}
	
	
	
	
	public function book($message = ""){
		
		// get inputs
		$curentResource = $this->request->getParameterNoException('id_resource');
		$curentAreaId = $this->request->getParameterNoException('id_area');
		$curentDate = $this->request->getParameterNoException('curentDate');
		
		if ($curentAreaId == ""){
			$curentResource = $_SESSION['id_resource'];
			$curentAreaId = $_SESSION['id_area'];
			$curentDate = $_SESSION['curentDate'];
		}
		
		// change input if action
		$action = "";
		if ($this->request->isParameterNotEmpty("actionid")) {
			$action = $this->request->getParameter ( "actionid" );
		}
		if ($action == "daybefore" ){
			$curentDate = explode("-", $curentDate);
			$curentTime = mktime(0,0,0,$curentDate[1], $curentDate[2], $curentDate[0] );
			$curentTime = $curentTime - 86400;
			$curentDate = date("Y-m-d", $curentTime);
		}
		if ($action == "dayafter" ){
			$curentDate = explode("-", $curentDate);
			$curentTime = mktime(0,0,0,$curentDate[1], $curentDate[2], $curentDate[0] );
			$curentTime = $curentTime + 86400;
			$curentDate = date("Y-m-d", $curentTime);
		}
		if ($action == "today" ){
			$curentDate = date("Y-m-d", time());
		}
		
		$menuData = $this->calendarMenuData($curentAreaId, $curentResource, $curentDate);
		
		// save the menu info in the session
		$_SESSION['id_resource'] = $curentResource;
		$_SESSION['id_area'] = $curentAreaId;
		$_SESSION['curentDate'] = $curentDate;
		
		// get the resource info
		$modelRescal = new SyResourceCalendar();
		$resourceInfo = $modelRescal->resource($curentResource);
		
		$modelRes = new SyResource();
		$resourceBase = $modelRes->resource($curentResource);
		
		// get the entries for this resource
		$modelEntries = new SyCalendarEntry();
		$calEntries = $modelEntries->getEntriesForDayAndResource($curentDate, $curentResource);
		
		// curentdate unix
		$temp = explode("-", $curentDate);
		$curentDateUnix = mktime(0,0,0,$temp[1], $temp[2], $temp[0]);
		
		// color code
		$modelColor = new SyColorCode();
		$colorcodes = $modelColor->getColorCodes("name");
		
		// isUserAuthorizedToBook	
		$isUserAuthorizedToBook = $this->hasAuthorization($resourceBase["category_id"], $resourceBase["accessibility_id"], 
								$_SESSION['id_user'], $_SESSION["user_status"], $curentDateUnix);
		
		// view
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'menuData' => $menuData,
				'resourceInfo' => $resourceInfo,
				'resourceBase' => $resourceBase,
				'date' => $curentDate,
				'date_unix' => $curentDateUnix,
				'calEntries' => $calEntries,
				'colorcodes' => $colorcodes,
				'isUserAuthorizedToBook' => $isUserAuthorizedToBook,
				'message' => $message
		),"book" );
	}
	
	public function editReservation(){
		
		// get the action
		$action = '';
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$action = $this->request->getParameter ( "actionid" );
		}
		$contentAction = explode("_", $action);
		
		// get the menu info
		$id_resource = $this->request->getSession()->getAttribut('id_resource');
		$id_area = $this->request->getSession()->getAttribut('id_area');
		$curentDate = $this->request->getSession()->getAttribut('curentDate');
		
		// get the resource info
		$modelRescal = new SyResourceCalendar();
		$resourceInfo = $modelRescal->resource($id_resource);
		$modelRes = new SyResource();
		$resourceBase = $modelRes->resource($id_resource);
		
		// get users list
		$modelUser = new User();
		$users = $modelUser->getUsers("Name");
		
		$curentuserid = $this->request->getSession()->getAttribut("id_user");
		$curentuser = $modelUser->userAllInfo($curentuserid);
		
		// navigation
		$navBar = $this->navBar();
		$menuData = $this->calendarMenuData($id_area, $id_resource, $curentDate);
		
		// color types
		$colorCodeModel = new SyColorCode();
		$colorCodes = $colorCodeModel->getColorCodes();
		
		// a user cannot delete a reservation in the past
		$canEditReservation = false;
		$temp = explode("-", $curentDate);
		$curentDateUnix = mktime(0,0,0,$temp[1], $temp[2], $temp[0]);
		if ($curentDateUnix >= time() && $_SESSION["user_status"] < 3 ){
			$canEditReservation = true;
		}
		if ($_SESSION["user_status"] >= 3){
			$canEditReservation = true;
		}
		
		// set the view given the action		
		if ($contentAction[0] == "t"){ // add resa 
			$beginTime = $contentAction[1];
			$h = floor($beginTime);
			$m = $beginTime - $h;
			if ($m == 0.25){$m=15;}
			if ($m == 0.5){$m=30;}
			if ($m == 0.75){$m=45;}
			$timeBegin = array('h'=> $h, 'm' => $m);
			$timeEnd = array('h'=> $h, 'm' => $m);
			
			// view
			$this->generateView ( array (
					'navBar' => $navBar,
					'menuData' => $menuData,
					'resourceInfo' => $resourceInfo,
					'resourceBase' => $resourceBase,
					'date' => $curentDate,
					'timeBegin' => $timeBegin,
					'timeEnd' => $timeEnd,
					'users' => $users,
					'curentuser' => $curentuser,
					'canEditReservation' => $canEditReservation,
					'colorCodes' => $colorCodes
			) );
		}
		else{ // edit resa
			$reservation_id = $contentAction[1];
			
			$modelResa = new SyCalendarEntry();
			$reservationInfo = $modelResa->getEntry($reservation_id);
			
			if ($_SESSION["user_status"] < 3 && $curentuserid != $reservationInfo["recipient_id"]){
				$canEditReservation = false;
			}
			
			$this->generateView ( array (
					'navBar' => $navBar,
					'menuData' => $menuData,
					'resourceInfo' => $resourceInfo,
					'resourceBase' => $resourceBase,
					'date' => $curentDate,
					'users' => $users,
					'curentuser' => $curentuser,
					'reservationInfo' => $reservationInfo,
					'canEditReservation' => $canEditReservation,
					'colorCodes' => $colorCodes
					
			));
		}
		
	}
	
	public function editreservationquery(){
		
		// get reservation info
		$reservation_id = $this->request->getParameterNoException('reservation_id');
		$resource_id = $this->request->getParameter('resource_id');
		$booked_by_id = $this->request->getSession()->getAttribut("id_user");
		$recipient_id = $this->request->getParameter('recipient_id');
		$last_update = date("Y-m-d H:i:s", time());
		$color_type_id = $this->request->getParameter('color_code_id');
		$short_description = $this->request->getParameter('short_description');
		$full_description = $this->request->getParameter('full_description');
		$is_unitary = $this->request->getParameterNoException('is_unitary');
		
		$quantity = 0;
		if ($is_unitary != ""){
			$quantity = $this->request->getParameter('quantity');
		}
		
		// get reservation date
		$beginDate = $this->request->getParameter('begin_date');
		$beginDate = explode("-", $beginDate);
		$begin_hour =  $this->request->getParameter('begin_hour');
		$begin_min = $this->request->getParameter('begin_min');
		$start_time = mktime($begin_hour, $begin_min, 0, $beginDate[1], $beginDate[2], $beginDate[0]);
		
		$endDate = $this->request->getParameter('end_date');
		$endDate = explode("-", $endDate);
		$end_hour =  $this->request->getParameter('end_hour');
		$end_min = $this->request->getParameter('end_min');
		$end_time = mktime($end_hour, $end_min, 0, $endDate[1], $endDate[2], $endDate[0]);
		
		$modelCalEntry = new SyCalendarEntry();
		
		// test if a resa already exists on this periode
		$conflict = $modelCalEntry->isConflict($start_time, $end_time, $resource_id, $reservation_id);
		
		if ($conflict){
			$this->book("Error: There is already a reservation for the given slot");
			return;
		}
		
		if ($reservation_id == ""){
			$modelCalEntry->addEntry($start_time, $end_time, $resource_id, $booked_by_id, $recipient_id,
									 $last_update, $color_type_id, $short_description, $full_description, $quantity);
		}
		else{
			$modelCalEntry->updateEntry($reservation_id, $start_time, $end_time, $resource_id, $booked_by_id, 
					                   $recipient_id, $last_update, $color_type_id, $short_description, 
					                   $full_description, $quantity);
		}
		
		$_SESSION['id_resource'] = $resource_id;
		$modelResource = new SyResource();
		$areaID = $modelResource->getAreaID($resource_id);
		$_SESSION['id_area'] = $areaID;
		$date = $this->request->getParameter('begin_date');
		//echo "DATE = " .  $date . "--";
		$_SESSION['curentDate'] = $date;
		
		$message = "Success: Your reservation has been saved";
		$this->book($message);
		//$this->redirect("calendar", "book");
	}
	
	public function removeentry(){
		// get the action
		$id = '';
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$id = $this->request->getParameter ( "actionid" );
		}
		
		$modelEntry = new SyCalendarEntry();
		$message = $modelEntry->removeEntry($id);
		
		$this->book($message);
	}
}