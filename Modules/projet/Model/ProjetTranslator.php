<?php

/**
 * Class to translate the syggrif views
 * 
 * @author sprigent
 *
 */
class ProjetTranslator {
//navbar
	public static function navbartitre($lang="")
	{
		if ($lang == "Fr"){
			return utf8_encode("SyGGRif Projet Neurinfo");
		}
		return "SyGRRif Neurinfo Project";
	}
	
	public static function ficheprojet($lang="")
	{
		if ($lang == "Fr"){
			return "La fiche de Projet";
		}
		return "Project Sheet";
	}
	public static function listeprojets($lang="")
	{
		if ($lang == "Fr"){
			return "La liste des projets";
		}
		return "Project List";
	}
	public static function Tarifs($lang="")
	{
		if ($lang == "Fr"){
			return "Tarifs";
		}
		return "Prices";
	}
	public static function ajoutertarif($lang="")
	{
		if ($lang == "Fr"){
			return "Ajouter un Tarif";
		}
		return "Add a price";
	}
	public static function user($lang="")
	{
		if ($lang == "Fr"){
			return "Utilisateur";
		}
		return "User";
	}
	public static function adduser($lang="")
	{
		if ($lang == "Fr"){
			return "Ajouter un Utilisateur";
		}
		return "Add a User";
	}
	public static function listetarif($lang="")
	{
		if ($lang == "Fr"){
			return "La Liste des Tarifs";
		}
		return "The Price List";
	}
	public static function listneur($lang="")
	{
		if ($lang == "Fr"){
			return "Tarifs Neurinfo";
		}
		return "Neurinfo Prices";
	}
	public static function listeuser($lang="")
	{
		if ($lang == "Fr"){
			return "La Liste des Utilisateurs";
		}
		return "Users List";
	}
	public static function userneur($lang="")
	{
		if ($lang == "Fr"){
			return "Utilisateur Neurinfo";
		}
		return "Neurinfo Users";
	}
	public static function rapport($lang="")
	{
		if ($lang == "Fr"){
			return "Rapport Neurinfo";
		}
		return "Neurinfo Report";
	}
	public static function stat($lang=""){
		if ($lang == "Fr"){
			return "Statistiques";
		}
		return "Statistics";
	}
	public static function statNI($lang=""){
		if ($lang == "Fr"){
			return "Statistiques Neurinfo";
		}
		return "Neurinfo Statistics";
	}
	public static function Neurrappot($lang="")
	{
		if ($lang == "Fr"){
			return utf8_encode("Rapport d'activité");
		}
		return "Activity Report";
	}
//search.php
	public static function montant($lang=""){
		if($lang=="Fr"){
			return "Montant";
		}
		return "Amount";
	}
	
	public static function Send($lang = ""){
		if ($lang == "Fr"){
			return "Envoyer";
		}
		return "Send";
	}
	
	//index.php pour rapport d'activité
	public static function Champs($lang){
		if ($lang == "Fr"){
			return "Champs Formulaire";
		}
		return "Form fiels";
	}
public static function chercher($lang){
		if ($lang == "Fr"){
			return "Lancer la recherche";
		}
		return "Start search";
	}
	public static function Projet_configuration($lang){
		if ($lang == "Fr"){
			return "Projet_configuration";
		}
		return "Configuration project";
	}
	
	public static function ProjetConfigAbstract($lang="")

	{ 
	if ($lang=="Fr")
	{
		return "Neurinfo" ;
	
	}
	return "Neurinfo";
		
	}
	public static function Name($lang="")

	{ 
		if ($lang=="Fr")
	{
		return "Nom" ;
	
	}
	return "Name";
		
	}
	//projet/index/formulaire
	
