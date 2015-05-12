<?php
require_once 'Framework/Model.php';

/**
 * Class defining the resource type model
 *
 * @author Sylvain Prigent
 */
class SyResourceType extends Model {
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
	public function createDefaultTypes() {
		if (!$this->isType("Calendar")){
			$this->addType ( "Calendar", "calendar", "editcalendarresource", "book" );
		}
		if (!$this->isType("Unitary Calendar")){
			$this->addType ( "Unitary Calendar", "calendar", "editunitaryresource", "book" );
		}
		if (!$this->isType("Time and Unitary Calendar")){
			$this->addType ( "Time add unitary calendar", "calendar", "edittimeunitaryresource", "book" );
		}
	}
	
	public function types($sortentry){
		$sql = "select * from sy_resource_type order by " . $sortentry . " ASC;";
		$user = $this->runRequest($sql);
		return $user->fetchAll();
	}
	
	public function typesIDNames($sortentry){
		$sql = "select id, name from sy_resource_type order by " . $sortentry . " ASC;";
		$user = $this->runRequest($sql);
		return $user->fetchAll();
	}
	
	public function addType($name, $controller, $edit_action, $book_action) {
		$sql = "INSERT INTO sy_resource_type (name, controller, edit_action, book_action)
				 VALUES(?,?,?,?)";
		$pdo = $this->runRequest ( $sql, array (
				$name, $controller, $edit_action, $book_action 
		) );
		return $pdo;
	}
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