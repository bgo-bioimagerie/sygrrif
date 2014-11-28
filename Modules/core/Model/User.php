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
		`convention` int(11) NOT NULL DEFAULT 0,		
		`date_convention` DATE NOT NULL,
	    `date_created` DATE NOT NULL,
		`date_last_login` DATE NOT NULL,	
		PRIMARY KEY (`id`)
		);";
		
		$pdo = $this->runRequest($sql);
		return $pdo;
	}
	
	public function createDefaultUser(){
	
		$sql = "INSERT INTO users (login, firstname, name, id_status, pwd, id_unit,
				                   id_team, id_responsible, date_created)
				 VALUES(?,?,?,?,?,?,?,?,?)";
		$pdo = $this->runRequest($sql, array("--", "--", "--", "1", sha1("--"),
				1, 1, 1, "".date("Y-m-d")."" ));
		return $pdo;
	
		//INSERT INTO `membres` (`pseudo`, `passe`, `email`) VALUES("Pierre", SHA1("dupont"), "pierre@dupont.fr");
	}
	
	public function createDefaultAdmin(){
	
		
		$sql = "INSERT INTO users (login, firstname, name, id_status, pwd, id_unit, 
				                   id_team, id_responsible, date_created)
				 VALUES(?,?,?,?,?,?,?,?,?)";
		$pdo = $this->runRequest($sql, array("admin", "administrateur", "admin", "3", sha1("admin"),
				                              1, 1, 1, "".date("Y-m-d")."" ));
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
     * Update the last login date attribut to the todau date
     * 
     * @param int $userId Id of the user to update
     */
    public function updateLastConnection($userId){
    	$sql = "update users set date_last_login=? where id=?";
    	$unit = $this->runRequest($sql, array("".date("Y-m-d")."", $userId));
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
    
    public function getUserFUllName($id){
    	$sql = "select firstname, name from users where id=?";
    	$user = $this->runRequest($sql, array($id));
    	
    	if ($user->rowCount() == 1){
    		$userf = $user->fetch(); 
    		return $userf['firstname'] . " " . $userf['name'];
    	}
    	else
    		throw new Exception("Cannot find the user using the given id");
    }
    
    public function getUsersInfo($sortentry = 'id'){
    	$users = $this->getUsers($sortentry);
    	
    	
    	$unitModel = new Unit();
    	$teamModel = new Team();
    	$statusModel = new Status();
    	$respModel = new Responsible();
    	for ($i = 0 ; $i < count($users) ; $i++){	
    		$users[$i]['unit'] = $unitModel->getUnitName($users[$i]['id_unit'])[0];
    		$users[$i]['team'] = $teamModel->getTeamName($users[$i]['id_team'])[0];
    		$users[$i]['status'] = $statusModel->getStatusName($users[$i]['id_status'])[0];
    		$users[$i]['fullname'] = $this->getUserFUllName($users[$i]['id_responsible']);
    		$users[$i]['is_responsible'] = $respModel->isResponsible($users[$i]['id']);
    	}
    	return $users;
    }
    

    public function userAllInfo($id){
    	$sql = "select * from users where id=?";
    	$user = $this->runRequest($sql, array($id));
    	$userquery = null;
    	if ($user->rowCount() == 1)
    		return $user->fetch();  // get the first line of the result
    	else
    		throw new Exception("Cannot find the user using the given parameters");
    	
    }
    
    public function addUser($name, $firstname, $login, $pwd, 
		           			$email, $phone, $id_unit, $id_team, 
		           			$id_responsible, $id_status,
    						$convention, $date_convention ){
    	
    	$sql = "insert into users(login, firstname, name, email, tel, pwd, id_unit, id_team, id_responsible, id_status, date_created, convention, date_convention)"
    			. " values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )";
    	$this->runRequest($sql, array($login, $firstname, $name, $email, 
    			                      $phone, sha1($pwd), $id_unit, $id_team, 
    			                      $id_responsible, $id_status, "".date("Y-m-d")."",
    			                      $convention, $date_convention));
    	
    }
    
    
    public function updateUser($id, $firstname, $name, $login, $email, $phone,
    							$id_unit, $id_team, $id_responsible, $id_status,
    		                    $convention, $date_convention){
    	
    	$sql = "update users set login=?, firstname=?, name=?, email=?, tel=?, id_unit=?, id_team=?, id_responsible=?, id_status=?, convention=?, date_convention=? where id=?";
    	$this->runRequest($sql, array($login, $firstname, $name, $email, $phone, $id_unit, $id_team, $id_responsible, $id_status, $convention, $date_convention, $id));
    }
    
    public function changePwd($id, $pwd){
    	  	
    	$sql = "update users set pwd=? where id=?";
    	$user = $this->runRequest($sql, array(sha1($pwd), $id));
    }
    
    public function getpwd($id){
    	$sql = "select pwd from users where id=?";
    	$user = $this->runRequest($sql, array($id));
    	$userquery = null;
    	if ($user->rowCount() == 1)
    		return $user->fetch();  // get the first line of the result
    	else
    		throw new Exception("Cannot find the user using the given parameters");
    	 
    }
    
    public function updateUserAccount($id, $firstname, $name, $email, $phone){
    	$sql = "update users set firstname=?, name=?, email=?, tel=? where id=?";
    	$this->runRequest($sql, array($firstname, $name, $email, $phone, $id));
    }
    
    
}

