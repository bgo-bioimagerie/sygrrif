<?php

/**
 * Class to translate the syggrif views
 * 
 * @author sprigent
 *
 */
class PsTranslator {

    public static function Delete_Appartenance($lang) {
        if ($lang == "Fr") {
            return "Supprimer appartenance";
        }
        return "Delete appartenance";
    }

    public static function Delete_App_Warning($lang, $name) {
        if ($lang == "Fr") {
            return "Êtes-vous sûr de vouloir supprimer définitivement l'appartenance: " . $name . " ?" .
                    "<br> Attention: Cela supprimera uniquement l'appartenance de la base de données. Toute référence faite
				    à cet appartenance sera corrompu.";
        }
        return "Delete appartenance: " . $name . " ?" .
                "<br> Warning: This will remove the appartenance of the database. Any reference to this appartenance will be corrupted";
    }

    public static function PetShopAbstract($lang) {
        if ($lang == "Fr") {
            return "Base de données annimalerie";
        }
        return "Pet shop database";
    }

    public static function PetShop($lang) {
        if ($lang == "Fr") {
            return "Animalerie";
        }
        return "Pet shop";
    }

    public static function PetShopManagement($lang) {
        if ($lang == "Fr") {
            return "Gestion animalerie";
        }
        return "PetShop management";
    }

    public static function suppliers($lang) {
        if ($lang == "Fr") {
            return "Fournisseurs";
        }
        return "Suppliers";
    }

    public static function Edit_Supplier($lang) {
        if ($lang == "Fr") {
            return "Editer Fournisseur";
        }
        return "Edit Supplier";
    }

    public static function AnimalSpecies($lang) {
        if ($lang == "Fr") {
            return "Types animaux";
        }
        return "Animal species";
    }

    public static function Edit_Spice($lang) {
        if ($lang == "Fr") {
            return "Editer type d'animal";
        }
        return "Edit animal spice";
    }

    public static function Proceeding($lang) {
        if ($lang == "Fr") {
            return "Procédure";
        }
        return "Proceeding";
    }

    public static function Edit_Proceeding($lang) {
        if ($lang == "Fr") {
            return "Editer procédure";
        }
        return "Edit proceeding";
    }

    public static function SectorAndPricing($lang) {
        if ($lang == "Fr") {
            return "Secteurs & Tarifs";
        }
        return "Sector & Pricing";
    }

    public static function ExitReason($lang) {
        if ($lang == "Fr") {
            return "Motif de sortie";
        }
        return "Exit reason";
    }

    public static function EntryReason($lang) {
        if ($lang == "Fr") {
            return "Motif d'entrée";
        }
        return "Entry reason";
    }

    public static function AllProjects($lang) {
        if ($lang == "Fr") {
            return "Tous les projets";
        }
        return "All projects";
    }

    public static function Project($lang) {
        if ($lang == "Fr") {
            return "Projet";
        }
        return "Project";
    }

    public static function Projects($lang) {
        if ($lang == "Fr") {
            return "Projets";
        }
        return "Projects";
    }

    public static function CBEA($lang) {
        if ($lang == "Fr") {
            return "CBEA";
        }
        return "CBEA";
    }

    public static function HCD($lang) {
        if ($lang == "Fr") {
            return "HCD";
        }
        return "HCD";
    }

    public static function Mouse($lang) {
        if ($lang == "Fr") {
            return "Souris";
        }
        return "Mouse";
    }

    public static function Rat($lang) {
        if ($lang == "Fr") {
            return "Rat";
        }
        return "Rat";
    }

    public static function Animals($lang) {
        if ($lang == "Fr") {
            return "Animaux";
        }
        return "Animals";
    }

    public static function Export($lang) {
        if ($lang == "Fr") {
            return "Export";
        }
        return "Export";
    }

    public static function Invoicing($lang) {
        if ($lang == "Fr") {
            return "Facturer";
        }
        return "Invoice";
    }

    public static function PetShopConfiguration($lang) {
        if ($lang == "Fr") {
            return "Configuration animalerie";
        }
        return "Pet shop configuration";
    }

    public static function Install_Txt($lang) {
        if ($lang == "Fr") {
            return "Cliquer sur \"Installer\" pour installer ou réparer la base de donnée de Animalerie. 
					Cela crée les tables qui n'existent pas";
        }
        return "To repair the Pet shop mudule, click \"Install\". This will create the
				Core tables in the database if they don't exists ";
    }

    public static function Edit_sector($lang) {
        if ($lang == "Fr") {
            return "Editer secteur";
        }
        return "Edit sector";
    }

    public static function Pricing($lang) {
        if ($lang == "Fr") {
            return "Tarifs";
        }
        return "Pricing";
    }

