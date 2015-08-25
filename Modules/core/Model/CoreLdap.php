<?php

require_once 'Framework/Model.php';

/**
 * Class defining the config model
 *
 * @author Sylvain Prigent
 */
class CoreLdap extends Model {
	

	function ldap_query($_login, $_password, $_user_ext_authentifie = '', $tab_login = array(), $tab_groups = array()){
	
		// On initialise au cas où on ne réussisse pas à récupérer les infos dans l'annuaire.
		$l_nom = $_login;
		$l_email = '';
		$l_prenom = '';
		include "Config/config_ldap.inc.php";
		// Connexion à l'annuaire
		$ds = grr_connect_ldap($ldap_adresse,$ldap_port,$ldap_login,$ldap_pwd,$use_tls);
		$user_dn = grr_ldap_search_user($ds, $ldap_base,Settings::get("ldap_champ_recherche"), $_login, $ldap_filter, "no");
		// Test with login and password of the user
		if (!$ds)
			$ds = grr_connect_ldap($ldap_adresse,$ldap_port,$_login,$_password,$use_tls);
		if ($ds)
			$result = @ldap_read($ds, $user_dn, "objectClass=*", array(Settings::get("ldap_champ_nom"),Settings::get("ldap_champ_prenom"),Settings::get("ldap_champ_email")));
		if ($result)
		{
			// Recuperer les donnees de l'utilisateur
			$info = @ldap_get_entries($ds, $result);
			if (is_array($info))
			{
				for ($i = 0; $i < $info["count"]; $i++)
				{
					$val = $info[$i];
					if (is_array($val))
					{
						if (isset($val[Settings::get("ldap_champ_nom")][0]))
							$l_nom = ucfirst($val[Settings::get("ldap_champ_nom")][0]);
						else
							$l_nom = iconv("ISO-8859-1","utf-8","Nom à préciser");
						if (isset($val[Settings::get("ldap_champ_prenom")][0]))
							$l_prenom = ucfirst($val[Settings::get("ldap_champ_prenom")][0]);
						else
							$l_prenom = iconv("ISO-8859-1","utf-8","Prénom à préciser");
						if (isset($val[Settings::get("ldap_champ_email")][0]))
							$l_email = $val[Settings::get("ldap_champ_email")][0];
						else
							$l_email='';
					}
				}
			}
			// Convertir depuis UTF-8 (jeu de caracteres par defaut)
			if ((function_exists("utf8_decode")) && (Settings::get("ConvertLdapUtf8toIso") == "y"))
			{
				$l_email = utf8_decode($l_email);
				$l_nom = utf8_decode($l_nom);
				$l_prenom = utf8_decode($l_prenom);
			}
		}
		$queryContent = Array("nom_user" => $l_nom, "email_user" => $l_email, "prenom_user" => $l_prenom);
	}
	
	
}