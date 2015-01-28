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
		`date_generated` DATE NOT NULL,	
		`date_paid` DATE NOT NULL,			
		`is_paid` int(1) NOT NULL,		
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
	
	public function removeEntry($id){
		$sql="DELETE FROM sy_bills WHERE id = ?";
		$req = $this->runRequest($sql, array($id));
	}
}