<?php
require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/SyncGRR.php';


class ControllerConfiggrr extends ControllerSecureNav {
	
	public function __construct() {
		
	}
	
	/**
	 * check if a grr have already been configured
	 * 
	 * @return boolean
	 */
	protected function isInstalled(){
		
		$installedVar = Configuration::get("grr_installed");
    	if ($installedVar){
    		return 1;
    	}
    	return 0;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Controller::index()
	 */
	public function index() {

		// get sort action
		$confirmInstall = 0;
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$confirmInstall = $this->request->getParameter ( "actionid" );
		}
		
		$alreadyInstalled  = $this->isInstalled();
		
		
		if ($alreadyInstalled ==1 && $confirmInstall == 0){
			$navBar = $this->navBar();
			$this->generateView ( array (
					'alreadyInstalled' => $alreadyInstalled, 'confirmInstall' => $confirmInstall,
					'navBar' => $navBar
			) );
		}
		else{
			$this->redirect('configgrr', 'form');
		}
		

	}
	
	public function form(){
		
		// get the config information
		$alreadyInstalled  = $this->isInstalled();
		$sql_host = "";
		$db_name = "";
		$login = "";
		$password = "";
		if ($alreadyInstalled == true){
			// get request variables
			$sql_host = Configuration::get("grr_sql_host");
			$db_name = Configuration::get("grr_db_name");
			$login = Configuration::get("grr_login");
			$password = Configuration::get("grr_password");
		}
		
		// get the send info
		$send = "";
		$errorMessage = "";
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$send = $this->request->getParameter ( "actionid" );
		}
		
		if ($send != "" ){
			// get the form inputs
			// get request variables
			$sql_host = $this->request->getParameter("sql_host");
			$login = $this->request->getParameter("login");
			$password = $this->request->getParameter("password");
			$db_name = $this->request->getParameter("db_name");
			
			// test the connection
			$syncModel = new SyncGRR();
			
			$testRes = $syncModel->testConnection($sql_host, $login, $password, $db_name);
			if ( $testRes == 'success'){
				$syncModel->writedbConfig($sql_host, $login, $password, $db_name);
				$this->redirect('configgrr', 'startsync');
				return;
			}
			else{
				$errorMessage = $testRes;
			}
		}	
		
		$this->generateView ( array (
				'sql_host' => $sql_host,
				'login' => $login,
				'password' => $password, 
				'db_name' => $db_name,
				'errorMessage' => $errorMessage
		) );
		
	}
	
	public function startsync(){
		
		$this->generateView ();
	}
	
	public function sync(){
		
		$syncModel = new SyncGRR();
		$exitValue = $syncModel->importGRRUsers();
		
		
		$message = "";
		if ($exitValue){
			$message = "The users have been imported successfully ! ";	
		}
		else{
			$message = "Import Error";
		}
		
		$this->generateView ( array (
				'message' => $message
		) );
	}
	
}