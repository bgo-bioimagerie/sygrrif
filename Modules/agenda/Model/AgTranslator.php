<?php


/**
 * Class to translate the agenda views
 * 
 * @author sprigent
 *
 */
class AgTranslator {
	
	public static function AgConfigAbstract($lang){
		if ($lang == "Fr"){
			return "<p>Le module \"Agenda\" permet de gérer un agenda d'évenement pour l'intégrer au modules Web ou Networking </p>";
		}
		return "<p> The \"Agenda\" module helps creating a news agenda to be integrated to Web or Networking modules  </p>";
	}
	
	public static function Agenda_configuration($lang){
		if ($lang == "Fr"){
			return "Configuration du module Agenda";
		}
		return "Agenda configuration";
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

        public static function Agenda($lang){
            if ($lang == "Fr"){
			return "Agenda";
		}
		return "Agenda";
        }
        
        public static function Events($lang){
            if ($lang == "Fr"){
			return "Evenements";
		}
		return "Events";
        }
        
        public static function EventTypes($lang){
            if ($lang == "Fr"){
			return "Types d'évènements";
		}
		return "Event types";
        }
        
        public static function EventType($lang){
            if ($lang == "Fr"){
			return "Type d'évènements";
		}
		return "Event type";
        }
        
        public static function EditEventType($lang){
            if ($lang == "Fr"){
			return "Editer types d'évènements";
		}
		return "Edit event types";
        }
        
        public static function Date_begin($lang){
            if ($lang == "Fr"){
			return "Date début";
		}
		return "Date begin";
        }
        
        public static function Date_end($lang){
            if ($lang == "Fr"){
			return "Date fin";
		}
		return "Date end";
        }
        
        public static function Type($lang){
            if ($lang == "Fr"){
			return "Type";
		}
		return "Type";
        }
        
        public static function Image_url($lang){
            if ($lang == "Fr"){
			return "URL Image";
		}
		return "Image url";
        }
        
        public static function Content($lang){
            if ($lang == "Fr"){
			return "Contenu";
		}
		return "Content";
        }
        
}