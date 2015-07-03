<?php
require_once 'Framework/Model.php';



class GestionTarif extends Model{
	
	public function setTarif($tnom, $montant, $type, $dureevalidite){
		$this->addTarif($tnom, $montant, $type, $dureevalidite);
	}
	public  function addTarif($tnom, $montant, $type, $dureevalidite)
	{
		$sql= "insert into projet_tarif(tnom, montant, type, dureevalidite)"."values(?,?,?,?);";
		$user = $this->runRequest($sql, array($tnom, $montant, $type, $dureevalidite));		
	
	}
	public function getTarif($idt){
		$sql = "SELECT * FROM projet_tarif where idt=? ";
		$req = $this->runRequest($sql, array($idt));
		return  $req->fetch();
	}
	public function getListTarif(){
		$sql = "select * from projet_tarif;";
		$data = $this->runRequest($sql);
		return $data->fetchAll();
	}
	public function UpdateTarif($idt, $tnom, $montant, $type, $dureevalidite){
		$sql="UPDATE projet_tarif SET tnom=?, montant=?, type=?, dureevalidite=? where idt=?";
		$this->runRequest($sql, array($tnom, $montant, $type, $dureevalidite, $idt));
	}
	public function deletTarif($idt){
		$sql="DELETE FROM projet_tarif WHERE idt = ?";
		$req = $this->runRequest($sql, array($idt));
	}

}