    public static function Sector($lang) {
        if ($lang == "Fr") {
            return "Secteur";
        }
        return "Sector";
    }

    public static function Edit_exit_reason($lang) {
        if ($lang == "Fr") {
            return "Editer motif de sortie";
        }
        return "Edit exit reason";
    }

    public static function Edit_entry_reason($lang) {
        if ($lang == "Fr") {
            return "Editer motif d'entrée";
        }
        return "Edit entry reason";
    }

    public static function Date($lang) {
        if ($lang == "Fr") {
            return "Date";
        }
        return "Date";
    }

    public static function Number($lang) {
        if ($lang == "Fr") {
            return "Numéro";
        }
        return "Number";
    }

    public static function ProjectsTypes($lang) {
        if ($lang == "Fr") {
            return "Types de projet";
        }
        return "Projects Types";
    }

    public static function Edit_Project_Type($lang) {
        if ($lang == "Fr") {
            return "Editer type de projet";
        }
        return "Edit Project Type";
    }

    public static function who_can_see($lang) {
        if ($lang == "Fr") {
            return "Qui peut voir";
        }
        return "Who can see";
    }

    public static function Edit_Project($lang) {
        if ($lang == "Fr") {
            return "Editer projet";
        }
        return "Edit Project";
    }

    public static function Infos($lang) {
        if ($lang == "Fr") {
            return "Informations";
        }
        return "Informations";
    }

    public static function AddAnimals($lang) {
        if ($lang == "Fr") {
            return "ajouter animaux";
        }
        return "Add animals";
    }

    public static function AnimalsIn($lang) {
        if ($lang == "Fr") {
            return "Animaux présents";
        }
        return "Animals In";
    }

    public static function AnimalsOut($lang) {
        if ($lang == "Fr") {
            return "Animaux sortis";
        }
        return "Animals Out";
    }

    public static function kick_off($lang) {
        if ($lang == "Fr") {
            return "Envoi";
        }
        return "kick off";
    }

    public static function CommiteeMeeting($lang) {
        if ($lang == "Fr") {
            return "Rencontre comité";
        }
        return "Commitee meeting";
    }

    public static function AnimalsType($lang) {
        if ($lang == "Fr") {
            return "Type d'animal";
        }
        return "Animal type";
    }

    public static function Surgery($lang) {
        if ($lang == "Fr") {
            return "Chirurgie ?";
        }
        return "Surgery?";
    }

    public static function Reallaunching($lang) {
        if ($lang == "Fr") {
            return "Lancement réel";
        }
        return "Real launching";
    }

    public static function Stem_lineage($lang) {
        if ($lang == "Fr") {
            return "Souche / lignée";
        }
        return "Stem lineage";
    }

    public static function AnimalsNumber($lang) {
        if ($lang == "Fr") {
            return "Nbr animaux";
        }
        return "Animals number";
    }

    public static function Procedure($lang) {
        if ($lang == "Fr") {
            return "Procédures";
        }
        return "Procedures";
    }

    public static function ProcedureType($lang) {
        if ($lang == "Fr") {
            return "Type procédure";
        }
        return "Procedure type";
    }

    public static function ProjectType($lang) {
        if ($lang == "Fr") {
            return "Type projet";
        }
        return "Project type";
    }

    public static function Add_Animals($lang) {
        if ($lang == "Fr") {
            return "Ajouter animaux";
        }
        return "Add animals";
    }

    public static function NoAnimal($lang) {
        if ($lang == "Fr") {
            return "No animal";
        }
        return "No animal";
    }

    public static function NoRoom($lang) {
        if ($lang == "Fr") {
            return "No salle";
        }
        return "No room";
    }

    public static function DateEntry($lang) {
        if ($lang == "Fr") {
            return "Date entrée";
        }
        return "Date entry";
    }

    public static function Lineage($lang) {
        if ($lang == "Fr") {
            return "Lignée";
        }
        return "Lineage";
    }

    public static function BirthDate($lang) {
        if ($lang == "Fr") {
            return "Date de naissance";
        }
        return "Birth date";
    }

    public static function Father($lang) {
        if ($lang == "Fr") {
            return "Père";
        }
        return "Father";
    }

    public static function Mother($lang) {
        if ($lang == "Fr") {
            return "Mère";
        }
        return "Mother";
    }

    public static function Sexe($lang) {
        if ($lang == "Fr") {
            return "Sexe";
        }
        return "Sexe";
    }

    public static function Male($lang) {
        if ($lang == "Fr") {
            return "Male";
        }
        return "Male";
    }

    public static function female($lang) {
        if ($lang == "Fr") {
            return "Femelle";
        }
        return "Female";
    }

    public static function Genotype($lang) {
        if ($lang == "Fr") {
            return "Génotypage";
        }
        return "Genotype";
    }

