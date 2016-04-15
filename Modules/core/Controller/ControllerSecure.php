<?php

require_once 'Framework/Controller.php';
require_once 'Modules/core/Model/CoreUser.php';

/**
 * Mother class for controller using secure connection
 * 
 * @author Sylvain Prigent
 */
abstract class ControllerSecure extends Controller
{
	/**
	 * (non-PHPdoc)
	 * @see Controller::runAction()
	 */
    public function runAction($action)
    {

         $modelConfig = new CoreConfig();
        if ($modelConfig->getParam("is_maintenance") ){
            if ($this->request->getSession()->isAttribut("user_status")){
                if ( $_SESSION["user_status"] < 4 ){
                    echo $modelConfig->getParam("maintenance_message");
                    return; 
                }
            }
        }
        
        if ($this->request->getSession()->isAttribut("id_user")) {
        	
        	$login = $this->request->getSession()->getAttribut("login");
        	$company = $this->request->getSession()->getAttribut("company");
        	 
        	$modelUser = new CoreUser();
        	
        	//$connect = $modelUser->connect2($login, $pwd);
        	//echo "connect = " . $connect . "</br>";
        	if ($modelUser->isUser($login) && Configuration::get("name") == $company){
            	parent::runAction($action);
        	}
        	else{
        		//echo "redirect to connection here";
        		$this->redirect("connection");
        	}
        }
        else {
        	//echo "redirect to connection";
            $this->redirect("connection");
        }
    }
    public function getLanguage(){
    	$lang = "En";
    	if (isset($_SESSION["user_settings"]["language"])){
    		$lang = $_SESSION["user_settings"]["language"];
    	}
    	return $lang;
    }
}

