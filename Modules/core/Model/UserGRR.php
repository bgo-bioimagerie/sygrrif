<?php

require_once 'Framework/ModelGRR.php';

/**
 * Class defining the User model
 *
 * @author Sylvain Prigent
 */
class UserGRR extends ModelGRR {


   
    public function addUser($login, $name, $firstname, 
    		                $pwd, $email, $statut, $etat){
    	
    	$sql = "insert into grr_utilisateurs(login, nom, prenom, password, email, statut, etat)"
    			. " values(?, ?, ?, ?, ?, ?, ?)";
    	$this->runRequest($sql, array($login, $name, $firstname, md5($pwd), $email, $statut, $etat));
    }

    public function getStatusState($login){
    	$sql = "select statut, etat from grr_utilisateurs where login=?";
    	$user = $this->runRequest($sql, array($login));
    	if ($user->rowCount() == 1)
    		return $user->fetch();  // get the first line of the result
    	else
    		return null;
    }
    
    public function editUser($login, $name, $firstname, $email, $grr_status, $grr_etat){
    	$sql = "update grr_utilisateurs set prenom=?, nom=?, email=?, statut=?, etat=? where login=?";
    	$this->runRequest($sql, array($firstname, $name, $email, $grr_status, $grr_etat, $login));
    }
    
    public function changePwd($login, $pwd){
    	$sql = "update grr_utilisateurs set password=? where login=?";
    	$user = $this->runRequest($sql, array(md5($pwd), $login));
    }
    
    public function updateUserAccount($login, $firstname, $name, $email){
    	$sql = "update grr_utilisateurs set prenom=?, nom=?, email=? where login=?";
    	$this->runRequest($sql, array($firstname, $name, $email, $login));
    }
}

