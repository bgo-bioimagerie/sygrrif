<?php

require_once 'Framework/Model.php';

/**
 * Class defining the template table model. 
 *
 * @author Sylvain Prigent
 */
class NtProject extends Model {

	public function createTable(){
		$sql = "CREATE TABLE IF NOT EXISTS `nt_projects` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
                `name` varchar(50) NOT NULL DEFAULT '',	
                `description` text NOT NULL DEFAULT '',
                `date_created` DATE NOT NULL,
                `date_modified` DATE NOT NULL,
		PRIMARY KEY (`id`)
		);";

		$pdo = $this->runRequest($sql);
		return $pdo;
	}
	
	public function add($name, $description, $date_created, $date_modified = ""){
            $sql = "INERT INTO nt_projects (name, description, date_created, date_modified) VALUES(?, ?, ?, ?)";
            $this->runRequest($sql, array($name, $description, $date_created, $date_modified));
            return $this->getDatabase()->lastInsertId();
        }
        
        public function update($id, $name, $description, $date_created, $date_modified){
            $sql = "UPDATE nt_projects SET name=?, description=?, date_created=?, date_modified=? WHERE id=?";
            $this->runRequest($sql, array($name, $description, $date_created, $date_modified, $id));
            return $id;
        }
        
        public function set($id, $name, $description, $date_created, $date_modified){
            if ($this->isEntry($id)){
                return $this->update($id, $name, $description, $date_created, $date_modified);
            }
            else{
                return $this->add($name, $description, $date_created, $date_modified);
            }
        }
        
        public function isEntry($id){
            $sql = "SELECT * FROM nt_projects WHERE id=?";
            $req = $this->runRequest($sql, array($id));
            if ($req->rowCount() == 1){
                return true;
            }
            return false;
        }
        
        public function delete($id){
            $sql="DELETE FROM nt_projects WHERE id = ?";
            $this->runRequest($sql, array($id));
        } 
}