<?php

/**
 * Class to translate the syggrif views
 * 
 * @author sprigent
 *
 */
class SyTranslator {
	public static function Area_and_Resources($lang = "") {
		if ($lang == "Fr") {
			return "Domaines et ressources";
		}
		return "Area and Resources";
	}
	public static function Add($lang = "") {
		if ($lang == "Fr") {
			return "Ajouter";
		}
		return "Add";
	}
	public static function Areas($lang = "") {
		if ($lang == "Fr") {
			return "Domaines";
		}
		return "Areas";
	}
	public static function Resource_categories($lang = ""){
		if ($lang == "Fr"){
			return "Catégories de ressources";
		}
		return "Resource categories";
	}
	public static function color_code($lang = "") {
		if ($lang == "Fr") {
			return "Code couleur";
		}
		return "Color code";
	}
	public static function color_codes($lang = "") {
		if ($lang == "Fr") {
			return "Codes couleur";
		}
		return "Color codes";
	}
	public static function Color($lang = "") {
		if ($lang == "Fr") {
			return "Couleur";
		}
		return "Color";
	}
	public static function Resources($lang = "") {
		if ($lang == "Fr") {
			return "Ressources";
		}
		return "Resources";
	}
	public static function Users_Authorizations($lang = "") {
		if ($lang == "Fr") {
			return "Autorisations";
		}
		return "Users Authorizations";
	}
	public static function Visa($lang = "") {
		if ($lang == "Fr") {
			return "Visa";
		}
		return "Visa";
	}
	public static function Active_Authorizations($lang = "") {
		if ($lang == "Fr") {
			return "Autorisations actives";
		}
		return "Active Authorizations";
	}
	public static function Unactive_Authorizations($lang = "") {
		if ($lang == "Fr") {
			return "Autorisations non actives";
		}
		return "Inactive Authorizations";
	}
	public static function Add_Authorizations($lang = "") {
		if ($lang == "Fr") {
			return "Ajouter une autorisation";
		}
		return "Add Authorizations";
	}
	public static function Pricing($lang = "") {
		if ($lang == "Fr") {
			return "Tarification";
		}
		return "Pricing";
	}
	public static function Pricings($lang = "") {
		if ($lang == "Fr") {
			return "Tarifs";
		}
		return "Pricing";
	}
	public static function Pricing_Unit($lang = "") {
		if ($lang == "Fr") {
			return "Tarification par unité";
		}
		return "Pricing/Unit";
	}
	public static function Export($lang = "") {
		if ($lang == "Fr") {
			return "Export";
		}
		return "Export";
	}
	
	public static function Export_stats($lang = ""){
		if ($lang == "Fr"){
			return "Export et statistiques";
		}
		return "Export and stats";
	}
	
	public static function Statistics_Resources($lang = ""){
		if ($lang == "Fr"){
			return "Statistiques de réservation";
		}
		return "Booking statistics";
	}
	public static function Bill_per_unit($lang = "") {
		if ($lang == "Fr") {
			return "Facture par responsable";
		}
		return "Bill/Responsible";
	}
	public static function Bills_manager($lang = ""){
		if ($lang == "Fr"){
			return "Historique de facturation";
		}
		return "Bills manager";
	}
	
