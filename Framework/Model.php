<?php

require_once 'Configuration.php';

/**
 * Abstract class Model
 * A model define an access to the database
 *
 * @author Sylvain Prigent
 */
abstract class Model
{
    /** PDO object of the database 
     */
    private static $bdd;

    /**
     * Run a SQL request
     * 
     * @param string $sql SQL request
     * @param array $params Request parameters
     * @return PDOStatement Result of the request
     */
    protected function runRequest($sql, $params = null)
    {
	        if ($params == null) {
	            $result = self::getDatabase()->query($sql);   // direct query
	        }
	        else {
	            $result = self::getDatabase()->prepare($sql); // prepared request
	            $result->execute($params);
	        }
	        return $result;
    }

    /**
     * Return an object that connect the database and initialize the connection if needed
     * 
     * @return PDO Objet PDO of the database connections
     */
    protected static function getDatabase()
    {
        if (self::$bdd === null) {
            // load the database informations
            $dsn = Configuration::get("dsn");
            $login = Configuration::get("login");
            $pwd = Configuration::get("pwd");
            // Create connection
            self::$bdd = new PDO($dsn, $login, $pwd,
                    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            self::$bdd->exec("SET CHARACTER SET utf8");
        }
        return self::$bdd;
    }
    
    public function addColumn($tableName, $columnName, $columnType, $defaultValue){
    
        $sql = "SHOW COLUMNS FROM `".$tableName."` LIKE '".$columnName."'";
	$pdo = $this->runRequest($sql);
	$isColumn = $pdo->fetch();
        if ( $isColumn == false){
            $sql = "ALTER TABLE `".$tableName."` ADD `".$columnName."` ".$columnType." NOT NULL DEFAULT '".$defaultValue."'";
            $pdo = $this->runRequest($sql);
        }
    }
            
    public function isTable($table){
    	
    	$dsn = Configuration::get("dsn");
    	$dsnArray = explode(";", $dsn);
    	$dbname = "";
    	for($i = 0 ; $i < count($dsnArray) ; $i++){
    		if (strpos($dsnArray[$i], "dbname") === false){
    		}
    		else{
    			$dbnameArray = explode("=", $dsnArray[$i]);
    			$dbname = $dbnameArray[0];
    			break;
    		}
    	}
    	
    	$sql = 'SHOW TABLES FROM '. Configuration::get($dbname) . ' LIKE \''. $table. '\'';
    	$req = $this->runRequest($sql);
    	if ($req->rowCount() == 1){
    		return true;
    	}
    	return false;
    	
    }

}
