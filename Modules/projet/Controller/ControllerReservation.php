<?php
require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerInstall.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/sygrrif/Controller/ControllerBooking.php';
require_once 'Modules/projet/Model/neurinfoprojet.php';
require_once 'Modules/core/Model/CoreTranslator.php';
require_once 'Modules/projet/Model/reservation.php';
require_once 'Modules/sygrrif/Model/SyCalendarSeries.php';
require_once 'Modules/sygrrif/Model/SyCalendarEntry.php';
require_once 'Modules/sygrrif/Model/SyResource.php';
require_once 'Modules/sygrrif/Controller/ControllerBooking.php';
require_once  'Modules/sygrrif/Controller/ControllerCalendar.php';

class ControllerReservation extends ControllerBooking
{
	
	
	public function index(){
		
	}
	   
		
		public function AjouterReservation()
		{
			// get the action
			$action = '';
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$action = $this->request->getParameter ( "actionid" );
		}
		$contentAction = explode("_", $action);
		
		
		if (count($contentAction) > 3){
			$_SESSION["id_resource"] = $contentAction[3];
		}
		
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
		$users = $modelUser->getActiveUsers("Name");
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
		//echo "can edit reservation = " . $canEditReservation . " <br/>";
		$temp = explode("-", $curentDate);
		$H = date("H", time());
		$min = date("i", time());
		$curentDateUnix = mktime($H,$min+1,0,$temp[1], $temp[2], $temp[0]);
		if ($curentDateUnix >= time() && $_SESSION["user_status"] < 3 ){
			$canEditReservation = true;
		}
		if ($_SESSION["user_status"] >= 3){
			$canEditReservation = true;
		}
		//echo "can edit reservation = " . $canEditReservation . "<br/>";
		
		
		$ModulesManagerModel = new ModulesManager();
		$status = $ModulesManagerModel->getDataMenusUserType("projects");
		$projectsList = "";
		if ($status > 0){
			$modelProjects = new Project();
			$projectsList = $modelProjects->openedProjectsIDName(); 
		}
		// is user allowed to series
		$modelCoreConfig = new CoreConfig();
		$seriesBooking = $modelCoreConfig->getParam("SySeriesBooking");
		$showSeries = false;
		if ($seriesBooking > 0 && $_SESSION["user_status"]>=$seriesBooking){
			$showSeries = true;
		}
			
