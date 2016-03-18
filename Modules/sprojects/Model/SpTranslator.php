<?php

/**
 * Class to translate the syggrif views
 * 
 * @author sprigent
 *
 */
class SpTranslator {
	public static function Sprojects($lang) {
		if ($lang == "Fr") {
			return "Projets";
		}
		return "Projects";
	}
	public static function Sprojects_Pricing($lang) {
		if ($lang == "Fr") {
			return "Tarifs";
		}
		return "projects/Pricing";
	}
	public static function Pricing($lang) {
		if ($lang == "Fr") {
			return "Tarifs";
		}
		return "Pricing";
	}
	public static function Pricing_per_unit($lang) {
		if ($lang == "Fr") {
			return "Tarification par unité";
		}
		return "Pricing per unit";
	}
	public static function Items($lang) {
		if ($lang == "Fr") {
			return "prestations";
		}
		return "Items";
	}
	public static function Orders($lang) {
		if ($lang == "Fr") {
			return "Projets";
		}
		return "Projects";
	}
	public static function All_orders($lang) {
		if ($lang == "Fr") {
			return "Tous les projets";
		}
		return "All projects";
	}
	public static function Opened_orders($lang) {
		if ($lang == "Fr") {
			return "Projets en cours";
		}
		return "Opened projects";
	}
	public static function Closed_orders($lang) {
		if ($lang == "Fr") {
			return "Projets fermés";
		}
		return "Closed projects";
	}
	public static function New_orders($lang) {
		if ($lang == "Fr") {
			return "Nouveau projet";
		}
		return "New projects";
	}
	public static function Billing($lang) {
		if ($lang == "Fr") {
			return "Facturation";
		}
		return "Billing";
	}
	public static function Bill($lang) {
		if ($lang == "Fr") {
			return "Nouvelle facture";
		}
		return "New Bill";
	}
	public static function Billit($lang) {
		if ($lang == "Fr") {
			return "Facturer";
		}
		return "Bill it";
	}
	public static function Bills_manager($lang) {
		if ($lang == "Fr") {
			return "Gestionnaire de factures";
		}
		return "Bills manager";
	}
	public static function sprojects_bill($lang) {
		if ($lang == "Fr") {
			return "Facture prestations";
		}
		return "sprojects bill";
	}
	public static function Edit_Bill_Informations($lang) {
		if ($lang == "Fr") {
			return "Modifier suivi facture";
		}
		return "Edit Bill Informations";
	}
	public static function Number($lang) {
		if ($lang == "Fr") {
			return "Nombre";
		}
		return "Number";
	}
	public static function Date_generated($lang) {
		if ($lang == "Fr") {
			return "Date émise";
		}
		return "Date generated";
	}
	public static function Date_paid($lang) {
		if ($lang == "Fr") {
			return "Date reglement";
		}
		return "Date paid";
	}
	public static function Is_Paid($lang) {
		if ($lang == "Fr") {
			return "Est réglée";
		}
		return "Is Paid";
	}
	public static function SpConfigAbstract($lang) {
		if ($lang == "Fr") {
			return "<p>Le module \"sprojets\" permet de gérer et des facturer des flux de prestations organisés par projets <br\>
					Le module \"sprojets\" possède sa propre base de donnée utilisateurs ou peut utiliser la base de données utilisateurs de core</p>";
		}
		return "<p> The sprojects module allows to manage and bill sprojects ordered by users organized as projects. <br/>
				The sprojects module has its own user database or can use the core user database</p>";
	}
	public static function Sprojects_configuration($lang) {
		if ($lang == "Fr") {
			return "Configuration projets";
		}
		return "sprojects configuration";
	}
	public static function Install_Repair_database($lang = "") {
		if ($lang == "Fr") {
			return "Installer/Réparer la base de données";
		}
		return "Install/Repair database";
	}
	public static function Install_Txt($lang = "") {
		if ($lang == "Fr") {
			return "Cliquer sur \"Installer\" pour installer ou réparer la base de donnée du module. 
					Cela crée les tables qui n'existent pas";
		}
		return "To repair the Core mudule, click \"Install\". This will create the
				module tables in the database if they don't exists ";
	}
	public static function Activate_desactivate_menus($lang = "") {
		if ($lang == "Fr") {
			return "Activer/desactiver les menus";
		}
		return "Activate/desactivate menus";
	}
	public static function Bill_template($lang = "") {
		if ($lang == "Fr") {
			return "Patron facture xls";
		}
		return "Bill template";
	}
	public static function Bill_template_txt($lang) {
		if ($lang == "Fr") {
			return "Selectionner un fichier xls servant de patron pour générer les factures";
		}
		return "Select a xls file that will be used as template to generate the bills";
	}
	public static function Upload($lang) {
		if ($lang == "Fr") {
			return "Télécharger";
		}
		return "Upload";
	}
	public static function Add_Order($lang) {
		if ($lang == "Fr") {
			return "Nouveau projet";
		}
		return "New project";
	}
	public static function Edit_Order($lang) {
		if ($lang == "Fr") {
			return "Modifier projet";
		}
		return "Edit project";
	}
	public static function Description($lang) {
		if ($lang == "Fr") {
			return "Description";
		}
		return "Description";
	}
	public static function Opened_date($lang) {
		if ($lang == "Fr") {
			return "Date de création";
		}
		return "Opened date";
	}
	public static function Closed_date($lang) {
		if ($lang == "Fr") {
			return "Date de cloture";
		}
		return "Closed date";
	}
	public static function Last_modified_date($lang) {
		if ($lang == "Fr") {
			return "Dernière modification";
		}
		return "Last modified date";
	}
	public static function Order($lang) {
		if ($lang == "Fr") {
			return "Prestation";
		}
		return "Order";
	}
	public static function sprojects_Orders($lang) {
		if ($lang == "Fr") {
			return "Projets";
		}
		return "Projects";
	}
	public static function Add_Item($lang) {
		if ($lang == "Fr") {
			return "Ajouter une prestation";
		}
		return "Add_Item";
	}
	public static function Edit_Item($lang) {
		if ($lang == "Fr") {
			return "Modifier une prestation";
		}
		return "Edit Item";
	}
	public static function Is_active($lang) {
		if ($lang == "Fr") {
			return "Est actif";
		}
		return "Is active";
	}
	public static function sprojects_Items($lang) {
		if ($lang == "Fr") {
			return "Prestations";
		}
		return "sprojects Items";
	}
	public static function Add_pricing($lang) {
		if ($lang == "Fr") {
			return "Ajouter tarif";
		}
		return "Add_pricing";
	}
	public static function Associate_a_pricing_to_a_unit($lang) {
		if ($lang == "Fr") {
			return "Associer un tarif à une unité";
		}
		return "Associate a pricing to a unit";
	}
	public static function Edit_pricing($lang) {
		if ($lang == "Fr") {
			return "Modifier tarif";
		}
		return "Edit pricing";
	}
	public static function Users_database($lang) {
		if ($lang == "Fr") {
			return "Base de données utilisateurs";
		}
		return "Users database";
	}
	public static function Delete_entry_Warning($lang) {
		if ($lang == "Fr") {
			return "Êtes-vous sûr de vouloir supprimer définitivement cette commande ?";
		}
		return "Delete this entry";
	}
	public static function Delete_entry($lang) {
		if ($lang == "Fr") {
			return "Supprimer commande ?";
		}
		return "Delete entry";
	}
	public static function Prices($lang) {
		if ($lang == "Fr") {
			return "Prix";
		}
		return "Prices";
	}
	public static function Export_csv($lang) {
		if ($lang == "Fr") {
			return "Export csv";
		}
		return "Export csv";
	}
	public static function Type($lang) {
		if ($lang == "Fr") {
			return "Type";
		}
		return "Type";
	}
	public static function Open($lang) {
		if ($lang == "Fr") {
			return "Ouvert";
		}
		return "Open";
	}
	public static function Closed($lang) {
		if ($lang == "Fr") {
			return "Fermé";
		}
		return "Closed";
	}
	public static function Time_limite($lang) {
		if ($lang == "Fr") {
			return "Délai";
		}
		return "Time limit";
	}
	public static function New_project($lang) {
		if ($lang == "Fr") {
			return "Nouveau projet";
		}
		return "New project";
	}
	public static function New_team($lang) {
		if ($lang == "Fr") {
			return "Nouvelle equipe";
		}
		return "New team";
	}
	public static function Academique($lang) {
		if ($lang == "Fr") {
			return "Académique";
		}
		return "Academic";
	}
	public static function Industry($lang) {
		if ($lang == "Fr") {
			return "Privé";
		}
		return "Industry";
	}
	public static function Statistics($lang) {
		if ($lang == "Fr") {
			return "Statistiques";
		}
		return "Statistics";
	}
	public static function Open_after_date($lang) {
		if ($lang == "Fr") {
			return "Début période";
		}
		return "Begenning period";
	}
	public static function Open_before_date($lang) {
		if ($lang == "Fr") {
			return "Fin période";
		}
		return "end period";
	}
	public static function Ok($lang) {
		if ($lang == "Fr") {
			return "Ok";
		}
		return "Ok";
	}
	public static function numberNewIndustryTeam($lang) {
		if ($lang == "Fr") {
			return "Nb de nouveau utilisateurs privé";
		}
		return "Number of new industry team";
	}
	public static function purcentageNewIndustryTeam($lang) {
		if ($lang == "Fr") {
			return "Pourcentage de nouveau utilisateurs privé";
		}
		return "Purcentage of new industry team";
	}
	public static function numberIndustryProjects($lang) {
		if ($lang == "Fr") {
			return "Nb de projets avec les Privé";
		}
		return "Number of industry projects";
	}
	public static function loyaltyIndustryProjects($lang) {
		if ($lang == "Fr") {
			return "Fidélisation des Privé";
		}
		return "Loyalty of industry projects";
	}
	public static function numberNewAccademicTeam($lang) {
		if ($lang == "Fr") {
			return "Nb de nouveaux accadémiques";
		}
		return "Number of new accademic team";
	}
	public static function purcentageNewAccademicTeam($lang) {
		if ($lang == "Fr") {
			return "Pourcentage de nouveaux académiques";
		}
		return "Purcentage of new accademic team";
	}
	public static function numberAccademicProjects($lang) {
		if ($lang == "Fr") {
			return "Nb de projets avec les académiques";
		}
		return "Number of accademic projects";
	}
	public static function loyaltyAccademicProjects($lang) {
		if ($lang == "Fr") {
			return "Fidélisation des académiques";
		}
		return "Loyalty of accademic projects";
	}
	public static function totalNumberOfProjects($lang) {
		if ($lang == "Fr") {
			return "Nombre total des projets";
		}
		return "Total number of projects";
	}
	
