<?php

require_once 'Framework/Controller.php';
require_once 'Modules/core/Model/CoreUser.php';
require_once 'Modules/core/Model/UserSettings.php';
require_once 'Modules/core/Model/ModulesManager.php';
require_once 'Modules/core/Model/Ldap.php';

/**
 * Controler managing the user connection 
 * 
 * @author Sylvain Prigent
 */
class ControllerConnection extends Controller
{
    private $user;

    /**
     * Connstructor
     */
    public function __construct()
    {
        $this->user = new CoreUser();
    }

    /**
     * (non-PHPdoc)
     * @see Controller::index()
     * 
     */
    public function index($message = "")
    {
    	
    	$modelConfig = new CoreConfig();
    	$admin_email = $modelConfig->getParam("admin_email");
    	$logo = $modelConfig->getParam("logo");
    	$home_title = $modelConfig->getParam("home_title");
    	$home_message = $modelConfig->getParam("home_message");
    	
    	
        $this->generateView( array("msgError"=>$message, "admin_email" => $admin_email, "logo" => $logo,  "home_title" => $home_title, "home_message" => $home_message), "index");
    }

    /**
     * Shows the login page
     * @throws Exception
     */
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
         
            $connect = $this->connect($login, $pwd);
            if ($connect == "allowed") {
            	
            	// open the session
                session_unset();
                $user = $this->user->getUserByLogin($login);
                $this->request->getSession()->setAttribut("id_user", $user['idUser']);
                $this->request->getSession()->setAttribut("login", $user['login']);
                $this->request->getSession()->setAttribut("company", Configuration::get("name"));
                $this->request->getSession()->setAttribut("user_status", $user['id_status']);
                
                // add the user settings to the session
                $modelUserSettings = new UserSettings();
                $settings = $modelUserSettings->getUserSettings($user['idUser']);
                $this->request->getSession()->setAttribut("user_settings", $settings);
                
                // update the user last connection
                $this->user->updateLastConnection($user['idUser']);
                
                // update user active base if the user is manager or admin
                $modulesManager = new ModulesManager();
                if ($user['id_status'] >= 3){
                	$this->user->updateUsersActive();
                	if($modulesManager->isDataMenu("sygrrif")){
                		require_once 'Modules/sygrrif/Model/SyAuthorization.php';
                		$modelSygrrif = new SyAuthorization();
                		$modelSygrrif->desactivateUnactiveUserAuthorizations();
                	}
                }
                //return;
                // redirect
        	$redirectController = "Home";
        	if ($modulesManager->isDataMenu("sygrrif")){
        		$redirectController = "sygrrif/booking";
        	}
        	if(isset($_SESSION["user_settings"]["homepage"])){
        		$redirectController = $_SESSION["user_settings"]["homepage"];
        	}	
                
                $this->redirect($redirectController);
            }
            else{
            	//echo "error = " . $connect . "<br/>"; 
            	$this->index($connect);
            	/*
                $this->generateView(array('msgError' => $connect, "admin_email" => $admin_email),
                        "index");
                        */
            }
        }
        else{
            throw new Exception("Action not allowed : login or passeword undefined");
        }
    }

    /**
     * Logout (delete the session)
     */
    public function logout()
    {
        $this->request->getSession()->destroy();
        $this->redirect("home");
    }
    
    /**
     * Connect a user to the application
     * @param string $login User login
     * @param string $pwd User pssword 
     * @return string Error message
     */
    private function connect($login, $pwd){
    	
    	// test if local account
    	if ($this->user->isLocalUser($login)){
    		return $this->user->connect($login, $pwd);
    	}
    	
    	// search for LDAP account
    	else{
	    	$modelCoreConfig = new CoreConfig();
	    	if ($modelCoreConfig->getParam("useLdap") == true){
	    		
	    		$modelLdap = new Ldap();
	    		$ldapResult = $modelLdap->getUser($login, $pwd);
	    		if ($ldapResult == "error"){
	    			return "Cannot connect to ldap using the given login and password";
	    		}
	    		else{
	    			// update the user infos
	    			$status = $modelCoreConfig->getParam("ldapDefaultStatus");
	    			$this->user->setExtBasicInfo($login, $ldapResult["name"], $ldapResult["firstname"], $ldapResult["mail"], $status);
	    			return $this->user->isActive($login);
	    		}
	    	}
    	}
    	
    	return "Login or password not correct";
    }
}
