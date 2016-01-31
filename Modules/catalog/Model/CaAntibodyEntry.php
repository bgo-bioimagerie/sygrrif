<?php

require_once 'Framework/Model.php';
require_once 'Modules/anticorps/Model/Espece.php';
require_once 'Modules/anticorps/Model/Tissus.php';
/**
 * Class defining the template table model. 
 *
 * @author Sylvain Prigent
 */
class CaAntibodyEntry extends Model {

	public function createTable(){
            $sql = "CREATE TABLE IF NOT EXISTS `ca_entries_antibodies` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `id_antibody` int(11) NOT NULL,
                    `ranking` varchar(400) NOT NULL,
                    `staining` varchar(400) NOT NULL,
                    `image_url` varchar(300) NOT NULL,
                    PRIMARY KEY (`id`)
		);";

		$this->runRequest($sql);
                
                // add columns if no exists
		$sql2 = "SHOW COLUMNS FROM `ca_entries_antibodies` LIKE 'image_url'";
		$pdo = $this->runRequest($sql2);
		$isColumn = $pdo->fetch();
		if ( $isColumn == false){
			$sql3 = "ALTER TABLE `ca_entries_antibodies` ADD `image_url` varchar(300) NOT NULL";
			$pdo = $this->runRequest($sql3);
		}
	}
	
	public function add($id_antibody, $ranking, $staining){ 
		$sql = "INSERT INTO ca_entries_antibodies(id_antibody, ranking, staining) VALUES(?,?,?)";
		$this->runRequest($sql, array($id_antibody, $ranking, $staining));
		return $this->getDatabase()->lastInsertId();
	}
	
	public function setImageUrl($id, $url){
		$sql = "update ca_entries_antibodies set image_url=? where id=?";
		$this->runRequest($sql, array($url, $id));
	}
	
	public function edit($id, $id_antibody, $ranking, $staining){
		$sql = "update ca_entries_antibodies set id_antibody=?, ranking=?, staining=? where id=?";
		$this->runRequest($sql, array($id_antibody, $ranking, $staining, $id));
	}
	
	public function getAll(){
		$sql = "SELECT * FROM ca_entries_antibodies";
		$req = $this->runRequest($sql);
		return $req->fetchAll();
	}
        
        public function getAllInfo(){
            
            $ac = $this->getAll();
          
            //$isotypeModel = new Isotype();
            //$sourceModel = new Source();
            $tissusModel = new Tissus();
            for ($i = 0 ; $i < count($ac) ; $i++){
                
                // antibody informations
                $sql1 = "SELECT * FROM ac_anticorps WHERE id=?";
                $infosReq = $this->runRequest($sql1, array($ac[$i]["id_antibody"]));
                $infos = $infosReq->fetchAll();
                $ac[$i]["no_h2p2"] = $infos[0]["no_h2p2"];
                $ac[$i]["nom"] = $infos[0]["nom"];
                $ac[$i]["fournisseur"] = $infos[0]["fournisseur"];
                $ac[$i]["reference"] = $infos[0]["reference"];
                
                // tissus
		$ac[$i]['tissus'] = $tissusModel->getTissusCatalog($ac[$i]['id']);
            }
            return $ac;
      
	}
	
	public function getInfo($id){
		$sql = "SELECT * FROM ca_entries_antibodies WHERE id=?";
		$req = $this->runRequest($sql, array($id));
		$inter = $req->fetch();
		return $inter;
	}
	
        public function importAll(){
            
            $sql = "SELECT id FROM ac_anticorps";
            $req = $this->runRequest($sql);
            $antibodies = $req->fetchAll();
                
            foreach($antibodies as $ac){
                if (!$this->isAntibody($ac["id"])){
                    $this->add($ac["id"], "", "");
                }
            }
        }
        
        public function isAntibody($id){
		$sql = "select * from ca_entries_antibodies where id=?";
		$unit = $this->runRequest($sql, array($id));
		if ($unit->rowCount() == 1){
			return true;
                }
		else{
			return false;
                }
	}
        
	/**
	 * Delete a category
	 * @param number $id Entry ID
	 */
	public function delete($id){
		$sql="DELETE FROM ca_entries_antibodies WHERE id = ?";
		$this->runRequest($sql, array($id));
	}
}