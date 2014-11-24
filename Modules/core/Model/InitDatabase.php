<?php

require_once 'Framework/Model.php';
require_once 'Modules/core/Model/User.php';
require_once 'Modules/core/Model/Unit.php';
require_once 'Modules/core/Model/Team.php';
require_once 'Modules/core/Model/Responsible.php';
require_once 'Modules/core/Model/Status.php';

/**
 * Class defining the Database for the core module
 * This database contains the user, unit, team, responsible, and status 
 *
 * @author Baptiste Pesquet
 */
class InitDatabase extends Model {

	/**
	 * Create the core database
	 *
	 * @return boolean True if the base is created successfully
	 */
	public function createDatabase(){
		echo "call init database";
		
		$userModel = new User();
		$pdo = $userModel->createTable();
		$pdo = $userModel->createDefaultUser();
		
		$unitModel = new Unit();
		$pdo = $unitModel->createTable();
		
		$teamModel = new Team();
		$pdo = $teamModel->createTable();
		
		$respModel = new Responsible();
		$pdo = $respModel->createTable();
		
		$statusModel = new Status();
		$pdo = $statusModel->createTable();
		$pdo = $statusModel->createDefaultStatus();
		
		$message = 'success';
		return $message;
	}
}

