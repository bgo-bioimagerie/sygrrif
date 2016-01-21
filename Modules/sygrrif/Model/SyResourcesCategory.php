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
		`name` varchar(200) NOT NULL DEFAULT '',
		PRIMARY KEY (`id`)
		);
		";
		
		$pdo = $this->runRequest($sql);
		return $pdo;
	}
	
	/**
	 * Get the categories informations
	 * @param string $sortentry
	 * @return multitype:
	 */
	public function getResourcesCategories($sortentry = 'id'){
		 
		$sql = "select * from sy_resourcescategory order by " . $sortentry . " ASC;";
		$user = $this->runRequest($sql);
		return $user->fetchAll();
	}
	
	public function categoriesNumber($sortentry = 'id'){
			
		$sql = "select * from sy_resourcescategory";
		$user = $this->runRequest($sql);
		return $user->rowCount();
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
		return $this->getDatabase()->lastInsertId();	
	}
	
	/**
	 * import resources categories (used to import a GRR database)
	 * @param unknown $id
	 * @param unknown $name
	 * @return string
	 */
	public function importResourcesCategory($id, $name){
		$sql = "insert into sy_resourcescategory(id, name)"
				. " values(?,?)";
		$user = $this->runRequest($sql, array($id, $name));	
		return $this->getDatabase()->lastInsertId();
	}
	
	/**
	 * CHeck if a resource exists
	 * @param unknown $name
	 * @return boolean
	 */
	public function isResourcesCategory($name){
		$sql = "select * from sy_resourcescategory where name=?";
		$unit = $this->runRequest($sql, array($name));
		if ($unit->rowCount() == 1)
			return true;
		else
			return false;
	}
	
	/**
	 * Add a resource if not exists
	 * @param unknown $name
	 */
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
		if ($unit->rowCount() == 1){
			$tmp = $unit->fetch();
			return $tmp[0];  // get the first line of the result
		}
		else
			return "";
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
	/**
	 * get catefory info for a given resource
	 * @param unknown $id_resource
	 * @return mixed|multitype:number
	 */
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
	
	/**
	 * Get the category ID for a given resource
	 * @param unknown $id_resource
	 * @return mixed|number
	 */
	public function getCategoryID($id_resource){
		$sql = "select id_category from sy_j_resource_category
				where id_resource=?";
		$user = $this->runRequest($sql, array($id_resource));
		if ($user->rowCount() == 1){
			$tmp = $user->fetch();
			return $tmp[0];
		}
		else{
			return 0;
		}
	}
	
	/**
	 * Set the category of a resource
	 * @param unknown $id_resource
	 * @param unknown $id_category
	 */
	public function setCategory($id_resource, $id_category){
		if ($this->isJResourceCategory($id_resource)){
			$this->updateJResourceCategory($id_resource, $id_category);
		}
		else{
			$this->addJResourceCategory($id_resource, $id_category);
		}
	}
	
	/**
	 * Check if the resource is linked to a category
	 * @param unknown $id_resource
	 * @return boolean
	 */
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
	
	/**
	 * Joint a resource to a category
	 * @param unknown $id_resource
	 * @param unknown $id_category
	 */
	public function addJResourceCategory($id_resource, $id_category){
		$sql = "insert into sy_j_resource_category(id_resource, id_category)"
				. " values(?, ?)";
		$this->runRequest($sql, array($id_resource, $id_category));
	}
	
	/**
	 * Update the link between a resource and a category
	 * @param unknown $id_resource
	 * @param unknown $id_category
	 */
	public function updateJResourceCategory($id_resource, $id_category){
		$sql = "update sy_j_resource_category set id_category=? where id_resource=?";
		$unit = $this->runRequest($sql, array($id_category, $id_resource));
	}
	
	/**
	 * Remove a catrgory
	 * @param unknown $id
	 */
	public function delete($id){
		$sql="DELETE FROM sy_resourcescategory WHERE id = ?";
		$req = $this->runRequest($sql, array($id));
	}
}