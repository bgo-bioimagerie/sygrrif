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

class ControllerSynchmricendcontract extends Controller {

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
		
		
		// Users
		$this->addUsers($pdo_grr);
		echo "<p>add users</p>";
		
	}
	
	// /////////////////////////////////////////// //
	// internal functions
	// /////////////////////////////////////////// //
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
			
			//$id_unit = $unitModel->getUnitId($uo['equipe']);
			$id_unit = "";
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
			$dfc = $uo['fdc'];
			echo "name = " . $name . " " . $firstname . "<br/>";
			echo "dfc = " . $dfc . "<br/>";
			echo "date fc = " . date("Y-m-d", $uo['fdc']) . "<br/>";
			echo "<br/>";
			$date_fin_contrat = date("Y-m-d", $uo['fdc']);
			/*
			$dateObj = DateTime::createFromFormat("d/m/Y", $uo['fdc']);
			if ($dateObj)
			{
				$date_fin_contrat = $dateObj->format('Y-m-d');
			}
			*/
			
			echo "date fin de contrat = " . $date_fin_contrat . "<br/>"; 
			$date_convention = "0000-00-00";
			
			$userModel->setEndContract($login, $date_fin_contrat);
			/*
			$userModel->setUserMd5($name, $firstname, $login, $pwd, 
		           			$email, $phone, $id_unit, 
		           			$id_responsible, $id_status,
    						$convention, $date_convention, 
					        $date_fin_contrat, $is_active);
			*/
		}	
	}
	

}
?>