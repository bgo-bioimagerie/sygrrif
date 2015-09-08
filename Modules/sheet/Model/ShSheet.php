<?php

require_once 'Framework/Model.php';

/**
 * Give access to the template tables (create/edit/delete templates) 
 * 
 * @author Sylvain Prigent
 */
class ShSheet extends Model {

	/**
	 * Create the templates tables
	 * @return PDOStatement
	 */
	public function createTable(){
		
		$sql = "CREATE TABLE IF NOT EXISTS `sh_sheets` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`id_template` int(11) NOT NULL,
		`generated_date` date NOT NULL,	
		`last_modified`  date NOT NULL,	
		`status` varchar(100) NOT NULL,										
		PRIMARY KEY (`id`)
		); ";
		
		$sql .= "CREATE TABLE IF NOT EXISTS `sh_elements_values` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`id_sheet_element` int(11) NOT NULL,
		`value` text NOT NULL DEFAULT '',
		`id_sheet` int(11) NOT NULL,	
		PRIMARY KEY (`id`)
		);";
		
		$pdo = $this->runRequest ( $sql );
		return $pdo;
		
	}
	
	public function getSheets($templateID){
		
		// get the sheets
		$sql = 'select * from sh_sheets WHERE id_template=?';
		$req = $this->runRequest($sql, array($templateID));
		$sheets = $req->fetchAll();
		
		// get the summary elements
		$sql = 'select * from sh_templates_elements WHERE add_to_summary=1 AND id_template=?';
		$req = $this->runRequest($sql, array($templateID));
		$elements = $req->fetchAll();
		
		for($i = 0 ; $i < count($sheets) ; $i++ ){
			for($j = 0 ; $j < count($elements) ; $j++){
				$sql = "SELECT value FROM sh_elements_values WHERE id_sheet=? AND id_sheet_element=?";
				$req = $this->runRequest($sql, array($sheets[$i]["id"], $elements[$j]["id"]));
				$val = $req->fetch();
				$sheets[$i][$elements[$j]["caption"]] = $val[0];
			}
		}
		
		return $sheets;
	}
	
	public function addSheet($id_template, $created_date, $last_modified, $status){
		$sql = 'insert into sh_sheets(id_template, generated_date, last_modified, status)'
				. ' values(?,?,?,?)';
		$this->runRequest($sql, array($id_template, $created_date, $last_modified, $status
		));
		return $this->getDatabase()->lastInsertId();
	}
	
	public function removeSheetElements($id_sheet){
		$sql="DELETE FROM sh_elements_values WHERE id_sheet = ?";
		$req = $this->runRequest($sql, array($id_sheet));
	}
	
	public function addSheetElement($id_sheet_element, $value, $id_sheet){
		$sql = 'insert into sh_elements_values(id_sheet_element, value, id_sheet)'
				. ' values(?,?,?)';
		$this->runRequest($sql, array($id_sheet_element, $value, $id_sheet));
	}
	
	public function getSheet($id_sheet){
		$sql = 'select * from sh_sheets WHERE id=?';
		$req = $this->runRequest($sql, array($id_sheet));
		return $req->fetchAll();
	}
	
	public function getSheetElements($id_sheet){
		$sql = 'select * from sh_sheets WHERE id=?';
		$req = $this->runRequest($sql, array($id_sheet));
		$sheet = $req->fetch();
		
		// get the summary elements
		$sql = 'select * from sh_templates_elements WHERE id_template=?';
		$req = $this->runRequest($sql, array($sheet["id_template"]));
		$elements = $req->fetchAll();
		
		for($j = 0 ; $j < count($elements) ; $j++){
			$sql = "SELECT value FROM sh_elements_values WHERE id_sheet=? AND id_sheet_element=?";
			$req = $this->runRequest($sql, array($id_sheet, $elements[$j]["id"]));
			$val = $req->fetch();
			$sheet["id" . $elements[$j]["id"]] = $val[0];
		}
		
		
		return $sheet;
	}
	
	/**
	 * Delete a sheet
	 * @param number $id sheet ID
	 */
	public function delete($id){
		$sql="DELETE FROM sh_sheets WHERE id = ?";
		$req = $this->runRequest($sql, array($id));
	}
}