	public static function Bilan_projets($lang){
		if ($lang == "Fr") {
			return "Bilan projets";
		}
		return "Balance sheet of projects";
	}
	
	public static function period_from($lang){
		if ($lang == "Fr") {
			return "période du ";
		}
		return "period from ";
	}
	
	public static function to($lang){
		if ($lang == "Fr") {
			return " au ";
		}
		return " to ";
	}
	
	public static function Project_number($lang){
		if ($lang == "Fr") {
			return "Numéro projet";
		}
		return "Project number";
	}
	
	public static function Total_HT($lang){
		if ($lang == "Fr") {
			return "Total HT";
		}
		return "Total HT";
	}
	
	public static function Beginning_period($lang) {
		if ($lang == "Fr") {
			return "Début période";
		}
		return "Beginning period";
	}
	public static function End_period($lang) {
		if ($lang == "Fr") {
			return "Fin période";
		}
		return "End period";
	}
	
	public static function Bills_statistics($lang) {
		if ($lang == "Fr") {
			return "Statistiques factures";
		}
		return "Bills statistics";
	}
	
	public static function TotalNumberOfBills($lang) {
		if ($lang == "Fr") {
			return "Nombre total de factures";
		}
		return "Total number of bills";
	}
	public static function NumberOfAcademicBills($lang) {
		if ($lang == "Fr") {
			return "Nombre de factures académiques";
		}
		return "Number of academic bills";
	}
	public static function TotalPriceOfAcademicBills($lang) {
		if ($lang == "Fr") {
			return "Montant total académiques";
		}
		return "Total price of academic bills";
	}
	public static function NumberOfPrivateBills($lang) {
		if ($lang == "Fr") {
			return "Nombre de factures privés";
		}
		return "Total price of private bills";
	}
	public static function TotalPriceOfPrivateBills($lang) {
		if ($lang == "Fr") {
			return "Montant total privés";
		}
		return "Total price of private bills";
	}
	
