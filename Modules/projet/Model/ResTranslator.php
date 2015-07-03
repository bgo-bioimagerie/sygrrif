<?php
class ResTranslator {
	
	public static function Ajouter_Reservation($lang = ""){
		if ($lang == "Fr"){
			return utf8_encode("Ajouter une réservation");
		}
		return "Add Booking";
	}
	
	public static function protocol($lang = ""){
		if ($lang == "Fr"){
			return utf8_encode("Protocole");
		}
		return "Protocol";
	}
	
	public static function codeanonymation($lang = ""){
		if ($lang == "Fr"){
			return utf8_encode("Code d'anonymisation");
		}
		return "Anonymisation code";
	}
	public static function numerovisite($lang = ""){
		if ($lang == "Fr"){
			return utf8_encode("Visite");
		}
		return "Visit number";
	}

}
