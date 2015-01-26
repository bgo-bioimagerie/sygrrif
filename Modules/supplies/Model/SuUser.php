<?php

require_once 'Framework/Model.php';
require_once 'Modules/core/Model/CoreConfig.php';
/**
 * Class defining the User model for the Co module
 *
 * @author Sylvain Prigent
 */
class SuUser extends Model {

	/**
	 * Create the user table
	 * 
	 * @return PDOStatement
	 */
	public function createTable(){
			
		$sql = "CREATE TABLE IF NOT EXISTS `su_users` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`firstname` varchar(30) NOT NULL DEFAULT '',
		`name` varchar(30) NOT NULL DEFAULT '',
		`email` varchar(100) NOT NULL DEFAULT '',
		`tel` varchar(30) NOT NULL DEFAULT '',
		`id_unit` int(11) NOT NULL,
		`id_responsible` int(11) NOT NULL,		
	    `date_created` DATE NOT NULL,	
		`is_active` int(1) NOT NULL DEFAULT 1,				
		PRIMARY KEY (`id`)
		);";
		
		$pdo = $this->runRequest($sql);
		return $pdo;
	}
	
	public function createDefaultUser(){
	
		if (!$this->isUser("--")){
	
			$sql = "INSERT INTO su_users (firstname, name, id_unit,
				                   id_responsible, date_created)
				 VALUES(?,?,?,?,?)";
			$this->runRequest($sql, array("--", "--",
					1, 1, "".date("Y-m-d")."" ));
		}
	}
    
	/**
	 * Verify that a user is in the database
	 *
	 * @param string $login the login
	 * @return boolean True if the user is in the database
	 */
	public function isUser($name)
	{
		$sql = "select id from su_users where name=?";
		$user = $this->runRequest($sql, array($name));
		if ($user->rowCount() == 1)
			return true;  // get the first line of the result
		else
			return false;
	}
	
	public function defaultUserAllInfo(){
		
		$user = array();
		$user['id'] = "";
		$user['firstname'] = ""; 
		$user['name'] = ""; 
		$user['email'] = ""; 
		$user['tel'] = "";
		$user['id_unit'] = "";
		$user['id_responsible'] = "";
		$user['is_active'] = 1;
		
		return $user;
	}
	
    /**
     * Get the users information
     *  
     * @param string $sortentry column used to sort the users
     * @return multitype:
     */
    public function getUsers($sortentry = 'id'){
    	
    	$sql = "select * from su_users order by " . $sortentry . " ASC;";
    	$user = $this->runRequest($sql);
    	return $user->fetchAll();
    }
    
    /**
     * Get the active users information
     *
     * @param string $sortentry column used to sort the users
     * @return multitype:
     */
    public function getActiveUsers($sortentry = 'id'){
    	 
    	$sql = "select * from su_users where is_active >= 1 order by " . $sortentry . " ASC;";
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
    	 
    	$sql = "select id, name, firstname from su_users where is_active >= ".$active." order by " . $sortentry . " ASC;";
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
    	$sql = "select firstname, name from su_users where id=?";
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
    	
    	
    	$unitModel = new SuUnit();
    	$respModel = new SuResponsible();
    	for ($i = 0 ; $i < count($users) ; $i++){	
    		$users[$i]['unit'] = $unitModel->getUnitName($users[$i]['id_unit']);
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
    	$sql = "select * from su_users where id=?";
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
     * @param string $email
     * @param string $phone
     * @param int $id_unit
     * @param int $id_responsible
     * @param int $id_status
     */
    public function addUser($name, $firstname, 
		           			$email, $phone, $id_unit, 
		           			$id_responsible,
    						$is_active=1 ){
    	
    	$sql = "insert into su_users(firstname, name, email, tel, id_unit, id_responsible, 
    			                       date_created, is_active)"
    			. " values(?, ?, ?, ?, ?, ?, ?, ? )";
    	$this->runRequest($sql, array($firstname, $name, $email, 
    			                      $phone, $id_unit, 
    			                      $id_responsible, "".date("Y-m-d")."",
    			                      $is_active
    	));
    	
    	return $this->getDatabase()->lastInsertId();
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
     */
    public function updateUser($id, $name, $firstname, 
		           			$email, $phone, $id_unit, 
		           			$id_responsible,
    						$is_active=1){
    	
    	$sql = "update su_users set firstname=?, name=?, email=?, tel=?, id_unit=?, id_responsible=?,
    			                      is_active=? 
    			                  where id=?";
    	$this->runRequest($sql, array($firstname, $name, $email, $phone, $id_unit, 
    			                      $id_responsible, $is_active, $id));
    }
    
    
    public function setUnitId($login, $unitId){
    	$sql = "update su_users set id_unit=? where login=?";
    	$this->runRequest($sql, array($unitId, $login));
    }
    
    public function getUserIdFromFullName($fullname){
    	$sql = "select firstname, name, id from su_users";
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
    	$sql = "update su_users set id_responsible=? where id=?";
    	$this->runRequest($sql, array($idResp, $idUser));
    }
    
    public function getResponsibleOfUnit($unitId){
    	$sql = "select id, name, firstname from su_users where id in (select id_users from su_responsibles) and id_unit=? ORDER BY name";
    	return $this->runRequest($sql, array($unitId));
    }
    
    public function setactive($id, $active){
    	$sql = "update su_users set is_active=? where id=?";
    	$this->runRequest($sql, array($active, $id));
    }
    
   
    public function activate($userId){
    	$today = date("Y-m-d", time());
    	
    	$sql = "update su_users set is_active=?, 
    		           where id=?";
    	$this->runRequest($sql, array(1, $userId));
    }
    
    public function getUserFromNameFirstname($name, $firstname){
    	$sql = "select id from su_users where name=? and firstname=?";
    	$user = $this->runRequest($sql, array($name, $firstname));

    if ($user->rowCount() == 1){
			$tmp = $user->fetch();
			return $tmp[0];
		}
    	else{
    		return -1;
		}
    }
    
    public function getUserFromlup($id, $unit_id, $responsible_id){
    	$sql = 'SELECT name, firstname, id_responsible FROM su_users WHERE id=? AND id_unit=? AND id_responsible=?';
    	$req = $this->runRequest($sql, array($id, $unit_id, $responsible_id));
    	return $req->fetchAll();
    }
}

