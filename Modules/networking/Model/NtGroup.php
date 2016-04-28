<?php

require_once 'Framework/Model.php';

/**
 * Class defining the template table model. 
 *
 * @author Sylvain Prigent
 */
class NtGroup extends Model {

	public function createTable(){
		$sql = "CREATE TABLE IF NOT EXISTS `nt_groups` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
                `name` varchar(50) NOT NULL DEFAULT '',
                `description` text NOT NULL DEFAULT '',
		PRIMARY KEY (`id`)
		);";
		$this->runRequest($sql);
                
                $sqlj = "CREATE TABLE IF NOT EXISTS `nt_j_group_user` (
		`id_group` int(11) NOT NULL,
                `id_user` int(11) NOT NULL,
                `id_role` int(11) NOT NULL
		);";
		$this->runRequest($sqlj);
	}
	
        public function setUserToGroup($id_group, $id_user, $id_role){
            if (isUserToGroup($id_group, $id_user)){
                $sql = "UPDATE nt_j_group_user SET id_role=? WHERE id_group=? AND id_user=?";
                $this->runRequest($sql, array($id_role, $id_group, $id_user));
            }
            else{
                $sql = "INERT INTO nt_j_group_user (id_group, id_user, id_role) VALUES(?, ?, ?)";
                $this->runRequest($sql, array($id_group, $id_user, $id_role));
            }
        }
        
        public function isUserToGroup($id_group, $id_user){
            $sql = "SELECT * FROM nt_j_group_user WHERE id=?";
            $req = $this->runRequest($sql, array($id_group, $id_user));
            if ($req->rowCount() == 1){
                return true;
            }
            return false;
        }
        
        public function removeUserFromGroup($id_group, $id_user){
            $sql="DELETE FROM nt_j_group_user WHERE id_group=? AND id_user=?";
            $this->runRequest($sql, array($id_group, $id_user));
        }
        
	public function add($name, $description){
            $sql = "INERT INTO nt_groups (name, description) VALUES(?, ?)";
            $this->runRequest($sql, array($name, $description));
            return $this->getDatabase()->lastInsertId();
        }
        
        public function update($id, $name, $description){
            $sql = "UPDATE nt_groups SET name=?, description=? WHERE id=?";
            $this->runRequest($sql, array($name, $description, $id));
            return $id;
        }
        
        public function set($id, $name, $description){
            if ($this->isEntry($id)){
                return $this->update($id, $name, $description);
            }
            else{
                return $this->add($name, $description);
            }
        }
        
        public function isEntry($id){
            $sql = "SELECT * FROM nt_groups WHERE id=?";
            $req = $this->runRequest($sql, array($id));
            if ($req->rowCount() == 1){
                return true;
            }
            return false;
        }
        
        public function delete($id){
            $sql="DELETE FROM nt_groups WHERE id = ?";
            $this->runRequest($sql, array($id));
        } 
}