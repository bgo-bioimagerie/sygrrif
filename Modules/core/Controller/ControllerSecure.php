<?php

require_once 'Framework/Controller.php';

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
            parent::runAction($action);
        }
        else {
        	echo "redirect to connection";
            $this->redirect("Connection");
        }
    }
}

