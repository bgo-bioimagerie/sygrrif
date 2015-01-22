<?php

require_once 'Framework/Model.php';
require_once 'Modules/sygrrif/Model/SyColorCode.php';

/**
 * Class defining the GRR area model
 *
 * @author Sylvain Prigent
 */
class SyCalendarSeries extends Model {

	
	/**
	 * Create the calendar entry table
	 *
	 * @return PDOStatement
	 */
	public function createTable(){
			
		$sql = "CREATE TABLE IF NOT EXISTS `sy_calendar_series` (
		`id` int(11) NOT NULL AUTO_INCREMENT,	
		`start_time` int(11) NOT NULL,	
		`end_time` int(11) NOT NULL,	
		`series_type_id` int(11) NOT NULL,		
		`end_date` varchar(10) NOT NULL,
		`days_option` varchar(14) NOT NULL,		
		`resource_id` int(11) NOT NULL,
		`booked_by_id` int(11) NOT NULL,	
		`recipient_id` int(11) NOT NULL,
		`last_update` timestamp NOT NULL,
		`color_type_id` int(11) NOT NULL,						
		`short_description` varchar(100) NOT NULL,	
		`full_description` text NOT NULL,
		`quantity` int(11) NOT NULL,								
		PRIMARY KEY (`id`)
		);";

		$pdo = $this->runRequest($sql);
		return $pdo;
	}
	
	
	
	public function addEntry($start_time, $end_time, $series_type_id, $end_date, $days_option,
							 $resource_id, $booked_by_id, $recipient_id, $last_update, $color_type_id,
							 $short_description, $full_description, $quantity = 0){
		
		$sql = "insert into sy_calendar_series(
				start_time,	end_time, series_type_id, end_date, days_option,
				resource_id, booked_by_id, recipient_id, last_update, color_type_id,
				short_description, full_description, quantity
				)"
				. " values(?,?,?,?,?,?,?,?,?,?,?,?,?)";
		$this->runRequest($sql, array($start_time, $end_time, $series_type_id, $end_date, $days_option,
							 $resource_id, $booked_by_id, $recipient_id, $last_update, $color_type_id,
							 $short_description, $full_description, $quantity));
		return $this->getDatabase()->lastInsertId();
	}
	
	public function getEntry($id){
		$sql = "select * from sy_calendar_series where id=?";
		$req = $this->runRequest($sql, array($id));
		return $req->fetch();
	}
	
	public function updateEntry($id, $start_time, $end_time, $series_type_id, $end_date, $days_option,
							 $resource_id, $booked_by_id, $recipient_id, $last_update, $color_type_id,
							 $short_description, $full_description, $quantity=0){
		$sql = "update sy_calendar_entry set 
				start_time=?, end_time=?, series_type_id=?, end_date=?, days_option=?,
				resource_id=?, booked_by_id=?, recipient_id=?, last_update=?, color_type_id=?,
				short_description=?, full_description=?, quantity=?
									  where id=?";
		$this->runRequest($sql, array($start_time, $end_time, $series_type_id, $end_date, $days_option,
							 $resource_id, $booked_by_id, $recipient_id, $last_update, $color_type_id,
							 $short_description, $full_description, $quantity, $id));
	}

	public function entriesDates($start_time, $end_time, $series_type_id, $days_option, $seriesEndDate){
		
		$seriesEndDate = explode("-", $seriesEndDate);
		$seriesEndDate = mktime(23,59,59,$seriesEndDate[1], $seriesEndDate[2], $seriesEndDate[0]);
		
		$entriesTimes = array();
		if ($series_type_id == 1){ // Every day
			$last_start_time = $start_time;
			$last_end_time = $end_time;
			while($last_end_time <= $seriesEndDate){
				$entriesTimes[] = array('start_time' => $last_start_time, 'end_time' => $last_end_time );
				$last_start_time += 86400;
				$last_end_time += 86400;
			}
		}
		else if ($series_type_id == 2){ // Every week
			throw new Exception('This option is not yet implemented');
		}
		else if ($series_type_id == 3){ // Every 2 weeks
			throw new Exception('This option is not yet implemented');
		}
		else if ($series_type_id == 4){ // Every 3 weeks
			throw new Exception('This option is not yet implemented');
		}
		else if ($series_type_id == 5){ // Every 4 weeks
			throw new Exception('This option is not yet implemented');
		}
		else if ($series_type_id == 6){ // Every 5 weeks
			throw new Exception('This option is not yet implemented');
		}
		else if ($series_type_id == 7){ // Every month same date
			throw new Exception('This option is not yet implemented');
		}
		else if ($series_type_id == 8){ // Every month same week day
			throw new Exception('This option is not yet implemented');
		}
		else if ($series_type_id == 9){ // Every year same date
			throw new Exception('This option is not yet implemented');
		}
		return $entriesTimes;
	}
	
	public function removeSeries($id){
		$sql="DELETE FROM sy_calendar_series WHERE id = ?";
		$req = $this->runRequest($sql, array($id));
	}
}