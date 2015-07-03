<?php
require_once 'Framework/Model.php';

require_once 'Modules/projet/Model/neurinfoprojet.php';
/**
 * Class defining methods to install and initialize the sygrrif database
 *
 * @author Sylvain Prigent
 */
class neurinfoinstall extends Model {

	/**
	 * Create the sygrrif database
	 *
	 * @return boolean True if the base is created successfully
	 */
	public function createDatabase(){
		
		$neurinfoModel = new neurinfoprojet();
		$neurinfoModel->createTable();
		
	}
	
}