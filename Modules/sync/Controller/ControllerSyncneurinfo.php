<?php
require_once 'Framework/Controller.php';
require_once 'Modules/sygrrif/Model/SyVisa.php';
require_once 'Modules/sygrrif/Model/SyPricing.php';
require_once 'Modules/core/Model/Unit.php';
require_once 'Modules/core/Model/User.php';
require_once 'Modules/core/Model/Responsible.php';
require_once 'Modules/sygrrif/Model/SyResourcesCategory.php';
require_once 'Modules/sygrrif/Model/SyAuthorization.php';
require_once 'Modules/sygrrif/Model/SyUnitPricing.php';
require_once 'Modules/sygrrif/Model/SyCalendarEntry.php';
require_once 'Modules/sygrrif/Model/SyArea.php';
require_once 'Modules/sygrrif/Model/SyResource.php';
require_once 'Modules/sygrrif/Model/SyCalendarEntry.php';
require_once 'Modules/sygrrif/Model/SyResourceCalendar.php';
require_once 'Modules/sygrrif/Model/SyColorCode.php';

class ControllerSyncneurinfo extends Controller {

	public function __construct() {
	}

	// affiche la liste des Sources
	public function index() {
		
		// connect to h2p2 grr 
		$dsn_grr = 'mysql:host=localhost;dbname=grr_neurinfo;charset=utf8';
		$login_grr = "root";
		$pwd_grr = "";
		
		$pdo_grr = new PDO($dsn_grr, $login_grr, $pwd_grr,
				array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		
		// area
		$this->syncAreas($pdo_grr);
		echo "sync area </br>";
		
		// area types
		$this->syncEntryTypes($pdo_grr);
		echo "sync entry types </br>";
		
		// resources
		$this->syncResources($pdo_grr);
		echo "sync resources </br>";
		
		// users
		$this->addUsers($pdo_grr);
		echo "sync users </br>";
		
		// calendar entries
		$this->syncCalendarEntry($pdo_grr);
		echo "sync calendar entries </br>";
		
		// last login 
		$this->syncLastLogin($pdo_grr);
		echo "sync last login </br>";
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
			if ($area["access"] == "r"){
				$restricted = 1;
			}
			$modelArea->importArea($id, $name, $display_order, $restricted);
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
				
			$id = $typeo["id"] + 1;
			$name = $typeo["type_name"];
			$color = $tab_couleur[$typeo["couleur"]];
			$model->importColorCode($id, $name, $color);
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
			$accessibility_id = 4; // who can book = admin by default
			$type_id = 1; // calendar
			$category_id = 1;
			$modelResource->importResource($id, $name, $description, $accessibility_id, $type_id, $area_id, $category_id);
				
			$nb_people_max = $room["capacity"];
			$arr1 = str_split($area_info["display_days"]);
			for ($t = 0 ; $t < count($arr1) ; $t++){
				if ($arr1[$t] == "y"){$arr1[$t] = 1;}
				if ($arr1[$t] == "n"){$arr1[$t] = 0;}
			}
			$available_days = $arr1[0] . "," . $arr1[1] . "," . $arr1[2] . "," . $arr1[3] . ","
					. $arr1[4] . "," . $arr1[5] . "," . $arr1[6];
			$day_begin = $area_info["morningstarts_area"];
			$day_end = $area_info["eveningends_area"];
			$size_bloc_resa = $area_info["resolution_area"];
			$modelResourceCal->addResource($id, $nb_people_max, $available_days, $day_begin, $day_end, $size_bloc_resa);
		}
	}
	
	protected function addUsers($pdo_grr){
		// get all users from old db
		$sql = "select * from grr_utilisateurs";
		$req = $pdo_grr->query($sql);
		$users_old = $req->fetchAll();
	
		$userModel = new User();
		foreach ($users_old as $uo){
			$name = $uo['nom'];
			$firstname = $uo['prenom'];
			$login = $uo['login'];
			$pwd = $uo['password'];
			$email = $uo['email'];
			$phone = "";
			$id_unit = 1;
			$id_responsible = 1;
			
			$grrstatus = $uo['statut'];
			if ($grrstatus == "administrateur"){
				$id_status = 4;
			}
			if ($grrstatus == "gestionnaire_utilisateur"){
				$id_status = 3;
			}
			if ($grrstatus == "utilisateur"){
				$id_status = 2;
			}
			if ($grrstatus == "visiteur"){
				$id_status = 1;
			}
			
			$id_status = 1;
			$convention = "";
			$date_convention = '';
			//$dateObj = DateTime::createFromFormat("d/m/Y", $uo['date_c']);
			//if ($dateObj)
			//{
			//	$date_convention = $dateObj->format('Y-m-d');
			//}
			$userModel->setUser($name, $firstname, $login, $pwd,
					$email, $phone, $id_unit,
					$id_responsible, $id_status,
					$convention, $date_convention);
		}
	
	}
	
	public function syncCalendarEntry($pdo_old){
		// get all authorizations from old db
		$sql = "select * from grr_entry";
		$entry_oldq = $pdo_old->query($sql);
		$entry_old = $entry_oldq->fetchAll();
	
		$modelUser = new User();
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
				
			//echo " color_type_id = " . $color_type_id;
				
			// add the reservation
			$start_time = $entry['start_time'];
			$end_time = $entry['end_time'];
			$resource_id = $entry['room_id'];
			$booked_by_id = $creatorID;
			$recipient_id = $recipientID;
			$last_update = $entry['timestamp'];
			$color_type_id = $color_type_id+1;
			$short_description = $entry['description'];
			$full_description = $entry['description'];
			$id = $modelCalEntry->addEntry($start_time, $end_time, $resource_id, $booked_by_id, $recipient_id, $last_update, $color_type_id, $short_description, $full_description);
		
			$repeat_id = $entry['repeat_id'];
			$modelCalEntry->setRepeatID($id, $repeat_id);
		}
	}
	
	public function syncLastLogin($pdo_grr){
		$sql = "select * from grr_entry";
		$entry_oldq = $pdo_grr->query($sql);
		$entry_old = $entry_oldq->fetchAll();
	
		$modelUser = new User();
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
	
	
}

?>