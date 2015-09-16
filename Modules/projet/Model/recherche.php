<?php

require_once 'Framework/Model.php';


class recherche extends Model {

	public function getinfo($typeactivite){
		$sql="select * from neurinfo where typeactivite=?";
		$req=$this->runRequest($sql, array($typeactivite));
		return $req->fetchAll();
	}
	public function getdonnee($nac){
		$sql="select * from neurinfo where nac=?";
		$req=$this->runRequest($sql, array($nac));
		return $req->fetchAll();
	}
	public function getfiche($fiche, $valeur){
		$sql="select * from neurinfo where fiche=valeur";
		$req=$this->runRequest($sql, array($fiche, $valeur));
		return $req->fetchAll();
	}
	public function getfichenothere($fiche, $valeur){
		$sql="select * from neurinfo where fich!=valeur";
		$req=$this->runRequest($sql, array($fiche, $valeur));
		return $req->fetchAll();
	}
	public function reportstats( $champ, $type_recherche, $text, $contition_et_ou){
		
		$sql = "SELECT distinct e.idform, e.numerofiche, e.type, e.nac, e.acronyme, e.typeactivite, e.promoteur, e.opglibelle, e.protocoleinjecte, e.cstnt,  "
				. "e.gamds, e.irm, e.lastirm, f.tarif, f.soinscourant, c.intitule, "
				. "a.ipprenom,  a.numerofiche "
				. " FROM neurinfo e, invesprinc a, projet_type_financement f, cotation c"
				. " WHERE e.numerofiche = a.numerofiche and e.numerofiche = f.numerofiche and e.numerofiche = c.numerofiche " ;
		
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
		
		if ( $champ == "numerofiche" ){
			return " e.numerofiche = " . $text;
		}
		if ($champ == "type"){
			return " e.type ". $like ." '%" . $text . "%'";
		}
		if ($champ == "nac"){
			return " e.nac ". $like ." '%" . $text . "%'";
		}
		if ($champ == "acronyme"){
			return " e.acronyme ". $like ." '%" . $text . "%'";
		}
		if ($champ == "typeactivite"){
			return " e.typeactivite ". $like ." '%" . $text . "%'";
		}
		if ($champ == "ipprenom"){
			return " a.ipprenom ". $like ." '%" . $text . "%'";
		}
		if ($champ == "promoteur" ){
			return " e.promoteur ". $like ." '%" . $text . "%'";
		}
		if ($champ == "opglibelle" ){
			return " e.opglibelle ". $like ." '%" . $text . "%'";
		}
		if ($champ == "protocoleinjecte" ){
			return " e.protocoleinjecte". $like ." '%" . $text . "%'";
		}
		if ($champ == "cstnt" ){
			return " e.cstnt ". $like ." '%" . $text . "%'";
		}
		if ($champ == "gamds" ){
			return " e.gamds ". $like ." '%" . $text . "%'";
		}
		if ($champ == "soinscourant" ){
			return " f.soinscourant ". $like ." '%" . $text . "%'";
		}
		if ($champ == "tarif" ){
			return " f.tarif ". $like ." '%" . $text . "%'";
		}
		if ($champ == "irm" ){
			return " e.irm ". $like ." '%" . $text . "%'";
		}
		if ($champ == "lastirm" ){
			return " e.lastirm ". $like ." '%" . $text . "%'";
		}
		if ($champ == "intitule" ){
			return " c.intitule ". $like ." '%" . $text . "%'";
		}
	
	}
public function summaryseReportStats($table, $entrySummary){
		
		if ($entrySummary == "numerofiche"){
			$entrySummary = "numerofiche";
		}
		if ($entrySummary == "acronyme"){
			$entrySummary = "acronyme";
		}
		if ($entrySummary == "nac"){
			$entrySummary = "nac";
		}
		//echo '<br /> entrySummary = ' . $entrySummary . "<br/>";
		
		// get unique resource
		$tResources = array();
		foreach($table as $t){
			
			$found = false;
			foreach($tResources as $res){ 
				if( $t['acronyme'] == $res ){
					$found = true;
					break;
				}
			}
			
			if (!$found){
				$tResources[] = $t['acronyme'];
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
		
		
		foreach ($tSummary as $sum){
			foreach ($tResources as $res){
			
				$count = 0;
				
				foreach($table as $t){
					if ( $t["acronyme"] == $res && $t[$entrySummary] == $sum ){
						$count += 1;
						 
					}
				}
				$countTable[$sum][$res] = $count;
				
			}
		} 
		
		$summary = array('countTable' => $countTable,  'acronyme' => $tResources, 'entrySummary' => $tSummary);
		return $summary;
	}

}