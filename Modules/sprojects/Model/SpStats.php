<?php

require_once 'Framework/Model.php';
require_once 'Modules/sprojects/Model/SpProject.php';
require_once 'Modules/sprojects/Model/SpPricing.php';
require_once 'Modules/sprojects/Model/SpUser.php';
require_once 'Modules/sprojects/Model/SpUnitPricing.php';

require_once 'Modules/core/Model/Unit.php';
require_once 'Modules/core/Model/User.php';
require_once 'Modules/core/Model/CoreTranslator.php';
require_once("externals/PHPExcel/Classes/PHPExcel.php");

/**
 * Class defining the supplies pricing model
 *
 * @author Sylvain Prigent
 */
class SpStats extends Model {
	
	public function computeStats($startDate_min, $startDate_max){
		
		// total number of projects 
		$sql = "select * from sp_projects where date_open >= ? AND date_open <= ?";
		$req = $this->runRequest ( $sql, array ($startDate_min, $startDate_max) );
		$totalNumberOfProjects = $req->rowCount();
		$projects = $req->fetchAll();
		
		// number of accademic and industry projects
		$numberAccademicProjects = 0;
		$numberIndustryProjects = 0;
		
			$modelUser = "";
		$modelUnit = new SpUnitPricing();
		$modelPricing = new SpPricing();
		$modelConfig = new CoreConfig();
		$sprojectsusersdatabase = $modelConfig->getParam ( "sprojectsusersdatabase" );
		if ($sprojectsusersdatabase == "local"){
			$modelUser = new SpUser();
		}
		else{
			$modelUser = new User();
		}
		
		foreach($projects as $project){
			
			// get the responsible unit
			$id_unit = $modelUser->getUserUnit($project["id_resp"]);
			$id_pricing = $modelUnit->getPricing($id_unit);
			$pricingInfo = $modelPricing->getPricing($id_pricing);
			if ($pricingInfo["tarif_type"] == 1){
				$numberAccademicProjects++;
			}
			else{
				$numberIndustryProjects++;
			}
		}
		
		// number of new academic projects
		$sql = "select * from sp_projects where date_open >= ? AND date_open <= ? AND new_project=2";
		$req = $this->runRequest ( $sql, array ($startDate_min, $startDate_max) );
		$numberNewAccademicProject = $req->rowCount();
		
		// number of new academic team
		$sql = "select * from sp_projects where date_open >= ? AND date_open <= ? AND new_team=2";
		$req = $this->runRequest ( $sql, array ($startDate_min, $startDate_max) );
		$numberNewAccademicTeam = $req->rowCount();
		
		// number of new industry projects
		$sql = "select * from sp_projects where date_open >= ? AND date_open <= ? AND new_project=3";
		$req = $this->runRequest ( $sql, array ($startDate_min, $startDate_max) );
		$numberNewIndustryProject = $req->rowCount();
		
		// number of new industry team
		$sql = "select * from sp_projects where date_open >= ? AND date_open <= ? AND new_team=3";
		$req = $this->runRequest ( $sql, array ($startDate_min, $startDate_max) );
		$numberNewIndustryTeam = $req->rowCount();
		
		
		$output = array( "numberNewIndustryTeam" => $numberNewIndustryTeam, 
						 "purcentageNewIndustryTeam" => round(100*$numberNewIndustryTeam/$numberIndustryProjects),
				         "numberIndustryProjects" => $numberIndustryProjects,
						 "loyaltyIndustryProjects" => $numberIndustryProjects-$numberNewIndustryTeam,
					     "purcentageloyaltyIndustryProjects" => round(100*($numberIndustryProjects-$numberNewIndustryTeam)/$numberIndustryProjects),
				
						 "numberNewAccademicTeam" => $numberNewAccademicTeam,
						 "purcentageNewAccademicTeam" => round(100*$numberNewAccademicTeam/$numberAccademicProjects),
					 	 "numberAccademicProjects" => $numberAccademicProjects,
					 	 "loyaltyAccademicProjects" => $numberAccademicProjects-$numberNewAccademicTeam,
				         "purcentageloyaltyAccademicProjects" => round(100*($numberAccademicProjects-$numberNewAccademicTeam)/$numberAccademicProjects),
					
						 "totalNumberOfProjects" => $totalNumberOfProjects
				
		);
		return $output;
	}
}