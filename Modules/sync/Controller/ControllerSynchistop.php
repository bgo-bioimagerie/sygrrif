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
		
		// add calendar entries
		$this->syncCalendarEntry($pdo_old);
		echo "<p>add Calendar Entries</p>";
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
			$pwd = $uo['pass'];
			$email = $uo['courriel']; 
			$phone = $uo['telephone'];
			$id_unit = 1;
			$id_responsible = 1;
			$id_status = 1;
			$convention = $uo['convention'];
			$date_convention = '';
			$dateObj = DateTime::createFromFormat("d/m/Y", $uo['date_c']);
			if ($dateObj)
			{
				$date_convention = $dateObj->format('Y-m-d');
			}
			$userModel->setUser($name, $firstname, $login, $pwd, 
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
			$id_resourceCategory = $mrc->getResourcesCategoryId($aut['machine'])[0];
			
			// get visa id
			$mv = new SyVisa();
			$id_visa = $mv->getVisaId($aut['visa'])[0];
			
			// get unit id
			$mu = new Unit();
			$idUnit = $mu->getUnitId($aut['laboratoire']);
			
			// get user id
			$muser = new User();
			$idUser = $muser->getUserIdFromFullName($aut['nf']);

			// convert date
			$date_convention = '';
			$dateObj = DateTime::createFromFormat("d/m/Y", $aut['date']);
			if ($dateObj){
				$date_convention = $dateObj->format('Y-m-d');
			}
			
			// set autorization
			$maut = new SyAuthorization();
			$maut->addAuthorization($date_convention, $idUser, $idUnit, $id_visa, $id_resourceCategory);
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
			
			// add the reservation
			$start_time = $entry['start_time'];
			$end_time = $entry['end_time']; 
			$resource_id = $entry['room_id'];
			$booked_by_id = $creatorID; 
			$recipient_id = $recipientID;
			$last_update = $entry['timestamp'];
			$color_type_id = $entry['entry_type']; 
			$short_description = $entry['description'];
			$full_description = $entry['description'];
			$modelCalEntry->addEntry($start_time, $end_time, $resource_id, $booked_by_id, $recipient_id, $last_update, $color_type_id, $short_description, $full_description);
		}
	}

}
?>