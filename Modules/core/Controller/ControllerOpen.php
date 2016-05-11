<?php

require_once 'Framework/Controller.php';
require_once 'Modules/core/Model/CoreUser.php';

/**
 * Mother class for controller using secure connection
 * 
 * @author Sylvain Prigent
 */
abstract class ControllerOpen extends Controller
{

    public function getLanguage(){
    	$lang = "En";
    	if (isset($_SESSION["user_settings"]["language"])){
    		$lang = $_SESSION["user_settings"]["language"];
    	}
        else{
            // get the navigator language
            $langNav = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
            switch ($langNav){
                case "fr":
                    $lang = "Fr";
                    break;
                case "en":
                    $lang = "En";
                    break;      
            }
        }
    	return $lang;
    }
}

