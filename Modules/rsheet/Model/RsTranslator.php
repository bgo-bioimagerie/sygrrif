<?php


/**
 * Class to translate the template views
 * 
 * @author sprigent
 *
 */
class RsTranslator {
	
	public static function RsConfigAbstract($lang){
		if ($lang == "Fr"){
			return "<p>Le module \"rsheet\" permet de décrire les ressources syggrif et d'étider des fiches de suivi </p>";
		}
		return "<p> The \"rsheet\" module helps creating  </p>";
	}
	
	public static function Rsheet_configuration($lang){
		if ($lang == "Fr"){
			return "Configuration du module Rsheet";
		}
		return "Rsheet configuration";
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

}