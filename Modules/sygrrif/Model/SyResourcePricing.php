<?php

require_once 'Framework/Model.php';

/**
 * Class defining the Sygrrif pricing model
 *
 * @author Sylvain Prigent
 */
class SyResourcePricing extends Model {
	
	public function createTable(){
		$sql = "CREATE TABLE IF NOT EXISTS `sy_j_resource_pricing` (
		`id_resource` int(11) NOT NULL,
		`id_pricing` int(11) NOT NULL,
		`price_day` decimal(10,2) NOT NULL,
		`price_night` decimal(10,2) NOT NULL,
		`price_we` decimal(10,2) NOT NULL	
		);";
		
		$pdo = $this->runRequest($sql);
		return $pdo;
	}
	
	public function addPricing($id_ressource, $id_pricing, $price_day, $price_night, $price_we){
			
		$sql = "INSERT INTO sy_j_resource_pricing (id_resource, id_pricing, price_day, price_night, price_we)
				 VALUES(?,?,?,?,?)";
		$pdo = $this->runRequest ( $sql, array (
				$id_ressource, $id_pricing, $price_day, $price_night, $price_we
		) );
		return $pdo;
	}
	
	public function editPricing($id_ressource, $id_pricing, $price_day, $price_night, $price_we){
			
		$sql = "update sy_j_resource_pricing set price_day=?, price_night=?, price_we=? 
		        where id_resource=? AND id_pricing=?";
		$this->runRequest($sql, array($price_day, $price_night, $price_we, $id_ressource, $id_pricing));
	}
	
	public function setPricing($id_ressource, $id_pricing, $price_day, $price_night, $price_we){
		
		if ($this->isPricing($id_ressource, $id_pricing)){
			$this->editPricing($id_ressource, $id_pricing, $price_day, $price_night, $price_we);
		}
		else{
			$this->addPricing($id_ressource, $id_pricing, $price_day, $price_night, $price_we);
		}
	}
	
	public function isPricing($id_ressource, $id_pricing){
		$sql = "select * from sy_j_resource_pricing where id_resource=? AND id_pricing=?";
		$user = $this->runRequest($sql, array($id_ressource, $id_pricing));
		return ($user->rowCount() == 1);
	}
	
	public function getPrice($id_ressource, $id_pricing){
		$sql = "select price_day, price_night, price_we from sy_j_resource_pricing where id_resource=? AND id_pricing=?";
		$user = $this->runRequest($sql, array($id_ressource, $id_pricing));
		if ($user->rowCount() == 1){
			return $user->fetch();
		}
		else{
			return array('price_day' => 0, 'price_night' => 0, 'price_we' => 0);
		}
	}
}
?>