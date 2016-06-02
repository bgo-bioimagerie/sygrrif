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
                `adressed_problem` text NOT NULL DEFAULT '',
                `expected_results` text NOT NULL DEFAULT '',
                `protocol` text NOT NULL DEFAULT '',
                `date_created` int(11) NOT NULL,
                `date_modified` int(11) NOT NULL,
                `image_url` text NOT NULL,
		PRIMARY KEY (`id`)
		);";
		$this->runRequest($sql);
                
                $sqlju = "CREATE TABLE IF NOT EXISTS `nt_j_project_user` (
		`id_project` int(11) NOT NULL,
                `id_user` int(11) NOT NULL,
                `id_role` int(11) NOT NULL
		);";
		$this->runRequest($sqlju);
                
                $sqljp = "CREATE TABLE IF NOT EXISTS `nt_j_project_group` (
		`id_project` int(11) NOT NULL,
                `id_group` int(11) NOT NULL,
                `id_role` int(11) NOT NULL
		);";
		$this->runRequest($sqljp);
                
                $sqljd = "CREATE TABLE IF NOT EXISTS `nt_j_projects_data` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
                `id_project` int(11) NOT NULL,
                `data_url` text NOT NULL DEFAULT '',
		PRIMARY KEY (`id`)
		);";
		$this->runRequest($sqljd);
                
                $sqljc = "CREATE TABLE IF NOT EXISTS `nt_j_project_comment` (
		`id_project` int(11) NOT NULL,
                `id_comment` int(11) NOT NULL
		);";
		$this->runRequest($sqljc);
		
	}
        
        public function setUserToProject($id_project, $id_user, $id_role){
            if ($this->isUserToProject($id_project, $id_user)){
                $sql = "UPDATE nt_j_project_user SET id_role=? WHERE id_project=? AND id_user=?";
                $this->runRequest($sql, array($id_role, $id_project, $id_user));
            }
            else{
                $sql = "INSERT INTO nt_j_project_user (id_project, id_user, id_role) VALUES(?, ?, ?)";
                $this->runRequest($sql, array($id_project, $id_user, $id_role));
            }
        }
        
        public function isUserToProject($id_project, $id_user){
            $sql = "SELECT * FROM nt_j_project_user WHERE id_project=? AND id_user=?";
            $req = $this->runRequest($sql, array($id_project, $id_user));
            if ($req->rowCount() == 1){
                return true;
            }
            return false;
        }
        
        public function getDefault(){
            return array("id" => "",
                "name"  => "",
                "adressed_problem"  => "",
                "expected_results"  => "",
                "protocol"  => "",
                "date_created"  => "",
                "date_modified"  => "",
                "image_url"  => "");
        }
        
        public function getUsers($id_project){
            $sql = "SELECT user.id AS id, user.name AS name, user.firstname AS firstname, 
			groupj.id_role AS id_role, ntroles.name as role
                    FROM nt_j_project_user AS groupj
    			INNER JOIN core_users AS user ON groupj.id_user = user.id
                        INNER JOIN nt_roles AS ntroles ON groupj.id_role = ntroles.id
    			WHERE groupj.id_project=" . $id_project . "
    			ORDER BY groupj.id_role DESC, user.name;";
            return $this->runRequest($sql);
        }
        
        public function addData($id_project, $data_url){
            $sql = "INSERT INTO nt_j_projects_data (id_project, data_url) VALUES (?, ?)";
            $this->runRequest($sql, array($id_project, $data_url));
            return $this->getDatabase()->lastInsertId();
        }
        
        public function getData($id_project){
            $sql = "SELECT * FROM nt_j_projects_data WHERE id_project=?";
            return $this->runRequest($sql, array($id_project));
        }
	
        public function getAllComments($id_project){
            $sql = "SELECT comment.*, user.name as authorname, user.firstname as authorfirstname "
                    . "FROM nt_comments as comment "
                    . "INNER JOIN core_users AS user ON comment.id_author = user.id "
                    . "WHERE comment.id IN (SELECT id_comment FROM nt_j_project_comment WHERE id_project=?) ORDER BY unix_date DESC;";
            return $this->runRequest($sql, array($id_project))->fetchAll();
        }
        
        public function setCommentToProject($id_project, $id_comment){
            if ($this->isCommentToProject($id_project, $id_comment)){
                $sql = "UPDATE nt_j_project_comment SET id_project=? WHERE id_comment=?";
                $this->runRequest($sql, array($id_comment, $id_project));
            }
            else{
                $sql = "INSERT INTO nt_j_project_comment (id_project, id_comment) VALUES(?, ?)";
                $this->runRequest($sql, array($id_project, $id_comment));
            }
        }
        
        public function isCommentToProject($id_project, $id_comment){
            $sql = "SELECT * FROM nt_j_project_comment WHERE id_project=? AND id_comment=?";
            $req = $this->runRequest($sql, array($id_project, $id_comment));
            if ($req->rowCount() == 1){
                return true;
            }
            return false;
        }
        
        public function removeUserFromProject($id_project, $id_user){
            $sql="DELETE FROM nt_j_project_user WHERE id_project=? AND id_user=?";
            $this->runRequest($sql, array($id_project, $id_user));
        }
        
        public function getAll(){
            $sql = "SELECT * FROM nt_projects ORDER BY date_created";
            return $this->runRequest($sql)->fetchAll();
        }
       
	public function add($name, $adressed_problem, $expected_results, $protocol, $date_created){
            $date_modified = time();
            $sql = "INSERT INTO nt_projects (name, adressed_problem, expected_results, protocol, date_created, date_modified) VALUES(?, ?, ?, ?, ?, ?)";
            $this->runRequest($sql, array($name, $adressed_problem, $expected_results, $protocol, $date_created, $date_modified));
            return $this->getDatabase()->lastInsertId();
        }
        
        public function update($id, $name, $adressed_problem, $expected_results, $protocol, $date_created){
            $date_modified = time();
            $sql = "UPDATE nt_projects SET name=?, adressed_problem=?, expected_results=?, protocol=?, date_created=?, date_modified=? WHERE id=?";
            $this->runRequest($sql, array($name, $adressed_problem, $expected_results, $protocol, $date_created, $date_modified, $id));
            return $id;
        }
        
        public function setImageUrl($id, $image_url){
            $sql = "UPDATE nt_projects SET image_url=? WHERE id=?";
            $this->runRequest($sql, array($image_url, $id));
        }
        
        public function set($id, $name, $adressed_problem, $expected_results, $protocol, $date_created){
            if ($this->isEntry($id)){
                return $this->update($id, $name, $adressed_problem, $expected_results, $protocol, $date_created);
            }
            else{
                return $this->add($name, $adressed_problem, $expected_results, $protocol, $date_created);
            }
        }
        
        public function isUserProjectAdmin($id_project, $id_user){
            $sql = "SELECT * FROM nt_j_project_user WHERE id_project=? AND id_user=? AND id_role>1";
            $req = $this->runRequest($sql, array($id_project, $id_user));
            if ($req->rowCount() == 1){
                return true;
            }
            return false;
        }
        
        public function get($id){
            $sql = "SELECT * FROM nt_projects WHERE id=?";
            return $this->runRequest($sql, array($id))->fetch();
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