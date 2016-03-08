<?php


/**
 * Class to translate the template views
 * 
 * @author sprigent
 *
 */
class BiTranslator {
	
	public static function Supplies($lang){
		if ($lang == "Fr"){
			return "consommables";
		}
		return "Supplies";
	}
	

	public static function BiConfigAbstract($lang){
		if ($lang == "Fr"){
			return "<p>Le module \"Biose\" permet d'indexer et d'analyser des images </p>";
		}
		return "<p> The \"Biose\" module helps analysing images </p>";
	}
	
	public static function Biose_configuration($lang){
		if ($lang == "Fr"){
			return "Configuration du module Biose";
		}
		return "Biose configuration";
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

        public static function Projects($lang = ""){
		if ($lang == "Fr"){
			return "Projets";
		}
		return "Projects";
	}
        
        public static function Owner($lang = ""){
		if ($lang == "Fr"){
			return "Propriétaire";
		}
		return "Owner";
	}
        
        public static function Type($lang = ""){
		if ($lang == "Fr"){
			return "Type";
		}
		return "Type";
	}
        
        public static function NewProject($lang = ""){
		if ($lang == "Fr"){
			return "Nouveau projet";
		}
		return "New Project";
	}
        
        public static function NewProjectText($lang = ""){
		if ($lang == "Fr"){
			return "Aucun projet n'est actuellement associé à votre compte. Cliquer ci-dessous pour créer un nouveau projet";
		}
		return "There is no project associated to you account. You can create a new project with the button below";
	}
        
        public static function ProjectInfo($lang = ""){
		if ($lang == "Fr"){
			return "Informations du project";
		}
		return "Project informations";
	}
        
        public static function Next($lang = ""){
		if ($lang == "Fr"){
			return "Suivant";
		}
		return "Next";
	}
        
        public static function Description($lang = ""){
		if ($lang == "Fr"){
			return "Description";
		}
		return "Description";
	}
        
        public static function Indexation($lang = ""){
		if ($lang == "Fr"){
			return "Description de l'experience";
		}
		return "Experiment description";
	}
        
        public static function key($lang = ""){
		if ($lang == "Fr"){
			return "Condition";
		}
		return "Condition";
	}
        
        public static function values($lang = ""){
		if ($lang == "Fr"){
			return "Valeurs (séparés par ;)";
		}
		return "Values (separated by ;)";
	}
 
}