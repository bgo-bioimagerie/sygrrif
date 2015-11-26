<?php
require_once 'Framework/Model.php';
require_once 'Modules/core/Model/CoreConfig.php';

/**
 * Class defining the User model
 *
 * @author Sylvain Prigent
 */
class CoreUser extends Model {
	
	/**
	 * Create the user table
	 *
	 * @return PDOStatement
	 */
	public function createTable() {
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
		`source` varchar(30) NOT NULL DEFAULT 'local',								
		PRIMARY KEY (`id`)
		);";
		
		$pdo = $this->runRequest ( $sql );
		return $pdo;
	}
	
	/**
	 * Create the default empty user
	 *
	 * @return PDOStatement
	 */
	public function createDefaultUser() {
		if (! $this->isUser ( "--" )) {
			
			$sql = "INSERT INTO core_users (login, firstname, name, id_status, pwd, id_unit,
				                   id_responsible, date_created)
				 VALUES(?,?,?,?,?,?,?,?)";
			$this->runRequest ( $sql, array (
					"--",
					"--",
					"--",
					"1",
					md5 ( "--" ),
					1,
					1,
					"" . date ( "Y-m-d" ) . "" 
			) );
		}
	}
	
	/**
	 * Create the default admin user
	 *
	 * @return PDOStatement
	 */
	public function createDefaultAdmin() {
		if (! $this->isUser ( "admin" )) {
			$sql = "INSERT INTO core_users (login, firstname, name, id_status, pwd, id_unit, 
				                   id_responsible, date_created)
				 VALUES(?,?,?,?,?,?,?,?)";
			$this->runRequest ( $sql, array (
					"admin",
					"administrateur",
					"admin",
					"4",
					md5 ( "admin" ),
					1,
					1,
					"" . date ( "Y-m-d" ) . "" 
			) );
		}
		
		// INSERT INTO `membres` (`pseudo`, `passe`, `email`) VALUES("Pierre", md5("dupont"), "pierre@dupont.fr");
	}
	
	/**
	 * Check if a user is active
	 * @param string $login User login
	 * @return string Error or success message
 	 */
	public function isActive($login){
		$sql = "select id, is_active from core_users where login=?";
		$user = $this->runRequest ( $sql, array (
				$login
		) );
		if ($user->rowCount () == 1) {
			$req = $user->fetch ();
			if ($req ["is_active"] == 1) {
				return "allowed";
			} else {
				return "Your account is not active";
			}
		} else {
			return "Login or password not correct";
		}
	}
	/**
	 * Verify that a user is in the database
	 *
	 * @param string $login
	 *        	the login
	 * @param string $pwd
	 *        	the password
	 * @return boolean True if the user is in the database
	 */
	public function connect($login, $pwd) {
		$sql = "select id, is_active from core_users where login=? and pwd=?";
		$user = $this->runRequest ( $sql, array (
				$login,
				md5 ( $pwd ) 
		) );
		if ($user->rowCount () == 1) {
			$req = $user->fetch ();
			if ($req ["is_active"] == 1) {
				return "allowed";
			} else {
				return "Your account is not active";
			}
		} else {
			return "Login or password not correct";
		}
	}
	/**
	 * Verify that a user is in the database 
	 *
	 * @param string $login
	 *        	the login
	 * @param string $pwd
	 *        	the password encoded in MD5
	 * @return boolean True if the user is in the database
	 */
	public function connect2($login, $pwd) {
		$sql = "select id, is_active from core_users where login=? and pwd=?";
		$user = $this->runRequest ( $sql, array (
				$login,
				$pwd 
		) );
		if ($user->rowCount () == 1) {
			$req = $user->fetch ();
			if ($req ["is_active"] == 1) {
				return "allowed";
			} else {
				return "Your account is not active";
			}
		} else {
			return "Login or password not correct";
		}
	}
	
	/**
	 * Update the last login date attribut to the todau date
	 *
	 * @param int $userId
	 *        	Id of the user to update
	 */
	public function updateLastConnection($userId) {
		$sql = "update core_users set date_last_login=? where id=?";
		$unit = $this->runRequest ( $sql, array (
				"" . date ( "Y-m-d" ) . "",
				$userId 
		) );
	}
	
	/**
	 * Return a user from the database
	 *
	 * @param string $login
	 *        	The login
	 * @param string $pwd
	 *        	The password
	 * @return The user
	 * @throws Exception If the user is not found
	 */
	public function getUser($login, $pwd) {
		$sql = "select id as idUser, login as login, pwd as pwd, id_status, is_active 
            from core_users where login=? and pwd=?";
		$user = $this->runRequest ( $sql, array (
				$login,
				md5 ( $pwd ) 
		) );
		if ($user->rowCount () == 1)
			return $user->fetch (); // get the first line of the result
		else
			throw new Exception ( "Cannot find the user using the given parameters" );
	}
	
	/**
	 * Get the user informations from login
	 * @param string $login User login
	 * @throws Exception
	 * @return array User info (id, login, pwd, id_status, is_active)
	 */
	public function getUserByLogin($login) {
		$sql = "select id as idUser, login as login, pwd as pwd, id_status, is_active
            from core_users where login=?";
		$user = $this->runRequest ( $sql, array (
				$login
		) );
		if ($user->rowCount () == 1)
			return $user->fetch (); // get the first line of the result
		else
			throw new Exception ( "Cannot find the user using the given parameters" );
	}
	
	/**
	 * Get the user login from id
	 * @param number $id User ID
	 * @throws Exception
	 * @return mixed
	 */
	public function userLogin($id){
		$sql = "select login from core_users where id=?";
		$user = $this->runRequest ( $sql, array (
				$id
		) );
		if ($user->rowCount () == 1){
			$tmp = $user->fetch ();
			return $tmp[0]; // get the first line of the result
		}
		else{
			throw new Exception ( "Cannot find the user login using the given id" );
		}
	}
	
	/**
	 * Get the users information
	 *
	 * @param string $sortentry
	 *        	column used to sort the users
	 * @return multitype:
	 */
	public function getUsers($sortentry = 'id') {
		$sql = "select * from core_users order by " . $sortentry . " ASC;";
		$user = $this->runRequest ( $sql );
		return $user->fetchAll ();
	}
	
	/**
	 * Get the emails of all active users
	 * @return multitype:
	 */
	public function getAllActifEmails(){
		$sql = "select email from core_users where is_active=1 order by name ASC;";
		$user = $this->runRequest ( $sql );
		return $user->fetchAll ();
	}
	
	/**
	 * Get the users information
	 *
	 * @param string $sortentry
	 *        	column used to sort the users
	 * @return multitype:
	 */
	public function getActiveUsers($sortentry = 'id', $is_active = 1) {
		$sql = "select * from core_users where is_active=" . $is_active . " order by " . $sortentry . " ASC;";
		$user = $this->runRequest ( $sql );
		return $user->fetchAll ();
	}
	
	/**
	 * Get the users summary (id, name, firstname)
	 *
	 * @param string $sortentry
	 *        	column used to sort the users
	 * @return multitype:
	 */
	public function getUsersSummary($sortentry = 'id', $active = 1) {
		$sql = "select id, name, firstname from core_users where is_active >= " . $active . " order by " . $sortentry . " ASC;";
		$user = $this->runRequest ( $sql );
		return $user->fetchAll ();
	}
	
	/**
	 * get the firstname and name of a user from it's id
	 *
	 * @param int $id
	 *        	Id of the user to get
	 * @throws Exception
	 * @return string "firstname name"
	 */
	public function getUserFUllName($id) {
		$sql = "select firstname, name from core_users where id=?";
		$user = $this->runRequest ( $sql, array (
				$id 
		) );
		
		if ($user->rowCount () == 1) {
			$userf = $user->fetch ();
			return $userf ['name'] . " " . $userf ['firstname'];
		} else
			return "";
	}
	
	/**
	 * GEt the responsible of a given user
	 * @param number $id User id
	 * @return number Responsible ID
	 */
	public function getUserResponsible($id){
		$sql = "select id_responsible from core_users where id=?";
		$user = $this->runRequest ( $sql, array ($id) );
		$userf = $user->fetch ();
		return $userf [0];
	}
	
	/**
	 * Get the unit ID for a given user
	 * @param number $id
	 * @return Number: Unit ID
	 */
	public function getUserUnit($id){
		$sql = "select id_unit from core_users where id=?";
		$user = $this->runRequest ( $sql, array ($id) );
		$userf = $user->fetch ();
		return $userf [0];
	}
	
	/**
	 * Get the user email
	 * @param number $id User ID
	 * @return string User email
	 */
	public function getUserEmail($id){
		$sql = "select email from core_users where id=?";
		$user = $this->runRequest ( $sql, array ($id) );
		$userf = $user->fetch ();
		return $userf [0];
	}
	
	/**
	 * Get the user info by changing the ids by names
	 *
	 * @param string $sortentry
	 *        	column used to sort the users
	 * @return Ambigous <multitype:, boolean>
	 */
	public function getUsersInfo($sortentry = 'id') {
		$users = $this->getUsers ( $sortentry );
		
		$unitModel = new Unit ();
		$statusModel = new Status ();
		$respModel = new CoreResponsible ();
		for($i = 0; $i < count ( $users ); $i ++) {
			$users [$i] ['unit'] = $unitModel->getUnitName ( $users [$i] ['id_unit'] );
			$tmp = $statusModel->getStatusName ( $users [$i] ['id_status'] );
			$users [$i] ['status'] = $tmp [0];
			$users [$i] ['fullname'] = $this->getUserFUllName ( $users [$i] ['id_responsible'] );
			$users [$i] ['is_responsible'] = $respModel->isResponsible ( $users [$i] ['id'] );
		}
		return $users;
	}
	
	/**
	 * Get the active user info by changing the ids by names
	 *
	 * @param string $sortentry
	 *        	column used to sort the users
	 * @return Ambigous <multitype:, boolean>
	 */
	public function getActiveUsersInfo($sortentry = 'id', $is_active = 1) {
		$sqlSort = "user.id";
		if ($sortentry == "name") {
			$sqlSort = "user.name";
		} else if ($sortentry == "firstname") {
			$sqlSort = "user.firstname";
		} else if ($sortentry == "login") {
			$sqlSort = "user.login";
		} else if ($sortentry == "email") {
			$sqlSort = "user.email";
		} else if ($sortentry == "tel") {
			$sqlSort = "user.tel";
		} else if ($sortentry == "unit") {
			$sqlSort = "core_units.name";
		} else if ($sortentry == "unit") {
			$sqlSort = "resp.name";
		} else if ($sortentry == "status") {
			$sqlSort = "core_status.name";
		} else if ($sortentry == "status") {
			$sqlSort = "core_status.name";
		} else if ($sortentry == "convention") {
			$sqlSort = "user.convention";
		} else if ($sortentry == "date_convention") {
			$sqlSort = "user.date_convention";
		} else if ($sortentry == "date_last_login") {
			$sqlSort = "user.date_last_login";
		} else if ($sortentry == "responsible") {
			$sqlSort = "resp.name";
		}
		
		$sql = "SELECT user.id AS id, user.login AS login, 
					   user.date_end_contract AS date_end_contract,
					   user.source AS source,
    				   user.firstname AS firstname, user.name AS name, 
    				   user.email AS email, user.tel AS tel,	
    				   user.convention AS convention, user.date_convention AS date_convention,
    			       user.date_created AS date_created, user.date_last_login AS date_last_login,
    				   core_units.name AS unit, 
    				   resp.name AS resp_name, resp.firstname AS resp_firstname,
    				   core_status.name AS status
    			FROM core_users AS user
    			INNER JOIN core_users AS resp ON user.id_responsible = resp.id
    			INNER JOIN core_units ON user.id_unit = core_units.id
    			INNER JOIN core_status ON user.id_status = core_status.id
    			WHERE user.is_active=" . $is_active . "
    			ORDER BY " . $sqlSort . ";";
		
		$req = $this->runRequest ( $sql );
		$users = $req->fetchAll ();
		
		$respModel = new CoreResponsible ();
		for($i = 0; $i < count ( $users ); $i ++) {
			$users [$i] ['is_responsible'] = $respModel->isResponsible ( $users [$i] ['id'] );
		}
		
		if ($sortentry == "is_responsible") {
			// get the is resp colomn
			foreach ( $users as $key => $row ) {
				$rang [$key] = $row ['is_responsible'];
			}
			
			// sort
			array_multisort ( $rang, SORT_DESC, $users );
		}
		
		return $users;
	}
	
	/**
	 * Get the user info using a search on user entry
	 * @param string $selectEntry Entry on wich the search has to be done
	 * @param string $searchTxt Search text
	 * @param string $sortentry Sort entry
	 * @return array Users informations
	 */
	public function getUsersInfoSearch($selectEntry, $searchTxt, $sortentry = ""){
		
		if ($sortentry == "responsible"){
			$sortentry = "resp_name";
		}
		$sortIsResp = false;
		if ($sortentry == "is_responsible"){
			$sortentry = "id";
			$sortIsResp = true;
		}
		
		$sql = "SELECT user.id AS id, user.login AS login,
    				   user.firstname AS firstname, user.name AS name,
    				   user.email AS email, user.tel AS tel,
    				   user.convention AS convention, user.date_convention AS date_convention,
    			       user.date_created AS date_created, user.date_last_login AS date_last_login,
    				   core_units.name AS unit,
    				   resp.name AS resp_name, resp.firstname AS resp_firstname,
    				   core_status.name AS status
    			FROM core_users AS user
    			
				INNER JOIN core_users AS resp ON user.id_responsible = resp.id
    			INNER JOIN core_units ON user.id_unit = core_units.id
    			INNER JOIN core_status ON user.id_status = core_status.id
    			WHERE user.".$selectEntry." LIKE '%$searchTxt%' ";
		
		if ($sortentry != ""){
			$sql .= " ORDER BY " . $sortentry;
		}
		
		//echo "sql = " . $sql;
		$req = $this->runRequest ( $sql );
		$users = $req->fetchAll ();
		
		//echo "<p> count users = " . count($users) . "</p>";
		
		$respModel = new CoreResponsible ();
		for($i = 0; $i < count ( $users ); $i ++) {
			$users [$i] ['is_responsible'] = $respModel->isResponsible ( $users [$i] ['id'] );
		}
		
		if ($sortIsResp){
			foreach ($users as $key => $row) {
				$isresp[$key]  = $row['is_responsible'];
			}
			array_multisort($isresp, SORT_ASC, $users);
		}
		return $users;
	}
	
	/**
	 * Get the user info using a search on unit entry
	 * @param string $selectEntry Entry on wich the search has to be done
	 * @param string $searchTxt Search text
	 * @param string $sortentry Sort entry
	 * @return array Users informations
	 */
	public function getUsersUnitInfoSearch($selectEntry, $searchTxt, $sortentry = ""){
		
		if ($sortentry == "responsible"){
			$sortentry = "resp_name";
		}
		$sortIsResp = false;
		if ($sortentry == "is_responsible"){
			$sortentry = "id";
			$sortIsResp = true;
		}
		
		$sql = "SELECT user.id AS id, user.login AS login,
    				   user.firstname AS firstname, user.name AS name,
    				   user.email AS email, user.tel AS tel,
    				   user.convention AS convention, user.date_convention AS date_convention,
    			       user.date_created AS date_created, user.date_last_login AS date_last_login,
    				   core_units.name AS unit,
    				   resp.name AS resp_name, resp.firstname AS resp_firstname,
    				   core_status.name AS status
    			FROM core_users AS user
    
				INNER JOIN core_users AS resp ON user.id_responsible = resp.id
    			INNER JOIN core_units ON user.id_unit = core_units.id
    			INNER JOIN core_status ON user.id_status = core_status.id
    			WHERE core_units.".$selectEntry." LIKE '%$searchTxt%'";
		
		if ($sortentry != ""){
			$sql .= " ORDER BY " . $sortentry;
		}
	
		//echo "sql = " . $sql;
		$req = $this->runRequest ( $sql );
		$users = $req->fetchAll ();
	
		//echo "<p> count users = " . count($users) . "</p>";
	
		$respModel = new CoreResponsible ();
		for($i = 0; $i < count ( $users ); $i ++) {
			$users [$i] ['is_responsible'] = $respModel->isResponsible ( $users [$i] ['id'] );
		}
		
		if ($sortIsResp){
			foreach ($users as $key => $row) {
				$isresp[$key]  = $row['is_responsible'];
			}
			array_multisort($isresp, SORT_ASC, $users);
		}
	
		return $users;
	}
	
	/**
	 * Get the user info using a search on status entry
	 * @param string $selectEntry Entry on wich the search has to be done
	 * @param string $searchTxt Search text
	 * @param string $sortentry Sort entry
	 * @return array Users informations
	 */
	public function getUsersStatusInfoSearch($selectEntry, $searchTxt, $sortentry = ""){
		
		if ($sortentry == "responsible"){
			$sortentry = "resp_name";
		}
		$sortIsResp = false;
		if ($sortentry == "is_responsible"){
			$sortentry = "id";
			$sortIsResp = true;
		}
		
		$sql = "SELECT user.id AS id, user.login AS login,
    				   user.firstname AS firstname, user.name AS name,
    				   user.email AS email, user.tel AS tel,
    				   user.convention AS convention, user.date_convention AS date_convention,
    			       user.date_created AS date_created, user.date_last_login AS date_last_login,
    				   core_units.name AS unit,
    				   resp.name AS resp_name, resp.firstname AS resp_firstname,
    				   core_status.name AS status
    			FROM core_users AS user
	
				INNER JOIN core_users AS resp ON user.id_responsible = resp.id
    			INNER JOIN core_units ON user.id_unit = core_units.id
    			INNER JOIN core_status ON user.id_status = core_status.id
    			WHERE core_status.".$selectEntry." LIKE '%$searchTxt%'";
		
		if ($sortentry != ""){
			$sql .= " ORDER BY " . $sortentry;
		}
	
		//echo "sql = " . $sql;
		$req = $this->runRequest ( $sql );
		$users = $req->fetchAll ();
	
		//echo "<p> count users = " . count($users) . "</p>";
	
		$respModel = new CoreResponsible ();
		for($i = 0; $i < count ( $users ); $i ++) {
			$users [$i] ['is_responsible'] = $respModel->isResponsible ( $users [$i] ['id'] );
		}
		if ($sortIsResp){
			foreach ($users as $key => $row) {
				$isresp[$key]  = $row['is_responsible'];
			}
			array_multisort($isresp, SORT_ASC, $users);
		}
	
		return $users;
	}
	
	/**
	 * Get the user info using a search on responsible entry
	 * @param string $selectEntry Entry on wich the search has to be done
	 * @param string $searchTxt Search text
	 * @param string $sortentry Sort entry
	 * @return array Users informations
	 */
	public function getUsersResponsibleInfoSearch($selectEntry, $searchTxt, $sortentry = ""){
		
		if ($sortentry == "responsible"){
			$sortentry = "resp_name";
		}
		$sortIsResp = false;
		if ($sortentry == "is_responsible"){
			$sortentry = "id";
			$sortIsResp = true;
		}
		
		$sql = "SELECT user.id AS id, user.login AS login,
    				   user.firstname AS firstname, user.name AS name,
    				   user.email AS email, user.tel AS tel,
    				   user.convention AS convention, user.date_convention AS date_convention,
    			       user.date_created AS date_created, user.date_last_login AS date_last_login,
    				   core_units.name AS unit,
    				   resp.name AS resp_name, resp.firstname AS resp_firstname,
    				   core_status.name AS status
    			FROM core_users AS user
		
				INNER JOIN core_users AS resp ON user.id_responsible = resp.id
    			INNER JOIN core_units ON user.id_unit = core_units.id
    			INNER JOIN core_status ON user.id_status = core_status.id
    			WHERE resp.".$selectEntry." LIKE '%$searchTxt%'";
		
		if ($sortentry != ""){
			$sql .= " ORDER BY " . $sortentry;
		}
		
		//echo "sql = " . $sql;
		$req = $this->runRequest ( $sql );
		$users = $req->fetchAll ();
		
		//echo "<p> count users = " . count($users) . "</p>";
		
		$respModel = new CoreResponsible ();
		for($i = 0; $i < count ( $users ); $i ++) {
			$users [$i] ['is_responsible'] = $respModel->isResponsible ( $users [$i] ['id'] );
		}
		if ($sortIsResp){
			foreach ($users as $key => $row) {
				$isresp[$key]  = $row['is_responsible'];
			}
			array_multisort($isresp, SORT_ASC, $users);
		}
		return $users;
	}
	
	/**
	 * get the informations of a user from it's id
	 *
	 * @param int $id
	 *        	Id of the user to query
	 * @throws Exception if the user connot be found
	 */
	public function userAllInfo($id) {
		$sql = "select * from core_users where id=?";
		$user = $this->runRequest ( $sql, array (
				$id 
		) );
		$userquery = null;
		if ($user->rowCount () == 1)
			return $user->fetch (); // get the first line of the result
		else
			throw new Exception ( "Cannot find the user using the given parameters: " . $id );
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
	public function addUser($name, $firstname, $login, $pwd, $email, $phone, $id_unit, $id_responsible, $id_status, $convention, 
			                $date_convention, $date_end_contract = "", $is_active = 1, $source = "local") {
		$sql = "insert into core_users(login, firstname, name, email, tel, pwd, id_unit, id_responsible, 
    			                       id_status, date_created, convention, date_convention, date_end_contract,is_active, source)" . " values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )";
		$this->runRequest ( $sql, array (
				$login,
				$firstname,
				$name,
				$email,
				$phone,
				md5 ( $pwd ),
				$id_unit,
				$id_responsible,
				$id_status,
				"" . date ( "Y-m-d" ) . "",
				$convention,
				$date_convention,
				$date_end_contract,
				$is_active,
				$source				
		) );
		
		return $this->getDatabase ()->lastInsertId ();
	}
	/**
	 * Set user (add if not exists)
	 * @param string $name
	 * @param string $firstname
	 * @param string $login
	 * @param string $pwd
	 * @param string $email
	 * @param string $phone
	 * @param number $id_unit
	 * @param number $id_responsible
	 * @param number $id_status
	 * @param number $convention
	 * @param date $date_convention
	 * @param string $date_end_contract
	 * @param number $is_active
	 * @param string $source
	 */
	public function setUser($name, $firstname, $login, $pwd, $email, $phone, $id_unit, $id_responsible, $id_status, $convention, $date_convention, $date_end_contract = "", $is_active = 1, $source = "local") {
		if (! $this->isUser ( $login )) {
			$this->addUser ( $name, $firstname, $login, $pwd, $email, $phone, $id_unit, $id_responsible, $id_status, $convention, $date_convention, $date_end_contract, $is_active, $source);
		}
	}
	/**
	 * Set user (add if not exists) using MD5
	 * @param unknown $name
	 * @param unknown $firstname
	 * @param unknown $login
	 * @param unknown $pwd
	 * @param unknown $email
	 * @param unknown $phone
	 * @param unknown $id_unit
	 * @param unknown $id_responsible
	 * @param unknown $id_status
	 * @param unknown $convention
	 * @param unknown $date_convention
	 * @param string $date_end_contract
	 * @param number $is_active
	 * @param string $source
	 */
	public function setUserMd5($name, $firstname, $login, $pwd, $email, $phone, $id_unit, $id_responsible, $id_status, $convention, $date_convention, $date_end_contract = "", $is_active = 1, $source = "local") {
		if (! $this->isUser ( $login )) {
			
			$sql = "insert into core_users(login, firstname, name, email, tel, pwd, id_unit, id_responsible, 
    			                       id_status, date_created, convention, date_convention, date_end_contract,is_active,source)" . " values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )";
			$this->runRequest ( $sql, array (
					$login,
					$firstname,
					$name,
					$email,
					$phone,
					$pwd,
					$id_unit,
					$id_responsible,
					$id_status,
					"" . date ( "Y-m-d" ) . "",
					$convention,
					$date_convention,
					$date_end_contract,
					$is_active,
					$source 		
			) );
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
	public function updateUser($id, $firstname, $name, $login, $email, $phone, $id_unit, $id_responsible, $id_status, $convention, 
							   $date_convention, $date_end_contract = "", $is_active = 1, $source = "local") {
		$sql = "update core_users set login=?, firstname=?, name=?, email=?, tel=?, id_unit=?, id_responsible=?, id_status=?,
    			                      convention=?, date_convention=?, date_end_contract=?, is_active=?, source=? 
    			                  where id=?";
		$this->runRequest ( $sql, array (
				$login,
				$firstname,
				$name,
				$email,
				$phone,
				$id_unit,
				$id_responsible,
				$id_status,
				$convention,
				$date_convention,
				$date_end_contract,
				$is_active,
				$source,
				$id 
		) );
	}
	/**
	 * Set (add if not exists, update otherwise) external (i.e. LDAP) user info
	 * @param unknown $login
	 * @param unknown $name
	 * @param unknown $firstname
	 * @param unknown $email
	 * @param unknown $id_status
	 */
	public function setExtBasicInfo($login, $name, $firstname, $email, $id_status){
		
		// insert
		if (! $this->isUser ( $login )){
			$sql = "insert into core_users(login, firstname, name, email, id_status, source, date_created, id_unit, id_responsible)" . " values(?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$this->runRequest ( $sql, array (
					$login,
					$firstname,
					$name,
					$email,
					$id_status,
					"ext",
					"" . date ( "Y-m-d" ) . "",
					1,
					1
			) );
		}
		// update
		else{
			$sql = "update core_users set firstname=?, name=?, email=?
    			                  where login=?";
			$this->runRequest ( $sql, array (
					$firstname,
					$name,
					$email,
					$login
			) );
		}
		
	}
	
	/**
	 * Change the password of a user
	 *
	 * @param int $id
	 *        	Id of the user to edit
	 * @param string $pwd
	 *        	new password
	 */
	public function changePwd($id, $pwd) {
		$sql = "update core_users set pwd=? where id=?";
		$user = $this->runRequest ( $sql, array (
				md5 ( $pwd ),
				$id 
		) );
	}
	
	/**
	 * get the password of a user
	 *
	 * @param int $id
	 *        	Id of the user to query
	 * @throws Exception if the user cannot be found
	 * @return mixed array
	 */
	public function getpwd($id) {
		$sql = "select pwd from core_users where id=?";
		$user = $this->runRequest ( $sql, array (
				$id 
		) );
		$userquery = null;
		if ($user->rowCount () == 1)
			return $user->fetch (); // get the first line of the result
		else
			throw new Exception ( "Cannot find the user using the given parameters" );
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
	public function updateUserAccount($id, $firstname, $name, $email, $phone) {
		$sql = "update core_users set firstname=?, name=?, email=?, tel=? where id=?";
		$this->runRequest ( $sql, array (
				$firstname,
				$name,
				$email,
				$phone,
				$id 
		) );
	}
	
	/**
	 * Verify that a user is in the database
	 *
	 * @param string $login
	 *        	the login
	 * @return boolean True if the user is in the database
	 */
	public function isUser($login) {
		$sql = "select id from core_users where login=?";
		$user = $this->runRequest ( $sql, array (
				$login 
		) );
		if ($user->rowCount () == 1)
			return true; // get the first line of the result
		else
			return false;
	}
	
	/**
	 * Check if a local user with a given login exists
	 * @param string $login Local login
	 * @return boolean
	 */
	public function isLocalUser($login) {
		$sql = "select id from core_users where login=? AND source=?";
		$user = $this->runRequest ( $sql, array (
				$login, "local"
		) );
		if ($user->rowCount () == 1)
			return true; // get the first line of the result
		else
			return false;
	}
	
	/**
	 * Get the user ID fro mit login
	 * @param string $login User login
	 * @return number User ID
	 */
	public function userIdFromLogin($login) {
		$sql = "select id from core_users where login=?";
		$user = $this->runRequest ( $sql, array (
				$login 
		) );
		if ($user->rowCount () == 1) {
			$tmp = $user->fetch ();
			return $tmp [0];
		} else {
			return - 1;
		}
	}
	/**
	 * Add User if not exists
	 * @param string $login
	 * @param string $name
	 * @param string $firstname
	 * @param string $pwd
	 * @param string $email
	 * @param number $id_status
	 */
	public function addIfLoginNotExists($login, $name, $firstname, $pwd, $email, $id_status) {
		if (! $this->isUser ( $login )) {
			$this->addUser ( $name, $firstname, $login, $pwd, $email, "", 1, 1, 1, $id_status, "", '' );
		}
	}
	/**
	 * Set user unit
	 * @param string $login User login
	 * @param number $unitId Unit ID
	 */
	public function setUnitId($login, $unitId) {
		$sql = "update core_users set id_unit=? where login=?";
		$this->runRequest ( $sql, array (
				$unitId,
				$login 
		) );
	}
	/**
	 * Get user ID from fullname
	 * @param string $fullname User fullname
	 * @return number User ID
	 */
	public function getUserIdFromFullName($fullname) {
		$sql = "select firstname, name, id from core_users";
		$user = $this->runRequest ( $sql );
		$users = $user->fetchAll ();
		
		foreach ( $users as $user ) {
			$curentFullname = $user ['name'] . " " . $user ['firstname'];
			if ($fullname == $curentFullname) {
				return $user ['id'];
			}
		}
		return - 1;
	}
	/**
	 * Set a responsible to a user
	 * @param number $idUser User ID
	 * @param number $idResp Responsible ID
	 */
	public function setResponsible($idUser, $idResp) {
		$sql = "update core_users set id_responsible=? where id=?";
		$this->runRequest ( $sql, array (
				$idResp,
				$idUser 
		) );
	}
	/**
	 * Get all the responsibles assocaited to a given unit
	 * @param number $unitId UNit ID
	 * @return PDOStatement
	 */
	public function getResponsibleOfUnit($unitId) {
		$sql = "select id, name, firstname from core_users where id in (select id_users from core_responsibles) and id_unit=? ORDER BY name";
		return $this->runRequest ( $sql, array (
				$unitId 
		) );
	}
	/**
	 * Get a user informations from ID, unit and responsible
	 * @param number $id User ID
	 * @param number $unit_id Unit ID 
	 * @param number $responsible_id Responsible ID
	 * @return array User info
	 */
	public function getUserFromlup($id, $unit_id, $responsible_id) {
		$sql = 'SELECT name, firstname, id_responsible FROM core_users WHERE id=? AND id_unit=? AND id_responsible=?';
		$req = $this->runRequest ( $sql, array (
				$id,
				$unit_id,
				$responsible_id 
		) );
		return $req->fetchAll ();
	}
	/**
	 * Get user from unit
	 * @param number $id User ID
	 * @param number $unit_id Unit ID 
	 * @return array User info
	 */
	public function getUserFromIdUnit($id, $unit_id) {
		$sql = "SELECT name, firstname, id_responsible, id_unit FROM core_users WHERE id=?";
		if ($unit_id > 0) {
			$sql .= " AND id_unit=" . $unit_id;
		}
		
		$req = $this->runRequest ( $sql, array (
				$id 
		) );
		return $req->fetchAll ();
	}
	/**
	 * Get the date of a user last connection
	 * @param number $id User ID
	 * @return string Last connection date
	 */
	public function getLastConnection($id) {
		$sql = "select date_last_login from core_users where id=?";
		$user = $this->runRequest ( $sql, array (
				$id 
		) );
		if ($user->rowCount () == 1) {
			$tmp = $user->fetch ();
			return $tmp [0];
		} else {
			return "0000-00-00";
		}
	}
	/**
	 * Set a user last connection date
	 * @param number $id User ID
	 * @param date $time Date
	 */
	public function setLastConnection($id, $time) {
		$sql = "update core_users set date_last_login=? where id=?";
		$this->runRequest ( $sql, array (
				$time,
				$id 
		) );
	}
	/**
	 * Update user to active or unactive depending on the settings criteria
	 */
	public function updateUsersActive() {
		$modelConfig = new CoreConfig ();
		$desactivateType = $modelConfig->getParam ( "user_desactivate" );
		
		if ($desactivateType > 1) {
			if ($desactivateType == 2) {
				$this->updateUserActiveContract ();
			} else if ($desactivateType == 3) {
				$this->updateUserActiveLastLogin ( 1 );
			} else if ($desactivateType == 4) {
				$this->updateUserActiveLastLogin ( 2 );
			} else if ($desactivateType == 5) {
				$this->updateUserActiveLastLogin ( 3 );
			}
		}
	}
	/**
	 * Set a user active
	 * @param number $id User ID
	 * @param number $active Active status
	 */
	public function setactive($id, $active) {
		$sql = "update core_users set is_active=? where id=?";
		$this->runRequest ( $sql, array (
				$active,
				$id 
		) );
	}
	/**
	 * Set unactive user who contract ended
	 */
	private function updateUserActiveContract() {
		$sql = "select id, date_end_contract from core_users where is_active=1";
		$req = $this->runRequest ( $sql );
		$users = $req->fetchAll ();
		
		foreach ( $users as $user ) {
			$contractDate = $user ["date_end_contract"];
			$today = date ( "Y-m-d", time () );
			
			if ($contractDate != "0000-00-00"){
				if ($contractDate < $today) {
					$this->setactive ( $user["id"], 0 );
				}
			}
		}
	}
	/**
	 * Unactivate users who did not login for a number of year given in $numberYear
	 * @param number $numberYear Number of years
	 */
	private function updateUserActiveLastLogin($numberYear) {
		$sql = "select id, date_last_login from core_users where is_active=1";
		$req = $this->runRequest ( $sql );
		$users = $req->fetchAll ();
		
		foreach ( $users as $user ) {
			$lastLoginDate = $user ["date_last_login"];
			$lastLoginDate = explode ( "-", $lastLoginDate );
			$timell = mktime ( 0, 0, 0, $lastLoginDate [1], $lastLoginDate [2], $lastLoginDate [0] );
			$timell = date ( "Y-m-d", $timell + $numberYear * 31556926 );
			$today = date ( "Y-m-d", time () );
			
			$changedUsers = array ();
			if ($lastLoginDate [0] != "0000") {
				if ($timell <= $today) {
					$this->setactive ( $user ['id'], 0 );
					$changedUsers [] = $user ['id'];
				}
			}
		}
		
		$modelConfig = new CoreConfig ();
		
		if ($modelConfig->isKey ( "sygrrif_installed" )) {
			require_once 'Modules/sygrrif/Model/SyAuthorization.php';
			$authModel = new SyAuthorization ();
			$authModel->desactivateAthorizationsForUsers ( $changedUsers );
		}
	}
	/**
	 * Make a user active
	 * @param number $userId User ID
	 */
	public function activate($userId) {
		$today = date ( "Y-m-d", time () );
		
		$sql = "update core_users set is_active=?, date_last_login=? where id=?";
		$this->runRequest ( $sql, array (
				1,
				$today,
				$userId 
		) );
	}
	/**
	 * Get a user from his name and firstname
	 * @param string $name User name
	 * @param string $firstname User firstname
	 * @return number User ID
	 */
	public function getUserFromNameFirstname($name, $firstname) {
		$sql = "select id from core_users where name=? and firstname=?";
		$user = $this->runRequest ( $sql, array (
				$name,
				$firstname 
		) );
		
		if ($user->rowCount () == 1) {
			$tmp = $user->fetch ();
			return $tmp [0];
		} else {
			return - 1;
		}
	}
	/**
	 * Get all the conventions
	 * @return Array convention list
	 */
	public function getConventionList() {
		$sql = "select distinct convention from core_users order by convention";
		$req = $this->runRequest ( $sql );
		return $req->fetchAll ();
	}
	/**
	 * Get the convention of a user
	 * @param number $id User ID
	 * @return number COnvention Number
	 */
	public function getUserConvention($id) {
		$sql = "select convention from core_users where id=?";
		$req = $this->runRequest ( $sql, array (
				$id 
		) );
		$tmp = $req->fetch ();
		return $tmp [0];
	}
	/**
	 * Export Responsible lists to file
	 * @param number $idType Active/Unative/all
	 */
	public function exportResponsible($idType) {
		
		// get the responsibles
		$resps = array ();
		$typeResp = "";

		if ($idType == 0) { // all
			$sql = "SELECT * FROM core_users WHERE id IN (SELECT id_users FROM core_responsibles) ORDER BY name ASC";
			$req = $this->runRequest ( $sql );
			$resps = $req->fetchAll ();
		} else if ($idType == 1) { // active
			$sql = "SELECT * FROM core_users WHERE id IN (SELECT id_users FROM core_responsibles) AND is_active=? ORDER BY name ASC";
			$req = $this->runRequest ( $sql, array(1));
			$resps = $req->fetchAll ();
			$typeResp = "actifs";
		} else if ($idType == 2) { // inactive
			$sql = "SELECT * FROM core_users WHERE id IN (SELECT id_users FROM core_responsibles) AND is_active=0 ORDER BY name ASC";
			$req = $this->runRequest ( $sql, array(0) );
			$resps = $req->fetchAll ();
			$typeResp = "inactifs";
		}
		
		// export to xls
		include_once ("externals/PHPExcel/Classes/PHPExcel.php");
		include_once ("externals/PHPExcel/Classes/PHPExcel/Writer/Excel5.php");
		include_once ("externals/PHPExcel/Classes/PHPExcel/Writer/Excel2007.php");
		
		// get resource category

		// header
		$today = date ( 'd/m/Y' );
		$header = "Date d'édition de ce document : \n" . $today;
		$titre = "Liste des responsables " . $typeResp;
		
		// file name
		$nom = date ( 'Y-m-d-H-i' ) . "_" . "responsables" . ".xlsx";
		$teamName = Configuration::get ( "name" );
		$footer = "SyGRRif/" . $teamName . "/exportFiles/" . $nom;
		
		// Création de l'objet
		$objPHPExcel = new PHPExcel ();
		
		// Définition de quelques propriétés
		$objPHPExcel->getProperties ()->setCreator ( $teamName );
		$objPHPExcel->getProperties ()->setLastModifiedBy ( $teamName );
		$objPHPExcel->getProperties ()->setTitle ( "Liste des responsables " . $typeResp );
		$objPHPExcel->getProperties ()->setSubject ( "" );
		$objPHPExcel->getProperties ()->setDescription ( "Fichier genere avec PHPExel depuis la base de donnees" );
		
		$center = array (
				'alignment' => array (
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER 
				) 
		);
		$gras = array (
				'font' => array (
						'bold' => true 
				) 
		);
		$border = array (
				'borders' => array (
						'top' => array (
								'style' => PHPExcel_Style_Border::BORDER_THIN 
						),
						'left' => array (
								'style' => PHPExcel_Style_Border::BORDER_THIN 
						),
						'right' => array (
								'style' => PHPExcel_Style_Border::BORDER_THIN 
						),
						'bottom' => array (
								'style' => PHPExcel_Style_Border::BORDER_THIN 
						) 
				) 
		);
		$borderLR = array (
				'borders' => array (
						'top' => array (
								'style' => PHPExcel_Style_Border::BORDER_NONE 
						),
						'left' => array (
								'style' => PHPExcel_Style_Border::BORDER_THIN 
						),
						'right' => array (
								'style' => PHPExcel_Style_Border::BORDER_THIN 
						),
						'bottom' => array (
								'style' => PHPExcel_Style_Border::BORDER_NONE 
						) 
				) 
		);
		
		$borderG = array (
				'borders' => array (
						'top' => array (
								'style' => PHPExcel_Style_Border::BORDER_MEDIUM 
						),
						'left' => array (
								'style' => PHPExcel_Style_Border::BORDER_MEDIUM 
						),
						'right' => array (
								'style' => PHPExcel_Style_Border::BORDER_MEDIUM 
						),
						'bottom' => array (
								'style' => PHPExcel_Style_Border::BORDER_MEDIUM 
						) 
				) 
		);
		
		$borderLRB = array (
				'borders' => array (
						'top' => array (
								'style' => PHPExcel_Style_Border::BORDER_NONE 
						),
						'left' => array (
								'style' => PHPExcel_Style_Border::BORDER_THIN 
						),
						'right' => array (
								'style' => PHPExcel_Style_Border::BORDER_THIN 
						),
						'bottom' => array (
								'style' => PHPExcel_Style_Border::BORDER_THIN 
						) 
				) 
		);
		
		$style = array (
				'font' => array (
						'bold' => false,
						'color' => array (
								'rgb' => '000000' 
						),
						'size' => 15,
						'name' => 'Calibri' 
				) 
		);
		
		$style2 = array (
				'font' => array (
						'bold' => false,
						'color' => array (
								'rgb' => '000000' 
						),
						'size' => 10,
						'name' => 'Calibri' 
				) 
		);
		
		// Nommage de la feuille
		$objPHPExcel->setActiveSheetIndex ( 0 );
		$sheet = $objPHPExcel->getActiveSheet ();
		$sheet->setTitle ( 'Liste responsables ' . $typeResp );
		
		// Mise en page de la feuille
		$sheet->getPageSetup ()->setOrientation ( PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT );
		$sheet->getPageSetup ()->setPaperSize ( PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4 );
		$sheet->setBreak ( 'A55', PHPExcel_Worksheet::BREAK_ROW );
		$sheet->setBreak ( 'E55', PHPExcel_Worksheet::BREAK_COLUMN );
		$sheet->setBreak ( 'A110', PHPExcel_Worksheet::BREAK_ROW );
		$sheet->setBreak ( 'E110', PHPExcel_Worksheet::BREAK_COLUMN );
		$sheet->setBreak ( 'A165', PHPExcel_Worksheet::BREAK_ROW );
		$sheet->setBreak ( 'E165', PHPExcel_Worksheet::BREAK_COLUMN );
		$sheet->setBreak ( 'A220', PHPExcel_Worksheet::BREAK_ROW );
		$sheet->setBreak ( 'E220', PHPExcel_Worksheet::BREAK_COLUMN );
		// $sheet->getPageSetup()->setFitToWidth(1);
		// $sheet->getPageSetup()->setFitToHeight(10);
		$sheet->getPageMargins ()->SetTop ( 0.9 );
		$sheet->getPageMargins ()->SetBottom ( 0.5 );
		$sheet->getPageMargins ()->SetLeft ( 0.2 );
		$sheet->getPageMargins ()->SetRight ( 0.2 );
		$sheet->getPageMargins ()->SetHeader ( 0.2 );
		$sheet->getPageMargins ()->SetFooter ( 0.2 );
		$sheet->getPageSetup ()->setHorizontalCentered ( true );
		// $sheet->getPageSetup()->setVerticalCentered(false);
		
		$sheet->getColumnDimension ( 'A' )->setWidth ( 32 );
		$sheet->getColumnDimension ( 'B' )->setWidth ( 30 );
		$sheet->getColumnDimension ( 'C' )->setWidth ( 16 );
		$sheet->getColumnDimension ( 'D' )->setWidth ( 8 );
		
		// Header
		$objDrawing = new PHPExcel_Worksheet_HeaderFooterDrawing ();
		$objDrawing->setName ( 'PHPExcel logo' );
		$objDrawing->setPath ( './Themes/logo.jpg' );
		$objDrawing->setHeight ( 60 );
		$objPHPExcel->getActiveSheet ()->getHeaderFooter ()->addImage ( $objDrawing, PHPExcel_Worksheet_HeaderFooter::IMAGE_HEADER_LEFT );
		$sheet->getHeaderFooter ()->setOddHeader ( '&L&G&R' . $header );
		
		// Titre
		$ligne = 1;
		$colonne = 'A';
		$sheet->getRowDimension ( $ligne )->setRowHeight ( 30 );
		$sheet->SetCellValue ( $colonne . $ligne, $titre );
		$sheet->getStyle ( $colonne . $ligne )->applyFromArray ( $style );
		$sheet->getStyle ( $colonne . $ligne )->applyFromArray ( $gras );
		$sheet->getStyle ( $colonne . $ligne )->applyFromArray ( $center );
		$sheet->getStyle ( $colonne . $ligne )->getAlignment ()->setWrapText ( true );
		$sheet->mergeCells ( $colonne . $ligne . ':D' . $ligne );
		
		/*
		// Avertissement
		$ligne = 2;
		$sheet->mergeCells ( 'A' . $ligne . ':D' . $ligne );
		$sheet->SetCellValue ( 'A' . $ligne, "" );
		$sheet->getStyle ( 'A' . $ligne )->applyFromArray ( $gras );
		$sheet->getStyle ( 'A' . $ligne )->applyFromArray ( $center );
		$sheet->getStyle ( 'A' . $ligne )->getAlignment ()->setWrapText ( true );
		
		// Réservation
		$ligne = 3;
		$sheet->mergeCells ( 'A' . $ligne . ':D' . $ligne );
		$sheet->SetCellValue ( 'A' . $ligne, "" );
		$sheet->getStyle ( 'A' . $ligne )->applyFromArray ( $center );
		*/
		$ligne = 2;
		$sheet->SetCellValue ( 'A' . $ligne, "Laboratoire" );
		$sheet->getStyle ( 'A' . $ligne )->applyFromArray ( $border );
		$sheet->getStyle ( 'A' . $ligne )->applyFromArray ( $center );
		$sheet->getStyle ( 'A' . $ligne )->applyFromArray ( $gras );
		$sheet->SetCellValue ( 'B' . $ligne, "Nom Prénom" );
		$sheet->getStyle ( 'B' . $ligne )->applyFromArray ( $border );
		$sheet->getStyle ( 'B' . $ligne )->applyFromArray ( $center );
		$sheet->getStyle ( 'B' . $ligne )->applyFromArray ( $gras );
		$sheet->SetCellValue ( 'C' . $ligne, "Date" );
		$sheet->getStyle ( 'C' . $ligne )->applyFromArray ( $border );
		$sheet->getStyle ( 'C' . $ligne )->applyFromArray ( $center );
		$sheet->getStyle ( 'C' . $ligne )->applyFromArray ( $gras );
		$sheet->SetCellValue ( 'D' . $ligne, "Charte" );
		$sheet->getStyle ( 'D' . $ligne )->applyFromArray ( $border );
		$sheet->getStyle ( 'D' . $ligne )->applyFromArray ( $center );
		$sheet->getStyle ( 'D' . $ligne )->applyFromArray ( $gras );
		
		$ligne = 3;
		foreach ( $resps as $r ) {
			
			if ($r["id"] > 1){
			
			$colonne = 'A';
			$sheet->getRowDimension ( $ligne )->setRowHeight ( 13 );
			
			
			$sql = "select name from core_units where id=?";
			$unitReq = $this->runRequest($sql, array($r ["id_unit"]));
			$unitName = $unitReq->fetch();
			
			$sheet->SetCellValue ( $colonne . $ligne, $unitName[0] ); // unit name
			$sheet->getStyle ( $colonne . $ligne )->applyFromArray ( $style2 );
			$sheet->getStyle ( $colonne . $ligne )->applyFromArray ( $center );
			$sheet->getStyle ( $colonne . $ligne )->applyFromArray ( $borderLR );
			$colonne ++;
			$sheet->SetCellValue ( $colonne . $ligne, $r ["name"] . " " . $r ["firstname"] ); // user name
			$sheet->getStyle ( $colonne . $ligne )->applyFromArray ( $style2 );
			$sheet->getStyle ( $colonne . $ligne )->applyFromArray ( $center );
			$sheet->getStyle ( $colonne . $ligne )->applyFromArray ( $borderLR );
			$colonne ++;
			// $date=date('d/m/Y', $r[2]); // date
			$sheet->SetCellValue ( $colonne . $ligne, CoreTranslator::dateFromEn ( $r ["date_convention"], "Fr" ) );
			$sheet->getStyle ( $colonne . $ligne )->applyFromArray ( $style2 );
			$sheet->getStyle ( $colonne . $ligne )->applyFromArray ( $center );
			$sheet->getStyle ( $colonne . $ligne )->applyFromArray ( $borderLR );
			$colonne ++;
			
			$conStr = "non";
			if ($r ["convention"] > 0) {
				$conStr = "signée";
			}
			$sheet->SetCellValue ( $colonne . $ligne, $conStr ); // visa name
			$sheet->getStyle ( $colonne . $ligne )->applyFromArray ( $style2 );
			$sheet->getStyle ( $colonne . $ligne )->applyFromArray ( $center );
			$sheet->getStyle ( $colonne . $ligne )->applyFromArray ( $borderLR );
			
			if (! ($ligne % 55)) {
				$sheet->getStyle ( 'A' . $ligne )->applyFromArray ( $borderLRB );
				$sheet->getStyle ( 'B' . $ligne )->applyFromArray ( $borderLRB );
				$sheet->getStyle ( 'C' . $ligne )->applyFromArray ( $borderLRB );
				$sheet->getStyle ( 'D' . $ligne )->applyFromArray ( $borderLRB );
				$ligne ++;
				// Titre
				$colonne = 'A';
				$sheet->getRowDimension ( $ligne )->setRowHeight ( 30 );
				$sheet->SetCellValue ( $colonne . $ligne, $titre );
				$sheet->getStyle ( $colonne . $ligne )->applyFromArray ( $style );
				$sheet->getStyle ( $colonne . $ligne )->applyFromArray ( $gras );
				$sheet->getStyle ( $colonne . $ligne )->applyFromArray ( $center );
				$sheet->getStyle ( $colonne . $ligne )->getAlignment ()->setWrapText ( true );
				$sheet->mergeCells ( $colonne . $ligne . ':D' . $ligne );
				
				/*
				// Avertissement
				$ligne ++;
				$sheet->mergeCells ( 'A' . $ligne . ':D' . $ligne );
				$sheet->SetCellValue ( 'A' . $ligne, "" );
				$sheet->getStyle ( 'A' . $ligne )->applyFromArray ( $gras );
				$sheet->getStyle ( 'A' . $ligne )->applyFromArray ( $center );
				$sheet->getStyle ( 'A' . $ligne )->getAlignment ()->setWrapText ( true );
				
				// Réservation
				$ligne ++;
				$sheet->mergeCells ( 'A' . $ligne . ':D' . $ligne );
				$sheet->SetCellValue ( 'A' . $ligne, "" );
				$sheet->getStyle ( 'A' . $ligne )->applyFromArray ( $center );
				*/
				// Noms des colonnes
				$ligne += 2;
				$sheet->SetCellValue ( 'A' . $ligne, "Laboratoire" );
				$sheet->getStyle ( 'A' . $ligne )->applyFromArray ( $border );
				$sheet->getStyle ( 'A' . $ligne )->applyFromArray ( $center );
				$sheet->getStyle ( 'A' . $ligne )->applyFromArray ( $gras );
				$sheet->SetCellValue ( 'B' . $ligne, "NOM Prénom" );
				$sheet->getStyle ( 'B' . $ligne )->applyFromArray ( $border );
				$sheet->getStyle ( 'B' . $ligne )->applyFromArray ( $center );
				$sheet->getStyle ( 'B' . $ligne )->applyFromArray ( $gras );
				$sheet->SetCellValue ( 'C' . $ligne, "Date" );
				$sheet->getStyle ( 'C' . $ligne )->applyFromArray ( $border );
				$sheet->getStyle ( 'C' . $ligne )->applyFromArray ( $center );
				$sheet->getStyle ( 'C' . $ligne )->applyFromArray ( $gras );
				$sheet->SetCellValue ( 'D' . $ligne, "Charte" );
				$sheet->getStyle ( 'D' . $ligne )->applyFromArray ( $border );
				$sheet->getStyle ( 'D' . $ligne )->applyFromArray ( $center );
				$sheet->getStyle ( 'D' . $ligne )->applyFromArray ( $gras );
			}
			$ligne ++;
			}
		}
		$ligne --;
		$sheet->getStyle ( 'A' . $ligne )->applyFromArray ( $borderLRB );
		$sheet->getStyle ( 'B' . $ligne )->applyFromArray ( $borderLRB );
		$sheet->getStyle ( 'C' . $ligne )->applyFromArray ( $borderLRB );
		$sheet->getStyle ( 'D' . $ligne )->applyFromArray ( $borderLRB );
		
		// Footer
		$sheet->getHeaderFooter ()->setOddFooter ( '&L ' . $footer . '&R Page &P / &N' );
		$sheet->getHeaderFooter ()->setEvenFooter ( '&L ' . $footer . '&R Page &P / &N' );
		
		$ImageNews = './Themes/logo.jpg';
		
		// on récupère l'extension du fichier
		$ExtensionPresumee = explode ( '.', $ImageNews );
		$ExtensionPresumee = strtolower ( $ExtensionPresumee [count ( $ExtensionPresumee ) - 1] );
		// on utilise la fonction php associé au bon type d'image
		if ($ExtensionPresumee == 'jpg' || $ExtensionPresumee == 'jpeg') {
			$ImageChoisie = imagecreatefromjpeg ( $ImageNews );
		} elseif ($ExtensionPresumee == 'gif') {
			$ImageChoisie = imagecreatefromgif ( $ImageNews );
		} elseif ($ExtensionPresumee == 'png') {
			$ImageChoisie = imagecreatefrompng ( $ImageNews );
		}
		
		// je redimensionne l’image
		$TailleImageChoisie = getimagesize ( $ImageNews );
		// la largeur voulu dans le document excel
		// $NouvelleLargeur = 150;
		$NouvelleHauteur = 80;
		// calcul du pourcentage de réduction par rapport à l’original
		// $Reduction = ( ($NouvelleLargeur * 100)/$TailleImageChoisie[0] );
		$Reduction = (($NouvelleHauteur * 100) / $TailleImageChoisie [1]);
		// PHPExcel m’aplatit verticalement l’image donc j’ai calculé de ratio d’applatissement de l’image et je l’étend préalablement
		// $NouvelleHauteur = (($TailleImageChoisie[1] * $Reduction)/100 );
		$NouvelleLargeur = (($TailleImageChoisie [0] * $Reduction) / 100);
		// j’initialise la nouvelle image
		$NouvelleImage = imagecreatetruecolor ( $NouvelleLargeur, $NouvelleHauteur ) or die ( Erreur );
		
		// je mets l’image obtenue après redimensionnement en variable
		imagecopyresampled ( $NouvelleImage, $ImageChoisie, 0, 0, 0, 0, $NouvelleLargeur, $NouvelleHauteur, $TailleImageChoisie [0], $TailleImageChoisie [1] );
		$gdImage = $NouvelleImage;
		
		// on créé l’objet de dessin et on lui donne un nom, l’image, la position de l’image, la compression de l’image, le type mime…
		$objDrawing = new PHPExcel_Worksheet_MemoryDrawing ();
		$objDrawing->setName ( 'Sample image' );
		$objDrawing->setImageResource ( $gdImage );
		$objDrawing->setCoordinates ( 'A1' );
		$objDrawing->setOffsetX ( 50 );
		$objDrawing->setOffsetY ( 8 );
		$objDrawing->setRenderingFunction ( PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG );
		$objDrawing->setMimeType ( PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT );
		// enfin on l’envoie à la feuille de calcul !
		// $objDrawing->setWorksheet($sheet);
		
		$writer = PHPExcel_IOFactory::createWriter ( $objPHPExcel, 'Excel2007' );
		
		//$writer->save ( './data/' . $nom );
		header ( 'Content-Type: application/vnd.ms-excel' );
		header ( 'Content-Disposition: attachment;filename="' . $nom . '"' );
		header ( 'Cache-Control: max-age=0' );
		
		$writer->save ( 'php://output' );
	}
	
	/**
	 * SGet user ID by parsinf a fullname (used to import user from XLS files)
	 * @param string $resp User name
	 * @return number User ID
	 */
	public function findFromAC($resp){
		
		// extract Name
		$respArray = explode(" ", $resp);
		if ( count($respArray) > 1){
			$name = $respArray[count($respArray) -1];
			
			$sql = "select id from core_users where name=?";
			$user = $this->runRequest ( $sql, array (
					$name
			) );
			
			if ($user->rowCount () == 1) {
				$tmp = $user->fetch ();
				return $tmp [0];
			} else {
				return - 1;
			}
		}
		return -1;
	}
	
	/**
	 * Remove a user from the database
	 * @param number $id User ID
	 */
	public function delete($id){
		$sql="DELETE FROM core_users WHERE id = ?";
		$req = $this->runRequest($sql, array($id));
	}
	public function setEndContract($login, $date_fin_contrat){
		$sql = "update core_users set date_end_contract=? where login=?";
		$this->runRequest ( $sql, array (
				$date_fin_contrat,
				$login
		) );
	}
	
}
