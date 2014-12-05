<?php
require_once 'Framework/Model.php';

/**
 * Class defining the Visa model
 *
 * @author Sylvain Prigent
 */
class SyAuthorization extends Model {
	
	/**
	 * Create the authorization table
	 *
	 * @return PDOStatement
	 */
	public function createTable() {
		$sql = "CREATE TABLE IF NOT EXISTS `sy_authorization` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`date` DATE NOT NULL,		
		`user_id` int(11) NOT NULL,
		`lab_id` int(11) NOT NULL,
		`visa_id` int(11) NOT NULL,
		`resource_id` int(11) NOT NULL,		
		PRIMARY KEY (`id`)
		);";
		
		$pdo = $this->runRequest ( $sql );
		return $pdo;
	}
	public function addAuthorization($date, $user_id, $lab_id, $visa_id, $resource_id) {
		$sql = "insert into sy_authorization(date, user_id, lab_id, visa_id, resource_id)" . " values(?,?,?,?,?)";
		$user = $this->runRequest ( $sql, array (
				$date,
				$user_id,
				$lab_id,
				$visa_id,
				$resource_id 
		) );
	}
	public function editAuthorization($id, $date, $user_id, $lab_id, $visa_id, $resource_id) {
		$sql = "update sy_authorization set date=?, user_id=?, lab_id=?, visa_id=?, resource_id=?
						where id=?";
		$unit = $this->runRequest ( $sql, array (
				$date,
				$user_id,
				$lab_id,
				$visa_id,
				$resource_id,
				$id 
		) );
	}
	public function getAuthorizations($sortentry = 'id') {
		
		$sqlSort = "sy_authorization.id";
		if ($sortentry == "date"){
			$sqlSort = "sy_authorization.date";
		}
		else if ($sortentry == "userFirstname"){
			$sqlSort = "core_users.firstname";
		}
		else if ($sortentry == "userName"){
			$sqlSort = "core_users.name";
		}
		else if ($sortentry == "unit"){
			$sqlSort = "core_units.name";
		}
		else if ($sortentry == "visa"){
			$sqlSort = "sy_visas.name";
		}
		else if ($sortentry == "ressource"){
			$sqlSort = "sy_resources.name";
		}
		
		$sql = "SELECT sy_authorization.id, sy_authorization.date, core_users.name AS userName, core_users.firstname AS userFirstname, core_units.name AS unitName, sy_visas.name AS visa, sy_resources.name AS resource 		
					from sy_authorization
					     INNER JOIN core_users on sy_authorization.user_id = core_users.id
					     INNER JOIN core_units on sy_authorization.lab_id = core_units.id
					     INNER JOIN sy_visas on sy_authorization.visa_id = sy_visas.id
					     INNER JOIN sy_resources on sy_authorization.resource_id = sy_resources.id
					ORDER BY ". $sqlSort . ";";
		$auth = $this->runRequest ( $sql );
		return $auth->fetchAll ();
	}
}
