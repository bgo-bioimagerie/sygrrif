<?php

require_once 'Framework/Model.php';

/**
 * Class defining the template table model. 
 *
 * @author Sylvain Prigent
 */
class NtData extends Model {

	public function createTable(){
            $sql = "CREATE TABLE IF NOT EXISTS `nt_data` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `url` varchar(300) NOT NULL DEFAULT '',
            `type` varchar(150) NOT NULL DEFAULT 1,
            `id_stream` int(11) NOT NULL DEFAULT 1,
            `date` DATE NOT NULL,
            PRIMARY KEY (`id`)
            );";

            $pdo = $this->runRequest($sql);
            return $pdo;
	}
	
	public function add($url, $type, $id_stream, $date){
            $sql = "INERT INTO nt_data (url, type, id_stream, date) VALUES(?, ?, ?, ?)";
            $this->runRequest($sql, array($url, $type, $id_stream, $date));
            return $this->getDatabase()->lastInsertId();
        }
        
        public function update($id, $url, $type, $id_stream, $date){
            $sql = "UPDATE nt_data SET url=?, type=?, id_stream=?, date=? WHERE id=?";
            $this->runRequest($sql, array($url, $type, $id_stream, $date, $id));
            return $id;
        }
        
        public function set($id, $url, $type, $id_stream, $date){
            if ($this->isEntry($id)){
                return $this->update($id, $url, $type, $id_stream, $date);
            }
            else{
                return $this->add($url, $type, $id_stream, $date);
            }
        }
        
        public function isEntry($id){
            $sql = "SELECT * FROM nt_data WHERE id=?";
            $req = $this->runRequest($sql, array($id));
            if ($req->rowCount() == 1){
                return true;
            }
            return false;
        }
        
        public function delete($id){
            $sql="DELETE FROM nt_data WHERE id = ?";
            $this->runRequest($sql, array($id));
        } 
}