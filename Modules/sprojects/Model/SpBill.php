<?php

require_once 'Framework/Model.php';
require_once 'Modules/core/Model/CoreUser.php';
require_once 'Modules/core/Model/CoreUnit.php';
require_once 'Modules/core/Model/CoreBelonging.php';
require_once 'Modules/sprojects/Model/SpUser.php';
require_once 'Modules/sprojects/Model/SpUnit.php';
require_once 'Modules/sprojects/Model/SpBelonging.php';

/**
 * Class defining the Bill model. It is used to store the history 
 * of the generated bills
 *
 * @author Sylvain Prigent
 */
class SpBill extends Model {

	public function createTable(){
		$sql = "CREATE TABLE IF NOT EXISTS `sp_bills` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
	    `number` varchar(50) NOT NULL,
		`no_project` varchar(50) NOT NULL,
		`id_resp` int(11) NOT NULL,
		`date_generated` DATE NOT NULL,
		`total_ht` varchar(50) NOT NULL,		
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
	public function addBill($number, $no_project, $id_resp, $date_generated, $total_ht, $date_paid="", $is_paid=0){
	
		$sql = "insert into sp_bills(number, no_project, id_resp, date_generated, total_ht, date_paid, is_paid)"
				. " values(?, ?, ?, ?, ?, ?, ?)";
		$this->runRequest($sql, array($number, $no_project, $id_resp, $date_generated, $total_ht, $date_paid, $is_paid));
		return $this->getDatabase()->lastInsertId();
	}
	
	public function setPaid($id, $is_paid){
		$sql = "update sp_bills set is_paid=? where id=?";
		$unit = $this->runRequest($sql, array($is_paid, $id));
	}
	
	/**
	 * get bills informations
	 *
	 * @param string $sortentry Entry that is used to sort the units
	 * @return multitype: array
	 */
	public function getBills($sortentry = 'id'){
			
		$sql = "select * from sp_bills order by " . $sortentry . " ASC;";
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
		$sql = "select * from sp_bills where id=?";
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
	public function editBills($id, $number, $no_project, $id_resp, $date_generated, $total_ht, $date_paid, $is_paid){
	
		$sql = "update sp_bills set number=?, no_project=?, id_resp=?, date_generated=?, total_ht=?, date_paid=?, is_paid=?  where id=?";
		$unit = $this->runRequest($sql, array($number, $no_project, $id_resp, $date_generated, $total_ht, $date_paid, $is_paid, $id));
	}
	
	public function removeEntry($id){
		$sql="DELETE FROM sp_bills WHERE id = ?";
		$req = $this->runRequest($sql, array($id));
	}
	
	public function computeStats($period_begin, $period_end){
		$sql = "select * from sp_bills where date_generated >=? AND date_generated <=?";
		$req = $this->runRequest($sql, array($period_begin, $period_end));
		$bills = $req->fetchAll();
		
		$totalNumberOfBills = count($bills);
		$totalPrice = 0;
		$numberOfAcademicBills = 0;
		$totalPriceOfAcademicBills = 0;
		$numberOfPrivateBills = 0;
		$totalPriceOfPrivateBills = 0;
	
		// instanciate models
		$modelUser = "";
		$modelUnit = "";
		$modelBelonging = "";
		$modelConfig = new CoreConfig();
		$sprojectsusersdatabase = $modelConfig->getParam ( "sprojectsusersdatabase" );
		if ($sprojectsusersdatabase == "local"){
			$modelUser = new SpUser();
			$modelUnit = new SpUnit();
			$modelBelonging = new SpBeloning();
		}
		else{
			$modelUser = new CoreUser();
			$modelUnit = new CoreUnit();
			$modelBelonging = new CoreBelonging();
		}
		
		// stats
		for($i = 0 ; $i < $totalNumberOfBills ; $i++){
			
			$id_unit = $modelUser->getUserUnit($bills[$i]["id_resp"]);
			$id_pricing = $modelUnit->getBelonging($id_unit);
			$pricingInfo = $modelBelonging->getInfo($id_pricing);
			if ($pricingInfo["type"] == 1){
				$numberOfAcademicBills++;
				$totalPriceOfAcademicBills += $bills[$i]["total_ht"];
			}
			else{
				$numberOfPrivateBills++;
				$totalPriceOfPrivateBills += $bills[$i]["total_ht"];
			}
			$totalPrice += $bills[$i]["total_ht"]; 
		}
		  
		$output = array(
				"totalNumberOfBills" => $totalNumberOfBills,
				"totalPrice" => $totalPrice,
				"numberOfAcademicBills" => $numberOfAcademicBills,
				"totalPriceOfAcademicBills" => $totalPriceOfAcademicBills,
				"numberOfPrivateBills" => $numberOfPrivateBills,
				"totalPriceOfPrivateBills" => $totalPriceOfPrivateBills
		);
		return $output;
	}
}