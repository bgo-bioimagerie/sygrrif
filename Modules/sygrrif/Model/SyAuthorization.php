<?php
require_once 'Framework/Model.php';
require_once 'Modules/core/Model/Responsible.php';

/**
 * Class defining the Visa model
 *
 * @author Sylvain Prigent
 */
class SyAuthorization extends Model {
	
	/**
	 * Create the authorization table
	 *
	 * @return PDOStatement
	 */
	public function createTable() {
		$sql = "CREATE TABLE IF NOT EXISTS `sy_authorization` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`date` DATE NOT NULL,		
		`user_id` int(11) NOT NULL,
		`lab_id` int(11) NOT NULL,
		`visa_id` int(11) NOT NULL,
		`resource_id` int(11) NOT NULL,	
		`is_active` int(1) NOT NULL,			
		PRIMARY KEY (`id`)
		);";
		
		$pdo = $this->runRequest ( $sql );
		return $pdo;
	}
	public function addAuthorization($date, $user_id, $lab_id, $visa_id, $resource_id, $is_active=1) {
		$sql = "insert into sy_authorization(date, user_id, lab_id, visa_id, resource_id, is_active)" .
		 " values(?,?,?,?,?,?)";
		$this->runRequest ( $sql, array (
				$date,
				$user_id,
				$lab_id,
				$visa_id,
				$resource_id,
				$is_active
		) );
	}
	
	public function setActive($id, $active){
		$sql = "update sy_authorization set is_active=? where id=?";
		$this->runRequest ( $sql, array (
				$is_active,
				$id
		) );
	}  
	
	public function unactivate($id){
		$sql = "update sy_authorization set is_active=0 where id=?";
		$this->runRequest ( $sql, array (
				$id
		) );
	}
	
	public function activate($id){
		$sql = "update sy_authorization set is_active=1 where id=?";
		$this->runRequest ( $sql, array (
				$id
		) );
	}
	
	public function desactivateAthorizationsForUser($userId){
		$sql="select id from sy_authorization where user_id=?";
		$req = $this->runRequest($sql, array($userId));
		$auths = $req->fetchAll();
		
		foreach ($auths as $auth){
			$this->unactivate($auth["id"]);
		}
	} 
	
	public function desactivateAthorizationsForUsers($ids){
		foreach ($ids as $id){
			$this->desactivateAthorizationsForUser($id);
		}
	}
	
	public function editAuthorization($id, $date, $user_id, $lab_id, $visa_id, $resource_id,$is_active=1) {
		$sql = "update sy_authorization set date=?, user_id=?, lab_id=?, visa_id=?, resource_id=?,
					   is_active=?	where id=?";
		$unit = $this->runRequest ( $sql, array (
				$date,
				$user_id,
				$lab_id,
				$visa_id,
				$resource_id,
				$is_active,
				$id 
		) );
	}
	public function getAuthorizations($sortentry = 'id') {
		
		$sqlSort = "sy_authorization.id";
		if ($sortentry == "date"){
			$sqlSort = "sy_authorization.date";
		}
		else if ($sortentry == "userFirstname"){
			$sqlSort = "core_users.firstname";
		}
		else if ($sortentry == "userName"){
			$sqlSort = "core_users.name";
		}
		else if ($sortentry == "unit"){
			$sqlSort = "core_units.name";
		}
		else if ($sortentry == "visa"){
			$sqlSort = "sy_visas.name";
		}
		else if ($sortentry == "ressource"){
			$sqlSort = "sy_resourcescategory.name";
		}
		
		$sql = "SELECT sy_authorization.id, sy_authorization.date, core_users.name AS userName, core_users.firstname AS userFirstname, core_units.name AS unitName, sy_visas.name AS visa, sy_resourcescategory.name AS resource 		
					from sy_authorization
					     INNER JOIN core_users on sy_authorization.user_id = core_users.id
					     INNER JOIN core_units on sy_authorization.lab_id = core_units.id
					     INNER JOIN sy_visas on sy_authorization.visa_id = sy_visas.id
					     INNER JOIN sy_resourcescategory on sy_authorization.resource_id = sy_resourcescategory.id
					ORDER BY ". $sqlSort . ";";
		$auth = $this->runRequest ( $sql );
		return $auth->fetchAll ();
	}
	
	public function getActiveAuthorizations($sortentry = 'id', $is_active=1) {
	
		$sqlSort = "sy_authorization.id";
		if ($sortentry == "date"){
			$sqlSort = "sy_authorization.date";
		}
		else if ($sortentry == "userFirstname"){
			$sqlSort = "core_users.firstname";
		}
		else if ($sortentry == "userName"){
			$sqlSort = "core_users.name";
		}
		else if ($sortentry == "unit"){
			$sqlSort = "core_units.name";
		}
		else if ($sortentry == "visa"){
			$sqlSort = "sy_visas.name";
		}
		else if ($sortentry == "ressource"){
			$sqlSort = "sy_resourcescategory.name";
		}
	
		$sql = "SELECT sy_authorization.id, sy_authorization.date, core_users.name AS userName, core_users.firstname AS userFirstname, core_units.name AS unitName, sy_visas.name AS visa, sy_resourcescategory.name AS resource
					from sy_authorization
					     INNER JOIN core_users on sy_authorization.user_id = core_users.id
					     INNER JOIN core_units on sy_authorization.lab_id = core_units.id
					     INNER JOIN sy_visas on sy_authorization.visa_id = sy_visas.id
					     INNER JOIN sy_resourcescategory on sy_authorization.resource_id = sy_resourcescategory.id
				WHERE sy_authorization.is_active=".$is_active."
				ORDER BY ". $sqlSort . ";";
		$auth = $this->runRequest ( $sql );
		return $auth->fetchAll ();
	}
	
	public function getAuthorization($id){
		$sql = "SELECT * from sy_authorization where id=?";
		$auth = $this->runRequest ( $sql, array($id) );
		return $auth->fetch();
	}
	
	public function hasAuthorization($id_resource, $id_user){
		$sql = "SELECT id from sy_authorization where user_id=? AND resource_id=? AND is_active=1";
		$data = $this->runRequest ( $sql, array($id_user, $id_resource) );
		if ($data->rowCount() >= 1)
			return true;  // get the first line of the result
		else
			return false;
		
	}
	
	public function minimalStatistics($searchDate_start, $searchDate_end, $user_id, $unit_id, 
			                          $oldunit_id, $visa_id, $resource_id){
		
		$t = array();
		$t["erreur"] = "no";
		$t["popup"] = "";
		$bilanGlobal = "";
		
		$tabDate = explode("-",$searchDate_start);
		$ddebut = $tabDate[2]."/".$tabDate[1]."/".$tabDate[0];
			
		$tabDate = explode("-",$searchDate_end);
		$dfin = $tabDate[2]."/".$tabDate[1]."/".$tabDate[0];
		
		
		$sql = 'SELECT DISTINCT user_id FROM sy_authorization WHERE date >= ? AND date <= ? ORDER BY date';
		$req = $this->runRequest($sql, array($searchDate_start, $searchDate_end));
		$numOfPeople = $req->rowCount(); // Nombre de personnes distinctes formées dans la période sélectionnée
		
		$q = array('start'=>$searchDate_start, 'end'=>$searchDate_end);
		$sql = 'SELECT id FROM sy_authorization WHERE date >= ? AND date <= ? ORDER BY date';
		$req = $this->runRequest($sql, array($searchDate_start, $searchDate_end));
		$numOfFormations = $req->rowCount(); // Nombre de formations dans la periode sélectionnée

		$q_search['start'] = $searchDate_start;
		$q_search['end'] = $searchDate_end;
		$sql_search = '';
		$sql_search_0 = 'SELECT date,user_id,lab_id,visa_id,resource_id FROM sy_authorization WHERE ';
		$sql_search_1 = 'SELECT DISTINCT user_id FROM sy_authorization WHERE ';
		$sql_search_2 = 'SELECT DISTINCT lab_id FROM sy_authorization WHERE ';
		$sql_search_3 = 'SELECT DISTINCT visa_id FROM sy_authorization WHERE ';
		$sql_search_4 = 'SELECT DISTINCT resource_id FROM sy_authorization WHERE ';
		
		$criteres = "Date begin : ".$ddebut."<br/> Date end : ".$dfin."<br/>";
		if ($user_id != "0") {
			$sql='SELECT login, name, firstname from core_users WHERE id = ?';
			$req = $this->runRequest($sql, array($user_id));
			$tmp = $req->fetchAll();
			$user = $tmp[0];
			$login = $user["login"];
			$nf = $user["name"] . " " . $user["firstname"];
					
			$q_search['user_id'] = $user_id;
			$sql_search .= 'user_id= :user_id AND ';
					
			$criteres .= "NAME Firstname : ".$nf."<br/>";
		}
		if ($oldunit_id != "0") {
			$sql='SELECT name from core_units WHERE id = ?';
			$req = $this->runRequest($sql, array($oldunit_id));
			$tmp = $req->fetchAll();
			$lab_old = $tmp[0];
			$lab_old = $lab_old["name"];
					
			$q_search['lab_old'] = $oldunit_id;
			$sql_search .= 'lab_id= :lab_old AND ';
					
			$criteres .= "Unit at training date : ".$lab_old."<br/>";
		}
		if ($unit_id != "0") {
			$q = array('id'=>$unit_id);
			$sql='SELECT name from core_units WHERE id = ?';
			$req = $this->runRequest($sql, array($unit_id));
			$tmp = $req->fetchAll();
			$laboratoire = $tmp[0];
			$laboratoire = $laboratoire["name"];
					
			$q_search['laboratoire'] = $unit_id;
			$sql_search .= 'lab_id= :laboratoire AND ';
					
			$criteres .= "Curent unit : ".$laboratoire."<br/>";
		}
		if ($visa_id != "0") {
			$sql='SELECT name from sy_visas WHERE id = ?';
			$req = $this->runRequest($sql, array($visa_id));
			$tmp = $req->fetchAll();
			$visa = $tmp[0];
			$visa = $visa["name"];
					
			$q_search['visa'] = $visa_id;
			$sql_search .= 'visa_id= :visa AND ';
					
			$criteres .= "VISA : ".$visa."\n";
		}
		if ($resource_id != "0") {
			$sql='SELECT name from sy_resourcescategory WHERE id = ?';
			$req = $this->runRequest($sql, array($resource_id));
			$tmp = $req->fetchAll();
			$machine = $tmp[0];
			$machine = $machine["name"];
					
			$q_search['machine'] = $resource_id;
			$sql_search .= 'resource_id= :machine AND ';
					
			$criteres .= "Resource : ".$machine."<br/>";
		}
		$sql_search_0 = $sql_search_0.$sql_search.'date >=:start AND date <= :end ORDER BY date';
		$req = $this->runRequest($sql_search_0, $q_search);
		$resultats = $req->fetchAll();
		$numOfRows = $req->rowCount();
		// Lister les personnes disctinctes
		$sql_search_1 = $sql_search_1.$sql_search.'date >=:start AND date <= :end ORDER BY date';
		$req = $this->runRequest($sql_search_1, $q_search);
		$res_distinct_nf = $req->fetchAll();
		$distinct_nf = $req->rowCount();
		$new_people = 0;
		foreach($res_distinct_nf as $rDN) {
			$nf = $rDN[0];
			$q = array('start'=>$searchDate_start, 'user_id'=>$nf);
			$sql = 'SELECT id FROM sy_authorization WHERE user_id=:user_id AND date<:start ORDER BY date';
			$req = $this->runRequest($sql, $q);
			$num = $req->rowCount();
			if ($num == 0) {
				$new_people++;
			}
		}
		$sql_search_2 = $sql_search_2.$sql_search.'date >=:start AND date <= :end ORDER BY date';
		$req = $this->runRequest($sql_search_2, $q_search);
		$distinct_laboratoire = $req->rowCount();
		
		$sql_search_3 = $sql_search_3.$sql_search.'date >=:start AND date <= :end ORDER BY date';
		$req = $this->runRequest($sql_search_3, $q_search);
		$distinct_visa = $req->rowCount();
		
		$sql_search_4 = $sql_search_4.$sql_search.'date >=:start AND date <= :end ORDER BY date';
		$req = $this->runRequest($sql_search_4, $q_search);
		$distinct_machine = $req->rowCount();
		
		if ($numOfRows == 0) {
			$t["erreur"] = "yes";
			if ($ddebut == $dfin) {
				$t["popup"]="No training found during the day ".$ddebut;
			} else {
				$t["popup"]="No training found from ".$ddebut." to ".$dfin;
			}
		} else {
			$t["erreur"] = "no";
			$t["ddebut"]= $ddebut;
			$t["dfin"]= $dfin;
			$t["numOfPeople"] = $numOfPeople;
			$t["numOfFormations"] = $numOfFormations;
				
			if ($numOfPeople > 1){
				$bilanGlobal .= '('.$numOfPeople.' users for '.$numOfFormations;
			} else {
				$bilanGlobal .= $numOfPeople.' users for '.$numOfFormations;
			}
			if ($numOfFormations > 1){
				$bilanGlobal .= ' trainings)';
			} else {
				$bilanGlobal .= ' training)';
			}
					
			$t["bilanGlobal"] = $bilanGlobal;
					
			$t["numOfRows"] = $numOfRows;
					
			$i = 0;
			foreach($resultats as $res) {
				$mat[$i][0] = $res[0]; // date
				$mat[$i][1] = $res[1]; // nf
				$mat[$i][2] = $res[2]; // laboratoire
				$mat[$i][3] = $res[3]; // visa
				$mat[$i][4] = $res[4]; // machine
				$i++;
			}
			$t["mat"] = $mat;
					
			$t["distinct_nf"] = $distinct_nf;
			$t["distinct_laboratoire"] = $distinct_laboratoire;
			$t["distinct_visa"] = $distinct_visa;
			$t["distinct_machine"] = $distinct_machine;
			$t["new_people"] = $new_people;
					
			$t["criteres"] = $criteres;
					
					
		}
		return $t;
	}
	
	public function statsDetails($searchDate_start, $searchDate_end, $user_id, $unit_id, 
			                     $oldunit_id, $visa_id, $resource_id){
		
		$t = array();
		$t["erreur"] = "no";
		$t["erreurLogin"] = "no";
		$t["popup"] = "";
		
		$tabDate = explode("-",$searchDate_start);
		$date_debut = $tabDate[2].'/'.$tabDate[1].'/'.$tabDate[0];
		
		$tabDate = explode("-",$searchDate_end);
		$date_fin = $tabDate[2].'/'.$tabDate[1].'/'.$tabDate[0];
		
		$nf = $user_id;
		$laboratoire = $unit_id;
		$visa = $visa_id;
		$machine = $resource_id;
		
		$req = null;
		$nom_fic = "";
		if(($nf == "0") && ($laboratoire == "0") && ($visa == "0") && ($machine == "0")) {
			$q = array('start'=>$searchDate_start, 'end'=>$searchDate_end);
			$sql = 'SELECT DISTINCT user_id FROM sy_authorization WHERE date >=:start AND date <= :end ORDER BY date, user_id';
			$req = $this->runRequest($sql, $q);
			$numOfPeople = $req->rowCount();
		
			$q = array('start'=>$searchDate_start, 'end'=>$searchDate_end);
			$sql = 'SELECT date,user_id,lab_id,visa_id,resource_id FROM sy_authorization WHERE date >=:start AND date <= :end ORDER BY date, user_id';
			$req = $this->runRequest($sql, $q);		
		
			$nom_fic = "total_autorisations.csv";
		}
		
		else if (($nf != "0")) {
			$q = array('id'=>$user_id);
			$sql='SELECT login, name, firstname from core_users WHERE id = :id';
			$req = $this->runRequest($sql, $q);
			$user = $req->fetchAll();
			$login = $user[0][0];
			$nf = $user[0][1] . " " . $user[0][2];
		
			$q = array('start'=>$searchDate_start, 'end'=>$searchDate_end, 'user_id'=>$user_id);
			$sql = 'SELECT date,user_id,lab_id,visa_id,resource_id FROM sy_authorization WHERE user_id= :user_id AND date >=:start AND date<=:end order by date, user_id';
			$req = $this->runRequest($sql, $q);
		
			$nom_fic = $login."_authorization.csv";
		}
		
		else if ($laboratoire != "0") {

			$q = array('start'=>$searchDate_start, 'end'=>$searchDate_end, 'laboratoire'=>$unit_id);
			$sql = 'SELECT date,user_id,lab_id,visa_id,resource_id FROM sy_authorization WHERE lab_id= :laboratoire AND date >=:start AND date<=:end order by date,user_id';
			$req = $this->runRequest($sql, $q);
		
			$nom_fic = "unit_authorization.csv";
		}
		
		else if ($visa != "0") {
	
			$q = array('start'=>$searchDate_start, 'end'=>$searchDate_end, 'visa'=>$visa);
			$sql = 'SELECT date,user_id,lab_id,visa_id,resource_id FROM sy_authorization WHERE visa_id= :visa AND date >=:start AND date<=:end order by date,user_id';
			$req = $this->runRequest($sql, $q);
		
			$nom_fic = "visa_authorization.csv";
		}
		else if ($machine != "0") {
		
			$q = array('start'=>$searchDate_start, 'end'=>$searchDate_end, 'machine'=>$machine);
			$sql = 'SELECT date,user_id,lab_id,visa_id,resource_id FROM sy_authorization WHERE resource_id= :machine AND date >=:start AND date<=:end order by date,user_id';
			$req = $this->runRequest($sql, $q);
		
			$nom_fic = "resource_authorization.csv";
		}
		
		$numOfRows = $req->rowCount();
		
		if ($numOfRows == 0) {
			$t["erreur"] = "yes";
			$t["erreurLogin"]="The query returns zero results !";
		} else {
			$data = $req->fetchAll();
			$datas = array();
		
			$modelResp = new Responsible();
			$modelUser = new User();
			$modelUnit = new Unit();
			$modelVisa = new SyVisa();
			$modelResource = new SyResourcesCategory();
			foreach($data as $d){
				
				$respInfo = $modelResp->getUserResponsible($d[1]);
				$responsable = $respInfo["name"] . " " . $respInfo["firstname"];  
					
				$visas = $modelVisa->getVisaName($d[3]);
				$machines = $modelResource->getResourcesCategoryName($d[4]);	
				$datas[] = array(
						'Date' 			=> $d[0],
						'Utilisateur' 	=> $modelUser->getUserFUllName($d[1]),
						'Laboratoire' 	=> $modelUnit->getUnitName($d[2]),
						'Visa' 			=> $visas[0],
						'machine' 		=> $machines[0],
						'responsable'   => $responsable
				);
			}
			$t['nom_fic'] = $nom_fic;
			$t["data"] = $datas;
		}
		return $t;
	}
	
	public function statsResources($searchDate_start, $searchDate_end){
		
		$q = array( "start" => $searchDate_start, "end" => $searchDate_end);
		$sql = 'SELECT id FROM sy_authorization WHERE date >=:start AND date <=:end';
		$req = $this->runRequest($sql, $q);
		$numTotal = $req->rowCount(); // Nombre de personnes distinctes formées dans la période sélectionnée
		
		$sql = 'SELECT DISTINCT resource_id FROM sy_authorization WHERE date >=:start AND date <=:end';
		$req = $this->runRequest($sql, $q);
		$numMachinesFormesTotal = $req->rowCount(); // Nombre de personnes distinctes formées da,s la période sélectionnée
		$machinesFormesListe = $req->fetchAll();
		
		$i = 0;
		$numMachinesFormes=array();
		$angle = 0;
		$departX = 300+250*cos(0);
		$departY = 330-250*sin(0);
		
		$test  = '<g fill="rgb(97, 115, 169)">';
		$test .= '<title>Formations</title>';
		$test .= '<desc>Formations</desc>';
		$test .= '<rect x="0" y="0" width="900" height="600" fill="white" stroke="black" stroke-width="0"/>';
		$test .= '<g>';
		$test .= '<text x="450" y="40" font-size="20" fill="black" stroke="none" text-anchor="middle">Training for each resource from '.$searchDate_start.' to '.$searchDate_end.'</text>';
		$test .= '</g>';
		$couleur = array("#FC441D","#FE8D11","#FCC212","#6AC720","#53D745","#156947","#291D81","#804DA4","#E4AADF","#FF77EE");
		
		$modelResouces = new SyResourcesCategory();
		
		foreach($machinesFormesListe as $mFL) {
			$q = array( "start" => $searchDate_start, "end" => $searchDate_end);
			$sql = 'SELECT id FROM sy_authorization WHERE date >=:start AND date <=:end AND resource_id="'.$mFL[0].'"';
			$req = $this->runRequest($sql, $q);
			$tmp = $modelResouces->getResourcesCategoryName($mFL[0]);
			$numMachinesFormes[0][$i] = $tmp[0];
			$numMachinesFormes[1][$i] = $req->rowCount();
			$i++;
		}
		array_multisort($numMachinesFormes[1],SORT_DESC,$numMachinesFormes[0]);
		
		$test_jpg = $test;
		for ($i = 0; $i < $numMachinesFormesTotal; $i++){
			$angle += 2*pi()*$numMachinesFormes[1][$i]/$numTotal;
			$arriveeX = 300+250*cos($angle);
			$arriveeY = 330-250*sin($angle);
			$test .= '<path d="M '.$departX.' '.$departY.' A 250 250 0 0 0 '.$arriveeX.' '.$arriveeY.' L 300 330" fill="'.$couleur[$i].'" stroke="black"/>';
			$test .= '<g>';
			$test .= '<rect x="580" y="'.(100+25*$i).'" width="30" height="12" rx="5" ry="5" fill="'.$couleur[$i].'" stroke="'.$couleur[$i].'" stroke-width="2"/>';
			$test .= '<text x="625" y="'.(100+25*$i).'" font-size="19" fill="black" stroke="none" text-anchor="start" baseline-shift="-12px">'.$numMachinesFormes[0][$i].' :</text>';
			$test .= '<text x="820" y="'.(100+25*$i).'" font-size="19" fill="black" stroke="none" text-anchor="start" baseline-shift="-12px">'.$numMachinesFormes[1][$i].'</text>';
			$test .= '</g>';
				
			$departX = $arriveeX;
			$departY = $arriveeY;
		
		}
		
		$test .= '</g>';
		
		$camembert = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 900 600" width="600" height="350" font-family="Verdana">';
		$camembert .= '<title>Formations</title>';
		$camembert .= '<desc>Formations</desc>';
		$camembert .= $test;		
		$camembert .= '</svg>';
		return $camembert;
	}
	
	public function getActiveAuthorizationForResourceCategory($resource_id){
		$sql = "SELECT sy_authorization.id, sy_authorization.date, core_users.name AS userName, core_users.firstname AS userFirstname, core_units.name AS unitName, sy_visas.name AS visa, sy_resourcescategory.name AS resource 		
					from sy_authorization
					     INNER JOIN core_users on sy_authorization.user_id = core_users.id
					     INNER JOIN core_units on sy_authorization.lab_id = core_units.id
					     INNER JOIN sy_visas on sy_authorization.visa_id = sy_visas.id
					     INNER JOIN sy_resourcescategory on sy_authorization.resource_id = sy_resourcescategory.id
				WHERE sy_authorization.resource_id=? 
				ORDER BY core_users.name;";
		$req = $this->runRequest($sql, array($resource_id));
		return $req->fetchAll();
	}
}
