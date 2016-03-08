<?php

require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecure.php';
require_once 'Modules/core/Model/ModulesManager.php';

/**
 * Mather class for controller using secure connection
 * 
 * @author Sylvain Prigent
 */
abstract class ControllerSecureNav extends ControllerSecure
{
    
	public function __construct(){
		header_remove();
	}
	/**
	 * Get the navbar content
	 * @return string
	 */
    public function navBar(){
    	$menu = $this->buildNavBar($this->request->getSession()->getAttribut("login"));
    	return $menu;
    }
    
    /**
     * Get the tool menu
     * @return multitype: tool menu content
     */
    public function getToolsMenu(){
    	$user_status_id = $_SESSION["user_status"];
    	 
    	$modulesModel = new ModulesManager();
    	$toolMenu = $modulesModel->getDataMenus($user_status_id);
    	return $toolMenu;
    }
    /**
     * Get the admin menu
     * @return multitype: Amdin menu
     */
    public function getAdminMenu(){
    	$user_status_id = $_SESSION["user_status"];
    	
    	$toolAdmin = null;
    	if ($user_status_id == 4){
    		$modulesModel = new ModulesManager();
    		$toolAdmin = $modulesModel->getAdminMenus();
    	}
    	return $toolAdmin;
    }
    
    /**
     * Get the navbar view
     * @param string $login User login
     * @return string: Menu view (html) 
     */
    public function buildNavBar($login){
    	$logoFile = Configuration::get("logoFile");
    	$userName = $login;
    	
    	
    	$toolMenu = $this->getToolsMenu();
    	$toolAdmin = $this->getAdminMenu();
    	
    	// get the view menu,fill it, and return the content
    	$view = $this->generateNavfile(
    			array('logoFile' => $logoFile, 'userName' => $userName, 
    					'toolMenu' => $toolMenu, 'toolAdmin' => $toolAdmin));
    	// Send the view
    	return $view;
    
    }
    
    /**
     * Internal method to build the navbar into HTML
     * @param  $data navbar content
     * @throws Exception
     * @return string Menu view (html) 
     */
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