	public static function formulaireProjet($lang)
		{
			if($lang=="Fr")
			{
				return "Formulaire Projet";
			}
			return "Project Form";
		}
	public static function datedemande($lang)
		{
			if($lang=="Fr")
			{
				return "La Date de la demande";
			}
			return "Date of application";
		}
		public static function numerofiche($lang){
			if($lang=="Fr")
			{
				return utf8_encode("Numéro fiche");
			}
			return "Record number";
		}
	public static function numerovisite($lang){
			if($lang=="Fr")
			{
				return utf8_encode("Numéro de visite");
			}
			return "Visit number";
		}
		public static function type($lang)
		{
			if($lang=="Fr")
			{
				return "Type du Projet";
			}
			return "Project Type";
			
		}
		public static function pilote($lang){
			if($lang=="Fr")
			{
				return "Pilote";
			}
			return "Pilote";
		}
public static function methodo($lang){
			if($lang=="Fr")
			{
				return utf8_encode("Méthodologique") ;
			}
			return "Méthodologique";
		}
public static function rechercheclini($lang){
			if($lang=="Fr")
			{
				return utf8_encode("Recherche Clinique") ;
			}
			return "Recherche Clinique";
		}
public static function multicen($lang){
			if($lang=="Fr")
			{
				return utf8_encode("Multicentrique") ;
			}
			return "Multicentrique";
		}
	public static function ip($lang)
		{
			if($lang=="Fr")
			{
				return "Investigateur Principal";
			}
			return "Principal Investigator";
			
		}
	public static function prenom($lang)
		{
			
			if($lang=="Fr")
			{
				return utf8_encode("Prénom")  ;
			}
			return "FirstName";
			
		}
	public static function nom($lang)
		{
			if($lang=="Fr")
			{
				return "Nom";
			}
			return "LastName";
			
		}
	public static function fonction($lang)
		{
			if($lang=="Fr")
			{
				return "Fonction";
			}
			return "Office";
			
		}
	public static function mail($lang)
		{
			if($lang=="Fr")
			{
				return "Email";
			}
			return "E-mail";
			
		}
	public static function tel($lang)
		{
			if($lang=="Fr")
			{
				return utf8_encode ("Téléphone");
			}
			return "Phone Number";
			
		}
	public static function ia($lang)
		{
			if($lang=="Fr")
			{
				return utf8_encode("Investigateur associé");
			}
			return "Associate Investigator";
			
		}
		
	public static function coord($lang)
		{
			if($lang=="Fr")
			{
				return "Coordinateur";
			}
			return "Coordinator";
			
		}
	public static function prom($lang)
		{
			if($lang=="Fr")
			{
				return "Promoteur";
			}
			return "Sponsor";
			
		}
	public static function libelle($lang)
		{
			if($lang=="Fr")
			{
				return utf8_encode("Libellé");
			}
			return "Wording";
			
		}
		public static function cri($lang)
		{
			if($lang=="Fr")
			{
				return "Centre de relecture des images";
			}
			return "Images replay center";
			
		}
	public static function opg($lang)
		{
			if($lang=="Fr")
			{
				return utf8_encode("Organisme Partenaire Gestionnaire(sera renseigné par le comité de direction)");
			}
			return "Partner Manager Organisation (to be complete by the executive committee)";
			
		}
	public static function contactcores($lang)
		{
			if($lang=="Fr")
			{
				return utf8_encode("Coordonnés du correspondant)");
			}
			return "Corresponding Contact";
			
		}
		public static function arc($lang)
		{
			if($lang=="Fr")
			{
				return utf8_encode( "Attaché de recherche clinique");
			}
			return "Clinical Research associate";
			
		}
			public static function rsre($lang)
		{
			if($lang=="Fr")
			{
				return utf8_encode("Radiologue supervisant la réalisation des examens");
			}
			return "Supervising radiologist conducting the reviews";
			
		}
		public static function nomprenom($lang)
		{
			if($lang="Fr")
			{
				return utf8_encode(" Nom, Prénom");
			}
			return "Lastname, Firstname";
		}
		public static function cstn($lang)
		{
			if($lang="Fr")
			{
				return utf8_encode(" Correspondants scientifique et technique Neunrinfo (seront désigné par le comité de direction)");
			}
			return "Scientific and technical correspondents Neurinfo (Will be appointed by the Executive Committee) ";
		}
	public static function nomprenoms($lang)
		{
			if($lang="Fr")
			{
				return utf8_encode(" Nom et Prénom du correspondant scientifique ");
			}
			return "full name of science correspondent";
		}
	public static function nomprenomt($lang)
		{
			if($lang="Fr")
			{
				return utf8_encode("Nom et Prénom du correspondant technique");
			}
			return " Full name of the technical contact";
		}
		
		public static function cpp($lang)
		{
			if($lang="Fr")
			{
				return utf8_encode("CPP (Merci de fournir la note d'information et le formulaire de consentement.)");
			}
			return "CPP (Please provide the information notice and the consent form. ) ";
		}
		public static function descriptionetude($lang)
		{
			if($lang="Fr")
			{
				return utf8_encode("Description de l'étude");
			}
			return "Study Description";
		}
		
