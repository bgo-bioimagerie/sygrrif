<?php

require_once 'Framework/Model.php';

/**
 * Class defining the template table model. 
 *
 * @author Sylvain Prigent
 */
class AgEvent extends Model {

	public function createTable(){
		$sql = "CREATE TABLE IF NOT EXISTS `ag_events` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
                `name` varchar(50) NOT NULL,
                `content` text NOT NULL,
                `date_begin` int(11) NOT NULL,
                `date_end` int(11) NOT NULL,
                `image_url` text NOT NULL,
                `id_type` int(11) NOT NULL,
		PRIMARY KEY (`id`)
		);";

		$this->runRequest($sql);
	}
	
	/*
	 * 
	 * Add here the query methods
	 * 
	 */
        public function insert($name, $content, $date_begin, $date_end, $id_type){
            $sql = "INSERT INTO ag_events (name, content, date_begin, date_end, id_type) VALUES (?,?,?,?,?)";
            $this->runRequest($sql, array($name, $content, $date_begin, $date_end, $id_type));
            return $this->getDatabase()->lastInsertId();
        }
        
        public function update($id, $name, $content, $date_begin, $date_end, $id_type){
            $sql = "UPDATE ag_events SET name=?, content=?, date_begin=?, date_end=?, id_type=? WHERE id=?";
            $this->runRequest($sql, array($name, $content, $date_begin, $date_end, $id_type, $id));
        }
        
        public function setImage($id, $image_url){
            $sql = "UPDATE ag_events SET image_url=? WHERE id=?";
            $this->runRequest($sql, array($image_url, $id));
        }
        
        public function exists($id){
            $sql = "SELECT id FROM ag_events WHERE id=?";
            $req = $this->runRequest($sql, array($id));
            if ($req->rowCount() == 1){
                return true;
            }
            return false;
        }
        
        public function set($id, $name, $content, $date_begin, $date_end, $id_type){
            if ($this->exists($id)){
                $this->update($id, $name, $content, $date_begin, $date_end, $id_type);
            }
            else{
                $this->insert($name, $content, $date_begin, $date_end, $id_type);
            }
        }
        
        public function selectAll(){
            $sql = "SELECT * FROM ag_events ORDER By date_begin ASC;";
            return $this->runRequest($sql)->fetchAll();        
        }
        
        public function select($id){
            $sql = "SELECT * FROM ag_events WHERE id=?";
            return $this->runRequest($sql, array($id))->fetch();        
        }
        
        public function delete($id){
            $sql = "DELETE FROM ag_events WHERE id=?";
            $this->runRequest($sql, array($id));
        }
        
        public function getEventsMonth($month, $year){
		
		// premier jour du mois
		$firstDay = mktime(0,0,0,$month,1,$year);
		$l_day=date("t",$firstDay);
		// dernier jour du moi
		$lastDay=mktime(0, 0, 0, $month,$l_day , $year);
		
		$sql = "SELECT  
					events.id as id,
					events.date_begin as date_begin,
					events.date_end as date_end,
					events.name as title,
					event_types.color as type_color
				FROM ag_events as events 
				INNER JOIN ag_eventtypes as event_types ON event_types.id = events.id_type  	
				WHERE date_begin >= ? and date_begin <= ? 
				order by date_begin ASC;";
		$req = $this->runRequest($sql, array($firstDay, $lastDay));
		return $req->fetchAll();
	}
        
        public function getLastEvents(){
			
		//$sql = "select * from events order by date_end DESC LIMIT 3;";
		$sql = "SELECT
					events.id as id,
					events.date_begin as date_begin,
					events.date_end as date_end,
					events.name as title,
					event_types.color as type_color,
					event_types.name as type_name
				FROM ag_events as events
				INNER JOIN ag_eventtypes as event_types ON event_types.id = events.id_type
				order by date_end DESC LIMIT 3;";
		$user = $this->runRequest($sql);
		return $user->fetchAll();
	}
        
        public function getEventsdesc($sortentry = 'id'){
			
		$sql = "select * from ag_events order by " . $sortentry . " DESC;";
		$user = $this->runRequest($sql);
		return $user->fetchAll();
	}
}
