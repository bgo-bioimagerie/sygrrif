<?php

require_once 'Framework/Model.php';
require_once 'Modules/sygrrif/Model/SyPricing.php';

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
		
	}
}
	
?>