<?php

require_once 'Framework/Model.php';

/**
 * Class defining the Team model
 *
 * @author Sylvain Prigent
 */
class Team extends Model {

	/**
	 * Create the Team table
	 * 
	 * @return PDOStatement
	 */
	public function createTable(){
			
		$sql = "CREATE TABLE IF NOT EXISTS `core_teams` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`name` varchar(30) NOT NULL DEFAULT '',
		`address` varchar(150) NOT NULL DEFAULT '',
		PRIMARY KEY (`id`)
		);";
		
		$pdo = $this->runRequest($sql);
		return $pdo;
	}
	
	/**
	 * Create the default empty team
	 * 
	 * @return PDOStatement
	 */
	public function createDefaultTeam(){
	
		$sql = "INSERT INTO core_teams (name, address) VALUES(?,?)";
		$pdo = $this->runRequest($sql, array("--", "--"));
		return $pdo;
	
		//INSERT INTO `membres` (`pseudo`, `passe`, `email`) VALUES("Pierre", SHA1("dupont"), "pierre@dupont.fr");
	}
	
	/**
	 * get teams informations
	 * 
	 * @param string $sortentry Entry that is used to sort the teams
	 * @return multitype: array
	 */
	public function getTeams($sortentry = 'id'){
			
		$sql = "select * from core_teams order by " . $sortentry . " ASC;";
		$teams = $this->runRequest($sql);
		return $teams->fetchAll();
	}
	
	/**
	 * get the names of all the teams
	 * 
	 * @return multitype: array
	 */
	public function teamsName(){
			
		$sql = "select name from core_teams";
		$teams = $this->runRequest($sql);
		return $teams->fetchAll();
	}
	
	/**
	 * Get the teams ids and names
	 * 
	 * @return array
	 */
	public function teamsIDName(){
			
		$sql = "select id, name from core_teams";
		$teams = $this->runRequest($sql);
		return $teams->fetchAll();
	}
	
	/**
	 * add a team to the table
	 * 
	 * @param string $name name of the team
	 * @param string $address address of the team
	 */
	public function addTeam($name, $address){
	
		$sql = "insert into core_teams(name, address)"
				. " values(?, ?)";
		$this->runRequest($sql, array($name, $address));
	}
	
	/**
	 * update the information of a team
	 *  
	 * @param int $id Id of the team to update
	 * @param string $name New name of the team
	 * @param string $address New Address of the team
	 */
	public function editTeam($id, $name, $address){
	
		$sql = "update core_teams set name=?, address=? where id=?";
		$this->runRequest($sql, array("".$name."", "".$address."", $id));
	}
	
	/**
	 * get the informations of a team
	 * 
	 * @param int $id Id of the team to query
	 * @throws Exception id the team is not found
	 * @return mixed array
	 */
	public function getTeam($id){
		$sql = "select * from core_teams where id=?";
		$team = $this->runRequest($sql, array($id));
		if ($team->rowCount() == 1)
			return $team->fetch();  // get the first line of the result
		else
			throw new Exception("Cannot find the user using the given parameters");
	}
	
	/**
	 * get the name of a team
	 * 
	 * @param int $id Id of the team to query
	 * @throws Exception if the team is not found
	 * @return mixed array
	 */
	public function getTeamName($id){
		$sql = "select name from core_teams where id=?";
		$team = $this->runRequest($sql, array($id));
		if ($team->rowCount() == 1)
			return $team->fetch();  // get the first line of the result
		else
			throw new Exception("Cannot find the user using the given parameters");
	}
	

}