			public static function soumettre($lang)
			{
				if($lang="Fr")
				{
					return utf8_encode("A soumettre");
				}
				return "To Submit";
			} 
			public static function soumis($lang)
			{
				if($lang="Fr")
				{
					return utf8_encode("Soumis");
				}
				return "Submit";
			} 
			public static function accepte($lang)
			{
				if($lang="Fr")
				{
					return utf8_encode("Accepté");
				}
				return "Accepted";
			} 
				public static function cppnumero($lang)
			{
				if($lang="Fr")
				{
					return utf8_encode("CPP Numéro");
				}
				return "CPP number";
			} 
				public static function resume($lang)
			{
				if($lang="Fr")
				{
					return utf8_encode("Resumé");
				}
				return "summary";
			} 
				public static function objectif($lang)
			{
				if($lang="Fr")
				{
					return utf8_encode("Objectif");
				}
				return "Goal";
			} 
				public static function experimentation($lang)
			{
				if($lang="Fr")
				{
					return utf8_encode("Expérimentation");
				}
				return "Experimentation";
			} 
				public static function traitementdonnee($lang)
			{
				if($lang="Fr")
				{
					return utf8_encode("Traitement des données");
				}
				return "Data Processing";
			} 
			public static function resultatattendu($lang)
			{
				if($lang="Fr")
				{
					return utf8_encode("Résultats attendus");
				}
				return "Expected Results";
			} 
		
				public static function publicationenvisage($lang)
			{
				if($lang="Fr")
				{
					return utf8_encode("Publications envisagées");
				}
				return "Proposed publications";
			} 
				public static function motcle($lang)
			{
				if($lang="Fr")
				{
					return utf8_encode("Mots-clés");
				}
				return "Keywords";
			} 
			
			public static function perpn($lang)
			{
				if($lang="Fr")
				{
					return utf8_encode("Protocoles d'études à realiser sur la plateforme Neurinfo ");
				}
				return "Protocols studies to realize  on Neurinfo platform";
			} 
			
			
			public static function tnsp($lang)
			{
				if($lang="Fr")
				{
					return utf8_encode("Type et Nombre de sujets prévu ");
				}
				return "Type and number of subjects expected";
			} 
			
			public static function temoins($lang)
			{
				if($lang="Fr")
				{
					return utf8_encode("Témoins");
				}
				return "Witnesses";
			} 
			public static function patient($lang)
			{
				if($lang="Fr")
				{
					return utf8_encode("Patients");
				}
				return "Patients";
			} 
			public static function fantome($lang)
			{
				if($lang="Fr")
				{
					return utf8_encode("Fantôme");
				}
				return "Phantom";
			} 
		public static function responsablerecrutement($lang)
			{
				if($lang="Fr")
				{
					return utf8_encode("Responsable de recrutement");
				}
				return "Recruitement Manager";
			}
		public static function nombredexam($lang)
			{
				if($lang="Fr")
				{
					return utf8_encode("Nombre d'examens");
				}
				return "Number of exams";
			}
	public static function dureeexam($lang)
			{
				if($lang="Fr")
				{
					return utf8_encode("Durée d'examen");
				}
				return "Time per Exam";
			}
	public static function dureetotale($lang)
			{
				if($lang="Fr")
				{
					return utf8_encode("Durée totale");
				}
				return "Total Time";
			}
	public static function protocoleinjecte($lang)
			{
				if($lang="Fr")
				{
					return utf8_encode("Protocole injecté");
				}
				return "Injected Protocol";
			}
		public static function oui($lang)
			{
				if($lang="Fr")
				{
					return utf8_encode("Oui");
				}
				return "Yes";
			}
		public static function non($lang)
			{
				if($lang="Fr")
				{
					return utf8_encode("Non");
				}
				return "No";
			}
			
		public static function planificationprevisinnelle($lang)
			{
				if($lang="Fr")
				{
					return utf8_encode("Planification prévisionnelle");
				}
				return "Forward Planning";
			}
public static function informationcomplementaire($lang)
			{
				if($lang="Fr")
				{
					return utf8_encode("Informations Complémentaire");
				}
				return "Additional Information";
			}
			
