<?php

require_once 'Framework/Model.php';

/**
 * Class defining the area model
 *
 * @author Sylvain Prigent
 */
class SyBookingTableCSS extends Model {

	
	/**
	 * Create the area table
	 *
	 * @return PDOStatement
	 */
	public function createTable(){
	
		$sql = "CREATE TABLE IF NOT EXISTS `sy_bookingcss` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`id_area` int(11) NOT NULL,	
		`header_background` varchar(7) NOT NULL DEFAULT '#337ab7',
		`header_color` varchar(7) NOT NULL DEFAULT '#ffffff',
		`header_font_size` int(2) NOT NULL DEFAULT 12,
		`resa_font_size` int(2) NOT NULL DEFAULT 12,
		`header_height` int(3) NOT NULL DEFAULT 70,
		`line_height` int(3) NOT NULL DEFAULT 50,							
		PRIMARY KEY (`id`)
		);";
		
		$pdo = $this->runRequest($sql);
		return $pdo;
		
	}
	
	/**
	 * Get the areas list
	 * @param string $sortEntry Sort entry
	 * @return multitype: tables of areas
	 */
	public function areas($sortEntry){
		$sql = "select * from sy_bookingcss order by " . $sortEntry . " ASC;";
		$data = $this->runRequest($sql);
		return $data->fetchAll();
	}
	
	/**
	 * Get the css for a given area
	 * @param number $id Area ID
 	 * @return mixed|string CSS info or error message
	 */
	public function getAreaCss($id){
	
		$sql = "select * from sy_bookingcss where id_area=?;";
		$data = $this->runRequest($sql, array($id));
		if ($data->rowCount () == 1)
			return $data->fetch ();
		else
			return "not found";
	}
	
	/**
	 * add a Area to the table
	 *
	 * @param string $name name of the Area
	 */
	private function addAreaCss($id_area, $header_background, $header_color, $header_font_size, 
								$resa_font_size, $header_height, $line_height){
		
		$sql = "insert into sy_bookingcss(id_area, header_background, header_color, header_font_size, 
										  resa_font_size, header_height, line_height)"
				. " values(?,?,?,?,?,?,?)";
		$user = $this->runRequest($sql, array($id_area, $header_background, $header_color, $header_font_size, 
								$resa_font_size, $header_height, $line_height));		
	}

	
	/**
	 * Check if an area exists
	 * @param string $name
	 * @return boolean
	 */
	public function isAreaCss($id_area){
		$sql = "select * from sy_bookingcss where id_area=?";
		$unit = $this->runRequest($sql, array($id_area));
		if ($unit->rowCount() == 1)
			return true;
		else
			return false;
	}
	
	public function areaCssId($id_area){
		$sql = "select id from sy_bookingcss where id_area=?";
		$unit = $this->runRequest($sql, array($id_area));
		if ($unit->rowCount() == 1)
			return $unit->fetch();
		else
			return 0;
	}

	/**
	 * Add an area if not exists
	 * @param string $name
	 * @param number $display_order
	 * @param number $restricted
	 */
	public function setAreaCss($id_area, $header_background, $header_color, $header_font_size, 
								$resa_font_size, $header_height, $line_height){
		if (!$this->isAreaCss($id_area)){
			$this->addAreaCss($id_area, $header_background, $header_color, $header_font_size, 
								$resa_font_size, $header_height, $line_height);
		}
		else{
			$id = $this->areaCssId($id_area);
			$this->updateAreaCss($id[0], $id_area, $header_background, $header_color, $header_font_size,
					$resa_font_size, $header_height, $line_height);
		}
	}
	
	/**
	 * Update a area info
	 * @param number $id ID of the area to edit 
	 * @param string $name New name
	 * @param number $display_order New display order
	 * @param number $restricted New restriction
	 */
	public function updateAreaCss($id, $id_area, $header_background, $header_color, $header_font_size, 
								$resa_font_size, $header_height, $line_height){
		$sql = "update sy_bookingcss set id_area=?, header_background=?, header_color=?, header_font_size=?, 
								resa_font_size=?, header_height=?, line_height=?
									  where id=?";
		$this->runRequest($sql, array($id_area, $header_background, $header_color, $header_font_size, 
								$resa_font_size, $header_height, $line_height, $id));
	}
	
	/**
	 * Remove an area
	 * @param number $id Area ID
	 */
	
	public function delete($id){
		$sql="DELETE FROM sy_bookingcss WHERE id = ?";
		$req = $this->runRequest($sql, array($id));
	}

}