<?php


/**
 * Class to translate the syggrif views
 * 
 * @author sprigent
 *
 */
class MailerTranslator {

	public static function Mailler($lang = ""){
		if ($lang == "Fr"){
			return "Envoyer email";
		}
		return "Mailler";
	}
	
	public static function From($lang = ""){
		if ($lang == "Fr"){
			return "Expediteur";
		}
		return "From";
	}
	
	public static function To($lang = ""){
		if ($lang == "Fr"){
			return "Destinataires";
		}
		return "To";
	}

	public static function Subject($lang = ""){
		if ($lang == "Fr"){
			return "Object";
		}
		return "Subject";
	}
	
	public static function Send($lang = ""){
		if ($lang == "Fr"){
			return "Envoyer";
		}
		return "Send";
	}
	
	public static function MailerConfigAbstract($lang){
		if ($lang == "Fr"){
			return "Module dépendant de sygrrif permettant d'envoyer des emails a des groupes d'utilisateurs";
		}
		return "Module depending on the sygrrif module that allows to send emails to a user group";
	}
	
	public static function Mailer_configuration($lang){
		if ($lang == "Fr"){
			return "Email configuration";
		}
		return "Mailer configuration";
	}
	public static function Content($lang){
		if ($lang == "Fr"){
			return "Contenu";
		}
		return "Content";
	}
	
	
}