	public static function Statistics_users($lang = ""){
		if ($lang == "Fr"){
			return "Statistiques des utilisateurs";
		}
		return "Users statistics";
	}
	public static function Statistics_authorizations($lang = ""){
		if ($lang == "Fr"){
			return "Statistiques des autorisations";
		}
		return "Authorizations statistics";
	}
	public static function bill_project($lang = "") {
		if ($lang == "Fr") {
			return "Facture par projet";
		}
		return "Bill/Project";
	}
	public static function SyGRRif_Booking($lang = "") {
		if ($lang == "Fr") {
			return "SyGRRif Réservations";
		}
		return "SyGRRif Booking";
	}
	public static function Area($lang) {
		if ($lang == "Fr") {
			return "Domaine";
		}
		return "Area";
	}
	public static function Date($lang) {
		if ($lang == "Fr") {
			return "Date";
		}
		return "Date";
	}
	public static function Edit_Reservation($lang = "") {
		if ($lang == "Fr") {
			return "Modification Réservation";
		}
		return "Edit Reservation";
	}
	public static function Resource($lang = "") {
		if ($lang == "Fr") {
			return "Ressource";
		}
		return "Resource";
	}
	public static function Reservation_number($lang) {
		if ($lang == "Fr") {
			return "Nombre de réservations";
		}
		return "Reservation number";
	}
	public static function Reservation_time($lang){
		if ($lang == "Fr"){
			return "Temps de réservation";
		}
		return "Reservation time";
	}
	public static function booking_on_behalf_of($lang = "") {
		if ($lang == "Fr") {
			return "Réserver au nom de";
		}
		return "booking on behalf of";
	}
	public static function Short_description($lang = "") {
		if ($lang == "Fr") {
			return "Description courte";
		}
		return "Short description";
	}
	public static function Full_description($lang = "") {
		if ($lang == "Fr") {
			return "Description complète";
		}
		return "Full description";
	}
	public static function Beginning_of_the_reservation($lang = "") {
		if ($lang == "Fr") {
			return "Début de la réservation";
		}
		return "Beginning of the reservation";
	}
	public static function End_of_the_reservation($lang = "") {
		if ($lang == "Fr") {
			return "Fin de la réservation";
		}
		return "End of the reservation";
	}
	public static function Duration($lang = "") {
		if ($lang == "Fr") {
			return "Durée";
		}
		return "Duration";
	}
	public static function Minutes($lang = "") {
		if ($lang == "Fr") {
			return "Minutes";
		}
		return "Minutes";
	}
	public static function Hours($lang = "") {
		if ($lang == "Fr") {
			return "Heures";
		}
		return "Hours";
	}
	public static function Days($lang = "") {
		if ($lang == "Fr") {
			return "Jours";
		}
		return "Days";
	}
	public static function Edit_series($lang = "") {
		if ($lang == "Fr") {
			return "Periodicité";
		}
		return "Edit series";
	}
	public static function Edit_series_subtitle($lang = ""){
		if ($lang == "Fr"){
			return "Cela modifie l'ensemble des réservations de la périodicité";
		}
		return "This will affect all the reservations of the series";
	}
	public static function Series_type($lang = "") {
		if ($lang == "Fr") {
			return "Type de périodicité";
		}
		return "Series type";
	}
	public static function Days_for_week_periodicity($lang = "") {
		if ($lang == "Fr") {
			return "Jours de périodicité";
		}
		return "Days for week periodicity";
	}
	public static function Date_end_series($lang = "") {
		if ($lang == "Fr") {
			return "Fin de périodicité";
		}
		return "Date end series";
	}
	public static function time($lang = "") {
		if ($lang == "Fr") {
			return "horaire";
		}
		return "time";
	}
	public static function Save($lang = ""){
		if ($lang == "Fr"){
			return "Enregistrer";
		}
		return "Save";
	}
	public static function Cancel($lang = "") {
		if ($lang == "Fr") {
			return "Annuler";
		}
		return "Cancel";
	}
	public static function Calendar_Default_view($lang = ""){
		if ($lang == "Fr"){
			return "Vue par défaut dans le calendrier";
		}
		return "Calendar default view";
	}
	public static function Day($lang = "") {
		if ($lang == "Fr") {
			return "Jour";
		}
		return "Day";
	}
	public static function Week($lang = "") {
		if ($lang == "Fr") {
			return "Semaine";
		}
		return "Week";
	}
	public static function Month($lang = "") {
		if ($lang == "Fr") {
			return "Mois";
		}
		return "Month";
	}
	public static function Week_Area($lang = "") {
		if ($lang == "Fr") {
			return "Semainier";
		}
		return "Week Area";
	}
	public static function Day_Area($lang = ""){
		if ($lang == "Fr"){
			return "Jour Domaine";
		}
		return "Day Area";
	}
	public static function Authorized_users($lang = ""){
		if ($lang == "Fr"){
			return "Listing des autorisations";
		}
		return "Authorized users list";
	}
	public static function Ok($lang = "") {
		if ($lang == "Fr") {
			return "Ok";
		}
		return "Ok";
	}
	public static function Active_users($lang = "") {
		if ($lang == "Fr") {
			return "Utilisateurs actifs";
		}
		return "Active users";
	}
	public static function User($lang = "") {
		if ($lang == "Fr") {
			return "Utilisateur";
		}
		return "User";
	}
	public static function Responsible($lang = "") {
		if ($lang == "Fr") {
			return "Responsable";
		}
		return "Person in charge";
	}
	public static function User_and_Responsible($lang = ""){
		if ($lang == "Fr"){
			return "Utilisateur et Responsable";
		}
		return "User and Person in charge";
	}
	public static function Date_Start($lang = "") {
		if ($lang == "Fr") {
			return "Date début";
		}
		return "Date Start";
	}
	public static function Date_End($lang = "") {
		if ($lang == "Fr") {
			return "Date fin";
		}
		return "Date End";
	}
	public static function Project($lang = "") {
		if ($lang == "Fr") {
			return "Projet";
		}
		return "Project";
	}
	public static function Pricing_by($lang = "") {
		if ($lang == "Fr") {
			return "Tarification au";
		}
		return "Pricing by";
	}
	public static function Time2($lang = "") {
		if ($lang == "Fr") {
			return "temps";
		}
		return "Time";
	}
	public static function Reservations_number($lang = "") {
		if ($lang == "Fr") {
			return "nombre de réservations";
		}
		return "reservations number";
	}
	public static function SyConfigAbstract($lang = ""){
		if ($lang == "Fr"){
			return "Le module SyGRRif permet de gérer des ressources et de
					générer des statistiques et des factures";
		}
		return "The SyGRRif module allows to manage GRR Ressources and to
				generate statistics and bills"; 
	}
	public static function Edit_Bill_Informations($lang = "") {
		if ($lang == "Fr") {
			return "Modifier informations facture";
		}
		return "Edit bill informations";
	}
	public static function Number($lang = "") {
		if ($lang == "Fr") {
			return "Numéro";
		}
		return "Number";
	}
	public static function Date_generated($lang = "") {
		if ($lang == "Fr") {
			return "Date d'émission";
		}
		return "Date generated";
	}
	public static function Date_paid($lang = "") {
		if ($lang == "Fr") {
			return "Date règlement";
		}
		return "Date paid";
	}
	public static function Is_Paid($lang = "") {
		if ($lang == "Fr") {
			return "Est réglée";
		}
		return "Is Paid";
	}
	public static function Yes($lang = "") {
		if ($lang == "Fr") {
			return "Oui";
		}
		return "Yes";
	}
	public static function No($lang = "") {
		if ($lang == "Fr") {
			return "Non";
		}
		return "No";
	}
	public static function Delete($lang = "") {
		if ($lang == "Fr") {
			return "Suprimer";
		}
		return "Delete";
	}
	public static function Sygrrif_Bills($lang = "") {
		if ($lang == "Fr") {
			return "Factures SyGRRif";
		}
		return "Sygrrif Bills";
	}
	public static function Edit($lang = "") {
		if ($lang == "Fr") {
			return "Editer";
		}
		return "Edit";
	}
	public static function Name($lang = "") {
		if ($lang == "Fr") {
			return "Nom";
		}
		return "Name";
	}
	public static function Unit($lang = "") {
		if ($lang == "Fr") {
			return "Unité";
		}
		return "Unit";
	}
	public static function Export_type($lang = "") {
		if ($lang == "Fr") {
			return "Type d'export";
		}
		return "Export type";
	}
	public static function counting($lang = "") {
		if ($lang == "Fr") {
			return "décompte";
		}
		return "counting";
	}
	public static function detail($lang = "") {
		if ($lang == "Fr") {
			return "détail";
		}
		return "detail";
	}
	public static function bill($lang = "") {
		if ($lang == "Fr") {
			return "facture";
		}
		return "bill";
	}
	public static function Add_area($lang = ""){
		if ($lang == "Fr"){
			return "Ajouter un Domaine";
		}
		return "Add Area";
	}
	public static function Is_resticted($lang = "") {
		if ($lang == "Fr") {
			return "Est restreint";
		}
		return "Is resticted";
	}
	public static function Display_order($lang = "") {
		if ($lang == "Fr") {
			return "Ordre d'affichage";
		}
		return "Display order";
	}
	public static function Add_Authorization($lang = "") {
		if ($lang == "Fr") {
			return "Ajouter une autorisation";
		}
		return "Add Authorization";
	}
	public static function Unit_at_the_authorization_date_time($lang = "") {
		if ($lang == "Fr") {
			return "Unité au moment de la formation";
		}
		return "Unit at the authorization date time";
	}
	public static function Training_date($lang = "") {
		if ($lang == "Fr") {
			return "Date de formation";
		}
		return "Training date";
	}
	public static function Add_Color_Code($lang = "") {
		if ($lang == "Fr") {
			return "Ajouter un code couleur";
		}
		return "Add Color Code";
	}
	public static function Color_diese($lang = "") {
		if ($lang == "Fr") {
			return "Couleur: #";
		}
		return "Color: #";
	}
	public static function Text_color_diese($lang = "") {
		if ($lang == "Fr") {
			return "Couleur text: #";
		}
		return "Text color: #";
	}
	public static function Add_pricing($lang = "") {
		if ($lang == "Fr") {
			return "Ajouter un tarif";
		}
		return "Add pricing";
	}
	public static function Unique_price($lang = "") {
		if ($lang == "Fr") {
			return "Tarif unique";
		}
		return "Add pricing";
	}
	public static function Price_night($lang = ""){
		if ($lang == "Fr"){
			return "Tarif de nuit";
		}
		return "Night rate";
	}
	public static function Night_beginning($lang = "") {
		if ($lang == "Fr") {
			return "Début nuit";
		}
		return "Night beginning";
	}
	public static function Night_end($lang = "") {
		if ($lang == "Fr") {
			return "Fin nuit";
		}
		return "Night end";
	}
	public static function Price_weekend($lang = ""){
		if ($lang == "Fr"){
			return "Tarif de week-end";
		}
		return "Week-end rate";
	}
	public static function Weekend_days($lang = ""){
		if ($lang == "Fr"){
			return "Jours week-end";
		}
		return "Week-end days";
	}
	public static function Monday($lang = "") {
		if ($lang == "Fr") {
			return "Lundi";
		}
		return "Monday";
	}
	public static function Tuesday($lang = "") {
		if ($lang == "Fr") {
			return "Mardi";
		}
		return "Tuesday";
	}
	public static function Wednesday($lang = "") {
		if ($lang == "Fr") {
			return "Mercredi";
		}
		return "Wednesday";
	}
	public static function Thursday($lang = "") {
		if ($lang == "Fr") {
			return "Jeudi";
		}
		return "Thursday";
	}
	public static function Friday($lang = "") {
		if ($lang == "Fr") {
			return "Vendredi";
		}
		return "Friday";
	}
	public static function Saturday($lang = "") {
		if ($lang == "Fr") {
			return "Samedi";
		}
		return "Saturday";
	}
	public static function Sunday($lang = "") {
		if ($lang == "Fr") {
			return "Dimanche";
		}
		return "Sunday";
	}
	public static function Unable_to_add_the_pricing($lang = "") {
		if ($lang == "Fr") {
			return "Impossible d'ajouter le tarif";
		}
		return "Unable to add the pricing";
	}
	public static function The_pricing_has_been_successfully_added($lang = "") {
		if ($lang == "Fr") {
			return "Le tarif a été ajouté avec success !";
		}
		return "The pricing has been successfully added!";
	}
	public static function Add_a_resource($lang = "") {
		if ($lang == "Fr") {
			return "Ajouter une ressource";
		}
		return "Add a resource";
	}
	public static function Select_the_resource_type($lang = "") {
		if ($lang == "Fr") {
			return "Sélectioner le type de ressource";
		}
		return "Select the resource type";
	}
	public static function Resource_type($lang = "") {
		if ($lang == "Fr") {
			return "Type de ressource";
		}
		return "Resource type";
	}
	public static function Next($lang = "") {
		if ($lang == "Fr") {
			return "Suivant";
		}
		return "Next";
	}
	public static function Add_a_resources_category($lang = "") {
		if ($lang == "Fr") {
			return "Aouter une catégorie de ressource";
		}
		return "Add a resources category";
	}
	public static function Associate_a_pricing_to_a_unit($lang = "") {
		if ($lang == "Fr") {
			return "Associer un tarif à une unité";
		}
		return "Associate a pricing to a unit";
	}
	public static function Unable_to_associate_the_pricing_with_the_unit($lang = "") {
		if ($lang == "Fr") {
			return "Impossible d'associer le tarif à l'unité";
		}
		return "Unable to associate the pricing with the unit";
	}
	public static function The_pricing_has_been_successfully_associated_to_the_unit($lang = "") {
		if ($lang == "Fr") {
			return "Le tarif a bien été associé à l'unité !";
		}
		return "The pricing has been successfully associated with the unit!";
	}
	public static function Add_VISA($lang = "") {
		if ($lang == "Fr") {
			return "Ajouter un Visa";
		}
		return "Add Visa";
	}
	public static function Authorisations($lang = "") {
		if ($lang == "Fr") {
			return "Autorisations";
		}
		return "Authorizations";
	}
	public static function Firstname($lang = "") {
		if ($lang == "Fr") {
			return "Prénom";
		}
		return "Firstname";
	}
	public static function Select_a_resource_on_the_navigation_bar($lang){
		if ($lang == "Fr"){
			return "Sélectionner une ressource dans la barre de navigation";
		}
		return "Select a resource in the navigation bar";
	}
	public static function Edit_area($lang){
		if ($lang == "Fr"){
			return "Modifier Domaine";
		}
		return "Edit Area";
	}
	public static function Edit_Authorization($lang){
		if ($lang == "Fr"){
			return "Editer une autorisation";
		}
		return "Edit authorization";
	}
	public static function Is_active($lang) {
		if ($lang == "Fr") {
			return "Est active";
		}
		return "Is active";
	}
	public static function Edit_Color_Code($lang){
		if ($lang == "Fr"){
			return "Editer un Code couleur";
		}
		return "Edit Color code";
	}
	public static function Edit_pricing($lang){
		if ($lang == "Fr"){
			return "Editer un Tarif";
		}
		return "Edit Pricing";
	}
	public static function Unable_to_modify_the_pricing($lang) {
		if ($lang == "Fr") {
			return "Imposible de modifier le tarif";
		}
		return "Unable to modify the pricing";
	}
	public static function The_pricing_has_been_successfully_modified($lang) {
		if ($lang == "Fr") {
			return "Le tarif a été modifié !";
		}
		return "The pricing has been successfully modified!";
	}
	public static function Edit_a_resources_category($lang = ""){
		if ($lang == "Fr"){
			return "Editer une Catégorie de ressource";
		}
		return "Edit a Resource category";
	}
	public static function Edit_Visa($lang = "") {
		if ($lang == "Fr") {
			return "Editer Visa";
		}
		return "Edit Visa";
	}
	public static function Description($lang = "") {
		if ($lang == "Fr") {
			return "Description";
		}
		return "Description";
	}
	public static function Type($lang = "") {
		if ($lang == "Fr") {
			return "Type";
		}
		return "Type";
	}
	public static function Category($lang = "") {
		if ($lang == "Fr") {
			return "Catégorie";
		}
		return "Category";
	}
	public static function Curent_unit($lang = "") {
		if ($lang == "Fr") {
			return "Unité actuelle";
		}
		return "Current unit";
	}
	public static function Outputs($lang) {
		if ($lang == "Fr") {
			return "Exports";
		}
		return "Outputs";
	}
	public static function view_resources_pie_chart($lang){
		if ($lang == "Fr"){
			return "Diagramme circulaire des autorisations par ressource";
		}
		return "View resources pie chart";
	}
	public static function view_counting($lang) {
		if ($lang == "Fr") {
			return "décompte";
		}
		return "view counting";
	}
	public static function view_details($lang) {
		if ($lang == "Fr") {
			return "détail";
		}
		return "view details";
	}
	public static function Calculate($lang) {
		if ($lang == "Fr") {
			return "Calculer";
		}
		return "Calculate";
	}
	public static function Results($lang) {
		if ($lang == "Fr") {
			return "Résultats";
		}
		return "Results";
	}
	public static function Export_as_jpeg($lang) {
		if ($lang == "Fr") {
			return "Exporter en jpeg";
		}
		return "Export as jpeg";
	}
	public static function Export_as_csv($lang) {
		if ($lang == "Fr") {
			return "Exporter en csv";
		}
		return "Export as csv";
	}
	public static function Export_as_xls($lang) {
		if ($lang == "Fr") {
			return "Exporter en xls";
		}
		return "Export as xls";
	}
	public static function Search_criteria($lang) {
		if ($lang == "Fr") {
			return "Critères de recherche";
		}
		return "Search criteria";
	}
	public static function Number_of_training($lang) {
		if ($lang == "Fr") {
			return "Nombre de formations";
		}
		return "Number of trainings";
	}
	public static function Nomber_of_users($lang) {
		if ($lang == "Fr") {
			return "Nombre d'utilisateurs";
		}
		return "Nomber of users";
	}
	public static function Nomber_of_units($lang) {
		if ($lang == "Fr") {
			return "Nombre d'unités";
		}
		return "Number of units";
	}
	public static function Nomber_of_VISAs($lang) {
		if ($lang == "Fr") {
			return "Nombre de Visas";
		}
		return "Number of Visas";
	}
	public static function Nomber_of_resources($lang) {
		if ($lang == "Fr") {
			return "Nombre de ressources";
		}
		return "Number of resources";
	}
	public static function Nomber_of_new_user($lang){
		if ($lang == "Fr"){
			return "Nombre de nouveaux utilisateurs";
		}
		return "Number of new user";
	}
	public static function Statistics($lang) {
		if ($lang == "Fr") {
			return "Statistiques";
		}
		return "Statistics";
	}
	public static function Year($lang) {
		if ($lang == "Fr") {
			return "Année";
		}
		return "Year";
	}
	public static function Annual_review_of_the_number_of_reservations_of($lang) {
		if ($lang == "Fr") {
			return "Bilan annuel du nombre de réservations pour ";
		}
		return "Annual review of the number of reservations for ";
	}
	public static function Annual_review_of_the_time_of_reservations_of($lang){
		if ($lang == "Fr"){
			return "Bilan annuel du temps de réservation pour ";
		}
		return "Annual review of the time of reservations for ";
	}
	public static function Jan($lang) {
		if ($lang == "Fr") {
			return "Janv.";
		}
		return "Jan.";
	}
	public static function Feb($lang) {
		if ($lang == "Fr") {
			return "Févr.";
		}
		return "Feb.";
	}
	public static function Mar($lang){
		if ($lang == "Fr"){
			return "Mars";
		}
		return "Mar.";
	}
	public static function Apr($lang) {
		if ($lang == "Fr") {
			return "Avri.";
		}
		return "Apr.";
	}
	public static function May($lang) {
		if ($lang == "Fr") {
			return "Mai";
		}
		return "May";
	}
	public static function Jun($lang){
		if ($lang == "Fr"){
			return "Juin";
		}
		return "June";
	}
	public static function July($lang) {
		if ($lang == "Fr") {
			return "Juil.";
		}
		return "July";
	}
	public static function Aug($lang){
		if ($lang == "Fr"){
			return "Août";
		}
		return "Aug.";
	}
	public static function Sept($lang) {
		if ($lang == "Fr") {
			return "Sept.";
		}
		return "Sept.";
	}
	public static function Oct($lang) {
		if ($lang == "Fr") {
			return "Oct.";
		}
		return "Oct.";
	}
	public static function Nov($lang) {
		if ($lang == "Fr") {
			return "Nov.";
		}
		return "Nov.";
	}
	public static function Dec($lang) {
		if ($lang == "Fr") {
			return "Déc.";
		}
		return "Dec.";
	}
	public static function Add_Unitary_Resource($lang) {
		if ($lang == "Fr") {
			return "Ajouter ressource unitaire";
		}
		return "Add Unitary Resource";
	}
	public static function Edit_Unitary_Resource($lang) {
		if ($lang == "Fr") {
			return "Editer ressource unitaire";
		}
		return "Edit Unitary Resource";
	}
	public static function Who_can_book($lang){
		if ($lang == "Fr"){
			return "Qui peut réserver ?";
		}
		return "Who can book?";
	}
	public static function Manager($lang) {
		if ($lang == "Fr") {
			return "Gestionnaire";
		}
		return "Manager";
	}
	public static function Admin($lang) {
		if ($lang == "Fr") {
			return "Administrateur";
		}
		return "Admin";
	}
	public static function Settings($lang) {
		if ($lang == "Fr") {
			return "Paramètres";
		}
		return "Settings";
	}
	public static function Quantity_name($lang) {
		if ($lang == "Fr") {
			return "Intitulé de la quantité";
		}
		return "Quantity name";
	}
	public static function Quantity($lang) {
		if ($lang == "Fr") {
			return "Quantité";
		}
		return "Quantity";
	}
	public static function Available_Days($lang) {
		if ($lang == "Fr") {
			return "Jours disponibles";
		}
		return "Available Days";
	}
	public static function Day_beginning($lang) {
		if ($lang == "Fr") {
			return "Début journée";
		}
		return "Day beginning";
	}
	public static function Day_end($lang) {
		if ($lang == "Fr") {
			return "Fin journée";
		}
		return "Day end";
	}
	public static function Booking_size_bloc($lang) {
		if ($lang == "Fr") {
			return "Résolution du bloc de réservation";
		}
		return "Booking size bloc";
	}
	public static function The_user_specify($lang) {
		if ($lang == "Fr") {
			return "L'utilisateur spécifie";
		}
		return "The user specifies";
	}
	public static function the_booking_duration($lang){
		if ($lang == "Fr"){
			return "La durée de la réservation";
		}
		return "the booking duration";
	}
	public static function the_date_time_when_reservation_ends($lang) {
		if ($lang == "Fr") {
			return "La date et l'heure de fin de la réservation";
		}
		return "the date/time when reservation ends";
	}
	public static function Prices($lang) {
		if ($lang == "Fr") {
			return "Prix";
		}
		return "Prices";
	}
	public static function Add_Calendar_Resource($lang) {
		if ($lang == "Fr") {
			return "Ajouter ressource calendaire";
		}
		return "Add Calendar Resource";
	}
	public static function Edit_Calendar_Resource($lang) {
		if ($lang == "Fr") {
			return "Editer ressource calendaire";
		}
		return "Edit Calendar Resource";
	}
	public static function Max_number_of_people($lang) {
		if ($lang == "Fr") {
			return "Nombre maximum de personnes";
		}
		return "Max number of people";
	}
	public static function Price_day($lang) {
		if ($lang == "Fr") {
			return "Tarif jour";
		}
		return "Price day";
	}
	public static function Price_w_e($lang) {
		if ($lang == "Fr") {
			return "Tarif w.e";
		}
		return "Price w.e";
	}
	public static function Today($lang) {
		if ($lang == "Fr") {
			return "Aujourd'hui";
		}
		return "Today";
	}
	public static function translateDayFromEn($day, $lang) {
		if ($day == "Monday") {
			return SyTranslator::Monday ( $lang );
		}
		if ($day == "Tuesday") {
			return SyTranslator::Tuesday ( $lang );
		}
		if ($day == "Wednesday") {
			return SyTranslator::Wednesday ( $lang );
		}
		if ($day == "Thursday") {
			return SyTranslator::Thursday ( $lang );
		}
		if ($day == "Friday") {
			return SyTranslator::Friday ( $lang );
		}
		if ($day == "Saturday") {
			return SyTranslator::Saturday ( $lang );
		}
		if ($day == "Sunday") {
			return SyTranslator::Sunday ( $lang );
		}
	}
	public static function translateMonthFromEn($day, $lang) {
		if ($lang == "Fr") {
			if ($day == "January") {
				return "Janvier";
			}
			if ($day == "February") {
				return "Février";
			}
			if ($day == "March") {
				return "Mars";
			}
			if ($day == "April") {
				return "Avril";
			}
			if ($day == "May") {
				return "Mai";
			}
			if ($day == "June") {
				return "Juin";
			}
			if ($day == "July") {
				return "Juillet";
			}
			if ($day == "August") {
				return "Août";
			}
			if ($day == "September") {
				return "Septembre";
			}
			if ($day == "October") {
				return "Octobre";
			}
			if ($day == "November") {
				return "Novembre";
			}
			if ($day == "December") {
				return "Décembre";
			}
		}
	}
	public static function DateFromTime($time, $lang) {
		$dayStream = date ( "l", $time );
		$monthStream = date ( "F", $time );
		$dayNumStream = date ( "d", $time );
		$yearStream = date ( "Y", $time );
		$sufixStream = date ( "S", $time );
		
		if ($lang == "Fr") {
			
			return SyTranslator::translateDayFromEn ( $dayStream, $lang ) . " " . $dayNumStream . " " . SyTranslator::translateMonthFromEn ( $monthStream, $lang ) . " " . $yearStream;
			
			// setlocale(LC_TIME, "fr_FR");
			// return utf8_encode(strftime('%A %d %B %Y', $time));
		}
		// english
		
		return $dayStream . ", " . $monthStream . " " . $dayNumStream . $sufixStream . " " . $yearStream;
	}
	public static function This_week($lang) {
		if ($lang == "Fr") {
			return "Cette semaine";
		}
		return "This week";
	}
	public static function Phone($lang){
		if ($lang == "Fr"){
			return "Tél.";
		}
		return "Phone";
	}
	public static function Short_desc($lang){
		if ($lang == "Fr"){
			return "courte desc.";
		}
		return "Short desc.";
	}
	public static function Desc($lang){
		if ($lang == "Fr"){
			return "Desc.";
		}
		return "Desc.";
	}
	public static function Fromdate($lang) {
		if ($lang == "Fr") {
			return "Période du";
		}
		return "From";
	}
	public static function ToDate($lang) {
		if ($lang == "Fr") {
			return "au";
		}
		return "to";
	}
	public static function Booking_time_year($lang){
		if ($lang == "Fr"){
			return "Nombre d'heures de réservation par ressource dans l'année";
		}
		return "Time (in hours) of reservations for each resource during the given period";
	}
	public static function Booking_time_year_category($lang) {
		if ($lang == "Fr") {
			return "Nombre d'heures de réservation par catégories de ressources dans la période";
		}
		return "Time (in hours) of reservations for each resource category during the given period";
	}
	public static function Booking_number_year($lang){
		if ($lang == "Fr"){
			return "Nombre de réservations par ressource dans l'année";
		}
		return "Number of reservations during the year";
	}
	public static function Booking_number_year_category($lang) {
		if ($lang == "Fr") {
			return "Nombre de réservations par catégorie de ressources dans la période";
		}
		return "Number of reservations for each resource category during the given period";
	}
	public static function email($lang){
		if ($lang == "Fr"){
			return "courriel";
		}
		return "email";
	}
	public static function Period_begin($lang) {
		if ($lang == "Fr") {
			return "Début période";
		}
		return "Period begin";
	}
	public static function Period_end($lang) {
		if ($lang == "Fr") {
			return "Fin période";
		}
		return "Period end";
	}
	public static function BillListExport($lang){
		if ($lang == "Fr"){
			return "Exporter l'historique de facturation";
		}
		return "Bill list export";
	}
	
