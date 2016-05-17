<?php
require_once 'Framework/Controller.php';
require_once 'Framework/TableView.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/CoreTranslator.php';
require_once 'Modules/sygrrif/Model/SyTranslator.php';
require_once 'Modules/sygrrif/Model/SyBookingTableCSS.php';
require_once 'Modules/sygrrif/Model/SyArea.php';
require_once 'Modules/sygrrif/Model/SyResourcesCategory.php';
require_once 'Modules/sygrrif/Model/SyResource.php';
require_once 'Modules/sygrrif/Model/SyResourceType.php';
require_once 'Modules/sygrrif/Model/SyColorCode.php';
require_once 'Modules/sygrrif/Model/SyCalendarEntry.php';

require_once 'Modules/core/Model/CoreSite.php';


/**
 * SyGRRif area management pages
 * 
 * @author sprigent
 *        
 */
class ControllerSygrrifareasresources extends ControllerSecureNav {
	
	/**
	 * Check if the user have the right to view SyGRRif pages
	 * 
	 * @return boolean
	 */
	private function secureCheck() {
		if ($_SESSION ["user_status"] < 3) {
			echo "Permission denied ";
			return true;
		}
		return false;
	}
	
	public function index() {
		if ($this->secureCheck ()) {
			return;
		}
		
		$navBar = $this->navBar ();
		$this->generateView ( array (
				'navBar' => $navBar 
		) );
	}
	
	// //////////////////////////////////////////////// //
	// Areas
	// //////////////////////////////////////////////// //
	/**
	 * (non-PHPdoc)
	 * 
	 * @see Controller::index()
	 */
	public function areas() {
		if ($this->secureCheck ()) {
			return;
		}
		$lang = $this->getLanguage ();
		
		$model = new SyArea ();
		$areas = $model->areas ( "id" );
		
		$table = new TableView ();
		
		$table->setTitle ( SyTranslator::Areas ( $lang ) );
		$table->addLineEditButton ( "sygrrifareasresources/editarea" );
		$table->addDeleteButton ( "sygrrifareasresources/deletearea" );
		$table->addPrintButton ( "sygrrifareasresources/areas/" );
		
		$tableContent = array (
				"id" => "ID",
				"name" => CoreTranslator::Name ( $lang ),
				"restricted" => SyTranslator::Is_resticted ( $lang ),
				"display_order" => SyTranslator::Display_order ( $lang ) 
		);
		// is restricted translation
		for($i = 0; $i < count ( $areas ); $i ++) {
			if ($areas [$i] ["restricted"] == 1) {
				$areas [$i] ["restricted"] = CoreTranslator::yes ( $lang );
			} else {
				$areas [$i] ["restricted"] = CoreTranslator::no ( $lang );
			}
		}
		
		$tableHtml = $table->view ( $areas, $tableContent );
		
		if ($table->isPrint ()) {
			echo $tableHtml;
			return;
		}
		
		$navBar = $this->navBar ();
		$this->generateView ( array (
				'navBar' => $navBar,
				'tableHtml' => $tableHtml 
		) );
	}
	
	/**
	 * Delete an area
	 */
	public function deletearea() {
		if ($this->secureCheck ()) {
			return;
		}
		
		$id = "";
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$id = $this->request->getParameter ( "actionid" );
		}
		
		$model = new SyArea ();
		$model->delete ( $id );
		
