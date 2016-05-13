<?php

require_once 'Framework/ModelAuto.php';

/**
 * Class defining the template table model. 
 *
 * @author Sylvain Prigent
 */
class WbArticleList extends Model {

	public function __construct() {
            
        }
	
        public function createTable(){
            
            $sql = "CREATE TABLE IF NOT EXISTS `wb_articleslist` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`title` varchar(150) NOT NULL DEFAULT '',
                `id_parent_menu` int(11) NOT NULL DEFAULT 0,
                `is_published` int(1) NOT NULL DEFAULT 0,
		PRIMARY KEY (`id`)
		);";
		
            $this->runRequest($sql);
            
            $sqlj = "CREATE TABLE IF NOT EXISTS `wb_j_articles_list` (
		`id_list` int(11) NOT NULL,
		`id_article` int(11) NOT NULL
		);";
		
            $this->runRequest($sqlj);
            
        }
        
        public function insert($title, $id_parent_menu, $is_published){
            $sql = "INSERT INTO wb_articleslist (title, id_parent_menu, is_published) VALUES (?, ?, ?)";
            $this->runRequest($sql, array($title, $id_parent_menu, $is_published));
            return $this->getDatabase()->lastInsertId();
        }
        
        public function update($id, $title, $id_parent_menu, $is_published){
            $sql = "UPDATE wb_articleslist SET title=?, id_parent_menu=?, is_published=? WHERE id=?";
            $this->runRequest($sql, array($title, $id_parent_menu, $is_published, $id));
        }
        
        public function exists($id){
            $sql = "SELECT id FROM wb_articleslist WHERE id=?";
            $req = $this->runRequest($sql, array($id));
            if ($req->rowCount() == 1){
                return true;
            }
            return false;
        }
        
        public function select($id){
            $sql = "SELECT * FROM wb_articleslist WHERE id=?";
            return $this->runRequest($sql, array($id))->fetch();
        }
        
        public function selectAll(){
            $sql = "SELECT * FROM wb_articleslist";
            return $this->runRequest($sql)->fetchAll();
        }
        
        public function getArticles($id){
            $sql = "SELECT * FROM wb_articles WHERE id IN (SELECT id_article FROM wb_j_articles_list WHERE id_list=?)";
            return $this->runRequest($sql, array($id))->fetchAll();
        }
        
        public function set($id, $title, $id_parent_menu, $is_published){
            if ($this->exists($id)){
                $this->update($id, $title, $id_parent_menu, $is_published);
                return $id;
            }
            else{
                return $this->insert($title, $id_parent_menu, $is_published);
            }
        }
        
        public function addLink($id_list, $id_article){
            $sql = "INSERT INTO wb_j_articles_list (id_list, id_article) VALUES (?, ?)";
            $this->runRequest($sql, array($id_list, $id_article));
        }
                
        public function removeLinks($id_list){
            $sql = "DELETE FROM wb_j_articles_list WHERE id_list=?";
            $this->runRequest($sql, array($id_list));
        }
        
        public function delete($id){
            $sql = "DELETE FROM wb_articleslist WHERE id=?";
            $this->runRequest($sql, array($id));
        }
}