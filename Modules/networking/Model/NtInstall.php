<?php

require_once 'Framework/Model.php';
require_once 'Modules/core/Model/ModulesManager.php';
require_once 'Modules/networking/Model/NtRole.php';
require_once 'Modules/networking/Model/NtGroup.php';
require_once 'Modules/networking/Model/NtProject.php';
require_once 'Modules/networking/Model/NtComment.php';
require_once 'Modules/networking/Model/NtData.php';


/**
 * Class defining methods to install and initialize the Suplies database
 *
 * @author Sylvain Prigent
 */
class NtInstall extends Model {

	/**
	 * Create the core database
	 *
	 * @return boolean True if the base is created successfully
	 */
	public function createDatabase(){
		
            $roleModel = new NtRole();
            $roleModel->createTable();
            $roleModel->createDefault();
                
            $groupModel = new NtGroup();
            $groupModel->createTable();
                
            $projectModel = new NtProject();
            $projectModel->createTable();
            
            $commentModel = new NtComment();
            $commentModel->createTable();
            
            $dataModel = new NtData();
            $dataModel->createTable();
                
	}
}

