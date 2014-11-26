<?php

require_once 'Framework/Model.php';

/**
 * Class defining the Team model
 *
 * @author Sylvain Prigent
 */
class Team extends Model {

	public function createTable(){
			
		$sql = "CREATE TABLE IF NOT EXISTS `teams` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`name` varchar(30) NOT NULL DEFAULT '',
		`adress` varchar(150) NOT NULL DEFAULT '',
		PRIMARY KEY (`id`)
		);";
		
		$pdo = $this->runRequest($sql);
		return $pdo;
	}
	
	public function createDefaultTeam(){
	
		$sql = "INSERT INTO teams (name, adress) VALUES(?,?)";
		$pdo = $this->runRequest($sql, array("--", "--"));
		return $pdo;
	
		//INSERT INTO `membres` (`pseudo`, `passe`, `email`) VALUES("Pierre", SHA1("dupont"), "pierre@dupont.fr");
	}
	
	public function getTeams($sortentry = 'id'){
			
		$sql = "select * from teams order by " . $sortentry . " ASC;";
		$teams = $this->runRequest($sql);
		return $teams->fetchAll();
	}
	
	public function teamsName(){
			
		$sql = "select name from teams";
		$teams = $this->runRequest($sql);
		return $teams->fetchAll();
	}
	
	public function teamsIDName(){
			
		$sql = "select id, name from teams";
		$teams = $this->runRequest($sql);
		return $teams->fetchAll();
	}
	
	public function addTeam($name, $address){
	
		$sql = "insert into teams(name, adress)"
				. " values(?, ?)";
		$this->runRequest($sql, array($name, $address));
	}
	
	public function editTeam($id, $name, $address){
	
		$sql = "update teams set name=?, adress=? where id=?";
		$this->runRequest($sql, array("".$name."", "".$address."", $id));
	}
	
	public function getTeam($id){
		$sql = "select * from teams where id=?";
		$team = $this->runRequest($sql, array($id));
		if ($team->rowCount() == 1)
			return $team->fetch();  // get the first line of the result
		else
			throw new Exception("Cannot find the user using the given parameters");
	}
	
	public function getTeamName($id){
		$sql = "select name from teams where id=?";
		$team = $this->runRequest($sql, array($id));
		if ($team->rowCount() == 1)
			return $team->fetch();  // get the first line of the result
		else
			throw new Exception("Cannot find the user using the given parameters");
	}
	

}

