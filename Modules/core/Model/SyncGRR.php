<?php

require_once 'Framework/ModelGRR.php';
require_once 'Modules/core/Model/UserGRR.php';
require_once 'Modules/core/Model/User.php';

/**
 * Class defining the User model
 *
 * @author Sylvain Prigent
 */
class SyncGRR extends ModelGRR {

	
	/**
	 * Test if the database informations are correct
	 * 
	 * @param string $sql_host Host of the database (ex: localhost)
	 * @param string $login Login to connect to the database (ex: root)
	 * @param string $password Password to connect to the database
	 * @param string $db_name Name of the database
	 * @return string error message
	 */
	public function testConnection($sql_host, $login, $password, $db_name){
		
		try {
			$dsn = 'mysql:host=' . $sql_host . ';dbname=' . $db_name .';charset=utf8';
			$bdd = new PDO( $dsn, $login, $password,
					array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
			
			
			$sql = "SHOW TABLES FROM ". $db_name . " LIKE \"grr_utilisateurs\"";
			echo "sql = " . $sql . "--";
			$exec = $bdd ->query($sql);
			$count = $exec->rowCount();
			
			if ($count == 1){
				return 'success';
			}
			else{
				return 'cannot find the GRR user table in the database';
			}
		} catch ( Exception $e ) {
			return $e->getMessage();
		}
	}
	
	/**
	 * Save the database connection information into the config file
	 * 
	 * @param string $sql_host Host of the database (ex: localhost)
	 * @param string $login Login to connect to the database (ex: root)
	 * @param string $password Password to connect to the database
	 * @param string $db_name Name of the database
	 * @return boolean false if unable to write in the file
	 */
	public function writedbConfig($sql_host, $login, $password, $db_name){
		echo "write config file";
		$fileURL = Configuration::getConfigFile();
	    $returnVal = $this->editConfFile($fileURL, $sql_host, $db_name, $login, $password);  
	    return $returnVal;  
	}
	
	/**
	 * Internal function that implement the config file edition
	 *
	 * @param string $fileURL URL of the configuration file
	 * @param string $sql_host Connection host
	 * @param string $db_name Name of the database
	 * @param string $login Login to connect to the database (ex: root)
	 * @param string $password Password to connect to the database
	 * @return boolean
	 */
	protected function editConfFile($fileURL, $sql_host, $db_name, $login, $password) {
		echo "edit config file";
		
		$handle = @fopen($fileURL, "r");
		$outContent = '';
		if ($handle) {
			while (($buffer = fgets($handle, 4096)) !== false) {
	
				// replace grr_installed
				$pos = strpos($buffer, 'grr_installed');
				if ($pos === false) {
				}
				else if ($pos == 0) {
					$outContent = $outContent . 'grr_installed = true' . PHP_EOL;
					continue;
				}
				// replace sql host
				$pos = strpos($buffer, 'grr_sql_host');
				if ($pos === false) {
				}
				else if ($pos == 0) {
					$outContent = $outContent . 'grr_sql_host =' . $sql_host . PHP_EOL;
					continue;
				}
				// replace grr_db_name
				$pos = strpos($buffer, 'grr_db_name');
				if ($pos === false) {
				}
				else if ($pos == 0) {
					$outContent = $outContent . 'grr_db_name =' . $db_name . PHP_EOL;
					continue;
				}
				// replace login
				$pos = strpos($buffer, 'grr_login');
				if ($pos === false) {
				}
				else if ($pos == 0) {
					$outContent = $outContent . 'grr_login =' . $login . PHP_EOL;
					continue;
				}
				// replace pwd
				$pos = strpos($buffer, 'grr_password');
				if ($pos === false) {
				}
				else if ($pos == 0) {
					$outContent = $outContent . 'grr_password =' . $password . PHP_EOL;
					continue;
				}
				$outContent = $outContent . $buffer;
			}
			if (!feof($handle)) {
				echo "Erreur: fgets() failed\n";
			}
			fclose($handle);
		}
		else{
			return false;
		}
	
		// save the new cong file
		$fp = fopen($fileURL, 'w');
		fwrite($fp, $outContent);
		fclose($fp);
		return true;
	}

	public function importGRRUsers(){
		
		// get grr users
		$grrModel = new UserGRR();
		$grrUsers = $grrModel->getUsers();
		
		// add them to core_users table
		$userModel = new User();
		foreach ($grrUsers as $grruser){
			$login = $name = $grruser['login'];
			$name = $grruser['nom'];
			$firstname = $grruser['prenom'];
			$pwd = $grruser['password'];
			$email = $grruser['email'];
			
			$grrstatus = $grruser['statut'];
			$id_status = 1; 
			if ($grrstatus == "gestionnaire_utilisateur"){
				$id_status = 2;
			}
			if ($grrstatus == "administrateur"){
				$id_status = 3;
			}
			
			$userModel->addIfLoginNotExists($login, $name, $firstname, $pwd, $email, $id_status);
		}	
		
		return true;
	}
}	

