<?php

require_once 'Framework/Model.php';

/**
 * Class defining the Sygrrif graph model
 *
 * @author Sylvain Prigent
 */
class SyGraph extends Model {


	/**
	 * Generate a graph containing the number of reservation per month
	 * @param unknown $year
	 * @return multitype:multitype:unknown  number
	 */
	public function getYearNumResGraph($month_start, $year_start, $month_end, $year_end){
		
		$num = 0;
		$numTotal = 0;
		$graph = array();
		$monthIds = array();
		$i = 0;
		for ($y = $year_start ; $y <= $year_end ; $y++){
			// start month
			$start_month = 1;
			if ($y == $year_start){
				$start_month = $month_start;
			}
			// end month
			$stop_month = 12;
			if ($y == $year_end){
				$stop_month = $month_end;
			}
			for ($m = $start_month ; $m <= $stop_month ; $m++){
				$dstart= mktime(0,0,0,$m,1,$y); // Le premier jour du mois en cours
				$dend= mktime(0,0,0,$m+1,1,$y); // Le 0eme jour du mois suivant == le dernier jour du mois en cour
				
				//$q = array('start'=>$dstart, 'end'=>$dend);
				$sql = 'SELECT * FROM sy_calendar_entry WHERE start_time >= '.$dstart.' AND start_time <= '.$dend.' ORDER BY id';
				$req = $this->runRequest($sql);
					
				$num = $req->rowCount(); // Nombre de réservations dans la période sélectionnée
				$i++;
				$numTotal += $num;
				$graph[$i]=$num;
				$monthIds[$i] = $m;
			}
		}
		
		$graphData = array('numTotal' => $numTotal, 'graph' => $graph, 'monthIds' => $monthIds);
		return $graphData;
	}
	
	/**
	 * Generate a graph containing the number of hours of reservation per year
	 * @param unknown $year
	 * @return multitype:number multitype:number
	 */
	public function getYearNumHoursResGraph($month_start, $year_start, $month_end, $year_end){
	
		$timeResa = 0.0;
		$timeTotal = 0.0;
		$graph = array();
		$monthIds = array();
		$i = 0;
		for ($y = $year_start ; $y <= $year_end ; $y++){
			// start month
			$start_month = 1;
			if ($y == $year_start){
				$start_month = $month_start;
			}
			// end month
			$stop_month = 12;
			if ($y == $year_end){
				$stop_month = $month_end;
			}
			for ($m = $start_month ; $m <= $stop_month ; $m++){
				$dstart= mktime(0,0,0,$m,1,$y); // Le premier jour du mois en cours
				$dend= mktime(0,0,0,$m+1,1,$y); // Le 0eme jour du mois suivant == le dernier jour du mois en cour
				
				//$q = array('start'=>$dstart, 'end'=>$dend);
				$sql = 'SELECT * FROM sy_calendar_entry WHERE start_time >= '.$dstart.' AND start_time <= '.$dend.' ORDER BY id';
				$req = $this->runRequest($sql);
				$datas = $req->fetchAll();
					
				$timeResa = 0;
				foreach ($datas as $data){
					if ($data["end_time"] - $data["start_time"] >= 0){
						$timeResa += (float)($data["end_time"] - $data["start_time"]) / (float)3600;
					}
					else{
						echo "WARNING: error in reservation : <br/>";
						print_r($data);
					}
				}
				$i++;
				$timeTotal += $timeResa;
				$graph[$i]=$timeResa;
				$monthIds[$i] = $m;
			}
		}
	
		$graphData = array('timeTotal' => $timeTotal, 'graph' => $graph, 'monthIds' => $monthIds);
		return $graphData;
	}
	
