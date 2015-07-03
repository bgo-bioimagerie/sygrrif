<?php
require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/projet/Model/GestionTarif.php';

class ControllerTarifs extends ControllerSecureNav{
	
	public function index(){
		
	$ModifierTarif=false;
		if ($_SESSION["user_status"]>=3){
				$ModifierTarif=true; //readonly
			}
		$idt="";
				if($this->request->isParameterNotEmpty('actionid'))
				{
					$idt=$this->request->getParameter("actionid");
				}
	
		$navBar = $this->navBar();
		$modeltarif = new GestionTarif();
		$Mesdonnees= $modeltarif->getTarif($idt);
			$this->generateView ( array (
					'navBar' => $navBar,
					
					'idt' => $idt,
					'Mesdonnees' => $Mesdonnees,
					'ModifierTarif'=>$ModifierTarif,
					
			) );
						
		
			
	}
	
	public function  AjoutTarif(){
		$idt=$this->request->getParameter("idt");
		$tnom= $this->request->getParameter("tnom");
		$montant= $this->request->getParameter("montant");
		$type= $this->request->getParameter("type");
		$dureevalidite= $this->request->getParameter("validite");
		$model= new GestionTarif();
		if($idt!=''){
		$model->UpdateTarif($idt, $tnom, $montant, $type, $dureevalidite);}
			ELSE{
		$model->setTarif($tnom, $montant, $type, $dureevalidite);}
			$this->redirect("Tarifs", "ListTarif");
	}
	public function DeleteTarif(){
		$idt = '';
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$idt = $this->request->getParameter ( "actionid" );
		}
		
		$model= new GestionTarif();
		$model->deletTarif($idt);
			$this->redirect("Tarifs", "ListTarif");
	}
	
	public function ListTarif(){
		
		$modeltarif = new GestionTarif();
		$liste= $modeltarif->getListTarif();
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar, 
				'liste'=> $liste,	
						
		) );
		
	}
	
	
}