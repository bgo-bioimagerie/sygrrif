<?php

require_once 'Framework/Model.php';
require_once 'Modules/sygrrif/Model/SyTranslator.php';

function cmpvisas($a, $b)
{
	return strcmp($a["desc"], $b["desc"]);
}

/**
 * Class defining the Visa model
 *
 * @author Sylvain Prigent
 */
class SyVisa extends Model {

	/**
	 * Create the table
	 * 
	 * @return PDOStatement
	 */
	public function createTable(){
			
		$sql = "CREATE TABLE IF NOT EXISTS `sy_visas` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`id_resource_category` int(11) NOT NULL,
		`id_instructor` int(11) NOT NULL,
		`instructor_status` int(11) NOT NULL,
		PRIMARY KEY (`id`)
		);";
		
		$pdo = $this->runRequest($sql);
		return $pdo;
	}
	
	/**
	 * Create the default empty Visa
	 * 
	 * @return PDOStatement
	 */
	public function createDefaultVisa(){
		$sql = "insert into sy_visas(id_resource_category, id_instructor, instructor_status)"
				. " values(?,?,?)";
		$this->runRequest($sql, array(0, 1, 1));
	}
	
	/**
	 * get visas informations
	 * 
	 * @param string $sortentry Entry that is used to sort the visas
	 * @return multitype: array
	 */
	public function getVisas($sortentry = 'id'){
		 
		$sql = "select * from sy_visas order by " . $sortentry . " ASC;";
		$user = $this->runRequest($sql);
		return $user->fetchAll();
	}
	
	/**
	 * add a visa to the table
	 *
	 * @param string $name name of the visa
	 */
	public function addVisa($id_resource_category, $id_instructor, $instructor_status){
		
		$sql = "insert into sy_visas(id_resource_category, id_instructor, instructor_status)"
				. " values(?,?,?)";
		$user = $this->runRequest($sql, array($id_resource_category, $id_instructor, $instructor_status));		
	}
	
	
	/**
	 * update the information of a visa
	 *
	 * @param int $id Id of the unit to update
	 * @param string $name New name of the unit
	 */
	public function editVisa($id, $id_resource_category, $id_instructor, $instructor_status){
		
		$sql = "update sy_visas set id_resource_category=?, id_instructor=?, instructor_status=? where id=?";
		$unit = $this->runRequest($sql, array($id_resource_category, $id_instructor, $instructor_status, $id));
	}
	
	/**
	 * get the informations of a visa
	 *
	 * @param int $id Id of the unit to query
	 * @throws Exception id the unit is not found
	 * @return mixed array
	 */
	public function getVisa($id){
		$sql = "select * from sy_visas where id=?";
		$unit = $this->runRequest($sql, array($id));
		if ($unit->rowCount() == 1)
    		return $unit->fetch();  // get the first line of the result
    	else
    		throw new Exception("Cannot find the visa using the given id"); 
	}
	
	public function getVisaShortDescription($id, $lang){
		$sql = "select * from sy_visas where id=?";
		$req = $this->runRequest($sql, array($id));
		if ($req->rowCount() == 1){
			$visaInfo = $req->fetch();  // get the first line of the result
			
			$modelUser = new CoreUser();
			$instructor = $modelUser->getUserInitiales($visaInfo["id_instructor"]);
		
			return $instructor;
		}
		else
			return "";
	}
	
	public function getVisaDescription($id, $lang){
		$sql = "select * from sy_visas where id=?";
		$req = $this->runRequest($sql, array($id));
		if ($req->rowCount() == 1){
			$visaInfo = $req->fetch();  // get the first line of the result
			
			return $this->getVisaDesc($visaInfo, $lang);
		}
		else
			return "";
	}
	
	private function getVisaDesc($visaInfo, $lang){
		$modelUser = new CoreUser();
		$instructor = $modelUser->getUserFUllName($visaInfo["id_instructor"]);
		
		$modelResourceCat = new SyResourcesCategory();
		$resourceName = $modelResourceCat->getResourcesCategoryName($visaInfo["id_resource_category"]);
		
		$instructorStatus = SyTranslator::Instructor($lang);
		if ($visaInfo["instructor_status"] == 2){
			$instructorStatus = SyTranslator::Responsible($lang);
		}
		
		return $instructor . " - " . $instructorStatus . " - " . $resourceName;
	}
	
	public function getVisasDesc($id_resource, $lang){
		$sql = "select * from sy_visas where id_resource_category=?";
		$req = $this->runRequest($sql, array($id_resource));
		$visasInfo = $req->fetchAll();  // get the first line of the result

		$visas = array();
		foreach($visasInfo as $visaInfo){
			$v["id"] = $visaInfo["id"];
			$v["desc"] = $this->getVisaDesc($visaInfo, $lang); 
			$visas[] = $v;
		}
		
		usort($visas, "cmpvisas");

		return $visas;
	}
	
	public function getAllVisasDesc($lang){
		$sql = "select * from sy_visas";
		$req = $this->runRequest($sql);
		$visasInfo = $req->fetchAll();  // get the first line of the result
		
		$visas = array();
		foreach($visasInfo as $visaInfo){
			$v["id"] = $visaInfo["id"];
			$v["desc"] = $this->getVisaDesc($visaInfo, $lang);
			$visas[] = $v;
		}
		
		usort($visas, "cmpvisas");
		
		return $visas;
	}
	/**
	 * Remove a visa
	 * @param number $id
	 */
	public function delete($id){
		$sql="DELETE FROM sy_visas WHERE id = ?";
		$req = $this->runRequest($sql, array($id));
	}
}