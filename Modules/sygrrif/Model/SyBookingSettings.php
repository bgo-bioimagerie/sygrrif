<?php

require_once 'Framework/Model.php';

/**
 * Class defining the booking settings model
 *
 * @author Sylvain Prigent
 */
class SyBookingSettings extends Model {

	
	/**
	 * Create the booking settings entry table
	 *
	 * @return PDOStatement
	 */
	public function createTable(){
			
		$sql = "CREATE TABLE IF NOT EXISTS `sy_booking_settings` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`tag_name` varchar(100) NOT NULL,
		`is_visible` int(1) NOT NULL,			
		`is_tag_visible` int(1) NOT NULL,
		`display_order` int(5) NOT NULL,
		`font` varchar(20) NOT NULL,									
		PRIMARY KEY (`id`)
		);";

		$pdo = $this->runRequest($sql);
		return $pdo;
	}
	
	public function defaultEntries(){
		setEntry("User", 1, 1, 1, "normal");
		setEntry("Phone", 1, 1, 2, "normal");
		setEntry("Short desc", 1, 1, 3, "normal");
		setEntry("Desc", 0, 0, 4, "normal");
	}
	
	public function addEntry($tag_name, $is_visible, $is_tag_visible, 
			                 $display_order, $font){
		$sql = "insert into sy_booking_settings(tag_name, is_visible, is_tag_visible, 
			                                    display_order, font)"
				. " values(?,?,?,?,?)";
		$this->runRequest($sql, array($tag_name, $is_visible, $is_tag_visible, 
			                          $display_order, $font));
		return $this->getDatabase()->lastInsertId();
	}
	
	public function isEntry($tag_name){
		$sql = "select id from sy_booking_settings where tag_name=?";
		$data = $this->runRequest ( $sql, array (
				$tag_name
		) );
		if ($data->rowCount () == 1)
			return true;
		else
			return false;
	}
	
	public function setEntry($tag_name, $is_visible, $is_tag_visible, 
			                 $display_order, $font){
		if (!$this->isEntry($tag_name)){
			$this->addEntry($tag_name, $is_visible, $is_tag_visible, $display_order, $font);
		}
		else{
			$id = $this->getEntryID($tag_name);
			$this->updateEntry($id, $tag_name, $is_visible, $is_tag_visible, $display_order, $font);
		}
	}
	
	public function getEntryID($tag_name){
		$sql = "select id from sy_booking_settings where tag_name=?";
		$req = $this->runRequest($sql, array($tag_name));
		$tmp = $req->fetch();
		return $tmp[0];
	}
	
	public function getEntry($id){
		$sql = "select * from sy_booking_settings where id=?";
		$req = $this->runRequest($sql, array($id));
		return $req->fetch();
	}
	
	public function updateEntry($id, $tag_name, $is_visible, $is_tag_visible, 
			                 $display_order, $font){
		$sql = "update sy_booking_settings set tag_name=?, is_visible=?, is_tag_visible=?, 
			                 display_order=?, font=?
			                 where id=?";
		$this->runRequest($sql, array($tag_name, $is_visible, $is_tag_visible, 
			                 $display_order, $font, $id));
	}
}