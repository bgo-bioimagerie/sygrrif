<?php


/**
 * Class to translate the template views
 * 
 * @author sprigent
 *
 */
class NtTranslator {

	public static function NtConfigAbstract($lang){
		if ($lang == "Fr"){
			return "<p>Le module \"Networking\" sert de réseau d'échange d'informations </p>";
		}
		return "<p> The \"Networking\" module helps informations and data exchanges as a user network </p>";
	}
	
	public static function Nt_configuration($lang){
		if ($lang == "Fr"){
			return "Configuration du module Networking";
		}
		return "Networking configuration";
	}
	
	public static function Install_Repair_database($lang = ""){
		if ($lang == "Fr"){
			return "Installer/Réparer la base de données";
		}
		return "Install/Repair database";
	}
	
	public static function Install_Txt($lang = ""){
		if ($lang == "Fr"){
			return "Cliquer sur \"Installer\" pour installer ou réparer la base de donnée du module. 
					Cela crée les tables qui n'existent pas";
		}
		return "To repair the mudule, click \"Install\". This will create the
				module tables in the database if they don't exists ";
	}
	
	public static function Activate_desactivate_menus($lang = ""){
		if ($lang == "Fr"){
			return "Activer/desactiver les menus";
		}
		return "Activate/desactivate menus";
	}
        
        public static function Groups($lang){
            if ($lang == "Fr"){
			return "Groupes";
		}
		return "Groups";
        }
        
        public static function Goup_users($lang){
            if ($lang == "Fr"){
			return "Utilisateurs du groupe";
		}
		return "Group users";
        }

        public static function Roles_n_Groups($lang){
            if ($lang == "Fr"){
			return "Roles et groupes";
		}
		return "Roles & Groups";
        }
        
        public static function Roles($lang){
            if ($lang == "Fr"){
			return "Roles";
		}
		return "Roles";
        }
        
        public static function GroupsRights($lang){
            if ($lang == "Fr"){
			return "Groupes: droit des roles";
		}
		return "Groups rights";
        }
        
        public static function ProjectsRights($lang){
            if ($lang == "Fr"){
			return "Projets: droit des roles";
		}
		return "Projects rights";
        }
        
        public static function Projects($lang){
            if ($lang == "Fr"){
			return "Projets";
		}
		return "Projects";
        }
        
        public static function Tools($lang){
            if ($lang == "Fr"){
			return "Outils";
		}
		return "Tools";
        }
        
        public static function MyProfile($lang){
            if ($lang == "Fr"){
			return "Profile";
		}
		return "Profile";
        }
        
        public static function Newsfeed($lang){
            if ($lang == "Fr"){
			return "File d'actualité";
		}
		return "Newsfeed";
        }
        
        public static function Notifications($lang){
            if ($lang == "Fr"){
			return "Notifications";
		}
		return "Notifications";
        }
        
        public static function Add_Group($lang){
            if ($lang == "Fr"){
			return "Ajouter group";
		}
		return "Add group";
        }
        
        public static function Add_Project($lang){
            if ($lang == "Fr"){
			return "Ajouter project";
		}
		return "Add project";
        }
        
        
        public static function Edit_Group($lang){
            if ($lang == "Fr"){
			return "Editer group";
		}
		return "Edit group";
        }
        
        public static function Image($lang){
            if ($lang == "Fr"){
			return "Image";
		}
		return "Image";
        }
        
        public static function Group_info($lang){
            if ($lang == "Fr"){
			return "Information groupe";
		}
		return "Group informations";
        }
        
        public static function Add_User($lang){
            if ($lang == "Fr"){
			return "Ajouter utilisateur";
		}
		return "Add user";
        }
        
        public static function ConfirmDeleteGroup($name, $lang){
            if ($lang == "Fr"){
			return "Suprimmer le groupe '" . $name . "' ? " . " cela supprimera toutes les données du groupe";
		}
		return "Delete the group '" . $name . "' ? " . " this will delete all the group data";
		
        }
        
        public static function ConfirmDeleteProject($name, $lang){
            if ($lang == "Fr"){
			return "Suprimmer le projet '" . $name . "' ? " . " cela supprimera toutes les données du projet";
		}
		return "Delete the project '" . $name . "' ? " . " this will delete all the project data";
		
        }
        
        
        public static function Role($lang){
            if ($lang == "Fr"){
			return "Role";
		}
		return "Role";
        }
        
        public static function Publish($lang){
            if ($lang == "Fr"){
			return "Publier";
		}
		return "Publish";
        }
        
        public static function Comment($lang){
            if ($lang == "Fr"){
			return "Commenter";
		}
		return "Comment";
        }
        
        public static function at($lang){
            if ($lang == "Fr"){
			return "à";
		}
		return "at";
        }
        
        public static function WroteThe($lang){
            if ($lang == "Fr"){
			return "à écrit le";
		}
		return "wrote the";
        }
        
        
        public static function adressed_problem($lang){
            if ($lang == "Fr"){
			return "Problème traité";
		}
		return "Adressed problem";
        }
        
        public static function expected_results($lang){
            if ($lang == "Fr"){
			return "Résultats attendu";
		}
		return "Expected results";
        }
       
        public static function protocol($lang){
            if ($lang == "Fr"){
			return "Protocole";
		}
		return "Protocol";
        }
        
        public static function Project_info($lang){
            if ($lang == "Fr"){
			return "Information projet";
		}
		return "Project informations";
        }
        
        public static function Files($lang){
            if ($lang == "Fr"){
			return "Fichiers";
		}
		return "Files";
        }
        
         public static function File($lang){
            if ($lang == "Fr"){
			return "Fichier";
		}
		return "File";
        }
        
}