	/**
	 * Generate a pie chart number of reservation per resource
	 * @param number $year
	 * @return unknown
	 */
	public function getCamembertArray($month_start, $year_start, $month_end, $year_end){
		$sql = 'SELECT DISTINCT resource_id FROM sy_calendar_entry WHERE start_time >='.mktime(0,0,0,$month_start,1,$year_start).' AND end_time <='.mktime(0,0,0,$month_end+1,0,$year_end).' ORDER by resource_id';
		$req = $this->runRequest($sql);
		$numMachinesFormesTotal = $req->rowCount();
		$machinesFormesListe = $req->fetchAll();
		
		$machineFormes = array();
		$i = -1;
		foreach($machinesFormesListe as $mFL) {
			$i++;
			$sql = 'SELECT * FROM sy_calendar_entry WHERE start_time >='.mktime(0,0,0,$month_start,1,$year_start).' AND end_time <='.mktime(0,0,0,$month_end+1,1,$year_end).' AND resource_id ="'.$mFL[0].'"';
			$req = $this->runRequest($sql);
			$numMachinesFormes[$i][0] = $mFL[0];
			$numMachinesFormes[$i][1] = $req->rowCount();
			
			$sql = 'SELECT name FROM sy_resources WHERE id ="'.$mFL[0].'"';
			$req = $this->runRequest($sql);
			$res = $req->fetchAll();
			$nomMachine = "-";
			if (count($res) > 0){
				$nomMachine = $res[0][0];
			}

			$numMachinesFormes[$i][0] = $nomMachine;
			
		}
		return $numMachinesFormes;
	}
	
	/**
	 * Generate a pie chart number of hours of reservation per resource
	 * @param unknown $year
	 * @return unknown
	 */
	public function getCamembertTimeArray($month_start, $year_start, $month_end, $year_end){
		$sql = 'SELECT DISTINCT resource_id FROM sy_calendar_entry WHERE start_time >='.mktime(0,0,0,$month_start,1,$year_start).' AND end_time <='.mktime(0,0,0,$month_end+1,0,$year_end).' ORDER by resource_id';
		$req = $this->runRequest($sql);
		$numMachinesFormesTotal = $req->rowCount();
		$machinesFormesListe = $req->fetchAll();
		
		$i=-1;
		foreach($machinesFormesListe as $mFL) {
			$i++;
			$sql = 'SELECT * FROM sy_calendar_entry WHERE start_time >='.mktime(0,0,0,$month_start,1,$year_start).' AND end_time <='.mktime(0,0,0,$month_end+1,1,$year_end).' AND resource_id ="'.$mFL[0].'"';
			$req = $this->runRequest($sql);
				
			$resas = $req->fetchAll();
			$timeResa = 0.0;
			foreach($resas as $resa){
				$timeResa += (float)($resa["end_time"] - $resa["start_time"]) / (float)3600;
			}
			$numMachinesFormes[$i][1] = $timeResa;
			
			$sql = 'SELECT name FROM sy_resources WHERE id ="'.$mFL[0].'"';
			$req = $this->runRequest($sql);
			$res = $req->fetchAll();
			$nomMachine = "-";
			if (count($res) > 0){
				$nomMachine = $res[0][0];
			}
			
			$numMachinesFormes[$i][0] = $nomMachine;
		}
		
		return $numMachinesFormes;
	}
	
