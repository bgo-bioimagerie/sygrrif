<?php
require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/User.php';
require_once 'Modules/core/Model/Status.php';
require_once 'Modules/core/Model/Unit.php';
require_once 'Modules/core/Model/Responsible.php';
require_once 'Modules/core/Model/CoreTranslator.php';

/**
 * Manage the users
 * 
 * @author sprigent
 *
 */
class ControllerUsers extends ControllerSecureNav {
	
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
	 * User model object
	 */
	private $userModel;
	
	/**
	 * Constructor
	 */
	public function __construct() {
		header_remove();
		$this->userModel = new User();
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Controller::index()
	 */
	public function index() {
		
		if($this->secureCheck()){
			return;
		}
		
		// get sort action
		$sortentry = "id";
		if ($this->request->isParameterNotEmpty('actionid')){
			$sortentry = $this->request->getParameter("actionid");
		}
		
		$searchColumn = "0";
		$searchTxt = "";
		if ( isset($_SESSION["user_searchColumn"])){
			$this->searchquery($sortentry);
			return;
		}
		
		
		
		$navBar = $this->navBar();
			
		// get the user list
		$usersArray = $this->userModel->getActiveUsersInfo($sortentry);
		
		
		$this->generateView ( array (
				'navBar' => $navBar, 'usersArray' => $usersArray,
				'searchColumn' => $searchColumn, "searchTxt" => $searchTxt 
		) );
	}
	
	/**
	 * Shows the list of active users
	 */
	public function unactiveusers() {
	
		if($this->secureCheck()){
			return;
		}
		
		$navBar = $this->navBar();
	
		// get sort action
		$sortentry = "id";
		if ($this->request->isParameterNotEmpty('actionid')){
			$sortentry = $this->request->getParameter("actionid");
		}
			
		// get the user list
		$usersArray = $this->userModel->getActiveUsersInfo($sortentry, 0);
	
	
		$this->generateView ( array (
				'navBar' => $navBar, 'usersArray' => $usersArray
		), "index" );
	}
	
	/**
	 * Add a new user form
	 */
	public function add(){
		
		if($this->secureCheck()){
			return;
		}
		
		$navBar = $this->navBar();
		
		// Lists for the form
		// get status list
		$modelStatus = new Status();
		$status = $modelStatus->statusIDName();

		//print_r($status);
		
		// get units list
		$modelUnit = new Unit();
		$unitsList = $modelUnit->unitsIDName();
		
		$userModel = new User();
		$conventionsList = $userModel->getConventionList();
		
		// responsible list
		$respModel = new Responsible();
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
		
		if($this->secureCheck()){
			return;
		}
		
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
			$respModel = new Responsible();
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
		
		if($this->secureCheck()){
			return;
		}
		
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
		$modelStatus = new Status();
		$status = $modelStatus->statusIDName();

		// get units list
		$modelUnit = new Unit();
		$unitsList = $modelUnit->unitsIDName();
	
		
		// responsible list
		$respModel = new Responsible();
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
		
		if($this->secureCheck()){
			return;
		}
		
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
			$respModel = new Responsible();
			$respModel->addResponsible($id);
		} 
		else{
			$respModel = new Responsible();
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
	 * Change password form
	 */
	public function changepwd(){
		
		if($this->secureCheck()){
			return;
		}
		
		$userId = 0;
		if ($this->request->isParameterNotEmpty('actionid')){
			$userId = $this->request->getParameter("actionid");
		};
		
		$user = $this->userModel->userAllInfo($userId);	
		
		// generate view
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar, 'user' => $user
		) );
	}
	
