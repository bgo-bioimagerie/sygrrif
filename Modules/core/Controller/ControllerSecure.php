<?php

require_once 'Framework/Controller.php';
require_once 'Modules/core/Model/User.php';

/**
 * Mather class for controller using secure connection
 * 
 * @author Sylvain Prigent
 */
abstract class ControllerSecure extends Controller
{

    public function runAction($action)
    {

        if ($this->request->getSession()->isAttribut("id_user")) {
        	
        	$login = $this->request->getSession()->getAttribut("login");
        	$pwd = $this->request->getSession()->getAttribut("pwd");
        	 
        	$modelUser = new User();
        	$connect = $modelUser->connect2($login, $pwd);
        	//echo "connect = " . $connect . "</br>";
        	if ($connect == "allowed"){
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
}