	public static function TotalPrice($lang) {
		if ($lang == "Fr") {
			return "Montant total";
		}
		return "Total price";
	}

	public static function Responsible_list($lang){
		if ($lang == "Fr") {
			return "Listing responsables";
		}
		return "Responsible listing";
	}
	
	public static function No_Projet($lang){
		if ($lang == "Fr") {
			return "No projet";
		}
		return "# project";
	}
	
	public static function ExportType($lang){
		if ($lang == "Fr") {
			return "Type d'export";
		}
		return "Export type";
	}
	
	public static function view($lang){
		if ($lang == "Fr") {
			return "Afficher";
		}
		return "View";
	}
        
        public static function Balance_sheet($lang){
                if ($lang == "Fr") {
			return "Bilan";
		}
		return "Balance sheet";
        }
        
        public static function OPENED($lang){
                if ($lang == "Fr") {
			return "OUVERTURE";
		}
		return "OPENED";
        }
        
        public static function Invoice_details($lang){
                if ($lang == "Fr") {
                    return "DETAILS PRESTATIONS";
		}
		return "BENEFIT DETAILS";
        }
        
        public static function invoices($lang){
                if ($lang == "Fr") {
                    return "FACTURES";
		}
		return "INVOICES";
        }
        
        public static function StatisticsMaj($lang){
                if ($lang == "Fr") {
                    return "STATISTIQUES";
		}
		return "STATISTICS";
        }
	
