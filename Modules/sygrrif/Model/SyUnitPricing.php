<?php

require_once 'Framework/Model.php';

/**
 * Class defining the Sygrrif unit pricing joint model
 *
 * @author Sylvain Prigent
 */
class SyUnitPricing extends Model {
	
	public function createTable(){
		$sql = "CREATE TABLE IF NOT EXISTS `sy_unitpricing` (
		`id_unit` int(11) NOT NULL,	
	    `id_pricing` int(11) NOT NULL,		
		PRIMARY KEY (`id_unit`)
		);";
		
		$pdo = $this->runRequest($sql);
		return $pdo;
	}
	
	public function allPricing(){
		$sql = "select * from sy_unitpricing";
		$data = $this->runRequest($sql);
		return $data->fetchAll();
	}
	
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
	
	public function hasPricing($id_unit)
	{
		$sql = "select id_pricing from sy_unitpricing where id_unit=?";
		$user = $this->runRequest($sql, array($id_unit));
		return ($user->rowCount() == 1);
	}
	
	public function getPricing($id_unit)
	{
		$sql = "select id_pricing from sy_unitpricing where id_unit=?";
		$data = $this->runRequest($sql, array($login));
		if ($data->rowCount() == 1){
			return $data->fetch();
		}
		else{
			return 0;
		}
	}
	
	public function editPricing($id_unit, $id_pricing){
		$sql = "update sy_unitpricing set id_pricing=? where id_unit=?";
		$this->runRequest($sql, array($id_pricing, $id_unit));
	}
	
	public function addPricing($id_unit, $id_pricing){
		$sql = "insert into sy_unitpricing(id_unit, id_pricing)"
				. " values(?, ?)";
		$this->runRequest($sql, array($id_unit, $id_pricing));
	}
	
	public function setPricing($id_unit, $id_pricing){
		
		if ($this->hasPricing($id_unit)){
			$this->editPricing($id_unit, $id_pricing);
		}
		else{
			$this->addPricing($id_unit, $id_pricing);
		}
	}

	
}