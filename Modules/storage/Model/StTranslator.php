<?php


/**
 * Class to translate the syggrif views
 * 
 * @author sprigent
 *
 */
class StTranslator {

	public static function Storage($lang = ""){
		if ($lang == "Fr"){
			return "Stockage";
		}
		return "Stockage";
	}

	public static function ConfigAbstract($lang = ""){
		if ($lang == "Fr"){
			return "Ce module permet de stocker des fichiers temprairement";
		}
		return "This module allows to temporarily store some data";
	}
	
	public static function Storage_configuration($lang){
		if ($lang == "Fr"){
			return "Configuration du stockage";
		}
		return "Storage configuration";
	}
	
	public static function Upload($lang){
		if ($lang == "Fr"){
			return "Ajouter fichiers";
		}
		return "Upload";
	}
	
	public static function Download($lang){
		if ($lang == "Fr"){
			return "Télécharger";
		}
		return "Download";
	}
	
	public static function Delete($lang){
		if ($lang == "Fr"){
			return "Supprimer";
		}
		return "Delete";
	}
	
	public static function Repository($lang){
		if ($lang == "Fr"){
			return "Répertoire";
		}
		return "Repository";
	}
	
	public static function FilePath($lang){
		if ($lang == "Fr"){
			return "Chemin complet du fichier local";
		}
		return "Local file full path ";
	}
	
	public static function ManageFiles($lang){
		if ($lang == "Fr"){
			return "Gestion des fichiers ";
		}
		return "Manage files ";
	}
	
	public static function LocalDirDownload($lang){
		if ($lang == "Fr"){
			return "Destination téléchargements (ex: C:\login\Desktop\) : ";
		}
		return "Local directory for download (ex: C:\login\Desktop\): ";
	}
	
	public static function DownloadMessage($lang){
		if ($lang == "Fr"){
			return "Le fichier est téléchargé:  ";
		}
		return "The file is douwnloaded in: ";
	}
	
	public static function QuotasHoverMessage($lang){
		if ($lang == "Fr"){
			return "Vous ne pouvez plus télécharger de fichiers, votre quota est dépassé";
		}
		return "You cannot upload more files, your quota is over";
	}
	
	public static function MyAccount($lang){
		if ($lang == "Fr"){
			return "Mon espace";
		}
		return "My account";
	}
	
	
	public static function Users_quotas($lang){
		if ($lang == "Fr"){
			return "Quotas utilisateurs";
		}
		return "Users quotas";
	}
	
	public static function Quota($lang){
		if ($lang == "Fr"){
			return "Quota";
		}
		return "Quota";
	}
	
	public static function Edit_Quota($lang){
		if ($lang == "Fr"){
			return "Editer quota";
		}
		return "Edit quota";
	}
	
	public static function Default_quota($lang){
		if ($lang == "Fr"){
			return "Quota par défaut";
		}
		return "Default quota";
	}
	
	
	public static function ftp_settings($lang){
		if ($lang == "Fr"){
			return "Paramètres FTP";
		}
		return "FTP settings";
	}
	
}