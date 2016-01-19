<?php

/**
 * Class to translate the template views
 * 
 * @author sprigent
 *
 */
class CaTranslator {
	
	

	public static function CaConfigAbstract($lang){
		if ($lang == "Fr"){
			return "<p>Le module \"Catalogue\" permet de gérer un catalogue de prestations </p>";
		}
		return "<p> The \"Catlog\" module allows creating services catalog </p>";
	}
	
	public static function Catalog_configuration($lang){
		if ($lang == "Fr"){
			return "Configuration du module Cataloge";
		}
		return "Catalog configuration";
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
	
	public static function Catalog_management($lang){
		if ($lang == "Fr"){
			return "Gestion du catalogue";
		}
		return "Catalog management";
	}

	public static function Categories($lang){
		if ($lang == "Fr"){
			return "Catégories";
		}
		return "Categories";
	}
	
	public static function Category($lang){
		if ($lang == "Fr"){
			return "Catégorie";
		}
		return "Category";
	}
	
	public static function Entries($lang){
		if ($lang == "Fr"){
			return "Prestations";
		}
		return "Entries";
	}
	
	public static function Entry($lang){
		if ($lang == "Fr"){
			return "Prestation";
		}
		return "Entry";
	}
	
	public static function Short_desc($lang){
		if ($lang == "Fr"){
			return "Description courte";
		}
		return "Short description";
	}
	
	public static function Full_desc($lang){
		if ($lang == "Fr"){
			return "Description complète";
		}
		return "Full description";
	}
	
	public static function Title($lang){
		if ($lang == "Fr"){
			return "Titre";
		}
		return "Title";
	}
	
	public static function Catalog($lang){
		if ($lang == "Fr"){
			return "Catalogue";
		}
		return "Catalog";
	}
	
	public static function Illustration($lang){
		if ($lang == "Fr"){
			return "Illustration";
		}
		return "Illustration";
	}
	
	
}