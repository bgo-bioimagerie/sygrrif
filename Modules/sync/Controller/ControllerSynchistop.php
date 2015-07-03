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
require_once 'Modules/sygrrif/Model/SyResourcePricing.php';
require_once 'Modules/sygrrif/Model/SyColorCode.php';

class ControllerSynchistop extends Controller {

	public function __construct() {
	}

	// affiche la liste des Sources
	public function index() {
		
		// connect to the h2p2 db
		$dsn_old = 'mysql:host=localhost;dbname=histop-demo;charset=utf8';
		$login_old = "root";
		$pwd_old = "";
		
		$pdo_old = new PDO($dsn_old, $login_old, $pwd_old,
				array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		
		// connect to h2p2 grr 
		$dsn_grr = 'mysql:host=localhost;dbname=grr_h2p2;charset=utf8';
		$login_grr = "root";
		$pwd_grr = "";
		
		$pdo_grr = new PDO($dsn_grr, $login_grr, $pwd_grr,
				array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		
		/*
		// Visa
		$visas_old = $this->getVisas($pdo_old);
		$visaModel = new SyVisa();
		foreach ($visas_old as $visa_old){
			$visaModel->setVisa($visa_old['name']);
		}
		echo "<p>Visa syncro done</p>";
		
		// Tarifs
		$pricing_old = $this->getTarifs($pdo_old);
		$tarifModel = new SyPricing();
		foreach ($pricing_old as $po){
			$nom = $po['name'];
			$tarif_unique = $po['t_unique'];
			$tarif_nuit = $po['night'];
			$night_start = $po['night_start'];
			$night_end = $po['night_end'];
			$tarif_we = $po['we'];
			$we_char = $po['we_choice'];
			$tarifModel->setPricing($nom, $tarif_unique, $tarif_nuit, $night_start, $night_end, $tarif_we, $we_char);
		}
		echo "<p>pricing syncro done</p>";
		
		// Unit
		$units_old = $this->getUnits($pdo_old);
		$unitModel = new Unit();
		foreach ($units_old as $unit){
			$unitModel->setUnit($unit['name'], $unit['address']);
		}
		echo "<p>units syncro done</p>";
		
		// add user and link it's unit
		$this->addUsers($pdo_old);
		echo "<p>add user done</p>";
		
		// add unit link
		$this->addlinkUnitUser($pdo_old);
		echo "<p>unit user link added</p>";
		
		// add unit pricing
		$this->addlinkUnitPricing($pdo_old);
		echo "<p>unit pricing link added</p>";
		
		// add responsible
		$this->addResponsibles($pdo_old);
		echo "<p>responsibles added</p>";
		
		// link user responsible
		$this->linkUserResponsible($pdo_old);
		echo "<p>link user responsibles added</p>";
		
		// add machines cathegories
		$this->syncMachines($pdo_old);
		echo "<p>add ressources cathegories</p>";
		
		// add authorisations
		$this->syncAuthorisations($pdo_old);
		echo "<p>add athorizations</p>";
		
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
		$this->syncLastLogin($pdo_grr);
		echo "<p>add Last login</p>";
		
		$this->syncPrices($pdo_grr);
		echo "<p>sync prices done</p>";
		
		$this->addNewResources();
		echo "<p>add New Resources</p>";
		// */
		// /*
		$this->desactivateAuthorizationDoNotBookAYear();
		echo "<p>desactivate authorizations</p>";
		
		$this->desactivateUserDoNotBookAYear();
		echo "<p>desactivate users</p>";
		// */
	}
	
	// /////////////////////////////////////////// //
	// internal functions
	// /////////////////////////////////////////// //
	protected function getVisas($pdo_old){
	
		$sql = "select * from visa";
		$result = $pdo_old->query($sql);
		return $result->fetchAll();
	
	}
	
	protected function getTarifs($pdo_old){
		$sql = "select * from tarif";
		$result = $pdo_old->query($sql);
		return $result->fetchAll();
		
	}
	
	protected function getUnits($pdo_old){
		$sql = "select * from laboratoire";
		$result = $pdo_old->query($sql);
		return $result->fetchAll();
	}
	
	protected function addUsers($pdo_old){
		// get all users from old db
		$sql = "select * from users";
		$users_oldq = $pdo_old->query($sql);
		$users_old = $users_oldq->fetchAll();
		
		$userModel = new User();
		foreach ($users_old as $uo){	
			$name = $uo['name'];
			$firstname = $uo['firstname']; 
			$login = $uo['login']; 
			$pwd = md5("*histop*");//$uo['pass'];
			$email = $uo['courriel']; 
			$phone = $uo['telephone'];
			$id_unit = 1;
			$id_responsible = 1;
			$id_status = 2; // user
			$convention = $uo['convention'];
			$date_convention = '';
			$dateObj = DateTime::createFromFormat("d/m/Y", $uo['date_c']);
			if ($dateObj)
			{
				$date_convention = $dateObj->format('Y-m-d');
			}
			
			$userModel->setUserMd5($name, $firstname, $login, $pwd, 
		           			$email, $phone, $id_unit, 
		           			$id_responsible, $id_status,
    						$convention, $date_convention);
		}
		
	}
	
	public function addlinkUnitUser($pdo_old){
		// get all users from old db
		$sql = "select * from users";
		$users_oldq = $pdo_old->query($sql);
		$users_old = $users_oldq->fetchAll();
		
		// get unit id
		$modelUnit = new Unit();
		
		$userModel = new User();
		foreach ($users_old as $uo){
		
			//print_r($uo);
			$unitId = $modelUnit->getUnitId($uo['laboratoire']);
			$userModel->setUnitId($uo['login'], $unitId);
		}
	}
	
	public function addlinkUnitPricing($pdo_old){
		// get all users from old db
		$sql = "select * from laboratoire";
		$labs_oldq = $pdo_old->query($sql);
		$labs_old = $labs_oldq->fetchAll();
		
		$modelUnit = new Unit();
		$userPricing = new SyPricing();
		$modelLink = new SyUnitPricing();
		foreach ($labs_old as $lo){
			// get lab id
			$unitId = $modelUnit->getUnitId($lo['name']);
			
			// get tarif id
			$id_pricing = $userPricing->getPricingId($lo['tarif']);

			// link 
			$modelLink->setPricing($unitId, $id_pricing);
		}
		
	}
	
	public function addResponsibles($pdo_old){
		// get all users from old db
		$sql = "select * from users";
		$users_oldq = $pdo_old->query($sql);
		$users_old = $users_oldq->fetchAll();
		
		$userModel = new User();
		$respModel = new Responsible();
		foreach ($users_old as $uo){
			
			// find id
			$id = $userModel->getUserIdFromFullName($uo['responsable']);
			if ($id > 0){
				// add responsible
				$respModel->setResponsible($id); 
			}
			else{
				echo "<p>cannot find responsible: " . $uo['responsable'] . "</p>";
			}
		}
	} 
	
	public function linkUserResponsible($pdo_old){
		// get all users from old db
		$sql = "select * from users";
		$users_oldq = $pdo_old->query($sql);
		$users_old = $users_oldq->fetchAll();
		
		$userModel = new User();
		$respModel = new Responsible();
		foreach ($users_old as $uo){
			
			$idResp = $userModel->getUserIdFromFullName($uo['responsable']);
			$idUser = $userModel->userIdFromLogin($uo['login']);
			
			if ($idResp > 0){
				if ($idUser > 0){
					$userModel->setResponsible($idUser, $idResp);
				}
				else{
					echo "<p> Warning: cannot find id of " . $uo['login'] . "</p>";
				}
			}
			else{
				echo "<p> Warning: cannot find resp id of " . $uo['responsable'] . "</p>";
			}
			
			
		}
	}
	
	public function syncMachines($pdo_old){
		// get the machines
		$sql = "select * from machines";
		$result = $pdo_old->query($sql);
		$machines = $result->fetchAll();
		
		$model = new SyResourcesCategory();
		foreach ($machines as $m){
			$model->setResourcesCategory($m['nom']);
		}
	}
	
	public function syncAuthorisations($pdo_old){
		// get all authorizations from old db
		$sql = "select * from autorisation";
		$autorisations_oldq = $pdo_old->query($sql);
		$autorisations_old = $autorisations_oldq->fetchAll();
		
		foreach ($autorisations_old as $aut){
			// get id resource category
			$mrc = new SyResourcesCategory();
			if (!$mrc->isResourcesCategory($aut['machine'])){
				$mrc->addResourcesCategory($aut['machine']);
			}
			$id_resourceCategory = $mrc->getResourcesCategoryId($aut['machine'][0]);
			
			// get visa id
			$mv = new SyVisa();
			$id_visa = $mv->getVisaId($aut['visa'][0]);
			
			// get unit id
			$mu = new Unit();
			$idUnit = $mu->getUnitId($aut['laboratoire']);
			
			// get user id
			$muser = new User();
			$idUser = $muser->getUserIdFromFullName($aut['nf']);

			// convert date
			$date_convention = '';
			// when only the year change it to 01/01/YYYY
			$db_date = $aut['date'];
			if (iconv_strlen($db_date) < 8){
				$db_date = "01/01/".$db_date;
			}
			
			$dateObj = DateTime::createFromFormat("d/m/Y", $db_date);
			if ($dateObj){
				$date_convention = $dateObj->format('Y-m-d');
			}
			
			// set autorization
			$maut = new SyAuthorization();
			$maut->setAuthorization($aut['id'], $date_convention, $idUser, $idUnit, $id_visa, $id_resourceCategory);
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
			$color_type_id = $req->fetch();
			
			if (!$color_type_id){
				$color_type_id = 3; // autres
			}
			
			//echo " color_type_id = " . $color_type_id; 
			
			// add the reservation
			$start_time = $entry['start_time'];
			$end_time = $entry['end_time']; 
			$resource_id = $entry['room_id'];
			$booked_by_id = $creatorID; 
			$recipient_id = $recipientID;
			$last_update = $entry['timestamp'];
			$color_type_id = $color_type_id; 
			$short_description = $entry['description'];
			$full_description = $entry['description'];
			//$modelCalEntry->addEntry($start_time, $end_time, $resource_id, $booked_by_id, $recipient_id, $last_update, $color_type_id, $short_description, $full_description);
			$modelCalEntry->setEntry($entry["id"], $start_time, $end_time, $resource_id, $booked_by_id, $recipient_id, $last_update, $color_type_id, $short_description, $full_description);
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

	public function syncAreas($pdo_grr){
		$sql = "select * from grr_area";
		$entry_oldq = $pdo_grr->query($sql);
		$entry_old = $entry_oldq->fetchAll();
		
		$modelArea = new SyArea();
		foreach ($entry_old as $area){
			
			$id = $area["id"];
			$name = $area["area_name"];;
			$display_order = $area["order_display"];
			
			if ($name != "INTAVIS"){
				$restricted = 0;
				if ($area["access"] == "r"){
					$restricted = 1;
				}
				$modelArea->importArea($id, $name, $display_order, $restricted);	
			}
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
	
	
	public function desactivateAuthorizationDoNotBookAYear(){
		
		// activate all authorizations
		
		$modelAuth = new SyAuthorization();
		$auths = $modelAuth->getAuths();
		
		$ModelUser = new User();
		
		$ayearago = time()-3600*24*365;
		$modelCalEntry = new SyCalendarEntry();
		$modelResources = new SyResource();
		foreach($auths as $auth){
			$authID = $auth["id"];
			$userID = $auth["user_id"];
			$authDate = $auth["date"];
			
			//echo "auth date = " . $authDate . "<br />";
			
			$authDate = explode("-", $authDate);
			//echo "auth date = " . print_r($authDate) . "<br />";
			$authDate = mktime(0,0,0, $authDate[1], $authDate[2], $authDate[0]);
			$resourceCat_id = $auth["resource_id"];
			$modelAuth->activate($authID);
			
			if ($authID == 433){
				echo "authDate = " . $authDate . "<br/>";
				echo "ayearago = " . $ayearago . "<br/>";
			}
			
			if ($authDate < $ayearago){
				
				//echo " coucou <br/>";
				
				// get all the resources of the category
				$resources_id = $modelResources->resourcesFromCategory($resourceCat_id);
				$desactivate = 0;
				//print_r($resources_id);
				
				$resources_count = 0;
				foreach ($resources_id as $resource_id){
					$resources_count++;
					$entries = $modelCalEntry->getUserBookingResource($userID, $resource_id["id"]);
					if ( ( $resource_id["id"] == 2 || $resource_id["id"] == 9 ) && $userID == 155 ){
						echo "anglade " .  "<br/>" ;
						if (count($entries) > 0){
							echo "last booking anglade = " . date("Y-m-d", $entries[0]["end_time"]) . ", id= " . $entries[0]["id"] . "<br/>";
						}  
					}
					if (count($entries) > 0){
						//echo "count > 0 <br />" ;
						if ( $entries[0]["end_time"] < $ayearago ){
							//echo "last booking anglade = " . date("Y-m-d", $entries[0]["end_time"]) . "is more than a year ago";
							$desactivate++;
						}
					}
					else{
						$desactivate++;
					}
				}
				echo "desactivate = " . $desactivate . "<br/>";
				if ($desactivate == $resources_count){
					// desactivate autorisations
					if ($userID == 114){
						echo "desactivate sicard for " . $authID . "<br/>";
					}
					echo "desactivate authorisation";
					$modelAuth->unactivate($authID);
				}
			}
		}
	}
	
	public function desactivateUserDoNotBookAYear(){
		// get all the users
		$ModelUser = new User();
		$users = $ModelUser->getUsers();
		
		$modelCalEntry = new SyCalendarEntry();
		$modelAuth = new SyAuthorization();
		$today = time();
		$aYearAgo = $today - 365*24*3600;
		foreach( $users as $user){
			$ModelUser->setactive($user["id"], 1);
			// get his booking
			$entries = $modelCalEntry->getUserBooking($user["id"]);
			if (count($entries) > 0){
				if ( $entries[0]["end_time"] < $aYearAgo ){
					// desactivate user
					//$ModelUser->setactive($user["id"], 0);
					
					/*
					if ($user["id"] == 155){
						echo "desactivate anglade, ";
						echo "because last booking = " . date();
					}
					*/
					
					// desactivate autorisations
					//$modelAuth->desactivateAthorizationsForUser($user["id"]);
				}
			}
		}
	}
	
	public function syncPrices($pdo_grr){
		$sql = "select * from grr_room";
		$entry_oldq = $pdo_grr->query($sql);
		$entry_old = $entry_oldq->fetchAll();
		
		$modelRes = new SyResource();
		$modelPricing = new SyResourcePricing();
		foreach ($entry_old as $room){

			//echo " room name = " . $room["room_name"] . "<br />";
			
			if ($room["room_name"] != "INTAVIS"){
				// get the room ID
				$res = $modelRes->getResourceFromName($room["room_name"]);
				//print_r($res);
				
				// add the pricings
				$modelPricing->setPricing($res["id"], 1, $room["tarif_biosit"], $room["tarif_biosit"], $room["tarif_biosit"]);
				$modelPricing->setPricing($res["id"], 2, $room["tarif_ur1"], $room["tarif_ur1"], $room["tarif_ur1"]);
				$modelPricing->setPricing($res["id"], 3, $room["tarif_public_sans_personnel"], $room["tarif_public_sans_personnel"], $room["tarif_public_sans_personnel"]);
				$modelPricing->setPricing($res["id"], 4, $room["tarif_prive_ac_personnel"], $room["tarif_prive_ac_personnel"], $room["tarif_prive_ac_personnel"]);
				}
		}
	}
	
	public function addNewResources(){
		
		// create INTAVIS TYPE
		$resCat = new SyResourcesCategory();
		$resCat->addResourcesCategory("Intavis");
		
		// INTAVIS
		$name = "INTAVIS";
		$description = "";
		$accessibility_id = "4";
		$type_id = "2";
		$area_id = "4";
		$category_id = "13";
		
		$available_days = "1,1,1,1,1,0,0";
		$day_begin = "8";
		$day_end = "19"; 
		$size_bloc_resa = "1800";
		$resa_time_setting = "0";
		$quantity_name = "Nombre d'échantillons";
		
		$modelResource = new SyResource();
		$id_resource = $modelResource->addResource($name, $description, $accessibility_id, $type_id, $area_id, $category_id);
		$modelCResource = new SyResourceCalendar();
		$modelCResource->setResource($id_resource, 0, $available_days, $day_begin, $day_end, $size_bloc_resa, $resa_time_setting, $quantity_name);
		
		// Automate d'impréniation
		$name = "Inclusion parafine";
		$description = "";
		$accessibility_id = "2";
		$type_id = "2";
		$area_id = "1";
		$category_id = "3";
		
		$available_days = "1,1,1,1,1,0,0";
		$day_begin = "8";
		$day_end = "19";
		$size_bloc_resa = "1800";
		$resa_time_setting = "0";
		$quantity_name = "Nombre d'échantillons";
		
		$id_resource = $modelResource->addResource($name, $description, $accessibility_id, $type_id, $area_id, $category_id);
		$modelCResource->setResource($id_resource, 0, $available_days, $day_begin, $day_end, $size_bloc_resa, $resa_time_setting, $quantity_name);
	}
}
?>