<?php

require_once 'Framework/Model.php';

/**
 * Class defining the GRR area model
 *
 * @author Sylvain Prigent
 */
class Pr_stat extends Model {

	public function reportstats($datebegin, $dateend, $champ, $type_recherche, $text, $contition_et_ou){
		
		
		$sql = "SELECT distinct e.id, e.start_time, e.end_time, e.acronyme, e.codeanonyma, e.numerovisite, "
				. "e.color_type_id, e.recipient_id, "
				. "a.name as area_name, r.name as resource, r.description, a.id as area, u.login, c.name color"
				. " FROM reservation e, sy_areas a, sy_resources r, core_users u, sy_color_codes c "
				. " WHERE e.resource_id = r.id  AND u.id = e.recipient_id AND r.area_id = a.id AND c.id = e.color_type_id"		
				. " AND e.start_time >= " . $datebegin . " AND e.end_time <= " .$dateend . " ";
		
		//echo "contition_et_ou = " . $contition_et_ou . "<br/>";
		
		$sql .= " AND (";
		$first = true;
		for($i = 0 ; $i < count($champ) ; $i++){
			
			if( $text[$i] != "" ){
				
				if(!$first){
					$sql .= " " . $contition_et_ou . " ";
				}
				if ($first){
					$first = false;
				}
				
				
				$sql .= $this->extractQueryFrom( $champ[$i], $text[$i], $type_recherche[$i] );
			}
		}
		$sql .= ")";
		//echo "sql = " . $sql . "<br/>";
		//return;
		
		$data = $this->runRequest($sql);
		return $data->fetchAll();
	}
	
	private function extractQueryFrom($champ, $text, $type_recherche){
		
		$like = " LIKE ";
		if( $type_recherche == 0 ){
			$like = " NOT LIKE ";
		}
		
		if ( $champ == "area" ){
			return " a.name = " . $text;
		}
		if ($champ == "resource"){
			return " r.name ". $like ." '%" . $text . "%'";
		}
		if ($champ == "color_code"){
			return " c.name ". $like ." '%" . $text . "%'";
		}
		if ($champ == "acronyme"){
			return " e.acronyme ". $like ." '%" . $text . "%'";
		}
		if ($champ == "codeanonyma"){
			return " e.codeanonyma ". $like ." '%" . $text . "%'";
		}
		if ($champ == "numerovisite"){
			return " e.numerovisite ". $like ." '%" . $text . "%'";
		}
		if ($champ == "recipient" ){
			return " u.login ". $like ." '%" . $text . "%'";
		}
	}
	
	public function summaryseReportStats($table, $entrySummary){
		
		if ($entrySummary == "recipient"){
			$entrySummary = "login";
		}
		if ($entrySummary == "color_code"){
			$entrySummary = "color";
		}
		
		//echo '<br /> entrySummary = ' . $entrySummary . "<br/>";
		
		// get unique resource
		$tResources = array();
		foreach($table as $t){
			
			$found = false;
			foreach($tResources as $res){ 
				if( $t['resource'] == $res ){
					$found = true;
					break;
				}
			}
			
			if (!$found){
				$tResources[] = $t['resource'];
			}
		}
		
		// get unique entry summary
		$tSummary = array();
		foreach($table as $t){
				
			//print_r($t);
			//return;
			
			$found = false;
			foreach($tSummary as $res){
				if( $t[$entrySummary] == $res ){
					$found = true;
					break;
				}
			}
				
			if (!$found){
				$tSummary[] = $t[$entrySummary];
			}
		}
		
		// count the numbers of reservation and the time
		$countTable = array();
		$timeTable = array();
		
		foreach ($tSummary as $sum){
			foreach ($tResources as $res){
			
				$count = 0;
				$time = 0;
				foreach($table as $t){
					if ( $t["resource"] == $res && $t[$entrySummary] == $sum ){
						$count += 1;
						$time += $t["end_time"] - $t["start_time"]; 
					}
				}
				$countTable[$sum][$res] = $count;
				$timeTable[$sum][$res] = $time;
			}
		} 
		
		$summary = array('countTable' => $countTable, 'timeTable' => $timeTable, 'resources' => $tResources, 'entrySummary' => $tSummary);
		return $summary;
	}
}