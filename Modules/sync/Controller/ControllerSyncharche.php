<?php

require_once 'Framework/Controller.php';
require_once 'Modules/sygrrif/Model/SyVisa.php';
require_once 'Modules/sygrrif/Model/SyPricing.php';
require_once 'Modules/core/Model/CoreUnit.php';
require_once 'Modules/core/Model/CoreUser.php';
require_once 'Modules/core/Model/CoreResponsible.php';
require_once 'Modules/sygrrif/Model/SyResourcesCategory.php';
require_once 'Modules/sygrrif/Model/SyAuthorization.php';
require_once 'Modules/sygrrif/Model/SyCalendarEntry.php';
require_once 'Modules/sygrrif/Model/SyArea.php';
require_once 'Modules/sygrrif/Model/SyResource.php';
//require_once 'Modules/sygrrif/Model/SyResourcesCategory.php';
require_once 'Modules/sygrrif/Model/SyCalendarEntry.php';
require_once 'Modules/sygrrif/Model/SyResourceCalendar.php';
require_once 'Modules/sygrrif/Model/SyResourcePricing.php';
require_once 'Modules/sygrrif/Model/SyColorCode.php';
require_once 'Modules/core/Model/CoreInitDatabase.php';
require_once 'Modules/sygrrif/Model/SyInstall.php';

require_once 'Modules/petshop/Model/PsSupplier.php';
require_once 'Modules/petshop/Model/PsInitDatabase.php';
require_once 'Modules/petshop/Model/PsProceedings.php';
require_once 'Modules/petshop/Model/PsSector.php';
require_once 'Modules/petshop/Model/PsType.php';
require_once 'Modules/petshop/Model/PsEntryReason.php';
require_once 'Modules/petshop/Model/PsExitReason.php';
require_once 'Modules/petshop/Model/PsProject.php';
require_once 'Modules/petshop/Model/PsAnimal.php';

class ControllerSyncharche extends Controller {

    public function __construct() {
        
    }
    
    public function index(){
        
        //$this->importGRR();
        $this->importAnimals();
    }

