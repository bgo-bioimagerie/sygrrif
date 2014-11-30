<?php

require_once 'Framework/Model.php';

/**
 * Class defining the User model
 *
 * @author Sylvain Prigent
 */
class User extends Model {

	/**
	 * Create the user table
	 * 
	 * @return PDOStatement
	 */
	public function createTable(){
			
		$sql = "CREATE TABLE IF NOT EXISTS `core_users` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`login` varchar(40) NOT NULL DEFAULT '',
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
	
	/** 
	 * Create the default empty user
	 * 
	 * @return PDOStatement
	 */
	public function createDefaultUser(){
	
		$sql = "INSERT INTO core_users (login, firstname, name, id_status, pwd, id_unit,
				                   id_team, id_responsible, date_created)
				 VALUES(?,?,?,?,?,?,?,?,?)";
		$pdo = $this->runRequest($sql, array("--", "--", "--", "1", md5("--"),
				1, 1, 1, "".date("Y-m-d")."" ));
		return $pdo;
	
		//INSERT INTO `membres` (`pseudo`, `passe`, `email`) VALUES("Pierre", md5("dupont"), "pierre@dupont.fr");
	}
	
	/**
	 * Create the default admin user
	 * 
	 * @return PDOStatement
	 */
	public function createDefaultAdmin(){
	
		
		$sql = "INSERT INTO core_users (login, firstname, name, id_status, pwd, id_unit, 
				                   id_team, id_responsible, date_created)
				 VALUES(?,?,?,?,?,?,?,?,?)";
		$pdo = $this->runRequest($sql, array("admin", "administrateur", "admin", "3", md5("admin"),
				                              1, 1, 1, "".date("Y-m-d")."" ));
		return $pdo;
	
