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
				PRIMARY KEY (`id`)
				);";
		
		$pdo = $this->runRequest($sql);
		return $pdo;
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
	
	public function getProtocolsNo(){
			
		$sql = "select distinct no_proto from ac_protocol order by no_proto ASC;";
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
	public function addProtocol($kit, $no_proto, $proto, $fixative, $option, $enzyme, $dem, $acl_inc, $linker, $inc, $acll, $inc2){		
		
		//, `no_proto`, proto, fixative, option, enzyme, dem, `acl_inc`, linker, inc, acll
		// ,?,?,?,?,?,?,?,?,?,?,?
		$sql = "insert into ac_protocol(kit, no_proto, proto, fixative, option_, enzyme, dem, acl_inc, linker, inc, acll, inc2)"
				. " values(?,?,?,?,?,?,?,?,?,?,?,?)";
		
		$this->runRequest($sql, array($kit, $no_proto, $proto, $fixative, $option , $enzyme, $dem, $acl_inc, $linker, $inc, $acll, $inc2));
	}
	
	/**
	 * update the information of a isotype
	 *
	 * @param int $id Id of the isotype to update
	 * @param string $name New name of the isotype
	 */
	public function editProtocol($id, $kit, $no_proto, $proto, $fixative, $option, $enzyme, $dem, $acl_inc, $linker, $inc, $acll, $inc2){
	
		$sql = "update ac_protocol set kit=?, no_proto=?, proto=?, fixative=?, option=?, enzyme=?, dem=?, acl_inc=?, linker=?, inc=?, acll=?, inc2=? where id=?";
		$this->runRequest($sql, array($kit, $no_proto, $proto, $fixative, $option, $enzyme, $dem, $acl_inc, $linker, $inc, $acll, $inc2, $id));
	}
	
}