    public function importAnimals(){
        $dsn_grr = 'mysql:host=localhost;dbname=arche_old;charset=utf8';
        $login_grr = "root";
        $pwd_grr = "";

        $pdo_arche = new PDO($dsn_grr, $login_grr, $pwd_grr, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

        // Create petshop database
        echo "arche<br/>";
        $installModel = new CoreInitDatabase();
        $installModel->createDatabase();
        $modelDatabase = new PsInitDatabase();
        $modelDatabase->createDatabase();
        echo "arche database created <br/>";
        
        // import arche users
        $this->importArcheUsers($pdo_arche);
        echo "arche users added <br/>";
        
        // import equipe to unit
        $this->importArcheUnits($pdo_arche);
        echo "arche unit added <br/>";
        
        $this->importFournisseurs($pdo_arche);
        echo "arche suppliers added <br/>";
        
        $this->importProceedings($pdo_arche);
        echo "arche proceedings added <br/>";
        
        $this->importSectors($pdo_arche);
        echo "arche sectors added <br/>";
        
        $this->importType($pdo_arche);
        echo "arche type added <br/>";
        
        $this->createProjectsTypes();
        echo "arche projects types added <br/>";
        
        $this->addEntryReason($pdo_arche);
        echo "arche entry reasons added <br/>";
        
        $this->addExitReason($pdo_arche);
        echo "arche exit reasons added <br/>";
        
        $this->addPricingsArche();
        echo "arche pricing added <br/>";
        
        $this->addProjects($pdo_arche);
        echo "arche projects added <br/>";
        
        $this->addAnimals($pdo_arche);
        echo "arche animals added <br/>";
        
        $this->addHistory($pdo_arche);
        echo "arche history added <br/>";
        echo "done <br/>";
    
    }
    
    public function addHistory($pdo_arche){
        $sql = "SELECT * FROM an_historique";
	$req = $pdo_arche->query($sql);
	$datas = $req->fetchAll();
        
        $model = new PsAnimal();
        foreach($datas as $data){
            
            $id = $data["num_souris"]; 
            $sector = $data["secteur"];
            $date_entry_sect = $data["date_entree"];
            $date_exit_sect = $data["date_sortie"];
            $unit_hist = $data["equipe"];
            $no_room = "";
            $model->addhistory($id, $sector, $date_entry_sect, $date_exit_sect, $unit_hist, $no_room);
        }
    }
    
    public function addAnimals($pdo_arche){
        $sql = "SELECT * FROM an_animals";
	$req = $pdo_arche->query($sql);
	$datas = $req->fetchAll();
        
        $model = new PsAnimal();
        $modelEntryReason = new PsEntryReason();
        $modelExitReason = new PsExitReason();
        foreach($datas as $data){
            
            $id = $data["id"];
            $id_project = $data["projet"];
            $no_animals = $data["num_souris"];
            $type_animal = $data["type_animal"];
            $date_entry = $data["date_entree"];
            $entry_reason = $modelEntryReason->getId($data["motif_entree"]);
            $lineage = $data["Lignee"];
            $birth_date = $data["date_naissance"];
            $father = $data["pere"];
            $mother = $data["mere"];
            $sexe = $data["sexe"];
            $genotypage = $data["genotypage"];
            $supplier = $data["fournisseur"];
            $collaboration = $data["collaboration"];
            $num_bon = $data["num_bon"];
            $user1 = $data["user1"];
            $user2 = $data["user2"];
            $observation = $data["observation"];
            $avertissement = $data["avertissement"];
            $date_sortie = $data["date_sortie"];
            $raison_sortie = $modelExitReason->getId($data["raison_sortie"]);
            $model->import($id, $id_project, $no_animals, $type_animal, $date_entry, 
                    $entry_reason, $lineage, $birth_date, $father, $mother, $sexe, 
                    $genotypage, $supplier, $collaboration, $num_bon, $user1, $user2, 
                    $observation, $avertissement, $date_sortie, $raison_sortie);
                    
        }
    }
    
    public function addProjects($pdo_arche){
        
        $sql = "SELECT * FROM an_projet";
	$req = $pdo_arche->query($sql);
	$datas = $req->fetchAll();
        
        $model = new PsProject();
        foreach($datas as $data){
            $id = $data["id-projet"];
            $name = $data["nom_projet"];
            $no_projet = $data["no_projet"];
            $id_unit = $data["equipe"];
            $id_responsible = 1;
            $user1 = $data["user1"];
            $user2 = $data["user2"];
            $date_envoi = $data["date_envoi"];
            $date_rencontre_commite = $data["date_rencontre_commite"];
            $type_animal = $data["type_animal"]; 
            $souche_lignee = $data["souche_lignee"];
            $nbr_animaux = $data["nbr_animaux"];
            $nbr_procedures = $data["nbr_procedures"];
            $type_procedure = $data["type_procedure"]; //
            if ($data["chirurgie"] == "oui"){
                $chirurgie = 1;
            }
            else{
                $chirurgie = 0;
            }
            if ($data["cbea"] == "oui"){
                $type_project = 2;
            }
            else if ($data["cbea"] == "HCD"){
                $type_project = "3";
            }
            else{
                $type_project = "1";
            }
            
            $date_reel_lancement = $data["date_reel_lancement"];
            $date_closed = "";
            $model->import($id, $name, $no_projet, $id_unit, $id_responsible, $user1, $user2, $date_envoi, $date_rencontre_commite, $type_animal, $souche_lignee, $nbr_animaux, $nbr_procedures, $type_procedure, $chirurgie, $type_project, $date_reel_lancement, $date_closed);
        }
    }
    
    public function addPricingsArche(){
        // do nothing entered by hand
    }

    public function addEntryReason($pdo_arche){
        $sql = "SELECT DISTINCT motif_entree FROM an_animals";
	$req = $pdo_arche->query($sql);
	$datas = $req->fetchAll();
        
        $model = new PsEntryReason();
        foreach($datas as $data){
            $model->add($data[0]);
        }
    }
    
    public function addExitReason($pdo_arche){
        $sql = "SELECT DISTINCT raison_sortie FROM an_animals";
	$req = $pdo_arche->query($sql);
	$datas = $req->fetchAll();
        
        $model = new PsExitReason();
        foreach($datas as $data){
            $model->add($data[0]);
        }
    }
    
    public function createProjectsTypes(){
        $model = new PsProjectType();
        $model->add("CBEA", 1);
        $model->add("HCD", 1);
    }
    
    public function importType($pdo_arche){
        $sql = "select * from an_type";
	$req = $pdo_arche->query($sql);
	$datas = $req->fetchAll();
        
        $model = new PsType();
        foreach($datas as $data){
            $model->import($data["id"], $data["name"]);
        }
    }
    
    public function importSectors($pdo_arche){
        $sql = "select * from an_secteur";
	$req = $pdo_arche->query($sql);
	$datas = $req->fetchAll();
        
        $model = new PsSector();
        foreach($datas as $data){
            $model->import($data["id"], $data["libelle_secteur"]);
        }
    }
    
    public function importFournisseurs($pdo_arche){
        $sql = "select * from an_fournisseur";
	$req = $pdo_arche->query($sql);
	$fournisseurs = $req->fetchAll();
        
        $modelSupplier = new PsSupplier();
        foreach($fournisseurs as $fourn){
            $modelSupplier->import($fourn["id"], $fourn["nom_fournisseur"], $fourn["adress_fournisseur"]);
            // id nom_fournisseur adress_fournisseur
        }
    }
    
    public function importProceedings($pdo_arche){
        $sql = "select * from an_procedure";
	$req = $pdo_arche->query($sql);
	$proceedings = $req->fetchAll();
        
        $model = new PsProceedings();
        foreach($proceedings as $pr){
            $model->import($pr["id"], $pr["name"]);
        }
    }
    
    public function importArcheUnits($pdo_arche){
        $sql = "SELECT * FROM an_equipe;";
	$pdoequipe = $pdo_arche->query($sql);
	$equipes = $pdoequipe->fetchAll();
        
        echo "coucou <br/>";
        $modelUnit = new CoreUnit();
        foreach($equipes as $equipe){
            /*
            $sql = "SELECT appartenance FROM core_units WHERE id=?";
            echo "unit id = " . intval($equipe["unit"]) . "<br/>";
            $id_appartenance = $pdo_arche->query($sql, array(intval($equipe["unit"])))->fetch();
            echo "id_appartenance = " . $id_appartenance . "<br/>";
            $id_appartenance = $id_appartenance[0];
            $id_app = 1;
            if ($id_appartenance == 1){
                $id_app = 2;
            }
            if ($id_appartenance == 2){
                $id_app = 3;
            }
            if ($id_appartenance == 3){
                $id_app = 4;
            }if ($id_appartenance == 6){
                $id_app = 5;
            }
             */
            
            $modelUnit->importUnit($equipe["id"], $equipe["name"], "", 1);
        }
        
    }
    
    public function importArcheUsers($pdo_arche){
        	// get all users from old db
		$sql = "select * from grr_utilisateurs";
		$users_oldq = $pdo_grr->query($sql);
		$users_old = $users_oldq->fetchAll();
		
		$userModel = new CoreUser();
		$unitModel = new CoreUnit();
		foreach ($users_old as  $uo){	
			$name = $uo['nom'];
			$firstname = $uo['prenom']; 
			$login = $uo['login']; 
			$pwd = $uo['password'];
			$email = $uo['email']; 
			$phone = $uo['telephone'];
			
			$id_unit = $unitModel->getUnitId($uo['equipe']);
			
			$id_responsible = array(1);
			
			$is_active = 1;
			if ($uo['etat'] == "inactif"){
				$is_active = 0;
			}
			
			$id_status = 2;
			if($uo['statut'] == "administrateur"){
				$id_status = 4;
			}
			$convention = 0;
			$date_fin_contrat = '';
			
			$date_convention = "0000-00-00";
                        
                        $userModel->setUserMd5($name , $firstname , $login , $pwd , 
		           			$email , $phone , $id_unit , 
		           			$id_responsible , $id_status ,
    						$convention , $date_convention , 
					        $date_fin_contrat , $is_active

        );
		}
    }
    
    // affiche la liste des Sources
    public function importGRR() {

        // connect to h2p2 grr 
        $dsn_grr = 'mysql:host=localhost;dbname=sygrrif_arche;charset=utf8';
        $login_grr = "root";
        $pwd_grr = "root";

        $pdo_grr = new PDO($dsn_grr, $login_grr, $pwd_grr, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));


        // install data  base


        $sygrrifInstall = new SyInstall();
        $sygrrifInstall->createDatabase();

        // Equipes
        $this->syncUnits($pdo_grr);
        echo "<p>add equipes</p>";

        // Users
        $this->addUsers($pdo_grr);
        echo "<p>add users</p>";

        // calendar entry types
        $this->syncEntryTypes($pdo_grr);
        echo "<p>add entry types</p>";

        // add area
        $this->syncAreas($pdo_grr);
        echo "<p>add areas</p>";

        // add resources
        $this->syncResources($pdo_grr);
        echo "<p>add resources</p>";

        // add calendar entries
        $this->syncCalendarEntry($pdo_grr);
        echo "<p>add Calendar Entries</p>";

        // last login
        //$this->syncLastLogin($pdo_grr);
        //echo "<p>add Last login</p>";
        // prices
        // add Tarifs
        $this->addPricings();
        echo "<p>add prices done</p>";

        $this->syncPrices($pdo_grr);
        echo "<p>sync prices done</p>";

        //$this->addlinkUnitPricing($pdo_grr);
        //echo "<p>sync unit prices done</p>";

        $this->syncResourceCategories($pdo_grr);
        echo "<p>sync resource categories</p>";

        // authorisations
        //$this->syncAuthorisations($pdo_grr);
        //echo "<p>sync authorizations</p>";

        $this->changeUnitName($pdo_grr);
        echo "<p>sync unit name</p>";
    }