	/**
	 * Generate a pie chart number of reservation per resource
	 * @param unknown $year
	 * @param unknown $numTotal
	 * @return string
	 */
	public function getCamembertContent($month_start, $year_start, $month_end, $year_end, $numTotal){
		$sql = 'SELECT DISTINCT resource_id FROM sy_calendar_entry WHERE start_time >='.mktime(0,0,0,$month_start,1,$year_start).' AND end_time <='.mktime(0,0,0,$month_end+1,0,$year_end).' ORDER by resource_id';
		$req = $this->runRequest($sql);
		$numMachinesFormesTotal = $req->rowCount();
		$machinesFormesListe = $req->fetchAll();
		
		$i = 0;
		$numMachinesFormes=array();
		$angle = 0;
		$departX = 300+250*cos(0);
		$departY = 300-250*sin(0);
		
		$test  = '<g fill="rgb(97, 115, 169)">';
		$test .= '<title>Réservations</title>';
		$test .= '<desc>287</desc>';
		$test .= '<rect x="0" y="0" width="1000" height="600" fill="white" stroke="black" stroke-width="0"/>';
		$couleur = array("#FC441D","#FE8D11","#FCC212","#FFFD32","#D0E92B","#53D745","#6AC720","#156947","#291D81","#804DA4","#E4AADF","#A7194B","#FE0000",
				         "#FC441D","#FE8D11","#FCC212","#FFFD32","#D0E92B","#53D745","#6AC720","#156947","#291D81","#804DA4","#E4AADF","#A7194B","#FE0000"
		);
	
		foreach($machinesFormesListe as $mFL) {
			$sql = 'SELECT * FROM sy_calendar_entry WHERE start_time >='.mktime(0,0,0,$month_start,1,$year_start).' AND end_time <='.mktime(0,0,0,$month_end+1,1,$year_end).' AND resource_id ="'.$mFL[0].'"';
			$req = $this->runRequest($sql);
			$numMachinesFormes[$i][0] = $mFL[0];
			$numMachinesFormes[$i][1] = $req->rowCount();
			
			$curentAngle = 2*pi()*$numMachinesFormes[$i][1]/$numTotal; 
			
			if ($curentAngle > pi()){
				
				$angle += $curentAngle/2;
				
				$arriveeX = 300+250*cos($angle);
				$arriveeY = 300-250*sin($angle);
				
				$test .= '<path d="M '.$departX.' '.$departY.' A 250 250 0 0 0 '.$arriveeX.' '.$arriveeY.' L 300 300" fill="'.$couleur[$i].'" stroke="black" stroke-width="0"  />';
				$test .= '<g>';
				
				$departX = $arriveeX;
				$departY = $arriveeY;
				$angle += $curentAngle/2;
			}
			else{
				$angle += $curentAngle;
			}
			
			$arriveeX = 300+250*cos($angle);
			$arriveeY = 300-250*sin($angle);
			
			$test .= '<path d="M '.$departX.' '.$departY.' A 250 250 0 0 0 '.$arriveeX.' '.$arriveeY.' L 300 300" fill="'.$couleur[$i].'"/>';
			$test .= '<g>';
			$test .= '<rect x="580" y="'.(83+40*$i).'" width="30" height="20" rx="5" ry="5" fill="'.$couleur[$i].'" stroke="'.$couleur[$i].'" stroke-width="0"/>';
				
			$sql = 'SELECT name FROM sy_resources WHERE id ="'.$mFL[0].'"';
			$req = $this->runRequest($sql);
			$res = $req->fetchAll();
			$nomMachine = "-";
			if (count($res) > 0){
				$nomMachine = $res[0][0];
			}
				
			$test .= '<text x="615" y="'.(90+40*$i).'" font-size="25" fill="black" stroke="none" text-anchor="start" baseline-shift="-11px">'.$nomMachine.' : '.$numMachinesFormes[$i][1].'</text>';
			$test .= '</g>';
		
		
			$departX = $arriveeX;
			$departY = $arriveeY;
			$i++;
		}
		
		$test .= '</g>';
		return $test;
		
	}
	