	public static function block_resources($lang){
		if ($lang == "Fr"){
			return "Bloquer des ressources";
		}
		return "Block resources";
	}
	public static function grr_report($lang) {
		if ($lang == "Fr") {
			return "Statistiques GRR";
		}
		return "GRR report";
	}
	public static function query($lang) {
		if ($lang == "Fr") {
			return "Requête";
		}
		return "Query";
	}
	public static function Recipient($lang) {
		if ($lang == "Fr") {
			return "Bénéficiaire";
		}
		return "Recipient";
	}
	public static function Contains($lang) {
		if ($lang == "Fr") {
			return "Contient";
		}
		return "Contains";
	}
	public static function Does_not_contain($lang) {
		if ($lang == "Fr") {
			return "Ne contient pas";
		}
		return "Does not contain";
	}
	public static function Output($lang) {
		if ($lang == "Fr") {
			return "Export";
		}
		return "Output";
	}
	public static function TotalHT($lang) {
		if ($lang == "Fr") {
			return "Total HT";
		}
		return "Total HT";
	}
	static public function Default_color($lang) {
		if ($lang == "Fr") {
			return "Couleur par défaut";
		}
		return "Default color";
	}
	static public function Supplies($lang) {
		if ($lang == "Fr") {
			return "Consommables";
		}
		return "Supplies";
	}
	static public function Remove($lang) {
		if ($lang == "Fr") {
			return "Suprimer";
		}
		return "Remove";
	}
	static public function Prices_for($lang) {
		if ($lang == "Fr") {
			return "Tarifs pour ";
		}
		return "Prices for";
	}
	static public function Beginning($lang) {
		if ($lang == "Fr") {
			return "Début";
		}
		return "Beginning";
	}
	static public function End($lang) {
		if ($lang == "Fr") {
			return "Fin";
		}
		return "End";
	}
	static public function Edited_by($lang) {
		if ($lang == "Fr") {
			return "Edité par";
		}
		return "Edited by";
	}
	static public function Your_reservation($lang) {
		if ($lang == "Fr") {
			return "Votre réservation";
		}
		return "Your reservation";
	}
	static public function Your_reservation_has_been_added($lang) {
		if ($lang == "Fr") {
			return "Une réservation a été ajoutée à votre nom";
		}
		return "Your reservation has been added";
	}
	static public function Your_reservation_has_been_modified($lang) {
		if ($lang == "Fr") {
			return "Votre réservation à été modifiée";
		}
		return "Your reservation has been modified";
	}
	static public function Your_reservation_has_been_deleted($lang){
		if ($lang == "Fr"){
			return "Votre réservation a été supprimée";
		}
		return "Your reservation has been deleted";
	}
	static public function Authorisations_menu_location($lang) {
		if ($lang == "Fr") {
			return "Localisation du menu autorisations";
		}
		return "Authorisations menu location";
	}
	static public function Booking_style($lang) {
		if ($lang == "Fr") {
			return "Style agenda";
		}
		return "Booking stylesheet";
	}
	static public function Packages($lang) {
		if ($lang == "Fr") {
			return "Forfaits";
		}
		return "Packages";
	}
	static public function Select_Package($lang) {
		if ($lang == "Fr") {
			return "Choix forfait";
		}
		return "Select package";
	}
	static public function Use_Package($lang) {
		if ($lang == "Fr") {
			return "Utiliser forfait";
		}
		return "Use package";
	}

