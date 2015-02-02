<?php

require_once 'Framework/Controller.php';
require_once 'Modules/core/Model/User.php';

/**
 * Controler managing the user connection 
 * 
 * @author Sylvain Prigent
 */
class ControllerConnection extends Controller
{
    private $user;

    public function __construct()
    {
        $this->user = new User();
    }

    public function index()
    {
        $this->generateView();
    }

    public function login()
    {
        if ($this->request->isparameter("login") && $this->request->isParameter("pwd")) {
            $login = $this->request->getParameter("login");
            $pwd = $this->request->getparameter("pwd");
            
            if ($login == "--"){
            	$this->generateView(array('msgError' => 'Login not correct'), "index");
            	return;
            }
         
            $connect = $this->user->connect($login, $pwd);
            if ($connect == "allowed") {
            	
            	// open the session
                $user = $this->user->getUser($login, $pwd);
                $this->request->getSession()->setAttribut("id_user", $user['idUser']);
                $this->request->getSession()->setAttribut("login", $user['login']);
                $this->request->getSession()->setAttribut("user_status", $user['id_status']);
                
                // add the user settings to the session
                $modelUserSettings = new UserSettings();
                $settings = $modelUserSettings->getUserSettings($user['idUser']);
                $this->request->getSession()->setAttribut("user_settings", $settings);
                
                // update the user last connection
                $this->user->updateLastConnection($user['idUser']);
                
                // update user active base if the user is manager or admin
                if ($user['id_status'] >= 3){
                	$this->user->updateUsersActive();
                }
                
                // redirect
                $this->redirect("home");
            }
            else
                $this->generateView(array('msgError' => $connect),
                        "index");
        }
        else
            throw new Exception("Action not allowed : login or passeword undefined");
    }

    public function logout()
    {
        $this->request->getSession()->destroy();
        $this->redirect("home");
    }

}
