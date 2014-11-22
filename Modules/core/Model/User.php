<?php

require_once 'Framework/Model.php';

/**
 * Class defining the User model
 *
 * @author Baptiste Pesquet
 */
class User extends Model {

    /**
     * Verify that a user is in the database
     * 
     * @param string $login the login
     * @param string $pwd the password
     * @return boolean True if the user is in the database
     */
    public function connecter($login, $pwd)
    {
        $sql = "select UTIL_ID from T_UTILISATEUR where UTIL_LOGIN=? and UTIL_MDP=?";
        $user = $this->runRequest($sql, array($login, $pwd));
        return ($user->rowCount() == 1);
    }

    /**
     * Return a user from the database
     * 
     * @param string $login The login
     * @param string $pwd The password
     * @return The user
     * @throws Exception If the user is not found
     */
    public function getUtilisateur($login, $pwd)
    {
        $sql = "select UTIL_ID as idUtilisateur, UTIL_LOGIN as login, UTIL_MDP as mdp 
            from T_UTILISATEUR where UTIL_LOGIN=? and UTIL_MDP=?";
        $user = $this->runRequest($sql, array($login, $pwd));
        if ($user->rowCount() == 1)
            return $user->fetch();  // get the first line of the result
        else
            throw new Exception("Cannot find the user using the given parameters");
    }

}

