<?php

require_once 'Framework/Model.php';
require_once 'Modules/storage/Model/StDirectories.php';

/**
 * Class defining methods to install and initialize the sygrrif database
 *
 * @author Sylvain Prigent
 */
class StInstall extends Model {

	/**
	 * Create the sygrrif database
	 *
	 * @return boolean True if the base is created successfully
	 */
	public function createDatabase(){
		
		$model = new StDirectories();
		$model->createTable();
		
	}
}
	
?>