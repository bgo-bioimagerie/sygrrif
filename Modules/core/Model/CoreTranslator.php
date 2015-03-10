<?php


/**
 * Class to translate the syggrif views
 * 
 * @author sprigent
 *
 */
class CoreTranslator {
	
	public static function dateToEn($date, $lang){
		echo "to translate = " . $date . "<br/>";
		if ($lang == "Fr"){
			$dateArray = explode("/", $date);
			//print_r($dateArray);
			$day = $dateArray[0];
			$month = $dateArray[1];
			$year = $dateArray[2];
			//echo "translated = " . $year . "-" . $month . "-" . $day . "<br/>";
			return $year . "-" . $month . "-" . $day; 
		}
		// En
		return $date;
	}
	
	public static function dateFromEn($date, $lang){
		if ($lang == "Fr"){
			$dateArray = explode("-", $date);
			if (count($dateArray) == 3){
				$day = $dateArray[2];
				$month = $dateArray[1];
				$year = $dateArray[0];
				return  $day . "/" . $month . "/" . $year;
			}
			return $date;
		}
		// En
		return $date;
	}
	
	
	public static function Home($lang = ""){
		if ($lang == "Fr"){
			return "Accueil";
		}
		return "Home";
	}
	
	public static function Tools($lang = ""){
		if ($lang == "Fr"){
			return "Outils";
		}
		return "Tools";
	}
	
	public static function Admin($lang = ""){
		if ($lang == "Fr"){
			return "Administration";
		}
		return "Admin";
	}
	
	public static function My_Account($lang = ""){
		if ($lang == "Fr"){
			return "Mon compte";
		}
		return "My Account";
	}
	
	public static function Settings($lang = ""){
		if ($lang == "Fr"){
			return "Préférences";
		}
		return "Settings";
	}
	
	public static function logout($lang = ""){
		if ($lang == "Fr"){
			return "Déconnexion";
		}
		return "logout";
	}
	
	public static function MenuItem($item, $lang = ""){
		if ($lang == "Fr"){
			if($item == "booking"){
				return "calendrier";
			}
			if($item == "users/institutions"){
				return "utilisateurs";
			}
			if($item == "supplies"){
				return "consommables";
			}
		}
		return $item;
	}
	
	public static function Change_password($lang = ""){
		if ($lang == "Fr"){
			return "Modifier mot de passe";
		}
		return "Change password";
	}
	
	public static function Unable_to_change_the_password($lang){
		if ($lang == "Fr"){
			return "Impossible de modifier mot de passe";
		}
		return "Unable to change the password";
	}
	
	public static function The_password_has_been_successfully_updated($lang){
		if ($lang == "Fr"){
			return "Le mot de passe a été mis à jour";
		}
		return "The password has been successfully updated !";
	}
	
	public static function Ok($lang){
		if ($lang == "Fr"){
			return "Ok";
		}
		return "Ok";
	}
	
	public static function Add_User($lang){
		if ($lang == "Fr"){
			return "Ajouter utilisateur";
		}
		return "Add User";
	}
	public static function Name($lang){
		if ($lang == "Fr"){
			return "Nom";
		}
		return "Name";
	}
	public static function Firstname($lang){
		if ($lang == "Fr"){
			return "Prénom";
		}
		return "Firstname";
	}
	public static function Login($lang){
		if ($lang == "Fr"){
			return "Identifiant";
		}
		return "Login";
	}
	public static function Password($lang){
		if ($lang == "Fr"){
			return "Mot de passe";
		}
		return "Password";
	}
	public static function Confirm($lang){
		if ($lang == "Fr"){
			return "Confirmer";
		}
		return "Confirm";
	}
	public static function Email($lang){
		if ($lang == "Fr"){
			return "Couriel";
		}
		return "Email";
	}
	public static function Phone($lang){
		if ($lang == "Fr"){
			return "Téléphone";
		}
		return "Phone";
	}
	public static function Responsible($lang){
		if ($lang == "Fr"){
			return "Responsable";
		}
		return "Responsible";
	}
	public static function is_responsible($lang){
		if ($lang == "Fr"){
			return "est responsable";
		}
		return "is responsible";
	}
	public static function Status($lang){
		if ($lang == "Fr"){
			return "Statut";
		}
		return "Status";
	}
	public static function Convention($lang){
		if ($lang == "Fr"){
			return "Charte";
		}
		return "Convention";
	}
	public static function Date_convention($lang){
		if ($lang == "Fr"){
			return "Date charte";
		}
		return "Date convention";
	}
	public static function Date_end_contract($lang){
		if ($lang == "Fr"){
			return "Date de fin de contrat";
		}
		return "Date end contract";
	}
	public static function Save($lang){
		if ($lang == "Fr"){
			return "Valider";
		}
		return "Save";
	}
	public static function Cancel($lang){
		if ($lang == "Fr"){
			return "Annuler";
		}
		return "Cancel";
	}
	
	public static function Unable_to_add_the_user($lang){
		if ($lang == "Fr"){
			return "Impossible d'ajouter l'utilisateur";
		}
		return "Unable to add the user";
	}
	
