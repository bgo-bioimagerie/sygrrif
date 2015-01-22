<?php

require_once 'Framework/Model.php';

/**
 * Class defining the Sygrrif pricing model
 *
 * @author Sylvain Prigent
 */
class SuItemPricing extends Model {
	
	public function createTable(){
		$sql = "CREATE TABLE IF NOT EXISTS `su_j_item_pricing` (
		`id_item` int(11) NOT NULL,
		`id_pricing` int(11) NOT NULL,
		`price` decimal(10,2) NOT NULL,
		);";
		
		$pdo = $this->runRequest($sql);
		return $pdo;
	}
	
	public function addPricing($id_item, $id_pricing, $price){
			
		$sql = "INSERT INTO su_j_item_pricing (id_item, id_pricing, price)
				 VALUES(?,?,?)";
		$pdo = $this->runRequest ( $sql, array (
				$id_item, $id_pricing, $price
		) );
		return $pdo;
	}
	
	public function editPricing($id_item, $id_pricing, $price){
			
		$sql = "update su_j_item_pricing set price=? 
		        where id_item=? AND id_pricing=?";
		$this->runRequest($sql, array($price, $id_item, $id_pricing,));
	}
	
	public function setPricing($id_item, $id_pricing, $price){
		
		if ($this->isPricing($id_item, $id_pricing)){
			$this->editPricing($id_item, $id_pricing, $price);
		}
		else{
			$this->addPricing($id_item, $id_pricing, $price);
		}
	}
	
	public function isPricing($id_item, $id_pricing, $price){
		$sql = "select * from su_j_item_pricing where id_item=? AND id_pricing=?";
		$user = $this->runRequest($sql, array($id_item, $id_pricing));
		return ($user->rowCount() == 1);
	}
	
	public function getPrice($id_item, $id_pricing){
		$sql = "select price from su_j_item_pricing where id_item=? AND id_pricing=?";
		$user = $this->runRequest($sql, array($id_ressource, $id_pricing));
		if ($user->rowCount() == 1){
			return $user->fetch();
		}
		else{
			return array('price' => 0);
		}
	}
}
?>