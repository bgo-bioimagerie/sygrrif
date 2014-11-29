<?php

require_once 'Framework/ModelGRR.php';

/**
 * Class defining the User model
 *
 * @author Sylvain Prigent
 */
class UserGRR extends ModelGRR {

    /**
     * Add a user to the grr user table
     * 
     * @param string $login
     * @param string $name
     * @param string $firstname
     * @param string $pwd
     * @param string $email
     * @param string $statut
     * @param string $etat
     */
    public function addUser($login, $name, $firstname, 
    		                $pwd, $email, $statut, $etat){
    	
    	$sql = "insert into grr_utilisateurs(login, nom, prenom, password, email, statut, etat)"
    			. " values(?, ?, ?, ?, ?, ?, ?)";
    	$this->runRequest($sql, array($login, $name, $firstname, md5($pwd), $email, $statut, $etat));
    }

    /**
     * get the state and status of a user
     * 
     * @param string $login 
     * @return mixed|NULL
     */
    public function getStatusState($login){
    	$sql = "select statut, etat from grr_utilisateurs where login=?";
    	$user = $this->runRequest($sql, array($login));
    	if ($user->rowCount() == 1)
    		return $user->fetch();  // get the first line of the result
    	else
    		return null;
    }
    
    /**
     * Change the informations of a user
     * 
     * @param string $login
     * @param string $name
     * @param string $firstname
     * @param string $email
     * @param string $grr_status
     * @param string $grr_etat
     */
    public function editUser($login, $name, $firstname, $email, $grr_status, $grr_etat){
    	$sql = "update grr_utilisateurs set prenom=?, nom=?, email=?, statut=?, etat=? where login=?";
    	$this->runRequest($sql, array($firstname, $name, $email, $grr_status, $grr_etat, $login));
    }
    
    /**
     * Change the passeword of a user
     * 
     * @param string $login
     * @param string $pwd
     */
    public function changePwd($login, $pwd){
    	$sql = "update grr_utilisateurs set password=? where login=?";
    	$user = $this->runRequest($sql, array(md5($pwd), $login));
    }
    
    /**
     * Update the user info that are accessible from account management
     * 
     * @param string $login
     * @param string $firstname
     * @param string $name
     * @param string $email
     */
    public function updateUserAccount($login, $firstname, $name, $email){
    	$sql = "update grr_utilisateurs set prenom=?, nom=?, email=? where login=?";
    	$this->runRequest($sql, array($firstname, $name, $email, $login));
    }
    
    /**
     * get all the users informations
     * 
     * @return multitype: array
     */
    public function getUsers(){
    	$sql = "select * from grr_utilisateurs";
    	$user = $this->runRequest($sql);
    	return $user->fetchAll();
    }
}

