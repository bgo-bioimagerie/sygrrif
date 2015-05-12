<?php

require_once 'Framework/Model.php';

/**
 * Class defining the Unit model
 *
 * @author Sylvain Prigent
 */
class StUserQuota extends Model {

	/**
	 * Create the unit table
	 * 
	 * @return PDOStatement
	 */
	public function createTable(){
			
		$sql = "CREATE TABLE IF NOT EXISTS `st_userquotas` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`quota` varchar(30) NOT NULL DEFAULT '',
		PRIMARY KEY (`id`)
		);";
		
		$pdo = $this->runRequest($sql);
		return $pdo;
	}
	
	/**
	 * get units informations
	 * 
	 * @param string $sortentry Entry that is used to sort the users
	 * @return multitype: array
	 */
	public function getQuotas($sortentry = 'id'){
		 
		$sql = "select * from st_userquotas order by " . $sortentry . " ASC;";
		$user = $this->runRequest($sql);
		return $user->fetchAll();
	}
	
	public function getUsersQuotas($sortentry = 'id'){
		
		$sql = "select user.id AS id, user.login AS login,
				       user.firstname AS firstname, user.name AS name,
					   q.quota AS quota 
				from st_userquotas as q
				INNER JOIN core_users AS user ON user.id = q.id
				ORDER BY user.name;";
		$user = $this->runRequest($sql);
		return $user->fetchAll();
	}
	
	public function getUserQuota($userID){
	
		$sql = "select user.id AS id, user.login AS login,
				       user.firstname AS firstname, user.name AS name,
					   q.quota AS quota
				from st_userquotas as q
				INNER JOIN core_users AS user ON user.id = q.id
				WHERE q.id=".$userID.";";
		$user = $this->runRequest($sql);
		return $user->fetchAll();
	}
	
	/**
	 * add a user to the table
	 *
	 * @param string $id id of the user
	 * @param string $quota quotas for the user
	 */
	public function addQuota($id, $quota){
		
		$sql = "insert into st_userquotas(id, quota)"
				. " values(?, ?)";
		$user = $this->runRequest($sql, array($id, $quota));		
	}
	
	/**
	 * update the information of a quota
	 *
	 * @param string $id id of the user
	 * @param string $quota quotas for the user
	 */
	public function editQuota($id, $quota){
		
		$sql = "update st_userquotas set quota=? where id=?";
		$unit = $this->runRequest($sql, array("".$quota."", $id));
	}
	
	
	public function isQuota($id){
		$sql = "select * from st_userquotas where id=?";
		$unit = $this->runRequest($sql, array($id));
		if ($unit->rowCount() == 1)
			return true;
		else
			return false;
	}
	
	public function setQuota($id, $quota){
		if (!$this->isQuota($id)){
			$this->addQuota($id, $quota);
		}
		else{
			$this->editQuota($id, $quota);
		}
	}
	
	/**
	 * get the quota of a user
	 *
	 * @param int $id Id of the user to query
	 * @throws Exception id the user is not found
	 * @return mixed array
	 */
	public function getQuota($id){
		$sql = "select * from st_userquotas where id=?";
		$unit = $this->runRequest($sql, array($id));
		if ($unit->rowCount() == 1)
    		return $unit->fetch();  // get the first line of the result
    	else
    		throw new Exception("Cannot find the quotas using the given id"); 
	}

}

