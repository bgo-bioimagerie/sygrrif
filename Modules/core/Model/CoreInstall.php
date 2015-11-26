<?php

require_once 'Framework/Model.php';
require_once 'Framework/Configuration.php';

/**
 * Class defining the Install model
 * to edit the config file and initialize de database
 * 
 * @author Sylvain Prigent
 */
class CoreInstall extends Model {

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
			$connection = new PDO( $dsn, $login, $password,
					array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
			return 'success';
			
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
		
	    $dsn = '\'mysql:host=' . $sql_host . ';dbname=' . $db_name .';charset=utf8\'';
	    
		$fileURL = Configuration::getConfigFile();
	    $returnVal = $this->editConfFile($fileURL, $dsn, $sql_host, $db_name, $login, $password);  
	    return $returnVal;  
	}
	
	/**
	 * Internal function that implement the config file edition
	 * 
	 * @param string $fileURL URL of the configuration file
	 * @param string $dsn Connection informations for the PDO connection
	 * @param string $login Login to connect to the database (ex: root)
	 * @param string $password Password to connect to the database
	 * @return boolean
	 */
	protected function editConfFile($fileURL, $dsn, $sql_host, $db_name, $login, $password) {

		$handle = @fopen($fileURL, "r");
		$outContent = '';
		if ($handle) {
			while (($buffer = fgets($handle, 4096)) !== false) {
				
				// replace dsn
				$pos = strpos($buffer, 'dsn');
				if ($pos === false) {
				}
				else if ($pos == 0) {
				    $outContent = $outContent . 'dsn = ' . $dsn . PHP_EOL;
				    continue;
				}
				
				// replace host
				$pos = strpos($buffer, 'host');
				if ($pos === false) {
				}
				else if ($pos == 0) {
					$outContent = $outContent . 'host = ' . $sql_host . PHP_EOL;
					continue;
				}
				
				// replace dbname
				$pos = strpos($buffer, 'dbname');
				if ($pos === false) {
				}
				else if ($pos == 0) {
					$outContent = $outContent . 'dbname = ' . $db_name . PHP_EOL;
					continue;
				}
				
				// replace login
				$pos = strpos($buffer, 'login');
				if ($pos === false) {
				}
				else if ($pos == 0) {
					$outContent = $outContent . 'login = ' . $login . PHP_EOL;
					continue;
				}
				// replace pwd
				$pos = strpos($buffer, 'pwd');
				if ($pos === false) {
				}
				else if ($pos == 0) {
					$outContent = $outContent . 'pwd = "' . $password . '"' . PHP_EOL;
					continue;
				}
				$outContent = $outContent . $buffer;
			}
			if (!feof($handle)) {
				echo "Erreur: fgets() a �chou�\n";
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
}

