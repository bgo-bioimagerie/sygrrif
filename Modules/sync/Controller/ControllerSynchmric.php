<?php
require_once 'Framework/Controller.php';
require_once 'Modules/sygrrif/Model/SyVisa.php';
require_once 'Modules/sygrrif/Model/SyPricing.php';
require_once 'Modules/core/Model/CoreUnit.php';
require_once 'Modules/core/Model/CoreUser.php';
require_once 'Modules/core/Model/CoreResponsible.php';
require_once 'Modules/sygrrif/Model/SyResourcesCategory.php';
require_once 'Modules/sygrrif/Model/SyAuthorization.php';
require_once 'Modules/sygrrif/Model/SyUnitPricing.php';
require_once 'Modules/sygrrif/Model/SyCalendarEntry.php';
require_once 'Modules/sygrrif/Model/SyArea.php';
require_once 'Modules/sygrrif/Model/SyResource.php';
require_once 'Modules/sygrrif/Model/SyCalendarEntry.php';
require_once 'Modules/sygrrif/Model/SyResourceCalendar.php';
require_once 'Modules/sygrrif/Model/SyResourcePricing.php';
require_once 'Modules/sygrrif/Model/SyColorCode.php';
require_once 'Modules/core/Model/CoreInitDatabase.php';
require_once 'Modules/sygrrif/Model/SyInstall.php';

class ControllerSynchmric extends Controller {

	public function __construct() {
	}