		// set the view given the action		
		if ($contentAction[0] == "t"){ // add resa 
			
			$curentDate = $contentAction[1];
			$beginTime = $contentAction[2];
			$beginTime = str_replace("-", ".", $beginTime);
			$h = floor($beginTime);
			$m = $beginTime - $h;
			if ($m == 0.25){$m=15;}
			if ($m == 0.5){$m=30;}
			if ($m == 0.75){$m=45;}
			$timeBegin = array('h'=> $h, 'm' => $m);
			$timeEnd = array('h'=> $h, 'm' => $m);
			
			// navigation
			$menuData = $this->calendarMenuData($id_area, $_SESSION["id_resource"], $curentDate);
			// view
		$navBar=$this->navBar();
		$modelProjet = new neurinfoprojet();
		$donnee=$modelProjet->getProjet();
		$this->generateView ( array ('navBar' => $navBar,
					'menuData' => $menuData,
					'resourceInfo' => $resourceInfo,
					'resourceBase' => $resourceBase,
					'date' => $curentDate,
					'timeBegin' => $timeBegin,
					'timeEnd' => $timeEnd,
					'users' => $users,
					'curentuser' => $curentuser,
					'canEditReservation' => $canEditReservation,
					'colorCodes' => $colorCodes,
					'projectsList' => $projectsList,
					'showSeries' => $showSeries,
					'donnee'=> $donnee,
					'reserv'=>$reserv
			),"AjouterReservation" );
		}
		

	
	}


		
	public function ajouterreservationquery(){
	$lang = "En";
		if (isset($_SESSION['user_settings']['language'])){
			$lang = $_SESSION['user_settings']['language'];
		}
		// get reservation info
		$reservation_id = $this->request->getParameterNoException('reservation_id');
		$resource_id = $this->request->getParameter('resource_id');
		$booked_by_id = $this->request->getSession()->getAttribut("id_user");
		$recipient_id = $this->request->getParameter('recipient_id');
		$last_update = date("Y-m-d H:i:s", time());
		$color_type_id = $this->request->getParameter('color_code_id');
		$protocol = $this->request->getParameter('acronyme');
		$codeanonym = $this->request->getParameter('codeanonym');
		$numerovisite=$this->request->getParameter('numerovisite');
		$is_unitary = $this->request->getParameterNoException('is_unitary');
		$repeat_id = $this->request->getParameterNoException('repeat_id');
		
		$quantity = 0;
		if ($is_unitary != ""){
			$quantity = $this->request->getParameter('quantity');
		}
		// get reservation date
		$beginDate = $this->request->getParameter('begin_date');
		$beginDate = CoreTranslator::dateToEn($beginDate, $lang);
		$beginDate = explode("-", $beginDate);
		$begin_hour =  $this->request->getParameter('begin_hour');
		$begin_min = $this->request->getParameter('begin_min');
		$start_time = mktime($begin_hour, $begin_min, 0, $beginDate[1], $beginDate[2], $beginDate[0]);
		
		$endDate = $this->request->getParameterNoException('end_date');
		if ($endDate != ""){
			$endDate = CoreTranslator::dateToEn($endDate, $lang);
		}
		$endDate = explode("-", $endDate);
		$end_hour =  $this->request->getParameterNoException('end_hour');
		$end_min = $this->request->getParameterNoException('end_min');
		
		if (count($endDate) > 2){
			$end_time = mktime($end_hour, $end_min, 0, $endDate[1], $endDate[2], $endDate[0]);
		}
		
		$duration = $this->request->getParameterNoException('duration');
		if ($duration != ""){
			$end_time = $start_time + $duration*60;
		}
		
		// get the series info
		$series_type_id = $this->request->getParameterNoException("series_type_id");
		
		
		if ($series_type_id == 0 || $series_type_id == ""){
			
			$modelReservation = new reservation();
			// test if a resa already exists on this periode
			$reserv= $modelReservation->ifresa($start_time, $end_time, $resource_id, $reservation_id);
			
			if ($reserv){
				$this->book("Error: There is already a reservation for the given slot");
				return;
			}
			
			if ($reservation_id == ""){
				$modelReservation->addres($start_time, $end_time, $resource_id, $booked_by_id, $recipient_id,
										 $last_update, $color_type_id, $protocol, $codeanonym, $numerovisite, $quantity);
				$modelReservation->addResCalendarEntry($start_time, $end_time, $resource_id, $booked_by_id, $recipient_id, $last_update, $color_type_id, $protocol, $codeanonym, $numerovisite);
			}
			else{
				$modelReservation->updateres($reservation_id, $start_time, $end_time, $resource_id, $booked_by_id, 
						                   $recipient_id, $last_update, $color_type_id, $protocol, 
						                   $codeanonym, $numerovisite, $quantity);
				$modelReservation->updateresCanlendar($reservation_id, $start_time, $end_time, $resource_id, $booked_by_id, 
						                   $recipient_id, $last_update, $color_type_id, $protocol, 
						                   $codeanonym, $numerovisite, $quantity);
				
			}
		}
		else{
			// get the series info
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
			
			$days_option = $lundi . "," . $mardi . "," . $mercredi . "," . $jeudi . "," . $vendredi . "," . $samedi . "," . $dimanche;
			$seriesEndDate = $this->request->getParameter("series_end_date");
			
			// get the list of all the entries in the series
			$modelCalSeries = new SyCalendarSeries();
			$seriesDates = $modelCalSeries->entriesDates($start_time, $end_time, $series_type_id, $days_option, $seriesEndDate);
			
			// test if there are conflicts
			$modelCalEntry = new SyCalendarEntry();
			for ($d = 0 ; $d < count($seriesDates) ; $d++){
				$conflict = $modelCalEntry->isConflict($seriesDates[$d]['start_time'], $seriesDates[$d]['end_time'], $resource_id, $reservation_id);
					
				if ($conflict){
					$this->book("Error: There is already a reservation for the given series slot");
					return;
				}
			}
			
			// create/update the series entry
			if ($repeat_id == "" || $repeat_id == "0"){
				$repeat_id = $modelCalSeries->addEntry($start_time, $end_time, $series_type_id, $seriesEndDate, $days_option, $resource_id, $booked_by_id,
									  $recipient_id, $last_update, $color_type_id, $short_description, $full_description, $reservationnumber);
			}
			else{
				$modelCalSeries->updateEntry($repeat_id, $start_time, $end_time, $series_type_id, $seriesEndDate, $days_option, $resource_id, 
											$booked_by_id, $recipient_id, $last_update, $color_type_id, $short_description, $full_description, $reservationnumber);
			}
			
			// create the entries
			for ($d = 0 ; $d < count($seriesDates) ; $d++){
				
				$start_time = $seriesDates[$d]['start_time'];
				$end_time = $seriesDates[$d]['end_time'];
				$reservation_id = $modelReservation->addres($start_time, $end_time, $resource_id, $booked_by_id, $recipient_id, $last_update, $color_type_id, $protocol, $codeanonym, $numerovisite,  $quantity); 
						

				$modelReservation->setRepeatID($reservation_id, $repeat_id);
			}
		}
		
		$_SESSION['id_resource'] = $resource_id;
		$modelResource = new SyResource();
		$areaID = $modelResource->getAreaID($resource_id);
		$_SESSION['id_area'] = $areaID;
		$date = $this->request->getParameter('begin_date');
		//echo "date = " . $date . "<br />";
		if ($date != ""){
			$date = CoreTranslator::dateToEn($date, $lang);
		}
		//echo "DATE = " .  $date . "--";
		$_SESSION['curentDate'] = $date;
		
		$message = "Success: Your reservation has been saved";
		$this->book($message);
		$this->redirect("Reservation", "AjouterReservation");
	
	}
	
		public function book($message = ""){
		
		$lastView = "";
		if (isset($_SESSION["user_settings"]["calendarDefaultView"])){
			$lastView = $_SESSION["user_settings"]["calendarDefaultView"];
		}
		if (isset($_SESSION['lastbookview'])){
			$lastView = $_SESSION['lastbookview'];
		}
		if ($lastView == "bookday"){
			$this->bookday($message);
			return;
		}
		else if ($lastView == "bookweek"){
			$this->bookweek($message);
			return;
		}
		else if ($lastView == "bookweekarea"){
			$this->bookweekarea($message);
			return;
		}
		$this->bookday($message);
	}
	
	public function bookday($message = ""){
		
		$_SESSION['lastbookview'] = "bookday";
		
		$lang = "En";
		if (isset($_SESSION["user_settings"]["language"])){
			$lang = $_SESSION["user_settings"]["language"];
		}
		
		// get inputs
		$curentResource = $this->request->getParameterNoException('id_resource');
		$curentAreaId = $this->request->getParameterNoException('id_area');
		$curentDate = $this->request->getParameterNoException('curentDate');
		
		if ($curentDate != ""){
			$curentDate = CoreTranslator::dateToEn($curentDate, $lang);
		}
		
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
		
		if (count($resourceInfo) <=1 ){
			$this->redirect("calendar", "booking");
			return;
		}
		
		$modelRes = new SyResource();
		$resourceBase = $modelRes->resource($curentResource);
		
		// get the entries for this resource
		$modelEntries = new SyCalendarEntry();
		//echo "curent date line 470 = " . $curentDate . "<br/>";
		$dateArray = explode("-", $curentDate);
		$dateBegin = mktime(0,0,0,$dateArray[1],$dateArray[2],$dateArray[0]);
		$dateEnd = mktime(23,59,59,$dateArray[1],$dateArray[2],$dateArray[0]);
		$calEntries = $modelEntries->getEntriesForPeriodeAndResource($dateBegin, $dateEnd, $curentResource);
		
		// curentdate unix
		$temp = explode("-", $curentDate);
		$curentDateUnix = mktime(0,0,0,$temp[1], $temp[2], $temp[0]);
		
		// color code
		$modelColor = new SyColorCode();
		$colorcodes = $modelColor->getColorCodes("name");
		
		// isUserAuthorizedToBook	
		$isUserAuthorizedToBook = $this->hasAuthorization($resourceBase["category_id"], $resourceBase["accessibility_id"], 
								$_SESSION['id_user'], $_SESSION["user_status"], $curentDateUnix);
		$modelReservation= new reservation();
		$reserv= $modelReservation->ifresa($start_time, $end_time, $resource_id, $reservation_id);
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
				'message' => $message,
				'$reserv'=>$reserv,
		),"bookday" );
	}
	
	public function bookweek($message = ""){
	
		$_SESSION['lastbookview'] = "bookweek";
		$lang = "En";
		if (isset($_SESSION["user_settings"]["language"])){
			$lang = $_SESSION["user_settings"]["language"];
		}
		
		// get inputs
		$curentResource = $this->request->getParameterNoException('id_resource');
		$curentAreaId = $this->request->getParameterNoException('id_area');
		$curentDate = $this->request->getParameterNoException('curentDate');

		if ($curentDate != ""){
			$curentDate = CoreTranslator::dateToEn($curentDate, $lang);
		}
	
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
		if ($action == "dayweekbefore" ){
			$curentDate = explode("-", $curentDate);
			$curentTime = mktime(0,0,0,$curentDate[1], $curentDate[2], $curentDate[0] );
			$curentTime = $curentTime - 86400*7;
			$curentDate = date("Y-m-d", $curentTime);
		}
		if ($action == "dayweekafter" ){
			$curentDate = explode("-", $curentDate);
			$curentTime = mktime(0,0,0,$curentDate[1], $curentDate[2], $curentDate[0] );
			$curentTime = $curentTime + 86400*7;
			$curentDate = date("Y-m-d", $curentTime);
		}
		if ($action == "thisWeek" ){
			$curentDate = date("Y-m-d", time());
		}
		
		// get the closest monday to curent day
		$i = 0;
		//echo "curentDate = " . $curentDate . "<br/>";
		$curentDateE = explode("-", $curentDate);
		while(date('D',mktime(0,0,0,$curentDateE[1], $curentDateE[2]-$i, $curentDateE[0])) != "Mon") {
			$i++;
		} 
		$mondayDate = date('Y-m-d', mktime(0,0,0,$curentDateE[1], $curentDateE[2]-($i), $curentDateE[0]));
		$sundayDate  = date('Y-m-d', mktime(0,0,0,$curentDateE[1], $curentDateE[2]-($i)+6, $curentDateE[0]));
		
	
		$menuData = $this->calendarMenuData($curentAreaId, $curentResource, $curentDate);
	
		// save the menu info in the session
		$_SESSION['id_resource'] = $curentResource;
		$_SESSION['id_area'] = $curentAreaId;
		$_SESSION['curentDate'] = $curentDate;
	
		// get the resource info
		$modelRescal = new SyResourceCalendar();
		$resourceInfo = $modelRescal->resource($curentResource);
		
		if (count($resourceInfo) <=1 ){
			$this->redirect("calendar", "booking");
			return;
		}
	
		$modelRes = new SyResource();
		$resourceBase = $modelRes->resource($curentResource);
	
		// get the entries for this resource
		$modelEntries = new SyCalendarEntry();
		$dateArray = explode("-", $mondayDate);
		$dateBegin = mktime(0,0,0,$dateArray[1],$dateArray[2],$dateArray[0]);
		$dateEnd = mktime(23,59,59,$dateArray[1],$dateArray[2]+7,$dateArray[0]);
		$calEntries = $modelEntries->getEntriesForPeriodeAndResource($dateBegin, $dateEnd, $curentResource);
		
		//echo "Cal entry count = " . count($calEntries) . "</br>";
		
		
		// curentdate unix
		$temp = explode("-", $curentDate);
		$curentDateUnix = mktime(0,0,0,$temp[1], $temp[2], $temp[0]);
	
		// color code
		$modelColor = new SyColorCode();
		$colorcodes = $modelColor->getColorCodes("name");
	
		// isUserAuthorizedToBook
		$isUserAuthorizedToBook = $this->hasAuthorization($resourceBase["category_id"], $resourceBase["accessibility_id"],
				$_SESSION['id_user'], $_SESSION["user_status"], $curentDateUnix);
				$modelReservation= new reservation();
			$reserv= $modelReservation->ifresa($start_time, $end_time, $resource_id, $reservation_id);
		// view
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'menuData' => $menuData,
				'resourceInfo' => $resourceInfo,
				'resourceBase' => $resourceBase,
				'date' => $curentDate,
				'date_unix' => $curentDateUnix,
				'mondayDate' => $mondayDate,
				'sundayDate' => $sundayDate,
				'calEntries' => $calEntries,
				'colorcodes' => $colorcodes,
				'isUserAuthorizedToBook' => $isUserAuthorizedToBook,
				'message' => $message,
				'reserv'=>$reserv
		), "bookweek");
		
	}
	
	public function bookmonth($message = ""){
	
		$_SESSION['lastbookview'] = "bookmonth";
		$lang = "En";
		if (isset($_SESSION["user_settings"]["language"])){
			$lang = $_SESSION["user_settings"]["language"];
		}
	
		// get inputs
		$curentResource = $this->request->getParameterNoException('id_resource');
		$curentAreaId = $this->request->getParameterNoException('id_area');
		$curentDate = $this->request->getParameterNoException('curentDate');
	
		if ($curentDate != ""){
			$curentDate = CoreTranslator::dateToEn($curentDate, $lang);
		}
	
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
		$curentTime=0;
		if ($action == "daymonthbefore" ){
			$curentDate = explode("-", $curentDate);
			$curentTime = mktime(0,0,0,$curentDate[1], $curentDate[2], $curentDate[0] );
			$curentTime = $curentTime - 86400*30;
			$curentDate = date("Y-m-d", $curentTime);
		}
		if ($action == "daymonthafter" ){
			$curentDate = explode("-", $curentDate);
			$curentTime = mktime(0,0,0,$curentDate[1], $curentDate[2], $curentDate[0] );
			$curentTime = $curentTime + 86400*30;
			$curentDate = date("Y-m-d", $curentTime);
		}
		if ($action == "thisMonth" ){
			$curentDate = date("Y-m-d", time());
			$curentTime = time();
		}
	
		// get the closest monday to curent day
		
		$i = 0;
		//echo "curentDate = " . $curentDate . "<br/>";
		$curentDateE = explode("-", $curentDate);
		while(date('d',mktime(0,0,0,$curentDateE[1], $curentDateE[2]-$i, $curentDateE[0])) != 1) {
			$i++;
		}
		$mondayDate = date('Y-m-d', mktime(0,0,0,$curentDateE[1], $curentDateE[2]-($i), $curentDateE[0]));
		$sundayDate  = date('Y-m-d', mktime(0,0,0,$curentDateE[1], $curentDateE[2]-($i)+31, $curentDateE[0]));
	
		$menuData = $this->calendarMenuData($curentAreaId, $curentResource, $curentDate);
	
		// save the menu info in the session
		$_SESSION['id_resource'] = $curentResource;
		$_SESSION['id_area'] = $curentAreaId;
		$_SESSION['curentDate'] = $curentDate;
	
		// get the resource info
		$modelRescal = new SyResourceCalendar();
		$resourceInfo = $modelRescal->resource($curentResource);
	
		if (count($resourceInfo) <=1 ){
			$this->redirect("calendar", "booking");
			return;
		}
	
		$modelRes = new SyResource();
		$resourceBase = $modelRes->resource($curentResource);
	
		// get the entries for this resource
		$modelEntries = new SyCalendarEntry();
		$dateArray = explode("-", $mondayDate);
		$dateBegin = mktime(0,0,0,$dateArray[1],$dateArray[2],$dateArray[0]);
		$dateEnd = mktime(23,59,59,$dateArray[1],$dateArray[2]+31,$dateArray[0]);
		$calEntries = $modelEntries->getEntriesForPeriodeAndResource($dateBegin, $dateEnd, $curentResource);
	
		//echo "Cal entry count = " . count($calEntries) . "</br>";
	
	
		// curentdate unix
		$temp = explode("-", $curentDate);
		$curentDateUnix = mktime(0,0,0,$temp[1], $temp[2], $temp[0]);
	
		// color code
		$modelColor = new SyColorCode();
		$colorcodes = $modelColor->getColorCodes("name");
	
		// isUserAuthorizedToBook
		$isUserAuthorizedToBook = $this->hasAuthorization($resourceBase["category_id"], $resourceBase["accessibility_id"],
				$_SESSION['id_user'], $_SESSION["user_status"], $curentDateUnix);
		$modelReservation= new reservation();
		$reserv= $modelReservation->ifresa($start_time, $end_time, $resource_id, $reservation_id);
		// view
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'menuData' => $menuData,
				'resourceInfo' => $resourceInfo,
				'resourceBase' => $resourceBase,
				'date' => $curentDate,
				'month' => date("n", $curentTime),
				'year' => date("Y", $curentTime),
				'date_unix' => $curentDateUnix,
				'mondayDate' => $mondayDate,
				'sundayDate' => $sundayDate,
				'calEntries' => $calEntries,
				'colorcodes' => $colorcodes,
				'isUserAuthorizedToBook' => $isUserAuthorizedToBook,
				'message' => $message,
				'reserv'=>$reserv
		), "bookmonth");
	}
	
	public function bookweekarea($message = ""){
	
		$_SESSION['lastbookview'] = "bookweekarea";
		
		$lang = "En";
		if (isset($_SESSION["user_settings"]["language"])){
			$lang = $_SESSION["user_settings"]["language"];
		}
		
		// get inputs
		$curentResource = $this->request->getParameterNoException('id_resource');
		$curentAreaId = $this->request->getParameterNoException('id_area');
		$curentDate = $this->request->getParameterNoException('curentDate');
		
		if ($curentDate != ""){
			$curentDate = CoreTranslator::dateToEn($curentDate, $lang);
		}
		
		if ($curentAreaId == ""){
			$curentResource = $_SESSION['id_resource'];
			$curentAreaId = $_SESSION['id_area'];
			$curentDate = $_SESSION['curentDate'];
			//echo "curent date n-2 = " . $curentDate . "<br/>";
		}
	
		//echo "curent date n-1= " . $curentDate . "<br/>";
		// change input if action
		$action = "";
		if ($this->request->isParameterNotEmpty("actionid")) {
			$action = $this->request->getParameter ( "actionid" );
		}
		if ($action == "dayweekbefore" ){
			$curentDate = explode("-", $curentDate);
			$curentTime = mktime(0,0,0,$curentDate[1], $curentDate[2], $curentDate[0] );
			$curentTime = $curentTime - 86400*7;
			$curentDate = date("Y-m-d", $curentTime);
		}
		if ($action == "dayweekafter" ){
			$curentDate = explode("-", $curentDate);
			$curentTime = mktime(0,0,0,$curentDate[1], $curentDate[2], $curentDate[0] );
			$curentTime = $curentTime + 86400*7;
			$curentDate = date("Y-m-d", $curentTime);
		}
		if ($action == "thisWeek" ){
			$curentDate = date("Y-m-d", time());
		}
	
		//echo "curent date n = " . $curentDate . "<br/>";
		// get the closest monday to curent day
		$i = 0;
		$curentDateE = explode("-", $curentDate);
		while(date('D',mktime(0,0,0,$curentDateE[1], $curentDateE[2]-$i, $curentDateE[0])) != "Mon") {
			$i++;
		}
		$mondayDate = date('Y-m-d', mktime(0,0,0,$curentDateE[1], $curentDateE[2]-($i), $curentDateE[0]));
		$sundayDate  = date('Y-m-d', mktime(0,0,0,$curentDateE[1], $curentDateE[2]-($i)+6, $curentDateE[0]));
	
		$menuData = $this->calendarMenuData($curentAreaId, $curentResource, $curentDate);
	
		// save the menu info in the session
		$_SESSION['id_resource'] = $curentResource;
		$_SESSION['id_area'] = $curentAreaId;
		$_SESSION['curentDate'] = $curentDate;
	
		// get the area info
		$modelArea = new SyArea();
		$area = $modelArea->getArea($curentAreaId);
		
		// get the resource info
		$modelRes = new SyResource();
		$resourcesBase = $modelRes->resourcesForArea($curentAreaId);
		
		$modelRescal = new SyResourceCalendar();
		for ($t = 0 ; $t < count($resourcesBase) ; $t++){
			$resourcesInfo[$t] = $modelRescal->resource($resourcesBase[$t]["id"]);
		}
	
		// get the entries for this resource
		$modelEntries = new SyCalendarEntry();
		$dateArray = explode("-", $mondayDate);
		$dateBegin = mktime(0,0,0,$dateArray[1],$dateArray[2],$dateArray[0]);
		$dateEnd = mktime(23,59,59,$dateArray[1],$dateArray[2]+7,$dateArray[0]);
		$calEntries = $modelEntries->getEntriesForPeriodeAndArea($dateBegin, $dateEnd, $curentAreaId);
	
		// curentdate unix
		$temp = explode("-", $curentDate);
		$curentDateUnix = mktime(0,0,0,$temp[1], $temp[2], $temp[0]);
	
		// color code
		$modelColor = new SyColorCode();
		$colorcodes = $modelColor->getColorCodes("name");
	
		// isUserAuthorizedToBook
		foreach ($resourcesBase as $resourceBase){
			$isUserAuthorizedToBook[] = $this->hasAuthorization($resourceBase["category_id"], $resourceBase["accessibility_id"],
				$_SESSION['id_user'], $_SESSION["user_status"], $curentDateUnix);
		}
		
		
		//echo "area id = "  . $curentAreaId . "</br>";
		//print_r($calEntries);
		//return;
		
		// view
			$modelReservation=new reservation();
			$reserv= $modelReservation->ifresa($start_time, $end_time, $resource_id, $reservation_id);
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'menuData' => $menuData,
				'areaname' => $area["name"],
				'resourcesInfo' => $resourcesInfo,
				'resourcesBase' => $resourcesBase,
				'date' => $curentDate,
				'date_unix' => $curentDateUnix,
				'mondayDate' => $mondayDate,
				'sundayDate' => $sundayDate,
				'calEntries' => $calEntries,
				'colorcodes' => $colorcodes,
				'isUserAuthorizedToBook' => $isUserAuthorizedToBook,
				'message' => $message,
				'reserv'=>$reserv
		), "bookweekarea");
	}
	
		
}
		

