<?php

require_once 'Framework/Model.php';

/**
 * Class defining the Sygrrif resource unitary calendar model
 *
 * @author Sylvain Prigent
 */

class SyResourceUnitaryCalendar extends Model {

	/**
	 * Create the unit table
	 *
	 * @return PDOStatement
	 */
	public function createTable(){
			
		$sql = "CREATE TABLE IF NOT EXISTS `sy_resources_ucalendar` (
		`id_resource` int(11) NOT NULL AUTO_INCREMENT,	
		`nb_people_max` int(11) NOT NULL,		
		`available_days` varchar(15) NOT NULL DEFAULT '',
		`day_begin` int(11) NOT NULL,		
		`day_end` int(11) NOT NULL,		
		`size_bloc_resa` int(11) NOT NULL,
		`unitary_name` int(11) NOT NULL,		
		PRIMARY KEY (`id`)
		);";

		$pdo = $this->runRequest($sql);
		return $pdo;
	}

	public function addResource($id_resource, $nb_people_max, $available_days, $day_begin, $day_end, $size_bloc_resa, $unitary_name){
		$sql = "INSERT INTO sy_resources_calendar (id_resource, nb_people_max, available_days, day_begin, day_end, size_bloc_resa, unitary_name) 
				VALUES(?,?,?,?,?,?)";
		$pdo = $this->runRequest($sql, array($id_resource, $nb_people_max, $available_days, $day_begin, $day_end, $size_bloc_resa,$unitary_name));
		return $pdo;
	}
	
	public function setResource($id_resource, $nb_people_max, $available_days, $day_begin, $day_end, $size_bloc_resa,$unitary_name){
		if (!$this->isResource($id_resource)){
			$this->addResource($id_resource, $nb_people_max, $available_days, $day_begin, $day_end, $size_bloc_resa, $unitary_name);
		}
	}
	
	public function isResource($id_resource){
		$sql = "select * from sy_resources_calendar where id_resource=?";
		$req = $this->runRequest($sql, array($id_resource));
		return ($req->rowCount() == 1);
	}
	
	public function updateResource($id_resource, $nb_people_max, $available_days, $day_begin, $day_end, $size_bloc_resa, $unitary_name){
		$sql = "update sy_resources_calendar set nb_people_max=?, available_days=?, day_begin=?, day_end=?, size_bloc_resa=?, 
		        unitary_name=? where id_resource=?";
		$this->runRequest($sql, array($nb_people_max, $available_days, $day_begin, $day_end, $size_bloc_resa, $id_resource, $unitary_name));
	}
	
}