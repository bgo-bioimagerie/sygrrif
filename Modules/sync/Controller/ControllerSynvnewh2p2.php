<?php
require_once 'Framework/Configuration.php';
require_once 'Framework/Controller.php';
require_once 'Modules/core/Model/CoreInitDatabase.php';
require_once 'Modules/core/Model/CoreUnit.php';
require_once 'Modules/core/Model/CoreBelonging.php';
require_once 'Modules/sygrrif/Model/SyInstall.php';

/**
 * Script qui met à jour une partie de la base de donnée Sygrrif pour 
 * passer de la V0 à la V1
 * 
 * Procédure de mise à jour de V0 vers V1:
 * 	1- Faire une copie de la base de données au cas où le script efface certaines données
 *  2- Copier les sources de la V1 à la place des sources de la V0
 *  3- Lancer le script de mise à jour
 *  4- Certains modules peuvent necessiter une mise a jour de la base de données: Admin > modules > config > install 
 *  5- Check that the sygrrif pricing are correct
 *  
 * @author sprigent
 */

class ControllerSynvnew extends Controller {

	
	private static $bdd;
	public function __construct() {
	}

	// affiche la liste des Sources
	public function index() {

		// 1- install data  base
		echo "<p> Install core database...  </p>";
		$installModel = new CoreInitDatabase();
		$installModel->createDatabase();
		echo "<p> Core database installed </p>";
		
		echo "<p> Remove the sy_visa table </p>";
		$sql = "DROP TABLE sy_visas;";
		$this->runRequest($sql); 
		
		echo "<p> Install SyGRRif database...  </p>";
		$sygrrifInstall = new SyInstall();
		$sygrrifInstall->createDatabase();
		echo "<p> SyGrrif database installed </p>";
		
		$ModulesManagerModel = new ModulesManager();
		$ModulesManagerModel->setDataMenu("users/institutions", "coreusers", 3, "glyphicon-user");
			
		// 2- Copy syprincings to coreBelongings
		echo "<p> Copy syprincings to coreBelongings... </p>";
		// 2.1- get all the pricings
		echo "<p> get all the pricings </p>";
		$sql = "SELECT * FROM sy_pricing";
		$req = $this->runRequest($sql);
		$syPricings = $req->fetchAll();
		
		// 2.2- Copy pricings to belongings
		echo "<p> Copy pricings to belongings </p>";
		$modelBelonging = new CoreBelonging();
		foreach($syPricings as $pricing){
			$modelBelonging->set($pricing["id"]+1, $pricing["tarif_name"], "#ffffff", 1);
		}
		echo "<p> Copied syprincings to coreBelongings </p>";
		
		
		// 3- Associate belonging to unit depending on the syUnitPricing
		echo "<p> Associate belonging to unit depending on the syUnitPricing... </p>";
		// 3.1- Get all the unit pricing
		$sql = "SELECT * FROM sy_unitpricing";
		$req = $this->runRequest($sql);
		$syUnitPricings = $req->fetchAll();
		echo "<p> Get all the unit pricing </p>";
		
		// 2.3 do +1 to pricing ids
		$sql = "SELECT * FROM sy_j_resource_pricing;";
		$req = $this->runRequest($sql);
		$resPricings = $req->fetchAll();
		foreach($resPricings as $rep){
			$sql = "update sy_j_resource_pricing set id_pricing=? 
					where price_day=? AND price_night=? AND price_we=? AND id_resource=?";
			$this->runRequest($sql, array($rep["id_pricing"]+1, $rep["price_day"], $rep["price_night"], $rep["price_we"], $rep["id_resource"]));
		}
		
		$sql = "SELECT * FROM sy_pricing ORDER BY id DESC;";
		$req = $this->runRequest($sql);
		$pricings = $req->fetchAll();
		foreach($pricings as $rep){
			$sql = "update sy_pricing set id=?
					where id=?";
			$this->runRequest($sql, array($rep["id"]+1, $rep["id"]));
		}
		
		// 3.2 Associate units to belonging
		echo "<p> Associate units to belonging... </p>";
		$modelUnit = new CoreUnit();
		foreach($syUnitPricings as $up){
			// get the unit info
			$unitInfo = $modelUnit->getUnit($up["id_unit"]);
			$modelUnit->editUnit($unitInfo["id"], $unitInfo["name"], $unitInfo["address"], $up["id_pricing"]+1);
		}
		
		// 5- create visas
		$modelVisa = new SyVisa();
		
		$id_Analyse_images = 1;
		$id_Cryostat = 2;
		$id_Inclusion = 3;
		$id_Loupe_binoculaire = 4;
		$id_Microscope_nikon_NI_E = 6;
		$id_Microtome = 7;
		$id_Scanner_de_lames = 8;
		$id_Snapfrost = 9;
		$id_Vibratome = 10;
		$id_Microscope_80i = 12;
		$id_Intavis = 14;
		
		$id_visa_AF = 4; 
		$id_visa_MS = 7;
		$id_visa_PB = 8;
		$id_visa_RV = 11;
		$id_visa_GB = 15;
		
		$id_AF = 140;
		$id_MS = 113;
		$id_PB = 202;
		$id_RV = 201;
		$id_GB = 1; // todo add gaelle to users
		
		$status_resp = 2;
		$status_instructor = 1;
		
		// create AF visas
		$modelVisa->addVisa($id_Analyse_images, $id_AF, $status_instructor); // 1
		$modelVisa->addVisa($id_Cryostat, $id_AF, $status_instructor); // 2
		$modelVisa->addVisa($id_Inclusion, $id_AF, $status_instructor); // 3
		$modelVisa->addVisa($id_Loupe_binoculaire, $id_AF, $status_instructor); // 4
		$modelVisa->addVisa($id_Microscope_nikon_NI_E, $id_AF, $status_instructor); // 5
		$modelVisa->addVisa($id_Microtome, $id_AF, $status_instructor); // 6
		$modelVisa->addVisa($id_Scanner_de_lames, $id_AF, $status_instructor); // 7
		$modelVisa->addVisa($id_Snapfrost, $id_AF, $status_instructor); // 8
		$modelVisa->addVisa($id_Vibratome, $id_AF, $status_instructor); // 9
		$modelVisa->addVisa($id_Microscope_80i, $id_AF, $status_instructor); // 10
		$modelVisa->addVisa($id_Intavis, $id_AF, $status_instructor); // 11
		
		$modelVisa->addVisa($id_Analyse_images, $id_MS, $status_instructor); // 12
		$modelVisa->addVisa($id_Cryostat, $id_MS, $status_instructor); // 13
		$modelVisa->addVisa($id_Inclusion, $id_MS, $status_instructor); // 14
		$modelVisa->addVisa($id_Loupe_binoculaire, $id_MS, $status_instructor); // 15
		$modelVisa->addVisa($id_Microscope_nikon_NI_E, $id_MS, $status_instructor); // 16
		$modelVisa->addVisa($id_Microtome, $id_MS, $status_instructor); // 17
		$modelVisa->addVisa($id_Scanner_de_lames, $id_MS, $status_instructor); // 18
		$modelVisa->addVisa($id_Snapfrost, $id_MS, $status_instructor); // 19
		$modelVisa->addVisa($id_Vibratome, $id_MS, $status_instructor); // 20
		$modelVisa->addVisa($id_Microscope_80i, $id_MS, $status_instructor); // 21
		$modelVisa->addVisa($id_Intavis, $id_MS, $status_instructor); // 22
		
		$modelVisa->addVisa($id_Analyse_images, $id_PB, $status_instructor); // 23
		$modelVisa->addVisa($id_Cryostat, $id_PB, $status_instructor); // 24
		$modelVisa->addVisa($id_Inclusion, $id_PB, $status_instructor); // 25
		$modelVisa->addVisa($id_Loupe_binoculaire, $id_PB, $status_instructor); // 26
		$modelVisa->addVisa($id_Microscope_nikon_NI_E, $id_PB, $status_instructor); // 27
		$modelVisa->addVisa($id_Microtome, $id_PB, $status_instructor); // 28
		$modelVisa->addVisa($id_Scanner_de_lames, $id_PB, $status_instructor); // 29
		$modelVisa->addVisa($id_Snapfrost, $id_PB, $status_instructor); // 30
		$modelVisa->addVisa($id_Vibratome, $id_PB, $status_instructor); // 31
		$modelVisa->addVisa($id_Microscope_80i, $id_PB, $status_instructor); // 32
		$modelVisa->addVisa($id_Intavis, $id_PB, $status_instructor); // 33
		
		$modelVisa->addVisa($id_Analyse_images, $id_RV, $status_instructor); // 34
		$modelVisa->addVisa($id_Cryostat, $id_RV, $status_instructor); // 35
		$modelVisa->addVisa($id_Inclusion, $id_RV, $status_instructor); // 36
		$modelVisa->addVisa($id_Loupe_binoculaire, $id_RV, $status_instructor); // 37
		$modelVisa->addVisa($id_Microscope_nikon_NI_E, $id_RV, $status_instructor); // 38
		$modelVisa->addVisa($id_Microtome, $id_RV, $status_instructor); // 39
		$modelVisa->addVisa($id_Scanner_de_lames, $id_RV, $status_instructor); // 40
		$modelVisa->addVisa($id_Snapfrost, $id_RV, $status_instructor); // 41
		$modelVisa->addVisa($id_Vibratome, $id_RV, $status_instructor); // 42
		$modelVisa->addVisa($id_Microscope_80i, $id_RV, $status_instructor); // 43
		$modelVisa->addVisa($id_Intavis, $id_RV, $status_instructor); // 44
		
		$modelVisa->addVisa($id_Analyse_images, $id_GB, $status_instructor); // 45
		$modelVisa->addVisa($id_Cryostat, $id_GB, $status_instructor); // 46
		$modelVisa->addVisa($id_Inclusion, $id_GB, $status_instructor); // 47
		$modelVisa->addVisa($id_Loupe_binoculaire, $id_GB, $status_instructor); // 48
		$modelVisa->addVisa($id_Microscope_nikon_NI_E, $id_GB, $status_instructor); // 49
		$modelVisa->addVisa($id_Microtome, $id_GB, $status_instructor); // 50
		$modelVisa->addVisa($id_Scanner_de_lames, $id_GB, $status_instructor); // 51
		$modelVisa->addVisa($id_Snapfrost, $id_GB, $status_instructor); // 52
		$modelVisa->addVisa($id_Vibratome, $id_GB, $status_instructor); // 53
		$modelVisa->addVisa($id_Microscope_80i, $id_GB, $status_instructor); // 54
		$modelVisa->addVisa($id_Intavis, $id_GB, $status_instructor); // 55
		
		// edit authorizations
		$modelAuthorizations = new SyAuthorization();
		$auths = $modelAuthorizations->getAuths();
		foreach($auths as $au){
			$id = $au["id"];
			$date = $au["date"];
			$user_id = $au["user_id"];
			$lab_id = $au["lab_id"];
			$resource_id = $au["resource_id"];
			$visa_id = $au["visa_id"];
			
			
			$visaID = 1;
			if ($visa_id == $id_visa_AF){
				$visaID = $modelVisa->getVisaFromResourceAndInstructor($resource_id, $id_AF);
			}
			if ($visa_id == $id_visa_MS){
				$visaID = $modelVisa->getVisaFromResourceAndInstructor($resource_id, $id_MS);
			}
			if ($visa_id == $id_visa_PB){
				$visaID = $modelVisa->getVisaFromResourceAndInstructor($resource_id, $id_PB);
			}
			if ($visa_id == $id_visa_RV){
				$visaID = $modelVisa->getVisaFromResourceAndInstructor($resource_id, $id_RV);
			}
			if ($visa_id == $id_visa_GB){
				$visaID = $modelVisa->getVisaFromResourceAndInstructor($resource_id, $id_GB);
			}
				
			$modelAuthorizations->editAuthorization($id, $date, $user_id, $lab_id, $visaID, $resource_id);
		}
		
		// 4- enlarge the header column of sy_bookingcss
		echo "<p> enlarge the header columns of sy_bookingcss... </p>";
		$sql = "ALTER TABLE sy_bookingcss MODIFY header_background VARCHAR(7);";
		$this->runRequest($sql); 
		$sql = "ALTER TABLE sy_bookingcss MODIFY header_color VARCHAR(7);";
		$this->runRequest($sql);
		$modelCss = new SyBookingTableCSS();
		$bookingcss = $modelCss->areas("id");
		foreach($bookingcss as $css){
			$id = $css["id"];  
			$id_area = $css["id_area"]; 
			$header_background = "#" . $css["header_background"];
			$header_color = "#" . $css["header_color"];
			$header_font_size = $css["header_font_size"];
			$resa_font_size = $css["resa_font_size"];
			$header_height = $css["header_height"];
			$line_height = $css["line_height"];
			$modelCss->updateAreaCss($id, $id_area, $header_background, $header_color, $header_font_size, $resa_font_size, $header_height, $line_height);
		}
		
		// 5- update color code table
		echo "<p> Update color code table... </p>";
		$sql = "ALTER TABLE sy_color_codes MODIFY color VARCHAR(7);";
		$this->runRequest($sql);
		$sql = "ALTER TABLE sy_color_codes MODIFY text VARCHAR(7);";
		$this->runRequest($sql);
		$moduleColorCode = new SyColorCode();
		$colorCodes = $moduleColorCode->getColorCodes();
		foreach($colorCodes as $cc){
			$id = $cc["id"];
			$name = $cc["name"];
			$color = "#" . $cc["color"];
			$text_color = "#" . $cc["text"];
			$display_order = $cc["display_order"];
			$moduleColorCode->editColorCode($id, $name, $color, $text_color, $display_order);
		}	
		
		// 6- remove useless tables and columns
		echo "<p> remove useless tables and columns... </p>";
		$sql = "DROP TABLE sy_unitpricing;";
		$this->runRequest($sql);
		
		$sql = "alter table sy_pricing drop column tarif_name;";
		$this->runRequest($sql);
		$sql = "alter table sy_pricing drop column tarif_print;";
		$this->runRequest($sql);
		
		$sql = "DROP TABLE su_pricing;";
		$this->runRequest($sql);
		$sql = "DROP TABLE su_unitpricing;";
		$this->runRequest($sql);
		
/*		
		// copy responsibles to join table
		$modelUser = new CoreUser();
		$modelResp = new CoreResponsible();
		$users = $modelUser->getUsers();
		foreach($users as $user){
			$modelResp->addUserRespJoin($user['id'], $user['id_responsible']);
		}
		
		// set responsible id in the reservations
		$modelCalEntries = new SyCalendarEntry();
		$modelUser = new CoreUser();
		$entries = $modelCalEntries->getAllEntries();
		foreach($entries as $entry){
			$recipientID = $entry["recipient_id"];
			$resps = $modelUser->getUserResponsibles($recipientID);
			if (count($resps) > 0){
				$modelCalEntries->setEntryResponsible($entry["id"], $resps[0]["id"]);
			}
		}
*/
		echo "<p> Done </p>";
	}
	
	protected static function getDatabase()
	{
		if (self::$bdd === null) {
			// load the database informations
			$dsn = Configuration::get("dsn");
			$login = Configuration::get("login");
			$pwd = Configuration::get("pwd");
			// Create connection
			self::$bdd = new PDO($dsn, $login, $pwd,
					array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
			self::$bdd->exec("SET CHARACTER SET utf8");
		}
		return self::$bdd;
	}
	
	protected function runRequest($sql, $params = null)
	{
		if ($params == null) {
			$result = self::getDatabase()->query($sql);   // direct query
		}
		else {
			$result = self::getDatabase()->prepare($sql); // prepared request
			$result->execute($params);
		}
		return $result;
	}
		
}
?>