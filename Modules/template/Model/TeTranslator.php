<?php


/**
 * Class to translate the template views
 * 
 * @author sprigent
 *
 */
class TeTranslator {
	
	public static function Supplies($lang){
		if ($lang == "Fr"){
			return "consommables";
		}
		return "Supplies";
	}
	

	public static function TeConfigAbstract($lang){
		if ($lang == "Fr"){
			return "<p>Le module \"Template\" sert de modèle pour créer un nouveau module </p>";
		}
		return "<p> The \"Template\" module helps creating a new module </p>";
	}
	
	public static function Template_configuration($lang){
		if ($lang == "Fr"){
			return "Configuration du module Template";
		}
		return "Template configuration";
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