<?php

require_once 'Framework/Model.php';
require_once 'Modules/sygrrif/Model/SyColorCode.php';

/**
 * Class defining the GRR area model
 *
 * @author Sylvain Prigent
 */
class SyCalendarEntry extends Model {

	
	/**
	 * Create the calendar entry table
	 *
	 * @return PDOStatement
	 */
	public function createTable(){
			
		$sql = "CREATE TABLE IF NOT EXISTS `sy_calendar_entry` (
		`id` int(11) NOT NULL AUTO_INCREMENT,	
		`start_time` int(11) NOT NULL,	
		`end_time` int(11) NOT NULL,	
		`resource_id` int(11) NOT NULL,	
		`booked_by_id` int(11) NOT NULL,	
		`recipient_id` int(11) NOT NULL,	
		`last_update` timestamp NOT NULL,
		`color_type_id` int(11) NOT NULL,						
		`short_description` varchar(100) NOT NULL,	
		`full_description` text NOT NULL,
		`quantity` int(11) NOT NULL,
		`repeat_id` int(11) NOT NULL DEFAULT 0,									
		PRIMARY KEY (`id`)
		);";

		$pdo = $this->runRequest($sql);
		return $pdo;
	}
	
	public function addEntry($start_time, $end_time, $resource_id, $booked_by_id, $recipient_id, 
							$last_update, $color_type_id, $short_description, $full_description, $quantity = 0){
		
		$sql = "insert into sy_calendar_entry(start_time, end_time, resource_id, booked_by_id, recipient_id, 
							last_update, color_type_id, short_description, full_description, quantity)"
				. " values(?,?,?,?,?,?,?,?,?,?)";
		$this->runRequest($sql, array($start_time, $end_time, $resource_id, $booked_by_id, $recipient_id, 
							$last_update, $color_type_id, $short_description, $full_description, $quantity));
		return $this->getDatabase()->lastInsertId();
	}
	
	public function setRepeatID($id, $repeat_id){
		$sql = "update sy_calendar_entry set repeat_id=?
									  where id=?";
		$this->runRequest($sql, array($repeat_id, $id));
	}
	
	public function getEntry($id){
		$sql = "select * from sy_calendar_entry where id=?";
		$req = $this->runRequest($sql, array($id));
		return $req->fetch();
	}
	
	public function updateEntry($id, $start_time, $end_time, $resource_id, $booked_by_id, $recipient_id, 
							$last_update, $color_type_id, $short_description, $full_description, $quantity=0){
		$sql = "update sy_calendar_entry set start_time=?, end_time=?, resource_id=?, booked_by_id=?, recipient_id=?, 
							last_update=?, color_type_id=?, short_description=?, full_description=?, quantity=?
									  where id=?";
		$this->runRequest($sql, array($start_time, $end_time, $resource_id, $booked_by_id, $recipient_id, 
							$last_update, $color_type_id, $short_description, $full_description, $quantity, $id));
	}
	
	public function getEntriesForDay($curentDate){
		$dateArray = explode("-", $curentDate);
		$dateBegin = mktime(0,0,0,$dateArray[1],$dateArray[2],$dateArray[0]);
		$dateEnd = mktime(23,59,59,$dateArray[1],$dateArray[2],$dateArray[0]);
		
		$q = array('start'=>$dateBegin, 'end'=>$dateEnd);
		$sql = 'SELECT * FROM sy_calendar_entry WHERE
				(start_time >=:start AND end_time <= :end) 
				ORDER BY start_time';
		$req = $this->runRequest($sql, $q);
		return $req->fetchAll();	// Liste des bénéficiaire dans la période séléctionée
	}
	
	/**
	 * 
	 * @param $dateBegin Beginning of the periode in linux time
	 * @param $dateEnd End of the periode in linux time
	 * 
	 */
	public function getEntriesForPeriodeAndResource($dateBegin, $dateEnd, $resource_id){
		//$dateArray = explode("-", $date);
		//$dateBegin = mktime(0,0,0,$dateArray[1],$dateArray[2],$dateArray[0]);
		//$dateEnd = mktime(23,59,59,$dateArray[1],$dateArray[2],$dateArray[0]);
		
		$q = array('start'=>$dateBegin, 'end'=>$dateEnd, 'res'=>$resource_id);
		$sql = 'SELECT * FROM sy_calendar_entry WHERE
				(start_time >=:start AND end_time <= :end) AND resource_id = :res
				ORDER BY start_time';
		$req = $this->runRequest($sql, $q);
		$data = $req->fetchAll();	// Liste des bénéficiaire dans la période séléctionée
		
	
		$modelUser = new User();
		$modelColor = new SyColorCode();
		for ($i = 0 ; $i < count($data) ; $i++){
			//echo "color id = " . $data[$i]["color_type_id"] . "</br>";
			$rid = $data[$i]["recipient_id"];
			if ($rid > 0){
				$userInfo = $modelUser->userAllInfo($rid);
				$data[$i]["recipient_fullname"] = $userInfo["name"] . " " . $userInfo["firstname"];
				$data[$i]["phone"] = $userInfo["tel"];
				$data[$i]["color"] = $modelColor->getColorCodeValue($data[$i]["color_type_id"]);
			}
			else{
				$data[$i]["recipient_fullname"] = "";
				$data[$i]["phone"] = "";
				$data[$i]["color"] = $modelColor->getColorCodeValue($data[$i]["color_type_id"]);
				
			} 
		}
		return $data;
	}
	
	public function isConflict($start_time, $end_time, $resource_id, $reservation_id = ""){
		$sql="SELECT id FROM sy_calendar_entry WHERE
			  ((start_time >=:start AND start_time < :end) OR	
			  (end_time >:start AND end_time <= :end)) 
			AND resource_id = :res;";
		$q = array('start'=>$start_time, 'end'=>$end_time, 'res'=>$resource_id);	
		$req = $this->runRequest($sql, $q);
		if ($req->rowCount() > 0){
			if ($reservation_id != "" && $req->rowCount() == 1){
				$tmp = $req->fetch();  
				$id = $tmp[0];
				if ($id == $reservation_id){
					return false;
				}
				else{
					return true;
				}
			}
			return true;
		}
		else
			return false;
	}
	
	public function removeEntry($id){
		$sql="DELETE FROM sy_calendar_entry WHERE id = ?";
		$req = $this->runRequest($sql, array($id));
	}
	
	public function removeEntriesFromSeriesID($series_id){
		$sql="DELETE FROM sy_calendar_entry WHERE repeat_id = ?";
		$req = $this->runRequest($sql, array($series_id));
	}
}