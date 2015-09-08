<?php

require_once 'Framework/Model.php';
require_once 'Modules/sheet/Model/ShTemplate.php';
require_once 'Modules/sheet/Model/ShSheet.php';


/**
 * Class defining methods to install and initialize the sygrrif database
 *
 * @author Sylvain Prigent
 */
class ShInstall extends Model {

	/**
	 * Create the sygrrif database
	 *
	 * @return boolean True if the base is created successfully
	 */
	public function createDatabase(){
		
		$model = new ShTemplate();
		$model->createTable();
		$model->setDefaultElementsTypes();
		
		$model = new ShSheet();
		$model->createTable();
	}
}
	
?>