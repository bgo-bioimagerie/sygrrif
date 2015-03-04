<?php

require_once 'Framework/Model.php';

/**
 * Class defining the Bill model. It is used to store the history 
 * of the generated bills
 *
 * @author Sylvain Prigent
 */
class SyBill extends Model {

	public function createTable(){
		$sql = "CREATE TABLE IF NOT EXISTS `sy_bills` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
	    `number` varchar(50) NOT NULL,		
		`period_begin` DATE NOT NULL,		
		`period_end` DATE NOT NULL,
		`date_generated` DATE NOT NULL,	
		`date_paid` DATE NOT NULL,			
		`is_paid` int(1) NOT NULL,
		`id_unit` int(11) NOT NULL,
		`id_responsible` int(11) NOT NULL,
		`id_project` int(11) NOT NULL,						
		PRIMARY KEY (`id`)
		);";

		$pdo = $this->runRequest($sql);
		return $pdo;
	}
	
	/**
	 * add an item to the table
	 *
	 * @param string $name name of the unit
	 */
	public function addBill($number, $date_generated, $date_paid="", $is_paid=0){
	
		$sql = "insert into sy_bills(number, date_generated, date_paid, is_paid)"
				. " values(?, ?, ?, ?)";
		$this->runRequest($sql, array($number, $date_generated, $date_paid, $is_paid));
		return $this->getDatabase()->lastInsertId();
	}
	
	
	public function addBillUnit($number, $period_begin, $period_end, $date_generated, $id_unit, $id_responsible, $date_paid="", $is_paid=0){
		$sql = "insert into sy_bills(number, period_begin, period_end, date_generated, id_unit, id_responsible, date_paid, is_paid)"
				. " values(?, ?, ?, ?, ?, ?, ?, ?)";
		$this->runRequest($sql, array($number, $period_begin, $period_end, $date_generated, $id_unit, $id_responsible, $date_paid, $is_paid));
		return $this->getDatabase()->lastInsertId();
	}
	
	public function addBillProject($number, $period_begin, $period_end, $date_generated, $id_project, $date_paid="", $is_paid=0){
		$sql = "insert into sy_bills(number, period_begin, period_end, date_generated, id_project, date_paid, is_paid)"
				. " values(?, ?, ?, ?, ?, ?, ?)";
		$this->runRequest($sql, array($number, $period_begin, $period_end, $date_generated, $id_project, $date_paid, $is_paid));
		return $this->getDatabase()->lastInsertId();
	}
	
	public function setPaid($id, $is_paid){
		$sql = "update sy_bills set is_paid=? where id=?";
		$unit = $this->runRequest($sql, array($is_paid, $id));
	}
	
	/**
	 * get bills informations
	 *
	 * @param string $sortentry Entry that is used to sort the units
	 * @return multitype: array
	 */
	public function getBills($sortentry = 'id'){
			
		$sql = "select * from sy_bills order by " . $sortentry . " ASC;";
		$user = $this->runRequest($sql);
		return $user->fetchAll();
	}
	
	public function getBillsUnit($sortentry = 'id'){
		$sqlSort = "sy_bills.id";
		if ($sortentry == "number"){
			$sqlSort = "sy_bills.number";
		}
		else if ($sortentry == "date_generated"){
			$sqlSort = "sy_bills.date_generated";
		}
		else if ($sortentry == "date_paid"){
			$sqlSort = "sy_bills.date_paid";
		}
		else if ($sortentry == "is_paid"){
			$sqlSort = "sy_bills.is_paid";
		}
		else if ($sortentry == "unit"){
			$sqlSort = "core_units.name";
		}
		else if ($sortentry == "responsible"){
			$sqlSort = "core_users.name";
		}
		
		$sql = "SELECT sy_bills.id AS id, sy_bills.number AS number,
				       sy_bills.period_begin AS period_begin, 
					   sy_bills.period_end AS period_end, 
					   sy_bills.date_generated AS date_generated, 
					   sy_bills.date_paid AS date_paid, 
					   sy_bills.is_paid AS is_paid,
					   core_units.name AS unit,
					   core_users.name AS resp_name,
					   core_users.firstname AS resp_firstname
				FROM sy_bills
				INNER JOIN core_units ON sy_bills.id_unit = core_units.id
				INNER JOIN core_users ON sy_bills.id_responsible = core_users.id	
				ORDER BY ". $sqlSort . ";";	
				
		/*
		$sql = "SELECT sy_resources.id AS id, sy_resources.name AS name, sy_resources.description AS description,
				       sy_resource_type.name AS type_name, sy_resourcescategory.name AS category_name, sy_areas.name AS area_name,
				       sy_resource_type.controller AS controller, sy_resource_type.edit_action AS edit_action
					from sy_resources
					     INNER JOIN sy_resource_type on sy_resources.type_id = sy_resource_type.id
					     INNER JOIN sy_resourcescategory on sy_resources.category_id = sy_resourcescategory.id
						 INNER JOIN sy_areas on sy_resources.area_id = sy_areas.id
					ORDER BY ". $sqlSort . ";";
					*/
		$req = $this->runRequest ( $sql );
		return $req->fetchAll ();
	}
	
	/**
	 * get the informations of an item
	 *
	 * @param int $id Id of the item to query
	 * @throws Exception id the item is not found
	 * @return mixed array
	 */
	public function getBill($id){
		$sql = "select * from sy_bills where id=?";
		$unit = $this->runRequest($sql, array($id));
		if ($unit->rowCount() == 1)
			return $unit->fetch();  // get the first line of the result
		else
			throw new Exception("Cannot find the item using the given id");
	}
	
	
	/**
	 * update the information of an item
	 *
	 * @param int $id Id of the item to update
	 * @param string $name New name of the item
	 */
	public function editBills($id, $number, $date_generated, $date_paid, $is_paid){
	
		$sql = "update sy_bills set number=?, date_generated=?, date_paid=?, is_paid=?  where id=?";
		$unit = $this->runRequest($sql, array($number, $date_generated, $date_paid, $is_paid, $id));
	}
	

	public function editBillUnit($id, $number, $date_generated, $id_unit, $id_responsible, $date_paid, $is_paid){
	
		$sql = "update sy_bills set number=?, date_generated=?, id_unit=?, id_responsible=?, date_paid=?, is_paid=?  where id=?";
		$unit = $this->runRequest($sql, array($number, $date_generated, $id_unit, $id_responsible, $date_paid, $is_paid, $id));
	}
	
	public function editBillProject($id, $number, $date_generated, $id_project, $date_paid, $is_paid){
	
		$sql = "update sy_bills set number=?, date_generated=?, id_project=?, date_paid=?, is_paid=?  where id=?";
		$unit = $this->runRequest($sql, array($number, $date_generated, $id_project, $date_paid, $is_paid, $id));
	}
	
	public function removeEntry($id){
		$sql="DELETE FROM sy_bills WHERE id = ?";
		$req = $this->runRequest($sql, array($id));
	}
}