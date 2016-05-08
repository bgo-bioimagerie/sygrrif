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
                `image_url` text NOT NULL DEFAULT '',
                `created_date` date NOT NULL,
		PRIMARY KEY (`id`)
		);";
		$this->runRequest($sql);
                
                $sqlj = "CREATE TABLE IF NOT EXISTS `nt_j_group_user` (
		`id_group` int(11) NOT NULL,
                `id_user` int(11) NOT NULL,
                `id_role` int(11) NOT NULL
		);";
		$this->runRequest($sqlj);
                
                $sqljc = "CREATE TABLE IF NOT EXISTS `nt_j_group_comment` (
		`id_group` int(11) NOT NULL,
                `id_comment` int(11) NOT NULL
		);";
		$this->runRequest($sqljc);
	}
	
        public function getAllComments($id_group){
            $sql = "SELECT comment.*, user.name as authorname, user.firstname as authorfirstname "
                    . "FROM nt_comments as comment "
                    . "INNER JOIN core_users AS user ON comment.id_author = user.id "
                    . "WHERE comment.id IN (SELECT id_comment FROM nt_j_group_comment WHERE id_group=?) ORDER BY unix_date DESC;";
            return $this->runRequest($sql, array($id_group))->fetchAll();
        }
        
        public function setCommentToGroup($id_group, $id_comment){
            if ($this->isCommentToGroup($id_group, $id_comment)){
                $sql = "UPDATE nt_j_group_comment SET id_group=? WHERE id_comment=?";
                $this->runRequest($sql, array($id_comment, $id_group));
            }
            else{
                $sql = "INSERT INTO nt_j_group_comment (id_group, id_comment) VALUES(?, ?)";
                $this->runRequest($sql, array($id_group, $id_comment));
            }
        }
        
        public function isCommentToGroup($id_group, $id_comment){
            $sql = "SELECT * FROM nt_j_group_comment WHERE id_group=? AND id_comment=?";
            $req = $this->runRequest($sql, array($id_group, $id_comment));
            if ($req->rowCount() == 1){
                return true;
            }
            return false;
        }
        
        public function getUsers($id_group){
            $sql = "SELECT user.id AS id, user.name AS name, user.firstname AS firstname, 
			groupj.id_role AS id_role, ntroles.name as role
                    FROM nt_j_group_user AS groupj
    			INNER JOIN core_users AS user ON groupj.id_user = user.id
                        INNER JOIN nt_roles AS ntroles ON groupj.id_role = ntroles.id
    			WHERE groupj.id_group=" . $id_group . "
    			ORDER BY groupj.id_role DESC, user.name;";
            return $this->runRequest($sql);
        }
        
        public function setUserToGroup($id_group, $id_user, $id_role){
            if ($this->isUserToGroup($id_group, $id_user)){
                $sql = "UPDATE nt_j_group_user SET id_role=? WHERE id_group=? AND id_user=?";
                $this->runRequest($sql, array($id_role, $id_group, $id_user));
            }
            else{
                $sql = "INSERT INTO nt_j_group_user (id_group, id_user, id_role) VALUES(?, ?, ?)";
                $this->runRequest($sql, array($id_group, $id_user, $id_role));
            }
        }
        
        public function isUserToGroup($id_group, $id_user){
            $sql = "SELECT * FROM nt_j_group_user WHERE id_group=? AND id_user=?";
            $req = $this->runRequest($sql, array($id_group, $id_user));
            if ($req->rowCount() == 1){
                return true;
            }
            return false;
        }
        
        public function isUserGroupAdmin($id_group, $id_user){
            $sql = "SELECT * FROM nt_j_group_user WHERE id_group=? AND id_user=? AND id_role>1";
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
        
	public function add($name, $description, $image_url){
            $date = date("Y-m-d");
            $sql = "INSERT INTO nt_groups (name, description, image_url, created_date) VALUES(?, ?, ?, ?)";
            $this->runRequest($sql, array($name, $description, $image_url, $date));
            return $this->getDatabase()->lastInsertId();
        }
        
        public function update($id, $name, $description, $image_url){
            $sql = "UPDATE nt_groups SET name=?, description=?, image_url=? WHERE id=?";
            $this->runRequest($sql, array($name, $description, $image_url, $id));
            return $id;
        }
        
        public function set($id, $name, $description, $image_url){
            if ($this->isEntry($id)){
                return $this->update($id, $name, $description, $image_url);
            }
            else{
                return $this->add($name, $description, $image_url);
            }
        }
        
        public function getAll($sortEntry = "created_date"){
            $sql = "SELECT * FROM nt_groups ORDER BY ". $sortEntry ." ASC;";
            return $this->runRequest($sql)->fetchAll();
        }
        
        public function get($id){
            $sql = "SELECT * FROM nt_groups WHERE id=?";
            return $this->runRequest($sql, array($id))->fetch();
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