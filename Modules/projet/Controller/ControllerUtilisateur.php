<?php
require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/projet/Model/Utilisateur.php';

class ControllerUtilisateur extends ControllerSecureNav{
	
	public function index(){
	$ModifierUser=false;
		if ($_SESSION["user_status"]>=3){
				$ModifierUser=true; //readonly
			}
		$id="";
				if($this->request->isParameterNotEmpty('actionid'))
				{
					$id=$this->request->getParameter("actionid");
				}
	
		$navBar = $this->navBar();
		$modeluser = new Utilisateur();
		$duser= $modeluser->getUser($id);
		$this->generateView ( array (
					'navBar' => $navBar,
					'id' => $id,
					'duser'=>$duser,
					'ModifierUser'=>$ModifierUser,	
			) );
	}
	public function  AjoutUser(){
		$id=$this->request->getParameter("id");
		$nom= $this->request->getParameter("nom");
		$prenom= $this->request->getParameter("prenom");
		$identifiant= $this->request->getParameter("identifiant");
		$mdp= $this->request->getParameter("mdp");
		$courrier= $this->request->getParameter("courrier");
		$tel= $this->request->getParameter("tel");
		$status= $this->request->getParameter("status");
		$charte= $this->request->getParameter("charte");
		$model= new Utilisateur();
		
		if($id!=''){
		$model->UpdateUser($id, $nom, $prenom, $identifiant, $courrier, $tel, $status, $charte);}
			ELSE{
		$model->setUtilisateur($nom, $prenom, $identifiant, $mdp, $courrier, $tel, $status, $charte);}
		
		$this->redirect("Utilisateur", "ListUsers");
	}
	public function DeleteUser(){
	$id = '';
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$id = $this->request->getParameter ( "actionid" );
		}
		$model= new Utilisateur();
		$model->deletUser($id);
			$this->redirect("Utilisateur", "ListUsers");
		
	}
	public function ListUsers(){
		
		$modelUser = new Utilisateur();
		$liste= $modelUser->getUserModif();
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar, 
				'liste'=> $liste,	
						
		) );
		
	}
	
	
}