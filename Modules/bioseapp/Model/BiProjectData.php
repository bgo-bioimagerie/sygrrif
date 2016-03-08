<?php

require_once 'Framework/Model.php';

/**
 * Class defining the template table model. 
 *
 * @author Sylvain Prigent
 */
class BiProjectData extends Model {

	public function createTable(){
	        
            $sqlm = "CREATE TABLE IF NOT EXISTS `bi_maincols` (
                    `id_proj` INT(11) NOT NULL ,
                    `id_in_proj` INT(11) NOT NULL ,
                    `name` VARCHAR(100) NOT NULL,
                    `origin_url` VARCHAR(500) NOT NULL
                    );";
            $this->runRequest($sqlm);       
            
            $sqls = "CREATE TABLE IF NOT EXISTS `bi_subcols` (
                    `id_proj` INT(11) NOT NULL,
                    `id_in_proj` INT(11) NOT NULL ,
                    `name` VARCHAR(100) NOT NULL,
                    `id_main_col` INT(11) NOT NULL ,
                    `datatype` VARCHAR(100) NOT NULL
                    );";
            $this->runRequest($sqls); 
            
            $sqlp = "CREATE TABLE IF NOT EXISTS `bi_projdata` (
                    `id_proj` INT(11) NOT NULL,
                    `line_idx` INT(11) NOT NULL ,
                    `url` VARCHAR(500) NOT NULL,
                    `thumbnail_url` VARCHAR(500) NOT NULL,
                    `id_main_col` INT(11) NOT NULL ,
                    `id_sub_col` INT(11) NOT NULL
                    );";
            $this->runRequest($sqlp); 
    
            $sqlt = "CREATE TABLE IF NOT EXISTS `bi_projtags` (
                    `id_proj` INT(11) NOT NULL,
                    `key` VARCHAR(100) NOT NULL ,
                    `content` VARCHAR(1500) NOT NULL
                    );";
            $this->runRequest($sqlt); 

	}
	
        public function tags($id){
            $sql = "SELECT * FROM bi_projtags WHERE id_proj=?";
            $req = $this->runRequest($sql, array($id));
            return $req->fetchAll();
        }
        
        
        public function getDefaultInfo(){
            $project["id"] = "";
            $project["name"] = "";
            $project["desciption"] = "";
        }
        
        public function getInfo($id){
            $sql = "SELECT * from bi_projects WHERE id=?";
            $project = $this->runRequest($sql, array($id))->fetchAll();
            return $project[0];
        } 
        
        
        
        public function setProjectTags($idProject, $tags_name, $tags_content){
            // remove all the project tags
            $sql="DELETE FROM bi_projtags WHERE id_proj = ?";
            $this->runRequest($sql, array($idProject));
            
            // add the tags
            for($i = 0 ; $i < count($tags_name) ; $i++){
                $sql = "INSERT INTO bi_projtags (id_proj, `key`, content) VALUES(?,?,?)";
                $this->runRequest($sql, array($idProject, $tags_name[$i], $tags_content[$i]));
            }
        }
        
        
        
        
        
        
        
        public function all(){
            $sql = "SELECT * FROM bi_projects";
            return $this->runRequest($sql)->fetchAll();
        }
        
	public function add($name, $id_owner, $icon_url, $desc, $id_type){
            $sql = "INSERT INTO bi_projects (name, id_owner, icon_url, desc, id_type) VALUES(?,?,?,?,?)";
            $this->runRequest($sql, array($name, $id_owner, $icon_url, $desc, $id_type));
        }
        
        public function edit($id, $name, $id_owner, $icon_url, $desc, $id_type){
            $sql = "update bi_projects set name=?, id_owner=?, icon_url=?, desc=?, id_type=? where id=?";
            $this->runRequest($sql, array($name, $id_owner, $icon_url, $desc, $id_type, $id));
        }
        
        public function delete($id){
            $sql="DELETE FROM bi_projects WHERE id = ?";
            $this->runRequest($sql, array($id));
        }
                
}