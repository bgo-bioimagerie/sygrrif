<?php


/**
 * Class to translate the template views
 * 
 * @author sprigent
 *
 */
class QoTranslator {

	public static function QoConfigAbstract($lang){
		if ($lang == "Fr"){
			return "<p>Le module \"Quotes\" permet de créer des devis </p>";
		}
		return "<p> The \"Quotes\" module allow creating quotes from SyGRRif resources and SProject Supplies </p>";
	}
	
	public static function Quotes_configuration($lang){
		if ($lang == "Fr"){
			return "Configuration du module Quotes";
		}
		return "Quotes configuration";
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
        
        public static function Quotes($lang){
            if ($lang == "Fr"){
                return "Devis";
            }
            return "Quotes";
        }
        
        public static function Recipient($lang){
            if ($lang == "Fr"){
                return "Destinataire";
            }
            return "Recipient";
        }
        public static function DateCreated($lang){
            if ($lang == "Fr"){
                return "Date création";
            }
            return "Date Created";
            
        }
        public static function DateLastModified($lang){
            if ($lang == "Fr"){
                return "Dernière modification";
            }
            return "Last Modified";
        }
        public static function Ok($lang){
            if ($lang == "Fr"){
                return "Ok";
            }
            return "Ok";
        }
        public static function NewQuote($lang){
            if ($lang == "Fr"){
                return "Nouveau devis";
            }
            return "New quote";
        }
        public static function Description($lang){
            if ($lang == "Fr"){
                return "Description";
            }
            return "Description";
        }
        public static function Address($lang){
            if ($lang == "Fr"){
                return "Adresse";
            }
            return "Address";
        }
        
        public static function Add($lang){
            if ($lang == "Fr"){
                return "Ajouter";
            }
            return "Ajouter";
        }
        
        public static function Remove($lang){
            if ($lang == "Fr"){
                return "Enlever";
            }
            return "Remove";
        }
        
        public static function Presta($lang){
            if ($lang == "Fr"){
                return "Prestations";
            }
            return "Quantities";
        }
        
        public static function EditQuote($lang){
            if ($lang == "Fr"){
                return "Modifier Devis";
            }
            return "Edit quote";
            
        }
}