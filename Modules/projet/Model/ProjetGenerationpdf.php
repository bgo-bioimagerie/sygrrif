<?php

require_once 'Framework/Model.php';



class ProjetGenerationpdf extends Model{
//function permettant de prendre toute les informations de la base de donn�es appropri�es au idform pass� en paramettre 
	public function showdonnee($numerofiche){
		$sql = "select * from neurinfo where numerofiche=?;";
		$data = $this->runRequest($sql, array($numerofiche));
		if ($data->rowCount () == 1)
		{
			return  $data->fetch(PDO::FETCH_ASSOC);
			}
		else{
			return "not found";
		}
	}
	
}