<?php

require_once 'Modules/core/Model/LdapConfiguration.php';

/**
 * Class defining the  LDAP model to connect 
 * user from LDAP
 * 
 * @author Sylvain Prigent from GRR
 */
class Ldap {
	
	/**
	 * Get the user information using LDAP
	 * @param string $_login User login
	 * @param string $_password User password 
	 * @return multitype: User informatins (name, firstname, login, email)
	 */
	public function getUser($_login, $_password){
		
		$user_dn = $this->grr_opensession($_login, $_password);
		//echo "grr_opensession user dn = " . $user_dn . "<br/>";
		$user_info = $this->grr_getinfo_ldap($user_dn,$_login,$_password);
		return $user_info;
	}
	
	/**
	 * Open LDAP session (adapted from GRR)
	 * @param string $_login User login
	 * @param string $_password User password
	 * @param string $_user_ext_authentifie
	 * @param array $tab_login
	 * @param array $tab_groups
	 * @return multitype: User informatins (name, firstname, login, email)
	 */
	private function grr_opensession($_login, $_password, $_user_ext_authentifie = '', $tab_login = array(), $tab_groups = array()) {
		// Initialisation de $auth_ldap
		$auth_ldap = 'no';
		// Initialisation de $auth_imap
		$auth_imap = 'no';
		// Initialisation de $est_authentifie_sso
		$est_authentifie_sso = FALSE;
		
		// On traite le cas NON SSO
		// -> LDAP sans SSO
		// -> Imap
		$passwd_md5 = md5 ( $_password );
		if ((@function_exists ( "ldap_connect" )) ) {
			// $login_search = ereg_replace("[^-@._[:space:][:alnum:]]", "", $_login);
			$login_search = preg_replace ( "/[^\-@._[:space:]a-zA-Z0-9]/", "", $_login );
			if ($login_search != $_login)
				return "6";
			$user_dn = $this->grr_verif_ldap ( $_login, $_password );
			// print_r($user_dn);
			if ($user_dn == "error_1")
				return "7";
			else if ($user_dn == "error_2")
				return "8";
			else if ($user_dn == "error_3")
				return "9";
			else if ($user_dn) {
				$auth_ldap = 'yes';
				return $user_dn;
			} else
				return "4";
		}
	}
	
	/**
	 * Check if a user can connect with LDAP
	 * @param string $_login User login
	 * @param string $_password User password
	 * @return boolean 
	 */
	private function grr_verif_ldap($_login, $_password) {
		global $ldap_filter;
		if ($_password == '')
			return false;
		
		$ldap_adresse = LdapConfiguration::get("ldapAdress");
		$ldap_port = LdapConfiguration::get("ldapPort");
		$ldap_login = LdapConfiguration::get("ldapId");
		$ldap_pwd = LdapConfiguration::get("ldapPwd");
		$ldap_base = LdapConfiguration::get("ldapBaseDN");
		$use_tls = FALSE;
		$ldap_filter = "";
		
		$ds = $this->grr_connect_ldap ( $ldap_adresse, $ldap_port, $ldap_login, $ldap_pwd, $use_tls );
		// Test with login and password of the user
		if (! $ds) {
			$ds = $this->grr_connect_ldap ( $ldap_adresse, $ldap_port, $_login, $_password, $use_tls );
		}
		if ($ds) {
			
			$modelCoreconfig = new CoreConfig();
			// Attributs testés pour egalite avec le login
			$atts = explode ( "|", $modelCoreconfig->getParam("ldapSearchAtt") ); 
			                            // $atts = array('uid', 'login', 'userid', 'cn', 'sn', 'samaccountname', 'userprincipalname');
			                            // $login_search = ereg_replace("[^-@._[:space:][:alnum:]]", "", $_login);
			$login_search = preg_replace ( "/[^\-@._[:space:]a-zA-Z0-9]/", "", $_login );
			// Tenter une recherche pour essayer de retrouver le DN
			reset ( $atts );
			while ( list ( , $att ) = each ( $atts ) ) {
				$dn = $this->grr_ldap_search_user ( $ds, $ldap_base, $att, $login_search, $ldap_filter );
				// echo "grr_ldap_search_user, dn = " . $dn . "<br/>";
				if (($dn == "error_1") or ($dn == "error_2") or ($dn == "error_3"))
					return $dn;
				else if ($dn) {
					// on a le dn
					if (@ldap_bind ( $ds, $dn, $_password )) {
						@ldap_unbind ( $ds );
						return $dn;
					}
				}
			}
			// Si echec, essayer de deviner le DN, dans le cas où il n'y a pas de filtre supplémentaires
			reset ( $atts );
			if (! isset ( $ldap_filter ) or ($ldap_filter = "")) {
				while ( list ( , $att ) = each ( $atts ) ) {
					$dn = $att . "=" . $login_search . "," . $ldap_base;
					if (@ldap_bind ( $ds, $dn, $_password )) {
						@ldap_unbind ( $ds );
						return $dn;
					}
				}
			}
			return false;
		} else
			return false;
	}
	