        public static function BalanceSheetFrom($lang){
                if ($lang == "Fr") {
                    return "Bilan sur la période du ";
                }
		return "Balance sheet from ";
        }
        
        public static function Date($lang){
                if ($lang == "Fr") {
                    return "Date";
                }
		return "Date";
        }
        
        public static function Prestation($lang){
                if ($lang == "Fr") {
                    return "Prestation";
                }
		return "Prestation";
        }
        
        public static function Quantity($lang){
                if ($lang == "Fr") {
                    return "Quantity";
                }
		return "Quantity";
        }
        
        public static function Add($lang){
                if ($lang == "Fr") {
                    return "Ajouter";
                }
		return "Add";
        }
                
        public static function Remove($lang){
                if ($lang == "Fr") {
                    return "Enlever";
                }
		return "Remove";
        }
        
        public static function invoiced($lang){
            if ($lang == "Fr") {
                return "Facturé";
            }
            return "Invoiced";
        } 
        
        public static function RemoveInvoice($lang){
            if ($lang == "Fr") {
                return "Annuler facture";
            }
            return "Cancel invoice";
        }
        
        public static function NotInvoiced($lang){
            if ($lang == "Fr") {
                return "Pas encore facturé";
            }
            return "Not invoiced yet";
        }
        
        public static function ExportAndStats($lang){
            if ($lang == "Fr") {
                return "Export & Statistiques";
            }
            return "Exports & Statistics";
        }
        
        public static function BillPerPeriode($lang){
            if ($lang == "Fr") {
                return "Facturation par période";
            }
            return "Invoice a period";
        }
        
        public static function OneBillMultipleProjects($lang){
            if ($lang == "Fr") {
                return "Une facture pour plusieurs projets";
            }
            return "One bill multiple projects";
        }
        
        public static function Sevices_details($lang){
            if ($lang == "Fr") {
                return "PRESTATIONS";
            }
            return "Sevices details";    
        }
        
        public static function Sevices_billed_details($lang){
            if ($lang == "Fr") {
                return "PRESTATIONS FACTUREES";
            }
            return "BILLED SERVICES";    
        }
        
}