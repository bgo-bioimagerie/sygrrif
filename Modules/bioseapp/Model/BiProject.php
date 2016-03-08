<?php

require_once 'Framework/Model.php';

/**
 * Class defining the template table model. 
 *
 * @author Sylvain Prigent
 */
class BiProject extends Model {

	public function createTable(){
		$sql = "CREATE TABLE IF NOT EXISTS `bi_projects` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
                `name` varchar(50) NOT NULL,
                `desc` text NOT NULL,                
                `id_owner` int(11) NOT NULL,
                PRIMARY KEY (`id`)
		);";

		$this->runRequest($sql);
	}
	
        public function all(){
            $sql = "SELECT * FROM bi_projects";
            return $this->runRequest($sql)->fetchAll();
        }
        
        public function set($id, $name, $desc, $id_owner){
            if(!$this->isProject($id)){
                return $this->add($name, $desc, $id_owner);
            }
            else{
                return $this->edit($id, $name, $desc, $id_owner);
            }
        }
        
        public function isProject($id){
            $sql = "select * from bi_projects where id=?";
            $unit = $this->runRequest($sql, array($id));
            if ($unit->rowCount() == 1){
                return true;
            }
            else{
                return false;
            }
        }
                
        
	public function add($name, $desc, $id_owner){
            $sql = "INSERT INTO bi_projects(`name`, `desc`, `id_owner`) VALUES(?,?,?)";
            $this->runRequest($sql, array($name, $desc, $id_owner));
            return $this->getDatabase()->lastInsertId();
        }
        
        public function edit($id, $name, $desc, $id_owner){
            $sql = "update bi_projects set name=?, `desc`=?, id_owner=? where id=?";
            $this->runRequest($sql, array($name, $desc, $id_owner, $id));
            return $id;
        }
        
        public function delete($id){
            $sql="DELETE FROM bi_projects WHERE id = ?";
            $this->runRequest($sql, array($id));
        }
                
}