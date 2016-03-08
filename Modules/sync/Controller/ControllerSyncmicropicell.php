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
require_once 'Modules/sygrrif/Model/SyColorCode.php';

require_once 'externals/PHPExcel/Classes/PHPExcel.php';

class ControllerSyncmicropicell extends Controller {

	public function __construct() {
	}

	// affiche la liste des Sources
	public function index() {
	
		$authorizeUsers = true;
		
		// connect to h2p2 grr 
		$dsn_grr = 'mysql:host=localhost;dbname=grr_micropicell;charset=utf8';
		$login_grr = "root";
		$pwd_grr = "";
		
		$pdo_grr = new PDO($dsn_grr, $login_grr, $pwd_grr,
				array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		
		// resources categories
		$this->createdefaultResourceCatAndPricing();
		echo "add resources categories and pricing </br>";
		
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
	
		
		// load xls file
		$file = "C:/Users/sprigent/Desktop/myriam/utilisateurs imagerie cellulaire.xls";
		$XLSDocument = new PHPExcel_Reader_Excel5();
		$objPHPExcel = $XLSDocument->load($file);
		$objPHPExcel->setActiveSheetIndex(0);
		
		// units from xls
		$this->syncUnits($objPHPExcel);
		echo "sync units </br>";
		
		// responsble from xls
		$this->syncResponsibles($objPHPExcel);
		echo "sync responsibles </br>";
		
		// users from xls
		$this->syncUsersFromXls($objPHPExcel);
		echo "sync users from xls </br>";
		
		
		// load xls file 2
		$file = "C:/Users/sprigent/Desktop/myriam/Plate Forme  Morphologie.xls";
		$XLSDocument = new PHPExcel_Reader_Excel5();
		$objPHPExcel = $XLSDocument->load($file);
		$objPHPExcel->setActiveSheetIndex(0);
		
		// units xls 2
		$this->syncUnitXls2($objPHPExcel);
		echo "sync units from xls 2 </br>";
		
		// users xls 2
		$this->syncUsersFromXls2($objPHPExcel);
		echo "sync users from xls 2 </br>";
		
		if ($authorizeUsers){
			$this->addResourcesCategories();
			echo "sync resources types </br>";
		
			$this->addAuthorizations();
			echo "sync add authorizations </br>";
			
		}
	}
	
	public function syncAreas($pdo_grr){
		$sql = "select * from grr_area where area_name='PF-MicroPiCell'";
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
		
		$model = new SyColorCode();
		$model->importColorCode(15, "Formation", "FFCCFF");
		$model->importColorCode(19, "Manip", "C0E0FF");
		$model->importColorCode(21, "Indisponible", "FF0000");
		$model->importColorCode(22, "Maintenance", "FFBB20");
		$model->importColorCode(32, "Démonstration", "8000FF");
	}
	
	/*
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
	*/
	
	public function syncResources($pdo_grr){
		

		$sql = "select id from grr_area where area_name='PF-MicroPiCell'";
		$req = $pdo_grr->query($sql);
		$area_id = $req->fetch()[0];
		
		
		$sql = "select * from grr_room where area_id=".$area_id;
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
			$accessibility_id = 2; // who can book = users by default
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
			$resa_time_setting = 1;
			$modelResourceCal->addResource($id, $nb_people_max, $available_days, $day_begin, $day_end, $size_bloc_resa, $resa_time_setting);
		}
	}
	protected function addUsers($pdo_grr){
		
		$sql = "select id from grr_area where area_name='PF-MicroPiCell'";
		$req = $pdo_grr->query($sql);
		$area_id = $req->fetch()[0];
		
		$sql = "select distinct beneficiaire from grr_entry where room_id in (select id from grr_room where area_id=".$area_id.")";
		$entry_oldq = $pdo_grr->query($sql);
		$beneficiaires_old = $entry_oldq->fetchAll();
		
		//print_r($beneficiaires_old);
		
		// get all users from old db
		$sql = "select * from grr_utilisateurs";
		$req = $pdo_grr->query($sql);
		$users_old = $req->fetchAll();
		
		
		$userModel = new CoreUser();
		foreach($beneficiaires_old as $ben){
			
			$posUser = -1;
			$upben = strtoupper($ben[0]);
			for($i = 0 ; $i < count($users_old) ; $i++){
				//echo "ben = " . $upben . "</br>";
				//echo "user name = " . strtoupper($users_old[$i]['nom']) . "</br>";
				//echo "user login = " . strtoupper($users_old[$i]['login']) . "</br>";
				if (strtoupper($users_old[$i]['nom']) == $upben || strtoupper($users_old[$i]['login']) == $upben){
					$posUser = $i;
					break;
				}
			}
			if ($posUser>0){
				$uo = $users_old[$posUser];
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
				
				$convention = "";
				$date_convention = '';
				if ($pwd == ""){
					$pwd = "azerty";
				}
				$userModel->setUser($name, $firstname, $login, $pwd,
						$email, $phone, $id_unit,
						$id_responsible, $id_status,
						$convention, $date_convention);
			}
		}
	}
		