	/**
	 * LDAP bind
	 * @param string $l_adresse LDAP adress
	 * @param string $l_port Connection port
	 * @param string $l_login User login
	 * @param string $l_pwd User password
	 * @param boolean $use_tls
	 * @param string $msg_error
	 * @return string|boolean error message or true/false if $msg_error=="no"
	 */
	private function grr_connect_ldap($l_adresse, $l_port, $l_login, $l_pwd, $use_tls, $msg_error = "no") {
		
		// echo "use tls = " . $use_tls . "<br/>";
		// echo "l_adresse = " . $l_adresse . "<br/>";
		$ds = @ldap_connect ( $l_adresse, $l_port );
		if ($ds) {
			// On dit qu'on utilise LDAP V3, sinon la V2 par défaut est utilisé et le bind ne passe pas.
			if (! (ldap_set_option ( $ds, LDAP_OPT_PROTOCOL_VERSION, 3 ))) {
				if ($msg_error != "no")
					return "error_1";
				die ();
			}
			// Option LDAP_OPT_REFERRALS à désactiver dans le cas d'active directory
			@ldap_set_option ( $ds, LDAP_OPT_REFERRALS, 0 );
			if ($use_tls) {
				if (! @ldap_start_tls ( $ds )) {
					if ($msg_error != "no")
						return "error_2";
					return false;
				}
			}
			// Accès non anonyme
			if ($l_login != '') {
				// On tente un bind
				$b = @ldap_bind ( $ds, $l_login, $l_pwd );
			} else {
				// Accès anonyme
				$b = @ldap_bind ( $ds );
			}
			if ($b) {
				return $ds;
			} else {
				if ($msg_error != "no")
					return "error_3";
				return false;
			}
		} else {
			if ($msg_error != "no")
				return "error_4";
			return false;
		}
	}
	/**
	 * Search if a user exists in LDAP (adapted from GRR)
	 * @param string $ds
	 * @param string $basedn
	 * @param string $login_attr
	 * @param string $login
	 * @param string $filtre_sup
	 * @param string $diagnostic
	 * @return string|boolean
	 */
	private function grr_ldap_search_user($ds, $basedn, $login_attr, $login, $filtre_sup = "", $diagnostic = "no") {
		/*
		 * if (Settings::get("ActiveModeDiagnostic") == "y")
		 * $diagnostic = "yes";
		 */
		$diagnostic = "yes";
		// Construction du filtre
		$filter = "(" . $login_attr . "=" . $login . ")";
		if (! empty ( $filtre_sup )) {
			$filter = "(& " . $filter . $filtre_sup . ")";
		}
		
		// echo "base dn = " . $basedn . "<br/>";
		// echo "login_attr = " . $login_attr . "<br/>";
		$res = @ldap_search ( $ds, $basedn, $filter, array (
				"dn",
				$login_attr 
		), 0, 0 );
		if ($res) {
			
			$info = @ldap_get_entries ( $ds, $res );
			if ((! is_array ( $info )) or ($info ['count'] == 0)) {
				// Mode diagnostic
				if ($diagnostic != "no")
					return "error_2";
				else
					return false;
			} else if ($info ['count'] > 1) {
				// Si plusieurs entrées, on accepte uniquement en mode diagnostic
				if ($diagnostic != "no")
					return "error_3";
				else
					return false;
			} else
				return $info [0] ['dn'];
		} else {
			// Mode diagnostic
			if ($diagnostic != "no")
				return "error_1";
			else
				// Mode normal
				return false;
		}
	}
	/**
	 * Get the user informations from the LDAP
	 * @param string $_dn
	 * @param string $_login
	 * @param string $_password
	 * @return string|multitype: User informations or error message
	 */
	private function grr_getinfo_ldap($_dn, $_login, $_password) {
		
		$modelCoreConfig = new CoreConfig();
		$m_setting_ldap_champ_nom = $modelCoreConfig->getParam("ldapNameAtt");
		$m_setting_ldap_champ_prenom = $modelCoreConfig->getParam("ldapFirstnameAtt");
		$m_setting_ldap_champ_email = $modelCoreConfig->getParam("ldapMailAtt");
		
		$ldap_adresse = LdapConfiguration::get("ldapAdress");
		$ldap_port = LdapConfiguration::get("ldapPort");
		$ldap_login = LdapConfiguration::get("ldapId");
		$ldap_pwd = LdapConfiguration::get("ldapPwd");
		$use_tls = FALSE;
		
		// Lire les infos sur l'utilisateur depuis LDAP
		// Connexion à l'annuaire
		$ds = $this->grr_connect_ldap ( $ldap_adresse, $ldap_port, $ldap_login, $ldap_pwd, $use_tls );
		// Test with login and password of the user
		if (! $ds) {
			$ds = $this->grr_connect_ldap ( $ldap_adresse, $ldap_port, $_login, $_password, $use_tls );
		}
		if ($ds) {
			$result = @ldap_read ( $ds, $_dn, "objectClass=*", array (
					$m_setting_ldap_champ_nom,
					$m_setting_ldap_champ_prenom,
					$m_setting_ldap_champ_email 
			) );
		}
		
		if (! $result)
			return "error";
			// Recuperer les donnees de l'utilisateur
		$info = @ldap_get_entries ( $ds, $result );
		if (! is_array ( $info ))
			return "error";
		for($i = 0; $i < $info ["count"]; $i ++) {
			$val = $info [$i];
			if (is_array ( $val )) {
				$l_nom = iconv ( "ISO-8859-1", "utf-8", "Nom à préciser" );
				$l_nom = ucfirst ( $val [$m_setting_ldap_champ_nom] [0] );
				
				$l_prenom = iconv ( "ISO-8859-1", "utf-8", "Prénom à préciser" );
				$l_prenom = ucfirst ( $val [$m_setting_ldap_champ_prenom] [0] );
				
				$l_email = '';
				$l_email = $val [$m_setting_ldap_champ_email] [0];
			}
		}
		
		//echo "user informations = " . $l_nom . ", " . $l_prenom . ", " . $l_email . "</br>";
		// Return infos
		return array (
				"name" => $l_nom,
				"firstname" => $l_prenom,
				"mail" => $l_email 
		);
	}
}
