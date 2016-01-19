<?php

require_once 'Framework/Model.php';

/**
 * Class defining the Sygrrif resource model
 *
 * @author Sylvain Prigent
 */

class SyResource extends Model {

	/**
	 * Create the resource table
	 *
	 * @return PDOStatement
	 */
	public function createTable(){
			
		$sql = "CREATE TABLE IF NOT EXISTS `sy_resources` (
		`id` int(11) NOT NULL AUTO_INCREMENT,	
		`name` varchar(200) NOT NULL DEFAULT '',
		`description` varchar(300) NOT NULL DEFAULT '',		
		`accessibility_id` int(11) NOT NULL, 
		`type_id` int(11) NOT NULL,
		`category_id` int(11) NOT NULL,		
		`area_id` int(11) NOT NULL,	
		`display_order` int(11) NOT NULL,					
		PRIMARY KEY (`id`)
		);";

		$pdo = $this->runRequest($sql);
		return $pdo;
	}
	
	/**
	 * Add a ne resource
	 * @param unknown $name
	 * @param unknown $description
	 * @param unknown $accessibility_id
	 * @param unknown $type_id
	 * @param unknown $area_id
	 * @param number $category_id
	 * @param number $display_order
	 * @return string
	 */
	public function addResource($name, $description, $accessibility_id, $type_id, $area_id, $category_id = 0, $display_order = 0){
		$sql = "INSERT INTO sy_resources (name, description, accessibility_id, type_id, area_id, category_id, display_order) VALUES(?, ?, ?, ?, ?,?,?)";
		$this->runRequest($sql, array($name, $description, $accessibility_id, $type_id, $area_id, $category_id, $display_order));
		return $this->getDatabase()->lastInsertId();
	}
	
	/**
	 * import resource (used for grr database import)
	 * @param unknown $id
	 * @param unknown $name
	 * @param unknown $description
	 * @param unknown $accessibility_id
	 * @param unknown $type_id
	 * @param unknown $area_id
	 * @param number $category_id
	 * @param number $display_order
	 * @return string
	 */
	public function importResource($id, $name, $description, $accessibility_id, $type_id, $area_id, $category_id = 0, $display_order = 0){
		
		if( $this->isResource($id)){
			$this->editResource($id, $name, $description, $accessibility_id, $type_id, $area_id, $category_id, $display_order);
		}
		else{
			$sql = "INSERT INTO sy_resources (id, name, description, accessibility_id, type_id, area_id, category_id, display_order) VALUES(?, ?, ?, ?, ?, ?, ?, ?)";
			$this->runRequest($sql, array($id, $name, $description, $accessibility_id, $type_id, $area_id, $category_id, $display_order));
			return $this->getDatabase()->lastInsertId();
		}
	}
	
	/**
	 * Check if a resource exists
	 * @param number $id
	 * @return boolean
	 */
	public function isResource($id){
		$sql = "select * from sy_resources where id=?";
		$unit = $this->runRequest($sql, array($id));
		if ($unit->rowCount() == 1)
			return true;  // get the first line of the result
		else
			return false;
	}
	
	/**
	 * Get an area ID for a given resource
	 * @param name $id resource ID
	 * @return mixed|boolean
	 */
	public function getAreaID($id){
		$sql = "select area_id from sy_resources where id=?";
		$req = $this->runRequest($sql, array($id));
		if ($req->rowCount() == 1){
			$tmp = $req->fetch();
			return $tmp[0];
		}
		else{
			return false;
		}
	}

	/**
	 * Update a resource info
	 * @param unknown $id
	 * @param unknown $name
	 * @param unknown $description
	 * @param unknown $accessibility_id
	 * @param unknown $type_id
	 * @param unknown $area_id
	 * @param unknown $category_id
	 * @param unknown $display_order
	 */
	public function editResource($id, $name, $description, $accessibility_id, $type_id, $area_id, $category_id, $display_order){
		$sql = "update sy_resources set name=?, description=?, accessibility_id=?, type_id=?, area_id=?,
				category_id=?, display_order=?  where id=?";
		$this->runRequest($sql, array($name, $description, $accessibility_id, $type_id, $area_id, $category_id, $display_order, $id));
	}
	
	/**
	 * Get the resources table infos
	 * @param unknown $sortEntry
	 * @return multitype:
	 */
	public function resources($sortEntry){
			
		$sql = "select * from sy_resources order by " . $sortEntry . " ASC;";
		$data = $this->runRequest($sql);
		return $data->fetchAll();
		
	}
	
	public function resourcesNumber(){
		$sql = "select * from sy_resources";
		$data = $this->runRequest($sql);
		return $data->rowCount();
	}
	
	/**
	 * Get the resources info with join on IDs
	 * @param string $sortentry
	 * @return multitype:
	 */
	public function resourcesInfo($sortentry = "id"){
		
		$sqlSort = "sy_resources.id";
		if ($sortentry == "name"){
			$sqlSort = "sy_resources.name";
		}
		else if ($sortentry == "description"){
			$sqlSort = "sy_resources.description";
		}
		else if ($sortentry == "type_name"){
			$sqlSort = "sy_resource_type.name";
		}
		else if ($sortentry == "category_name"){
			$sqlSort = "sy_resourcescategory.name";
		}
		else if ($sortentry == "area_name"){
			$sqlSort = "sy_areas.name";
		}
		else if ($sortentry == "display_order"){
			$sqlSort = "sy_resources.display_order";
		}
		
		$sql = "SELECT sy_resources.id AS id, sy_resources.name AS name, sy_resources.description AS description, 
				       sy_resources.display_order AS display_order, sy_resources.accessibility_id AS accessibility_id,
				       sy_resource_type.name AS type_name, sy_resourcescategory.name AS category_name, sy_areas.name AS area_name, 
				       sy_resource_type.controller AS controller, sy_resource_type.edit_action AS edit_action	
					from sy_resources
					     INNER JOIN sy_resource_type on sy_resources.type_id = sy_resource_type.id
					     INNER JOIN sy_resourcescategory on sy_resources.category_id = sy_resourcescategory.id
						 INNER JOIN sy_areas on sy_resources.area_id = sy_areas.id
					ORDER BY ". $sqlSort . ";";
		$req = $this->runRequest ( $sql );
		return $req->fetchAll ();
	}
	
	/**
	 * Get a resource info from ID
	 * @param unknown $id
	 * @return mixed|number
	 */
	public function resource($id){
		$sql = "select * from sy_resources where id=?";
		$req = $this->runRequest($sql, array($id));
		if ($req->rowCount() == 1)
			return $req->fetch();
		else
			return 0;
	}
	
	public function resourcesNumber(){
		$sql = "select * from sy_resources";
		$data = $this->runRequest($sql);
		return $data->rowCount();
	}
	
	/**
	 * Get the resources IDs and names for a given Area
	 * @param unknown $areaId
	 * @return multitype:
	 */
	public function resourceIDNameForArea($areaId){
		$sql = "select id, name from sy_resources where area_id=? ORDER BY display_order";
		$data = $this->runRequest($sql, array($areaId));
		return $data->fetchAll();
	}
	
	/**
	 * Get the resources info for a given area
	 * @param unknown $areaId
	 * @return multitype:
	 */
	public function resourcesForArea($areaId){
		$sql = "select * from sy_resources where area_id=? ORDER BY display_order";
		$data = $this->runRequest($sql, array($areaId));
		return $data->fetchAll();
	}
	
	/**
	 * Get the first resource ID for a given area
	 * @param unknown $areaId
	 * @return mixed
	 */
	public function firstResourceIDForArea($areaId){
		$sql = "select id from sy_resources where area_id=?";
		$req = $this->runRequest($sql, array($areaId));
		$tmp = $req->fetch();
		return $tmp[0];
	}
	
	/**
	 * get the type of a given resource
	 * @param number $id
	 * @return number
	 */
	public function getResourceType($id){
		$sql = "select type_id from sy_resources where id=?";
		$req = $this->runRequest($sql, array($id));
		if ($req->rowCount() == 1){
			$tmp = $req->fetch();
			return $tmp[0];
		}
		else{
			return 0;
		}
	}
	
	/**
	 * Update the category of a resource
	 * @param number $id_resource
	 * @param number $id_category
	 */
	public function setResourceCategory($id_resource, $id_category){
		$sql = "update sy_resources set category_id=? where id=?";
		$this->runRequest($sql, array($id_category, $id_resource));
	}
	
	/**
	 * Remove a resource
	 * @param number $id_resource
	 */
	public function delete($id_resource){
		$sql="DELETE FROM sy_resources WHERE id = ?";
		$req = $this->runRequest($sql, array($id_resource));
	}
	
	/**
	 * get resource info from it name
	 * @param unknown $name
	 * @return mixed
	 */
	public function getResourceFromName($name){
		$sql = "select * from sy_resources where name=?";
		$data = $this->runRequest($sql, array($name));
		return $data->fetch();
	}
	
	/**
	 * get the resources IDs for a given category
	 * @param number $category
	 * @return multitype:
	 */
	public function resourcesFromCategory($category){
		$sql = "select id from sy_resources where category_id=?";
		$data = $this->runRequest($sql, array($category));
		return $data->fetchAll();
	}
}