<?php
require_once 'Framework/Model.php';

/**
 * Class defining the area model
 *
 * @author Sylvain Prigent
 */
class SyPackage extends Model {
	
	/**
	 * Create the area table
	 *
	 * @return PDOStatement
	 */
	public function createTable() {
		$sql = "CREATE TABLE IF NOT EXISTS `sy_packages` (
		`id` int(11) NOT NULL AUTO_INCREMENT,	
		`id_resource` int(11) NOT NULL,
		`duration` decimal(10,2) NOT NULL,
		`name` varchar(100) NOT NULL,			
		PRIMARY KEY (`id`)
		);";
		$pdo = $this->runRequest ( $sql );
		
		$sql = "CREATE TABLE IF NOT EXISTS `sy_j_packages_prices` (
		`id_package` int(11) NOT NULL,
		`id_pricing` int(11) NOT NULL,
		`price` decimal(10,2) NOT NULL
		);";
		$pdo = $this->runRequest ( $sql );
	}
	
	public function getPrices($resourceID) {
		$sql = "SELECT id, name, duration FROM sy_packages WHERE id_resource=?";
		$data = $this->runRequest ( $sql, array (
				$resourceID 
		) );
		
		if($data->rowCount() < 1){
			return array();
		}
		
		$packages = $data->fetchAll ();
		//print_r($packages);
		
		for($p = 0 ; $p < count($packages) ; $p++){
			
			$sql = "select * from sy_j_packages_prices where id_package=?";
			$data = $this->runRequest ( $sql, array( $packages[$p]["id"]) );
			$prices = $data->fetchAll ();
			foreach ( $prices as $price ) {
				$packages[$p]["price_" . $price["id_pricing"]] = $price["price"];
			}
		}
		
		//print_r($packages);
		return $packages;
	}
	public function getPackageDuration($id){
		$sql = "select duration from sy_packages where id=?";
		$req = $this->runRequest ( $sql, array( $id) );
		$duration = $req->fetch();
		return $duration[0];
	}

	public function setPackage($id, $id_resource, $name, $duration){
		
		if ($this->isPackage($id)){
			$this->updatePackage($id, $id_resource, $duration, $name);
			return $id;
		}
		else{
			return $this->addPackage($id_resource, $duration, $name);
		}
	}
	
	public function addPackage($id_resource, $duration, $name){
		$sql = "insert into sy_packages(id_resource, duration, name)"
				. " values(?, ?, ?)";
		$this->runRequest($sql, array($id_resource, $duration, $name));
		return $this->getDatabase()->lastInsertId();
	}
	
	public function updatePackage($id, $id_resource, $duration, $name){
		
		$sql = "update sy_packages set id_resource=?, duration=?, name=? where id=?";
		$this->runRequest($sql, array($id_resource, $duration, $name, $id));
		
	}
	
	public function isPackage($id){
		$sql = "select * from sy_packages where id=?";
		$req = $this->runRequest($sql, array($id));
		if ($req->rowCount() == 1)
			return true;
		else
			return false;
	}

	public function setPrice($id_package, $id_pricing, $price){
		if ($this->isPackagePrice($id_package, $id_pricing)){
			$this->updatePackagePrice($id_package, $id_pricing, $price);
		}
		else{
			$this->addPackagePrice($id_package, $id_pricing, $price);
		}
	}
	
	public function isPackagePrice($id_package, $id_pricing){
		$sql = "select * from sy_j_packages_prices where id_package=? AND id_pricing=?";
		$req = $this->runRequest($sql, array($id_package, $id_pricing));
		if ($req->rowCount() == 1)
			return true;
		else
			return false;
	}
	
	public function updatePackagePrice($id_package, $id_pricing, $price){
		$sql = "update sy_j_packages_prices set price=? where id_package=? AND id_pricing=?";
		$this->runRequest($sql, array($price, $id_package, $id_pricing));
	}
	
	public function addPackagePrice($id_package, $id_pricing, $price){
		$sql = "insert into sy_j_packages_prices(id_package, id_pricing, price)"
				. " values(?, ?, ?)";
		$this->runRequest($sql, array($id_package, $id_pricing, $price));
	}
}