<?php
require_once 'Framework/Controller.php';
require_once 'Modules/sygrrif/Model/SyVisa.php';
require_once 'Modules/sygrrif/Model/SyPricing.php';
require_once 'Modules/core/Model/Unit.php';
require_once 'Modules/core/Model/User.php';
require_once 'Modules/core/Model/Responsible.php';

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
		
		// ad unit link
		$this->addlinkUnitUser($pdo_old);
		echo "<p>unit user link added</p>";
		
		// add responsible
		$this->addResponsibles($pdo_old);
		echo "<p>responsibles added</p>";
		
		// link user responsible
		$this->linkUserResponsible($pdo_old);
		echo "<p>link user responsibles added</p>";
		
		// add authorisations
		// @todo
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

}
?>