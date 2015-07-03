<?php
require_once 'Framework/Model.php';

/**
 * Class defining the GRR area model
 *
 
 */
class reservation extends Model {
	public function createTable(){
			
	$sql = "CREATE TABLE IF NOT EXISTS `reservation` (
		`id` int(11) NOT NULL AUTO_INCREMENT,	
		`start_time` int(11) NOT NULL,	
		`end_time` int(11) NOT NULL,	
		`resource_id` int(11) NOT NULL,	
		`booked_by_id` int(11) NOT NULL,	
		`recipient_id` int(11) NOT NULL,	
		`last_update` timestamp NOT NULL,
		`color_type_id` int(11) NOT NULL,						
		`protocol` varchar(20) NOT NULL,	
		`codeanonyma` varchar(20) NOT NULL,	
		`numerovisite` varchar(20) NOT NULL,					
		`quantity` int(11) NOT NULL,
		`repeat_id` int(11) NOT NULL DEFAULT 0,									
		PRIMARY KEY (`id`)
		);";

		$pdo = $this->runRequest($sql);
		return $pdo;
	}
	
	public function ifresa($start_time, $end_time, $resource_id, $reservation_id){
		$sql="SELECT id FROM reservation WHERE
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
	
	public function addres($start_time, $end_time, $resource_id, $booked_by_id, $recipient_id,
										 $last_update, $color_type_id, $protocol, $codeanonym, $numerovisite, $quantity=0){
										 	$sql = "insert into reservation(start_time, end_time, resource_id, booked_by_id, recipient_id, 
							last_update, color_type_id, protocol, codeanonyma, numerovisite, quantity)"
				. " values(?,?,?,?,?,?,?,?,?,?,?)";
		$this->runRequest($sql, array($start_time, $end_time, $resource_id, $booked_by_id, $recipient_id, 
							$last_update, $color_type_id, $protocol, $codeanonym, $numerovisite, $quantity));
		return $this->getDatabase()->lastInsertId();
							 }
		public function addResCalendarEntry($start_time, $end_time, $resource_id, $booked_by_id, $recipient_id,
										 $last_update, $color_type_id, $protocol, $codeanonym, $numerovisite, $quantity=0){
										 	$sql = "insert into sy_calendar_entry(start_time, end_time, resource_id, booked_by_id, recipient_id, 
							last_update, color_type_id, short_description, full_description, numerovisite, quantity)"
				. " values(?,?,?,?,?,?,?,?,?,?,?)";
		$this->runRequest($sql, array($start_time, $end_time, $resource_id, $booked_by_id, $recipient_id, 
							$last_update, $color_type_id, $protocol, $codeanonym, $numerovisite, $quantity));
		return $this->getDatabase()->lastInsertId();
							 }
	public function updateres($id, $start_time, $end_time, $resource_id, $booked_by_id, $recipient_id, 
							$last_update, $color_type_id, $protocol, $codeanonym, $numerovisite, $quantity=0){
		$sql = "update sy_calendar_entry set start_time=?, end_time=?, resource_id=?, booked_by_id=?, recipient_id=?, 
							last_update=?, color_type_id=?, protocol=?, codeanonyma=?, numerovisite=?, quantity=?
									  where id=?";
		$this->runRequest($sql, array($start_time, $end_time, $resource_id, $booked_by_id, $recipient_id, 
							$last_update, $color_type_id, $protocol, $codeanonym, $numerovisite, $quantity, $id));
	}
	public function updateresCanlendar($id, $start_time, $end_time, $resource_id, $booked_by_id, $recipient_id, 
							$last_update, $color_type_id, $protocol, $codeanonym, $numerovisite, $quantity=0){
		$sql = "update sy_calendar_entry set start_time=?, end_time=?, resource_id=?, booked_by_id=?, recipient_id=?, 
							last_update=?, color_type_id=?, short_description=?, full_description=?, numerovisite=?, quantity=?
									  where id=?";
		$this->runRequest($sql, array($start_time, $end_time, $resource_id, $booked_by_id, $recipient_id, 
							$last_update, $color_type_id, $protocol, $codeanonym, $numerovisite, $quantity, $id));
	}
	
	
public function setRepeatID($id, $repeat_id){
		$sql = "update reservation set repeat_id=?
									  where id=?";
		$this->runRequest($sql, array($repeat_id, $id));
	}
	
}
