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
        
        
}