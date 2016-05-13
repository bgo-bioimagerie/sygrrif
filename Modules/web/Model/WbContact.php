<?php

require_once 'Framework/ModelAuto.php';

/**
 * Class defining the template table model. 
 *
 * @author Sylvain Prigent
 */
class WbContact extends Model {

	public function __construct() {
            
        }
	
        public function createTable(){
            
            $sql = "CREATE TABLE IF NOT EXISTS `wb_contact` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`name` varchar(150) NOT NULL DEFAULT '',
                `tel` varchar(150) NOT NULL DEFAULT '',
                `email` varchar(150) NOT NULL DEFAULT '',
                `content` text NOT NULL DEFAULT '',
		PRIMARY KEY (`id`)
		);";
		
            $this->runRequest($sql);
            
        }
        
        public function get(){
            $sql = "SELECT * FROM wb_contact";
            return $this->runRequest($sql)->fetch();
        }
        
        public function insert($name, $tel, $email, $content){
            $sql = "INSERT INTO wb_contact (name, tel, email, content) VALUES (?, ?, ?, ?)";
            $this->runRequest($sql, array($name, $tel, $email, $content));
            return $this->getDatabase()->lastInsertId();
        }
        
        public function update($id, $name, $tel, $email, $content){
            $sql = "UPDATE wb_contact SET name=?, tel=?, email=?, content=? WHERE id=?";
            $this->runRequest($sql, array($name, $tel, $email, $content, $id));
        }
        
        public function exists($id){
            $sql = "SELECT id FROM wb_contact WHERE id=?";
            $req = $this->runRequest($sql, array($id));
            if ($req->rowCount() == 1){
                return true;
            }
            return false;
        }
       
        public function set($id, $name, $tel, $email, $content){
            if ($this->exists($id)){
                $this->update($id, $name, $tel, $email, $content);
                return $id;
            }
            else{
                return $this->insert($name, $tel, $email, $content);
            }
        }
        
        public function delete($id){
            $sql = "DELETE FROM wb_articles WHERE id=?";
            $this->runRequest($sql, array($id));
        }
}