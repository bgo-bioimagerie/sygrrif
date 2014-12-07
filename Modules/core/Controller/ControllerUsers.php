<?php
require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/User.php';
require_once 'Modules/core/Model/Status.php';
require_once 'Modules/core/Model/Unit.php';
require_once 'Modules/core/Model/Responsible.php';
require_once 'Modules/core/Model/UserGRR.php';

class ControllerUsers extends ControllerSecureNav {
	
	/**
	 * User model object
	 */
	private $userModel;
	
	//private $billet;
	public function __construct() {
		//$this->billet = new Billet ();
		$this->userModel = new User();
	}
	
	
	
	// Affiche la liste de tous les billets du blog
	public function index() {
		
		$navBar = $this->navBar();
		
		// get sort action
		$sortentry = "id";
		if ($this->request->isParameterNotEmpty('actionid')){
			$sortentry = $this->request->getParameter("actionid");
		}
			
		// get the user list
		$usersArray = $this->userModel->getUsersInfo($sortentry);
		
		
		$this->generateView ( array (
				'navBar' => $navBar, 'usersArray' => $usersArray 
		) );
	}
	
	
	public function add(){
		$navBar = $this->navBar();
		
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
		
		$this->generateView ( array (
				'navBar' => $navBar, 'statusList' => $status,
				'unitsList' => $unitsList, 
				'respsList' => $respsList
		) );
	}
	
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
		
		
		// add the user to the database
		$this->userModel->addUser($name, $firstname, $login, $pwd, 
				                  $email, $phone, $id_unit, 0, 
				                  $id_responsible, $id_status, $convention, $date_convention );
		
		// add the user to the responsible list
		if ($is_responsible != ''){
			$userID = $this->userModel->getUser($login, $pwd);
			$respModel = new Responsible();
			$respModel->addResponsible($userID['idUser']);
		}
		
		// GRR add user
		if (Configuration::get("grr_installed")){
			$use_grr = $this->request->getParameterNoException ( "grr_use");
			if ($use_grr != ''){
				// add user to grr
				$grr_status = $this->request->getParameter ( "grr_status");
				$grr_etat = $this->request->getParameter ( "grr_etat");
				$usergrrModel = new UserGRR();
				$usergrrModel->addUser($login, $name, $firstname, $pwd, $email, $grr_status, $grr_etat);
			}
		}
		
		// generate view
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar
		) );
		
	}
	
	
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
		
		// GRR
		$grretat = "";
		$grrstatus = "";
		if (Configuration::get("grr_installed")){
			$usermodelgrr = new UserGRR();
			$grrinfo = $usermodelgrr->getStatusState($user['login']);
			if ($grrinfo){
				$grretat = $grrinfo['etat'];
				$grrstatus = $grrinfo['statut'];
			}
		}
		
		// generate the view
		$this->generateView ( array (
				'navBar' => $navBar, 'statusList' => $status,
				'unitsList' => $unitsList,
				'respsList' => $respsList, 'user' => $user, 
				'grretat' => $grretat, 'grrstatus' => $grrstatus
		) );
	}
	
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
		$is_responsible = $this->request->getParameterNoException ( "is_responsible");
		$id_status = $this->request->getParameter ( "id_status");
		$convention = $this->request->getParameterNoException ( "convention");
		$date_convention = $this->request->getParameterNoException ( "date_convention");
		
		
		// update user
		$this->userModel->updateUser($id, $firstname, $name, $login, $email, $phone,
    		                         $id_unit, 0, $id_responsible, $id_status,
				                     $convention, $date_convention);

		// update responsible
		if ($is_responsible != ''){
			$respModel = new Responsible();
			$respModel->addResponsible($id);
		} 
		
		// GRR add user
		if (Configuration::get("grr_installed")){
			$use_grr = $this->request->getParameterNoException ( "grr_use");
			if ($use_grr != ''){
				// add user to grr
				$grr_status = $this->request->getParameter ( "grr_status");
				$grr_etat = $this->request->getParameter ( "grr_etat");
				$usergrrModel = new UserGRR();
				$usergrrModel->editUser($login, $name, $firstname, $email, $grr_status, $grr_etat);
			}
		}
		
		// generate view
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar
		) );
	}
	
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
	
	public function manageaccount(){
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
				'unit' => $unit['name'],
				'resp' => $resp, 'user' => $user
		) );
		
	}
	
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
	
	public function accountchangepwdquery(){
		
		$id = $this->request->getParameter ( "id");
		$login = $this->request->getParameter ( "login");
		$previouspwd = $this->request->getParameter ( "previouspwd");
		$pwd = $this->request->getParameter ( "pwd");
		$pwdc = $this->request->getParameter ( "pwdc");
		
		echo "id to change = " . $id;
		
		$previouspwddb = $this->userModel->getpwd($id);
		echo "previous pwd = " . sha1($previouspwd);
		echo "previous pwd db = " . $previouspwddb['pwd'];
		
		
		if ($previouspwddb['pwd'] == sha1($previouspwd)){
		
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
	
}