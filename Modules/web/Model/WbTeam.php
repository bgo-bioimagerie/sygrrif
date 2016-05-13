<?php

require_once 'Framework/ModelAuto.php';

/**
 * Class defining the template table model. 
 *
 * @author Sylvain Prigent
 */
class WbTeam extends Model {

	public function __construct() {
            
        }
	
        public function createTable(){
            
            $sql = "CREATE TABLE IF NOT EXISTS `wb_team` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`name` varchar(150) NOT NULL DEFAULT '',
                `job` text NOT NULL DEFAULT '',
                `tel` varchar(150) NOT NULL DEFAULT '',
                `email` varchar(150) NOT NULL DEFAULT '',
                `misc` text NOT NULL DEFAULT '',
                `image_url` text NOT NULL DEFAULT '',
		PRIMARY KEY (`id`)
		);";
		
            $this->runRequest($sql);
        }
        
        public function setImage($id, $url){
            $sql = "UPDATE wb_team SET image_url=? WHERE id=?";
            $this->runRequest($sql, array($url, $id));
        }
        
        public function get($id){
            $sql = "SELECT * FROM wb_team WHERE id=?";
            return $this->runRequest($sql, array($id))->fetch();
        }
        
        public function selectAll(){
            $sql = "SELECT * FROM wb_team";
            return $this->runRequest($sql)->fetchAll();
        }
        
        public function insert($name, $job, $tel, $email, $misc){
            $sql = "INSERT INTO wb_team (name, job, tel, email, misc) VALUES (?, ?, ?, ?, ?)";
            $this->runRequest($sql, array($name, $job, $tel, $email, $misc));
            return $this->getDatabase()->lastInsertId();
        }
        
        public function update($id, $name, $job, $tel, $email, $misc){
            $sql = "UPDATE wb_team SET name=?, job=?, tel=?, email=?, misc=? WHERE id=?";
            $this->runRequest($sql, array($name, $job, $tel, $email, $misc, $id));
        }
        
        public function exists($id){
            $sql = "SELECT id FROM wb_team WHERE id=?";
            $req = $this->runRequest($sql, array($id));
            if ($req->rowCount() == 1){
                return true;
            }
            return false;
        }
       
        public function set($id, $name, $job, $tel, $email, $misc){
            if ($this->exists($id)){
                $this->update($id, $name, $job, $tel, $email, $misc);
                return $id;
            }
            else{
                return $this->insert($name, $job, $tel, $email, $misc);
            }
        }
        
        public function delete($id){
            $sql = "DELETE FROM wb_team WHERE id=?";
            $this->runRequest($sql, array($id));
        }
}