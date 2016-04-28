<?php

require_once 'Framework/Model.php';

/**
 * Class defining the template table model. 
 *
 * @author Sylvain Prigent
 */
class NtComment extends Model {

	public function createTable(){
            $sql = "CREATE TABLE IF NOT EXISTS `nt_comments` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `text` text NOT NULL DEFAULT '',	
            `id_author` int(11) NOT NULL DEFAULT 1,
            `date` DATE NOT NULL,
            PRIMARY KEY (`id`)
            );";

            $pdo = $this->runRequest($sql);
            return $pdo;
	}
	
	public function add($text, $id_author, $date){
            $sql = "INERT INTO nt_comments (text, id_author, date) VALUES(?, ?, ?)";
            $this->runRequest($sql, array($text, $id_author, $date));
            return $this->getDatabase()->lastInsertId();
        }
        
        public function update($id, $text, $id_author, $date){
            $sql = "UPDATE nt_comments SET text=?, id_author=?, date=? WHERE id=?";
            $this->runRequest($sql, array($text, $id_author, $date, $id));
            return $id;
        }
        
        public function set($id, $text, $id_author, $date){
            if ($this->isEntry($id)){
                return $this->update($id, $text, $id_author, $date);
            }
            else{
                return $this->add($text, $id_author, $date);
            }
        }
        
        public function isEntry($id){
            $sql = "SELECT * FROM nt_comments WHERE id=?";
            $req = $this->runRequest($sql, array($id));
            if ($req->rowCount() == 1){
                return true;
            }
            return false;
        }
        
        public function delete($id){
            $sql="DELETE FROM nt_comments WHERE id = ?";
            $this->runRequest($sql, array($id));
        } 
}