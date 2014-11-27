<?php
require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/User.php';
require_once 'Modules/core/Model/Status.php';
require_once 'Modules/core/Model/Team.php';
require_once 'Modules/core/Model/Unit.php';
require_once 'Modules/core/Model/Responsible.php';

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
		
		// get teams list
		$modelTeam = new Team();
		$teamsList = $modelTeam->teamsIDName();
	
		
		// responsible list
		$respModel = new Responsible();
		$respsList = $respModel->responsibleSummaries(); 
		
		$this->generateView ( array (
				'navBar' => $navBar, 'statusList' => $status,
				'unitsList' => $unitsList, 'teamsList' => $teamsList,
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
		$id_team = $this->request->getParameter ( "team");
		$id_responsible = $this->request->getParameter ( "responsible");
		$id_status = $this->request->getParameter ( "status");
		$is_responsible = $this->request->getParameterNoException ( "is_responsible");
		
		
		// add the user to the database
		$this->userModel->addUser($name, $firstname, $login, $pwd, 
				                  $email, $phone, $id_unit, $id_team, 
				                  $id_responsible, $id_status );
		
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
		
		// get teams list
		$modelTeam = new Team();
		$teamsList = $modelTeam->teamsIDName();
	
		
		// responsible list
		$respModel = new Responsible();
		$respsList = $respModel->responsibleSummaries(); 
		
		// is responsoble user
		$user['is_responsible'] = $respModel->isResponsible($user['id']);
		
		// generate the view
		$this->generateView ( array (
				'navBar' => $navBar, 'statusList' => $status,
				'unitsList' => $unitsList, 'teamsList' => $teamsList,
				'respsList' => $respsList, 'user' => $user
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
		$id_team = $this->request->getParameter ( "id_team");
		$id_responsible = $this->request->getParameter ( "id_responsible");
		$is_responsible = $this->request->getParameterNoException ( "is_responsible");
		$id_status = $this->request->getParameter ( "id_status");
		
		
		// update user
		$this->userModel->updateUser($id, $firstname, $name, $login, $email, $phone,
    		                         $id_unit, $id_team, $id_responsible, $id_status);

		// update responsible
		if ($is_responsible != ''){
			$respModel = new Responsible();
			$respModel->addResponsible($id);
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
		$pwd = $this->request->getParameter ( "pwd");
		$pwdc = $this->request->getParameter ( "pwdc");
		
		if ($pwd == $pwdc){
			$this->userModel->changePwd($id, $pwd);
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
	
}