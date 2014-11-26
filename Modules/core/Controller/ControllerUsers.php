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
		$usersArray = $this->userModel->getUsers($sortentry);
		
		
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
	}
	
	
	public function edit(){
		
		$navBar = $this->navBar();
		
		// get user id
		$userId = 0;
		if ($this->request->isParameterNotEmpty('actionid')){
			$userId = $this->request->getParameter("actionid");
		}
		
		// get user info
		$userquery = $this->userModel->userAllInfo($userId);
		
		$modelUnit = new Unit();
		$unitName = $modelUnit->getUnitName($userquery["id_unit"]);
		
		$modelTeam = new Team();
		$teamName = $modelTeam->getTeamName($userquery["id_team"]);
		
		$modelStatus = new Status();
		$statusName = $modelStatus->getStatusName($userquery["id_status"]);
		
		$resp_summary = $this->userModel->userSummary($userquery['id_responsible']);
		
		$user = array(
				'id' => $userquery['id'],
				'name' => $userquery['name'],
				'firstname' => $userquery['firstname'],
				'login' => $userquery['login'],
				'email' => $userquery['email'],
				'tel' => $userquery['tel'],
				'unit' => $unitName,
				'team' => $teamName,
				'resp_summary' => $resp_summary,
				'status' => $statusName
		);
		
		// Lists for the form
		// get status list
		$status = $modelStatus->allStatus();
		
		// get teams list
		$teamsList = $modelTeam->teamsName();
		
		// get teams list
		$unitsList = $modelUnit->unitsName();
		
		// responsible list
		$respModel = new Responsible();
		$respsList = $respModel->responsibleSummaries();
		
		// responsible status
		$isResponsible = $respModel->isResponsible($userId);
		
		$this->generateView ( array (
				'navBar' => $navBar, 'user' => $user, 'statusList' => $status, 
				'unitsList' => $unitsList, 'teamsList' => $teamsList,
				'respsList' => $respsList, 'isResponsible' => $isResponsible
		) );
	}
	
	public function editquery(){
		
		// get form variables
		$id = $this->request->getParameter ( "name");
		$name = $this->request->getParameter ( "name"); 
		$firstname = $this->request->getParameter ( "firstname");
		$login = $this->request->getParameter ( "login");
		$email = $this->request->getParameter ( "email");
		$phone = $this->request->getParameter ( "phone");
		$unit = $this->request->getParameter ( "unit");
		$team = $this->request->getParameter ( "team");
		$responsible = $this->request->getParameter ( "responsible");
		$is_responsible = $this->request->getParameter ( "is_responsible");
		$status = $this->request->getParameter ( "status");
		
		// get the responsible id
		list($responsibleFullName, $responsibleId) = split('id:', $responsible);
		
		// update user
		$this->userModel->updateUser($id, $firstname, $name, $login, $email, $phone,
    		                         $unit, $team, $responsibleId, $status);

		// update responsible
		if ($is_responsible){
			$respModel = new Responsible();
			$respModel->addResponsible($id);
		} 
	}
	
}