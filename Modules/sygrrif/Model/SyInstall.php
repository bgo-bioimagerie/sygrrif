<?php

require_once 'Framework/Model.php';
require_once 'Modules/sygrrif/Model/SyPricing.php';
require_once 'Modules/sygrrif/Model/SyUnitPricing.php';
require_once 'Modules/sygrrif/Model/SyResourceTypeGRR.php';
require_once 'Modules/sygrrif/Model/SyResourcePricing.php';
/**
 * Class defining methods to install and initialize the sygrrif database
 *
 * @author Sylvain Prigent
 */
class SyInstall extends Model {

	/**
	 * Create the sygrrif database
	 *
	 * @return boolean True if the base is created successfully
	 */
	public function createDatabase(){
		
		echo "call init database";
		$pricingModel = new SyPricing();
		$pricingModel->createTable();
		
		$unitpricingModel = new SyUnitPricing();
		$unitpricingModel->createTable();
		
		$SyResourceTypeGRRModel = new SyResourceTypeGRR();
		$SyResourceTypeGRRModel->createTable();
		$SyResourceTypeGRRModel->createDefaultTypes();
		
		$SyResourcePricingModel = new SyResourcePricing();
		$SyResourcePricingModel->createTable();
	}
}
	
?>