	// affiche la liste des Sources
	public function index() {
		
		// connect to h2p2 grr 
		$dsn_grr = 'mysql:host=localhost;dbname=sygrrif_mric;charset=utf8';
		$login_grr = "root";
		$pwd_grr = "";
		
		$pdo_grr = new PDO($dsn_grr, $login_grr, $pwd_grr,
				array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		
		
		// install data  base
		$installModel = new CoreInitDatabase();
		$installModel->createDatabase();
		
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
		
		$this->addlinkUnitPricing($pdo_grr);
		echo "<p>sync unit prices done</p>";

		$this->syncResourceCategories($pdo_grr);
		echo "<p>sync resource categories</p>";
		
		// authorisations
		$this->syncAuthorisations($pdo_grr);
		echo "<p>sync authorizations</p>";
		
		$this->changeUnitName($pdo_grr);
		echo "<p>sync unit name</p>";
		
	}
	
	// /////////////////////////////////////////// //
	// internal functions
	// /////////////////////////////////////////// //
	protected function syncUnits($pdo_grr){
		
		$sql = "select * from grr_equipe";
		$result = $pdo_grr->query($sql);
		$units_old = $result->fetchAll();
		
		$unitModel = new CoreUnit();
		foreach ($units_old as $unit){
			$unitModel->setUnit($unit['equipe_name'], $unit['equipe_address']);
		}
	}
	
	protected function addUsers($pdo_grr){
		// get all users from old db
		$sql = "select * from grr_utilisateurs";
		$users_oldq = $pdo_grr->query($sql);
		$users_old = $users_oldq->fetchAll();
		
		$userModel = new CoreUser();
		$unitModel = new CoreUnit();
		foreach ($users_old as $uo){	
			$name = $uo['nom'];
			$firstname = $uo['prenom']; 
			$login = $uo['login']; 
			$pwd = $uo['password'];
			$email = $uo['email']; 
			$phone = $uo['telephone'];
			
			$id_unit = $unitModel->getUnitId($uo['equipe']);
			
			$id_responsible = 1;
			
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
			$dateObj = DateTime::createFromFormat("d/m/Y", $uo['fdc']);
			if ($dateObj)
			{
				$date_fin_contrat = $dateObj->format('Y-m-d');
			}
			$date_convention = "0000-00-00";
			$userModel->setUserMd5($name, $firstname, $login, $pwd, 
		           			$email, $phone, $id_unit, 
		           			$id_responsible, $id_status,
    						$convention, $date_convention, 
					        $date_fin_contrat, $is_active);
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
		foreach ($type_old as $typeo){
	
			$id = $typeo["id"];
			$name = $typeo["type_name"];
			$color = $tab_couleur[$typeo["couleur"]];
			$model->importColorCode($id, $name, $color);
		}
	}
	
	public function syncAreas($pdo_grr){
		$sql = "select * from grr_area";
		$entry_oldq = $pdo_grr->query($sql);
		$entry_old = $entry_oldq->fetchAll();
		
		$modelArea = new SyArea();
		foreach ($entry_old as $area){
			
			$id = $area["id"];
			$name = $area["area_name"];;
			$display_order = $area["order_display"];
			$restricted = 0;
			
			$modelArea->importArea($id, $name, $display_order, $restricted);	
		}
	}

	public function syncResources($pdo_grr){
		$sql = "select * from grr_room";
		$entry_oldq = $pdo_grr->query($sql);
		$entry_old = $entry_oldq->fetchAll();
	
		$modelArea = new SyArea();
		$modelResource = new SyResource();
		$modelResourceCal = new SyResourceCalendar();
	
		foreach ($entry_old as $room){
				
			$area_id = $room['area_id'];
			// get the area name
			$sql = "select * from grr_area where id=".$area_id."";
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
			$category_id = 1;
			$modelResource->importResource($id, $name, $description, $accessibility_id, $type_id, $area_id, $category_id);
				
			$nb_people_max = $room["capacity"];
			$arr1 = str_split($area_info["display_days"]);
			for ($t = 0 ; $t < count($arr1) ; $t++){
				if ($arr1[$t] == "y"){$arr1[$t] = 1;}
				if ($arr1[$t] == "n"){$arr1[$t] = 0;}
			}
			$available_days = $arr1[1] . "," . $arr1[2] . "," . $arr1[3] . ","
					. $arr1[4] . "," . $arr1[5] . "," . $arr1[6] . "," . $arr1[0] ;
			$day_begin = $area_info["morningstarts_area"];
			$day_end = $area_info["eveningends_area"];
			$size_bloc_resa = $area_info["resolution_area"];
			$modelResourceCal->setResource($id, $nb_people_max, $available_days, $day_begin, $day_end, $size_bloc_resa, 0);
		}
	}
	
	public function syncCalendarEntry($pdo_old){
		// get all authorizations from old db
		$sql = "select * from grr_entry";
		$entry_oldq = $pdo_old->query($sql);
		$entry_old = $entry_oldq->fetchAll();
	
		$modelUser = new CoreUser();
		$modelCalEntry = new SyCalendarEntry();
		foreach ($entry_old as $entry){
			// get the recipient ID
			$recipientID = $modelUser->userIdFromLogin($entry['beneficiaire']);
				
			// get the creator ID
			$creatorID = $modelUser->userIdFromLogin($entry['create_by']);
				
			// get the color id
			$type = $entry['type'];
			$sql = "select id from grr_type_area where type_letter='".$type."'";
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
			$modelCalEntry->setEntry($entry["id"], $start_time, $end_time, $resource_id, $booked_by_id, $recipient_id, $last_update, $color_type_id, $short_description, $full_description);
		}
	}
	
	public function syncLastLogin($pdo_grr){
		$sql = "select * from grr_entry";
		$entry_oldq = $pdo_grr->query($sql);
		$entry_old = $entry_oldq->fetchAll();
	
		$modelUser = new CoreUser();
		$modelCalEntry = new SyCalendarEntry();
		foreach ($entry_old as $entry){
			// get the recipient ID
			$recipientID = $modelUser->userIdFromLogin($entry['beneficiaire']);
			$date_last_login = $modelUser->getLastConnection($recipientID);
				
			$end_time = $entry['end_time'];
			$end_time = date("Y-m-d", $end_time);
				
			if ($end_time > $date_last_login){
				$modelUser->setLastConnection($recipientID, $end_time);
			}
		}
	}
	
	
	public function addPricings(){

		$modelPricing = new SyPricing();
		$modelPricing->addPricing("Biosit", 0, 1, 18, 8, 1, "0,0,0,0,1,1");
		$modelPricing->addPricing("UR1", 0, 1, 18, 8, 1, "0,0,0,0,1,1");
		$modelPricing->addPricing("Public", 0, 1, 18, 8, 1, "0,0,0,0,1,1");
		$modelPricing->addPricing("Privé", 0, 1, 18, 8, 1, "0,0,0,0,1,1");
	} 
	
	public function syncPrices($pdo_grr){
		$sql = "select * from grr_room";
		$entry_oldq = $pdo_grr->query($sql);
		$entry_old = $entry_oldq->fetchAll();
	
		$modelRes = new SyResource();
		$modelPricing = new SyResourcePricing();
		foreach ($entry_old as $room){
	
			//echo " room name = " . $room["room_name"] . "<br />";
				
			// get the room ID
			$res = $modelRes->getResourceFromName($room["room_name"]);
			//print_r($res);

			// add the pricings
			$modelPricing->setPricing($res["id"], 1, $room["tarif_biosit"], $room["tarif_biosit_nuit"], $room["tarif_biosit_we"]);
			$modelPricing->setPricing($res["id"], 2, $room["tarif_ur1"], $room["tarif_ur1_nuit"], $room["tarif_ur1_we"]);
			$modelPricing->setPricing($res["id"], 3, $room["tarif_public"], $room["tarif_public_nuit"], $room["tarif_public_we"]);
			$modelPricing->setPricing($res["id"], 4, $room["tarif_prive"], $room["tarif_prive_nuit"], $room["tarif_prive_we"]);
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
		foreach ($labs_old as $lo){
			// get lab id
			$unitId = $modelUnit->getUnitId($lo['equipe_name']);
				
			// get tarif id
			$id_pricing = $userPricing->getPricingId($lo['equipe_tarif']);
			if ($id_pricing == 0){
				$id_pricing = 4;
			}
	
			// link
			$modelLink->setPricing($unitId, $id_pricing);
		}
	
	}
	
	public function syncResourceCategories($pdo_old){
		// get the machines
		$sql = "select * from grr_room";
		$result = $pdo_old->query($sql);
		$machines = $result->fetchAll();
	
		$model = new SyResourcesCategory();
		foreach ($machines as $m){
			$model->importResourcesCategory($m['id'], $m['room_name']);
		}
	}
	
	public function syncAuthorisations($pdo_old){
		// get all authorizations from old db
		$sql = "select * from grr_visiteur";
		$autorisations_oldq = $pdo_old->query($sql);
		$autorisations_old = $autorisations_oldq->fetchAll();
		
		
		$modelUser = new CoreUser();
		foreach ($autorisations_old as $aut){
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
				$maut->setAuthorization($aut['id'], $date_convention, $idUser, $idUnit, $id_visa, $id_resourceCategory);
			}
		}
	}
	
	public function changeUnitName($pdo_grr){
		$sql = "select * from grr_equipe";
		$labs_oldq = $pdo_grr->query($sql);
		$labs_old = $labs_oldq->fetchAll();
		
		$modelUnit = new CoreUnit();
		$userPricing = new SyPricing();
		$modelLink = new SyUnitPricing();
		foreach ($labs_old as $lo){
			// get lab id
			$unitId = $modelUnit->getUnitId($lo['equipe_name']);
			$name = $lo['equipe_print'];
			$address = $lo['equipe_address'];
			$modelUnit->editUnit($unitId, $name, $address);
		}
	}
}
?>