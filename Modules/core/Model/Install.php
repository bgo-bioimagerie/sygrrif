<?php

require_once 'Framework/Model.php';
require_once 'Framework/Configuration.php';

/**
 * Class defining the Install model
 * to edit the config file and initialize de database
 * 
 * @author Sylvain Prigent
 */
class Install extends Model {

	
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
	
	public function writedbConfig($sql_host, $login, $password, $db_name){
		
	    $dsn = '\'mysql:host=' . $sql_host . ';dbname=' . $db_name .';charset=utf8\'';

		$fileURL = Configuration::getConfigFile();
	    $returnVal = $this->editConfFile($fileURL, $dsn, $login, $password);  
	    return $returnVal;  
	}
	
	protected function editConfFile($fileURL, $dsn, $login, $password) {

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
					$outContent = $outContent . 'pwd = ' . $password . PHP_EOL;
					continue;
				}
				$outContent = $outContent . $buffer;
			}
			if (!feof($handle)) {
				echo "Erreur: fgets() a échoué\n";
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

