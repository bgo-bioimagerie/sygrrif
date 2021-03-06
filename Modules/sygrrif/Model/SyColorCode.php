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
		`color` varchar(7) NOT NULL DEFAULT '',
		`text` varchar(7) NOT NULL DEFAULT '',		
		`display_order` int(11) NOT NULL DEFAULT 0,
		PRIMARY KEY (`id`)
		);";
		
		$pdo = $this->runRequest($sql);
		//return $pdo;
		
		// add columns if no exists
		$sql = "SHOW COLUMNS FROM `sy_color_codes` LIKE 'text'";
		$pdo = $this->runRequest($sql);
		$isColumn = $pdo->fetch();
		if ( $isColumn == false){
			$sql = "ALTER TABLE `sy_color_codes` ADD `text` varchar(6) NOT NULL DEFAULT '#000000'";
			$pdo = $this->runRequest($sql);
		}
		
	}
	
	/**
	 * Create the default empty SyColorCode
	 * 
	 * @return PDOStatement
	 */
	public function createDefaultColorCode(){
	
		if(!$this->isColorCode("default", "b2dfee")){
			$sql = "INSERT INTO sy_color_codes (name, color, text) VALUES(?,?,?)";
			$this->runRequest($sql, array("default", "b2dfee", "000000"));
		}
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
	
	/**
	 * Get color code info from ID
	 * @param unknown $id
	 * @return mixed
	 */
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
	public function addColorCode($name, $color, $text_color, $display_order=0){
		
		$sql = "insert into sy_color_codes(name, color, text, display_order)"
				. " values(?, ?, ?, ?)";
		$this->runRequest($sql, array($name, $color, $text_color, $display_order));		
	}
	
	/**
	 * import a color code (used to import GRR database)
	 * @param unknown $id
	 * @param unknown $name
	 * @param unknown $color
	 * @param number $display_order
	 */
	public function importColorCode($id, $name, $color, $display_order=0){
		
		if ($this->isColorCodeId($id)){
			$this->editColorCode($id, $name, $color, "000000", $display_order);
		}
		else{	
			$sql = "insert into sy_color_codes(id, name, color, text, display_order)"
					. " values(?, ?, ?, ?, ?)";
			$this->runRequest($sql, array($id, $name, $color, "000000", $display_order));		
		}
	}
	
	/**
	 * update the information of a SyColorCode
	 *
	 * @param int $id Id of the SyColorCode to update
	 * @param string $name New name of the SyColorCode
	 * @param string $color New Address of the SyColorCode
	 */
	public function editColorCode($id, $name, $color, $text_color, $display_order){
		
		$sql = "update sy_color_codes set name=?, color=?, text=?, display_order=? where id=?";
		$SyColorCode = $this->runRequest($sql, array("".$name."", "".$color."", $text_color, $display_order , $id));
	}
	
	/**
	 * CHeck if a color code exists from name
	 * @param unknown $name
	 * @return boolean
	 */
	public function isColorCode($name){
		$sql = "select * from sy_color_codes where name=?";
		$SyColorCode = $this->runRequest($sql, array($name));
		if ($SyColorCode->rowCount() == 1)
			return true;
		else
			return false;
	}
	
	/**
	 * Check if a color code exists from id
	 * @param unknown $id
	 * @return boolean
	 */
	public function isColorCodeId($id){
		$sql = "select * from sy_color_codes where id=?";
		$SyColorCode = $this->runRequest($sql, array($id));
		if ($SyColorCode->rowCount() == 1)
			return true;
		else
			return false;
	}
	
	/**
	 * Add a color code if not exists
	 * @param unknown $name
	 * @param unknown $color
	 * @param unknown $display_order
	 */
	public function setColorCode($name, $color, $text_color, $display_order){
		if (!$this->isColorCode($name)){
			$this->addSyColorCode($name, $color, $text_color, $display_order);
		}
	}
	
	/**
	 * get the color of a SyColorCode from ID
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
	 * get the text color of a SyColorCode from ID
	 *
	 * @param int $id Id of the SyColorCode to query
	 * @throws Exception id the SyColorCode is not found
	 * @return mixed array
	 */
	public function getColorCodeText($id){
		$sql = "select text from sy_color_codes where id=?";
		$SyColorCode = $this->runRequest($sql, array($id));
		if ($SyColorCode->rowCount() == 1){
			$tmp = $SyColorCode->fetch();
			return $tmp[0];  // get the first line of the result
		}
		else{
			return "000000";
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

	/**
	 * Remove a color code
	 * @param unknown $id
	 */
	public function delete($id){
		$sql="DELETE FROM sy_color_codes WHERE id = ?";
		$req = $this->runRequest($sql, array($id));
	}
	
}

