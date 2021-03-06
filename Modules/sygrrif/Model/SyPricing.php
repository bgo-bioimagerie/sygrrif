<?php

require_once 'Framework/Model.php';

/**
 * Class defining the Sygrrif pricing model
 *
 * @author Sylvain Prigent
 */
class SyPricing extends Model {
	
	public function createTable(){
		$sql = "CREATE TABLE IF NOT EXISTS `sy_pricing` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`tarif_unique` int(11) NOT NULL DEFAULT 1,
		`tarif_night` int(3) NOT NULL DEFAULT 0,
		`night_start` int(11) NOT NULL DEFAULT 19,
		`night_end` int(11) NOT NULL DEFAULT 8,
		`tarif_we` int(3) NOT NULL DEFAULT 0,
		`choice_we`  varchar(100) NOT NULL DEFAULT '',				
		PRIMARY KEY (`id`)
		);";
		
		$pdo = $this->runRequest($sql);
		return $pdo;
	}
	
	/**
	 * Get all the prices info
	 * @param string $sortEntry
	 * @return multitype:
	 */
	public function getPrices($sortEntry = 'id'){

		$sql = "select * from sy_pricing order by " . $sortEntry . " ASC;";
		$data = $this->runRequest($sql);
		return $data->fetchAll();
	}
	
	/**
	 * Get pricings IDs and names
	 * @return multitype:
	 */
	/*
	public function pricingsIDName(){
		$sql = "select id, tarif_name from sy_pricing";
		$data = $this->runRequest($sql);
		return $data->fetchAll();
	}
	*/
	
	/**
	 * get pricing ID from ID
	 * @param unknown $id
	 * @throws Exception
	 * @return mixed
	 */
	public function getPricing($id){
		$sql = "select * from sy_pricing where id=?;";
		$data = $this->runRequest($sql, array($id));
		if ($data->rowCount() == 1){
			return $data->fetch();  // get the first line of the result
                }
		else{
			throw new Exception("Cannot find the pricing using the given id:".$id);
                }
	}
	
	/**
	 * get the pricing ID from name
	 * @param unknown $name
	 * @return mixed|number
	 */
	/*
	public function getPricingId($name){
		$sql = "select * from sy_pricing where tarif_name=?;";
		$data = $this->runRequest($sql, array($name));
		if ($data->rowCount() == 1){
			$tmp = $data->fetch();
			return $tmp[0];  // get the first line of the result
		}
		else{
			return 0;
			}
	}
	*/
	
	/**
	 * add a unique pricing
	 * @param unknown $name
	 * @return PDOStatement
	 */
	public function addUnique($id){
		$sql = "INSERT INTO sy_pricing (id) VALUES(?)";
		$pdo = $this->runRequest($sql, array($id));
		return $pdo;
	}
	
	/**
	 * add a pricing
	 * @param unknown $id
	 * @param unknown $tarif_unique
	 * @param unknown $tarif_nuit
	 * @param unknown $night_start
	 * @param unknown $night_end
	 * @param unknown $tarif_we
	 * @param unknown $we_char
	 * @return PDOStatement
	 */
	public function addPricing($id, $tarif_unique, $tarif_nuit, $night_start, $night_end, $tarif_we, $we_char){
		$sql = "INSERT INTO sy_pricing (id, tarif_unique, tarif_night, night_start,
				                        night_end, tarif_we, choice_we ) VALUES(?,?,?,?,?,?,?)";
		$pdo = $this->runRequest($sql, array($id, $tarif_unique, $tarif_nuit, $night_start, $night_end, $tarif_we, $we_char));
		return $pdo;
	}
	
	/**
	 * Update a pricing infos
	 * @param unknown $id
	 * @param unknown $tarif_unique
	 * @param unknown $tarif_nuit
	 * @param unknown $night_start
	 * @param unknown $night_end
	 * @param unknown $tarif_we
	 * @param unknown $we_char
	 */
	public function editPricing($id, $tarif_unique, $tarif_nuit, $night_start, $night_end, $tarif_we, $we_char){
		$sql = "update sy_pricing set tarif_unique=?, tarif_night=?, night_start=?,
				                      night_end=?, tarif_we=?, choice_we=?
									  where id=?";
		$this->runRequest($sql, array($tarif_unique, $tarif_nuit, $night_start, $night_end, $tarif_we, $we_char, $id));
	} 
	
	/**
	 * Check if a pricing exists
	 * @param unknown $name
	 * @return boolean
	 */
	private function isPricing($id){
		$sql = "select * from sy_pricing where id=?;";
		$data = $this->runRequest($sql, array($id));
		if ($data->rowCount() == 1)
			return true;
		else
			return false;
	}
	
	/**
	 * Add pricing if pricing name does not exists
	 * @param unknown $nom
	 * @param unknown $tarif_unique
	 * @param unknown $tarif_nuit
	 * @param unknown $night_start
	 * @param unknown $night_end
	 * @param unknown $tarif_we
	 * @param unknown $we_char
	 */
	public function setPricing($id, $tarif_unique, $tarif_nuit, $night_start, $night_end, $tarif_we, $we_char){
		if (!$this->isPricing($id)){
			$this->addPricing($id, $tarif_unique, $tarif_nuit, $night_start, $night_end, $tarif_we, $we_char);	
		}
	}
	
	/**
	 * Delete a unit
	 * @param number $id Unit ID
	 */
	public function delete($id){
		$sql="DELETE FROM sy_pricing WHERE id = ?";
		$req = $this->runRequest($sql, array($id));
	}
	
}