<?php


/**
 * Class to translate the syggrif views
 * 
 * @author sprigent
 *
 */
class SyTranslator {
	
	public static function SyGRRif_Booking($lang = ""){
		if ($lang == "Fr"){
			return "SyGRRif Réservations";
		}
		return "SyGRRif Booking";
	}
	
	public static function Area($lang){
		if ($lang == "Fr"){
			return "Domaine";
		}
		return "Area";
	} 
	
	public static function Date($lang){
		if ($lang == "Fr"){
			return "Date";
		}
		return "Date";
	} 
	
	public static function Edit_Reservation($lang = ""){
		if ($lang == "Fr"){
			return "Modification Réservation";
		}
		return "Edit Reservation";
	}
	
	public static function Resource($lang = ""){
		if ($lang == "Fr"){
			return "Ressource";
		}
		return "Resource";
	}
	
	public static function Reservation_number($lang){
		if ($lang == "Fr"){
			return "Identifiant";
		}
		return "Reservation number";
	}
	
	public static function booking_on_behalf_of($lang = ""){
		if ($lang == "Fr"){
			return "Réserver au nom de";
		}
		return "booking on behalf of";
	}
	
	public static function Short_description($lang = ""){
		if ($lang == "Fr"){
			return "Description courte";
		}
		return "Short description";
	}
	
	public static function Full_description($lang = ""){
		if ($lang == "Fr"){
			return "Description complète";
		}
		return "Full description";
	}
	
	public static function Beginning_of_the_reservation($lang = ""){
		if ($lang == "Fr"){
			return "Début de la réservation";
		}
		return "Beginning of the reservation";
	}
	
	public static function End_of_the_reservation($lang=""){
		if ($lang == "Fr"){
			return "Fin de la réservation";
		}
		return "End of the reservation";
	}
	
	public static function Duration($lang = ""){
		if ($lang == "Fr"){
			return "Durée (en minutes)";
		}
		return "Duration (in minutes)";
	}
	
	public static function Color_code($lang = ""){
		if ($lang == "Fr"){
			return "Code couleur";
		}
		return "Color code";
	}
	
	public static function Edit_series($lang = ""){
		if ($lang == "Fr"){
			return "Periodicité";
		}
		return "Edit series";
	}
	
	public static function Edit_series_subtitle($lang = ""){
		if ($lang == "Fr"){
			return "Cela modifie l'ensemble des réservations du la périodicité";
		}
		return "This will affect all the reservations of the series";
	}
	
	public static function Series_type($lang = ""){
		if ($lang == "Fr"){
			return "Type de périodicité";
		}
		return "Series type";
	}
	
	public static function Days_for_week_periodicity($lang = ""){
		if ($lang == "Fr"){
			return "Jours de périodicité";
		}
		return "Days for week periodicity";
	}
	
	public static function Date_end_series($lang = ""){
		if ($lang == "Fr"){
			return "Fin de périodicité";
		}
		return "Date end series";
	}
	
	public static function time($lang = ""){
		if ($lang == "Fr"){
			return "horaire";
		}
		return "time";
	}
	
	public static function Save($lang = ""){
		if ($lang == "Fr"){
			return "Ok";
		}
		return "Save";
	}
	
	public static function Cancel($lang = ""){
		if ($lang == "Fr"){
			return "Annuler";
		}
		return "Cancel";
	}
}