<?php

/**
 * Class to translate the web views
 * 
 * @author sprigent
 *
 */
class WbTranslator {
	
	public static function WbConfigAbstract($lang){
		if ($lang == "Fr"){
			return "<p>Le module \"Web\" sert de modèle pour créer un nouveau module </p>";
		}
		return "<p> The \"Web\" module helps creating a new module </p>";
	}
	
	public static function Web_configuration($lang){
		if ($lang == "Fr"){
			return "Configuration du module Web";
		}
		return "Web configuration";
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

        
        public static function Web($lang = ""){
		if ($lang == "Fr"){
			return "Web";
		}
		return "Web";
	}
        
        public static function Menu($lang = ""){
		if ($lang == "Fr"){
			return "Menu";
		}
		return "Menu";
	}
        
        public static function Links($lang = ""){
		if ($lang == "Fr"){
			return "Liens";
		}
		return "Links";
	}
        
        public static function Stylesheet($lang = ""){
		if ($lang == "Fr"){
			return "feuille de style";
		}
		return "Stylesheet";
	}
        
        public static function Home($lang = ""){
		if ($lang == "Fr"){
			return "Accueil";
		}
		return "Home";
	}
        
        public static function Carousel($lang = ""){
		if ($lang == "Fr"){
			return "Carousel";
		}
		return "Carousel";
	}
        
        public static function Features($lang = ""){
		if ($lang == "Fr"){
			return "Items";
		}
		return "Features";
	}
        
        public static function Events($lang = ""){
		if ($lang == "Fr"){
			return "Evenements";
		}
		return "Events";
	}
        
        public static function News($lang = ""){
		if ($lang == "Fr"){
			return "Actualités";
		}
		return "News";
	}
        
        public static function Articles($lang = ""){
		if ($lang == "Fr"){
			return "Articles";
		}
		return "Articles";
	}
        
       
        
        public static function Pages($lang = ""){
		if ($lang == "Fr"){
			return "Pages";
		}
		return "Pages";
	}
        
        public static function Contact($lang = ""){
		if ($lang == "Fr"){
			return "Contact";
		}
		return "Contact";
	}
        
        public static function People($lang = ""){
		if ($lang == "Fr"){
			return "Equipe";
		}
		return "People";
	}
        
        public static function Is_active($lang = ""){
		if ($lang == "Fr"){
			return "Est visible";
		}
		return "Is active";
	}
        
        public static function Name($lang = ""){
		if ($lang == "Fr"){
			return "Nom";
		}
		return "Name";
	}
        
        public static function Url($lang = ""){
		if ($lang == "Fr"){
			return "Url";
		}
		return "Url";
	}
        
        public static function Display_order($lang = ""){
		if ($lang == "Fr"){
			return "Ordre d'affichage";
		}
		return "Display order";
	}
        
        public static function Title($lang = ""){
		if ($lang == "Fr"){
			return "Titre";
		}
		return "Title";
	}
        
        public static function Image_Url($lang = ""){
		if ($lang == "Fr"){
			return "Url image";
		}
		return "Image url";
	}
        
        public static function Description($lang = ""){
		if ($lang == "Fr"){
			return "Description";
		}
		return "Description";
	}
      
        public static function Link($lang = ""){
		if ($lang == "Fr"){
			return "Lien";
		}
		return "Link";
	}
        
        public static function Go($lang = ""){
		if ($lang == "Fr"){
			return "Voir";
		}
		return "Go";
	}
        
        public static function Feature($lang = ""){
		if ($lang == "Fr"){
			return "Item";
		}
		return "Feature";
	}
        
        public static function ViewFeatures($lang = ""){
		if ($lang == "Fr"){
			return "Afficher items";
		}
		return "View features";
	}
        
        public static function Submenus($lang = ""){
		if ($lang == "Fr"){
			return "Sous menus";
		}
		return "Sub menus";
	}
        
        public static function Submenusitems($lang = ""){
		if ($lang == "Fr"){
			return "Sous menus items";
		}
		return "Sub menus items";
	}
        
        public static function Edit_Sub_Menu($lang = ""){
		if ($lang == "Fr"){
			return "Editer sous menu";
		}
		return "Edit sub menu";
	}
        
        public static function Content($lang = ""){
		if ($lang == "Fr"){
			return "Contenu";
		}
		return "Content";
	}
        
        public static function parent_menu($lang = ""){
		if ($lang == "Fr"){
			return "Menu parent";
		}
		return "Parent menu";
	}
        
        public static function date_created($lang = ""){
		if ($lang == "Fr"){
			return "Date création";
		}
		return "Date created";
	}
        
        public static function date_modified($lang = ""){
		if ($lang == "Fr"){
			return "Dernière modification";
		}
		return "Date modified";
	}
        
        public static function is_published($lang = ""){
		if ($lang == "Fr"){
			return "Est publié";
		}
		return "Is published";
	}
        
        public static function is_news($lang = ""){
		if ($lang == "Fr"){
			return "apparait dans actualités";
		}
		return "is news";
	}
        
        public static function All_News($lang = ""){
		if ($lang == "Fr"){
			return "Toutes les actualité";
		}
		return "All news";
	}
        
        public static function Short_desc($lang = ""){
		if ($lang == "Fr"){
			return "Description courte";
		}
		return "Short description";
	}
        
        
        public static function All_Events($lang = ""){
		if ($lang == "Fr"){
			return "Tous les evenements";
		}
		return "All events";
	}
        
}