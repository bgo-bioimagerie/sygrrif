<?php

require_once 'Framework/Model.php';
require_once 'Modules/sprojects/Model/SpProject.php';

require_once 'Modules/sprojects/Model/SpUser.php';
require_once 'Modules/sprojects/Model/SpUnit.php';
require_once 'Modules/sprojects/Model/SpBelonging.php';

require_once 'Modules/core/Model/CoreUnit.php';
require_once 'Modules/core/Model/CoreUser.php';
require_once 'Modules/core/Model/CoreBelonging.php';

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

		$modelUnit = "";
		$modelBelonging = "";

		$modelConfig = new CoreConfig();
		$sprojectsusersdatabase = $modelConfig->getParam ( "sprojectsusersdatabase" );
		if ($sprojectsusersdatabase == "local"){
			$modelUser = new SpUser();
			$modelUnit = new SpUnit();
			$modelBelonging = new SpBelonging();
		}
		else{
			$modelUser = new CoreUser();
			$modelUnit = new CoreUnit();
			$modelBelonging = new CoreBelonging();

		}
		
		foreach($projects as $project){
			
			// get the responsible unit
			$id_unit = $modelUser->getUserUnit($project["id_resp"]);

			$id_pricing = $modelUnit->getBelonging($id_unit);
			$pricingInfo = $modelBelonging->getInfo($id_pricing);
			if ($pricingInfo["type"] == 1){

				$numberAccademicProjects++;
			}
			else{
				$numberIndustryProjects++;
			}
		}
		
		// number of new academic projects
		$sql = "select * from sp_projects where date_open >= ? AND date_open <= ? AND new_project=?";
		$req = $this->runRequest ( $sql, array ($startDate_min, $startDate_max, 2) );
		$numberNewAccademicProject = $req->rowCount();
		
		//echo "numberNewAccademicProject = " . $numberNewAccademicProject . "<br/>";
		
		// number of new academic team
		$sql = "select * from sp_projects where date_open >= ? AND date_open <= ? AND new_team=?";
		$req = $this->runRequest ( $sql, array ($startDate_min, $startDate_max, 2) );
		$numberNewAccademicTeam = $req->rowCount();
		
		//echo "numberNewAccademicTeam = " . $numberNewAccademicTeam . "<br/>";
		
		// number of new industry projects
		$sql = "select * from sp_projects where date_open >= ? AND date_open <= ? AND new_project=?";
		$req = $this->runRequest ( $sql, array ($startDate_min, $startDate_max, 3) );
		$numberNewIndustryProject = $req->rowCount();
		
		//echo "numberNewIndustryProject = " . $numberNewIndustryProject . "<br/>";
		
		// number of new industry team
		$sql = "select * from sp_projects where date_open >= ? AND date_open <= ? AND new_team=?";
		$req = $this->runRequest ( $sql, array ($startDate_min, $startDate_max, 3) );
		$numberNewIndustryTeam = $req->rowCount();
		
		//echo "numberNewIndustryTeam = " . $numberNewIndustryTeam . "<br/>";
		
		$purcentageNewIndustryTeam  = 0;
		$purcentageloyaltyIndustryProjects = 0;
		if ($numberIndustryProjects > 0){
			$purcentageNewIndustryTeam = round(100*$numberNewIndustryTeam/$numberIndustryProjects);
			$purcentageloyaltyIndustryProjects = round(100*($numberIndustryProjects-$numberNewIndustryTeam)/$numberIndustryProjects);
		}

		$purcentageNewAccademicTeam = 0;
		$purcentageloyaltyAccademicProjects = 0;
		if ($numberAccademicProjects > 0){
			$purcentageNewAccademicTeam = round(100*$numberNewAccademicTeam/$numberAccademicProjects);
			$purcentageloyaltyAccademicProjects = round(100*($numberAccademicProjects-$numberNewAccademicTeam)/$numberAccademicProjects);
		}
		
		$output = array( "numberNewIndustryTeam" => $numberNewIndustryTeam, 
						 "purcentageNewIndustryTeam" => $purcentageNewIndustryTeam,
				         "numberIndustryProjects" => $numberIndustryProjects,
						 "loyaltyIndustryProjects" => $numberIndustryProjects-$numberNewIndustryTeam,
					     "purcentageloyaltyIndustryProjects" => $purcentageloyaltyIndustryProjects,
				
						 "numberNewAccademicTeam" => $numberNewAccademicTeam,
						 "purcentageNewAccademicTeam" => $purcentageNewAccademicTeam,
					 	 "numberAccademicProjects" => $numberAccademicProjects,
					 	 "loyaltyAccademicProjects" => $numberAccademicProjects-$numberNewAccademicTeam,
				         "purcentageloyaltyAccademicProjects" => $purcentageloyaltyAccademicProjects,
					
						 "totalNumberOfProjects" => $totalNumberOfProjects
				
		);
		return $output;
	}
	
	public function getResponsiblesCsv($startDate_min, $startDate_max, $lang){
		$sql = "select id_resp from sp_projects where date_open >= ? AND date_open <= ?";
		$req = $this->runRequest ( $sql, array ($startDate_min, $startDate_max) );
		$totalNumberOfProjects = $req->rowCount();
		$projects = $req->fetchAll();
		
		$modelConfig = new CoreConfig();
		$sprojectsusersdatabase = $modelConfig->getParam ( "sprojectsusersdatabase" );
		$modelUser = "";
		if ($sprojectsusersdatabase == "local"){
			$modelUser = new SpUser();
		}
		else{
			$modelUser = new CoreUser();
		}
		
		$content = CoreTranslator::Name($lang) . ";" . CoreTranslator::Email($lang) . "\r\n";
		foreach($projects as $project){
			$userName = $modelUser->getUserFUllName($project["id_resp"]);
			$userMail = $modelUser->getUserEmail($project["id_resp"]);
			$content .= $userName . ";" . $userMail . "\r\n";
		}
		
		header("Content-Type: application/csv-tab-delimited-table");
		header("Content-disposition: filename=listing_responsible_sproject.csv");
		echo $content;
	}
}