<?php

require_once 'Configuration.php';

/**
 * Abstract class ModelGRR
 * A model define an access to the GRR database
 *
 * @author Sylvain Prigent
 */
abstract class ModelGRR
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
    private static function getDatabase()
    {
        if (self::$bdd === null) {
            // load the database informations
            $dsn = Configuration::get("grr_dsn");
            $login = Configuration::get("grr_login");
            $pwd = Configuration::get("grr_pwd");
            // Create connection
            self::$bdd = new PDO($dsn, $login, $pwd,
                    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        }
        return self::$bdd;
    }

}
