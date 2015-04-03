<?php

require_once 'Framework/Model.php';
require_once 'Modules/anticorps/Model/Anticorps.php';
require_once 'Modules/anticorps/Model/Isotype.php';
require_once 'Modules/anticorps/Model/Source.php';
require_once 'Modules/anticorps/Model/Espece.php';
require_once 'Modules/anticorps/Model/Tissus.php';
require_once 'Modules/anticorps/Model/AcProtocol.php';
require_once 'Modules/anticorps/Model/Organe.php';
require_once 'Modules/anticorps/Model/Prelevement.php';

require_once 'Modules/anticorps/Model/Dem.php';
require_once 'Modules/anticorps/Model/Aciinc.php';
require_once 'Modules/anticorps/Model/Linker.php';
require_once 'Modules/anticorps/Model/Inc.php';
require_once 'Modules/anticorps/Model/Acii.php';
require_once 'Modules/anticorps/Model/Kit.php';
require_once 'Modules/anticorps/Model/Proto.php';
require_once 'Modules/anticorps/Model/Fixative.php';
require_once 'Modules/anticorps/Model/AcOption.php';
require_once 'Modules/anticorps/Model/Enzyme.php';

/**
 * Class defining methods to install and initialize the core database
 *
 * @author Sylvain Prigent
 */
class AcInstall extends Model {

	/**
	 * Create the anticorps database
	 *
	 * @return boolean True if the base is created successfully
	 */
	public function createDatabase(){
		
		$anticorpsModel = new Anticorps();
		$anticorpsModel->createTable();
		
		$isotypeModel = new Isotype();
		$isotypeModel->createTable();
		
		$sourceModel = new Source();
		$sourceModel->createTable();
		
		$especeModel = new Espece();
		$especeModel->createTable();
		
		$tissusModel = new Tissus();
		$tissusModel->createTable();
		
		$protoModel = new AcProtocol();
		$protoModel->createTable(); 
		
		$organeModel = new Organe();
		$organeModel->createTable();
		
		$organePrelevement = new Prelevement();
		$organePrelevement->createTable();
		
		$modelacii = new Acii();
		$modelacii->createTable();
		
		$modelaciinc = new Aciinc();
		$modelaciinc->createTable();
		
		$modelaciinc = new Dem();
		$modelaciinc->createTable();
		
		$modelinc = new Inc();
		$modelinc->createTable();
		
		$modellinker = new Linker();
		$modellinker->createTable();
		
		$model = new Kit();
		$model->createTable();
		
		$model = new Proto();
		$model->createTable();
		
		$model = new Fixative();
		$model->createTable();
		
		$model = new AcOption();
		$model->createTable();
		
		$model = new Enzyme();
		$model->createTable();
		
		$message = 'success';
		return $message;
	}
}

