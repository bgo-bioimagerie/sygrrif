<?php

require_once 'Framework/Model.php';

/**
 * Class defining the Isotype model
 *
 * @author Sylvain Prigent
 */
class AcProtocol extends Model {

	/**
	 * Create the protocols table
	 * 
	 * @return PDOStatement
	 */
	public function createTable(){
	
		$sql = "CREATE TABLE IF NOT EXISTS `ac_protocol` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`kit` varchar(30) NOT NULL,
				`no_proto` varchar(30) NOT NULL,
				`proto` varchar(30) NOT NULL,
				`fixative` varchar(30) NOT NULL,
				`option_` varchar(30) NOT NULL,
				`enzyme` varchar(30) NOT NULL,
				`dem` varchar(30) NOT NULL,
				`acl_inc` varchar(30) NOT NULL,
				`linker` varchar(30) NOT NULL,
				`inc` varchar(30) NOT NULL,
				`acll` varchar(30) NOT NULL,
				`inc2` varchar(30) NOT NULL,
				`associe` int(1) NOT NULL,
				PRIMARY KEY (`id`)
				);";
		
		$pdo = $this->runRequest($sql);
		return $pdo;
	}
	
	public function addManualProtocol(){

		$kit = "Manuel";
		$no_proto = 0;
		$proto = "";
		$fixative = ""; 
		$option = "";
		$enzyme = ""; 
		$dem = "";
		$acl_inc = "";
		$linker = "";
		$inc = "";
		$acll = "";
		$inc2 = "";
		$associe = "";
		$sql = "insert into ac_protocol(kit, no_proto, proto, fixative, option_, enzyme, dem, acl_inc, linker, inc, acll, inc2, associe)"
				. " values(?,?,?,?,?,?,?,?,?,?,?,?,?)";
		
		$this->runRequest($sql, array($kit, $no_proto, $proto, $fixative, $option , $enzyme, $dem, $acl_inc, $linker, $inc, $acll, $inc2, $associe));
		
	}
	
	/**
	 * get protocols informations
	 *
	 * @param string $sortentry Entry that is used to sort the isotypes
	 * @return multitype: array
	 */
	public function getProtocols($sortentry = 'id'){
			
		$sql = "select * from ac_protocol order by " . $sortentry . " ASC;";
		$user = $this->runRequest($sql);
		return $user->fetchAll();
	}
	
	public function getProtocols2($sortentry = 'id'){
			
		$sql = "select * from ac_protocol order by " . $sortentry . " ASC;";
		$req = $this->runRequest($sql);
		$protos = $req->fetchAll();
		
		return $this->getAssociateAnticorpsInfo($protos);
	}
	
	private function getAssociateAnticorpsInfo($protos){
		for ($i=0 ; $i < count($protos) ; $i++){
			if ($protos[$i]["associe"] == 1 ){
		
				$sql = "select id_anticorps from ac_j_tissu_anticorps where ref_protocol=?";
				$req = $this->runRequest($sql, array($protos[$i]["no_proto"]));
				$ac = $req->fetchAll();
		
				//print("ref protocol = " + $protos[$i]["id"] + "<br />");
				//print_r($ac);
		
				if ($req->rowCount() > 0){
						
					$sql = "select nom, no_h2p2 from ac_anticorps where id=?";
					$req = $this->runRequest($sql, array($ac[0]["id_anticorps"]));
					$acInfo = $req->fetch();
						
					$protos[$i]["anticorps"] = $acInfo["nom"];
					$protos[$i]["no_h2p2"] = $acInfo["no_h2p2"];
				}
				else{
					$protos[$i]["anticorps"] = "not found";
					$protos[$i]["no_h2p2"] = "not found";
				}
			}
			else{
				$protos[$i]["anticorps"] = "general";
				$protos[$i]["no_h2p2"] = 0;
			}
		}
		return $protos;
	}
	
	public function getProtocolsByRef($protocolRef){
		$sql = "select * from ac_protocol where no_proto=?";
		$req = $this->runRequest($sql, array($protocolRef));
		$protos = $req->fetchAll();
		
		return $this->getAssociateAnticorpsInfo($protos);
	}
	
	public function getProtocolsNo(){
			
		$sql = "select id, no_proto from ac_protocol order by no_proto ASC;";
		$user = $this->runRequest($sql);
		return $user->fetchAll();
	}
	
	/**
	 * get the informations of an protocol
	 *
	 * @param int $id Id of the isotype to query
	 * @throws Exception id the isotype is not found
	 * @return mixed array
	 */
	public function getProtocol($id){
		$sql = "select * from ac_protocol where id=?";
		$unit = $this->runRequest($sql, array($id));
		if ($unit->rowCount() == 1)
			return $unit->fetch();  
		else
			throw new Exception("Cannot find the protocol using the given id");
	}
	
	/**
	 * add a protocol to the table
	 *
	 * 
	 */
	public function addProtocol($kit, $no_proto, $proto, $fixative, $option, $enzyme, $dem, $acl_inc, $linker, $inc, $acll, $inc2, $associe = ""){		
		
		//, `no_proto`, proto, fixative, option, enzyme, dem, `acl_inc`, linker, inc, acll
		// ,?,?,?,?,?,?,?,?,?,?,?
		$sql = "insert into ac_protocol(kit, no_proto, proto, fixative, option_, enzyme, dem, acl_inc, linker, inc, acll, inc2, associe)"
				. " values(?,?,?,?,?,?,?,?,?,?,?,?,?)";
		
		$this->runRequest($sql, array($kit, $no_proto, $proto, $fixative, $option , $enzyme, $dem, $acl_inc, $linker, $inc, $acll, $inc2, $associe));
	}
	
	/**
	 * update the information of a isotype
	 *
	 * @param int $id Id of the isotype to update
	 * @param string $name New name of the isotype
	 */
	public function editProtocol($id, $kit, $no_proto, $proto, $fixative, $option, $enzyme, $dem, $acl_inc, $linker, $inc, $acll, $inc2, $associe = ""){
	
		$sql = "update ac_protocol set kit=?, no_proto=?, proto=?, fixative=?, option_=?, enzyme=?, dem=?, acl_inc=?, linker=?, inc=?, acll=?, inc2=?, associe=? where id=?";
		$this->runRequest($sql, array($kit, $no_proto, $proto, $fixative, $option, $enzyme, $dem, $acl_inc, $linker, $inc, $acll, $inc2, $associe, $id));
	}
	
	public function delete($id){
		$sql="DELETE FROM ac_protocol WHERE id = ?";
		$req = $this->runRequest($sql, array($id));
	}
	
	public function existsProtocol($kit, $no_proto){
		$sql = "select * from ac_protocol where kit=? and no_proto=?";
		$req = $this->runRequest($sql, array($kit, $no_proto));
		if ($req->rowCount() > 0){
			return true;
		}
		else{
			return false;
		}
	}
	
}