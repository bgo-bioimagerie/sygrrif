<?php

require_once 'Framework/ModelAuto.php';

/**
 * Class defining the template table model. 
 *
 * @author Sylvain Prigent
 */
class WbSubMenu extends Model {

	public function __construct() {
            
        }
	
        public function createTable(){
            
            $sql = "CREATE TABLE IF NOT EXISTS `wb_submenus` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`title` varchar(150) NOT NULL DEFAULT '',
		PRIMARY KEY (`id`)
		);";
		
            $this->runRequest($sql);
            
            $sqli = "CREATE TABLE IF NOT EXISTS `wb_submenusitems` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`title` varchar(150) NOT NULL DEFAULT '',
                `url` text NOT NULL DEFAULT '',
                `id_menu` int(11) NOT NULL, 
                `display_order` int(11) NOT NULL, 
		PRIMARY KEY (`id`)
		);";
	
            $this->runRequest($sqli);
            
        }
        
        // Items
        public function insertItem($title, $url, $id_menu, $display_order){
            $sql = "INSERT INTO wb_submenusitems (title, url, id_menu, display_order) VALUES (?, ?, ?, ?)";
            $this->runRequest($sql, array($title, $url, $id_menu, $display_order));
            return $this->getDatabase()->lastInsertId();
        }
        
        public function updateItems($id, $title, $url, $id_menu, $display_order){
            $sql = "UPDATE wb_submenusitems SET title=?, url=?, id_menu=?, display_order=? WHERE id=?";
            $this->runRequest($sql, array($title, $url, $id_menu, $display_order, $id));
        }
        
        public function isItem($id){
            $sql = "SELECT id FROM wb_submenusitems WHERE id=?";
            $req = $this->runRequest($sql, array($id));
            if ($req->rowCount() == 1){
                return true;
            }
            return false;
        }
        
        public function selectItem($id){
            $sql = "SELECT * FROM wb_submenusitems WHERE id=?";
            return $this->runRequest($sql, array($id))->fetch();
        }
        
        public function selectSubMenuItems($id_sub_menu){
            $sql = "SELECT * FROM wb_submenusitems WHERE id_menu ORDER BY display_order ASC;";
            return $this->runRequest($sql, array($id_sub_menu))->fetchAll();
        }
        
        public function selectAllItems(){
            $sql = "SELECT * FROM wb_submenusitems";
            return $this->runRequest($sql)->fetchAll();
        }
        
        public function setItem($id, $title, $url, $id_menu, $display_order){
            if ($this->isItem($id)){
                $this->updateItems($id, $title, $url, $id_menu, $display_order);
                return $id;
            }
            else{
                $this->insertItem($title, $url, $id_menu, $display_order);
            }
        }
        
        //     Sub Menu
        public function insertSubMenu($title){
            $sql = "INSERT INTO wb_submenus (title) VALUES (?)";
            $this->runRequest($sql, array($title));
            return $this->getDatabase()->lastInsertId();
        }
        
        public function updateSubMenu($id, $title){
            $sql = "UPDATE wb_submenus SET title=? WHERE id=?";
            $this->runRequest($sql, array($title, $id));
        }
        
        public function isSubMenu($id){
            $sql = "SELECT id FROM wb_submenus WHERE id=?";
            $req = $this->runRequest($sql, array($id));
            if ($req->rowCount() == 1){
                return true;
            }
            return false;
        }
        
        public function setSubMenu($id, $title){
            if ($this->isSubMenu($id)){
                $this->updateSubMenu($id, $title);
                return $id;
            }
            else{
                $this->insertSubMenu($title);
            }
        }
        
        public function selectSubMenu($id){
            $sql = "SELECT * FROM wb_submenus WHERE id=?";
            return $this->runRequest($sql, array($id))->fetch();
        }
        
        public function selectAllSubMenu(){
            $sql = "SELECT * FROM wb_submenus";
            return $this->runRequest($sql)->fetchAll();
        }
        
        public function deleteSubMenu($id){
            $sql = "DELETE FROM wb_submenus WHERE id=?";
            $this->runRequest($sql, array($id));
        }
	
}