	public static function The_user_had_been_successfully_added($lang){
		if ($lang == "Fr"){
			return "L'utilisateur a été ajouté !";
		}
		return "The user had been successfully added !";
	}
	
	public static function for_user($lang){
		if ($lang == "Fr"){
			return "pour l'utilisateur";
		}
		return "for user";
	}
	
	public static function Is_user_active($lang){
		if ($lang == "Fr"){
			return "est actif";
		}
		return "Is user active";
	}
	
	public static function yes($lang){
		if ($lang == "Fr"){
			return "oui";
		}
		return "yes";
	}
	
	public static function no($lang){
		if ($lang == "Fr"){
			return "non";
		}
		return "no";
	}
	
	public static function Edit_User($lang){
		if ($lang == "Fr"){
			return "Editer utilisateur";
		}
		return "Edit User";
	}
	
	public static function Unable_to_update_the_user($lang){
		if ($lang == "Fr"){
			return "Impossible de mettre à jour l'utilisateur ";
		}
		return "Unable to update the user";
	}
	
	public static function The_user_had_been_successfully_updated($lang){
		if ($lang == "Fr"){
			return "L'utilisateur a été mis à jour";
		}
		return "The user had been successfully updated";
	}
	
	public static function User_from($lang){
		if ($lang == "Fr"){
			return "date inscription";
		}
		return "User from";
	}
	
	public static function Last_connection($lang){
		if ($lang == "Fr"){
			return "dernière connexion";
		}
		return "Last connection";
	}
	
	public static function Edit($lang){
		if ($lang == "Fr"){
			return "Editer";
		}
		return "Edit";
	}
	
	public static function Manage_account($lang){
		if ($lang == "Fr"){
			return "Editer compte";
		}
		return "Manage account";
	}
	
	public static function Curent_password($lang){
		if ($lang == "Fr"){
			return "Mot de passe actuel";
		}
		return "Curent password";
	}
	
	public static function New_password($lang){
		if ($lang == "Fr"){
			return "Nouveau mot de passe";
		}
		return "New password";
	}
	
	public static function Unable_to_update_the_account($lang){
		if ($lang == "Fr"){
			return "Impossible de mettre à jour le compte !";
		}
		return "Unable to update the account !";
	}
	
	public static function  The_account_has_been_successfully_updated($lang){
		if ($lang == "Fr"){
			return "Le compte a été mis à jour !";
		}
		return "The account has been successfully updated !";
	}
	
	public static function Users_Institutions($lang){
		if ($lang == "Fr"){
			return "Utilisateurs/Unités";
		}
		return "Users/Institutions";
	}
	
	public static function Units($lang){
		if ($lang == "Fr"){
			return "Unités";
		}
		return "Units";
	}
	
	public static function Add_unit($lang){
		if ($lang == "Fr"){
			return "Ajouter Unité";
		}
		return "Add unit";
	}
	
	public static function Active_Users($lang){
		if ($lang == "Fr"){
			return "Utilisateurs actifs";
		}
		return "Active Users";
	}
	
	public static function Unactive_Users($lang){
		if ($lang == "Fr"){
			return "Utilisateurs inactifs";
		}
		return "Unactive_Users";
	}
	
	public static function Address($lang = ""){
		if ($lang == "Fr"){
			return "Adresse";
		}
		return "Address";
	}
	
	public static function User($lang = ""){
		if ($lang == "Fr"){
			return "Utilisateur";
		}
		return "User";
	}
	
	public static function Users($lang = ""){
		if ($lang == "Fr"){
			return "Utilisateurs";
		}
		return "Users";
	}
	
	public static function Unit($lang = ""){
		if ($lang == "Fr"){
			return "Unité";
		}
		return "Unit";
	}
	
	public static function Add($lang = ""){
		if ($lang == "Fr"){
			return "Ajouter";
		}
		return "Add";
	}
	
	public static function Edit_Unit($lang = ""){
		if ($lang == "Fr"){
			return "Modifier unité";
		}
		return "Edit Unit";
	}
	
	public static function User_Settings($lang = ""){
		if ($lang == "Fr"){
			return "Préférences utilisateur";
		}
		return "User Settings";
	}
	
	public static function Projects($lang = ""){
		if ($lang == "Fr"){
			return "Projets";
		}
		return "Projects";
	}
	
	public static function Add_project($lang = ""){
		if ($lang == "Fr"){
			return "Ajouter projet";
		}
		return "Add project";
	}
	
	public static function Description($lang = ""){
		if ($lang == "Fr"){
			return "Description";
		}
		return "Description";
	}
	
	public static function Edit_Project($lang = ""){
		if ($lang == "Fr"){
			return "Editer Projet";
		}
		return "Edit Project";
	}
	
	public static function Open($lang = ""){
		if ($lang == "Fr"){
			return "Ouvert";
		}
		return "Open";
	}
	public static function Close($lang = ""){
		if ($lang == "Fr"){
			return "Fermé";
		}
		return "Close";
	}
	
