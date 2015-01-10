<?php

require_once 'Framework/Model.php';

/**
 * Class defining the SyColorCode model
 *
 * @author Sylvain Prigent
 */
class SyColorCode extends Model {

	/**
	 * Create the SyColorCode table
	 * 
	 * @return PDOStatement
	 */
	public function createTable(){
			
		$sql = "CREATE TABLE IF NOT EXISTS `sy_color_codes` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`name` varchar(30) NOT NULL DEFAULT '',
		`color` varchar(6) NOT NULL DEFAULT '',
		PRIMARY KEY (`id`)
		);";
		
		$pdo = $this->runRequest($sql);
		return $pdo;
	}
	
	/**
	 * Create the default empty SyColorCode
	 * 
	 * @return PDOStatement
	 */
	public function createDefaultColorCode(){
	
		if(!$this->isColorCode("default", "dddddd")){
			$sql = "INSERT INTO sy_color_codes (name, color) VALUES(?,?)";
			$this->runRequest($sql, array("default", "dddddd"));
		}
		//INSERT INTO `membres` (`pseudo`, `passe`, `email`) VALUES("Pierre", SHA1("dupont"), "pierre@dupont.fr");
	}
	
	/**
	 * get SyColorCodes informations
	 * 
	 * @param string $sortentry Entry that is used to sort the SyColorCodes
	 * @return multitype: array
	 */
	public function getColorCodes($sortentry = 'id'){
		 
		$sql = "select * from sy_color_codes order by " . $sortentry . " ASC;";
		$user = $this->runRequest($sql);
		return $user->fetchAll();
	}
	
	public function getColorCode($id){
			
		$sql = "SELECT * FROM sy_color_codes WHERE id=?";
		$user = $this->runRequest($sql, array($id));
		return $user->fetch();
	}
	
	/**
	 * get the names of all the SyColorCodes
	 *
	 * @return multitype: array
	 */
	public function colorCodesName(){
			
		$sql = "select name from sy_color_codes";
		$SyColorCodes = $this->runRequest($sql);
		return $SyColorCodes->fetchAll();
	}
	
	/**
	 * Get the SyColorCodes ids and names
	 *
	 * @return array
	 */
	public function colorCodesIDName(){
			
		$sql = "select id, name from sy_color_codes";
		$SyColorCodes = $this->runRequest($sql);
		return $SyColorCodes->fetchAll();
	}
	
	/**
	 * add a SyColorCode to the table
	 *
	 * @param string $name name of the SyColorCode
	 * @param string $address address of the SyColorCode
	 */
	public function addColorCode($name, $color){
		
		$sql = "insert into sy_color_codes(name, color)"
				. " values(?, ?)";
		$this->runRequest($sql, array($name, $color));		
	}
	
	public function importColorCode($id, $name, $color){
		
		$sql = "insert into sy_color_codes(id, name, color)"
				. " values(?, ?, ?)";
		$this->runRequest($sql, array($id, $name, $color));		
	}
	
	/**
	 * update the information of a SyColorCode
	 *
	 * @param int $id Id of the SyColorCode to update
	 * @param string $name New name of the SyColorCode
	 * @param string $color New Address of the SyColorCode
	 */
	public function editColorCode($id, $name, $color){
		
		$sql = "update sy_color_codes set name=?, color=? where id=?";
		$SyColorCode = $this->runRequest($sql, array("".$name."", "".$color."", $id));
	}
	
	
	public function isColorCode($name){
		$sql = "select * from sy_color_codes where name=?";
		$SyColorCode = $this->runRequest($sql, array($name));
		if ($SyColorCode->rowCount() == 1)
			return true;
		else
			return false;
	}
	
	public function setColorCode($name, $color){
		if (!$this->isColorCode($name)){
			$this->addSyColorCode($name, $color);
		}
	}
	
	/**
	 * get the informations of a SyColorCode
	 *
	 * @param int $id Id of the SyColorCode to query
	 * @throws Exception id the SyColorCode is not found
	 * @return mixed array
	 */
	public function getColorCodeValue($id){
		$sql = "select color from sy_color_codes where id=?";
		$SyColorCode = $this->runRequest($sql, array($id));
		if ($SyColorCode->rowCount() == 1){
			$tmp = $SyColorCode->fetch();
    		return $tmp[0];  // get the first line of the result
		}
    	else{
			return "aaaaaa";
			}
		}
	
	/**
	 * get the name of a SyColorCode
	 *
	 * @param int $id Id of the SyColorCode to query
	 * @throws Exception if the SyColorCode is not found
	 * @return mixed array
	 */
	public function getColorCodeName($id){
		$sql = "select name from sy_color_codes where id=?";
		$SyColorCode = $this->runRequest($sql, array($id));
		if ($SyColorCode->rowCount() == 1){
			$tmp = $SyColorCode->fetch();
			return $tmp[0];  // get the first line of the result
		}
		else{
			return "";	
		}
	}
	
	/**
	 * get the id of a SyColorCode from it's name
	 * 
	 * @param string $name Name of the SyColorCode
	 * @throws Exception if the SyColorCode connot be found
	 * @return mixed array
	 */
	public function getColorCodeId($name){
		$sql = "select id from sy_color_codes where name=?";
		$SyColorCode = $this->runRequest($sql, array($name));
		if ($SyColorCode->rowCount() == 1){
			$tmp = $SyColorCode->fetch();
			return $tmp[0];  // get the first line of the result
		}
		else{
			throw new Exception("Cannot find the SyColorCode using the given name");
		}
	}

}

