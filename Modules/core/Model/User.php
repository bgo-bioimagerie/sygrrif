<?php

require_once 'Framework/Model.php';
require_once 'Modules/core/Model/CoreConfig.php';

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
		`id_responsible` int(11) NOT NULL,
		`id_status` int(11) NOT NULL,
		`convention` int(11) NOT NULL DEFAULT 0,		
		`date_convention` DATE NOT NULL,
	    `date_created` DATE NOT NULL,
		`date_last_login` DATE NOT NULL,
		`date_end_contract` DATE NOT NULL,	
		`is_active` int(1) NOT NULL DEFAULT 1,				
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
	
		if (!$this->isUser("--")){
		
			$sql = "INSERT INTO core_users (login, firstname, name, id_status, pwd, id_unit,
				                   id_responsible, date_created)
				 VALUES(?,?,?,?,?,?,?,?)";
			$this->runRequest($sql, array("--", "--", "--", "1", md5("--"),
				1, 1, "".date("Y-m-d")."" ));
		}	
	}
	
	/**
	 * Create the default admin user
	 * 
	 * @return PDOStatement
	 */
	public function createDefaultAdmin(){
	
		if (!$this->isUser("admin")){
			$sql = "INSERT INTO core_users (login, firstname, name, id_status, pwd, id_unit, 
				                   id_responsible, date_created)
				 VALUES(?,?,?,?,?,?,?,?)";
			$this->runRequest($sql, array("admin", "administrateur", "admin", "4", md5("admin"),
				                              1, 1, "".date("Y-m-d")."" ));
		}
	
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
        $sql = "select id, is_active from core_users where login=? and pwd=?";
        $user = $this->runRequest($sql, array($login, md5($pwd)));
        if ($user->rowCount() == 1){
        	$req = $user->fetch();
        	if ($req["is_active"] == 1){
        		return true;
        	}
        	else{
        		return "Your account is not active";
        	}
        }
        else{
        	return "Login or password not correct";
        }
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
        $sql = "select id as idUser, login as login, pwd as pwd, id_status, is_active 
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
    public function getUsersSummary($sortentry = 'id', $active = 1){
    	 
    	$sql = "select id, name, firstname from core_users where is_active >= ".$active." order by " . $sortentry . " ASC;";
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
    		return $userf['name'] . " " . $userf['firstname'];
    	}
    	else
    		return "";
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
    	$statusModel = new Status();
    	$respModel = new Responsible();
    	for ($i = 0 ; $i < count($users) ; $i++){	
    		$users[$i]['unit'] = $unitModel->getUnitName($users[$i]['id_unit']);
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
     * @param int $id_responsible
     * @param int $id_status
     * @param int $convention
     * @param date $date_convention
     */
    public function addUser($name, $firstname, $login, $pwd, 
		           			$email, $phone, $id_unit, 
		           			$id_responsible, $id_status,
    						$convention, $date_convention,
    						$date_end_contract="", $is_active=1 ){
    	
    	$sql = "insert into core_users(login, firstname, name, email, tel, pwd, id_unit, id_responsible, 
    			                       id_status, date_created, convention, date_convention, date_end_contract,is_active)"
    			. " values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )";
    	$this->runRequest($sql, array($login, $firstname, $name, $email, 
    			                      $phone, md5($pwd), $id_unit, 
    			                      $id_responsible, $id_status, "".date("Y-m-d")."",
    			                      $convention, $date_convention, $date_end_contract,
    			                      $is_active
    	));
    	
    }
    
    public function setUser($name, $firstname, $login, $pwd,
    		$email, $phone, $id_unit,
    		$id_responsible, $id_status,
    		$convention, $date_convention, $date_end_contract="",$is_active=1 ){
    	
    	if (!$this->isUser($login)){
    		$this->addUser($name, $firstname, $login, $pwd, $email, $phone, 
    				$id_unit, $id_responsible, $id_status, $convention, $date_convention,
    				$date_end_contract, $is_active);
    	}
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
     * @param int $id_responsible
     * @param int $id_status
     * @param int $convention
     * @param date $date_convention
     */
    public function updateUser($id, $firstname, $name, $login, $email, $phone,
    							$id_unit, $id_responsible, $id_status,
    		                    $convention, $date_convention, $date_end_contract="",
    		                    $is_active=1){
    	
    	$sql = "update core_users set login=?, firstname=?, name=?, email=?, tel=?, id_unit=?, id_responsible=?, id_status=?,
    			                      convention=?, date_convention=?, date_end_contract=?, is_active=? 
    			                  where id=?";
    	$this->runRequest($sql, array($login, $firstname, $name, $email, $phone, $id_unit, 
    			                      $id_responsible, $id_status, $convention, $date_convention, 
    			                      $date_end_contract, $is_active, $id));
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
    	if ($user->rowCount() == 1)
    		return true;  // get the first line of the result
    	else
    		return false;
    }
    
    public function userIdFromLogin($login)
    {
    	$sql = "select id from core_users where login=?";
    	$user = $this->runRequest($sql, array($login));
    	if ($user->rowCount() == 1)
    		return $user->fetch()[0];
    	else
    		return -1;
    }
    
    
    public function addIfLoginNotExists($login, $name, $firstname, $pwd, $email, $id_status){
    	
    	if ( !$this->isUser($login)){
    		$this->addUser($name, $firstname, $login, $pwd, $email, "", 1, 1, 1, $id_status, "", '');
    	}
    }
    
    public function setUnitId($login, $unitId){
    	$sql = "update core_users set id_unit=? where login=?";
    	$this->runRequest($sql, array($unitId, $login));
    }
    
    public function getUserIdFromFullName($fullname){
    	$sql = "select firstname, name, id from core_users";
    	$user = $this->runRequest($sql);
    	$users = $user->fetchAll();
    	
    	foreach ($users as $user){
    		$curentFullname = $user['name'] . " " . $user['firstname'];
    		if ($fullname == $curentFullname){
    			return $user['id'];
    		} 
    	}
    	return -1;
    }
    
    public function setResponsible($idUser, $idResp){
    	$sql = "update core_users set id_responsible=? where id=?";
    	$this->runRequest($sql, array($idResp, $idUser));
    }
    
    public function getResponsibleOfUnit($unitId){
    	$sql = "select id, name, firstname from core_users where id in (select id_users from core_responsibles) and id_unit=? ORDER BY name";
    	return $this->runRequest($sql, array($unitId));
    }
    
    public function getUserFromlup($id, $unit_id, $responsible_id){
    	$sql = 'SELECT name, firstname, id_responsible FROM core_users WHERE id=? AND id_unit=? AND id_responsible=?';
    	$req = $this->runRequest($sql, array($id, $unit_id, $responsible_id));
    	return $req->fetchAll();
    }
    
    public function getUserFromIdUnit($id, $unit_id){
    	$sql = "SELECT name, firstname, id_responsible, id_unit FROM core_users WHERE id=?";
    	if ($unit_id > 0){
    		$sql .= " AND id_unit=" . $unit_id; 
    	}
    	
    	$req = $this->runRequest($sql, array($id));
    	return $req->fetchAll();
    }
    
    public function getLastConnection($id){
    	$sql = "select date_last_login from core_users where id=?";
    	$user = $this->runRequest($sql, array($id));
    	if ($user->rowCount() == 1)
    		return $user->fetch()[0];
    	else
    		return "0000-00-00";
    }
    
    public function setLastConnection($id, $time){
    	$sql = "update core_users set date_last_login=? where id=?";
    	$this->runRequest($sql, array($time, $id));
    }
    
    public function updateUsersActive(){
    	$modelConfig = new CoreConfig();
    	$desactivateType = $modelConfig->getParam("user_desactivate");
    	
    	if ($desactivateType > 1){
    		if ($desactivateType == 2){
    			$this->updateUserActiveContract();
    		}	
    		else if ($desactivateType == 3){
    			$this->updateUserActiveLastLogin(1);
    		}
    		else if ($desactivateType == 4){
    			$this->updateUserActiveLastLogin(2);
    		}
    		else if ($desactivateType == 5){
    			$this->updateUserActiveLastLogin(3);
    		}
    	
    	}
    }
    
    public function setactive($id, $active){
    	$sql = "update core_users set is_active=? where id=?";
    	$this->runRequest($sql, array($active, $id));
    }
    
    private function updateUserActiveContract(){
    	$sql="select id, date_end_contract from core_users where is_active=1";
    	$req = $this->runRequest($sql);
    	$users = $req->fetchAll();
    	
    	foreach ($users as $user){
    		$contractDate = $user["date_end_contract"];
    		$today = date("Y-m-d", time());
    		
    		if ($contractDate < $today){
    			$this->setactive($id, 0);
    		}
    	}
    }
    
    private function updateUserActiveLastLogin($numberYear){
    	
    	$sql="select id, date_last_login from core_users where is_active=1";
    	$req = $this->runRequest($sql);
    	$users = $req->fetchAll();
    	 
    	foreach ($users as $user){
    		$lastLoginDate = $user["date_last_login"];
    		$lastLoginDate = explode("-", $lastLoginDate);
    		$timell = mktime(0,0,0, $lastLoginDate[1], $lastLoginDate[2], $lastLoginDate[0]);
    		$timell = date("Y-m-d", $timell + $numberYear*31556926);
    		$today = date("Y-m-d", time());
    	
    		$changedUsers = array();
    		if ($lastLoginDate[0] != "0000"){
	    		if ($timell <= $today){
	    			$this->setactive($user['id'], 0);
	    			$changedUsers[] = $user['id'];
	    		}
    		}
    	}
    	
    	$modelConfig = new CoreConfig();
    	
    	if ($modelConfig->isKey("sygrrif_installed")){
    		require_once 'Modules/sygrrif/Model/SyAuthorization.php';
    		$authModel = new SyAuthorization();
    		$authModel->desactivateAthorizationsForUsers($changedUsers);
    	}
    }
    
    public function activate($userId){
    	$today = date("Y-m-d", time());
    	
    	$sql = "update core_users set is_active=?, date_last_login=? where id=?";
    	$this->runRequest($sql, array(1, $today, $userId));
    }
    
}

