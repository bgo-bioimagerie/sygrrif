<?php
require_once 'Framework/Controller.php';
require_once 'Modules/core/Model/CoreUnit.php';
require_once 'Modules/core/Model/CoreUser.php';
require_once 'Modules/core/Model/CoreTranslator.php';
require_once 'Framework/TableView.php';
require_once 'Framework/Form.php';
require_once 'Modules/sygrrif/Model/SyTranslator.php';
require_once 'Modules/sygrrif/Controller/ControllerBooking.php';
require_once 'Modules/sygrrif/Model/SyGraph.php';
require_once 'Modules/sygrrif/Model/SyPricing.php';
require_once 'Modules/sygrrif/Model/SyInstall.php';
require_once 'Modules/sygrrif/Model/SyVisa.php';
require_once 'Modules/sygrrif/Model/SyAuthorization.php';
require_once 'Modules/sygrrif/Model/SyResourcesCategory.php';
require_once 'Modules/sygrrif/Model/SyBillGenerator.php';
require_once 'Modules/sygrrif/Model/SyArea.php';
require_once 'Modules/core/Model/UserSettings.php';

/**
 * SyGRRif management pages
 * @author sprigent
 *
 */
class ControllerSygrrifauthorisations extends ControllerSecureNav {

	/**
	 * Check if the user have the right to view SyGRRif pages
	 * @return boolean
	 */
	private function secureCheck(){
		if ( $_SESSION["user_status"] < 3){
			echo "Permission denied "; 
			return true;
		}
		return false;
	}
	
	public function index(){
	
	}
	
	/**
	 * List of Visa
	 */
	public function visa(){
	
		if($this->secureCheck()){
			return;
		}
	
		// get sort action
		$sortentry = "id";
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$sortentry = $this->request->getParameter ( "actionid" );
		}
	
		// get the user list
		$visaModel = new SyVisa();
		$visaTable = $visaModel->getVisas ( $sortentry );
		
		$lang = $this->getLanguage();
		$table = new TableView ();
		
		$table->setTitle ( SyTranslator::Visa( $lang ) );
		$table->ignoreEntry("id", 1);
		$table->addLineEditButton ( "sygrrifauthorisations/editvisa" );
		$table->addDeleteButton ( "sygrrifauthorisations/deletevisa", "id", "id" );
		$table->addPrintButton ( "sygrrifauthorisations/visa/" );
		
		$modelResourceCategory = new SyResourcesCategory();
		$modelUser = new CoreUser();
		for($i = 0 ; $i < count($visaTable) ; $i++ ){
			
			if ($visaTable[$i]["id"] == 1){
				$visaTable[$i]["id_resource_category"] = "--";
				$visaTable[$i]["id_instructor"] = "--";
				$visaTable[$i]["instructor_status"] = "--";
				
			}
			else{
				$visaTable[$i]["id_resource_category"] = $modelResourceCategory->getResourcesCategoryName($visaTable[$i]["id_resource_category"]);
				$visaTable[$i]["id_instructor"] = $modelUser->getUserFUllName($visaTable[$i]["id_instructor"]);
				if ($visaTable[$i]["instructor_status"] == 1){
					$visaTable[$i]["instructor_status"] = SyTranslator::Instructor($lang);
				}
				else{
					$visaTable[$i]["instructor_status"] = CoreTranslator::Responsible($lang);
				}
			}
		}
		
		$tableContent = array (
				"id" => "ID",
				"id_resource_category" => SyTranslator::Resource_categories( $lang ),
				"id_instructor" => SyTranslator::Instructor( $lang ),
				"instructor_status" => SyTranslator::Instructor_status($lang)
		);		
		$tableHtml = $table->view ( $visaTable, $tableContent );
		
		$print = $this->request->getParameterNoException ( "print" );
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
	 * Form to add a visa
	 */
	public function editvisa(){
	
		if($this->secureCheck()){
			return;
		}
		
		$lang = $this->getLanguage();
		// get id
		$visaId = 0;
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$visaId = $this->request->getParameter ( "actionid" );
		}
		
		$visaInfo = array("id" => 0, "id_resource_category" => 0, "id_instructor" => 0, "instructor_status" => 1);
		if ($visaId > 0){
			$modelVisa = new SyVisa();
			$visaInfo = $modelVisa->getVisa($visaId);
		}
		
		// build the form
		$form = new Form($this->request, "formeditVisa");
		$form->setTitle(SyTranslator::Edit_Visa($lang));

                // get resources categories
                $modelResourcesCategory = new SyResourcesCategory();
                $modelSite = new CoreSite();
                $sites = array();
                if ($modelSite->countSites() > 1){
                    $sites = $modelSite->getUserManagingSites($_SESSION["id_user"]);
                    $resourcesCategories = $modelResourcesCategory->getResourcesCategoriesForManager($_SESSION["id_user"]);
                }
                else{
                    $resourcesCategories = $modelResourcesCategory->getResourcesCategories();
                }
                