	static public function Pricing_Type($lang) {
		if ($lang == "Fr") {
			return "La réservation se fait";
		}
		return "Use package";
	}
	static public function Use_time_and_package($lang) {
		if ($lang == "Fr") {
			return "En temps et en package";
		}
		return "Use time and package";
	}
	static public function Use_only_package($lang) {
		if ($lang == "Fr") {
			return "Uniquement en package";
		}
		return "only package";
	}


	static public function Authorisations_for($lang){
		if ($lang == "Fr"){
			return "Autorisations pour ";
		}
		return "Authorisations for";
	}
	
	static public function Modifications_have_been_saved($lang){
		if ($lang == "Fr") {
			return "Les modifications ont bien été enregistrées";
		}
		return "Modifications have been saved";
	}
	

	static public function Begining_period($lang) {
		if ($lang == "Fr") {
			return "Début période";
		}
		return "Begining period";
	}
	static public function End_period($lang) {
		if ($lang == "Fr") {
			return "Fin période";
		}
		return "End period";
	}
	static public function Period($lang) {
		if ($lang == "Fr") {
			return "période";
		}
		return "period";
	}
	static public function to($lang) {
		if ($lang == "Fr") {
			return "au";
		}
		return "to";
	}
	static public function monthNameFromID($id, $lang) {
		if ($lang == "Fr") {
			if ($id == 1) {
				return "Janv.";
			}
			if ($id == 2) {
				return "Fév.";
			}
			if ($id == 3) {
				return "Mar.";
			}
			if ($id == 4) {
				return "Avr.";
			}
			if ($id == 5) {
				return "Mai";
			}
			if ($id == 6) {
				return "Juin";
			}
			if ($id == 7) {
				return "Juil.";
			}
			if ($id == 8) {
				return "Août";
			}
			if ($id == 9) {
				return "Sept.";
			}
			if ($id == 10) {
				return "Oct.";
			}
			if ($id == 11) {
				return "Nov.";
			}
			if ($id == 12) {
				return "Déc.";
			}
		} else {
			if ($id == 1) {
				return "Janv.";
			}
			if ($id == 2) {
				return "Fev.";
			}
			if ($id == 3) {
				return "Mar.";
			}
			if ($id == 4) {
				return "Apr.";
			}
			if ($id == 5) {
				return "May";
			}
			if ($id == 6) {
				return "Jun";
			}
			if ($id == 7) {
				return "Jul.";
			}
			if ($id == 8) {
				return "Aug.";
			}
			if ($id == 9) {
				return "Sep.";
			}
			if ($id == 10) {
				return "Oct.";
			}
			if ($id == 11) {
				return "Nov.";
			}
			if ($id == 12) {
				return "Dec.";
			}
		}
	}
	
	public static function Booking_number_year_category($lang) {
		if ($lang == "Fr") {
			return "Nombre de réservations par catégorie de ressources dans la période";
		}
		return "Number of reservations for each resource category during the given period";
	}
	
	public static function Booking_time_year_category($lang) {
		if ($lang == "Fr") {
			return "Nombre d'heures de réservation par catégories de ressources dans la période";
		}
		return "Time (in hours) of reservations for each resource category during the given period";
	}
	
	public static function Instructor($lang){
		if ($lang == "Fr") {
			return "Formateur";
		}
		return "Instructor";
	}
	
	public static function Instructor_status($lang){
		if ($lang == "Fr") {
			return "Statut du formateur";
		}
		return "Instructor status";
	}
	
	public static function Statistics_booking_users($lang){
		if ($lang == "Fr") {
			return "Utilisateurs ayant réservé";
		}
		return "Statistics booking users";
	}

}