    public static function Supplier($lang) {
        if ($lang == "Fr") {
            return "Fournisseur";
        }
        return "Supplier";
    }

    public static function Collaboration($lang) {
        if ($lang == "Fr") {
            return "Collaboration";
        }
        return "Collaboration";
    }

    public static function Num_bon($lang) {
        if ($lang == "Fr") {
            return "Num bon";
        }
        return "No order";
    }

    public static function Observation($lang) {
        if ($lang == "Fr") {
            return "Observation";
        }
        return "Observation";
    }

    public static function ExitAnimal($lang) {
        if ($lang == "Fr") {
            return "Sortir animaux";
        }
        return "Exit animals";
    }

    public static function ExitDate($lang) {
        if ($lang == "Fr") {
            return "Date de sortie";
        }
        return "Exit date";
    }

    public static function InformationsAnimal($lang) {
        if ($lang == "Fr") {
            return "Informations animal";
        }
        return "Animal informations";
    }

    public static function Avertissement($lang) {
        if ($lang == "Fr") {
            return "Avertissement";
        }
        return "Warning";
    }

    public static function AnimalModificationSaved($lang) {
        if ($lang == "Fr") {
            return "Les modifications de l'animal on été sauvegardées";
        }
        return "Modifications of animals have been saved";
    }

    public static function AddSector($lang) {
        if ($lang == "Fr") {
            return "Ajouter secteur";
        }
        return "Add sector";
    }

    public static function RemoveSector($lang) {
        if ($lang == "Fr") {
            return "Enlever secteur";
        }
        return "Remove sector";
    }

    public static function Listing($lang) {
        if ($lang == "Fr") {
            return "Liste animaux";
        }
        return "Listing";
    }

    public static function ConfirmDeleteAnimal($lang) {
        if ($lang == "Fr") {
            return "Etes vous certain de vouloir suprimer l'animal ";
        }
        return "Are you sure you want to delete the animal ";
    }
    
    public static function BeginingPeriod($lang) {
        if ($lang == "Fr") {
            return "Début période";
        }
        return "Begining period";
    }
    
    public static function EndPeriod($lang) {
        if ($lang == "Fr") {
            return "Fin période";
        }
        return "End period";
    }
    
    public static function DateClosed($lang) {
        if ($lang == "Fr") {
            return "Date de cloture";
        }
        return "Date closed";
    }
    
    public static function hostedAnimalsFrom($lang) {
        if ($lang == "Fr") {
            return "Animaux hébergés du ";
        }
        return "Hosted animals from ";
    }
    
    public static function to($lang) {
        if ($lang == "Fr") {
            return " au ";
        }
        return " to ";
    }
    
    public static function NumberOfDay($lang) {
        if ($lang == "Fr") {
            return "Nombre de jours";
        }
        return "Number of day";
    }
    
    public static function UnitaryPrice($lang) {
        if ($lang == "Fr") {
            return "Tarif unitaire";
        }
        return "Unitary price";
    }
    
    public static function Total($lang) {
        if ($lang == "Fr") {
            return "Total";
        }
        return "Total";
    }
    
    public static function InvoicingAll($lang) {
        if ($lang == "Fr") {
            return "Facturer tous";
        }
        return "Invoice all";
    }
    
    public static function InvoicingHistory($lang) {
        if ($lang == "Fr") {
            return "Historique de facturation";
        }
        return "Invoicing history";
    }
    
    public static function NewProject($lang) {
        if ($lang == "Fr") {
            return "Nouveau projet";
        }
        return "New project";
    }
    
    public static function Closed($lang) {
        if ($lang == "Fr") {
            return "Clos";
        }
        return "Closed";
    }
    
    public static function Yes($lang) {
        if ($lang == "Fr") {
            return "Oui";
        }
        return "Yes";
    }
    
    public static function No($lang) {
        if ($lang == "Fr") {
            return "Non";
        }
        return "No";
    }
    
    public static function Date_Generated($lang) {
        if ($lang == "Fr") {
            return "Date d'émission";
        }
        return "Date generated";
    }
    
    public static function TotalHT($lang) {
        if ($lang == "Fr") {
            return "Total HT";
        }
        return "Total";
    }
    
    public static function Date_Paid($lang) {
        if ($lang == "Fr") {
            return "Réglée le";
        }
        return "Date paid";
    }
    
    public static function Is_Paid($lang) {
        if ($lang == "Fr") {
            return "Est réglée";
        }
        return "Is paid";
    }
    
    public static function Edit_invoice($lang) {
        if ($lang == "Fr") {
            return "Editer facture";
        }
        return "Edit invoice";
    }
    
    public static function Download($lang) {
        if ($lang == "Fr") {
            return "Télécharger";
        }
        return "Download";
    }
    
    
}