		$rcchoices = array();
		$rcchoicesid = array();
		foreach($resourcesCategories as $rc){
			$rcchoicesid[] = $rc["id"];
			$rcchoices[] = $rc["name"];
		}
		$form->addSelect("id_resource_category", SyTranslator::Resource_categories($lang), $rcchoices, $rcchoicesid, $visaInfo["id_resource_category"]);
		
		$modelUser = new CoreUser();
		$users = $modelUser->getUsers("name");
		foreach($users as $us){
			$uschoices[] = $us["name"] . " " . $us["firstname"];  
			$uschoicesid[] = $us["id"];
		}
		$form->addSelect("id_instructor", SyTranslator::User($lang), $uschoices, $uschoicesid, $visaInfo["id_instructor"]);
		
		$ischoicesid = array(1,2);
		$ischoices = array(SyTranslator::Instructor($lang), CoreTranslator::Responsible($lang));
		$form->addSelect("instructor_status", SyTranslator::Instructor_status($lang), $ischoices, $ischoicesid, $visaInfo["instructor_status"]);
		$form->setValidationButton("Ok", "sygrrifauthorisations/editvisa".$visaId);
		$form->setCancelButton(CoreTranslator::Cancel($lang), "sygrrifauthorisations/visa");
		
		if ($form->check()){
			// run the database query
			$modelVisa = new SyVisa();
			if ($visaId > 0){
				$modelVisa->editVisa($visaId, $form->getParameter("id_resource_category"), $form->getParameter("id_instructor"), $form->getParameter("instructor_status"));
			}
			else{
				$modelVisa->addVisa($form->getParameter("id_resource_category"), $form->getParameter("id_instructor"), $form->getParameter("instructor_status"));
			}
			$this->redirect("sygrrifauthorisations/visa");
		}
		else{
			// set the view
			$formHtml = $form->getHtml();
			// view
			$navBar = $this->navBar();
			$this->generateView ( array (
					'navBar' => $navBar,
					'formHtml' => $formHtml
			) );
		}
	}
	
	/**
	 * Export the visas in an xls file
	 */
	public function exportvisa(){
		
		$lang = $this->getLanguage();
		
		// get all the resources categories
		$modelResources = new SyResourcesCategory();
		$resources = $modelResources->getResourcesCategories("name");
		
		// get all the instructors
		$modelVisa = new SyVisa();
		$instructors = $modelVisa->getAllInstructors();
		
		//print_r($instructors);
		
		$visas = $modelVisa->getVisas();
		
		header("Content-Type: application/csv-tab-delimited-table");
		header("Content-disposition: filename=visas.csv");
		
		// resources
		$content = ";";
		foreach ($resources as $resource){
			$content .= $resource["name"] . ";" ;  
		}
		$content.= "\r\n";
		
		// instructors
		foreach ($instructors as $instructor){
			$content .= $instructor["name_instructor"] . ";" ;
			foreach ($resources as $resource){
				$found = 0;
				foreach($visas as $visa){
					if ($visa["id_resource_category"] == $resource["id"] && $visa["id_instructor"] == $instructor["id_instructor"]){
						
						$instructorStatus = SyTranslator::Instructor($lang);
						if ($visa["instructor_status"] == 2){
							$instructorStatus = SyTranslator::Responsible($lang);
						}
						$content .= $instructorStatus . ";" ;
						$found = 1;
						break;
					}
				}
				if ($found == 0){
					$content .= ";" ;
				}
			}
			$content.= "\r\n";
		}
		$content.= "\r\n";
		echo $content;
		
	}
	
	/**
	 * Delete  visa
	 */
	public function deletevisa(){
	
		if($this->secureCheck()){
			return;
		}
	
		$id = 0;
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$id = $this->request->getParameter ( "actionid" );
		}
	
		// get the user list
		$visaModel = new SyVisa();
		$visaModel->delete( $id );
	
		$this->redirect ( "sygrrifauthorisations", "visa" );
	}
	
	/**
	 * List of all authorizations
	 */
	public function authorizations($active = 1){
	
		if($this->secureCheck()){
			return;
		}
	
		// get user id
		$sortentry = 0;
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$sortentry = $this->request->getParameter ( "actionid" );
		}
	
		// query
		$authModel = new SyAuthorization();
                $modelSite = new CoreSite();
                $sites = array();
                if ($modelSite->countSites() > 1){
                    $sites = $modelSite->getUserManagingSites($_SESSION["id_user"]);
                    $authorizationTable = $authModel->getActiveAuthorizationsForManager($_SESSION["id_user"], $active);
                }
                else{
                    $authorizationTable = $authModel->getActiveAuthorizations ( $sortentry, $active );
                }
                
		$lang = $this->getLanguage();
		$table = new TableView ();
		
		$table->setTitle ( SyTranslator::Authorisations( $lang ) );
		$table->addLineEditButton ( "sygrrifauthorisations/editauthorization", "id", "id" );
		$table->addDeleteButton ( "Sygrrifauthorisations/deleteauthorization", "id", "id" );
		$table->addPrintButton ( "sygrrifauthorisations/authorizations/" );
		
		$modelUser = new CoreUser();
		$modelUnit = new CoreUnit();
		$modelVisa = new SyVisa();
		$modelRes = new SyResourcesCategory();
		for($i = 0 ; $i < count($authorizationTable) ; $i++){
			$authorizationTable[$i]["date"] = CoreTranslator::dateFromEn($authorizationTable[$i]["date"], $lang); 
 			$authorizationTable[$i]["user_id"] = $modelUser->getUserFUllName($authorizationTable[$i]["user_id"]);
			$authorizationTable[$i]["lab_id"] = $modelUnit->getUnitName($authorizationTable[$i]["lab_id"]);
			$authorizationTable[$i]["visa_id"] = $modelVisa->getVisaDescription($authorizationTable[$i]["visa_id"], $lang);
			$authorizationTable[$i]["resource_id"] = $modelRes->getResourcesCategoryName($authorizationTable[$i]["resource_id"], $lang);
		}
		
		$tableContent = array (
				"id" => "ID",
				"date" => SyTranslator::Date($lang),
				"user_id" => CoreTranslator::Name( $lang ),
				"lab_id" => SyTranslator::Unit( $lang ),
				"visa_id" => SyTranslator::Visa( $lang ),
				"resource_id" => SyTranslator::Resource( $lang )
		);
		
		$tableHtml = $table->view ( $authorizationTable, $tableContent );
		
		//$print = $this->request->getParameterNoException ( "print" );
		if ($table->isPrint()) {
			echo $tableHtml;
			return;
		}
	
		// view
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'tableHtml' => $tableHtml
		), 'authorizations');
	}
	
	/**
	 * List of unactive authorizations
	 */
	public function uauthorizations(){
	
		$this->authorizations(0);
	}
	
	
	/**
	 * Form to edit an authorization
	 */
	public function editauthorization(){
	
		if($this->secureCheck()){
			return;
		}
		
		$lang = $this->getLanguage();
		// get id
		$authId = 0;
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$authId = $this->request->getParameter ( "actionid" );
		}
		
		$authInfo = array("id" => 0, "date" => "0000-00-00", "user_id" => 0, "lab_id" => 0,
								   "visa_id" => 0, "resource_id" => 0, "is_active" => 0);	 
		if ($authId > 0){
			$modelAuth = new SyAuthorization();
			$authInfo = $modelAuth->getAuthorization($authId);
		}
		// lists for the form
		$modelUser = new CoreUser();
		$users = $modelUser->getUsers("name");
		foreach($users as $us){
			$uschoices[] = $us["name"] . " " . $us["firstname"];
			$uschoicesid[] = $us["id"];
		}
		$modelVisa = new SyVisa();
                
		$modelResourcesCategory = new SyResourcesCategory();
		$visas = $modelVisa->getVisas("id");
		foreach($visas as $vi){
			$vichoices[] = $modelUser->getUserFUllName($vi["id_instructor"]) . " - " . $modelResourcesCategory->getResourcesCategoryName($vi["id_resource_category"]);
			$vichoicesid[] = $vi["id"];
		}
                
                // get resources categories
                $modelSite = new CoreSite();
                $sites = array();
                if ($modelSite->countSites() > 1){
                    $sites = $modelSite->getUserManagingSites($_SESSION["id_user"]);
                    $resCat = $modelResourcesCategory->getResourcesCategoriesForManager($_SESSION["id_user"]);
                }
                else{
                    $resCat = $modelResourcesCategory->getResourcesCategories("name");
                }
		foreach($resCat as $un){
			$reschoices[] = $un["name"];
			$reschoicesid[] = $un["id"];
		}
		// build the form
		$form = new Form($this->request, "formeditauth");
		$title = SyTranslator::Add_Authorization($lang);
		if ($authId > 0){
			$title = SyTranslator::Edit_Authorization($lang);
		}
		$form->setTitle($title);
		$form->addDate("date", SyTranslator::Date($lang), true, $authInfo["date"]);
		$form->addSelect("user_id", SyTranslator::User($lang), $uschoices, $uschoicesid, $authInfo["user_id"]);
		$form->addSelect("resource_id", SyTranslator::Resource_categories($lang), $reschoices, $reschoicesid, $authInfo["resource_id"]);
		$form->addSelect("visa_id", SyTranslator::Visa($lang), $vichoices, $vichoicesid, $authInfo["visa_id"]);
		$form->setValidationButton(CoreTranslator::Ok($lang), "sygrrifauthorisations/editauthorization/" . $authId);
		
		if ($form->check()){
			// run the database query
			$modelAuth = new SyAuthorization();
			$date = $form->getParameter("date");
			$user_id = $form->getParameter("user_id");
			//$lab_id = $form->getParameter("lab_id");
                        $lab_id = $modelUser->getUserUnit($user_id);
			$visa_id = $form->getParameter("visa_id");
			$resource_id = $form->getParameter("resource_id");
			if ($authId > 0){
				$modelAuth->editAuthorization($authId, $date, $user_id, $lab_id, $visa_id, $resource_id);
			}
			else{
				$modelAuth->addAuthorization($date, $user_id, $lab_id, $visa_id, $resource_id);
			}
				
			$this->redirect("sygrrifauthorisations/authorizations");
		}
		else{
			// set the view
			$formHtml = $form->getHtml();
			// view
			$navBar = $this->navBar();
			$this->generateView ( array (
					'navBar' => $navBar,
					'formHtml' => $formHtml
			) );
		}
	}

	/**
	 * 
	 */
	public function userauthorizations($userID = 0, $message = ""){
		
		if($this->secureCheck()){
			return;
		}
		
		if ($this->request->isParameterNotEmpty('actionid')){
			$userID = $this->request->getParameter("actionid");
		}
		
		// get al the authorisations for the user
		$modelAuthorization = new SyAuthorization();
		$userAuthorizations = $modelAuthorization->getUserAuthorizations($userID);
		
		// get all the resources
		$modelResources = new SyResourcesCategory();
		$resources = $modelResources->getResourcesCategories("name");
		
		// user name
		$modelUser = new CoreUser();
		$userName = $modelUser->getUserFUllName($userID);
		
		// user unit
		$unit_id = $modelUser->getUserUnit($userID);
		
		// visas
		$modelVisa = new SyVisa();
		$resourceVisas = array();
		$lang = $this->getLanguage();
		foreach($resources as $res){
			$resourceVisas[$res["id"]] = $modelVisa->getVisasDesc($res["id"], $lang);
		}
		
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'userAuthorizations' => $userAuthorizations,
				'resources' => $resources,
				'userID' => $userID,
				'unit_id' => $unit_id,
				'userName' => $userName,
				'visas' => $resourceVisas,
				'message' => $message
		), "userauthorizations" );
	}
	
	/**
	 *
	 */
	public function userauthorizationsquery(){
	
		if($this->secureCheck()){
			return;
		}

		$user_id = $this->request->getParameter("user_id");
		$unit_id = $this->request->getParameter("unit_id");
		$resource_id = $this->request->getParameter("resource_id");
		$is_active = $this->request->getParameter("is_active");
		$date = $this->request->getParameter("date");
		$visa_id = $this->request->getParameter("visa_id");
		
		//print_r($resource_id);
		//print_r($is_active);
		
		$modelAuthorization = new SyAuthorization();
		$lang = $this->getLanguage();
		for($i = 0 ; $i < count($resource_id) ; $i++){
			$authorizationID = $modelAuthorization->getAuthorisationID($resource_id[$i], $user_id);
			//echo "authorizationID = " . $authorizationID  . "<br/>";
			//echo "is_active = " . $is_active[$i]  . "<br/>";
			$cdate = CoreTranslator::dateToEn($date[$i], $lang);
			//echo "date = " . $date[$i] . "<br/>";
			//echo "cdate = " . $cdate . "<br/>";
			if ($authorizationID > 0){
				$modelAuthorization->editAuthorization($authorizationID, $cdate, $user_id, $unit_id, 
											   $visa_id[$i], $resource_id[$i],$is_active[$i]);
			}
			else{
				if ($is_active[$i] > 0){
					// add authorization
					//echo "add authorization for resource : ". $resource_id[$i]. "<br/>";
					$modelAuthorization->addAuthorization($cdate, $user_id, $unit_id, $visa_id[$i], $resource_id[$i], 1);
				}
			}
		}
		
		$message = SyTranslator::Modifications_have_been_saved($lang);
		$this->userauthorizations($user_id, $message);
	}
	
	/**
	 * Delete  visa
	 */
	public function deleteauthorization(){
	
		if($this->secureCheck()){
			return;
		}
	
		$id = 0;
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$id = $this->request->getParameter ( "actionid" );
		}
	
		// get the user list
		$autModel = new SyAuthorization();
		$autModel->delete( $id );
	
		$this->redirect ( "sygrrifauthorisations", "authorizations" );
	}
}