			public static  function inpp($lang)
			{
				if($lan="Fr"){
					return utf8_encode("Intitulé Neurinfo pour la programmation");
				}
				return "Entitled Neurinfo for programming";
			}
	public static  function inppc($lang)
			{
				if($lan="Fr"){
					return utf8_encode("Intitulé Neurinfo pour la cotation");
				}
				return "Neurinfo entitled for the listing";
			}
	public static  function progcota($lang)
			{
				if($lan="Fr"){
					return utf8_encode("Programmation/cotation");
				}
				return "Entitled Neurinfo for programming";
			}

public static  function datedemarageprevu($lang)
			{
				if($lan="Fr"){
					return utf8_encode("Date de démarrage prévue");
				}
				return "Start date expected";
			}
public static  function dureeetudeprevu($lang)
			{
				if($lan="Fr"){
					return utf8_encode("Durée d'étude prévue");
				}
				return "Planned study duration";
			}
public static  function contraint($lang)
			{
				if($lan="Fr"){
					return utf8_encode("Contrainte d'horaires ou des dates");
				}
				return "Schedule constraints or dates";
			}
public static  function rhlme($lang)
			{
				if($lan="Fr"){
					return utf8_encode("Ressources humaines, logicielles et matérielles externes");
				}
				return "External Human, hardware and software resources";
			}
public static  function rhlmn($lang)
			{
				if($lan="Fr"){
					return utf8_encode("Ressources humaines, logicielles et matérielles Neurinfo");
				}
				return "Neurinfo human, hardware and software  resources";
			}
public static  function aedsm($lang)
			{
				if($lan="Fr"){
					return utf8_encode("Aide à l'exploitation des données, support méthodologique");
				}
				return "Operating assistance data , methodological support";
			}
public static  function gams($lang)
			{
				if($lan="Fr"){
					return utf8_encode("Gestion archivage mode de sauvegarde");
				}
				return "Mode backup archive management";
			}
public static  function pn($lang)
			{
				if($lan="Fr"){
					return utf8_encode("Plateforme Neurinfo");
				}
				return "Neurinfo Platform";
			}
public static  function aon($lang)
			{
				if($lan="Fr"){
					return utf8_encode("Adéquation aux objectifs de Neurinfo");
				}
				return "Adequacy for  Neurinfo's objectives ";
			}
public static  function csn($lang)
			{
				if($lan="Fr"){
					return utf8_encode("Caractère structurant pour Neurinfo");
				}
				return "Structuring for Neurinfo";
			}
			
			
			
			
		// Listeform.php
		public static function Listedesprojet($lang)
		{
			if($lang=="Fr")
			{
				return "Liste des projets";
			}
			return "List of projects";
		}
		public static function ID($lang)
		{
			if($lang=="Fr")
			{
				return "ID";
			}
			return "ID";
			
		}
		public static function titre($lang)
		{
			if($lang=="Fr")
			{
				return "Titre";
			}
			return "Tittle";
		}
		public static function Acronyme($lang)
		{
			if($lang=="Fr")
			{
				return "Acronyme";
			}
			return "Protocol";
		}

		public static function typeactivite($lang){
			if($lang=="Fr"){
				return utf8_encode("Type d'activité");
			}
			return "Activity type";
		} 
		public static function modifier($lang)
		{
			if($lang=="Fr")
			{
				return "Modifier";
			}
			return "Modify";
		}
		public static function afficher($lang)
		{
			if($lang=="Fr")
			{
				return "Afficher";
			}
			return "Display";
		}
		public static function generer($lang)
		{
			if($lang=="Fr")
			{
				return utf8_encode("Générer Document");
			}
			return "Generate Document";
		}
		public static function psfpf($lang){
			if($lang=="Fr")
			{
				return utf8_encode("Projets scientifiques-fiche pilote financé");
			}
			return "Projects Scientific - funded pilot plug";
		} 
		
		public static function psfpnf($lang){
			if($lang=="Fr")
			{
				return utf8_encode("Projets scientifiques-fiche pilote non financé");
			}
			return "Projects Scientific plug unfunded pilot";
			
		}
		
		public static function AC($lang){
			if($lang=="Fr")
			{
				return utf8_encode("Activité clinique");
			}
			return "Clinical activity";
			
		}
		public static function qualite($lang){
			if($lang=="Fr")
			{
				return utf8_encode("Qualité");
			}
			return "Quality";
			
		}
		
		//fin listform
		
	public static function enregistrer($lang)
	{
		if($lang=="Fr")
		{
			return "Enregistrer";
		}
		return "Record";
	}
	
	
	
	
}

