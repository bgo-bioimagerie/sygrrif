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
                    `id` INT(11) NOT NULL AUTO_INCREMENT,
                    `id_proj` INT(11) NOT NULL ,
                    `id_in_proj` INT(11) NOT NULL ,
                    `name` VARCHAR(100) NOT NULL,
                    `origin_url` VARCHAR(500) NOT NULL,
                    PRIMARY KEY (`id`)
                    );";
            $this->runRequest($sqlm);       
            
            $sqls = "CREATE TABLE IF NOT EXISTS `bi_subcols` (
                    `id` INT(11) NOT NULL AUTO_INCREMENT,
                    `id_proj` INT(11) NOT NULL,
                    `id_in_proj` INT(11) NOT NULL ,
                    `name` VARCHAR(100) NOT NULL,
                    `id_main_col` INT(11) NOT NULL ,
                    `datatype` VARCHAR(100) NOT NULL,
                    `content` VARCHAR(1500) NOT NULL,
                    PRIMARY KEY (`id`)
                    );";
            $this->runRequest($sqls); 
            
            $sqlp = "CREATE TABLE IF NOT EXISTS `bi_projdata` (
                    `id` INT(11) NOT NULL AUTO_INCREMENT,
                    `id_proj` INT(11) NOT NULL,
                    `line_idx` INT(11) NOT NULL ,
                    `url` VARCHAR(500) NOT NULL,
                    `thumbnail_url` VARCHAR(500) NOT NULL,
                    `id_main_col` INT(11) NOT NULL ,
                    `id_sub_col` INT(11) NOT NULL,
                    PRIMARY KEY (`id`)
                    );";
            $this->runRequest($sqlp); 
   
	}
	
        public function tags($id){
            $sql = "SELECT * FROM bi_subcols WHERE id_proj=? AND datatype='tag'";
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
        
        
        
        public function setProjectTags($idProject, $tags_name, $tags_content, $mainColId){

            // add the tags
            for($i = 0 ; $i < count($tags_name) ; $i++){
                $sql = "INSERT INTO bi_subcols (id_proj, id_in_proj, name, id_main_col, datatype, content) VALUES(?,?,?,?,?,?)";
                $this->runRequest($sql, array($idProject, 0, $tags_name[$i], $mainColId, "tag", $tags_content[$i]));
            }
        }
        
        public function addMainColumn($id_proj, $name, $origin_url = ""){
            $sql = "INSERT INTO bi_maincols (id_proj, id_in_proj, name, origin_url) VALUES(?,?,?,?)";
            $this->runRequest($sql, array($id_proj, 0, $name, $origin_url)); 
            return $this->getDatabase()->lastInsertId();
        }
        
        public function setMainColumnOrigin($id_proj, $originUrl){
            $sql = "UPDATE bi_maincols SET origin_url=? WHERE id=?";
            $this->runRequest($sql, array($originUrl, $id_proj));
        }
        
        public function createDataColumnIfNotExists($idProject){
            $sqle = "SELECT * FROM bi_maincols WHERE name='Data' AND id_proj=?";
            $req = $this->runRequest($sqle, array($idProject));
            if ($req->rowCount() == 1){
                $idMainCol = $req->fetch();
                return $idMainCol["id"];
            }
            else{
                $sql = "INSERT INTO bi_maincols (id_proj, id_in_proj, name, origin_url) VALUES(?,?,?,?)";
                $this->runRequest($sql, array($idProject, 0, "Data", "Data")); 
                return $this->getDatabase()->lastInsertId();
            }
        }
        
        public function createDataSubColumnIfNotExists($idProject, $id_main_col){
            $sqle = "SELECT id FROM bi_subcols WHERE name='Data' AND id_proj=? AND id_main_col=?";
            $req = $this->runRequest($sqle, array($idProject, $id_main_col));
            if ($req->rowCount() == 1){
                $idSubCol = $req->fetch();
                return $idSubCol[0];
            }
            else{
                $sql = "INSERT INTO bi_subcols (id_proj, id_in_proj, name, id_main_col, datatype, content) VALUES(?,?,?,?,?,?)";
                $this->runRequest($sql, array($idProject, 0, "Data", $id_main_col, "Data", "")); 
                return $this->getDatabase()->lastInsertId();
            }
        }
        
        public function addSubColumn($id_proj, $name, $id_main_col, $datatype){
            $sql = "INSERT INTO bi_subcols (id_proj, id_in_proj, name, id_main_col, datatype, content) VALUES(?,?,?,?,?,?)";
            $this->runRequest($sql, array($id_proj, 0, $name, $id_main_col, $datatype, "")); 
            return $this->getDatabase()->lastInsertId();
        }
        
        
        public function addData($id_proj, $line_idx, $url, $thumbnail_url, $id_main_col, $id_sub_col){
            
            $sql = "INSERT INTO bi_projdata (id_proj, line_idx, url, thumbnail_url, id_main_col, id_sub_col) VALUES(?,?,?,?,?,?)";
            $this->runRequest($sql, array($id_proj, $line_idx, $url, $thumbnail_url, $id_main_col, $id_sub_col));
            return $this->getDatabase()->lastInsertId();
        }
        
        public function editData($id, $id_proj, $line_idx, $url, $thumbnail_url, $id_main_col, $id_sub_col){
            
            $sql = "UPDATE bi_projdata set id_proj=?, line_idx=?, url=?, thumbnail_url=?, id_main_col=?, id_sub_col=? where id=?";
            $this->runRequest($sql, array($id_proj, $line_idx, $url, $thumbnail_url, $id_main_col, $id_sub_col, $id));
        }
        
        public function getMainColumnId($id_proj){
            $sqle = "SELECT id FROM bi_maincols WHERE name='Data' AND id_proj=?";
            $req = $this->runRequest($sqle, array($id_proj));
            if ($req->rowCount() == 1){
                $idMainCol = $req->fetch();
                return $idMainCol[0];
            }
            return 0;
        }
        
        public function getSubColumnDataId($id_proj, $id_main_col){
            $sqle = "SELECT id FROM bi_subcols WHERE name='Data' AND id_proj=? AND id_main_col=?";
            $req = $this->runRequest($sqle, array($id_proj, $id_main_col));
            if ($req->rowCount() == 1){
                $idMainCol = $req->fetch();
                return $idMainCol[0];
            }
            return 0;
        }
        
        public function getMainColumns($id_proj, $calculateSubColNum = false){
            $sqle = "SELECT * FROM bi_maincols WHERE id_proj=?";
            $req = $this->runRequest($sqle, array($id_proj));
            $cols = $req->fetchAll();
            
            if ($calculateSubColNum){
                for($i = 0 ; $i < count($cols) ; $i++){
                    $cols[$i]["num_sub_col"] = $this->countSubCol($cols[$i]['id']);
                }
            }
            return $cols;
        }
        
        public function countSubCol($mainColId){
            $sql = "SELECT * FROM bi_subcols WHERE id_main_col=?";
            $req = $this->runRequest($sql, array($mainColId));
            return $req->rowCount();
        }
        
        public function getSubColumns($id_proj){
            $sqle = "SELECT * FROM bi_subcols WHERE id_proj=?";
            $req = $this->runRequest($sqle, array($id_proj));
            return $req->fetchAll();
            
        }
        
        public function getData($id_proj){
            $sqle = "SELECT * FROM bi_projdata WHERE id_proj=?";
            $req = $this->runRequest($sqle, array($id_proj));
            return $req->fetchAll();
        }
        
        public function getProjectLineIdxs($id_proj){
            $sqle = "SELECT DISTINCT line_idx FROM bi_projdata WHERE id_proj=? ORDER BY line_idx ASC;";
            $req = $this->runRequest($sqle, array($id_proj));
            return $req->fetchAll();
        }
        
        public function getLastLineIdx($id_proj){
            $sqle = "SELECT DISTINCT line_idx FROM bi_projdata WHERE id_proj=? ORDER BY line_idx DESC;";
            $req = $this->runRequest($sqle, array($id_proj));
            if ($req->rowCount() == 0){
                return 0;
            }
            $tmp = $req->fetch();
            return $tmp[0];
        }
        
        public function getLineData($id_proj, $id_subCol, $lineIdx){
            $sqle = "SELECT * FROM bi_projdata WHERE id_proj=? AND id_sub_col=? AND line_idx=?";
            $req = $this->runRequest($sqle, array($id_proj, $id_subCol, $lineIdx));
            $tmp = $req->fetch();
            return $tmp;
        }
        
        public function getSubColumnsForProcess($id_proj){
            $sql = "SELECT * FROM bi_subcols WHERE id_proj=? AND datatype!='tag'";
            $req = $this->runRequest($sql, array($id_proj));
            $cols = $req->fetchAll();
            
            for($i=0 ; $i < count($cols) ; $i++){
                $sql = "SELECT name FROM bi_maincols WHERE id=?";
                $req = $this->runRequest($sql, array($cols[$i]["id_main_col"]));
                $name = $req->fetch();
                $cols[$i]["fullname"] = $name[0] . ":" . $cols[$i]["name"];
            }
            return $cols;
        }
        
        public function getTagsForProcess($id_proj){
            $sql = "SELECT * FROM bi_subcols WHERE id_proj=? AND datatype='tag'";
            $req = $this->runRequest($sql, array($id_proj));
            return $req->fetchAll();
        }
        
        public function getSubColumnsDataList($id_proj, $id_sub_col){
            $sql = "SELECT * FROM bi_projdata WHERE id_proj=? AND id_sub_col=?";
            $req = $this->runRequest($sql, array($id_proj, $id_sub_col));
            return $req->fetchAll();
        }
        /*
        public function delete($id){
            $sql="DELETE FROM bi_projects WHERE id = ?";
            $this->runRequest($sql, array($id));
        }
         */
                
}