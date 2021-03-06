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
		`tarif_color` varchar(7) NOT NULL DEFAULT '#ffffff',
		`tarif_type` int(7) NOT NULL DEFAULT '1',							
		PRIMARY KEY (`id`)
		);";
		
		$pdo = $this->runRequest($sql);
		
		$sql = "SHOW COLUMNS FROM `sp_pricing` LIKE 'tarif_color'";
		$pdo = $this->runRequest($sql);
		$isColumn = $pdo->fetch();
		if ( $isColumn == false){
			$sql = "ALTER TABLE `sp_pricing` ADD `tarif_color` varchar(7) NOT NULL DEFAULT '#ffffff'";
			$pdo = $this->runRequest($sql);
		}
		
		$sql = "SHOW COLUMNS FROM `sp_pricing` LIKE 'tarif_type'";
		$pdo = $this->runRequest($sql);
		$isColumn = $pdo->fetch();
		if ( $isColumn == false){
			$sql = "ALTER TABLE `sp_pricing` ADD `tarif_type` int(7) NOT NULL DEFAULT '1'"; // 1 accademic, 2 private
			$pdo = $this->runRequest($sql);
		}
		
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
		
		//echo "id = " . $id . "</br>";
		
		$sql = "select * from sp_pricing where id=?;";
		$data = $this->runRequest($sql, array($id));
		if ($data->rowCount() == 1)
			return $data->fetch(); 
		else
			throw new Exception("Cannot find the pricing using the given id = " . $id . "");

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
	
	public function addPricing($name, $color, $type){
		$sql = "INSERT INTO sp_pricing (tarif_name, tarif_color, tarif_type) VALUES(?,?,?)";
		$pdo = $this->runRequest($sql, array($name, $color, $type));
		return $pdo;
	}
	
	public function editPricing($id, $name, $color, $type){
		$sql = "update sp_pricing set tarif_name= ?, tarif_color=?, tarif_type=?
									  where id=?";
		$this->runRequest($sql, array($name, $color, $type, $id));
	}
	
	private function isPricing($name){
		$sql = "select * from sp_pricing where tarif_name=?;";
		$data = $this->runRequest($sql, array($name));
		if ($data->rowCount() == 1)
			return true;
		else
			return false;
	}
	
	public function setPricing($name, $color, $type){
		if (!$this->isPricing($name, $color, $type)){
			$this->addPricing($name, $color, $type);	
		}
	}
	
	public function delete($id){
		$sql = "DELETE FROM sp_pricing WHERE `id`=?";
		$req = $this->runRequest ( $sql, array (
				$id
		) );
	}
}