	/**
	 * Generate a pie chart number of reservation per resource
	 * @param unknown $year
	 * @param unknown $numTotal
	 * @return string
	 */
	public function getCamembertContentResourceType($month_start, $year_start, $month_end, $year_end, $numTotal){
		$sql = 'SELECT DISTINCT resource_id FROM sy_calendar_entry WHERE start_time >='.mktime(0,0,0,$month_start,1,$year_start).' AND end_time <='.mktime(0,0,0,$month_end+1,0,$year_end).' ORDER by resource_id';
		$req = $this->runRequest($sql);
		$numMachinesFormesTotal = $req->rowCount();
		$machinesFormesListe = $req->fetchAll();
		
		for($m = 0 ; $m < count($machinesFormesListe) ; $m++) {
			$sql = 'SELECT category_id from sy_resources WHERE id=?';
			$req = $this->runRequest($sql, array($machinesFormesListe[$m]["resource_id"]));
			$val = $req->fetch();
			$machinesFormesListe[$m]["category_id"] = $val[0];
		}
		
		$sql = 'SELECT * from sy_resourcescategory ORDER BY name ASC;';
		$req = $this->runRequest($sql);
		$resourceTypeList = $req->fetchAll();
	
		$i = 0;
		$numMachinesFormes=array();
		$angle = 0;
		$departX = 300+250*cos(0);
		$departY = 300-250*sin(0);
	
		$test  = '<g fill="rgb(97, 115, 169)">';
		$test .= '<title>Réservations</title>';
		$test .= '<desc>287</desc>';
		$test .= '<rect x="0" y="0" width="1000" height="600" fill="white" stroke="black" stroke-width="0"/>';
		$couleur = array("#FC441D","#FE8D11","#FCC212","#FFFD32","#D0E92B","#53D745","#6AC720","#156947","#291D81","#804DA4","#E4AADF","#A7194B","#FE0000",
				"#FC441D","#FE8D11","#FCC212","#FFFD32","#D0E92B","#53D745","#6AC720","#156947","#291D81","#804DA4","#E4AADF","#A7194B","#FE0000"
		);
	
		for($i = 0 ; $i < count($resourceTypeList) ; $i++){
			
			$resTypID = $resourceTypeList[$i]["id"];
			$count = 0;
			foreach($machinesFormesListe as $mFL) {

				if ($mFL["category_id"] == $resTypID){
					$sql = 'SELECT * FROM sy_calendar_entry WHERE start_time >='.mktime(0,0,0,$month_start,1,$year_start).' AND end_time <='.mktime(0,0,0,$month_end+1,1,$year_end).' AND resource_id ="'.$mFL[0].'"';
					$req = $this->runRequest($sql);
					$count += $req->rowCount();
				}
				
			}
			$resourceTypeList[$i]["number_resa"] = $count;
			
			$curentAngle = 2*pi()*$resourceTypeList[$i]["number_resa"]/$numTotal;
			
			if ($curentAngle > pi()){
			
				$angle += $curentAngle/2;
			
				$arriveeX = 300+250*cos($angle);
				$arriveeY = 300-250*sin($angle);
			
				$test .= '<path d="M '.$departX.' '.$departY.' A 250 250 0 0 0 '.$arriveeX.' '.$arriveeY.' L 300 300" fill="'.$couleur[$i].'" stroke="black" stroke-width="0"  />';
				$test .= '<g>';
			
				$departX = $arriveeX;
				$departY = $arriveeY;
				$angle += $curentAngle/2;
			}
			else{
				$angle += $curentAngle;
			}
			
			$arriveeX = 300+250*cos($angle);
			$arriveeY = 300-250*sin($angle);
			
			$test .= '<path d="M '.$departX.' '.$departY.' A 250 250 0 0 0 '.$arriveeX.' '.$arriveeY.' L 300 300" fill="'.$couleur[$i].'"/>';
			$test .= '<g>';
			$test .= '<rect x="580" y="'.(83+40*$i).'" width="30" height="20" rx="5" ry="5" fill="'.$couleur[$i].'" stroke="'.$couleur[$i].'" stroke-width="0"/>';
			
			$nomMachine = $resourceTypeList[$i]["name"];
			$test .= '<text x="615" y="'.(90+40*$i).'" font-size="25" fill="black" stroke="none" text-anchor="start" baseline-shift="-11px">'.$nomMachine.' : '.$resourceTypeList[$i]["number_resa"].'</text>';
			$test .= '</g>';
			
			
			$departX = $arriveeX;
			$departY = $arriveeY;
		}	

		$test .= '</g>';
		return $test;
	}
	
