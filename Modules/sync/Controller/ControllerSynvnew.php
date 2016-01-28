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
		
		// 5- set all visas to default
		echo "<p> set all visas to default... </p>";
		$modelAuthorizations = new SyAuthorization();
		$auths = $modelAuthorizations->getAuths();
		foreach($auths as $au){
			$id = $au["id"]; 
			$date = $au["date"]; 
			$user_id = $au["user_id"];
			$lab_id = $au["lab_id"]; 
			$resource_id = $au["resource_id"]; 
			
			$modelAuthorizations->editAuthorization($id, $date, $user_id, $lab_id, 1, $resource_id);
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
		
		/*
		$sql = "DROP TABLE su_pricing;";
		$this->runRequest($sql);
		$sql = "DROP TABLE su_unitpricing;";
		$this->runRequest($sql);
*/		
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