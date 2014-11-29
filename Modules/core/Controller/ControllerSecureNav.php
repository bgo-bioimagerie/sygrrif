<?php

require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecure.php';

/**
 * Mather class for controller using secure connection
 * 
 * @author Sylvain Prigent
 */
abstract class ControllerSecureNav extends ControllerSecure
{
    
    public function navBar(){
    	$menu = $this->buildNavBar($this->request->getSession()->getAttribut("login"));
    	return $menu;
    }
    
    public function buildNavBar($login){
    	$logoFile = Configuration::get("logoFile");
    	$userName = $login;
    	$toolMenu = array("statistics" => "statistiques");
    	$toolAdmin = array("users" => "users/institutions", "database" => "database",
    			           "configgrr" => "GRR configuration"
    	);
    
    	// get the view menu,fill it, and return the content
    	$view = $this->generateNavfile(
    			array('logoFile' => $logoFile, 'userName' => $userName, 
    					'toolMenu' => $toolMenu, 'toolAdmin' => $toolAdmin));
    	// Send the view
    	return $view;
    
    }
    
    
    private function generateNavfile($data)
    {
    	$file = 'Modules/core/View/navbar.php';
    	if (file_exists($file)) {
    		extract($data);
    
    		ob_start();
    
    		require $file;
    
    		return ob_get_clean();
    	}
    	else {
    		throw new Exception("unable to find the file: '$file' ");
    	}
    }

}