    // /////////////////////////////////////////// //
    // internal functions
    // /////////////////////////////////////////// //
    protected function getSygrrifArcheUnits(){
        
        $units[] = array(1 => "arche", 2 => "ARCHE", 3=> "Bât. 8 
            Campus santé de Villejean
            Université de Rennes 1
            2 avenue du Pr. Léon Bernard
            35043 RENNES Cedex
            France");
        
        $units[] = array(1 => "fonction__structure_et_inactivation_des_acides_ribonucleiques_bacteriens", 2 =>  "Fonction, structure et inactivation des acides ribonucléiques bactériens", 3=>  "U835");

        $units[] = array(1 => "fet_et_foie", 2 =>  "Fet et Foie", 3=>  "U991");

        $units[] = array(1 => "remodelage_du_micro-environnement_dans_le_cancer_du_foie", 2 =>  "Remodelage du micro-environnement dans le cancer du foie" , 3=> "U991");

        $units[] = array(1 => "hepatotoxicite_des_xenobiotiques", 2 =>  "Hépatotoxicité des xénobiotiques", 3=>  "U991");

        $units[] = array(1 => "stress__defenses_et_regeneration", 2 =>  "Stress, défenses et régénération", 3=>  "U991");

        $units[] = array(1 => "stress__membranes_et_signalisation", 2 =>  "Stress, Membranes et Signalisation", 3=>  "U1085-IRSET");

        $units[] = array(1 => "environnement_chimique__immunite_et_inflammation", 2 =>  "Environnement chimique, Immunité et Inflammation", 3=>  "U1085-IRSET");

        $units[] = array(1 => "agents_infectieux_hepatotropes_et_co-facteurs_environnementaux", 2 =>  "Agents infectieux hépatotropes et co-facteurs environnementaux" , 3=> "U1085-IRSET");

        $units[] = array(1 => "signalisation_et_modelisation_de_la_fibrose_hepatique", 2 =>  "Signalisation et modélisation de la fibrose hépatique", 3=>  "U1085-IRSET");

        $units[] = array(1 => "recherches_epidemiologiques_sur_l_environnement__la_reproduction_et_le_developpement", 2 =>  "Recherches épidémiologiques sur l'environnement, la reproduction et le développement" , 3=> "U1085-IRSET");

        $units[] = array(1 => "cancer_du_rein_:_bases_moleculaires_de_la_tumorogenese", 2 =>  "Cancer du rein : bases moléculaires de la tumorogenèse", 3=>  "UMR6290-IGDR");

        $units[] = array(1 => "genetique_des_pathologies_liees_au_developpement", 2 =>  "Génétique des pathologies liées au développement", 3=>  "UMR6290-IGDR");

        $units[] = array(1 => "expression_des_genes_et_oncogenese", 2 =>  "Expression des gènes et oncogenèse", 3=>  "UMR6290-IGDR");

        $units[] = array(1 => "signalisation_dans_l_ovocyte_et_l_embryon_de_souris", 2 =>  "Signalisation dans l'ovocyte et l'embryon de souris", 3=>  "UMR6290-IGDR");

        $units[] = array(1 => "expression_genetique_du_developpement", 2 =>  "Expression génétique du développement", 3=>  "UMR6290-IGDR");

        $units[] = array(1 => "micro_environnement_et_cancer_mica", 2 =>  "Micro environnement et Cancer MiCa", 3=>  "U917");

        $units[] = array(1 => "adnc_alimentation_adaptations_digestives__nerveuses_et_comportementales", 2 =>  "ADNC Alimentation Adaptations Digestives, Nerveuses et Comportementales", 3=>  "UR1341 INRA Saint Gilles");

        $units[] = array(1 => "lnprm", 2 =>  "LNPRM", 3=>  "Établissement Français du Sang");

        $units[] = array(1 => "laboratoire_de_pharmacologie_experimentale", 2 =>  "Laboratoire de Pharmacologie expérimentale" , 3=> "CIC INSERM 1414");

        $units[] = array(1 => "oss__equipe_ligue_contre_le_cancer", 2 =>  "OSS, Equipe Ligue Contre Le Cancer", 3=>  "ER440 - INSERM - Centre Eugène Marquis");

        $units[] = array(1 => "biotrial", 2 =>  "BIOTRIAL", 3=>  "Biotrial");

        $units[] = array(1 => "genetique_du_chien", 2 =>  "Génétique du Chien", 3=>  "UMR 6290 -IGDR" );	

        $units[] = array(1 => "labcom", 2 =>  "LABCOM" , 3=> 	"Biosit/Biotrial" );   
           
        return $units;
    }
    
    protected function syncUnits($pdo_grr) {

        $units_old = $this->getSygrrifArcheUnits();
    
        $unitModel = new CoreUnit();
	foreach ($units_old as  $unit){
            $unitModel->addUnit($unit[ 1], $unit[3], 1);
		}
	}
	
	protected function addUsers($pdo_grr){
		// get all users from old db
		$sql = "select * from grr_utilisateurs";
		$users_oldq = $pdo_grr->query($sql);
		$users_old = $users_oldq->fetchAll();
		
		$userModel = new CoreUser();
		$unitModel = new CoreUnit();
		foreach ($users_old as  $uo){	
			$name = $uo['nom'];
			$firstname = $uo['prenom']; 
			$login = $uo['login']; 
			$pwd = $uo['password'];
			$email = $uo['email']; 
			$phone = $uo['telephone'];
			
			$id_unit = $unitModel->getUnitId($uo['equipe']);
			
			$id_responsible = array(1);
			
			$is_active = 1;
			if ($uo['etat'] == "inactif"){
				$is_active = 0;
			}
			
			$id_status = 2;
			if($uo['statut'] == "administrateur"){
				$id_status = 4;
			}
			$convention = 0;
			$date_fin_contrat = '';
			
			$date_convention = "0000-00-00";
                        
                        $userModel->setUserMd5($name , $firstname , $login , $pwd , 
		           			$email , $phone , $id_unit , 
		           			$id_responsible , $id_status ,
    						$convention , $date_convention , 
					        $date_fin_contrat , $is_active

        );
		}	
	}
	
	public function syncEntryTypes($pdo_grr){
	
		$tab_couleur[1] = "FFCCFF"; # mauve pâle
		$tab_couleur[2] = "99CCCC"; # bleu
		$tab_couleur[3] = "FF9999"; # rose pâle
		$tab_couleur[4] = "FFFF99"; # jaune pâle
		$tab_couleur[5] = "C0E0FF"; # bleu-vert
		$tab_couleur[6] = "FFCC99"; # pêche
		$tab_couleur[7] = "FF6666"; # rouge
		$tab_couleur[8] = "66FFFF"; # bleu "aqua"
		$tab_couleur[9] = "DDFFDD"; # vert clair
		$tab_couleur[10] = "CCCCCC"; # gris
		$tab_couleur[11] = "7EFF7E"; # vert pâle
		$tab_couleur[12] = "8000FF"; # violet
		$tab_couleur[13] = "FFFF00"; # jaune
		$tab_couleur[14] = "FF00DE"; # rose
		$tab_couleur[15] = "00FF00"; # vert
		$tab_couleur[16] = "FF8000"; # orange
		$tab_couleur[17] = "DEDEDE"; # gris clair
		$tab_couleur[18] = "C000FF"; # Mauve
		$tab_couleur[19] = "FF0000"; # rouge vif
		$tab_couleur[20] = "FFFFFF"; # blanc
		$tab_couleur[21] = "A0A000"; # Olive verte
		$tab_couleur[22] = "DAA520"; # marron goldenrod
		$tab_couleur[23] = "40E0D0"; # turquoise
		$tab_couleur[24] = "FA8072"; # saumon
		$tab_couleur[25] = "4169E1"; # bleu royal
		$tab_couleur[26] = "6A5ACD"; # bleu ardoise
		$tab_couleur[27] = "AA5050"; # bordeaux
		$tab_couleur[28] = "FFBB20"; # pêche
	
		$sql = "select * from grr_type_area";
		$type_oldq = $pdo_grr->query($sql);
		$type_old = $type_oldq->fetchAll();
	
		$model = new SyColorCode();
		foreach ($type_old as  $typeo){
	
			$id = $typeo["id"];
			$name = $typeo["type_name"];
			$color = $tab_couleur[$typeo["couleur"]];
			$model->importColorCode($id , $name , "#".$color

        );
		}
	}
	
	public function syncAreas($pdo_grr){
		$sql = "select * from grr_area";
		$entry_oldq = $pdo_grr->query($sql);
		$entry_old = $entry_oldq->fetchAll();
		
		$modelArea = new SyArea();
		foreach ($entry_old as  $area){
			
			$id = $area["id"];
			$name = $area["area_name"];;
			$display_order = $area["order_display"];
			$restricted = 0;
			
			$modelArea->importArea($id , $name , $display_order , $restricted

        );	
		}
	}

	public function syncResources($pdo_grr){
		$sql = "select * from grr_room";
		$entry_oldq = $pdo_grr->query($sql);
		$entry_old = $entry_oldq->fetchAll();
	
		$modelArea = new SyArea();
		$modelResource = new SyResource();
                $modelResourceCategory = new SyResourcesCategory(); 
		$modelResourceCal = new SyResourceCalendar();
	
                $idCategory = 0;
		foreach ($entry_old as  $room){
				
			$area_id = $room['area_id'];
			// get the area name
			$sql = "select * from grr_area where id = ".$area_id."";
			$entry_oldq = $pdo_grr->query($sql);
			$area_info = $entry_oldq->fetch();
				
			$area_name = $area_info["area_name"];
			// get the area sygrrif id
			$area_id = $modelArea->getAreaFromName($area_name);
			// add the resource
			$id = $room["id"];
			$name = $room["room_name"];
			$description = $room["description"];
			$accessibility_id = 2; // who can book = authorized users
			$type_id = 1; // calendar
			$idCategory = $id;
                        //$modelResourceCategory->addResourcesCategory($name);
                        //$idCategory++;
                        //$modelResourceCategory->editResourcesCategory($id , $name);
			$modelResource->importResource($id , $name , $description , $accessibility_id , $type_id , $area_id , $idCategory);
				
			$nb_people_max = $room["capacity"];
			$arr1 = str_split($area_info["display_days"]);
			for ($t = 0 ;  $t < count($arr1) ;  $t++){
				if ($arr1[$t] == "y") {
            $arr1[$t] = 1;
        }
				if ($arr1[$t] == "n") {
            $arr1[$t] = 0;
        }
			}
			$available_days = $arr1[1] . ", " . $arr1[2] . ", " . $arr1[3] . ", "
					. $arr1[4] . ", " . $arr1[5] . ", " . $arr1[6] . ", " . $arr1[0] ;
			$day_begin = $area_info["morningstarts_area"];
			$day_end = $area_info["eveningends_area"];
			$size_bloc_resa = $area_info["resolution_area"];
			$modelResourceCal->setResource($id , $nb_people_max , $available_days , $day_begin , $day_end , $size_bloc_resa 

        , 0);
		}
	}
	
	public function syncCalendarEntry($pdo_old){
		// get all authorizations from old db
		$sql = "select * from grr_entry";
		$entry_oldq = $pdo_old->query($sql);
		$entry_old = $entry_oldq->fetchAll();
	
		$modelUser = new CoreUser();
		$modelCalEntry = new SyCalendarEntry();
		foreach ($entry_old as  $entry){
			// get the recipient ID
			$recipientID = $modelUser->userIdFromLogin($entry['beneficiaire']);
				
			// get the creator ID
			$creatorID = $modelUser->userIdFromLogin($entry['create_by']);
				
			// get the color id
			$type = $entry['type'];
			$sql = "select id from grr_type_area where type_letter = '".$type."'";
			//echo "sql = " . $sql ."</br>";
			$req = $pdo_old->query($sql);
			$color_type_id = $req->fetch()[0];
				
			if (!$color_type_id){
				$color_type_id = 1; // autres
			}

			// add the reservation
			$start_time = $entry['start_time'];
			$end_time = $entry['end_time'];
			$resource_id = $entry['room_id'];
			$booked_by_id = $creatorID;
			$recipient_id = $recipientID;
			$last_update = $entry['timestamp'];
			$color_type_id = $color_type_id;
			$short_description = $entry['description'];
			$full_description = "";
			//$modelCalEntry->addEntry($start_time, $end_time, $resource_id, $booked_by_id, $recipient_id, $last_update, $color_type_id, $short_description, $full_description);
			$modelCalEntry->setEntry($entry["id"] , $start_time , $end_time , $resource_id , $booked_by_id , $recipient_id , $last_update , $color_type_id , $short_description , $full_description

        );
		}
	}
	
	public function syncLastLogin($pdo_grr){
		$sql = "select * from grr_entry";
		$entry_oldq = $pdo_grr->query($sql);
		$entry_old = $entry_oldq->fetchAll();
	
		$modelUser = new CoreUser();
		$modelCalEntry = new SyCalendarEntry();
		foreach ($entry_old as  $entry){
			// get the recipient ID
			$recipientID = $modelUser->userIdFromLogin($entry['beneficiaire']);
			$date_last_login = $modelUser->getLastConnection($recipientID);
				
			$end_time = $entry['end_time'];
			$end_time = date("Y-m-d" , $end_time);
				
			if ($end_time > $date_last_login){
				$modelUser->setLastConnection($recipientID , $end_time

        );
			}
		}
	}
	
	
	public function addPricings(){

                $modelBelonging = new CoreBelonging();
                $modelBelonging->add("Biosit", "#ffffff", 1);
                $modelBelonging->add("UR1", "#ffffff", 1);
                $modelBelonging->add("Public", "#ffffff", 1);
                $modelBelonging->add("Privé", "#ffffff", 1);
            
		$modelPricing = new SyPricing();
		$modelPricing->addPricing("Biosit", 0, 1, 18, 8, 1, "0, 0, 0, 0, 0,1, 1");
		$modelPricing->addPricing("UR1", 0, 1, 18, 8, 1, "0, 0, 0, 0, 0,1, 1");
		$modelPricing->addPricing("Public", 0, 1, 18, 8, 1, "0, 0, 0, 0, 0,1, 1");
		$modelPricing->addPricing("Privé", 0, 1, 18, 8, 1, "0, 0, 0, 0, 0, 1, 1");
                //$modelPricing->addPricing($id, $tarif_unique, $tarif_nuit, $night_start, $night_end, $tarif_we, $we_char)
	} 
	
	public function syncPrices($pdo_grr){
		$sql = "select * from grr_room";
		$entry_oldq = $pdo_grr->query($sql);
		$entry_old = $entry_oldq->fetchAll();
	
		$modelRes = new SyResource();
		$modelPricing = new SyResourcePricing();
		foreach ($entry_old as  $room){
	
			//echo " room name = " . $room["room_name"] . "<br />";
				
			// get the room ID
			$res = $modelRes->getResourceFromName($room["room_name"]);
			//print_r($res);

			// add the pricings
			$modelPricing->setPricing($res["id"]  , 1, $room["tarif_biosit"] , $room["tarif_biosit_nuit"] , $room["tarif_biosit_we"]);
			$modelPricing->setPricing($res["id"]  , 2, $room["tarif_ur1"] , $room["tarif_ur1_nuit"] , $room["tarif_ur1_we"]);
			$modelPricing->setPricing($res["id"]  , 3, $room["tarif_public"] , $room["tarif_public_nuit"] , $room["tarif_public_we"]);
			$modelPricing->setPricing($res["id"]  , 4, $room["tarif_prive"] , $room["tarif_prive_nuit"] , $room["tarif_prive_we"]

        );
		}
	}
	
	public function addlinkUnitPricing($pdo_old){
		// get all users from old db
		$sql = "select * from grr_equipe";
		$labs_oldq = $pdo_old->query($sql);
		$labs_old = $labs_oldq->fetchAll();
	
		$modelUnit = new CoreUnit();
		$userPricing = new SyPricing();
		$modelLink = new SyUnitPricing();
		foreach ($labs_old as  $lo){
			// get lab id
			$unitId = $modelUnit->getUnitId($lo['equipe_name']);
				
			// get tarif id
			$id_pricing = $userPricing->getPricingId($lo['equipe_tarif']);
			if ($id_pricing == 0){
				$id_pricing = 4;
			}
	
			// link
			$modelLink->setPricing($unitId , $id_pricing

        );
		}
	
	}
	
	public function syncResourceCategories($pdo_old){
		// get the machines
		$sql = "select * from grr_room";
		$result = $pdo_old->query($sql);
		$machines = $result->fetchAll();
	
		$model = new SyResourcesCategory();
		foreach ($machines as  $m){
			$model->importResourcesCategory($m[ 'id'], $m[

        'room_name']);
		}
	}
	
	public function syncAuthorisations($pdo_old){
		// get all authorizations from old db
		$sql = "select * from grr_visiteur";
		$autorisations_oldq = $pdo_old->query($sql);
		$autorisations_old = $autorisations_oldq->fetchAll();
		
		
		$modelUser = new CoreUser();
		foreach ($autorisations_old as  $aut){
			// get id resource category
			$mrc = new SyResourcesCategory();
				
			// get user and unit id
			$mu = new CoreUnit();
			$idUser = $modelUser->userIdFromLogin($aut['visiteur_name']);
			if ($idUser <= 0){
				echo "sync authorizations cannot find the user " . $aut['visiteur_name'] . "<br/>";
			}
			else{
				$idUnit = $modelUser->userAllInfo($idUser)["id_unit"];
				$id_visa = 1;
				$id_resourceCategory = $aut['room_autorise'];
	
				// convert date
				$date_convention = '0000-00-00';
				// when only the year change it to 01/01/YYYY
				
				// set autorization
				$maut = new SyAuthorization();
				$maut->setAuthorization($aut[ 'id'], $date_convention , $idUser , $idUnit , $id_visa , $id_resourceCategory

        );
			}
		}
	}
	
	public function changeUnitName($pdo_grr){
		$labs_old = $this->getSygrrifArcheUnits();
                $modelUnit = new CoreUnit();
		foreach ($labs_old as  $lo){
			// get lab id
			$unitId = $modelUnit->getUnitId($lo[1]);
			$name = $lo[2]; 
			$address = $lo[3]; 
			$modelUnit->editUnit($unitId , $name , $address, 1);
		}
	}
}
?>