		//INSERT INTO `membres` (`pseudo`, `passe`, `email`) VALUES("Pierre", md5("dupont"), "pierre@dupont.fr");
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
        $sql = "select id from core_users where login=? and pwd=?";
        $user = $this->runRequest($sql, array($login, md5($pwd)));
        return ($user->rowCount() == 1);
    }
    
    /**
     * Update the last login date attribut to the todau date
     * 
     * @param int $userId Id of the user to update
     */
    public function updateLastConnection($userId){
    	$sql = "update core_users set date_last_login=? where id=?";
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
            from core_users where login=? and pwd=?";
        $user = $this->runRequest($sql, array($login, md5($pwd)));
        if ($user->rowCount() == 1)
            return $user->fetch();  // get the first line of the result
        else
            throw new Exception("Cannot find the user using the given parameters");
    }
    
    /**
     * Get the users information
     *  
     * @param string $sortentry column used to sort the users
     * @return multitype:
     */
    public function getUsers($sortentry = 'id'){
    	
    	$sql = "select * from core_users order by " . $sortentry . " ASC;";
    	$user = $this->runRequest($sql);
    	return $user->fetchAll();
    }
    
    /**
     * Get the users summary (id, name, firstname)
     *
     * @param string $sortentry column used to sort the users
     * @return multitype:
     */
    public function getUsersSummary($sortentry = 'id'){
    	 
    	$sql = "select id, name, firstname from core_users order by " . $sortentry . " ASC;";
    	$user = $this->runRequest($sql);
    	return $user->fetchAll();
    }
    
    /**
     * get the firstname and name of a user from it's id
     * 
     * @param int $id Id of the user to get
     * @throws Exception
     * @return string "firstname name"
     */
    public function getUserFUllName($id){
    	$sql = "select firstname, name from core_users where id=?";
    	$user = $this->runRequest($sql, array($id));
    	
    	if ($user->rowCount() == 1){
    		$userf = $user->fetch(); 
    		return $userf['firstname'] . " " . $userf['name'];
    	}
    	else
    		throw new Exception("Cannot find the user using the given id");
    }
    
    /**
     * Get the user info by changing the ids by names
     * 
     * @param string $sortentry column used to sort the users
     * @return Ambigous <multitype:, boolean>
     */
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
    
	/**
	 * get the informations of a user from it's id
	 * 
	 * @param int $id Id of the user to query
	 * @throws Exception if the user connot be found
	 */
    public function userAllInfo($id){
    	$sql = "select * from core_users where id=?";
    	$user = $this->runRequest($sql, array($id));
    	$userquery = null;
    	if ($user->rowCount() == 1)
    		return $user->fetch();  // get the first line of the result
    	else
    		throw new Exception("Cannot find the user using the given parameters");
    	
    }
    
    /**
     * add a user to the table
     * 
     * @param string $name
     * @param string $firstname
     * @param string $login
     * @param string $pwd
     * @param string $email
     * @param string $phone
     * @param int $id_unit
     * @param int $id_team
     * @param int $id_responsible
     * @param int $id_status
     * @param int $convention
     * @param date $date_convention
     */
    public function addUser($name, $firstname, $login, $pwd, 
		           			$email, $phone, $id_unit, $id_team, 
		           			$id_responsible, $id_status,
    						$convention, $date_convention ){
    	
    	$sql = "insert into core_users(login, firstname, name, email, tel, pwd, id_unit, id_team, id_responsible, id_status, date_created, convention, date_convention)"
    			. " values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )";
    	$this->runRequest($sql, array($login, $firstname, $name, $email, 
    			                      $phone, md5($pwd), $id_unit, $id_team, 
    			                      $id_responsible, $id_status, "".date("Y-m-d")."",
    			                      $convention, $date_convention));
    	
    }
    
    /**
     * Update the informations of a user
     * 
     * @param int $id
     * @param string $firstname
     * @param string $name
     * @param string $login
     * @param string $email
     * @param string $phone
     * @param int $id_unit
     * @param int $id_team
     * @param int $id_responsible
     * @param int $id_status
     * @param int $convention
     * @param date $date_convention
     */
    public function updateUser($id, $firstname, $name, $login, $email, $phone,
    							$id_unit, $id_team, $id_responsible, $id_status,
    		                    $convention, $date_convention){
    	
    	$sql = "update core_users set login=?, firstname=?, name=?, email=?, tel=?, id_unit=?, id_team=?, id_responsible=?, id_status=?, convention=?, date_convention=? where id=?";
    	$this->runRequest($sql, array($login, $firstname, $name, $email, $phone, $id_unit, $id_team, $id_responsible, $id_status, $convention, $date_convention, $id));
    }
    
    /**
     * Change the password of a user
     * 
     * @param int $id Id of the user to edit
     * @param string $pwd new password
     */
    public function changePwd($id, $pwd){
    	  	
    	$sql = "update core_users set pwd=? where id=?";
    	$user = $this->runRequest($sql, array(md5($pwd), $id));
    }
    
    /**
     * get the password of a user
     * 
     * @param int $id Id of the user to query
     * @throws Exception if the user cannot be found
     * @return mixed array
     */
    public function getpwd($id){
    	$sql = "select pwd from core_users where id=?";
    	$user = $this->runRequest($sql, array($id));
    	$userquery = null;
    	if ($user->rowCount() == 1)
    		return $user->fetch();  // get the first line of the result
    	else
    		throw new Exception("Cannot find the user using the given parameters");
    	 
    }
    
    /**
     * Update the user info that are accessible from account management
     * 
     * @param int $id
     * @param string $firstname
     * @param string $name
     * @param string $email
     * @param string $phone
     */
    public function updateUserAccount($id, $firstname, $name, $email, $phone){
    	$sql = "update core_users set firstname=?, name=?, email=?, tel=? where id=?";
    	$this->runRequest($sql, array($firstname, $name, $email, $phone, $id));
    }
    
    /**
     * Verify that a user is in the database
     *
     * @param string $login the login
     * @return boolean True if the user is in the database
     */
    public function isUser($login)
    {
    	$sql = "select id from core_users where login=?";
    	$user = $this->runRequest($sql, array($login));
    	return ($user->rowCount() == 1);
    }
    
    public function addIfLoginNotExists($login, $name, $firstname, $pwd, $email, $id_status){
    	
    	if ( !$this->isUser($login)){
    		$this->addUser($name, $firstname, $login, $pwd, $email, "", 1, 1, 1, $id_status, "", '');
    	}
    }
}

