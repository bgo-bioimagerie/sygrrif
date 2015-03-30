<?php

require_once 'Framework/Controller.php';
require_once 'Modules/core/Model/User.php';
require_once 'Modules/core/Model/UserSettings.php';

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
    	
    	$modelConfig = new CoreConfig();
    	$admin_email = $modelConfig->getParam("admin_email");
    	
        $this->generateView( array("admin_email" => $admin_email));
    }

    public function login()
    {
    	$modelConfig = new CoreConfig();
    	$admin_email = $modelConfig->getParam("admin_email");
    	
        if ($this->request->isparameter("login") && $this->request->isParameter("pwd")) {
            $login = $this->request->getParameter("login");
            $pwd = $this->request->getparameter("pwd");
            
            if ($login == "--"){
            	$this->generateView(array('msgError' => 'Login not correct', "admin_email" => $admin_email), "index");
            	return;
            }
         
            $connect = $this->user->connect($login, $pwd);
            if ($connect == "allowed") {
            	
            	// open the session
                $user = $this->user->getUser($login, $pwd);
                $this->request->getSession()->setAttribut("id_user", $user['idUser']);
                $this->request->getSession()->setAttribut("login", $user['login']);
                $this->request->getSession()->setAttribut("pwd", $user['pwd']);
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
        		$redirectController = "Home";
        		if (in_array("sygrrif", Configuration::get(modules))){
        			$redirectController = "sygrrif/booking";
        		}
        		if(isset($_SESSION["user_settings"]["homepage"])){
        			$redirectController = $_SESSION["user_settings"]["homepage"];
        		}	
                
                $this->redirect($redirectController);
            }
            else
                $this->generateView(array('msgError' => $connect, "admin_email" => $admin_email),
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
