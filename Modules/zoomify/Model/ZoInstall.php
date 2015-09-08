<?php

require_once 'Framework/Model.php';
require_once 'Modules/zoomify/Model/ZoDirectories.php';

/**
 * Class defining methods to install and initialize the sygrrif database
 *
 * @author Sylvain Prigent
 */
class ZoInstall extends Model {

	/**
	 * Create the zoomify database
	 *
	 * @return boolean True if the base is created successfully
	 */
	public function createDatabase(){
		
		$model = new ZoDirectories();
		$model->createTable();
		
	}
}
	
?>