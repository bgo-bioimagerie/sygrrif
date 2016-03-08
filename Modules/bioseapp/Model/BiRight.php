<?php

require_once 'Framework/Model.php';

/**
 * Class defining the user rights for the projects. 
 *
 * @author Sylvain Prigent
 */
class BiRight extends Model {

	public function createTable(){
		$sql = "CREATE TABLE IF NOT EXISTS `bi_rights` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
                `name` varchar(50) NOT NULL,
                PRIMARY KEY (`id`)
		);";

		$this->runRequest($sql);
	}
	
	public function add($name){
            $sql = "INSERT INTO bi_rights (name) VALUES(?)";
            $this->runRequest($sql, array($name));
        }
        
        public function edit($id, $name){
            $sql = "update bi_rights set name=? where id=?";
            $this->runRequest($sql, array($name, $id));
        }
        
        public function delete($id){
            $sql="DELETE FROM bi_rights WHERE id = ?";
            $this->runRequest($sql, array($id));
        }
             
        public function exists($id){
            $sql = "select * from bi_rights where id=?";
            $req = $this->runRequest($sql, array($id));
            if ($req->rowCount() == 1){
                return true;
            }
            else{
                return false;
            }
        }
        
        public function createDefault(){
	
            if (!$this->exists(1)){
                $this->add("Read");
            }
            if (!$this->exists(2)){
                $this->add("Read & Write");
            }
            
	}
}