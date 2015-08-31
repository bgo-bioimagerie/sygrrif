<?php

require_once 'Framework/Model.php';

/**
 * Class defining the Sygrrif unit pricing joint model
 *
 * @author Sylvain Prigent
 */
class SyUnitPricing extends Model {
	
	/**
	 * Create the table
	 * @return PDOStatement
	 */
	public function createTable(){
		$sql = "CREATE TABLE IF NOT EXISTS `sy_unitpricing` (
		`id_unit` int(11) NOT NULL,	
	    `id_pricing` int(11) NOT NULL,		
		PRIMARY KEY (`id_unit`)
		);";
		
		$pdo = $this->runRequest($sql);
		return $pdo;
	}
	
	/**
	 * Get all the pricing informations
	 * @return multitype:
	 */
	public function allPricing(){
		$sql = "select * from sy_unitpricing";
		$data = $this->runRequest($sql);
		return $data->fetchAll();
	}
	
	/**
	 * Get a table containing all the pricings for all units
	 * @return array
	 */
	public function allPricingTable(){	
		
		$pricingsIds= $this->allPricing();
		$pricingArray = array();
		for($i = 0 ; $i < count($pricingsIds) ; ++$i){
			$pricingId = $pricingsIds[$i];
			
			// get unit info
			$sql = "select id, name from core_units where id=?";
			$dataunit = $this->runRequest($sql, array($pricingId['id_unit']))->fetch(); /// @todo make it more robust (catch errors)
			
			// get pricing info
			$sql = "select id, tarif_name from sy_pricing where id=?";
			$datapricing = $this->runRequest($sql, array($pricingId['id_pricing']))->fetch(); /// @todo make it more robust (catch errors)

			$pricingArray[$i]['unit_id'] = $dataunit['id'];
			$pricingArray[$i]['unit_name'] = $dataunit['name'];
			$pricingArray[$i]['pricing_id'] = $datapricing['id'];
			$pricingArray[$i]['pricing_name'] = $datapricing['tarif_name'];
		}
		return $pricingArray;
	}
	
	/**
	 * CHeck if a unit has a pricing
	 * @param unknown $id_unit
	 * @return boolean
	 */
	public function hasPricing($id_unit)
	{
		$sql = "select id_pricing from sy_unitpricing where id_unit=?";
		$user = $this->runRequest($sql, array($id_unit));
		return ($user->rowCount() == 1);
	}
	
	/**
	 * get the pricing ID for a givin unit 
	 * @param number $id_unit
	 * @return number
	 */
	public function getPricing($id_unit)
	{
		$sql = "select id_pricing from sy_unitpricing where id_unit=?";
		$data = $this->runRequest($sql, array($id_unit));
		if ($data->rowCount() == 1){
			$tmp = $data->fetch();
			return $tmp[0];
		}
		else{
			return 0;
		}
	}
	
	/**
	 * Update the informations of a pricing
	 * @param number $id_unit
	 * @param number $id_pricing
	 */
	public function editPricing($id_unit, $id_pricing){
		$sql = "update sy_unitpricing set id_pricing=? where id_unit=?";
		$this->runRequest($sql, array($id_pricing, $id_unit));
	}
	
	/**
	 * Add a pricing to a unit
	 * @param number $id_unit
	 * @param number $id_pricing
	 */
	public function addPricing($id_unit, $id_pricing){
		$sql = "insert into sy_unitpricing(id_unit, id_pricing)"
				. " values(?, ?)";
		$this->runRequest($sql, array($id_unit, $id_pricing));
	}
	
	/**
	 * Set (add or update if exists) a pricing to a unit
	 * @param unknown $id_unit
	 * @param unknown $id_pricing
	 */
	public function setPricing($id_unit, $id_pricing){
		
		if ($this->hasPricing($id_unit)){
			$this->editPricing($id_unit, $id_pricing);
		}
		else{
			$this->addPricing($id_unit, $id_pricing);
		}
	}
	
}