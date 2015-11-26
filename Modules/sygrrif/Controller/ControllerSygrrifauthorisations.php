<?php
require_once 'Framework/Controller.php';
require_once 'Modules/core/Model/CoreUnit.php';
require_once 'Modules/core/Model/CoreUser.php';
require_once 'Modules/core/Model/CoreTranslator.php';
require_once 'Framework/TableView.php';
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
	
	/**
	 * Constructor
	 */
	public function __construct() {
		ob_end_clean();
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
		$table->addDeleteButton ( "sygrrifauthorisations/deletevisa" );
		$table->addPrintButton ( "sygrrifauthorisations/visa/" );
		
		$tableContent = array (
				"id" => "ID",
				"name" => CoreTranslator::Name ( $lang )
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
	public function addvisa(){
	
		if($this->secureCheck()){
			return;
		}
	
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
		) );
	}
	
	/**
	 * query to add a visa
	 */
	public function addvisaquery(){
	
		if($this->secureCheck()){
			return;
		}
	
		// get form variables
		$name = $this->request->getParameter ( "name" );
	
		// get the user list
		$visaModel = new SyVisa();
		$visaModel->addVisa ( $name );
	
		$this->redirect ( "sygrrifauthorisations", "visa" );
	}
	
	/**
	 * Form to edit a visa
	 */
	public function editvisa(){
	
		if($this->secureCheck()){
			return;
		}
	
		// get user id
		$visaId = 0;
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$visaId = $this->request->getParameter ( "actionid" );
		}
	
		// get unit info
		$visaModel = new SyVisa();
		$visa = $visaModel->getVisa ( $visaId );
	
		$navBar = $this->navBar ();
		$this->generateView ( array (
				'navBar' => $navBar,
				'visa' => $visa
		) );
	}
	
	/**
	 * Query to edit a visa
	 */
	public function editvisaquery(){
	
		if($this->secureCheck()){
			return;
		}
	
		// get form variables
		$id = $this->request->getParameter ( "id" );
		$name = $this->request->getParameter ( "name" );
	
		// get the user list
		$visaModel = new SyVisa();
		$visaModel->editVisa ( $id, $name );
	
		$this->redirect ( "sygrrifauthorisations", "visa" );
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
	public function authorizations(){
	
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
		$authorizationTable = $authModel->getActiveAuthorizations ( $sortentry );
	
		$lang = $this->getLanguage();
		$table = new TableView ();
		
		$table->setTitle ( SyTranslator::Authorisations( $lang ) );
		$table->addLineEditButton ( "sygrrifauthorisations/editauthorization" );
		$table->addDeleteButton ( "Sygrrifauthorisations/deleteauthorization", "id", "id" );
		$table->addPrintButton ( "sygrrifauthorisations/authorizations/" );
		
		for($i = 0 ; $i < count($authorizationTable) ; $i++){
			$authorizationTable[$i]["date"] = CoreTranslator::dateFromEn($authorizationTable[$i]["date"], $lang); 
		}
		
		$tableContent = array (
				"id" => "ID",
				"date" => SyTranslator::Date($lang),
				"userName" => CoreTranslator::Name( $lang ),
				"userFirstname" => CoreTranslator::Firstname( $lang ),
				"unitName" => SyTranslator::Unit( $lang ),
				"visa" => SyTranslator::Visa( $lang ),
				"resource" => SyTranslator::Resource( $lang )
		);
		
		$tableHtml = $table->view ( $authorizationTable, $tableContent );
		
		$print = $this->request->getParameterNoException ( "print" );
		if ($table->isPrint ()) {
			echo $tableHtml;
			return;
		}
	
		// view
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'tableHtml' => $tableHtml
		) );
	}
	
	/**
	 * List of unactive authorizations
	 */
	public function uauthorizations(){
	
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
		$authorizationTable = $authModel->getActiveAuthorizations ( $sortentry,0 );
	
		$lang = $this->getLanguage();
		$table = new TableView ();
		
		$table->setTitle ( SyTranslator::Authorisations( $lang ) );
		$table->addLineEditButton ( "sygrrifauthorisations/editauthorization" );
		$table->addDeleteButton ( "Sygrrifauthorisations/deleteauthorization", "id", "id" );
		$table->addPrintButton ( "sygrrifauthorisations/authorizations/" );
		
		for($i = 0 ; $i < count($authorizationTable) ; $i++){
			$authorizationTable[$i]["date"] = CoreTranslator::dateFromEn($authorizationTable[$i]["date"], $lang);
		}
		
		$tableContent = array (
				"id" => "ID",
				"date" => SyTranslator::Date($lang),
				"userName" => CoreTranslator::Name( $lang ),
				"userFirstname" => CoreTranslator::Firstname( $lang ),
				"unitName" => SyTranslator::Unit( $lang ),
				"visa" => SyTranslator::Visa( $lang ),
				"resource" => SyTranslator::Resource( $lang )
		);
		
		$tableHtml = $table->view ( $authorizationTable, $tableContent );
		
		$print = $this->request->getParameterNoException ( "print" );
		if ($table->isPrint ()) {
			echo $tableHtml;
			return;
		}
		
		// view
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'tableHtml' => $tableHtml
		),"authorizations" );
	}
	
	/**
	 * Form to add an authorization
	 */
	public function addauthorization(){
	
		if($this->secureCheck()){
			return;
		}
	
		// get users list
		$modelUser = new CoreUser();
		$users = $modelUser->getUsersSummary('name');
	
		// get unit list
		$modelUnit = new CoreUnit();
		$units = $modelUnit->unitsIDName();
	
		// get visa list
		$modelVisa = new SyVisa();
		$visas = $modelVisa->visasIDName();
	
		// get resource list
		$modelResource = new SyResourcesCategory();
		$resources = $modelResource->getResourcesCategories("name");
	
		// view
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'users' => $users,
				'units' => $units,
				'visas' => $visas,
				'resources' => $resources
		) );
	
	}
	
	/**
	 * Form to edit an authorization
	 */
	public function editauthorization(){
	
		// get sort action
		$id = 0;
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$id = $this->request->getParameter ( "actionid" );
		}
	
		// get the authorization info
		$modelAuth = new SyAuthorization();
		$authorization = $modelAuth->getAuthorization($id);
	
		//print_r($authorization);
	
		// get users list
		$modelUser = new CoreUser();
		$users = $modelUser->getUsersSummary('name');
	
		// get unit list
		$modelUnit = new CoreUnit();
		$units = $modelUnit->unitsIDName();
	
		// get visa list
		$modelVisa = new SyVisa();
		$visas = $modelVisa->visasIDName();
	
		// get resource list
		$modelResource = new SyResourcesCategory();
		$resources = $modelResource->getResourcesCategories("name");
	
		// view
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'users' => $users,
				'units' => $units,
				'visas' => $visas,
				'resources' => $resources,
				'authorization' => $authorization
		) );
	}
	
	/**
	 * Query to edit an authorization
	 */
	public function editauthorizationsquery(){
	
		$lang = "En";
		if (isset($_SESSION["user_settings"]["language"])){
			$lang = $_SESSION["user_settings"]["language"];
		}
	
		$id = $this->request->getParameter('id');
		$user_id = $this->request->getParameter('user_id');
		$unit_id = $this->request->getParameter('unit_id');
		$date = $this->request->getParameter('date');
		$visa_id = $this->request->getParameter('visa_id');
		$resource_id = $this->request->getParameter('resource_id');
		$is_active = $this->request->getParameter('is_active');
	
		if ($date != ""){
			$date = CoreTranslator::dateToEn($date, $lang);
		}
	
		$model = new SyAuthorization();
		$model->editAuthorization($id, $date, $user_id, $unit_id, $visa_id, $resource_id);
		//echo "is active = " . (int)$is_active . "<br/>";
		if ($is_active > 0){
			$model->activate($id);
		}
		else{
			$model->unactivate($id);
		}
		//$model->setActive($id, (int)$is_active);
	
		$this->redirect ( "sygrrifauthorisations", "authorizations" );
	}
	
	/**
	 * Query to add an authorization
	 */
	public function addauthorizationsquery(){
	
		$lang = "En";
		if (isset($_SESSION["user_settings"]["language"])){
			$lang = $_SESSION["user_settings"]["language"];
		}
	
		$user_id = $this->request->getParameter('user_id');
		//$unit_id = $this->request->getParameter('unit_id');
		$date = $this->request->getParameter('date');
		$visa_id = $this->request->getParameter('visa_id');
		$resource_id = $this->request->getParameter('resource_id');
	
		if ($date != ""){
			$date = CoreTranslator::dateToEn($date, $lang);
		}
	
		$modelUser = new CoreUser();
		$unit_id = $modelUser->getUserUnit($user_id);
	
		$model = new SyAuthorization();
		$model->addAuthorization($date, $user_id, $unit_id, $visa_id, $resource_id);
	
		$this->redirect ( "sygrrifauthorisations", "authorizations" );
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
		$visas = $modelVisa->visasIDName();
		
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'userAuthorizations' => $userAuthorizations,
				'resources' => $resources,
				'userID' => $userID,
				'unit_id' => $unit_id,
				'userName' => $userName,
				'visas' => $visas,
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