	/**
	 * Generate a pie chart time of reservation per resource
	 * @param unknown $year
	 * @param unknown $numTotal
	 * @return string
	 */
	public function getCamembertTimeContentResourceType($month_start, $year_start, $month_end, $year_end, $numTotal){
		$sql = 'SELECT DISTINCT resource_id FROM sy_calendar_entry WHERE start_time >='.mktime(0,0,0,$month_start,1,$year_start).' AND end_time <='.mktime(0,0,0,$month_end+1,0,$year_end).' ORDER by resource_id';
		$req = $this->runRequest($sql);
		$numMachinesFormesTotal = $req->rowCount();
		$machinesFormesListe = $req->fetchAll();
		
		for($m = 0 ; $m < count($machinesFormesListe) ; $m++) {
			$sql = 'SELECT category_id from sy_resources WHERE id=?';
			$req = $this->runRequest($sql, array($machinesFormesListe[$m]["resource_id"]));
			$val = $req->fetch();
			$machinesFormesListe[$m]["category_id"] = $val[0];
		}
		
		$sql = 'SELECT * from sy_resourcescategory ORDER BY name ASC;';
		$req = $this->runRequest($sql);
		$resourceTypeList = $req->fetchAll();
	
		$i = 0;
		$numMachinesFormes=array();
		$angle = 0;
		$departX = 300+250*cos(0);
		$departY = 300-250*sin(0);
	
		$test  = '<g fill="rgb(97, 115, 169)">';
		$test .= '<title>Réservations</title>';
		$test .= '<desc>287</desc>';
		$test .= '<rect x="0" y="0" width="1000" height="600" fill="white" stroke="black" stroke-width="0"/>';
		$couleur = array("#FC441D","#FE8D11","#FCC212","#FFFD32","#D0E92B","#53D745","#6AC720","#156947","#291D81","#804DA4","#E4AADF","#A7194B","#FE0000",
				         "#FC441D","#FE8D11","#FCC212","#FFFD32","#D0E92B","#53D745","#6AC720","#156947","#291D81","#804DA4","#E4AADF","#A7194B","#FE0000"
		);
		
		
		
		for($i = 0 ; $i < count($resourceTypeList) ; $i++){
				
			$resTypID = $resourceTypeList[$i]["id"];
			$timeResa = 0;
			foreach($machinesFormesListe as $mFL) {
		
				if ($mFL["category_id"] == $resTypID){
					$sql = 'SELECT * FROM sy_calendar_entry WHERE start_time >='.mktime(0,0,0,$month_start,1,$year_start).' AND end_time <='.mktime(0,0,0,$month_end+1,1,$year_end).' AND resource_id ="'.$mFL[0].'"';
					$req = $this->runRequest($sql);
					$numMachinesFormes[$i][0] = $mFL[0];
						
					$resas = $req->fetchAll();
					foreach($resas as $resa){
						$timeResa += (float)($resa["end_time"] - $resa["start_time"]) / (float)3600;
					}
				}
			}
			
			$curentAngle = 2*pi()*$timeResa/$numTotal;
			
			if ($curentAngle > pi()){
			
				$angle += $curentAngle/2;
			
				$arriveeX = 300+250*cos($angle);
				$arriveeY = 300-250*sin($angle);
			
				$test .= '<path d="M '.$departX.' '.$departY.' A 250 250 0 0 0 '.$arriveeX.' '.$arriveeY.' L 300 300" fill="'.$couleur[$i].'" stroke="black" stroke-width="0"  />';
				$test .= '<g>';
			
				$departX = $arriveeX;
				$departY = $arriveeY;
				$angle += $curentAngle/2;
			}
			else{
				$angle += $curentAngle;
			
			}
			
			$arriveeX = 300+250*cos($angle);
			$arriveeY = 300-250*sin($angle);
			
			$test .= '<path d="M '.$departX.' '.$departY.' A 250 250 0 0 0 '.$arriveeX.' '.$arriveeY.' L 300 300" fill="'.$couleur[$i].'"/>';
			$test .= '<g>';
			$test .= '<rect x="580" y="'.(83+40*$i).'" width="30" height="20" rx="5" ry="5" fill="'.$couleur[$i].'" stroke="'.$couleur[$i].'" stroke-width="0"/>';
			
			$sql = 'SELECT name FROM sy_resources WHERE id ="'.$mFL[0].'"';
			$req = $this->runRequest($sql);
			$res = $req->fetchAll();
			$nomMachine = $resourceTypeList[$i]["name"];
			
			$test .= '<text x="615" y="'.(90+40*$i).'" font-size="25" fill="black" stroke="none" text-anchor="start" baseline-shift="-11px">'.$nomMachine.' : '.$timeResa.'</text>';
			$test .= '</g>';
			
			$departX = $arriveeX;
			$departY = $arriveeY;
		}
		
	
		$test .= '</g>';
		return $test;
	
	}
	
