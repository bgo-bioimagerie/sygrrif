<?php
require_once 'Framework/Model.php';

/**
 * Class defining the resource type model
 *
 * @author Sylvain Prigent
 */
class SyResourceType extends Model {
	
	/**
	 * Create the table
	 * @return PDOStatement
	 */
	public function createTable() {
		$sql = "CREATE TABLE IF NOT EXISTS `sy_resource_type` (
  		`id` int(11) NOT NULL AUTO_INCREMENT,
  		`name` varchar(30) NOT NULL DEFAULT '',
		`controller` varchar(50) NOT NULL DEFAULT '',
		`edit_action` varchar(50) NOT NULL DEFAULT '',		
		`book_action` varchar(50) NOT NULL DEFAULT '',				
  		PRIMARY KEY (`id`)
		);";
		
		$pdo = $this->runRequest ( $sql );
		return $pdo;
	}
	
	/**
	 * Create the default types
	 */
	public function createDefaultTypes() {
		if (!$this->isType("Calendar")){
			$this->addType ( "Calendar", "calendar", "editcalendarresource", "book" );
		}
		if (!$this->isType("Unitary Calendar")){
			$this->addType ( "Unitary Calendar", "calendar", "editunitaryresource", "book" );
		}
		if (!$this->isType("Time add unitary calendar")){
			$this->addType ( "Time add unitary calendar", "calendar", "edittimeunitaryresource", "book" );
		}
	}
	
	/**
	 * get all the types info
	 * @param unknown $sortentry
	 * @return multitype:
	 */
	public function types($sortentry){
		$sql = "select * from sy_resource_type order by " . $sortentry . " ASC;";
		$user = $this->runRequest($sql);
		return $user->fetchAll();
	}
	
	/**
	 * Get all the types IDs and names
	 * @param unknown $sortentry
	 * @return multitype:
	 */
	public function typesIDNames($sortentry){
		$sql = "select id, name from sy_resource_type order by " . $sortentry . " ASC;";
		$user = $this->runRequest($sql);
		return $user->fetchAll();
	}
	
	/**
	 * Add a new type
	 * @param unknown $name
	 * @param unknown $controller
	 * @param unknown $edit_action
	 * @param unknown $book_action
	 * @return PDOStatement
	 */
	public function addType($name, $controller, $edit_action, $book_action) {
		$sql = "INSERT INTO sy_resource_type (name, controller, edit_action, book_action)
				 VALUES(?,?,?,?)";
		$pdo = $this->runRequest ( $sql, array (
				$name, $controller, $edit_action, $book_action 
		) );
		return $pdo;
	}
	
	/**
	 * Check if a type exists
	 * @param unknown $name
	 * @return boolean
	 */
	public function isType($name){
		$sql = "select id from sy_resource_type where name=?";
		$data = $this->runRequest ( $sql, array (
				$name
		) );
		if ($data->rowCount () == 1)
			return true;
		else
			return false;
	}
	
	/**
	 * Get the type ID from type name
	 * @param unknown $typename
	 * @throws Exception
	 * @return mixed
	 */
	public function getTypeId($typename) {
		$sql = "select id from sy_resource_type where name=?";
		$data = $this->runRequest ( $sql, array (
				$typename 
		) );
		if ($data->rowCount () == 1){
			$tmp = $data->fetch ();
			return $tmp[0]; // get the first line of the result
		}
		else{
			throw new Exception ( "Cannot find the resource type using the given name" );
		}
	}
	
	/**
	 * Get the inforations of a type fro mit ID
	 * @param unknown $id
	 * @throws Exception
	 * @return mixed
	 */
	public function getType($id){
		$sql = "select * from sy_resource_type where id=?";
		$req = $this->runRequest ( $sql, array (
				$id
		) );
		if ($req->rowCount () == 1)
			return $req->fetch (); 
		else
			throw new Exception ( "Cannot find the resource type using the given id" );
	}
	
	/**
	 * Get the type name from it ID
	 * @param unknown $typeId
	 * @throws Exception
	 * @return mixed
	 */
	public function getTypeName($typeId) {
		$sql = "select name from sy_resource_type where id=?";
		$data = $this->runRequest ( $sql, array (
				$typeId
		) );
		if ($data->rowCount () == 1)
			return $data->fetch (); // get the first line of the result
		else
			throw new Exception ( "Cannot find the resource type using the given id" );
	}
}