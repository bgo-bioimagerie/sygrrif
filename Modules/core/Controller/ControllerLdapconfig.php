<?php

require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/ModulesManager.php';
require_once 'Modules/core/Model/LdapConfiguration.php';


class ControllerLdapconfig extends ControllerSecureNav {

	public function __construct() {

	}

	/**
	 * (non-PHPdoc)
	 * Show the config index page
	 * 
	 * @see Controller::index()
	 */
	public function index() {

		// nav bar
		$navBar = $this->navBar();
		
		
		// LDAP configuration
		
		$modelSettings = new CoreConfig();
		$ldapConfig["useLdap"] = $modelSettings->getParam("useLdap");	
		$ldapConfig["ldapDefaultStatus"] = $modelSettings->getParam("ldapDefaultStatus");
		$ldapConfig["ldapSearchAtt"] = $modelSettings->getParam("ldapSearchAtt");
		$ldapConfig["ldapNameAtt"] = $modelSettings->getParam("ldapNameAtt");
		$ldapConfig["ldapFirstnameAtt"] = $modelSettings->getParam("ldapFirstnameAtt");
		$ldapConfig["ldapMailAtt"] = $modelSettings->getParam("ldapMailAtt");
		
		// LDAP connection
		$ldapConnect["ldapAdress"] = LdapConfiguration::get("ldapAdress", "");
		$ldapConnect["ldapPort"] = LdapConfiguration::get("ldapPort", "");
		$ldapConnect["ldapId"] = LdapConfiguration::get("ldapId", "");
		$ldapConnect["ldapPwd"] = LdapConfiguration::get("ldapPwd", "");
		$ldapConnect["ldapBaseDN"] = LdapConfiguration::get("ldapBaseDN", "");
		
		$this->generateView ( array ('navBar' => $navBar,
									 'ldapConfig' => $ldapConfig,
									 'ldapConnect' => $ldapConnect
		) );
	}

	public function editquery(){
		
		// get the post parameters
		$ldapConfig["useLdap"] = $this->request->getParameter ("useLdap");
		$ldapConfig["ldapDefaultStatus"] = $this->request->getParameter ("ldapDefaultStatus");
		$ldapConfig["ldapSearchAtt"] = $this->request->getParameter ("ldapSearchAtt");
		$ldapConfig["ldapNameAtt"] = $this->request->getParameter ("ldapNameAtt");
		$ldapConfig["ldapFirstnameAtt"] = $this->request->getParameter ("ldapFirstnameAtt");
		$ldapConfig["ldapMailAtt"] = $this->request->getParameter ("ldapMailAtt");
		
		$ldapConnect["ldapAdress"] = $this->request->getParameter ("ldapAdress", "");
		$ldapConnect["ldapPort"] = $this->request->getParameter ("ldapPort", "");
		$ldapConnect["ldapId"] = $this->request->getParameter ("ldapId", "");
		$ldapConnect["ldapPwd"] = $this->request->getParameter ("ldapPwd", "");
		$ldapConnect["ldapBaseDN"] = $this->request->getParameter ("ldapBaseDN", "");
		
		// update the database
		$modelSettings = new CoreConfig();
		$modelSettings->setParam("useLdap", $ldapConfig["useLdap"]);
		$modelSettings->setParam("ldapDefaultStatus", $ldapConfig["ldapDefaultStatus"]);
		$modelSettings->setParam("ldapSearchAtt", $ldapConfig["ldapSearchAtt"]);
		$modelSettings->setParam("ldapNameAtt", $ldapConfig["ldapNameAtt"]);
		$modelSettings->setParam("ldapFirstnameAtt", $ldapConfig["ldapFirstnameAtt"]);
		$modelSettings->setParam("ldapMailAtt", $ldapConfig["ldapMailAtt"]);
		
		// update the config file
		
		$fileContent = "; Configuration for ldap" . "\n"
					. "ldapAdress = \"" . $ldapConnect["ldapAdress"] . "\"" . "\n"
					. "ldapPort = \"" . $ldapConnect["ldapPort"] . "\"" . "\n"
					. "ldapId = \"" . $ldapConnect["ldapId"] . "\"" . "\n"
					. "ldapPwd = \"" . $ldapConnect["ldapPwd"] . "\"" . "\n"
					. "ldapBaseDN = \"" . $ldapConnect["ldapBaseDN"] . "\"" . "\n";
		file_put_contents("Config/ldap.ini", $fileContent);

		$this->redirect("coreconfig");
	}
}