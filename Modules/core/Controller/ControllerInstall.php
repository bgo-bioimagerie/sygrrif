<?php
require_once 'Framework/Controller.php';

require_once 'Modules/core/Model/Install.php';
require_once 'Modules/core/Model/InitDatabase.php';

class ControllerInstall extends Controller {
	
	//private $billet;
	public function __construct() {
		//$this->billet = new Billet ();
	}
	
	
	protected function isInstalled(){
		$dsn = Configuration::get('dsn', '');
		echo "dsn = " . $dsn . "--";
		if ($dsn == ''){
			$alreadyInstalled = false;
		}
		else{
			$alreadyInstalled = true;
		}
		return $alreadyInstalled;
	}
	
	// Affiche la liste de tous les billets du blog
	public function index() {
		
		$alreadyInstalled  = $this->isInstalled();
		
		$this->generateView ( array (
				'alreadyInstalled' => $alreadyInstalled 
		) );
	}
	
	
	public function configdatabase(){
		$alreadyInstalled  = $this->isInstalled();
		
		
		$showform = false;
		$errorMessage = '';
		if ($alreadyInstalled == false){
			
			// get request variables
			$sql_host = $this->request->getParameter("sql_host");
			$login = $this->request->getParameter("login");
			$password = $this->request->getParameter("password");
			$db_name = $this->request->getParameter("db_name");
			
			// test the connection
			$installModel = new Install();
			$testVal = $installModel->testConnection($sql_host, $login, $password, $db_name);
			echo 'test connection return val = ' . $testVal . '-----'; 
			if ($testVal == 'success'){
				// edit the config file
				$returnVal = $installModel->writedbConfig($sql_host, $login, $password, $db_name);
				if ($returnVal){
					$showform = false;
					$errorMessage = '';
				}
				else{
					$showform = true;
					$errorMessage = 'Cannot write the congif file. Please make sure that the application have the right for writing in Config/prod.ini' ;
				}
			}
			else{
				$showform = true;
				$errorMessage = $testVal;
				echo '$errorMessage = ' . $errorMessage . '-----';
			}
		}
		
		$this->generateView ( array (
				'alreadyInstalled' => $alreadyInstalled, 'showform' => $showform, 'errorMessage' => $errorMessage
		) );
		
	}
	
	public function createdatabase(){
		
		echo '--' . 'function createdatabase()' . '--';
		
		$model = new InitDatabase();
		$errorMessage = $model->createDatabase();
		
		$this->generateView ( array (
			'errorMessage' => $errorMessage
		) );
	}
	
}