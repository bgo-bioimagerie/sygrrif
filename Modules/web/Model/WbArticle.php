<?php

require_once 'Framework/ModelAuto.php';

/**
 * Class defining the template table model. 
 *
 * @author Sylvain Prigent
 */
class WbArticle extends Model {

	public function __construct() {
            
        }
	
        public function createTable(){
            
            $sql = "CREATE TABLE IF NOT EXISTS `wb_articles` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`title` varchar(150) NOT NULL DEFAULT '',
                `short_desc` text NOT NULL DEFAULT '',
                `content` text NOT NULL DEFAULT '',
                `id_parent_menu` int(11) NOT NULL DEFAULT 0,
                `date_created` int(11) NOT NULL,
                `date_modified` int(11) NOT NULL,
                `is_published` int(1) NOT NULL DEFAULT 0,
                `is_news` int(1) NOT NULL DEFAULT 0,
		PRIMARY KEY (`id`)
		);";
		
            $this->runRequest($sql);
            
        }
        
        public function insert($title, $short_desc, $content, $id_parent_menu, $is_news, $is_published){
            $date = time();
            $sql = "INSERT INTO wb_articles (title, short_desc, content, id_parent_menu, date_created, date_modified, is_news, is_published) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $this->runRequest($sql, array($title, $short_desc, $content, $id_parent_menu, $date, $date, $is_news, $is_published));
            return $this->getDatabase()->lastInsertId();
        }
        
        public function update($id, $title, $short_desc, $content, $id_parent_menu, $is_news, $is_published){
            $date = time();
            $sql = "UPDATE wb_articles SET title=?, short_desc=?, content=?, id_parent_menu=?, date_modified=?, is_news=?, is_published=? WHERE id=?";
            $this->runRequest($sql, array($title, $short_desc, $content, $id_parent_menu, $date, $is_news, $is_published, $id));
        }
        
        public function exists($id){
            $sql = "SELECT id FROM wb_articles WHERE id=?";
            $req = $this->runRequest($sql, array($id));
            if ($req->rowCount() == 1){
                return true;
            }
            return false;
        }
        
        public function select($id){
            $sql = "SELECT * FROM wb_articles WHERE id=?";
            return $this->runRequest($sql, array($id))->fetch();
        }
        
        public function selectAll(){
            $sql = "SELECT * FROM wb_articles";
            return $this->runRequest($sql)->fetchAll();
        }
        
        public function set($id, $title, $short_desc, $content, $id_parent_menu, $is_news, $is_published){
            if ($this->exists($id)){
                $this->update($id, $title, $short_desc, $content, $id_parent_menu, $is_news, $is_published);
                return $id;
            }
            else{
                return $this->insert($title, $short_desc, $content, $id_parent_menu, $is_news, $is_published);
            }
        }
        
        public function delete($id){
            $sql = "DELETE FROM wb_articles WHERE id=?";
            $this->runRequest($sql, array($id));
        }
}