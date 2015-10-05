<?php


require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/sprojects/Model/SpUser.php';
require_once 'Modules/sprojects/Model/SpUnit.php';
require_once 'Modules/sprojects/Model/SpResponsible.php';

class ControllerSprojectsusers extends ControllerSecureNav {

	public function index() {
		
		// get sort action
		$sortentry = "id";
		if ($this->request->isParameterNotEmpty('actionid')){
			$sortentry = $this->request->getParameter("actionid");
		}
		
		// get the user list
		$modelUser = new SpUser();
		$usersArray = $modelUser->getUsersInfo($sortentry);
		
		// view
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'usersArray' => $usersArray
		) );
	}
	
	public function edit(){
		
		// get sort action
		$userID = "";
		if ($this->request->isParameterNotEmpty('actionid')){
			$userID = $this->request->getParameter("actionid");
		}
		
		$model = new SpUser();
		$user = array();
		if ($userID == ""){ // default values
			$user = $model->defaultUserAllInfo();
		}
		else{ // get user info
			$user = $model->userAllInfo($userID);
		}
		
		// units
		$modelUnit = new SpUnit();
		$unitsList = $modelUnit->unitsIDName();
		
		
		// responsible list
		$respModel = new SpResponsible();
		$respsList = $respModel->responsibleSummaries();
		
		// is responsoble user
		if ($userID == ""){
			$user['is_responsible'] = 0;
		}
		else{
			$user['is_responsible'] = $respModel->isResponsible($user['id']);
		}
		// view
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'user' => $user,
				'unitsList' => $unitsList,
				'respsList' => $respsList
				
		) );
	}
	
	public function editquery(){
	
		// get form variables
		$id = $this->request->getParameterNoException ( "id");
		$name = $this->request->getParameter ( "name");
		$firstname = $this->request->getParameter ( "firstname");
		$email = $this->request->getParameter ( "email");
		$phone = $this->request->getParameter ( "phone");
		$id_unit = $this->request->getParameter ( "id_unit");
		$id_responsible = $this->request->getParameterNoException ( "id_responsible");
		$is_responsible = $this->request->getParameterNoException ( "is_responsible");
		
		//echo "id_responsible = " . $id_responsible . "--";
	
		if ($id_responsible == ""){
			$id_responsible = 1;
		}
		
		// update user
		$userModel = new SpUser();
		if ($id == ""){
			$id = $userModel->addUser($name, $firstname, $email, $phone, $id_unit, $id_responsible);
		}
		else{
			$userModel->updateUser($id, $firstname, $name, $email, $phone,
				$id_unit, $id_responsible);
		}
		// update responsible
		if ($is_responsible != ''){
			$respModel = new SpResponsible();
			$respModel->addResponsible($id);
			
			$userModel->setResponsible($id, $id);
		}
	
		// generate view
		$this->redirect("sprojectsusers");
	}
}