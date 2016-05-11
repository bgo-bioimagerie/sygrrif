<?php

require_once 'Framework/Model.php';

/**
 * Class defining the template table model. 
 *
 * @author Sylvain Prigent
 */
class AgEventType extends Model {

	public function createTable(){
		$sql = "CREATE TABLE IF NOT EXISTS `ag_eventtypes` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
                `name` varchar(50) NOT NULL,
                `color` varchar(7) NOT NULL,
                `display_order` int(11) NOT NULL,
		PRIMARY KEY (`id`)
		);";

		$this->runRequest($sql);
	}
	
	/*
	 * 
	 * Add here the query methods
	 * 
	 */
        public function insert($name, $color, $display_order){
            $sql = "INSERT INTO ag_eventtypes (name, color, display_order) VALUES (?,?,?)";
            $this->runRequest($sql, array($name, $color, $display_order));
            return $this->getDatabase()->lastInsertId();
        }
        
        public function update($id, $name, $color, $display_order){
            $sql = "UPDATE ag_eventtypes SET name=?, color=?, display_order=? WHERE id=?";
            $this->runRequest($sql, array($name, $color, $display_order, $id));
        }
        
        public function exists($id){
            $sql = "SELECT id FROM ag_eventtypes WHERE id=?";
            $req = $this->runRequest($sql, array($id));
            if ($req->rowCount() == 1){
                return true;
            }
            return false;
        }
        
        public function set($id, $name, $color, $display_order){
            if ($this->exists($id)){
                $this->update($id, $name, $color, $display_order);
            }
            else{
                $this->insert($name, $color, $display_order);
            }
        }
        
        public function selectAll(){
            $sql = "SELECT * FROM ag_eventtypes ORDER By display_order ASC;";
            return $this->runRequest($sql)->fetchAll();        
        }
        
        public function select($id){
            $sql = "SELECT * FROM ag_eventtypes WHERE id=?";
            return $this->runRequest($sql, array($id))->fetch();        
        }
        
        public function getName($id){
            $sql = "SELECT name FROM ag_eventtypes WHERE id=? ";
            return $this->runRequest($sql, array($id))->fetch(); 
        }
        
        public function delete($id){
            $sql = "DELETE FROM ag_eventtypes WHERE id=?";
            $this->runRequest($sql, array($id));
        }
}
