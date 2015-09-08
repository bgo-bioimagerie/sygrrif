<?php

/**
 * Class to translate the syggrif views
 * 
 * @author sprigent
 *
 */
class ShTranslator {
	public static function Install_Repair_database($lang = "") {
		if ($lang == "Fr") {
			return "Installer/Réparer la base de données";
		}
		return "Install/Repair database";
	}
	public static function Sheet($lang = "") {
		if ($lang == "Fr") {
			return "Fiche";
		}
		return "Sheet";
	}
	public static function Sheets($lang = "") {
		if ($lang == "Fr") {
			return "Fiches";
		}
		return "Sheets";
	}
	public static function ConfigAbstract($lang = "") {
		if ($lang == "Fr") {
			return "Ce module permet de créer et de classer des fiches";
		}
		return "This module allows to create and manage sheets";
	}
	public static function Sheet_configuration($lang) {
		if ($lang == "Fr") {
			return "Configuration du module";
		}
		return "Module configuration";
	}
	public static function Install_Txt($lang = "") {
		if ($lang == "Fr") {
			return "Cliquer sur \"Installer\" pour installer ou réparer la base de données de Sheet. 
					Cela crée les tables qui n'existent pas";
		}
		return "To repair the Sheet mudule, click \"Install\". This will create the
				Sheet tables in the database if they don't exists ";
	}
	public static function Templates($lang) {
		if ($lang == "Fr") {
			return "Modèles";
		}
		return "Templates";
	}
	
	public static function Add($lang) {
		if ($lang == "Fr") {
			return "+";
		}
		return "+";
	}
	
	public static function Edit_template($lang) {
		if ($lang == "Fr") {
			return "Ajouter/Modifier modèle";
		}
		return "Add/Edit template";
	}
	
	public static function Edit_Sheet($lang) {
		if ($lang == "Fr") {
			return "Ajouter/Modifier fiche";
		}
		return "Add/Edit sheet";
	}
	
	
	public static function Delete_Message($lang) {
		if ($lang == "Fr") {
			return "Êtes-vous sûr de voulir suprimer cette fiche ?";
		}
		return "Are you sure to delete this sheet ?";
	}
	
	public static function Delete($lang) {
		if ($lang == "Fr") {
			return "Suprimer fiche";
		}
		return "Delete sheet";
	}
}