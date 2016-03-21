<?php
require_once 'Framework/Controller.php';
require_once 'Framework/TableView.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/CoreUser.php';
require_once 'Modules/core/Model/CoreStatus.php';
require_once 'Modules/core/Model/CoreUnit.php';
require_once 'Modules/core/Model/CoreResponsible.php';
require_once 'Modules/core/Model/CoreTranslator.php';
require_once 'Modules/core/Model/CoreConfig.php';

/**
 * Manage the users
 * 
 * @author sprigent
 *
 */
class ControllerCoreusers extends ControllerSecureNav {
	
	/**
	 * User model object
	 */
	private $userModel;
	
	/**
	 * Constructor
	 */
	public function __construct() {
            parent::__construct();
            header_remove();
		$this->userModel = new CoreUser();
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
			if ($usersArray[$i]['date_convention']=="0000-00-00"){
				$convTxt = CoreTranslator::Not_signed($lang);
			}
			else{
				$convTxt = "" . CoreTranslator::Signed_the($lang)
						." " . CoreTranslator::dateFromEn($usersArray[$i]['date_convention'], $lang) . "";
			}
			$usersArray[$i]['convention'] = $convTxt;
			
			// dates
			$usersArray[$i]['date_created'] = CoreTranslator::dateFromEn($usersArray[$i]['date_created'], $lang);
			$usersArray[$i]['date_last_login'] = CoreTranslator::dateFromEn($usersArray[$i]['date_last_login'], $lang);
			
			$respsIds = $this->userModel->getUserResponsibles($usersArray[$i]['id']);
			$usersArray[$i]['resp_name'] = "";
			for($j = 0 ; $j < count($respsIds) ; $j++){
				$usersArray[$i]['resp_name'] .= $this->userModel->getUserFUllName($respsIds[$j][0]) ;
				if ($j < count($respsIds)-1){
					$usersArray[$i]['resp_name'] .= ", ";
				}
			}
		}
		
		//print_r($usersArray);
		
		$modelCoreConfig = new CoreConfig();
		$authorisations_location = $modelCoreConfig->getParam("sy_authorisations_location");
		
		$table = new TableView();
		
		$table->setTitle($title);
		$table->ignoreEntry("id", 1);
		$table->addLineEditButton("coreusers/edit");
		$table->addDeleteButton("coreusers/delete");
		$table->addPrintButton("coreusers/index/");
		if ($authorisations_location == 2){
			$table->addLineButton("Sygrrifauthorisations/userauthorizations", "id", CoreTranslator::Authorizations($lang));
		}
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
		
		// get units list
		$modelUnit = new CoreUnit();
		$unitsList = $modelUnit->unitsIDName();
		
		$userModel = new CoreUser();
		$conventionsList = $userModel->getConventionList();

		$userResponsibles = array();
		
		// responsible list
		$respModel = new CoreResponsible();
		$respsList = $respModel->responsibleSummaries(); 
		
