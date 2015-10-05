<?php

require_once 'Framework/Model.php';

/**
 * Class defining the consomable pricing model
 *
 * @author Sylvain Prigent
 */
class SpPricing extends Model {
	
	public function createTable(){
		$sql = "CREATE TABLE IF NOT EXISTS `sp_pricing` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`tarif_name` varchar(100) NOT NULL DEFAULT '',				
		PRIMARY KEY (`id`)
		);";
		
		$pdo = $this->runRequest($sql);
		return $pdo;
	}
	

	public function getPrices($sortEntry = 'id'){

		$sql = "select * from sp_pricing order by " . $sortEntry . " ASC;";
		$data = $this->runRequest($sql);
		return $data->fetchAll();
	}
	
	public function pricingsIDName(){
		$sql = "select id, tarif_name from sp_pricing";
		$data = $this->runRequest($sql);
		return $data->fetchAll();
	}
	
	public function getPricing($id){
		
		echo "id = " . $id . "</br>";
		
		$sql = "select * from sp_pricing where id=?;";
		$data = $this->runRequest($sql, array($id));
		if ($data->rowCount() == 1)
			return $data->fetch(); 
		else
			throw new Exception("Cannot find the pricing using the given id = " . $id . "</br>");

	}
	
	public function getPricingId($name){
		$sql = "select * from sp_pricing where tarif_name=?;";
		$data = $this->runRequest($sql, array($name));
		if ($data->rowCount() == 1){
			$tmp = $data->fetch();
			return $tmp[0]; 
		}
		else{
			return 0;
			}
	}
	
	public function addPricing($name){
		$sql = "INSERT INTO sp_pricing (tarif_name) VALUES(?)";
		$pdo = $this->runRequest($sql, array($name));
		return $pdo;
	}
	
	public function editPricing($id, $name){
		$sql = "update sp_pricing set tarif_name= ?
									  where id=?";
		$this->runRequest($sql, array($name, $id));
	}
	
	private function isPricing($name){
		$sql = "select * from sp_pricing where tarif_name=?;";
		$data = $this->runRequest($sql, array($name));
		if ($data->rowCount() == 1)
			return true;
		else
			return false;
	}
	
	public function setPricing($name){
		if (!$this->isPricing($name)){
			$this->addPricing($name);	
		}
	}
	
}