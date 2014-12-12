<?php

require_once 'Framework/Model.php';

/**
 * Class defining the resources category model
 *
 * @author Sylvain Prigent
 */
class SyResourcesCategory extends Model {

	/**
	 * Create the resourcescategory table
	 * 
	 * @return PDOStatement
	 */
	public function createTable(){
			
		$sql = "
		CREATE TABLE IF NOT EXISTS `sy_resourcescategory` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`name` varchar(30) NOT NULL DEFAULT '',
		PRIMARY KEY (`id`)
		);
				
		CREATE TABLE IF NOT EXISTS `sy_j_resource_category` (
		`id_resource` int(11) NOT NULL,
		`id_category` int(11) NOT NULL
		);
		";
		
		$pdo = $this->runRequest($sql);
		return $pdo;
	}
	
	/**
	 * get visas informations
	 * 
	 * @param string $sortentry Entry that is used to sort the sy_resourcescategory
	 * @return multitype: array
	 */
	public function getResourcesCategories($sortentry = 'id'){
		 
		$sql = "select * from sy_resourcescategory order by " . $sortentry . " ASC;";
		$user = $this->runRequest($sql);
		return $user->fetchAll();
	}
	
	/**
	 * get the names of all the resources categories
	 *
	 * @return multitype: array
	 */
	public function ResourcesCategoriesName(){
			
		$sql = "select name from sy_resourcescategory";
		$units = $this->runRequest($sql);
		return $units->fetchAll();
	}
	
	/**
	 * add a resources category to the table
	 *
	 * @param string $name name of the resources category
	 */
	public function addResourcesCategory($name){
		
		$sql = "insert into sy_resourcescategory(name)"
				. " values(?)";
		$user = $this->runRequest($sql, array($name));		
	}
	
	public function isResourcesCategory($name){
		$sql = "select * from sy_resourcescategory where name=?";
		$unit = $this->runRequest($sql, array($name));
		if ($unit->rowCount() == 1)
			return true;
		else
			return false;
	}
	
	public function setResourcesCategory($name){
		if (!$this->isResourcesCategory($name)){
			$this->addResourcesCategory($name);
		}
	}
	
	/**
	 * update the information of a resources category
	 *
	 * @param int $id Id of the unit to update
	 * @param string $name New name of the unit
	 */
	public function editResourcesCategory($id, $name){
		
		$sql = "update sy_resourcescategory set name=? where id=?";
		$unit = $this->runRequest($sql, array("".$name."", $id));
	}
	
	/**
	 * get the informations of a resources category
	 *
	 * @param int $id Id of the resources category to query
	 * @throws Exception id the resources category is not found
	 * @return mixed array
	 */
	public function getResourcesCategory($id){
		$sql = "select * from sy_resourcescategory where id=?";
		$unit = $this->runRequest($sql, array($id));
		if ($unit->rowCount() == 1)
    		return $unit->fetch();  // get the first line of the result
    	else
    		throw new Exception("Cannot find the resources category using the given id"); 
	}
	
	/**
	 * get the name of a resources category
	 *
	 * @param int $id Id of the resources category to query
	 * @throws Exception if the resources category is not found
	 * @return mixed array
	 */
	public function getResourcesCategoryName($id){
		$sql = "select name from sy_resourcescategory where id=?";
		$unit = $this->runRequest($sql, array($id));
		if ($unit->rowCount() == 1)
			return $unit->fetch();  // get the first line of the result
		else
			throw new Exception("Cannot find the resources category using the given id");
	}
	
	/**
	 * get the id of a resources category from it's name
	 * 
	 * @param string $name Name of the resources category
	 * @throws Exception if the resources category connot be found
	 * @return mixed array
	 */
	public function getResourcesCategoryId($name){
		$sql = "select id from sy_resourcescategory where name=?";
		$unit = $this->runRequest($sql, array($name));
		if ($unit->rowCount() == 1)
			return $unit->fetch();  // get the first line of the result
		else
			throw new Exception("Cannot find the resources category using the given name: " . $name);
	}
	
	// joint ressource category
	public function getCategory($id_resource){
		$sql = "select sy_j_resource_category.id_category AS id_category, sy_resourcescategory.name AS name_category
				 from sy_j_resource_category 
					INNER JOIN sy_resourcescategory on sy_j_resource_category.id_category = sy_resourcescategory.id
				where sy_j_resource_category.id_resource=?";
		$user = $this->runRequest($sql, array($id_resource));
		if ($user->rowCount() == 1){
			return $user->fetch();
		}
		else{
			return array('id_category' => 0, 'name_category' => 0);
		}
	}
	
	public function getCategoryID($id_resource){
		$sql = "select id_category from sy_j_resource_category
				where id_resource=?";
		$user = $this->runRequest($sql, array($id_resource));
		if ($user->rowCount() == 1){
			return $user->fetch()[0];
		}
		else{
			return 0;
		}
	}
	
	public function setCategory($id_resource, $id_category){
		if ($this->isJResourceCategory($id_resource)){
			$this->updateJResourceCategory($id_resource, $id_category);
		}
		else{
			$this->addJResourceCategory($id_resource, $id_category);
		}
	}
	
	public function isJResourceCategory($id_resource){
		$sql = "select id_category from sy_j_resource_category
				where id_resource=?";
		$user = $this->runRequest($sql, array($id_resource));
		if ($user->rowCount() == 1){
			return true;
		}
		else{
			return false;
		}
	}
	
	public function addJResourceCategory($id_resource, $id_category){
		$sql = "insert into sy_j_resource_category(id_resource, id_category)"
				. " values(?, ?)";
		$this->runRequest($sql, array($id_resource, $id_category));
	}
	
	public function updateJResourceCategory($id_resource, $id_category){
		$sql = "update sy_j_resource_category set id_category=? where id_resource id=?";
		$unit = $this->runRequest($sql, array($id_category, $id_resource));
	}
	
}