		$this->generateView ( array (
				'navBar' => $navBar, 
				'statusList' => $status,
				'unitsList' => $unitsList, 
				'respsList' => $respsList,
				'conventionsList' => $conventionsList,
				'userResponsibles' => $userResponsibles
		), "add" );
	}
	
	/**
	 * Add a new user query to database
	 */
	public function addquery(){
            
            $lang = $this->getLanguage();
            
            // check if the login is already taken
            $login = $this->request->getParameter ( "login");
            
            if ($this->userModel->isLogin($login)){
                echo '<script language="javascript">';
                echo 'alert("'. CoreTranslator::LoginAlreadyExists($lang) .'")';
                echo '</script>';
                return;
            }
            
            $name = $this->request->getParameter ( "name");
            $firstname = $this->request->getParameter ( "firstname");
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
			$respModel = new CoreResponsible();
			$respModel->addResponsible($userID['idUser']);
		}
		
		// save the convention
		$this->uploadConvention($login);
		
		// generate view
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar
		) );
	}
	
	/**
	 * Upload the sygrrif bill template
	 *
	 * @return string
	 */
	public function uploadConvention($user_id){
		$target_dir = "data/core/";
		$target_file = $target_dir . $user_id . ".pdf";

		$uploadOk = 1;
		$imageFileType = pathinfo($_FILES["file_convention"]["name"],PATHINFO_EXTENSION);
	
		// Check file size
		if ($_FILES["file_convention"]["size"] > 500000000) {
			return "Error: your file is too large.";
			$uploadOk = 0;
		}
		// Allow certain file formats
		if($imageFileType != "pdf") {
			return "Error: only pdf files are allowed.";
			$uploadOk = 0;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			return  "Error: your file was not uploaded.";
			// if everything is ok, try to upload file
		} else {
			if (move_uploaded_file($_FILES["file_convention"]["tmp_name"], $target_file)) {
				return  "The file logo file". basename( $_FILES["file_convention"]["name"]). " has been uploaded.";
			} else {
				return "Error, there was an error uploading your file.";
			}
		}
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
		
		// test if the user is allowed to edit this user
		$editUserStatus = $this->userModel->getUserStatus($userId);
		if($_SESSION["user_status"] < $editUserStatus){
			echo "Access denied: You are not allowed to edit this user.";
			return;
		}
		
		// get user info
		$user = $this->userModel->userAllInfo($userId);	
		
		$userResponsibles = $this->userModel->getUserResponsibles($userId);
		
		//print_r($userResponsibles);
		
		// Lists for the form
		// get status list
		$modelStatus = new CoreStatus();
		$status = $modelStatus->statusIDName();

		// get units list
		$modelUnit = new CoreUnit();
		$unitsList = $modelUnit->unitsIDName();
	
		
		// responsible list
		$respModel = new CoreResponsible();
		$respsList = $respModel->responsibleSummaries(); 
		
		// is responsoble user
		$user['is_responsible'] = $respModel->isResponsible($user['id']);
		
		// generate the view
		$this->generateView ( array (
				'navBar' => $navBar, 'statusList' => $status,
				'unitsList' => $unitsList,
				'respsList' => $respsList, 'user' => $user,
				'userResponsibles' => $userResponsibles
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
			$respModel = new CoreResponsible();
			$respModel->addResponsible($id);
		} 
		else{
			$respModel = new CoreResponsible();
			$respModel->removeResponsible($id);
		}
		
		// update the active/unactive
		$is_active = $this->request->getParameterNoException ( "is_active");
		$this->userModel->setactive($id, $is_active);
		
		// save the convention
		$this->uploadConvention($login);
		
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
		$navBar = $this->navBar();
		
		// get user id
		$userId = 0;
		$userId = $this->request->getSession()->getAttribut("id_user");
		
		// get user info
		$user = $this->userModel->userAllInfo($userId);
		
		// Lists for the form
		// get status list
		$modelStatus = new CoreStatus();
		$status = $modelStatus->getStatusName($user['id_status']);
		
		// get units list
		$modelUnit = new CoreUnit();
		$unit = $modelUnit->getUnitName($user['id_unit']);
		
		// responsible list
		$resp = $this->userModel->getUserFUllName($user['id_responsible']);
		
		// is responsoble user
		$respModel = new CoreResponsible();
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
		$userId = 0;
		if ($this->request->isParameterNotEmpty('actionid')){
			$userId = $this->request->getParameter("actionid");
		};
		
		if ($userId>0){
			$this->userModel->activate($userId);
		}
		
		$this->redirect("coreusers", "index");
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
	 * Search in the user database
	 * @param string $sortentry
	 */
	public function searchquery($sortentry = "id"){
	
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
	 * Query to delete a user
	 */
	public function delete(){
		
		$userId = $this->request->getParameter("actionid");
		
		$user = $this->userModel->delete($userId);
		
		// generate view
		$this->redirect("coreusers");
	}
}
