<?php


/**
 * Class to translate the syggrif views
 * 
 * @author sprigent
 *
 */
class SpTranslator {
	
	public static function Sprojects($lang){
		if ($lang == "Fr"){
			return "Projets";
		}
		return "Projects";
	}
	
	public static function Sprojects_Pricing($lang){
		if ($lang == "Fr"){
			return "Tarifs";
		}
		return "sprojects/Pricing";
	}
	
	public static function Pricing($lang){
		if ($lang == "Fr"){
			return "Tarifs";
		}
		return "Pricing";
	}
	
	public static function Pricing_per_unit($lang){
		if ($lang == "Fr"){
			return "Tarification par unité";
		}
		return "Pricing per unit";
	}
	
	public static function Items($lang){
		if ($lang == "Fr"){
			return "consommables";
		}
		return "Items";
	}
	
	public static function Orders($lang){
		if ($lang == "Fr"){
			return "Projets";
		}
		return "Projects";
	}
	
	public static function All_orders($lang){
		if ($lang == "Fr"){
			return "Tous les projets";
		}
		return "All projects";
	}
	
	public static function Opened_orders($lang){
		if ($lang == "Fr"){
			return "Projets en cours";
		}
		return "Opened projects";
	}
	
	public static function Closed_orders($lang){
		if ($lang == "Fr"){
			return "Projets fermées";
		}
		return "Closed projects";
	}
	
	public static function New_orders($lang){
		if ($lang == "Fr"){
			return "Nouveau projet";
		}
		return "New projects";
	}
	
	public static function Billing($lang){
		if ($lang == "Fr"){
			return "Facturation";
		}
		return "Billing";
	}
	
	public static function Bill($lang){
		if ($lang == "Fr"){
			return "Nouvelle facture";
		}
		return "New Bill";
	}
	
	public static function Billit($lang){
		if ($lang == "Fr"){
			return "Facturer";
		}
		return "Bill it";
	}
	
	
	public static function Bills_manager($lang){
		if ($lang == "Fr"){
			return "Gestionnaire de factures";
		}
		return "Bills manager";
	}
	
	public static function sprojects_bill($lang){
		if ($lang == "Fr"){
			return "Facture consommables";
		}
		return "sprojects bill";
	}
	
	public static function Edit_Bill_Informations($lang){
		if ($lang == "Fr"){
			return "Modifier suivi facture";
		}
		return "Edit Bill Informations";
	}
	
	public static function Number($lang){
		if ($lang == "Fr"){
			return "Nombre";
		}
		return "Number";
	}
	
	public static function Date_generated($lang){
		if ($lang == "Fr"){
			return "Date émise";
		}
		return "Date generated";
	}
	
	public static function Date_paid($lang){
		if ($lang == "Fr"){
			return "Date reglement";
		}
		return "Date paid";
	}
	
	public static function Is_Paid($lang){
		if ($lang == "Fr"){
			return "Est réglée";
		}
		return "Is Paid";
	}
	
	public static function SpConfigAbstract($lang){
		if ($lang == "Fr"){
			return "<p>Le module \"sprojets\" permet de gérer et des facturer des flux de consommables organisés par projets <br\>
					Le module \"sprojets\" possède sa propre base de donnée utilisateurs ou peut utiliser la base de données utilisateurs de core</p>";
		}
		return "<p> The sprojects module allows to manage and bill sprojects ordered by users organized as projects. <br/>
				The sprojects module has its own user database or can use the core user database</p>";
	}
	
	public static function Sprojects_configuration($lang){
		if ($lang == "Fr"){
			return "Configuration consommables";
		}
		return "sprojects configuration";
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
		return "To repair the Core mudule, click \"Install\". This will create the
				module tables in the database if they don't exists ";
	}
	
	public static function Activate_desactivate_menus($lang = ""){
		if ($lang == "Fr"){
			return "Activer/desactiver les menus";
		}
		return "Activate/desactivate menus";
	}
	
	public static function Bill_template($lang = ""){
		if ($lang == "Fr"){
			return "Patron facture xls";
		}
		return "Bill template";
	}
	
	public static function Bill_template_txt($lang){
		if ($lang == "Fr"){
			return "Selectionner un fichier xls servant de patron pour générer les factures";
		}
		return "Select a xls file that will be used as template to generate the bills";
		
	}

	public static function Upload($lang){
		if ($lang == "Fr"){
			return "Télécharger";
		}
		return "Upload";
	}
	
	public static function Add_Order($lang){
		if ($lang == "Fr"){
			return "Ajouter une commande";
		}
		return "Add Order";
	}
	
	public static function Edit_Order($lang){
		if ($lang == "Fr"){
			return "Modifier une commande";
		}
		return "Edit Order";
	}
	
	public static function Description($lang){
		if ($lang == "Fr"){
			return "Description";
		}
		return "Description";
	}
		
	public static function Opened_date($lang){
		if ($lang == "Fr"){
			return "Date de création";
		}
		return "Opened date";
	}
	
	public static function Closed_date($lang){
		if ($lang == "Fr"){
			return "Date de cloture";
		}
		return "Closed date";
	}
	
	public static function Last_modified_date($lang){
		if ($lang == "Fr"){
			return "Dernière modification";
		}
		return "Last modified date";
	}
	
	public static function Order($lang){
		if ($lang == "Fr"){
			return "Commande";
		}
		return "Order";
	}
	
	
	public static function sprojects_Orders($lang){
		if ($lang == "Fr"){
			return "Projets";
		}
		return "Projects";
	}
	
	public static function Add_Item($lang){
		if ($lang == "Fr"){
			return "Ajouter un consommable";
		}
		return "Add_Item";
	}
	
	public static function Edit_Item($lang){
		if ($lang == "Fr"){
			return "Modifier un consommable";
		}
		return "Edit Item";
	}
	
	public static function Is_active($lang){
		if ($lang == "Fr"){
			return "Est actif";
		}
		return "Is active";
	}
	
	public static function sprojects_Items($lang){
		if ($lang == "Fr"){
			return "Consommables";
		}
		return "sprojects Items";
	}
	
	public static function Add_pricing($lang){
		if ($lang == "Fr"){
			return "Ajouter tarif";
		}
		return "Add_pricing";
	}
	
	
	public static function Associate_a_pricing_to_a_unit($lang){
		if ($lang == "Fr"){
			return "Associer un tarif à une unité";
		}
		return "Associate a pricing to a unit";
	}
	
	public static function Edit_pricing($lang){
		if ($lang == "Fr"){
			return "Modifier tarif";
		}
		return "Edit pricing";
	}

	public static function Users_database($lang){
		if ($lang == "Fr"){
			return "Base de données utilisateurs";
		}
		return "Users database";
	}
	
	public static function Delete_entry_Warning($lang){
		if ($lang == "Fr"){
			return "Êtes-vous sûr de vouloir supprimer définitivement cette commande ?";
		}
		return "Delete this entry";
	}
	
	public static function Delete_entry($lang){
				if ($lang == "Fr"){
			return "Supprimer commande ?";
		}
		return "Delete entry";
	} 
}