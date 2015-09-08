<?php

require_once 'Framework/Model.php';

/**
 * Give access to the template tables (create/edit/delete templates) 
 * 
 * @author Sylvain Prigent
 */
class ShTemplate extends Model {

	/**
	 * Create the templates tables
	 * @return PDOStatement
	 */
	public function createTable(){
		
		$sql = "CREATE TABLE IF NOT EXISTS `sh_templates` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`name` varchar(40) NOT NULL DEFAULT '',							
		PRIMARY KEY (`id`)
		); ";
		
		$sql .= "CREATE TABLE IF NOT EXISTS `sh_elements_types` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`name` varchar(40) NOT NULL DEFAULT '',
		`preset_caption` varchar(150) NOT NULL DEFAULT '',		
		PRIMARY KEY (`id`)
		);";
		
		$sql .= "CREATE TABLE IF NOT EXISTS `sh_templates_elements` (
		`id` int(11) NOT NULL  AUTO_INCREMENT,
		`id_template` int(11) NOT NULL,
		`id_element_type` int(11) NOT NULL,
		`caption` varchar(40) NOT NULL DEFAULT '',
		`default_values` text NOT NULL DEFAULT '',		
		`display_order` int(5) NOT NULL,
		`mandatory` int(1) NOT NULL,	
		`who_can_modify` int(2) NOT NULL,
		`who_can_see` int(2) NOT NULL,	
		`add_to_summary` int(2) NOT NULL,						
		PRIMARY KEY (`id`)
		);";
		
		$pdo = $this->runRequest ( $sql );
		return $pdo;
		
	}
	
	public function setDefaultElementsTypes(){
		$this->addElementType("inputString", "Default value:");
		$this->addElementType("inputNumber", "Default value:");
		$this->addElementType("select", "Items(use ; as separator):");
		$this->addElementType("Separator", "Title:");
	}
	
	public function addElementType($name, $preset_caption){
		$sql = 'insert into sh_elements_types(name, preset_caption)'
				. ' values(?,?)';
		$this->runRequest($sql, array($name, $preset_caption));
	}
	
	public function getElementTypes(){
		$sql = 'select * from sh_elements_types ORDER By name';
		$tablesNames = $this->runRequest($sql);
		return $tablesNames->fetchAll();
	}
	
	public function getTemplates($sortEntry){
		$sql = 'select * from sh_templates ORDER By '.$sortEntry.'';
		$tablesNames = $this->runRequest($sql);
		return $tablesNames->fetchAll();
	}
	
	public function getTemplateName($id){
		$sql = 'select name from sh_templates WHERE id=?';
		$req = $this->runRequest($sql, array($id));
		$name = $req->fetch();
		return $name[0];
	}
	
	public function addTemplate($name){
		$sql = 'insert into sh_templates(name)'
				. ' values(?)';
		$this->runRequest($sql, array($name));
		return $this->getDatabase()->lastInsertId();
	}
	
	public function editTemplate($id, $name){
		$sql = "update sh_templates set name=? where id=?";
		$this->runRequest($sql, array($name, $id));
	}
	
	public function removeTemplateItems($id){
		$sql="DELETE FROM sh_templates_elements WHERE id_template = ?";
		$req = $this->runRequest($sql, array($id));
	}
	
	public function addTemplateElement($id_template, $id_element_type, $caption, $default_values,
										$display_order, $mandatory, $who_can_modify, $who_can_see,
										$add_to_summary
			){
		
		$sql = 'insert into sh_templates_elements(id_template, id_element_type, caption, default_values, display_order, mandatory, who_can_modify, who_can_see, add_to_summary)'
				. ' values(?,?,?,?,?,?,?,?,?)';
		$this->runRequest($sql, array($id_template, $id_element_type, $caption, 
				                      $default_values, $display_order, $mandatory,
									  $who_can_modify, $who_can_see, $add_to_summary
		));
	}
	
	public function editTemplateElement($id, $id_template, $id_element_type, $caption, $default_values,
			$display_order, $mandatory, $who_can_modify, $who_can_see,
			$add_to_summary
	){
	
		$sql = 'update sh_templates_elements set id_template=?, id_element_type=?, caption=?, default_values=?, display_order=?, 
				                                 mandatory=?, who_can_modify=?, who_can_see=?, add_to_summary=?'
				. ' where id=?';
		
		$this->runRequest($sql, array($id_template, $id_element_type, $caption,
				$default_values, $display_order, $mandatory,
				$who_can_modify, $who_can_see, $add_to_summary, $id
		));
	}
	
	public function getTemplateElements($templateID){
		$sql = 'select * from sh_templates_elements WHERE id_template=? ORDER BY display_order';
		$tablesNames = $this->runRequest($sql, array($templateID));
		return $tablesNames->fetchAll();
	}

}