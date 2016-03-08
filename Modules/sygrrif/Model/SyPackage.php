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
                `id_package` int(11) NOT NULL,
		`id_resource` int(11) NOT NULL,
		`duration` decimal(10,2) NOT NULL,
		`name` varchar(100) NOT NULL,			
		PRIMARY KEY (`id`)
		);";
		$this->runRequest ( $sql );
                
                $this->addColumn("sy_packages", "id_package",  "int(11)", 0);
		
		$sql2 = "CREATE TABLE IF NOT EXISTS `sy_j_packages_prices` (
		`id_package` int(11) NOT NULL,
		`id_pricing` int(11) NOT NULL,
		`price` decimal(10,2) NOT NULL
		);";
		$this->runRequest ( $sql2 );
	}
	
	public function getPrices($resourceID) {
		$sql = "SELECT id, id_package, name, duration FROM sy_packages WHERE id_resource=? ORDER BY id_package ASC;";
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

	public function setPackage($id_package, $id_resource, $name, $duration){
		
            $id = $this->getPackageID($id_package, $id_resource);
            if ($id > 0){
                $this->updatePackage($id, $id_package, $id_resource, $duration, $name);
                return $id;
            }
            else{
                return $this->addPackage($id_package, $id_resource, $duration, $name);
            }
	}
        
        public function getPackageID($id_package, $id_resource){
                $sql = "select id from sy_packages where id_package=? and id_resource=?";
		$req = $this->runRequest($sql, array($id_package, $id_resource));
		if ($req->rowCount() == 1){
                        $tmp = $req->fetch();
			return $tmp[0];
                }
		else{
			return 0;
                }
        }
	
	public function addPackage($id_package, $id_resource, $duration, $name){
            
            $sql = "insert into sy_packages(id_package, id_resource, duration, name)"
				. " values(?, ?, ?, ?)";
            $this->runRequest($sql, array($id_package, $id_resource, (float)($duration), $name));
            return $this->getDatabase()->lastInsertId();
                
	}
	
	public function updatePackage($id, $id_package, $id_resource, $duration, $name){
	    
            $sql = "update sy_packages set id_package=?, id_resource=?, duration=?, name=? where id=?";
            $this->runRequest($sql, array($id_package, $id_resource, $duration, $name, $id));
		
	}
	
	public function isPackage($id){
		$sql = "select * from sy_packages where id=?";
		$req = $this->runRequest($sql, array($id));
		if ($req->rowCount() == 1){
			return true;
                }
		else{
			return false;
                }
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
		if ($req->rowCount() == 1){
			return true;
                }
		else{
			return false;
                }
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
        
        public function removeUnlistedPackages($packageID, $id_resource){
            
            /*
            echo "packages ids in the request :" . "<br/>";
            foreach($packageID as $pid){
                echo "- " . $pid . "<br/>";
            }
             */
            
            $sql = "select id, id_package from sy_packages where id_resource=?";
            $req = $this->runRequest($sql, array($id_resource));
            $databasePackages = $req->fetchAll();
            
            /*
            echo "packages ids in the database :" . "<br/>";
            foreach($databasePackages as $dbPackage){
                echo "- " . $dbPackage["id_package"] . "<br/>";
            }
             */
            
            
            foreach($databasePackages as $dbPackage){
                $found = false;
                foreach($packageID as $pid){
                    if ($dbPackage["id_package"] == $pid){
                        //echo "found package " . $pid . "in the database <br/>";
                        $found = true;
                        break;
                    }
                }
                if (!$found){
                    //echo "delete pacjkage id = " . $dbPackage["id"] . " package-id = " . $dbPackage["id_package"] . "<br/>"; 
                    $this->deletePackage($dbPackage["id"]);
                }
            }
            
        }
        
        public function deletePackage($id){
            $sql="DELETE FROM sy_packages WHERE id = ?";
            $this->runRequest($sql, array($id));
            
            $sql2="DELETE FROM sy_j_packages_prices WHERE id_package = ?";
            $this->runRequest($sql2, array($id));
        }
        
}