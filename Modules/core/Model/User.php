<?php

require_once 'Framework/Model.php';

/**
 * Class defining the User model
 *
 * @author Sylvain Prigent
 */
class User extends Model {

	public function createTable(){
			
		$sql = "CREATE TABLE IF NOT EXISTS `users` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`login` varchar(12) NOT NULL DEFAULT '',
		`firstname` varchar(30) NOT NULL DEFAULT '',
		`name` varchar(30) NOT NULL DEFAULT '',
		`email` varchar(100) NOT NULL DEFAULT '',
		`tel` varchar(30) NOT NULL DEFAULT '',
		`pwd` varchar(50) NOT NULL DEFAULT '',
		`id_unit` int(11) NOT NULL,
		`id_team` int(11) NOT NULL,
		`id_responsible` int(11) NOT NULL,
		`id_status` int(11) NOT NULL,
		`date_created` DATE NOT NULL,
		`date_last_login` DATE NOT NULL,
		PRIMARY KEY (`id`)
		);";
		
		$pdo = $this->runRequest($sql);
		return $pdo;
	}
	
	public function createDefaultUser(){
	
		
		$sql = 'INSERT INTO `users` (`login`, `firstname`, `name`, `id_status`, pwd) VALUES(?,?,?,?,?)';
		$pdo = $this->runRequest($sql, array("admin", "admin", "admin", "3", sha1("admin")));
		return $pdo;
	
		//INSERT INTO `membres` (`pseudo`, `passe`, `email`) VALUES("Pierre", SHA1("dupont"), "pierre@dupont.fr");
	}
	
    /**
     * Verify that a user is in the database
     * 
     * @param string $login the login
     * @param string $pwd the password
     * @return boolean True if the user is in the database
     */
    public function connect($login, $pwd)
    {
        $sql = "select id from users where login=? and pwd=?";
        $user = $this->runRequest($sql, array($login, sha1($pwd)));
        return ($user->rowCount() == 1);
    }

    /**
     * Return a user from the database
     * 
     * @param string $login The login
     * @param string $pwd The password
     * @return The user
     * @throws Exception If the user is not found
     */
    public function getUser($login, $pwd)
    {
        $sql = "select id as idUser, login as login, pwd as pwd 
            from users where login=? and pwd=?";
        $user = $this->runRequest($sql, array($login, sha1($pwd)));
        if ($user->rowCount() == 1)
            return $user->fetch();  // get the first line of the result
        else
            throw new Exception("Cannot find the user using the given parameters");
    }
    
    public function getUsers($sortentry = 'id'){
    	
    	$sql = "select * from users order by " . $sortentry . " ASC;";
    	$user = $this->runRequest($sql);
    	return $user->fetchAll();
    }

    public function userAllInfo($id){
    	$sql = "select * from users where id=?";
    	$user = $this->runRequest($sql, array($id));
    	$userquery = null;
    	if ($user->rowCount() == 1)
    		$userquery = $user->fetch();  // get the first line of the result
    	else
    		throw new Exception("Cannot find the user using the given parameters");
    	
    	// get the status
    	$sql = "select name from status where id=?";
    	$status = $this->runRequest($sql, array($userquery['id_status']));
    	$statusName = "";
    	if ($user->rowCount() == 1)
    		$statusName = $status->fetch()['name'];
    	
    	$userInfo = array(
    			'id' => $userquery['id'],
    			'name' => $userquery['name'],
    			'firstname' => $userquery['firstname'],
    			'login' => $userquery['login'],
    			'email' => $userquery['email'],
    			'tel' => $userquery['tel'],
    			'unit' => $userquery['id_unit'],
    			'team' => $userquery['id_team'],
    			'responsible' => $userquery['id_responsible'],
    			'status' => $statusName   			
    	);
    	return $userInfo;
    }
    
}