	/**
	 * Change password query
	 * @throws Exception
	 */
	public function changepwdquery(){
		
		if($this->secureCheck()){
			return;
		}
		
		$id = $this->request->getParameter ( "id");
		$login = $this->request->getParameter ( "login");
		$pwd = $this->request->getParameter ( "pwd");
		$pwdc = $this->request->getParameter ( "pwdc");
		
		if ($pwd == $pwdc){
			// this database
			$this->userModel->changePwd($id, $pwd);
			
			// grr database
			if (Configuration::get("grr_installed")){
				$grrmodel = new UserGRR();
				$grrmodel->changePwd($login, $pwd);
			}
		}
		else{
			throw new Exception("The two passwords are not identical");
		}

		// generate view
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar
		) );
	}
	
	/**
	 * User form to edit his own informations
	 */
	public function manageaccount(){
		
		if($this->secureCheck()){
			return;
		}
		
		$navBar = $this->navBar();
		
		// get user id
		$userId = 0;
		$userId = $this->request->getSession()->getAttribut("id_user");
		
		// get user info
		$user = $this->userModel->userAllInfo($userId);
		
		// Lists for the form
		// get status list
		$modelStatus = new Status();
		$status = $modelStatus->getStatusName($user['id_status']);
		
		// get units list
		$modelUnit = new Unit();
		$unit = $modelUnit->getUnitName($user['id_unit']);
		
		// responsible list
		$resp = $this->userModel->getUserFUllName($user['id_responsible']);
		
		// is responsoble user
		$respModel = new Responsible();
		$user['is_responsible'] = $respModel->isResponsible($user['id']);
		
		// generate the view
		$this->generateView ( array (
				'navBar' => $navBar, 'status' => $status['name'],
				'unit' => $unit,
				'resp' => $resp, 'user' => $user
		) );
		
	}
	
	/**
	 * User edit his own info query
	 */
	public function manageaccountquery(){

		if($this->secureCheck()){
			return;
		}
		
		// get form variables
		$id = $this->request->getParameter ( "id");
		$login = $this->request->getParameter ( "login");
		$name = $this->request->getParameter ( "name");
		$firstname = $this->request->getParameter ( "firstname");
		$email = $this->request->getParameter ( "email");
		$phone = $this->request->getParameter ( "phone");
		
		// update user
		$this->userModel->updateUserAccount($id, $firstname, $name, $email, $phone);
		
		// grr database
		if (Configuration::get("grr_installed")){
			$grrmodel = new UserGRR();
			$grrmodel->updateUserAccount($login, $firstname, $name, $email);
		}
		
		// generate view
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar
		) );
		
	}
	
	/**
	 * Modify password
	 * @throws Exception
	 */
	public function accountchangepwdquery(){
		
		if($this->secureCheck()){
			return;
		}
		
		$id = $this->request->getParameter ( "id");
		$login = $this->request->getParameter ( "login");
		$previouspwd = $this->request->getParameter ( "previouspwd");
		$pwd = $this->request->getParameter ( "pwd");
		$pwdc = $this->request->getParameter ( "pwdc");
		
		//echo "id to change = " . $id;
		
		$previouspwddb = $this->userModel->getpwd($id);
		//echo "previous pwd = " . md5($previouspwd);
		//echo "previous pwd db = " . $previouspwddb['pwd'];
		
		
		if ($previouspwddb['pwd'] == md5($previouspwd)){
		
			if ($pwd == $pwdc){
				$this->userModel->changePwd($id, $pwd);
				
				// grr database
				if (Configuration::get("grr_installed")){
					$grrmodel = new UserGRR();
					$grrmodel->changePwd($login, $pwd);
				}
			}
			else{
				throw new Exception("The two passwords are not identical");
			}
		}
		else{
			throw new Exception("The curent password is not correct");
		}

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
		
		if($this->secureCheck()){
			return;
		}
		
		$userId = 0;
		if ($this->request->isParameterNotEmpty('actionid')){
			$userId = $this->request->getParameter("actionid");
		};
		
		if ($userId>0){
			$this->userModel->activate($userId);
		}
		
		$this->redirect("users", "index");
	}
	
	/**
	 * Form to export the responsibles to a file
	 */
	public function exportresponsable(){
		
		if($this->secureCheck()){
			return;
		}
		
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
	
		if($this->secureCheck()){
			return;
		}
		
		$idType = $this->request->getParameterNoException("id_type");
		
		//echo "idType = " . $idType . "<br/>";
		//return;
		$this->userModel->exportResponsible($idType);
		return;
	}
	
	/**
	 * Search in the user database
	 * @param string $sortentry
	 */
	public function searchquery($sortentry = "id"){
	
		if($this->secureCheck()){
			return;
		}
		
		$lang = "En";
		if (isset($_SESSION["user_settings"]["language"])){
			$lang = $_SESSION["user_settings"]["language"];
		}
	
		$searchColumn = $this->request->getParameterNoException("searchColumn");
		$searchTxt = $this->request->getParameterNoException("searchTxt");
		
		if ($searchColumn == ""){
			$searchColumn = $_SESSION["user_searchColumn"];
			$searchTxt = $_SESSION["user_searchTxt"];
		}
		
		$_SESSION["user_searchColumn"] = $searchColumn;
		$_SESSION["user_searchTxt"] = $searchTxt;
	
		$usersArray = array();
		if($searchColumn == "0"){
			$usersArray = $this->userModel->getActiveUsersInfo($sortentry);
		}
		else if($searchColumn == "name"){
			$usersArray = $this->userModel->getUsersInfoSearch("name", $searchTxt, $sortentry);
		}
		else if($searchColumn == "firstname"){
			$usersArray = $this->userModel->getUsersInfoSearch("firstname", $searchTxt, $sortentry);
		}
		else if($searchColumn == "unit"){
			$usersArray = $this->userModel->getUsersUnitInfoSearch("name", $searchTxt, $sortentry);
		}
		else if($searchColumn == "id_status"){
			$usersArray = $this->userModel->getUsersStatusInfoSearch("name", $searchTxt, $sortentry);
		}
		else if( $searchColumn == "responsible"){
			$usersArray = $this->userModel->getUsersResponsibleInfoSearch("name", $searchTxt, $sortentry);
		}
	
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar, 'usersArray' => $usersArray,
				'searchColumn' => $searchColumn, 'searchTxt' => $searchTxt
		), "index" );
	}
	
	/**
	 * Confirm form to delete a user
	 */
	public function delete(){
		
		if($this->secureCheck()){
			return;
		}
		
		$userId = 0;
		if ($this->request->isParameterNotEmpty('actionid')){
			$userId = $this->request->getParameter("actionid");
		};
		
		$userName = $this->userModel->getUserFUllName($userId);
		
		// generate view
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar, 
				'userName' => $userName,
				'userId' => $userId
		) );
	}
	
	/**
	 * Query to delete a user
	 */
	public function deletequery(){
		
		if($this->secureCheck()){
			return;
		}
		
		$userId = $this->request->getParameter("id");
		
		$user = $this->userModel->delete($userId);
		
		// generate view
		$this->redirect("users");
	}
}