	public function syncCalendarEntry($pdo_old){
		
		// get the area ID
		$sql = "select id from grr_area where area_name='PF-MicroPiCell'";
		$req = $pdo_old->query($sql);
		$area_id = $req->fetch()[0];
		
		// get all authorizations from old db
		$sql = "select * from grr_entry where room_id in (select id from grr_room where area_id=".$area_id.")";
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
		
		// get the area ID
		$sql = "select id from grr_area where area_name='PF-MicroPiCell'";
		$req = $pdo_grr->query($sql);
		$area_id = $req->fetch()[0];
		
		// get all authorizations from old db
		$sql = "select * from grr_entry where room_id in (select id from grr_room where area_id=".$area_id.")";
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
	
	public function syncUnits($objPHPExcel){		
		
		// get the line where to start
		$curentLine = 841;
		$column = "B";
		
		$modelUnit = new CoreUnit();
		while ($curentLine <= 1128){
			
			// get units
			$unitName = $objPHPExcel->getActiveSheet()->getCell("".$column.$curentLine."")->getValue();
			// add unit if not exists
			if ($unitName != "" && $unitName != "Unité"){
				//echo "unitName = " . $unitName . "</br>";
				$modelUnit->setUnit($unitName, "");
			}
			$curentLine++;
		}
		
	}
	
	public function syncResponsibles($objPHPExcel){
		
		// get the line where to start
		$curentLine = 841; 
		$column = "C";
		
		// add user if not exists
		$modelUser = new CoreUser();
		$modelUnit = new CoreUnit();
		$modelResponsible = new CoreResponsible();
		while ($curentLine <= 1128){
			
			$unitName = $objPHPExcel->getActiveSheet()->getCell("B".$curentLine."")->getValue();
			
			if ($unitName != "" && $unitName != "Unité"){
				$userFullName = $objPHPExcel->getActiveSheet()->getCell("".$column.$curentLine."")->getValue();
				
				$ufn = explode(" ", $userFullName);
				$firstname = "";
				$name = "";
				if (count($ufn) > 1){
					$firstname = $ufn[0];
					$name = $ufn[1];
				}
				else{
					$firstname = "";
					$name = $ufn[0];
				}
				
				$login = strtolower($name) . "-" . substr(strtolower($firstname), 0, 1);
				$id_unit = $modelUnit->getUnitId($unitName);
				
				$id = $modelUser->getUserFromNameFirstname(strtoupper($name), $firstname);
				if ($id ==-1){
					$id = $modelUser->userIdFromLogin($login);
				}
				if ($id == -1){
					$pwd = "azerty"; 
					$email = ""; 
					$phone = "";
					$id_responsible = 1; // default admin
					$id_status = 1; // visitor
					$convention = "";
					$date_convention = "";
					$id_user = $modelUser->addUser($name, $firstname, $login, $pwd, $email, $phone, $id_unit, 
										$id_responsible, $id_status, $convention, $date_convention);
					
					$modelResponsible->setResponsible($id_user);
				}
				else{
					//echo "found an already existing user, id=" . $id . "</br>";
					$modelResponsible->setResponsible($id);
					$modelUser->userAllInfo($id)['login'];
					$modelUser->setUnitId($login, $id_unit);
				}
			}
			$curentLine++;
		}		
	}
	
	public function syncUsersFromXls($objPHPExcel){
	
		// get the line where to start
		$curentLine = 841;

		// add user if not exists
		$modelUser = new CoreUser();
		$modelUnit = new CoreUnit();
		$modelResponsible = new CoreResponsible();
		while ($curentLine <= 1128){
			
			// get the unit ID
			$unitName = $objPHPExcel->getActiveSheet()->getCell("B".$curentLine."")->getValue();
			if ($unitName != "" && $unitName != "Unité"){
				$id_unit = $modelUnit->getUnitId($unitName);
				
				// get the responsible id
				$responsibleName = $objPHPExcel->getActiveSheet()->getCell("C".$curentLine."")->getValue();
				$ufn = explode(" ", $responsibleName);
				$firstname = "";
				$name = "";
				if (count($ufn) > 1){
					$firstname = $ufn[0];
					$name = $ufn[1];
				}
				else{
					$firstname = "";
					$name = $ufn[0];
				}
				$login = strtolower($name) . "-" . substr(strtolower($firstname), 0, 1);
				$id_responsible = $modelUser->userIdFromLogin($login);
				
				// get the users
				$usersString = $objPHPExcel->getActiveSheet()->getCell("D".$curentLine."")->getValue();
				$usersArray = explode("+", $usersString);
				
				foreach($usersArray as $userFullName){
					$ufn = explode(" ", $userFullName);
					$firstname = "";
					$name = "";
					if (count($ufn) > 1){
						$firstname = $ufn[0];
						$name = $ufn[1];
					}
					else{
						$firstname = "";
						$name = $ufn[0];
					}
					$login = strtolower($name) . "-" . substr(strtolower($firstname), 0, 1);
					
					//echo "coucou 1 </br>";
					$id = $modelUser->getUserFromNameFirstname(strtoupper($name), $firstname);
					if ($id ==-1){
						//echo "coucou 1 bis, login = " . $login . "</br>";
						$login = iconv("UTF-8", 'ASCII//TRANSLIT//IGNORE', $login);
						$id = $modelUser->userIdFromLogin($login);
					}
					//echo "coucou 2 </br>";
					if ($id == -1){
						/*
						$pwd = "azerty";
						$email = "";
						$phone = "";
						$id_status = 1; // visitor
						$convention = "";
						$date_convention = "";
						$id_user = $modelUser->addUser($name, $firstname, $login, $pwd, $email, $phone, $id_unit,
								$id_responsible, $id_status, $convention, $date_convention);
						*/
					}
					else{
						$modelUser->setResponsible($id, $id_responsible);
						$modelUser->userAllInfo($id)['login'];
						$modelUser->setUnitId($login, $id_unit);
					}
				}
			}
			$curentLine++;
		}
	}
	
	public function syncUnitXls2($objPHPExcel){		
		
		// get the line where to start
		$curentLine = 12;
		$column = "D";
		
		$modelUnit = new CoreUnit();
		while ($curentLine <= 1161){
			
			// get units
			$unitName = $objPHPExcel->getActiveSheet()->getCell("".$column.$curentLine."")->getValue();
			// add unit if not exists
			if ($unitName != "" && $unitName != "service"){
				//echo "unitName = " . $unitName . "</br>";
				$modelUnit->setUnit($unitName, "");
			}
			$curentLine++;
		}
	}
	
	public function syncUsersFromXls2($objPHPExcel){
	
		// get the line where to start
		$curentLine = 12;
	
		// add user if not exists
		$modelUser = new CoreUser();
		$modelUnit = new CoreUnit();
		$modelResponsible = new CoreResponsible();
		while ($curentLine <= 1161){
				
			// get the unit ID
			$unitName = $objPHPExcel->getActiveSheet()->getCell("D".$curentLine."")->getValue();
			if ($unitName != "" && $unitName != "service"){
				$id_unit = $modelUnit->getUnitId($unitName);
	
				// get the users
				$userFullName = $objPHPExcel->getActiveSheet()->getCell("C".$curentLine."")->getValue();
				$ufn = explode(" ", $userFullName);
				$firstname = "";
				$name = "";
				if (count($ufn) > 1){
					$firstname = $ufn[1];
					$name = $ufn[0];
				}
				else{
					$firstname = "";
					$name = $ufn[0];
				}
				$login = strtolower($name) . "-" . substr(strtolower($firstname), 0, 1);
					
				//echo "coucou 1 </br>";
				$id = $modelUser->getUserFromNameFirstname(strtoupper($name), $firstname);
				if ($id ==-1){
					//echo "coucou 1 bis, login = " . $login . "</br>";
					$login = iconv("UTF-8", 'ASCII//TRANSLIT//IGNORE', $login);
					$id = $modelUser->userIdFromLogin($login);
				}
				//echo "coucou 2 </br>";
				if ($id == -1){
					$pwd = "azerty";
					$email = "";
					$phone = "";
					$id_status = 2; // user
					$convention = "";
					$date_convention = "";
					$id_responsible = 1;
					$id_user = $modelUser->addUser($name, $firstname, $login, $pwd, $email, $phone, $id_unit,
					$id_responsible, $id_status, $convention, $date_convention);
				}
				else{
					$modelUser->userAllInfo($id)['login'];
					$modelUser->setUnitId($login, $id_unit);
				}
			}
			$curentLine++;
		}
	}
	
	public function createdefaultResourceCatAndPricing(){
		$modelResourceCat = new SyResourcesCategory();
		$modelResourceCat->addResourcesCategory("default");
		
		$modelPricing = new SyPricing();
		$modelPricing->addPricing("Equipes SFR Santé François Bonamy", 1, 0, 0, 0, 0, "");
		$modelPricing->addPricing("Equipes hors SFR / Entreprises incubées localement", 1, 0, 0, 0, 0, "");
		$modelPricing->addPricing("Entreprises privées", 1, 0, 0, 0, 0, "");
	}
	
	public function addResourcesCategories(){
		$modelResources = new SyResource();
		$resources = $modelResources->resources("id");
		
		$modelCat = new SyResourcesCategory();
		foreach($resources as $r){
			$catID = $modelCat->addResourcesCategory($r["name"]);
			$modelResources->setResourceCategory($r["id"], $catID);
		}
	}
	
	public function addAuthorizations(){
		$modelVisa = new SyVisa();
		$modelVisa->addVisa("default");
		
		
		$modelUser = new CoreUser();
		$users = $modelUser->getUsers();
		
		$modelResources = new SyResourcesCategory();
		$resources = $modelResources->getResourcesCategories();
		
		$modelAuth = new SyAuthorization();
		foreach ($users as $us){
			
			if ($us["id_status"] == 2 ){ // only users
					
				$date = date('Y-m-d'); 
				$user_id = $us["id"]; 
				$lab_id = $us["id_unit"]; 
				$visa_id = 2;

				foreach ($resources as $r){
					$resource_id = $r["id"];
					$modelAuth->addAuthorization($date, $user_id, $lab_id, $visa_id, $resource_id);
				}
			}
		}
	}
}

?>