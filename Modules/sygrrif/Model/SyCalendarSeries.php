<?php

require_once 'Framework/Model.php';
require_once 'Modules/sygrrif/Model/SyColorCode.php';

/**
 * Model that manage the series calendar entries
 *
 * @author Sylvain Prigent
 */
class SyCalendarSeries extends Model {

	
	/**
	 * Create the series calendar entry table
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
	
	
	/**
	 * Add a series entry
	 * @param unknown $start_time
	 * @param unknown $end_time
	 * @param unknown $series_type_id
	 * @param unknown $end_date
	 * @param unknown $days_option
	 * @param unknown $resource_id
	 * @param unknown $booked_by_id
	 * @param unknown $recipient_id
	 * @param unknown $last_update
	 * @param unknown $color_type_id
	 * @param unknown $short_description
	 * @param unknown $full_description
	 * @param number $quantity
	 * @return string
	 */
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
	
	/**
	 * Get the informations of an entry from it ID
	 * @param unknown $id
	 * @return mixed
	 */
	public function getEntry($id){
		$sql = "select * from sy_calendar_series where id=?";
		$req = $this->runRequest($sql, array($id));
		return $req->fetch();
	}
	
	/**
	 * Update an entry info from it ID
	 * @param unknown $id
	 * @param unknown $start_time
	 * @param unknown $end_time
	 * @param unknown $series_type_id
	 * @param unknown $end_date
	 * @param unknown $days_option
	 * @param unknown $resource_id
	 * @param unknown $booked_by_id
	 * @param unknown $recipient_id
	 * @param unknown $last_update
	 * @param unknown $color_type_id
	 * @param unknown $short_description
	 * @param unknown $full_description
	 * @param number $quantity
	 */
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

	/**
	 * Calculate the entries times
	 * @param unknown $start_time
	 * @param unknown $end_time
	 * @param unknown $series_type_id
	 * @param unknown $days_option
	 * @param unknown $seriesEndDate
	 * @throws Exception
	 * @return multitype:multitype:unknown
	 */
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
	
	/**
	 * Remove an entry series
	 * @param number $id
	 */
	public function removeSeries($id){
		$sql="DELETE FROM sy_calendar_series WHERE id = ?";
		$req = $this->runRequest($sql, array($id));
	}
}