		$this->redirect ( "sygrrifareasresources", "areas" );
	}
	
	/**
	 * Form to edit an area
	 */
	public function editarea() {
		if ($this->secureCheck ()) {
			return;
		}
		
		$id = "";
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$id = $this->request->getParameter ( "actionid" );
		}
		
		$model = new SyArea ();
		$area = $model->getArea ( $id );
		
		$modelCss = new SyBookingTableCSS ();
		$css = $modelCss->getAreaCss ( $id );
                
                // get the list of areas for the connected user
                $modelSite = new CoreSite();
                $isMultisite = false;
                $sites = array();
                if ($modelSite->countSites() > 1){
                    $isMultisite = true;
                    $sites = $modelSite->getUserManagingSites($_SESSION["id_user"]);
                }
                
		$navBar = $this->navBar ();
		$this->generateView ( array (
				'navBar' => $navBar,
				'area' => $area,
                                'sites' => $sites,
				'css' => $css 
		) );
	}
	
	/*
	 * query to edit the area in the database
	 */
	public function editareaquery() {
		if ($this->secureCheck ()) {
			return;
		}
		
		$id = $this->request->getParameter ( "id" );
		$name = $this->request->getParameter ( "name" );
		$display_order = $this->request->getParameter ( "display_order" );
		$restricted = $this->request->getParameter ( "restricted" );
                $id_site = $this->request->getParameterNoException ( "id_site" );
                if ($id_site == ""){
                    $id_site = 1;
                }
		
		$model = new SyArea ();
		$model->updateArea ( $id, $name, $display_order, $restricted, $id_site );
		
		// set the css
		$header_background = $this->request->getParameter ( "header_background" );
		$header_color = $this->request->getParameter ( "header_color" );
		$header_font_size = $this->request->getParameter ( "header_font_size" );
		$resa_font_size = $this->request->getParameter ( "resa_font_size" );
		$header_height = $this->request->getParameter ( "header_height" );
		$line_height = $this->request->getParameter ( "line_height" );
		$modelCss = new SyBookingTableCSS ();
		$modelCss->setAreaCss ( $id, $header_background, $header_color, $header_font_size, $resa_font_size, $header_height, $line_height );
		
		$this->redirect ( "sygrrifareasresources", "areas" );
	}
	
	/**
	 * Form to add an area
	 */
	public function addarea() {
		if ($this->secureCheck ()) {
			return;
		}
		
                // get the list of areas for the connected user
                $modelSite = new CoreSite();
                $isMultisite = false;
                $sites = array();
                if ($modelSite->countSites() > 1){
                    $isMultisite = true;
                    $sites = $modelSite->getUserManagingSites($_SESSION["id_user"]);
                }
                
		$navBar = $this->navBar ();
		$this->generateView ( array (
				'navBar' => $navBar,
                                'sites' => $sites
		) );
	}
	
	/**
	 * Query to add an area in the database
	 */
	public function addareaquery() {
		if ($this->secureCheck ()) {
			return;
		}
		
		// $id = $this->request->getParameter ( "id" );
		$name = $this->request->getParameter ( "name" );
		$display_order = $this->request->getParameter ( "display_order" );
		$restricted = $this->request->getParameter ( "restricted" );
                $id_site = $this->request->getParameterNoException ( "id_site" );
                if ($id_site == ""){
                    $id_site = 1;
                }
		
		$model = new SyArea ();
		$id = $model->addArea ( $name, $display_order, $restricted, $id_site );
		
		// set the css
		$header_background = $this->request->getParameter ( "header_background" );
		$header_color = $this->request->getParameter ( "header_color" );
		$header_font_size = $this->request->getParameter ( "header_font_size" );
		$resa_font_size = $this->request->getParameter ( "resa_font_size" );
		$header_height = $this->request->getParameter ( "header_height" );
		$line_height = $this->request->getParameter ( "line_height" );
		$modelCss = new SyBookingTableCSS ();
		$modelCss->setAreaCss ( $id, $header_background, $header_color, $header_font_size, $resa_font_size, $header_height, $line_height );
		
		$this->redirect ( "sygrrifareasresources", "areas" );
	}
	
	// /////////////////////////////////////////////////////////// //
	// resourcescategory
	// /////////////////////////////////////////////////////////// //
	/**
	 * List of the resources categories
	 */
	public function resourcescategory() {
		if ($this->secureCheck ()) {
			return;
		}
		$lang = $this->getLanguage();
		
		// get sort action
		$sortentry = "id";
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$sortentry = $this->request->getParameter ( "actionid" );
		}
		
		// get the user list
		$categoriesModel = new SyResourcesCategory ();
		$categoriesTable = $categoriesModel->getResourcesCategories ( $sortentry );
		
		$table = new TableView ();
		
		$table->setTitle ( SyTranslator::Resource_categories( $lang ) );
		$table->addLineEditButton ( "sygrrifareasresources/editresourcescategory" );
		$table->addDeleteButton ( "sygrrifareasresources/deleteresourcecategory" );
		$table->addPrintButton ( "sygrrifareasresources/resourcescategory/" );
		
		$tableContent = array (
				"id" => "ID",
				"name" => CoreTranslator::Name ( $lang )
		);

		$tableHtml = $table->view ( $categoriesTable, $tableContent );
		
		$print = $this->request->getParameterNoException ( "print" );
		if ($table->isPrint ()) {
			echo $tableHtml;
			return;
		}
		
		$navBar = $this->navBar ();
		$this->generateView ( array (
				'navBar' => $navBar,
				'tableHtml' => $tableHtml 
		) );
	}
	
	/**
	 * Form to add a resource category
	 */
	public function addresourcescategory() {
		if ($this->secureCheck ()) {
			return;
		}
		
                // get the list of areas for the connected user
                $modelSite = new CoreSite();
                $isMultisite = false;
                $sites = array();
                if ($modelSite->countSites() > 1){
                    $isMultisite = true;
                    $sites = $modelSite->getUserManagingSites($_SESSION["id_user"]);
                }
                
		$navBar = $this->navBar ();
		$this->generateView ( array (
				'navBar' => $navBar,
                                'sites' => $sites
		) );
	}
	
	/**
	 * Query to add a resource category
	 */
	public function addresourcescategoryquery() {
		if ($this->secureCheck ()) {
			return;
		}
		
		// get form variables
		$name = $this->request->getParameter ( "name" );
                $id_site = $this->request->getParameter ( "id_site" );
                if ($id_site == ""){
                    $id_site = 1;
                }
		
		// get the user list
		$rcModel = new SyResourcesCategory();
		$rcModel->addResourcesCategory ( $name, $id_site );
		
		$this->redirect ( "sygrrifareasresources", "resourcescategory" );
	}
	
	/**
	 * Form to edit a resource category
	 */
	public function editresourcescategory() {
		if ($this->secureCheck ()) {
			return;
		}
		
		// get user id
		$rcId = 0;
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$rcId = $this->request->getParameter ( "actionid" );
		}
		
                // get the list of areas for the connected user
                $modelSite = new CoreSite();
                $isMultisite = false;
                $sites = array();
                if ($modelSite->countSites() > 1){
                    $isMultisite = true;
                    $sites = $modelSite->getUserManagingSites($_SESSION["id_user"]);
                }
                
		// get unit info
		$rcModel = new SyResourcesCategory ();
		$rc = $rcModel->getResourcesCategory ( $rcId );
		
		$navBar = $this->navBar ();
		$this->generateView ( array (
				'navBar' => $navBar,
				'rc' => $rc,
                                'sites' => $sites
		) );
	}
	
	/**
	 * Query to edit a resources category
	 */
	public function editresourcescategoryquery() {
		if ($this->secureCheck ()) {
			return;
		}
		
		// get form variables
		$id = $this->request->getParameter ( "id" );
		$name = $this->request->getParameter ( "name" );
                $id_site = $this->request->getParameter ( "id_site" );
                if ($id_site == ""){
                    $id_site = 1;
                }
		
		// get the user list
		$rcModel = new SyResourcesCategory ();
		$rcModel->editResourcesCategory ( $id, $name, $id_site );
		
		$this->redirect ( "sygrrifareasresources", "resourcescategory" );
	}
	
	/**
	 * delete a resource category
	 */
	public function deleteresourcecategory() {
		if ($this->secureCheck ()) {
			return;
		}
		
		$id = "";
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$id = $this->request->getParameter ( "actionid" );
		}
		
		$model = new SyResourcesCategory ();
		$model->delete ( $id );
		
		$this->redirect ( "sygrrifareasresources", "resourcescategory" );
	}
	
	// ///////////////////////////////////////////////// //
	//                 Resource
	// ///////////////////////////////////////////////// //
	/**
	 * List of all the resources
	 */
	public function resources(){
	
		if($this->secureCheck()){
			return;
		}
	
		$sortEntry = 'id';
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$sortEntry = $this->request->getParameter ( "actionid" );
		}
	
		$modelResources = new SyResource();
		$resourcesArray = $modelResources->resourcesInfo($sortEntry);
	
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar, 'resourcesArray' => $resourcesArray
		) );
	
	}
	
	/**
	 * Form to add a resource
	 */
	public function addresource(){
	
		if($this->secureCheck()){
			return;
		}
	
		$resource_type = "";
		if ($this->request->isParameterNotEmpty ( 'resource_type' )) {
			$resource_type = $this->request->getParameter ( "resource_type" );
		}
	
		$modelResourcesTypes = new SyResourceType();
		if ($resource_type == ""){
			$resourcesTypes = $modelResourcesTypes->typesIDNames("name");
				
			$navBar = $this->navBar();
			$this->generateView ( array (
					'navBar' => $navBar,
					'resourcesTypes' => $resourcesTypes
			) );
		}
		else{
			$typeInfo = $modelResourcesTypes->getType($resource_type);
				
			$this->redirect($typeInfo["controller"], $typeInfo["edit_action"]);
		}
	}
	
	// ////////////////////////////////////////////////// //
	//					Color code
	// ////////////////////////////////////////////////// //
	/**
	 * Shows the color codes table
	 */
	public function colorcodes(){
		// get sort action
		$sortentry = "id";
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$sortentry = $this->request->getParameter ( "actionid" );
		}
	
		// get the user list
		$colorModel = new SyColorCode();
		$colorTable = $colorModel->getColorCodes( $sortentry );
		
		$lang = $this->getLanguage();
		$table = new TableView ();
		
		$table->setTitle ( SyTranslator::color_codes( $lang ) );
		$table->addLineEditButton ( "sygrrifareasresources/editcolorcode" );
		$table->addDeleteButton ( "sygrrifareasresources/deletecolorcode" );
		$table->addPrintButton ( "sygrrifareasresources/colorcodes/" );
		$table->setColorIndexes(array("color" => "color"));
		
		$tableContent = array (
				"id" => "ID",
				"name" => CoreTranslator::Name ( $lang ),
				"color" => CoreTranslator::Color ( $lang )
		);
		
		$tableHtml = $table->view ( $colorTable, $tableContent );
		
		if ($table->isPrint ()) {
			echo $tableHtml;
			return;
		}
	
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'tableHtml' => $tableHtml
		) );
	}
	
	/**
	 * Form to add a color code
	 */
	public function addcolorcode(){
	
                // get the list of areas for the connected user
                $modelSite = new CoreSite();
                $isMultisite = false;
                $sites = array();
                if ($modelSite->countSites() > 1){
                    $isMultisite = true;
                    $sites = $modelSite->getUserManagingSites($_SESSION["id_user"]);
                }
                
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
                                'sites' => $sites
		) );
	}
	
	/**
	 * Quey to add a color code
	 */
	public function addcolorcodequery(){
	
		// get form variables
		$name = $this->request->getParameter ( "name" );
		$color = $this->request->getParameter ( "color" );
		$text_color = $this->request->getParameter ( "text_color" );
		$display_order = $this->request->getParameter ( "display_order" );
                $id_site = $this->request->getParameterNoException ( "id_site" );
                if ($id_site == ""){
                    $id_site = 1;
                }
	
		// get the user list
		$ccModel = new SyColorCode();
		$ccModel->addColorCode($name, $color, $text_color, $display_order, $id_site);
	
		$this->redirect ( "sygrrifareasresources", "colorcodes" );
	}
	
	/**
	 * Form to edit a color code
	 */
	public function editcolorcode(){
	
		// get user id
		$ccId = 0;
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$ccId = $this->request->getParameter ( "actionid" );
		}
                
                // get the list of areas for the connected user
                $modelSite = new CoreSite();
                $isMultisite = false;
                $sites = array();
                if ($modelSite->countSites() > 1){
                    $isMultisite = true;
                    $sites = $modelSite->getUserManagingSites($_SESSION["id_user"]);
                }
	
		// get unit info
		$ccModel = new SyColorCode();
		$colorcode = $ccModel->getColorCode( $ccId );
	
		$navBar = $this->navBar ();
		$this->generateView ( array (
				'navBar' => $navBar,
				'colorcode' => $colorcode,
                                'sites' => $sites
		) );
	}
	
	/**
	 * Query to edit a color code
	 */
	public function editcolorcodequery(){
		
		// get form variables
		$id = $this->request->getParameter ( "id" );
		$name = $this->request->getParameter ( "name" );
		$color = $this->request->getParameter ( "color" );
		$text_color = $this->request->getParameter ( "text_color" );
		$display_order = $this->request->getParameter ( "display_order" );
                $id_site = $this->request->getParameterNoException ( "id_site" );
                if ($id_site == ""){
                    $id_site = 1;
                }
                
		// get the user list
		$ccModel = new SyColorCode();
		$ccModel->editColorCode($id, $name, $color, $text_color, $display_order, $id_site);
	
		$this->redirect ( "sygrrifareasresources", "colorcodes" );
	}
	
	/**
	 * Query to delete a color code
	 */
	public function deletecolorcode(){
		// get user id
		$ccId = 0;
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$ccId = $this->request->getParameter ( "actionid" );
		}
	
		// get the user list
		$ccModel = new SyColorCode();
		$ccModel->delete($ccId);
	
		$this->redirect ( "sygrrifareasresources", "colorcodes" );
	}
	
	// //////////////////////////////////////////// //
	// 				Bloc resource
	// //////////////////////////////////////////// //
	/**
	 * Form to make several resources unavailable
	 * @param string $errormessage
	 */
	public function blockresources($errormessage = ""){
	
		$modelResources = new SyResource();
		$resources = $modelResources->resources("name");
	
		$modelColor = new SyColorCode();
		$colorCodes = $modelColor->getColorCodes();
	
		$navBar = $this->navBar ();
		$this->generateView ( array (
				'navBar' => $navBar,
				'resources' => $resources,
				'colorCodes' => $colorCodes,
				'errormessage' => $errormessage
		) );
	}
	
	/**
	 * Query to make several resources unavailable
	 */
	public function blockresourcesquery(){
		$lang = "En";
		if (isset($_SESSION["user_settings"]["language"])){
			$lang = $_SESSION["user_settings"]["language"];
		}
		$navBar = $this->navBar ();
	
		// get form variables
		$short_description = $this->request->getParameter ( "short_description" );
		$resources = $this->request->getParameter ( "resources" );
		$begin_date = $this->request->getParameter ( "begin_date" );
		$begin_hour = $this->request->getParameter ( "begin_hour" );
		$begin_min = $this->request->getParameter ( "begin_min" );
		$end_date = $this->request->getParameter ( "end_date" );
		$end_hour = $this->request->getParameter ( "end_hour" );
		$end_min = $this->request->getParameter ( "end_min" );
		$color_type_id = $this->request->getParameter ( "color_code_id" );
	
		$beginDate = CoreTranslator::dateToEn($begin_date, $lang);
		$beginDate = explode("-", $beginDate);
		$start_time = mktime(intval($begin_hour), intval($begin_min), 0, $beginDate[1], $beginDate[2], $beginDate[0]);
	
		$endDate = CoreTranslator::dateToEn($end_date, $lang);
		$endDate = explode("-", $endDate);
		$end_time = mktime(intval($end_hour), intval($end_min), 0, $endDate[1], $endDate[2], $endDate[0]);
	
		if ($end_time <= $start_time){
			$errormessage = "Error: The begin time must be before the end time";
			$modelResources = new SyResource();
			$resources = $modelResources->resources("name");
			$modelColor = new SyColorCode();
			$colorCodes = $modelColor->getColorCodes();
			$this->generateView ( array (
					'navBar' => $navBar,
					'resources' => $resources,
					'colorCodes' => $colorCodes,
					'errormessage' => $errormessage
			),"blockresources");
			return;
		}
	
		// Add the booking
		$modelCalEntry = new SyCalendarEntry();
		$userID = $_SESSION["id_user"];
		foreach ($resources as $resource_id){
	
			$conflict = $modelCalEntry->isConflict($start_time, $end_time, $resource_id);
	
			if ($conflict){
				$errormessage = "Error: There is already a reservation for the given slot, please remove it before booking";
				$modelResources = new SyResource();
				$resources = $modelResources->resources("name");
				$modelColor = new SyColorCode();
				$colorCodes = $modelColor->getColorCodes();
				$this->generateView ( array (
						'navBar' => $navBar,
						'resources' => $resources,
						'colorCodes' => $colorCodes,
						'errormessage' => $errormessage
				),"blockresources");
				return;
			}
			$booked_by_id = $userID;
			$recipient_id = $userID;
			$last_update = date("Y-m-d H:i:s", time());
			$full_description = "";
			$quantity = "";
			$modelCalEntry->addEntry($start_time, $end_time, $resource_id, $booked_by_id, $recipient_id,
					$last_update, $color_type_id, $short_description, $full_description, $quantity);
		}
	
		$this->redirect ( "Sygrrifareasresources" );
	}
}