	public static function Modules_configuration($lang = ""){
		if ($lang == "Fr"){
			return "Configuration des modules";
		}
		return "Modules configuration";
	}
	
	public static function Config($lang = ""){
		if ($lang == "Fr"){
			return "Config";
		}
		return "Config";
	}
	
	public static function Language($lang = ""){
		if ($lang == "Fr"){
			return "Langue";
		}
		return "Language";
	}
	
	public static function Home_page($lang = ""){
		if ($lang == "Fr"){
			return "Page d'accueil";
		}
		return "Home page";
	}
	
	public static function Database($lang = ""){
		if ($lang == "Fr"){
			return "Base de données";
		}
		return "Database";
	}
	
	public static function Contact_the_administrator($lang = ""){
		if ($lang == "Fr"){
			return "Contacter l'administrateur";
		}
		return "Contact the administrator";
	}
	
	
	public static function CoreConfigAbstract($lang){
		if ($lang == "Fr"){
			return "Le module Core permet de gérer les parametres de 
					l'application et la base de donnée utilisateurs";
		}
		return "The Core module allows to manage the application
				settings and a user database";
	}
	
	public static function Core_configuration($lang = ""){
		if ($lang == "Fr"){
			return "Configuration du \"Core\"";
		}
		return "Core configuration";
	}
	
	public static function Install_Repair_database($lang = ""){
		if ($lang == "Fr"){
			return "Installer/Réparer la base de données";
		}
		return "Install/Repair database";
	}
	
	public static function Install_Txt($lang = ""){
		if ($lang == "Fr"){
			return "Cliquer sur \"Installer\" pour installer ou réparer la base de donnée de Core. 
					Cela crée les tables qui n'existent pas";
		}
		return "To repair the Core mudule, click \"Install\". This will create the
				Core tables in the database if they don't exists ";
	}
	
	public static function Activate_desactivate_menus($lang = ""){
		if ($lang == "Fr"){
			return "Activer/désactivre les menus";
		}
		return "Activate/desactivate menus";
	}
	
	public static function disable($lang = ""){
		if ($lang == "Fr"){
			return "désactivé";
		}
		return "disable";
	}
	public static function enable_for_visitors($lang = ""){
		if ($lang == "Fr"){
			return "activé pour les visiteurs";
		}
		return "enable for visitors";
	}
	public static function enable_for_users($lang = ""){
		if ($lang == "Fr"){
			return "activé pour les utlisateurs";
		}
		return "enable for users";
	}
	public static function enable_for_manager($lang = ""){
		if ($lang == "Fr"){
			return "activé pour les gestionaires";
		}
		return "enable for manager";
	}
	public static function enable_for_admin($lang = ""){
		if ($lang == "Fr"){
			return "activé pour les administrateurs";
		}
		return "enable for admin";
	}
	
	public static function non_active_users($lang = ""){
		if ($lang == "Fr"){
			return "désactivation des utilisateurs";
		}
		return "non-active users";
	}
	
	public static function Disable_user_account_when($lang = ""){
		if ($lang == "Fr"){
			return "désactiver un compte utilisateur lorsque";
		}
		return "Disable user account when";
	}
	
	public static function never($lang = ""){
		if ($lang == "Fr"){
			return "jamais";
		}
		return "never";
	}
	
	public static function contract_ends($lang = ""){
		if ($lang == "Fr"){
			return "fin de contrat";
		}
		return "contract ends";
	}
	
	public static function does_not_login_for_n_year($n, $lang = ""){
		if ($lang == "Fr"){
			if ($n > 1){
				return "ne s'est pas connecté depuis ".$n." années";
			}
			return "ne s'est pas connecté depuis ".$n." année";
		}
		if ($n > 1){
			return "does not login for ".$n." years ";
		}
		return "does not login for ".$n." year ";
	}
	
	public static function Backup($lang = ""){
		if ($lang == "Fr"){
			return "Sauvegarde";
		}
		return "Backup";
	}
	
	public static function Run_backup($lang = ""){
		if ($lang == "Fr"){
			return "Lancer sauvegarde";
		}
		return "Run backup";
	}
	
	public static function Install($lang){
		if ($lang == "Fr"){
			return "Installer";
		}
		return "Install";
	}
	
	public static function Not_signed($lang){
		if ($lang == "Fr"){
			return "Non signée";
		}
		return "Not signed";
	}
	
	public static function Signed_the($lang){
		if ($lang == "Fr"){
			return "Signée le";
		}
		return "Signed on";
	}
	
	public static function Export($lang){
		if ($lang == "Fr"){
			return "Exporter";
		}
		return "Export";
	}
	
	public static function ExportResponsibles($lang){
		if ($lang == "Fr"){
			return "Exporter Responsables";
		}
		return "Export Responsibles";
	}
	
	public static function All($lang){
		if ($lang == "Fr"){
			return "Tous";
		}
		return "All";
	}

	public static function Active($lang){
		if ($lang == "Fr"){
			return "Actifs";
		}
		return "Active";
	}
	
	public static function Unactive($lang){
		if ($lang == "Fr"){
			return "Inactifs";
		}
		return "unactive";
	}
}