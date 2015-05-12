<?php

require_once 'Framework/Model.php';

/**
 * Class defining the Sygrrif resource calendar model
 *
 * @author Sylvain Prigent
 */

class SyResourceCalendar extends Model {

	/**
	 * Create the unit table
	 *
	 * @return PDOStatement
	 */
	public function createTable(){
			
		$sql = "CREATE TABLE IF NOT EXISTS `sy_resources_calendar` (
		`id_resource` int(11) NOT NULL AUTO_INCREMENT,	
		`nb_people_max` int(11) NOT NULL,		
		`quantity_name` varchar(50) NOT NULL,
		`available_days` varchar(15) NOT NULL DEFAULT '',
		`day_begin` int(11) NOT NULL,		
		`day_end` int(11) NOT NULL,		
		`size_bloc_resa` int(11) NOT NULL,
		`resa_time_setting` int(1) NOT NULL,	
		`default_color_id` int(11) NOT NULL,			
		PRIMARY KEY (`id_resource`)
		);";

		$pdo = $this->runRequest($sql);
		return $pdo;
	}

	public function addResource($id_resource, $nb_people_max, $available_days, $day_begin, $day_end, $size_bloc_resa, $resa_time_setting, $quantity_name = "", $default_color_id=0){
		$sql = "INSERT INTO sy_resources_calendar (id_resource, nb_people_max, available_days, day_begin, day_end, size_bloc_resa, resa_time_setting, quantity_name, default_color_id) 
				VALUES(?,?,?,?,?,?,?,?,?)";
		$pdo = $this->runRequest($sql, array($id_resource, $nb_people_max, $available_days, $day_begin, $day_end, $size_bloc_resa, $resa_time_setting, $quantity_name, $default_color_id));
		return $pdo;
	}
	
	
	public function setResource($id_resource, $nb_people_max, $available_days, $day_begin, $day_end, $size_bloc_resa, $resa_time_setting, $quantity_name = "", $default_color_id=0){
		if (!$this->isResource($id_resource)){
			$this->addResource($id_resource, $nb_people_max, $available_days, $day_begin, $day_end, $size_bloc_resa, $resa_time_setting, $quantity_name, $default_color_id);
		}
		else{
			$this->updateResource($id_resource, $nb_people_max, $available_days, $day_begin, $day_end, $size_bloc_resa, $resa_time_setting, $quantity_name, $default_color_id);
		}
	}
	
	public function isResource($id_resource){
		$sql = "select * from sy_resources_calendar where id_resource=?";
		$req = $this->runRequest($sql, array($id_resource));
		return ($req->rowCount() == 1);
	}
	
	public function updateResource($id_resource, $nb_people_max, $available_days, $day_begin, $day_end, $size_bloc_resa, $resa_time_setting, $quantity_name = "", $default_color_id=0){
		$sql = "update sy_resources_calendar set nb_people_max=?, available_days=?, day_begin=?, day_end=?, size_bloc_resa=?, resa_time_setting=?,quantity_name=?, default_color_id=? 
		        where id_resource=?";
		$this->runRequest($sql, array($nb_people_max, $available_days, $day_begin, $day_end, $size_bloc_resa, $resa_time_setting, $quantity_name, $default_color_id, $id_resource));
	}
	
	public function resource($id_resource){
		$sql = "select * from sy_resources_calendar where id_resource=?";
		$data = $this->runRequest($sql, array($id_resource));
		return $data->fetch();
	}
	
	public function delete($id_resource){
		$sql="DELETE FROM sy_resources_calendar WHERE id_resource = ?";
		$req = $this->runRequest($sql, array($id_resource));
	}
	
}