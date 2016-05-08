<?php

require_once 'Framework/Model.php';

/**
 * Class defining the template table model. 
 *
 * @author Sylvain Prigent
 */
class NtRole extends Model {

	public function createTable(){
		$sql = "CREATE TABLE IF NOT EXISTS `nt_roles` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
                `name` varchar(50) NOT NULL DEFAULT '',
		PRIMARY KEY (`id`)
		);";
		$this->runRequest($sql);
	}
	
        public function createDefault(){
            if (!$this->isEntry(1)){
                $this->add("user");
            }
            if (!$this->isEntry(2)){
                $this->add("admin");
            }
        }
        
        public function getAll(){
            $sql = "SELECT * FROM nt_roles";
            return $this->runRequest($sql)->fetchAll();
        }
        
        public function add($name){
            $sql = "INSERT INTO nt_roles (name) VALUES(?)";
            $this->runRequest($sql, array($name));
            return $this->getDatabase()->lastInsertId();
        }
        
        public function update($id, $name){
            $sql = "UPDATE nt_roles SET name=? WHERE id=?";
            $this->runRequest($sql, array($name, $id));
            return $id;
        }
        
        public function set($id, $name){
            if ($this->isEntry($id)){
                return $this->update($id, $name);
            }
            else{
                return $this->add($name);
            }
        }
        
        public function isEntry($id){
            $sql = "SELECT * FROM nt_roles WHERE id=?";
            $req = $this->runRequest($sql, array($id));
            if ($req->rowCount() == 1){
                return true;
            }
            return false;
        }
        
        public function delete($id){
            $sql="DELETE FROM nt_roles WHERE id = ?";
            $this->runRequest($sql, array($id));
        } 
}