	/**
	 * Generate a pie chart time of reservation per resource
	 * @param unknown $year
	 * @param unknown $numTotal
	 * @return string
	 */
	public function getCamembertTimeContent($month_start, $year_start, $month_end, $year_end, $numTotal){
		$sql = 'SELECT DISTINCT resource_id FROM sy_calendar_entry WHERE start_time >='.mktime(0,0,0,$month_start,1,$year_start).' AND end_time <='.mktime(0,0,0,$month_end+1,0,$year_end).' ORDER by resource_id';
		$req = $this->runRequest($sql);
		$numMachinesFormesTotal = $req->rowCount();
		$machinesFormesListe = $req->fetchAll();
	
		$i = 0;
		$numMachinesFormes=array();
		$angle = 0;
		$departX = 300+250*cos(0);
		$departY = 300-250*sin(0);
	
		$test  = '<g fill="rgb(97, 115, 169)">';
		$test .= '<title>Réservations</title>';
		$test .= '<desc>287</desc>';
		$test .= '<rect x="0" y="0" width="1000" height="600" fill="white" stroke="black" stroke-width="0"/>';
		$couleur = array("#FC441D","#FE8D11","#FCC212","#FFFD32","#D0E92B","#53D745","#6AC720","#156947","#291D81","#804DA4","#E4AADF","#A7194B","#FE0000",
				"#FC441D","#FE8D11","#FCC212","#FFFD32","#D0E92B","#53D745","#6AC720","#156947","#291D81","#804DA4","#E4AADF","#A7194B","#FE0000"
		);
		foreach($machinesFormesListe as $mFL) {
			$sql = 'SELECT * FROM sy_calendar_entry WHERE start_time >='.mktime(0,0,0,$month_start,1,$year_start).' AND end_time <='.mktime(0,0,0,$month_end+1,1,$year_end).' AND resource_id ="'.$mFL[0].'"';
			$req = $this->runRequest($sql);
			$numMachinesFormes[$i][0] = $mFL[0];
				
			$resas = $req->fetchAll();
			$timeResa = 0.0;
			foreach($resas as $resa){
				$timeResa += (float)($resa["end_time"] - $resa["start_time"]) / (float)3600;
			}
			$numMachinesFormes[$i][1] = $timeResa;
	
			$curentAngle = 2*pi()*$numMachinesFormes[$i][1]/$numTotal;
	
			if ($curentAngle > pi()){
	
				$angle += $curentAngle/2;
	
				$arriveeX = 300+250*cos($angle);
				$arriveeY = 300-250*sin($angle);
	
				$test .= '<path d="M '.$departX.' '.$departY.' A 250 250 0 0 0 '.$arriveeX.' '.$arriveeY.' L 300 300" fill="'.$couleur[$i].'" stroke="black" stroke-width="0"  />';
				$test .= '<g>';
	
				$departX = $arriveeX;
				$departY = $arriveeY;
				$angle += $curentAngle/2;
			}
			else{
				$angle += $curentAngle;
	
			}
	
			$arriveeX = 300+250*cos($angle);
			$arriveeY = 300-250*sin($angle);
	
			$test .= '<path d="M '.$departX.' '.$departY.' A 250 250 0 0 0 '.$arriveeX.' '.$arriveeY.' L 300 300" fill="'.$couleur[$i].'"/>';
			$test .= '<g>';
			$test .= '<rect x="580" y="'.(83+40*$i).'" width="30" height="20" rx="5" ry="5" fill="'.$couleur[$i].'" stroke="'.$couleur[$i].'" stroke-width="0"/>';
	
			$sql = 'SELECT name FROM sy_resources WHERE id ="'.$mFL[0].'"';
			$req = $this->runRequest($sql);
			$res = $req->fetchAll();
			$nomMachine = "-";
			if (count($res) > 0){
				$nomMachine = $res[0][0];
			}
	
			$test .= '<text x="615" y="'.(90+40*$i).'" font-size="25" fill="black" stroke="none" text-anchor="start" baseline-shift="-11px">'.$nomMachine.' : '.$numMachinesFormes[$i][1].'</text>';
			$test .= '</g>';
	
	
			$departX = $arriveeX;
			$departY = $arriveeY;
			$i++;
		}
	
		$test .= '</g>';
		return $test;
	
	}
}

