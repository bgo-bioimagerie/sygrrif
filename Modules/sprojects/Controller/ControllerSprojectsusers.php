<?php
require_once 'Framework/Controller.php';
require_once 'Framework/TableView.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/sprojects/Model/SpUser.php';
require_once 'Modules/core/Model/CoreStatus.php';
require_once 'Modules/sprojects/Model/SpUnit.php';
require_once 'Modules/sprojects/Model/SpResponsible.php';
require_once 'Modules/core/Model/CoreTranslator.php';
require_once 'Modules/core/Model/CoreConfig.php';

/**
 * Manage the users
 * 
 * @author sprigent
 *
 */
class ControllerSprojectsusers extends ControllerSecureNav {
	
	/**
	 * User model object
	 */
	private $userModel;
	
	/**
	 * Constructor
	 */
	public function __construct() {
		header_remove();
		$this->userModel = new SpUser();
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Controller::index()
	 */
	public function index($active = "") {
		
		if ($active == ""){
			if (isset($_SESSION["users_lastvisited"])){
				$active = $_SESSION["users_lastvisited"];
			}
			else{
				$active = "active";
			}
		}
		
		// get sort action
		$sortentry = "id";
		if ($this->request->isParameterNotEmpty('actionid')){
			$sortentry = $this->request->getParameter("actionid");
		}
		
		$navBar = $this->navBar();
		$lang = $this->getLanguage();
			
		// get the user list
		$usersArray = array();
		$title = CoreTranslator::Users($lang);
		if ($active == "active"){
			$usersArray = $this->userModel->getActiveUsersInfo($sortentry);
		}
		else{
			$usersArray = $this->userModel->getActiveUsersInfo($sortentry, 0);
			$title = CoreTranslator::Unactive_Users($lang);
		}
		
		for($i =0 ; $i < count($usersArray) ; $i++ ){
			// is responsible
			if ($usersArray[$i]["is_responsible"] == 1){
				$usersArray[$i]["is_responsible"] = CoreTranslator::yes($lang);
			}
			else{
				$usersArray[$i]["is_responsible"] = CoreTranslator::no($lang);
			}
			
			// convention
			$convno = $usersArray[$i]['convention'];
			if ($convno == 0 || $usersArray[$i]['date_convention']=="0000-00-00"){
				$convTxt = CoreTranslator::Not_signed($lang);
			}
			else{
				$convTxt = "<p>" . CoreTranslator::Signed_the($lang) . "</p>"
						."<p>" . CoreTranslator::dateFromEn($usersArray[$i]['date_convention'], $lang) . "</p>";
			}
			$usersArray[$i]['convention'] = $convTxt;
			
			// dates
			$usersArray[$i]['date_created'] = CoreTranslator::dateFromEn($usersArray[$i]['date_created'], $lang);
			$usersArray[$i]['date_last_login'] = CoreTranslator::dateFromEn($usersArray[$i]['date_last_login'], $lang);
			$usersArray[$i]['resp_name'] = $usersArray[$i]['resp_name'] . " " .  $usersArray[$i]['resp_firstname'];
			
		}
		
		//print_r($usersArray);
		
		$modelCoreConfig = new CoreConfig();
		
		$table = new TableView();
		
		$table->setTitle($title);
		$table->ignoreEntry("id", 1);
		$table->addLineEditButton("suppliesusers/edit");
		$table->addDeleteButton("suppliesusers/delete");
		$table->addPrintButton("suppliesusers/index/");
		$tableContent =  array(
			"id" => "ID",
			"name" => CoreTranslator::Name($lang),
			"firstname" => CoreTranslator::Firstname($lang),
			"login" => CoreTranslator::Login($lang),
			"email" => CoreTranslator::Email($lang),
			"tel" => CoreTranslator::Phone($lang),
			"unit" => CoreTranslator::Unit($lang),
			"resp_name" => CoreTranslator::Responsible($lang),
			"status" => CoreTranslator::Status($lang),
			"is_responsible" => CoreTranslator::is_responsible($lang),
		);
		

		$modelCoreConfig = new CoreConfig();
			
		if ($modelCoreConfig->getParam("visible_date_convention") > 0){
			$tableContent["convention"] = CoreTranslator::Convention($lang);
		} 	
		if ($modelCoreConfig->getParam("visible_date_created") > 0){
			$tableContent["date_created"] = CoreTranslator::User_from($lang);
		}	
		if ($modelCoreConfig->getParam("visible_date_last_login") > 0){
			$tableContent["date_last_login"] = CoreTranslator::Last_connection($lang);
		}
		if ($modelCoreConfig->getParam("visible_date_end_contract") > 0){
			$tableContent["date_end_contract"] = CoreTranslator::Date_end_contract($lang);
		}
		if ($modelCoreConfig->getParam("visible_source") > 0){
			$tableContent["source"] = CoreTranslator::Source($lang);
		}
		
		
		$tableHtml = $table->view($usersArray,$tableContent);
		
		$print = $this->request->getParameterNoException("print");
		if ($table->isPrint()){
			echo $tableHtml;
			return;
		}
		
		$this->generateView ( array (
				'navBar' => $navBar, 
				'tableHtml' => $tableHtml 
		), "index" );
	}
	
	/**
	 * Shows the list of unactive users
	 */
	public function unactiveusers() {
	
		$_SESSION["users_lastvisited"] = "unactive";
		$this->index("unactive");

	}
	
	/**
	 * Shows the list of active users
	 */
	public function activeusers() {
	
		$_SESSION["users_lastvisited"] = "active";
		$this->index("active");
	
	}
	
	/**
	 * Add a new user form
	 */
	public function add(){
		$navBar = $this->navBar();
		
		// Lists for the form
		// get status list
		$modelStatus = new CoreStatus();
		$status = $modelStatus->statusIDName();

		//print_r($status);
		
		// get units list
		$modelUnit = new SuUnit();
		$unitsList = $modelUnit->unitsIDName();
		
		$userModel = new SuUser();
		$conventionsList = $userModel->getConventionList();
		
		// responsible list
		$respModel = new SuResponsible();
		$respsList = $respModel->responsibleSummaries(); 
		
		$this->generateView ( array (
				'navBar' => $navBar, 
				'statusList' => $status,
				'unitsList' => $unitsList, 
				'respsList' => $respsList,
				'conventionsList' => $conventionsList
		) );
	}
	
	/**
	 * Add a new user query to database
	 */
	public function addquery(){
		$name = $this->request->getParameter ( "name");
		$firstname = $this->request->getParameter ( "firstname");
		$login = $this->request->getParameter ( "login");
		$pwd = $this->request->getParameter ( "pwd");
		$email = $this->request->getParameter ( "email");
		$phone = $this->request->getParameter ( "phone");
		$id_unit = $this->request->getParameter ( "unit");
		$id_responsible = $this->request->getParameter ( "responsible");
		$id_status = $this->request->getParameter ( "status");
		$is_responsible = $this->request->getParameterNoException ( "is_responsible");
		$convention = $this->request->getParameterNoException ( "convention");
		$date_convention = $this->request->getParameterNoException ( "date_convention");
		$date_end_contract = $this->request->getParameterNoException ( "date_end_contract");
		
		$lang = 'En';
		if (isset($_SESSION["user_settings"]["language"])){
			$lang = $_SESSION["user_settings"]["language"];
		}
			
		if ($date_convention != ""){
			$date_convention = CoreTranslator::dateToEn($date_convention, $lang);
		}
		if ($date_end_contract != ""){
			$date_end_contract = CoreTranslator::dateToEn($date_end_contract, $lang);
		}

		// auto convention
		if ($convention == -1){
			// new convention for a responsible
			if ($is_responsible != ''){
				// get the last convention number
				$conventionsList = $this->userModel->getConventionList();
				$convention = $conventionsList[count($conventionsList)-1][0]+1;
			}
			else{
				// get the responsible convention
				$convention = $this->userModel->getUserConvention($id_responsible);
			}
		}
		
		
		// add the user to the database
		$this->userModel->addUser($name, $firstname, $login, $pwd, 
				                  $email, $phone, $id_unit,
				                  $id_responsible, $id_status, $convention, 
				                  $date_convention, $date_end_contract );
		
		// add the user to the responsible list
		if ($is_responsible != ''){
			$userID = $this->userModel->getUser($login, $pwd);
			$respModel = new SuResponsible();
			$respModel->addResponsible($userID['idUser']);
		}
		
		// generate view
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar
		) );
		
	}
	
	/**
	 * Edit a user form
	 */
	public function edit(){
		
		$navBar = $this->navBar();
		
		// get user id
		$userId = 0;
		if ($this->request->isParameterNotEmpty('actionid')){
			$userId = $this->request->getParameter("actionid");
		}
		
		// get user info
		$user = $this->userModel->userAllInfo($userId);	
		
		// Lists for the form
		// get status list
		$modelStatus = new CoreStatus();
		$status = $modelStatus->statusIDName();

		// get units list
		$modelUnit = new SuUnit();
		$unitsList = $modelUnit->unitsIDName();
	
		
		// responsible list
		$respModel = new SuResponsible();
		$respsList = $respModel->responsibleSummaries(); 
		
		// is responsoble user
		$user['is_responsible'] = $respModel->isResponsible($user['id']);
		
		// generate the view
		$this->generateView ( array (
				'navBar' => $navBar, 'statusList' => $status,
				'unitsList' => $unitsList,
				'respsList' => $respsList, 'user' => $user
		) );
	}
	
	/**
	 * Edit a user query to database
	 */
	public function editquery(){
		
		// get form variables
		$id = $this->request->getParameter ( "id");
		$name = $this->request->getParameter ( "name"); 
		$firstname = $this->request->getParameter ( "firstname");
		$login = $this->request->getParameter ( "login");
		$email = $this->request->getParameter ( "email");
		$phone = $this->request->getParameter ( "phone");
		$id_unit = $this->request->getParameter ( "id_unit");
		$id_responsible = $this->request->getParameter ( "id_responsible");
		$is_responsible = $this->request->getParameterNoException ("is_responsible");
		$id_status = $this->request->getParameter ( "id_status");
		$convention = $this->request->getParameterNoException ( "convention");
		$date_convention = $this->request->getParameterNoException ( "date_convention");
		$date_end_contract = $this->request->getParameterNoException ( "date_end_contract");
		$isLdap = $this->request->getParameterNoException ("isLdap");
		$lang = 'En';
		if (isset($_SESSION["user_settings"]["language"])){
			$lang = $_SESSION["user_settings"]["language"];
		}
			
		if ($date_convention != ""){
			$date_convention = CoreTranslator::dateToEn($date_convention, $lang);
		}
		if ($date_end_contract != ""){
			$date_end_contract = CoreTranslator::dateToEn($date_end_contract, $lang);
		}
		//echo "id_responsible = " . $id_responsible . "--";
		
		// update user
		$this->userModel->updateUser($id, $firstname, $name, $login, $email, $phone,
    		                         $id_unit, $id_responsible, $id_status,
				                     $convention, $date_convention, $date_end_contract, 1, $isLdap);

		// update responsible
		
		//echo "is_responsible = " . $is_responsible . "<br/>";
		if ($is_responsible != ""){
			$respModel = new SuResponsible();
			$respModel->addResponsible($id);
		} 
		else{
			$respModel = new SuResponsible();
			$respModel->removeResponsible($id);
		}
		
		// update the active/unactive
		$is_active = $this->request->getParameterNoException ( "is_active");
		$this->userModel->setactive($id, $is_active);
		
		// generate view
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar
		) );
	}
	
	/**
	 * Activate a user
	 */
	public function activate(){
		$userId = 0;
		if ($this->request->isParameterNotEmpty('actionid')){
			$userId = $this->request->getParameter("actionid");
		};
		
		if ($userId>0){
			$this->userModel->activate($userId);
		}
		
		$this->redirect("suppliesusers", "index");
	}
	
	/**
	 * Form to export the responsibles to a file
	 */
	public function exportresponsable(){
		
		// generate view
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar
		) );
	}
	
	/**
	 * Query to export the responsibles to a file
	 */
	public function exportresponsablequery(){
	
		$idType = $this->request->getParameterNoException("id_type");
		
		//echo "idType = " . $idType . "<br/>";
		//return;
		$this->userModel->exportResponsible($idType);
		return;
	}
		
	/**
	 * Query to delete a user
	 */
	public function delete(){
		
		$userId = $this->request->getParameter("actionid");
		
		$user = $this->userModel->delete($userId);
		
		// generate view
		$this->redirect("suppliesusers");
	}
}
