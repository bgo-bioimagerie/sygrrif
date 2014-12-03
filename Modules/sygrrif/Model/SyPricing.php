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
		`tarif_name` varchar(100) NOT NULL DEFAULT '',
		`tarif_print` varchar(100) NOT NULL DEFAULT '',
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
	

	public function getPrices($sortEntry = 'id'){

		$sql = "select * from sy_pricing order by " . $sortEntry . " ASC;";
		$data = $this->runRequest($sql);
		return $data->fetchAll();
	}
	
	public function pricingsIDName(){
		$sql = "select id, tarif_name from sy_pricing";
		$data = $this->runRequest($sql);
		return $data->fetchAll();
	}
	
	public function getPricing($id){
		$sql = "select * from sy_pricing where id=?;";
		$data = $this->runRequest($sql, array($id));
		if ($data->rowCount() == 1)
			return $data->fetch();  // get the first line of the result
		else
			throw new Exception("Cannot find the pricing using the given id");

	}
	
	public function addUnique($name){
		$sql = "INSERT INTO sy_pricing (tarif_name, tarif_print) VALUES(?,?)";
		$pdo = $this->runRequest($sql, array($name, $name));
		return $pdo;
	}
	
	public function addPricing($nom, $tarif_unique, $tarif_nuit, $night_start, $night_end, $tarif_we, $we_char){
		$sql = "INSERT INTO sy_pricing (tarif_name, tarif_print, tarif_unique, tarif_night, night_start,
				                        night_end, tarif_we, choice_we ) VALUES(?,?,?,?,?,?,?,?)";
		$pdo = $this->runRequest($sql, array($nom, $nom, $tarif_unique, $tarif_nuit, $night_start, $night_end, $tarif_we, $we_char));
		return $pdo;
	}
	
	public function editPricing($id, $nom, $tarif_unique, $tarif_nuit, $night_start, $night_end, $tarif_we, $we_char){
		$sql = "update sy_pricing set tarif_name= ?, tarif_print=?, tarif_unique=?, tarif_night=?, night_start=?,
				                      night_end=?, tarif_we=?, choice_we=?
									  where id=?";
		$this->runRequest($sql, array($nom, $nom, $tarif_unique, $tarif_nuit, $night_start, $night_end, $tarif_we, $we_char, $id));
	}
	
}