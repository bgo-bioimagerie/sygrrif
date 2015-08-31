<?php

require_once 'Framework/Model.php';
require_once 'Modules/sygrrif/Model/SyUnitPricing.php';
require_once 'Modules/sygrrif/Model/SyBill.php';
require_once 'Modules/sygrrif/Model/SyResourcePricing.php';
require_once("externals/PHPExcel/Classes/PHPExcel.php");

/**
 * Class containing method that calculate and generate bill files
 *
 * @author Sylvain Prigent
 */
class SyBillGenerator extends Model {
	
	/**
	 * Generate a bill for a project from calendar entries
	 * 
	 * @param date $searchDate_start Starting date of the bill
	 * @param date $searchDate_end   End date of the bill
	 * @param number $projectID		Id of the project to bill	
	 * @param number $pricingID		Id of the pricing to use
	 * @param number $billPerReservation	1 if pricing on the number of reservation, 0 on the reservation time
	 */
	public function generateProjectBill($searchDate_start, $searchDate_end, $projectID, $pricingID, $billPerReservation){
		
		// /////////////////////////////////////////// //
		//        get the input informations           //
		// /////////////////////////////////////////// //
		// convert start date to unix date
		$tabDate = explode("-",$searchDate_start);
		$date_debut = $tabDate[2].'/'.$tabDate[1].'/'.$tabDate[0];
		$searchDate_start= mktime(0,0,0,$tabDate[1],$tabDate[2],$tabDate[0]);
		
		// convert end date to unix date
		$tabDate = explode("-",$searchDate_end);
		$date_fin = $tabDate[2].'/'.$tabDate[1].'/'.$tabDate[0];
		$searchDate_end= mktime(0,0,0,$tabDate[1],$tabDate[2]+1,$tabDate[0]);
		
		// resources 
		$sql = 'SELECT * FROM sy_resources ORDER BY name';
		$req = $this->runRequest($sql);
		$resources = $req->fetchAll();
		
		// projectName
		$modelProject = new Project();
		$projectName = $modelProject->getProjectName($projectID);
		
		// ///////////////////////////////////////// //
		//             Main query                    //
		// ///////////////////////////////////////// //
		// count the booking 
		$bookedTime = array();
		$resaNumber = array();
		
		$i = -1;
		foreach ($resources as $resource){
			$i++;
			$bookedTime[$i] = 0;
			$resaNumber[$i] = 0;
			
			// reservations that starts before the date and that finish during the date
			$q = array('start'=>$searchDate_start, 'end'=>$searchDate_end, 'short_description'=>$projectID, 'room_id'=>$resource["id"]);
			$sql = 'SELECT start_time, end_time, quantity FROM sy_calendar_entry WHERE start_time <:start AND end_time <= :end AND end_time>:start AND short_description=:short_description AND resource_id=:room_id';
			$req = $this->runRequest($sql, $q);
			$resBefore = $req->fetchAll();
			
			foreach($resBefore as $rB){
				$resaNumber[$i]++;
				$bookedTime[$i] += ($rB["end_time"] - $searchDate_start)/3600;
			}
			
			// reseravtions that starts AND end during the selected periode
			$sql = 'SELECT start_time, end_time FROM sy_calendar_entry WHERE start_time >=:start AND end_time <= :end AND short_description=:short_description AND resource_id=:room_id';
			$req = $this->runRequest($sql, $q);
			$resIn = $req->fetchAll();
			$numResIn = $req->rowCount();
			
			foreach($resIn as $rI){
				$resaNumber[$i]++;
				$bookedTime[$i] += ($rI["end_time"] - $rI["start_time"])/3600;
			}
			
			//ResAfter : Réservation qui commence dans la période sélectionnée et se termine après la période sélectionnée
			$sql = 'SELECT start_time, end_time FROM sy_calendar_entry WHERE start_time >=:start AND start_time<:end AND end_time > :end AND short_description=:short_description AND resource_id=:room_id';
			$req = $this->runRequest($sql, $q);
			$resAfter = $req->fetchAll();
			$numResAfter = $req->rowCount();
			
			foreach($resAfter as $rI){
				$resaNumber[$i]++;
				$bookedTime[$i] += ($searchDate_end - $rI["start_time"])/3600;
			}
		}	
		
		//print_r($bookedTime);
		
		// /////////////////////////////////////////// //
		//             xls output                      //
		// /////////////////////////////////////////// //
		// stylesheet
		$styleTableHeader = array(
				'font' => array(
						'name' => 'Times',
						'size' => 10,
						'bold' => true,
						'color' => array(
								'rgb' => '000000'
						),
				),
				'borders' => array(
						'outline' => array(
								'style' => PHPExcel_Style_Border::BORDER_THIN,
								'color' => array(
										'rgb' => '000000'),
						),
				),
				'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'startcolor' => array(
								'rgb' => 'C0C0C0',
						),
				),
				'alignment' => array(
						'wrap'       => false,
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				),
		);
		
		$styleTableCell = array(
				'font' => array(
						'name' => 'Times',
						'size' => 10,
						'bold' => false,
						'color' => array(
								'rgb' => '000000'
						),
				),
				'alignment' => array(
						'wrap'       => false,
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				),
				'borders' => array(
				  'outline' => array(
				  		'style' => PHPExcel_Style_Border::BORDER_THIN,
				  		'color' => array(
				  				'rgb' => '000000'),
				  ),
				),
		);
		$styleTableCellTotal = array(
				'font' => array(
						'name' => 'Times',
						'size' => 10,
						'bold' => true,
						'color' => array(
								'rgb' => 'ff0000'
						),
				),
				'alignment' => array(
						'wrap'       => false,
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				),
				'borders' => array(
						'outline' => array(
								'style' => PHPExcel_Style_Border::BORDER_THIN,
								'color' => array(
										'rgb' => '000000'),
						),
				),
				'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'startcolor' => array(
								'rgb' => 'ffffff',
						),
				),
		);
		
		// load the template
		$file = "data/template.xls";
		$XLSDocument = new PHPExcel_Reader_Excel5();
		$objPHPExcel = $XLSDocument->load($file);
		
		// get the line where to insert the table
		$insertLine = 0;
		
		// replace tags by values
		$objPHPExcel = $this->replaceDate($objPHPExcel);
		$objPHPExcel = $this->replaceProject($objPHPExcel, $projectName);
		$output = $this->replaceBillNumber($objPHPExcel);
		$number = $output[0];
		$objPHPExcel = $output[1];
		
		// replace table
		$curentLine = $this->getTableLine($objPHPExcel);
		
		// Fill the pricing table
		// table headers
		$objPHPExcel->getActiveSheet()->insertNewRowBefore($curentLine + 1, 1);
		$objPHPExcel->getActiveSheet()->mergeCells('A'.$curentLine.':F'.$curentLine);
		
		$titleTab = "";
		if ($date_debut == $date_fin){
			$titleTab = "Prestations du ".$date_debut."";
		}
		else{
			$titleTab = "Prestations du ".$date_debut." au ".$date_fin."";
		}
		
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$curentLine, $titleTab);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$curentLine)->getFont()->setBold(true);
		
		$curentLine++;
		
		// table title
		$objPHPExcel->getActiveSheet()->insertNewRowBefore($curentLine + 1, 1);
		$objPHPExcel->getActiveSheet()
		->getRowDimension($curentLine)
		->setRowHeight(25);
		
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$curentLine, "Equipement");
		$objPHPExcel->getActiveSheet()->getStyle('A'.$curentLine)->applyFromArray($styleTableHeader);
		
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$curentLine, "Nombre de \n séances");
		$objPHPExcel->getActiveSheet()->getStyle('B'.$curentLine)->applyFromArray($styleTableHeader);
		
		$objPHPExcel->getActiveSheet()->SetCellValue('C'.$curentLine, "Nombre d'heures");
		$objPHPExcel->getActiveSheet()->getStyle('C'.$curentLine)->applyFromArray($styleTableHeader);
		
		$titleUnitaryPricing = "Tarif Séance";
		if ($billPerReservation == 0){
			$titleUnitaryPricing = "Tarif Horaire";
		}
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$curentLine, $titleUnitaryPricing);
		$objPHPExcel->getActiveSheet()->getStyle('D'.$curentLine)->applyFromArray($styleTableHeader);
		
		$objPHPExcel->getActiveSheet()->SetCellValue('E'.$curentLine, "Montant");
		$objPHPExcel->getActiveSheet()->getStyle('E'.$curentLine)->applyFromArray($styleTableHeader);
		
		// table content
		$honoraireTotal = 0;
		$totalHT = 0;
		for ($j = 0; $j < count($resources); $j++) {
			
			if ($resaNumber[$j] > 0){ // print only when there is some booking
				// get the unit price for the room
				$modelPricing = new SyResourcePricing();
				//echo "pricing id = " . $pricingID . "<br/>";
				//echo "resource id = " . $resources[$j]["id"] . "<br/>";
				
				$tmp = $modelPricing->getPrice($resources[$j]["id"], $pricingID);
				$unitaryPrice = $tmp["price_day"];
				//echo "unitaryPrice = " . $unitaryPrice . "<br/>";
				//return;
				// calculate the price
				$price = 0;
				if ($billPerReservation == 0){
					$price = (float)$bookedTime[$j]*(float)$unitaryPrice;
				}
				else{
					$price = (float)$resaNumber[$j]*(float)$unitaryPrice;
				}
				$totalHT += $price;
				
				// add the room
				$curentLine++;
				$objPHPExcel->getActiveSheet()->insertNewRowBefore($curentLine + 1, 1);
				$objPHPExcel->getActiveSheet()->SetCellValue('A'.$curentLine, $resources[$j]["name"]); // resource name
				$objPHPExcel->getActiveSheet()->getStyle('A'.$curentLine)->applyFromArray($styleTableCell);
				
				$objPHPExcel->getActiveSheet()->SetCellValue('B'.$curentLine, $resaNumber[$j]); // number of booking
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$curentLine, $bookedTime[$j]); // number of hours
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$curentLine, $unitaryPrice); // unitary price
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$curentLine, $price); // price HT
						
				$objPHPExcel->getActiveSheet()->getStyle('B'.$curentLine)->applyFromArray($styleTableCell);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$curentLine)->applyFromArray($styleTableCell);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$curentLine)->applyFromArray($styleTableCell);
				$objPHPExcel->getActiveSheet()->getStyle('E'.$curentLine)->applyFromArray($styleTableCell);	
			}	
		}
		
		// add the bill to the bill manager
		$modelBill = new SyBill();
		$modelBill->addBill($number, date("Y-m-d", time()));
		
		// bilan
		// total HT
		$curentLine++;
		$objPHPExcel->getActiveSheet()->insertNewRowBefore($curentLine + 1, 1);
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$curentLine, "Total H.T.");
		$objPHPExcel->getActiveSheet()->SetCellValue('E'.$curentLine, number_format(round($totalHT,2), 2, ',', ' ')." €");
		
		$objPHPExcel->getActiveSheet()->getStyle('D'.$curentLine)->applyFromArray($styleTableCell);
		$objPHPExcel->getActiveSheet()->getStyle('D'.$curentLine)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$curentLine)->applyFromArray($styleTableCell);
		
		// TVA 20p
		$curentLine++;
		$objPHPExcel->getActiveSheet()->insertNewRowBefore($curentLine + 1, 1);
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$curentLine, "T.V.A.:20%");
		$honoraireTVA = 0.2*$totalHT;
		$objPHPExcel->getActiveSheet()->SetCellValue('E'.$curentLine, number_format(round($honoraireTVA,2), 2, ',', ' ')." €");
		
		$objPHPExcel->getActiveSheet()->getStyle('D'.$curentLine)->applyFromArray($styleTableCell);
		$objPHPExcel->getActiveSheet()->getStyle('D'.$curentLine)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$curentLine)->applyFromArray($styleTableCell);
		
		// space
		$curentLine++;
		$objPHPExcel->getActiveSheet()->insertNewRowBefore($curentLine + 1, 1);
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$curentLine, "");
		$objPHPExcel->getActiveSheet()->SetCellValue('E'.$curentLine, "----");
		
		// TTC
		$curentLine++;
		$objPHPExcel->getActiveSheet()->insertNewRowBefore($curentLine + 1, 1);
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$curentLine, "Total T.T.C.");
		$honoraireTotal = 1.2*$totalHT;
		$objPHPExcel->getActiveSheet()->SetCellValue('E'.$curentLine, number_format(round($honoraireTotal,2), 2, ',', ' ')." €");
		
		$objPHPExcel->getActiveSheet()->getStyle('D'.$curentLine)->applyFromArray($styleTableCell);
		$objPHPExcel->getActiveSheet()->getStyle('D'.$curentLine)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$curentLine)->applyFromArray($styleTableCellTotal);
		
		// Save the xls file
		$filename = "bill_" . $number . ".xls";
		$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename='. $filename);
		header('Cache-Control: max-age=0');
		$objWriter->save('php://output');
	}
	
	/**
	 *  Generate a bill for a unit from calendar entries
	 *  
	 * @param unknown $searchDate_start Starting date of the bill
	 * @param unknown $searchDate_end   End date of the bill
	 * @param number $unit_id ID of the unit to bill
	 * @param number $responsible_id ID of the responsible to bill
	 */
	public function generateBill($searchDate_start, $searchDate_end, $unit_id, $responsible_id){
		
		
		// /////////////////////////////////////////// // 
		//        get the input informations           //
		// /////////////////////////////////////////// //
		// convert start date to unix date
		$period_begin = $searchDate_start;
		$tabDate = explode("-",$searchDate_start);
		$date_debut = $tabDate[2].'/'.$tabDate[1].'/'.$tabDate[0];
		$searchDate_start= mktime(0,0,0,$tabDate[1],$tabDate[2],$tabDate[0]);
		
		// convert end date to unix date
		$period_end = $searchDate_end;
		$tabDate = explode("-",$searchDate_end);
		$date_fin = $tabDate[2].'/'.$tabDate[1].'/'.$tabDate[0];
		$searchDate_end= mktime(0,0,0,$tabDate[1],$tabDate[2]+1,$tabDate[0]);
		
		// get the lab info
		$unitPricingModel = new SyUnitPricing();
		$LABpricingid = $unitPricingModel->getPricing($unit_id);
		
		// responsible fullname
		$modelUser = new User();
		$responsibleFullName = $modelUser->getUserFUllName($responsible_id);
		
		// unit name
		$modelUnit = new Unit();
		$unitName = $modelUnit->getUnitName($unit_id);
		
		$unitInfo = $modelUnit->getUnit($unit_id);
		$unitAddress = $unitInfo[2];
		
		
		// ///////////////////////////////////////// //
		//             Main query                    //
		// ///////////////////////////////////////// //
		// get the list of users in the selected period
		$q = array('start'=>$searchDate_start, 'end'=>$searchDate_end);
		$sql = 'SELECT DISTINCT recipient_id FROM sy_calendar_entry WHERE
				(start_time <:start AND end_time <= :end AND end_time>:start) OR
				(start_time >=:start AND end_time <= :end) OR
				(start_time >=:start AND start_time<:end AND end_time > :end) ORDER BY id';
		$req = $this->runRequest($sql, $q);
		$beneficiaire = $req->fetchAll();	// Liste des bénéficiaire dans la période séléctionée
		
		//print_r($beneficiaire);
		//return;
		
		$i=0;
		$people[0] = "";
		foreach($beneficiaire as $b){
			
			//print_r($b);
			//return;
			
			// user info
			$modelUser = new User();
			$nomPrenom = $modelUser->getUserFromlup(($b[0]), $unit_id, $responsible_id);
			// name, firstname, id_responsible
			if (count($nomPrenom) != 0){
				$people[0][$i] = $nomPrenom[0]["name"]; 	//Nom du beneficiaire
				$people[1][$i] = $nomPrenom[0]["firstname"]; 	//Prénom du bénéficiaire
				$people[2][$i] = $b[0];				//Login du bénéficiaire
				$people[3][$i] = $nomPrenom[0]["id_responsible"];	//Responsable du bénéficiaire
				$people[4][$i] = $LABpricingid;	//Tarif appliqué
				$i++;
			}
		}
		
		//print_r($people);
		//return;

		if (count($people[0]) >= 1){
			array_multisort($people[0],SORT_ASC,$people[1],$people[2],$people[3],$people[4]);
		}
		$sql = 'SELECT * FROM sy_resources ORDER BY name';
		$req = $this->runRequest($sql);
		$equipement = $req->fetchAll();
		
		$i=0;
		$room = array();
		foreach($equipement as $e){
			$numResTotal = 0;
			$heureTotal = 0;
			$heureResTotalJour = 0;
			$heureResTotalNuit = 0;
			$heureResTotalWeJour = 0;
			$heureResTotalWeNuit = 0;
					
			$heureTotalVrai = 0;
			$heureResTotalNuitVrai = 0;
			$heureResTotalWeJourVrai = 0;
			$heureResTotalWeNuitVrai = 0;
		
			$pricingModel = new SyPricing();
			$resourceID = $e[0];
			$modelResource = new SyResource();
			$resourceType = $modelResource->getResourceType($resourceID);
			
			for ($j = 0; $j < count($people[0]); $j++) {
				$descriptionTarif = $pricingModel->getPricing($people[4][$j]);

				// get the pricing info for this unit
				$tarif_id = $LABpricingid;
				$tarif_name = $descriptionTarif['tarif_name'];
				$tarif_unique = $descriptionTarif['tarif_unique'];
				$tarif_nuit = $descriptionTarif['tarif_night'];
				$tarif_we = $descriptionTarif['tarif_we'];
				$night_start = $descriptionTarif['night_start'];
				$night_end = $descriptionTarif['night_end'];
				$we_array1 = explode(",", $descriptionTarif['choice_we']);
				$we_array = array();
				for($s = 0 ; $s < count($we_array1) ; $s++ ){
					if ($we_array1[$s] > 0){
						$we_array[] = $s+1;
					}
				}
				
				//print_r($we_array1);
				//print_r($we_array);
				//return;
				// get the price for the curent resource
				$modelRessourcePricing = new SyResourcePricing();
				$res = $modelRessourcePricing->getPrice($e[0], $tarif_id);
				$tarif_horaire_jour = $res['price_day'];	//Tarif jour pour l'utilisateur sélectionné
				$tarif_horaire_nuit = $res['price_night'];	//Tarif nuit pour l'utilisateur sélectionné
				$tarif_horaire_we = $res['price_we'];		//Tarif w-e pour l'utilisateur sélectionné

				//Informations sur le domaine de de la ressource
				//$q = array('id'=>$e[0]);
				$sql = 'SELECT size_bloc_resa FROM sy_resources_calendar WHERE id_resource=?';
				$req = $this->runRequest($sql, array($e[0]));
				$descriptionDomaine = $req->fetchAll();
				$resolutionDomaine = $descriptionDomaine[0][0];

				//---------
				//ResBefore : Réservation qui commence avant la période sélectionée et se termine dans la période sélectionnée
				$q = array('start'=>$searchDate_start, 'end'=>$searchDate_end, 'room_id'=>$e[0], 'beneficiaire'=>$people[2][$j]);
				$sql = 'SELECT start_time, end_time, quantity FROM sy_calendar_entry WHERE start_time <:start AND end_time <= :end AND end_time>:start AND resource_id=:room_id AND recipient_id=:beneficiaire';
				$req = $this->runRequest($sql, $q);
				$resBefore = $req->fetchAll();
				$numResBefore = $req->rowCount();
				$heureBefore = 0;

				if ($resourceType == 1){ // calendar
					$heureBeforeJour = 0;
					$honoraireBeforeJour = 0;
					$heureBeforeNuit = 0;
					$honoraireBeforeNuit = 0;
					$heureBeforeWeJour = 0;
					$honoraireBeforeWeJour = 0;
					$heureBeforeWeNuit = 0;
					$honoraireBeforeWeNuit = 0;
					foreach($resBefore as $rB){
						$progress = $searchDate_start;
						while ($progress < $rB[1]){
							$progress += $resolutionDomaine;
							if (in_array(date('N',$progress),$we_array)){
								if ((date('H',$progress)>$night_end) && (date('H',$progress) <= $night_start)){
									$heureBeforeWeJour += $resolutionDomaine/3600;
								} else {
									$heureBeforeWeNuit += $resolutionDomaine/3600;
								}
							} else {
								if ((date('H',$progress)>$night_end) && (date('H',$progress) <= $night_start)){
									$heureBeforeJour += $resolutionDomaine/3600;
								} else {
									$heureBeforeNuit += $resolutionDomaine/3600;
								}
							}
						}
					}
					$heureBeforeVrai = $heureBeforeJour + $heureBeforeNuit + $heureBeforeWeJour + $heureBeforeWeNuit;
					$heureBefore = $heureBeforeJour + ($heureBeforeNuit/2) + ($heureBeforeWeJour/2) + ($heureBeforeWeNuit/2);
				}
				else if ($resourceType == 2){ // unitary calendar
					foreach($resBefore as $rB){
						$heureBefore += $rB[2];
					}
				}
				
				
				//---------
				//ResIn : Réservation qui commence ET se termine dans la période sélectionnée
				$sql = 'SELECT start_time, end_time, quantity FROM sy_calendar_entry WHERE start_time >=:start AND end_time <= :end AND resource_id=:room_id AND recipient_id=:beneficiaire';
				$req = $this->runRequest($sql, $q);
				$resIn = $req->fetchAll();
				$numResIn = $req->rowCount();
				
				//print_r($resIn);
				//return;
				
				$heureIn = 0;
				if ($resourceType == 1){ // calendar
					$heureInJour = 0;
					$honoraireInJour = 0;
					$heureInNuit = 0;
					$honoraireInNuit = 0;
					$heureInWeJour = 0;
					$honoraireInWeJour = 0;
					$heureInWeNuit = 0;
					$honoraireInWeNuit = 0;
					foreach($resIn as $rI){
							
						//if (strpos($rI[2],"@2@")) {
						//	$tarif_majoration = urldecode(substr($rI[2],strpos($rI[2],"@2@")+3,strpos($rI[2],"@/2@")-strpos($rI[2],"@2@")-3));
						//} else {
						$tarif_majoration = 0;
						//}
						$progress = $rI[0];
						while ($progress < $rI[1]){
							$progress += $resolutionDomaine;
							if (in_array(date('N',$progress),$we_array)){
								if ((date('H',$progress)>$night_end) && (date('H',$progress) <= $night_start)){
									$heureInWeJour += $resolutionDomaine/3600;
								} else {
									$heureInWeNuit += $resolutionDomaine/3600;
								}
							} else {
								if ((date('H',$progress)>$night_end) && (date('H',$progress) <= $night_start)){
									$heureInJour += $resolutionDomaine/3600;
								} else {
									$heureInNuit += $resolutionDomaine/3600;
								}
							}
						}
					}
					$heureInVrai = $heureInJour + $heureInNuit + $heureInWeJour + $heureInWeNuit;
					$heureIn = $heureInJour + ($heureInNuit/2) + ($heureInWeJour/2) + ($heureInWeNuit/2);
				}
				else if ($resourceType == 2){ // unitary calendar
					foreach($resIn as $rB){
						//print_r($rB);
						//return;
						$heureIn += $rB[2];
					}
				}	
					
				
				//---------
				//ResAfter : Réservation qui commence dans la période sélectionnée et se termine après la période sélectionnée
				$sql = 'SELECT start_time, end_time, quantity FROM sy_calendar_entry WHERE start_time >=:start AND start_time<:end AND end_time > :end AND resource_id=:room_id AND recipient_id=:beneficiaire';
				$req = $this->runRequest($sql, $q);
				$resAfter = $req->fetchAll();
				$numResAfter = $req->rowCount();

				$heureAfter = 0;
				if ($resourceType == 1){ // calendar
					$heureAfterJour = 0;
					$honoraireAfterJour = 0;
					$heureAfterNuit = 0;
					$honoraireAfterNuit = 0;
					$heureAfterWeJour = 0;
					$honoraireAfterWeJour = 0;
					$heureAfterWeNuit = 0;
					$honoraireAfterWeNuit = 0;
					foreach($resAfter as $rA){
						$progress = $rA[0];
						while ($progress < $searchDate_end){
							$progress += $resolutionDomaine;
							if (in_array(date('N',$progress),$we_array)){
								if ((date('H',$progress)>$night_end) && (date('H',$progress) <= $night_start)){
									$heureAfterWeJour += $resolutionDomaine/3600;
								} else {
									$heureAfterWeNuit += $resolutionDomaine/3600;
								}
							} else {
								if ((date('H',$progress)>$night_end) && (date('H',$progress) <= $night_start)){
									$heureAfterJour += $resolutionDomaine/3600;
								} else {
									$heureAfterNuit += $resolutionDomaine/3600;
								}
							}
						}
					}
					$heureAfterVrai = $heureAfterJour + $heureAfterNuit + $heureAfterWeJour + $heureAfterWeNuit;
					$heureAfter = $heureAfterJour + ($heureAfterNuit/2) + ($heureAfterWeJour/2) + ($heureAfterWeNuit/2);
				}
				else if ($resourceType == 2){ // unitary calendar
					foreach($resAfter as $rB){
						$heureAfter += $rB[2];
					}
				}
				//---------
		
				$numResBeneficiaire = $numResIn + $numResAfter;
				//$numResBeneficiaire = $numResBefore + $numResIn;
				$heureResBeneficiaire = $heureIn + $heureAfter;
				//$heureResBeneficiaire = $heureBefore + $heureIn;
				$heureResBeneficiaireJour = $heureInJour + $heureAfterJour;
				//$heureResBeneficiaireJour = $heureBeforeJour + $heureInJour;
				$heureResBeneficiaireNuit = ($heureInNuit/2) + ($heureAfterNuit/2);
				//$heureResBeneficiaireNuit = $heureBeforeNuit + $heureInNuit;
				$heureResBeneficiaireWeJour = ($heureInWeJour/2) + ($heureAfterWeJour/2);
				//$heureResBeneficiaireWeJour = $heureBeforeWeJour + $heureInWeJour;
				$heureResBeneficiaireWeNuit = ($heureInWeNuit/2) + ($heureAfterWeNuit/2);
				//$heureResBeneficiaireWeNuit = $heureBeforeWeNuit + $heureInWeNuit;
		
				$heureResBeneficiaireVrai = $heureInVrai + $heureAfterVrai;
				//$heureResBeneficiaireVrai = $heureBeforeVrai + $heureInVrai;
				$heureResBeneficiaireNuitVrai = $heureInNuit + $heureAfterNuit;
				//$heureResBeneficiaireNuit = $heureBeforeNuit + $heureInNuit;
				$heureResBeneficiaireWeJourVrai = $heureInWeJour + $heureAfterWeJour;
				//$heureResBeneficiaireWeJour = $heureBeforeWeJour + $heureInWeJour;
				$heureResBeneficiaireWeNuitVrai = $heureInWeNuit + $heureAfterWeNuit;
				//$heureResBeneficiaireWeNuit = $heureBeforeWeNuit + $heureInWeNuit;
			
				
				$beneficiaire[$j][$e[0]][0] = $numResBeneficiaire;			//nombre de réservations par bénéficiaire et par équipement
				$beneficiaire[$j][$e[0]][1] = $heureResBeneficiaire;		//nombre d'heures réservées par bénéficiaire et par équipement
				$beneficiaire[$j][$e[0]][2] = $tarif_unique;
				$beneficiaire[$j][$e[0]][3] = $tarif_nuit;
				$beneficiaire[$j][$e[0]][4] = $tarif_we;
				$beneficiaire[$j][$e[0]][5] = $heureResBeneficiaireJour;
				$beneficiaire[$j][$e[0]][6] = $heureResBeneficiaireNuit;
				$beneficiaire[$j][$e[0]][8] = $heureResBeneficiaireWeJour;
				$beneficiaire[$j][$e[0]][9] = $heureResBeneficiaireWeNuit;
				$beneficiaire[$j][$e[0]][10] = $tarif_horaire_jour;
				$beneficiaire[$j][$e[0]][11] = $tarif_horaire_nuit;
				$beneficiaire[$j][$e[0]][12] = $tarif_horaire_we;

				$beneficiaire[$j][$e[0]][13] = $heureResBeneficiaireVrai; //nombre d'heures "Vrai" réservées par bénéficiaire et par équipement
				$beneficiaire[$j][$e[0]][14] = $heureResBeneficiaireNuitVrai;
				$beneficiaire[$j][$e[0]][15] = $heureResBeneficiaireWeJourVrai;
				$beneficiaire[$j][$e[0]][16] = $heureResBeneficiaireWeNuitVrai;
		
				$numResTotal += $numResBeneficiaire;
				$heureTotal += $heureResBeneficiaire;
				$heureResTotalJour += $heureResBeneficiaireJour;
				$heureResTotalNuit += $heureResBeneficiaireNuit;
				$heureResTotalWeJour += $heureResBeneficiaireWeJour;
				$heureResTotalWeNuit += $heureResBeneficiaireWeNuit;
		
				$heureTotalVrai += $heureResBeneficiaireVrai;
				$heureResTotalNuitVrai += $heureResBeneficiaireNuitVrai;
				$heureResTotalWeJourVrai += $heureResBeneficiaireWeJourVrai;
				$heureResTotalWeNuitVrai += $heureResBeneficiaireWeNuitVrai;
		
		
			}
			
			if ($numResTotal != 0){
				$room[0][$i] = $e[0]; 					//id de la room
				$room[1][$i] = $e[1]; 					//nom de la room
				$room[2][$i] = $numResTotal; 			//nombre de réservations sur la room
				$room[3][$i] = $heureTotal; 			//nombre d'heures réservées sur la room
				$room[4][$i] = $heureResTotalJour;		//nombre d'heures réservées sur la room pendant la période jour
				$room[5][$i] = $heureResTotalNuit;		//nombre d'heures réservées sur la room pendant la période nuit / 2 (divisé par 2)
				$room[6][$i] = $heureResTotalWeJour;	//nombre d'heures réservées sur la room pendant la période w-e jour / 2 (divisé par 2)
				$room[7][$i] = $heureResTotalWeNuit;	//nombre d'heures réservées sur la room pendant la période w-e nuit / 2 (divisé par 2)
		
				$room[8][$i] = $heureTotalVrai;
				$room[9][$i] = $heureResTotalNuitVrai;
				$room[10][$i] = $heureResTotalWeJourVrai;
				$room[11][$i] = $heureResTotalWeNuitVrai;
		
				$i++;
			}			
		}
		$numOfEquipement = 0;
		
		//print_r($room);
		//return;
		
		if (count($room) > 0){
			$numOfEquipement = count($room[0]);
		}
		
		// /////////////////////////////////////////// //
		//             xls output                      //
		// /////////////////////////////////////////// //
		// stylesheet
		$styleTableHeader = array(
				'font' => array(
						'name' => 'Times',
						'size' => 10,
						'bold' => true,
						'color' => array(
								'rgb' => '000000'
				  ),
				),
				'borders' => array(
						'outline' => array(
								'style' => PHPExcel_Style_Border::BORDER_THIN,
								'color' => array(
										'rgb' => '000000'),
						),
				),
				'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'startcolor' => array(
								'rgb' => 'C0C0C0',
						),
				),
				'alignment' => array(
						'wrap'       => false,
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				),
		);
		
		$styleTableCell = array(
		  'font' => array(
			'name' => 'Times',
			'size' => 10,
			'bold' => false,
			'color' => array(
			  'rgb' => '000000'
			  ),
			),
		 'alignment' => array(
			'wrap'       => false,
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			),
		  'borders' => array(
		  'outline' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN,
			'color' => array(
			  'rgb' => '000000'),
			),
		  ),	
		);
		$styleTableCellTotal = array(
				'font' => array(
						'name' => 'Times',
						'size' => 10,
						'bold' => true,
						'color' => array(
								'rgb' => 'ff0000'
				  ),
				),
			 'alignment' => array(
			 		'wrap'       => false,
			 		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				),
				'borders' => array(
						'outline' => array(
								'style' => PHPExcel_Style_Border::BORDER_THIN,
								'color' => array(
										'rgb' => '000000'),
						),
				),
				'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'startcolor' => array(
								'rgb' => 'ffffff',
						),
				),
		);
		
		// load the template
		$file = "data/template.xls";
		$XLSDocument = new PHPExcel_Reader_Excel5();
		$objPHPExcel = $XLSDocument->load($file);
		
		// get the line where to insert the table
		$insertLine = 0;
		
		// replace the date
		$rowIterator = $objPHPExcel->getActiveSheet()->getRowIterator();
		$col = array("A", "B","C","D","E","F","G","H","I","J","K","L");
		$insertCol = "";
		$keyfound = false;
		foreach($rowIterator as $row) {
			for ($i = 0 ; $i < count($col) ; $i++){
				$rowIndex = $row->getRowIndex ();
				$num = $objPHPExcel->getActiveSheet()->getCell($col[$i].$rowIndex)->getValue();
				if (strpos($num,"{date}") !== false){
					$insertLine = $rowIndex;
					$insertCol = $col[$i];
					$keyfound = true;
					break;
				}
			}
		}
		if ($keyfound){
			$objPHPExcel->getActiveSheet()->SetCellValue($insertCol.$insertLine, date("d/m/Y", time()));
		}
		// replace the year
		$rowIterator = $objPHPExcel->getActiveSheet()->getRowIterator();
		$col = array("A", "B","C","D","E","F","G","H","I","J","K","L");
		$insertCol = "";
		$keyfound = false;
		foreach($rowIterator as $row) {
			for ($i = 0 ; $i < count($col) ; $i++){
				$rowIndex = $row->getRowIndex ();
				$num = $objPHPExcel->getActiveSheet()->getCell($col[$i].$rowIndex)->getValue();
				if (strpos($num,"{annee}") !== false){
					$insertLine = $rowIndex;
					$insertCol = $col[$i];
					$keyfound = true;
					break;
				}
			}
		}
		if ($keyfound){
			$objPHPExcel->getActiveSheet()->SetCellValue($insertCol.$insertLine, date("Y", time()));
		}
		// replace the responsible
		$rowIterator = $objPHPExcel->getActiveSheet()->getRowIterator();
		$col = array("A", "B","C","D","E","F","G","H","I","J","K","L");
		$insertCol = "";
		$keyfound = false;
		foreach($rowIterator as $row) {
			for ($i = 0 ; $i < count($col) ; $i++){
				$rowIndex = $row->getRowIndex ();
				$num = $objPHPExcel->getActiveSheet()->getCell($col[$i].$rowIndex)->getValue();
				if (strpos($num,"{responsable}") !== false){
					$insertLine = $rowIndex;
					$insertCol = $col[$i];
					$keyfound = true;
					break;
				}
			}
		}
		if ($keyfound){
			$objPHPExcel->getActiveSheet()->SetCellValue($insertCol.$insertLine, $responsibleFullName);
		}
		// replace $unitName
		$rowIterator = $objPHPExcel->getActiveSheet()->getRowIterator();
		$col = array("A", "B","C","D","E","F","G","H","I","J","K","L");
		$insertCol = "";
		$keyfound = false;
		foreach($rowIterator as $row) {
			for ($i = 0 ; $i < count($col) ; $i++){
				$rowIndex = $row->getRowIndex ();
				$num = $objPHPExcel->getActiveSheet()->getCell($col[$i].$rowIndex)->getValue();
				if (strpos($num,"{unite}") !== false){
					$insertLine = $rowIndex;
					$insertCol = $col[$i];
					$keyfound = true;
					break;
				}
			}
		}
		if ($keyfound){
			$objPHPExcel->getActiveSheet()->SetCellValue($insertCol.$insertLine, $unitName);
		}
		
		// replace address $unitAddress
		$rowIterator = $objPHPExcel->getActiveSheet()->getRowIterator();
		$col = array("A", "B","C","D","E","F","G","H","I","J","K","L");
		$insertCol = "";
		$keyfound = false;
		foreach($rowIterator as $row) {
			for ($i = 0 ; $i < count($col) ; $i++){
				$rowIndex = $row->getRowIndex ();
				$num = $objPHPExcel->getActiveSheet()->getCell($col[$i].$rowIndex)->getValue();
				if (strpos($num,"{adresse}") !== false){
					$insertLine = $rowIndex;
					$insertCol = $col[$i];
					$keyfound = true;
					break;
				}
			}
		}
		if ($keyfound){
			$objPHPExcel->getActiveSheet()->SetCellValue($insertCol.$insertLine, $unitAddress);
			$objPHPExcel->getActiveSheet()->getStyle($insertCol.$insertLine)->getAlignment()->setWrapText(true);
		}
		// replace the bill number
		// calculate the number
		$modelBill = new SyBill();
		$bills = $modelBill->getBills("number");
		$lastNumber = "";
		$number = "";
		if (count($bills) > 0){
			$lastNumber = $bills[count($bills)-1]["number"];
		}
		if ($lastNumber != ""){
			$lastNumber = explode("-", $lastNumber);
			$lastNumberY = $lastNumber[0];
			$lastNumberN = $lastNumber[1];
				
			if ($lastNumberY == date("Y", time())){
				$lastNumberN = (int)$lastNumberN + 1;
			}
			$num = "".$lastNumberN."";
			if ($lastNumberN < 10){
				$num = "00" . $lastNumberN;
			}
			else if ($lastNumberN >= 10 && $lastNumberN < 100){
				$num = "0" . $lastNumberN;
			}
			$number = $lastNumberY ."-". $num ;
		}
		else{
			$number = date("Y", time()) . "-001";
		}
		// replace the number
		$rowIterator = $objPHPExcel->getActiveSheet()->getRowIterator();
		$col = array("A", "B","C","D","E","F","G","H","I","J","K","L");
		$insertCol = "";
		$keyfound = false;
		foreach($rowIterator as $row) {
			for ($i = 0 ; $i < count($col) ; $i++){
				$rowIndex = $row->getRowIndex ();
				$num = $objPHPExcel->getActiveSheet()->getCell($col[$i].$rowIndex)->getValue();
				if (strpos($num,"{nombre}") !== false){
					$insertLine = $rowIndex;
					$insertCol = $col[$i];
					$keyfound = true;
					break;
				}
			}
		}
		if($keyfound){
			$objPHPExcel->getActiveSheet()->SetCellValue($insertCol.$insertLine, $number);
		}
		
		// table
		$rowIterator = $objPHPExcel->getActiveSheet()->getRowIterator();
		foreach($rowIterator as $row) {
			
			$rowIndex = $row->getRowIndex ();
			$num = $objPHPExcel->getActiveSheet()->getCell("A".$rowIndex)->getValue();
			if (strpos($num,"{table}") !== false){
				$insertLine = $rowIndex;
				break;
			}
		}
		
		$curentLine = $insertLine; 
		// Fill the pricing table
		// table headers
		$objPHPExcel->getActiveSheet()->insertNewRowBefore($curentLine + 1, 1);
		$objPHPExcel->getActiveSheet()->mergeCells('A'.$curentLine.':F'.$curentLine);
		
		$titleTab = "";
		if ($date_debut == $date_fin){
			$titleTab = "Prestations du ".$date_debut."";
		}
		else{
			$titleTab = "Prestations du ".$date_debut." au ".$date_fin."";
		}

		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$curentLine, $titleTab);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$curentLine)->getFont()->setBold(true);
		
		$curentLine++;
		
		// set the row
		$objPHPExcel->getActiveSheet()->insertNewRowBefore($curentLine + 1, 1);
		$objPHPExcel->getActiveSheet()
		->getRowDimension($curentLine)
		->setRowHeight(25);
		
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$curentLine, "Equipement");
		$objPHPExcel->getActiveSheet()->getStyle('A'.$curentLine)->applyFromArray($styleTableHeader);
		
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$curentLine, "Utilisateur");
		$objPHPExcel->getActiveSheet()->getStyle('B'.$curentLine)->applyFromArray($styleTableHeader);
		
		$objPHPExcel->getActiveSheet()->SetCellValue('C'.$curentLine, "Nombre de \n séances");
		$objPHPExcel->getActiveSheet()->getStyle('C'.$curentLine)->getAlignment()->setWrapText(true);
		$objPHPExcel->getActiveSheet()->getStyle('C'.$curentLine)->applyFromArray($styleTableHeader);
		
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$curentLine, "Quantité");
		$objPHPExcel->getActiveSheet()->getStyle('D'.$curentLine)->applyFromArray($styleTableHeader);
		
		$objPHPExcel->getActiveSheet()->SetCellValue('E'.$curentLine, "Tarif Unitaire");
		$objPHPExcel->getActiveSheet()->getStyle('E'.$curentLine)->applyFromArray($styleTableHeader);
		
		$objPHPExcel->getActiveSheet()->SetCellValue('F'.$curentLine, "Montant");
		$objPHPExcel->getActiveSheet()->getStyle('F'.$curentLine)->applyFromArray($styleTableHeader);
		
		// table content
		$honoraireTotal = 0;
		for ($j = 0; $j < $numOfEquipement; $j++) {
	
			// gather the information into a matrix
			$nBeArray = array();
			$nBe = 0;
			if($beneficiaire[0][$room[0][$j]][2] == 1){ // tarif unique = tarif jour
				$jour = $room[3][$j];
				$honoraire = $jour*$beneficiaire[0][$room[0][$j]][10];
				$honoraireTotal += $honoraire;
				for ($p = 0; $p < count($people[0]); $p++) {
					if ($beneficiaire[$p][$room[0][$j]][0] != 0){
						$nBeArray[$nBe][0] = $people[0][$p].' '.$people[1][$p]; // nom prénon utilisateur
						$nBeArray[$nBe][1] = $beneficiaire[$p][$room[0][$j]][0]; // nombre de séances
						$nBeArray[$nBe][2] = $beneficiaire[$p][$room[0][$j]][1]; // quantité: nbre d'heures
						$nBeArray[$nBe][3] = $beneficiaire[0][$room[0][$j]][10]; // prix unitaire
						$nBeArray[$nBe][4] = $beneficiaire[$p][$room[0][$j]][1]*$beneficiaire[$p][$room[0][$j]][10]; // Total
						$nBe++;
					}
				}
			}
			else{
				if (($beneficiaire[0][$room[0][$j]][3] == 1) && ($beneficiaire[0][$room[0][$j]][4] == 0)){			// tarif jour + tarif nuit (pas de tarif we)
					$jour = $room[4][$j]+2.0*$room[6][$j]; // tarif horaire jour
					$nuit = 2.0*$room[5][$j]+2.0*$room[7][$j]; // tarif horaire nuit
					$honoraire_jour = $jour*$beneficiaire[0][$room[0][$j]][10]; // honoraires jour
					$honoraire_nuit = $nuit*$beneficiaire[0][$room[0][$j]][11]; // honoarires nuit
					$honoraireTotal += $honoraire_jour + $honoraire_nuit; // honoraires total
					for ($p = 0; $p < count($people[0]); $p++) {
						if ($beneficiaire[$p][$room[0][$j]][0] != 0){
							$nBeArray[$nBe][0] = $people[0][$p].' '.$people[1][$p]; // nom prénon utilisateur
							$nBeArray[$nBe][1] = $beneficiaire[$p][$room[0][$j]][0]; // nombre de séances
							$nBeArray[$nBe][2] = $beneficiaire[$p][$room[0][$j]][5] . "hj " . $beneficiaire[$p][$room[0][$j]][6]*2.0 . "hn"; // quantité: nbre d'heures
							$nBeArray[$nBe][3] = $beneficiaire[0][$room[0][$j]][10] . "hj " . $beneficiaire[0][$room[0][$j]][11] . "hn "; // prix unitaire
							
							$totalJour = $beneficiaire[$p][$room[0][$j]][5]*$beneficiaire[$p][$room[0][$j]][10];
							$totalNuit = 2.0*$beneficiaire[$p][$room[0][$j]][6]*$beneficiaire[$p][$room[0][$j]][11];
							
							$nBeArray[$nBe][4] = $totalJour + $totalNuit; // Total
							$nBe++;
						}
					}
				} 
				else if (($beneficiaire[0][$room[0][$j]][3] == 0) && ($beneficiaire[0][$room[0][$j]][4] == 1)){		// tarif jour + tarif week-end
					$semaine = $room[4][$j]+$room[5][$j]*2.0;
					$we = 2.0*$room[6][$j]+2.0*$room[7][$j];
					$honoraire_semaine = $semaine*$beneficiaire[0][$room[0][$j]][10];
					$honoraire_we = $we*$beneficiaire[0][$room[0][$j]][12];
					$honoraireTotal += $honoraire_semaine + $honoraire_we;
					
					for ($p = 0; $p < count($people[0]); $p++) {
						if ($beneficiaire[$p][$room[0][$j]][0] != 0){
							$nBeArray[$nBe][0] = $people[0][$p].' '.$people[1][$p]; // nom prénon utilisateur
							$nBeArray[$nBe][1] = $beneficiaire[$p][$room[0][$j]][0]; // nombre de séances
							
							$sem = $beneficiaire[$p][$room[0][$j]][5] + $beneficiaire[$p][$room[0][$j]][6];
							$we = 2.0*($beneficiaire[$p][$room[0][$j]][8] + $beneficiaire[$p][$room[0][$j]][9]);
							$nBeArray[$nBe][2] = $sem . "hj " . $we . "hwe" ; // quantité: nbre d'heures
							
							$nBeArray[$nBe][3] = $beneficiaire[0][$room[0][$j]][10] . "hj " . $beneficiaire[0][$room[0][$j]][12] . "hwe ";; // prix unitaire
							
							$totalSem = $sem*$beneficiaire[0][$room[0][$j]][10];
							$totalWe = $we*$beneficiaire[0][$room[0][$j]][12];
							$nBeArray[$nBe][4] = $totalSem + $totalWe; // Total
							
							$nBe++;
						}
					}
					
				}
				else if (($beneficiaire[0][$room[0][$j]][3] == 1) && ($beneficiaire[0][$room[0][$j]][4] == 1)){ 	// tarif jour + tarif nuit + tarif week-end
					$jour = $room[4][$j];
					$nuit = 2.0*$room[5][$j];
					$we = 2.0*($room[6][$j] + $room[7][$j]);
					$honoraire_jour = $jour*$beneficiaire[0][$room[0][$j]][10];
					$honoraire_nuit = $nuit*$beneficiaire[0][$room[0][$j]][11];
					$honoraire_we = $we*$beneficiaire[0][$room[0][$j]][12];
					$honoraireTotal += $honoraire_jour + $honoraire_nuit + $honoraire_we;
					
					for ($p = 0; $p < count($people[0]); $p++) {
						if ($beneficiaire[$p][$room[0][$j]][0] != 0){
							$nBeArray[$nBe][0] = $people[0][$p].' '.$people[1][$p]; // nom prénon utilisateur
							$nBeArray[$nBe][1] = $beneficiaire[$p][$room[0][$j]][0]; // nombre de séances
								
							$jour = $beneficiaire[$p][$room[0][$j]][5];
							$nuit = 2.0*$beneficiaire[$p][$room[0][$j]][6];
							$we = 2.0*($beneficiaire[$p][$room[0][$j]][8] + $beneficiaire[$p][$room[0][$j]][9]);
							$nBeArray[$nBe][2] = $jour . "hj " . $nuit . "hn " . $we . "hwe" ; // quantité: nbre d'heures
								
							$nBeArray[$nBe][3] = $beneficiaire[0][$room[0][$j]][10] . "hj " . $beneficiaire[0][$room[0][$j]][11] . "hn ". $beneficiaire[0][$room[0][$j]][12] . "hwe ";; // prix unitaire
								
							$totalJ = $jour*$beneficiaire[0][$room[0][$j]][10];
							$totalN = $nuit*$beneficiaire[0][$room[0][$j]][11];
							$totalW = $we*$beneficiaire[0][$room[0][$j]][12];
							
							$nBeArray[$nBe][4] = $totalJ + $totalN + $totalW; // Total
								
							$nBe++;
						}
					}
				}
			}
			
			// print into xls table
			$curentLine++;
			$roomspan = $nBe + $curentLine-1;
			$objPHPExcel->getActiveSheet()->insertNewRowBefore($curentLine + 1, $nBe);
			$objPHPExcel->getActiveSheet()->mergeCells('A'.$curentLine.':A'.$roomspan);
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$curentLine, $room[1][$j]); // room name
			$objPHPExcel->getActiveSheet()->getStyle('A'.$curentLine)->applyFromArray($styleTableCell);
			
			for ($i = 0; $i < $nBe; $i++) {
				$objPHPExcel->getActiveSheet()->SetCellValue('B'.$curentLine, $nBeArray[$i][0]);
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$curentLine, $nBeArray[$i][1]);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$curentLine, $nBeArray[$i][2]);
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$curentLine, $nBeArray[$i][3]);
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.$curentLine, number_format(round($nBeArray[$i][4],2), 2, ',', ' '));
					
				$objPHPExcel->getActiveSheet()->getStyle('B'.$curentLine)->applyFromArray($styleTableCell);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$curentLine)->applyFromArray($styleTableCell);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$curentLine)->applyFromArray($styleTableCell);
				$objPHPExcel->getActiveSheet()->getStyle('E'.$curentLine)->applyFromArray($styleTableCell);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$curentLine)->applyFromArray($styleTableCell);
					
				if ($i<$nBe-1){
					$curentLine++;
				}
			}
			
			/*			
			// tarif unique = tarif jour
			if ($beneficiaire[0][$room[0][$j]][2] == 1){ 						// tarif unique = tarif jour
				$jour = $room[3][$j];
				$honoraire = $jour*$beneficiaire[0][$room[0][$j]][10];
				$honoraireTotal += $honoraire;
				$nBe = 0;
				$nBeArray = array();
				for ($p = 0; $p < count($people[0]); $p++) {
					if ($beneficiaire[$p][$room[0][$j]][0] != 0){
						$nBeArray[$nBe][0] = $people[0][$p].' '.$people[1][$p];
						$nBeArray[$nBe][1] = $beneficiaire[$p][$room[0][$j]][0]; // nombre resa
						$nBeArray[$nBe][2] = $beneficiaire[$p][$room[0][$j]][1]; // quantité
						$nBeArray[$nBe][3] = $beneficiaire[0][$room[0][$j]][10]; // prix unitaire
						$nBeArray[$nBe][4] = $beneficiaire[$p][$room[0][$j]][1]*$beneficiaire[$p][$room[0][$j]][10]; // quantité*prixUnitaire
						$nBe++;
					}
				}
				
				// add the room
				$curentLine++;
				$roomspan = $nBe + $curentLine-1;
				$objPHPExcel->getActiveSheet()->insertNewRowBefore($curentLine + 1, $nBe);
				$objPHPExcel->getActiveSheet()->mergeCells('A'.$curentLine.':A'.$roomspan);
				$objPHPExcel->getActiveSheet()->SetCellValue('A'.$curentLine, $room[1][$j]); // room name
				$objPHPExcel->getActiveSheet()->getStyle('A'.$curentLine)->applyFromArray($styleTableCell);
				
				for ($i = 0; $i < $nBe; $i++) {
					$objPHPExcel->getActiveSheet()->SetCellValue('B'.$curentLine, $nBeArray[$i][0]);
					$objPHPExcel->getActiveSheet()->SetCellValue('C'.$curentLine, $nBeArray[$i][1]);
					$objPHPExcel->getActiveSheet()->SetCellValue('D'.$curentLine, $nBeArray[$i][2]);
					$objPHPExcel->getActiveSheet()->SetCellValue('E'.$curentLine, $nBeArray[$i][3]);
					$objPHPExcel->getActiveSheet()->SetCellValue('F'.$curentLine, number_format(round($nBeArray[$i][4],2), 2, ',', ' '));
					
					$objPHPExcel->getActiveSheet()->getStyle('B'.$curentLine)->applyFromArray($styleTableCell);
					$objPHPExcel->getActiveSheet()->getStyle('C'.$curentLine)->applyFromArray($styleTableCell);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$curentLine)->applyFromArray($styleTableCell);
					$objPHPExcel->getActiveSheet()->getStyle('E'.$curentLine)->applyFromArray($styleTableCell);
					$objPHPExcel->getActiveSheet()->getStyle('F'.$curentLine)->applyFromArray($styleTableCell);
					
					if ($i<$nBe-1){
						$curentLine++;
					}
				}	

			// tarif jour + tarif nuit
			} else {
				if (($beneficiaire[0][$room[0][$j]][3] == 1) && ($beneficiaire[0][$room[0][$j]][4] == 0)){			// tarif jour + tarif nuit
					$jour = $room[4][$j]+$room[6][$j]; // tarif horaire jour
					$nuit = $room[5][$j]+$room[7][$j]; // tarif horaire nuit
					$honoraire_jour = $jour*$beneficiaire[0][$room[0][$j]][10]; // honoraires jour
					$honoraire_nuit = $nuit*$beneficiaire[0][$room[0][$j]][11]; // honoarires nuit
					$honoraireTotal += $honoraire_jour + $honoraire_nuit; // honoraires total
				} else if (($beneficiaire[0][$room[0][$j]][3] == 0) && ($beneficiaire[0][$room[0][$j]][4] == 1)){	// tarif jour + tarif week-end
					$semaine = $room[4][$j]+$room[5][$j];
					$we = $room[6][$j]+$room[7][$j];
					$honoraire_semaine = $semaine*$beneficiaire[0][$room[0][$j]][10];
					$honoraire_we = $we*$beneficiaire[0][$room[0][$j]][12];
					$honoraireTotal += $honoraire_semaine + $honoraire_we;
				} else if (($beneficiaire[0][$room[0][$j]][3] == 1) && ($beneficiaire[0][$room[0][$j]][4] == 1)){ 	// tarif jour + tarif nuit + tarif week-end
					$jour = $room[4][$j];
					$nuit = $room[5][$j];
					$we = $room[6][$j] + $room[7][$j];
										
					$nuitVrai = $room[9][$j];
					$weVrai = $room[10][$j] + $room[11][$j];
										
					$honoraire_jour = $jour*$beneficiaire[0][$room[0][$j]][10];
					$honoraire_nuit = $nuit*$beneficiaire[0][$room[0][$j]][11];
					$honoraire_we = $we*$beneficiaire[0][$room[0][$j]][12];
					$honoraireTotal += $honoraire_jour + $honoraire_nuit + $honoraire_we;
										
					$honoraire_nuitVrai = $nuitVrai*$beneficiaire[0][$room[0][$j]][11];
					$honoraire_weVrai = $weVrai*$beneficiaire[0][$room[0][$j]][12];
					$honoraireTotalVrai += $honoraire_jour + $honoraire_nuitVrai + $honoraire_weVrai;
										
					$nbTarif = 0;
					if ($jour) {
						$affichage[$nbTarif][0] = "Jour";
						$affichage[$nbTarif][1] = number_format(round($jour,2), 2, ',', ' ');
						$affichage[$nbTarif][2] = number_format(round($beneficiaire[0][$room[0][$j]][10],2), 2, ',', ' ');
						$affichage[$nbTarif][3] = number_format(round($honoraire_jour,2), 2, ',', ' ');
						$affichage[$nbTarif][4] = number_format(round($jour,2), 2, ',', ' ');
						$nbTarif++;
					}
					if ($nuit) { 
						$affichage[$nbTarif][0] = "Nuit";
						$affichage[$nbTarif][1] = number_format(round($nuit,2), 2, ',', ' ');
						$affichage[$nbTarif][2] = number_format(round($beneficiaire[0][$room[0][$j]][11],2), 2, ',', ' ');
						$affichage[$nbTarif][3] = number_format(round($honoraire_nuit,2), 2, ',', ' ');
						$affichage[$nbTarif][4] = number_format(round($nuitVrai,2), 2, ',', ' ');
						$nbTarif++;
					}
					if ($we) { 
						$affichage[$nbTarif][0] = "Week-end";
						$affichage[$nbTarif][1] = number_format(round($we,2), 2, ',', ' ');
						$affichage[$nbTarif][2] = number_format(round($beneficiaire[0][$room[0][$j]][12],2), 2, ',', ' ');
						$affichage[$nbTarif][3] = number_format(round($honoraire_we,2), 2, ',', ' ');
						$affichage[$nbTarif][4] = number_format(round($weVrai,2), 2, ',', ' ');
						$nbTarif++;
					}
					echo '<tr>';
					echo '<td class="resultat" style="width: 30%; border-bottom: 1px solid #000000; border-right: 1px solid #000000;" rowspan="'.$nbTarif.'">'.$room[1][$j].'</td>';
					echo '<td class="resultat" style="width: 15%; border-bottom: 1px solid #000000; border-right: 1px solid #000000;" rowspan="'.$nbTarif.'">'.$room[2][$j].'</td>';
					for ($n = 0; $n < $nbTarif; $n++) {
						if ($n == 0){
							if ($nbTarif == 1){
								echo '<td class="resultat" style="width: 13%; border-bottom: 1px solid #000000;border-right: 1px solid #000000;">'.$affichage[$n][0].'</td>';
								//echo '<td class="resultat" style="width: 14%; border-bottom: 1px solid #000000;border-right: 1px solid #000000; padding-right: 10px; text-align: right;">'.$affichage[$n][1].' ('.$affichage[$n][4].')</td>';
								echo '<td class="resultat" style="width: 14%; border-bottom: 1px solid #000000;border-right: 1px solid #000000; padding-right: 10px; text-align: right;">'.$affichage[$n][1].'</td>';
								echo '<td class="resultat" style="width: 14%; border-bottom: 1px solid #000000;border-right: 1px solid #000000; padding-right: 10px; text-align: right;">'.$affichage[$n][2].'</td>';
								echo '<td class="resultat" style="width: 14%; border-bottom: 1px solid #000000; padding-right: 10px; text-align: right;">'.$affichage[$n][3].' €</td>';
							} else{
								echo '<td class="resultat" style="width: 13%; border-bottom: 1px dashed #000000;border-right: 1px solid #000000;">'.$affichage[$n][0].'</td>';
								//echo '<td class="resultat" style="width: 14%; border-bottom: 1px dashed #000000;border-right: 1px solid #000000; padding-right: 10px; text-align: right;">'.$affichage[$n][1].' ('.$affichage[$n][4].')</td>';
								echo '<td class="resultat" style="width: 14%; border-bottom: 1px dashed #000000;border-right: 1px solid #000000; padding-right: 10px; text-align: right;">'.$affichage[$n][1].'</td>';
								echo '<td class="resultat" style="width: 14%; border-bottom: 1px dashed #000000;border-right: 1px solid #000000; padding-right: 10px; text-align: right;">'.$affichage[$n][2].'</td>';
								echo '<td class="resultat" style="width: 14%; border-bottom: 1px dashed #000000; padding-right: 10px; text-align: right;">'.$affichage[$n][3].' €</td>';
							}
							echo '</tr>';
						} else{
							if (($n+1) == $nbTarif){
								echo '<tr>';
								echo '<td class="resultat" style="width: 13%; border-bottom: 1px solid #000000; border-right: 1px solid #000000;">'.$affichage[$n][0].'</td>';
								//echo '<td class="resultat" style="width: 14%; border-bottom: 1px solid #000000; border-right: 1px solid #000000; padding-right: 10px; text-align: right;">'.$affichage[$n][1].' ('.$affichage[$n][4].')</td>';
								echo '<td class="resultat" style="width: 14%; border-bottom: 1px solid #000000; border-right: 1px solid #000000; padding-right: 10px; text-align: right;">'.$affichage[$n][1].'</td>';
								echo '<td class="resultat" style="width: 14%; border-bottom: 1px solid #000000; border-right: 1px solid #000000; padding-right: 10px; text-align: right;">'.$affichage[$n][2].'</td>';
								echo '<td class="resultat" style="width: 14%; border-bottom: 1px solid #000000; padding-right: 10px; text-align: right;">'.$affichage[$n][3].' €</td>';
								echo '</tr>';
												
							} else{
								echo '<tr>';
								echo '<td class="resultat" style="width: 13%; border-bottom: 1px dashed #000000; border-right: 1px solid #000000;">'.$affichage[$n][0].'</td>';
								//echo '<td class="resultat" style="width: 14%; border-bottom: 1px dashed #000000; border-right: 1px solid #000000; padding-right: 10px; text-align: right;">'.$affichage[$n][1].' ('.$affichage[$n][4].')</td>';
								echo '<td class="resultat" style="width: 14%; border-bottom: 1px dashed #000000; border-right: 1px solid #000000; padding-right: 10px; text-align: right;">'.$affichage[$n][1].'</td>';
								echo '<td class="resultat" style="width: 14%; border-bottom: 1px dashed #000000; border-right: 1px solid #000000; padding-right: 10px; text-align: right;">'.$affichage[$n][2].'</td>';
								echo '<td class="resultat" style="width: 14%; border-bottom: 1px dashed #000000; padding-right: 10px; text-align: right;">'.$affichage[$n][3].' €</td>';
								echo '</tr>';
							}
						}
					}
				} else {
					$jour = $room[3][$j];
					$honoraire = $jour*$beneficiaire[0][$room[0][$j]][10];
					echo '<td class="resultat" style="width: 15%">'.$jour.'</td>';
					echo '<td class="resultat" style="width: 20%">'.$beneficiaire[0][$room[0][$j]][10].'</td>';
					echo '<td class="resultat" style="width: 20%">'.$honoraire.'</td>';
				}
			//
			}
			*/
		}
		
		
		// bilan
		// total HT
		$curentLine++;
		$objPHPExcel->getActiveSheet()->insertNewRowBefore($curentLine + 1, 1);
		$objPHPExcel->getActiveSheet()->SetCellValue('E'.$curentLine, "Total H.T.");
		$objPHPExcel->getActiveSheet()->SetCellValue('F'.$curentLine, number_format(round($honoraireTotal,2), 2, ',', ' ')." €");
		
		$objPHPExcel->getActiveSheet()->getStyle('E'.$curentLine)->applyFromArray($styleTableCell);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$curentLine)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('F'.$curentLine)->applyFromArray($styleTableCell);
		
		// add the bill to the bill manager
		$modelBill->addBillUnit($number, $period_begin, $period_end, date("Y-m-d", time()), $unit_id, $responsible_id, $honoraireTotal);
		
		
		// frais de gestion
		/*
		if ($people[4][0] != "1"){
			$curentLine++;
			$objPHPExcel->getActiveSheet()->insertNewRowBefore($curentLine + 1, 1);
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$curentLine, "Frais de gestion :10%");
			$honoraireFrais = 0.1*$honoraireTotal;
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$curentLine, number_format(round($honoraireFrais,2), 2, ',', ' ')." €");
			
			$objPHPExcel->getActiveSheet()->getStyle('E'.$curentLine)->applyFromArray($styleTableCell);
			$objPHPExcel->getActiveSheet()->getStyle('E'.$curentLine)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('F'.$curentLine)->applyFromArray($styleTableCell);
			
			$curentLine++;
			$objPHPExcel->getActiveSheet()->insertNewRowBefore($curentLine + 1, 1);
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$curentLine, "");
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$curentLine, "----");
				
		
			$curentLine++;
			$objPHPExcel->getActiveSheet()->insertNewRowBefore($curentLine + 1, 1);
			// total H.T.
			$temp = "Total H.T.";
			if ($people[4][0] != "1"){
				$temp .= "\n (dont frais de gestion 10%)"; 
				$objPHPExcel->getActiveSheet()
				->getRowDimension($curentLine)
				->setRowHeight(25);
			}
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$curentLine, $temp);
			
			if ($people[4][0] != "1"){
				$honoraireFrais = 0.1*$honoraireTotal;
				$honoraireTotal += $honoraireFrais;
			}
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$curentLine, number_format(round($honoraireTotal,2), 2, ',', ' ')." €");
			
			$objPHPExcel->getActiveSheet()->getStyle('E'.$curentLine)->applyFromArray($styleTableCell);
			$objPHPExcel->getActiveSheet()->getStyle('E'.$curentLine)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('F'.$curentLine)->applyFromArray($styleTableCell);
		}
		*/
		
		// TVA 20p
		$curentLine++;
		$objPHPExcel->getActiveSheet()->insertNewRowBefore($curentLine + 1, 1);
		$objPHPExcel->getActiveSheet()->SetCellValue('E'.$curentLine, "T.V.A.:20%");
		$honoraireTVA = 0.2*$honoraireTotal;
		$honoraireTVA = number_format(round($honoraireTVA,2), 2, '.', ' ');
		$honoraireTotal += $honoraireTVA;
		$objPHPExcel->getActiveSheet()->SetCellValue('F'.$curentLine, number_format(round($honoraireTVA,2), 2, ',', ' ')." €");
		
		$objPHPExcel->getActiveSheet()->getStyle('E'.$curentLine)->applyFromArray($styleTableCell);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$curentLine)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('F'.$curentLine)->applyFromArray($styleTableCell);
		
		// space
		$curentLine++;
		$objPHPExcel->getActiveSheet()->insertNewRowBefore($curentLine + 1, 1);
		$objPHPExcel->getActiveSheet()->SetCellValue('E'.$curentLine, "");
		$objPHPExcel->getActiveSheet()->SetCellValue('F'.$curentLine, "----");
		
		// TTC
		$curentLine++;
		$objPHPExcel->getActiveSheet()->insertNewRowBefore($curentLine + 1, 1);
		$objPHPExcel->getActiveSheet()->SetCellValue('E'.$curentLine, "Total T.T.C.");
		$objPHPExcel->getActiveSheet()->SetCellValue('F'.$curentLine, number_format(round($honoraireTotal,2), 2, ',', ' ')." €");		

		$objPHPExcel->getActiveSheet()->getStyle('E'.$curentLine)->applyFromArray($styleTableCell);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$curentLine)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('F'.$curentLine)->applyFromArray($styleTableCellTotal);
		
		// Save the xls file
		$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
		$nom = $unitName . '_' . $responsibleFullName . "_" . date("d-m-Y", $searchDate_start) . "_" . date("d-m-Y", $searchDate_end-3600) ."_facture_sygrrif.xls";
		
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$nom.'"');
		header('Cache-Control: max-age=0');
		$objWriter->save('php://output');
			
	}

	/**
	 * Generate a counting of the reserrvations for a given unit
	 * @param date $searchDate_start Starting date of the counting
	 * @param date $searchDate_end   End date of the counting
	 * @param number $unit_id ID of the unit to count
	 * @param number $responsible_id ID of the responsible to count
	 */
	public function generateCounting($searchDate_start, $searchDate_end, $unit_id, $responsible_id){
		
		require_once ("externals/PHPExcel/Classes/PHPExcel.php");
		require_once ("externals/PHPExcel/Classes/PHPExcel/Writer/Excel5.php");
		require_once ("externals/PHPExcel/Classes/PHPExcel/Writer/Excel2007.php");
		
		// /////////////////////////////////////////// //
		//        get the input informations           //
		// /////////////////////////////////////////// //
		// convert start date to unix date
		$tabDate = explode("-",$searchDate_start);
		$date_debut = $tabDate[2].'/'.$tabDate[1].'/'.$tabDate[0];
		$searchDate_start= mktime(0,0,0,$tabDate[1],$tabDate[2],$tabDate[0]);
		
		// convert end date to unix date
		$tabDate = explode("-",$searchDate_end);
		$date_fin = $tabDate[2].'/'.$tabDate[1].'/'.$tabDate[0];
		$searchDate_end= mktime(0,0,0,$tabDate[1],$tabDate[2]+1,$tabDate[0]);
		
		// respondible fullname
		$modelUser = new User();
		$responsibleFullName = $modelUser->getUserFUllName($responsible_id);
		
		// unit name
		$unitName = "";
		if ($unit_id > 0){
			$modelUnit = new Unit();
			$unitName = $modelUnit->getUnitName($unit_id);
		}
		
		
		//----------------------------------------------------------------------------
		$q = array('start'=>$searchDate_start, 'end'=>$searchDate_end);
		$sql = 'SELECT DISTINCT recipient_id FROM sy_calendar_entry WHERE
		(start_time <:start AND end_time <= :end AND end_time>:start) OR
		(start_time >=:start AND end_time <= :end) OR
		(start_time >=:start AND start_time<:end AND end_time > :end) ORDER BY id';
		$req = $this->runRequest($sql, $q);
		$beneficiaire = $req->fetchAll();
		
		
		if (count($beneficiaire) == 0){
			return ;
		}
		
		$i=0;
		$people = array();
		foreach($beneficiaire as $b){
			// user info
			$modelUser = new User();
			$nomPrenom = $modelUser->getUserFromIdUnit(($b[0]), $unit_id);
			if (count($nomPrenom) != 0){
				
				if ($responsible_id == $modelUser->getUserResponsible($b[0])){
					// name, firstname, id_responsible
					$people[0][$i] = $nomPrenom[0]["name"]; 	//Nom du beneficiaire
					$people[1][$i] = $nomPrenom[0]["firstname"]; 	//Prénom du bénéficiaire
					$people[2][$i] = $b[0];				//Login du bénéficiaire
					$people[3][$i] = $modelUser->getUserFUllName($nomPrenom[0]["id_responsible"]);	//Responsable du bénéficiaire
					$people[4][$i] = $unitName;	//laboratoire du bénificiaire
					$i++;
				}
			}
		}
		array_multisort($people[0],SORT_ASC,$people[1],$people[2],$people[3],$people[4]);
		
		$sql = 'SELECT id, name, area_id FROM sy_resources ORDER BY name';
		$req = $this->runRequest($sql);
		$equipement = $req->fetchAll();
		
		$i=0;
		foreach($equipement as $e){
			$numRes = 0;
			for ($j = 0; $j < count($people[0]); $j++) {
				$q = array('start'=>$searchDate_start, 'end'=>$searchDate_end, 'room_id'=>$e[0], 'beneficiaire'=>$people[2][$j]);
				$sql = 'SELECT * FROM sy_calendar_entry WHERE start_time >=:start AND end_time <= :end AND resource_id=:room_id AND recipient_id=:beneficiaire';
				$req = $this->runRequest($sql, $q);
				$numRes += $req->rowCount();
			}
			if ($numRes != 0){
				$room[0][$i] = $e[0]; // id
				$room[1][$i] = $e[1]; // name
				$room[2][$i] = $e[2]; // id area
				$i++;
			}
		}
		$numOfEquipement = count($room[0]);
		
		// //////////////////////////////////////////////// //
		//              Put results in a xls file           //
		// //////////////////////////////////////////////// //
		$nom = date('Y-m-d')."_decompte_heures_sygrrif.xlsx";
		$today=date('d/m/Y');
		$header = "Date d'édition de ce document : \n".$today;
		$titre = "Décompte des heures réservés du ".$date_debut." inclu au ".$date_fin." inclu";
		
		//$footer = "https://bioimagerie.univ-rennes1.fr/h2p2_db-demo/exportFiles/".$nom;
		$footer = $nom;
		
		
		// Création de l'objet
		$objPHPExcel = new PHPExcel();
		
		// Définition de quelques propriétés
		$objPHPExcel->getProperties()->setCreator("Plate-forme" . Configuration::get("name"));
		$objPHPExcel->getProperties()->setLastModifiedBy("Plate-forme" . Configuration::get("name"));
		$objPHPExcel->getProperties()->setTitle("Liste d'utilisateurs autorises");
		$objPHPExcel->getProperties()->setSubject("Export SyGRRiF");
		$objPHPExcel->getProperties()->setDescription("Fichier genere avec PHPExel depuis la base de donnees SyGRRif");
		
		
		$center=array('alignment'=>array('horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'=>PHPExcel_Style_Alignment::VERTICAL_CENTER));
		$gras=array('font' => array('bold' => true));
		$border=array(
				'borders'=>array(
						'top'=>array(
								'style'=>PHPExcel_Style_Border::BORDER_MEDIUM),
						'left'=>array(
								'style'=>PHPExcel_Style_Border::BORDER_MEDIUM),
						'right'=>array(
								'style'=>PHPExcel_Style_Border::BORDER_MEDIUM),
						'bottom'=>array(
								'style'=>PHPExcel_Style_Border::BORDER_MEDIUM)));
		$borderLR=array(
				'borders'=>array(
						'top'=>array(
								'style'=>PHPExcel_Style_Border::BORDER_NONE),
						'left'=>array(
								'style'=>PHPExcel_Style_Border::BORDER_THIN),
						'right'=>array(
								'style'=>PHPExcel_Style_Border::BORDER_THIN),
						'bottom'=>array(
								'style'=>PHPExcel_Style_Border::BORDER_NONE)));
		
		$borderR=array(
				'borders'=>array(
						'top'=>array(
								'style'=>PHPExcel_Style_Border::BORDER_NONE),
						'left'=>array(
								'style'=>PHPExcel_Style_Border::BORDER_NONE),
						'right'=>array(
								'style'=>PHPExcel_Style_Border::BORDER_THIN),
						'bottom'=>array(
								'style'=>PHPExcel_Style_Border::BORDER_NONE)));
		
		$borderLR_Gras=array(
				'borders'=>array(
						'top'=>array(
								'style'=>PHPExcel_Style_Border::BORDER_NONE),
						'left'=>array(
								'style'=>PHPExcel_Style_Border::BORDER_MEDIUM),
						'right'=>array(
								'style'=>PHPExcel_Style_Border::BORDER_MEDIUM),
						'bottom'=>array(
								'style'=>PHPExcel_Style_Border::BORDER_NONE)));
		
		$borderRB=array(
				'borders'=>array(
						'top'=>array(
								'style'=>PHPExcel_Style_Border::BORDER_MEDIUM),
						'left'=>array(
								'style'=>PHPExcel_Style_Border::BORDER_NONE),
						'right'=>array(
								'style'=>PHPExcel_Style_Border::BORDER_THIN),
						'bottom'=>array(
								'style'=>PHPExcel_Style_Border::BORDER_MEDIUM)));
		
		$borderTop=array(
				'borders'=>array(
						'top'=>array(
								'style'=>PHPExcel_Style_Border::BORDER_THIN),
						'left'=>array(
								'style'=>PHPExcel_Style_Border::BORDER_NONE),
						'right'=>array(
								'style'=>PHPExcel_Style_Border::BORDER_NONE),
						'bottom'=>array(
								'style'=>PHPExcel_Style_Border::BORDER_NONE)));
		
		$style = array(
				'font'  => array(
						'bold'  => false,
						'color' => array('rgb' => '000000'),
						'size'  => 13,
						'name'  => 'Calibri'
				));
		
		// Nommage de la feuille
		$objPHPExcel->setActiveSheetIndex(0);
		$sheet=$objPHPExcel->getActiveSheet();
		$sheet->setTitle('Liste utilisateurs');
		
		// Mise en page de la feuille
		$sheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$sheet->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
		$sheet->getPageSetup()->setFitToWidth(1);
		$sheet->getPageSetup()->setFitToHeight(10);
		$sheet->getPageMargins()->SetTop(0.7);
		$sheet->getPageMargins()->SetBottom(0.2);
		$sheet->getPageMargins()->SetLeft(0.2);
		$sheet->getPageMargins()->SetRight(0.2);
		$sheet->getPageMargins()->SetHeader(0.2);
		$sheet->getPageMargins()->SetFooter(0.2);
		//$sheet->getPageSetup()->setHorizontalCentered(true);
		//$sheet->getPageSetup()->setVerticalCentered(false);
		
		$sheet->getColumnDimension('A')->setWidth(40);
		
		$colonne='B';
		for ($i = 0; $i < $numOfEquipement; $i++) {
			$sheet->getColumnDimension($colonne)->setWidth(20);
			$colonne++;
		}
		$sheet->getColumnDimension($colonne)->setWidth(10);
		
		// Header
		$objDrawing = new PHPExcel_Worksheet_HeaderFooterDrawing();
		$objDrawing->setName('PHPExcel logo');
		$objDrawing->setPath('./Themes/logo.jpg');
		$objDrawing->setHeight(60);
		$objPHPExcel->getActiveSheet()->getHeaderFooter()->addImage($objDrawing, PHPExcel_Worksheet_HeaderFooter::IMAGE_HEADER_LEFT);
		$sheet->getHeaderFooter()->setOddHeader('&L&G&R'.$header);
		
		// Titre
		$colonne='A';
		$colFin='A';
		for ($i = 0; $i <= $numOfEquipement; $i++) { $colFin++; }
		$ligne=1;
		$sheet->getRowDimension($ligne)->setRowHeight(25);
		$sheet->mergeCells($colonne.$ligne.':'.$colFin.$ligne);
		$sheet->SetCellValue($colonne.$ligne, $titre);
		$sheet->getStyle($colonne.$ligne)->applyFromArray($style);
		$sheet->getStyle($colonne.$ligne)->applyFromArray($gras);
		$sheet->getStyle($colonne.$ligne)->applyFromArray($center);
		$sheet->getStyle($colonne.$ligne)->getAlignment()->setWrapText(true);
		
		
		// Nom des équipements
		$ligne=2;
		$colonne='B';
		for ($i = 0; $i < $numOfEquipement; $i++) {
			$sheet->SetCellValue($colonne.$ligne,$room[1][$i]);
			$sheet->getStyle($colonne.$ligne)->applyFromArray($center);
			$sheet->getStyle($colonne.$ligne)->applyFromArray($gras);
			$sheet->getStyle($colonne.$ligne)->applyFromArray($border);
			$colonne++;
		}
		$sheet->SetCellValue($colonne.$ligne,"Total");
		$sheet->getStyle($colonne.$ligne)->applyFromArray($center);
		$sheet->getStyle($colonne.$ligne)->applyFromArray($gras);
		$sheet->getStyle($colonne.$ligne)->applyFromArray($border);
		
		// Nom des bénéficiaires
		$ligne=3;
		$colonne='A';
		$heureEquipement = array();
		for ($i = 0; $i < count($people[0]); $i++) {
			$colonne='A';
			$sheet->getRowDimension($ligne)->setRowHeight(50);
			$sheet->getStyle($colonne.$ligne)->getAlignment()->setWrapText(true);
			$sheet->SetCellValue($colonne.$ligne,$people[0][$i]." ".$people[1][$i]."\n(Labo.: ".$people[4][$i]."\nResp.: ".$people[3][$i].")");
			$sheet->getStyle($colonne.$ligne)->applyFromArray($center);
			$sheet->getStyle($colonne.$ligne)->applyFromArray($border);
		
			$colonne++;
			$heureBeneficiaire = 0;
			for ($j = 0; $j < $numOfEquipement; $j++) {
				$heureEquipement[$j] = 0;	
				$sql = 'SELECT size_bloc_resa FROM sy_resources_calendar WHERE id_resource=?';
				$req = $this->runRequest($sql, array($room[0][$j]));
				$descriptionDomaine = $req->fetchAll();
				$resolutionDomaine = $descriptionDomaine[0][0];
					
				$q = array('start'=>$searchDate_start, 'end'=>$searchDate_end, 'beneficiaire'=>$people[2][$i], 'room_id'=>$room[0][$j]);
				$sql = 'SELECT start_time, end_time FROM sy_calendar_entry WHERE start_time <:start AND end_time <= :end AND end_time>:start AND recipient_id=:beneficiaire AND resource_id=:room_id ORDER BY id';
				$req = $this->runRequest($sql, $q);
				$resBefore = $req->fetchAll();
				$numOfResBefore = $req->rowCount();
					
				//$heureBefore=0;
				//foreach($resBefore as $rB){
				//	$heureBefore += (($rB[1] - $searchDate_start)/3600);
					//}
						
				$heureBefore = 0;
				foreach($resBefore as $rB){
					$progress = $searchDate_start;
					while ($progress < $rB[1]){
						$progress += $resolutionDomaine;
						$heureBefore += $resolutionDomaine/3600;
					}
				}
						
				$q = array('start'=>$searchDate_start, 'end'=>$searchDate_end, 'beneficiaire'=>$people[2][$i], 'room_id'=>$room[0][$j]);
				$sql = 'SELECT start_time, end_time FROM sy_calendar_entry WHERE start_time >=:start AND end_time <= :end AND recipient_id=:beneficiaire AND resource_id=:room_id ORDER BY id';
				$req = $this->runRequest($sql, $q);
				$resIn = $req->fetchAll();
				$numOfResIn = $req->rowCount();
						
				//$heureIn = 0;
				//foreach($resIn as $rI){
				//	$heureIn += (($rI[1] - $rI[0])/3600);
				//}
						
				$heureIn = 0;
				foreach($resIn as $rI){
					$progress = $rI[0];
					while ($progress < $rI[1]){
						$progress += $resolutionDomaine;
						$heureIn += $resolutionDomaine/3600;
					}
				}
					
				$q = array('start'=>$searchDate_start, 'end'=>$searchDate_end, 'beneficiaire'=>$people[2][$i], 'room_id'=>$room[0][$j]);
				$sql = 'SELECT start_time, end_time FROM sy_calendar_entry WHERE start_time >=:start AND start_time<:end AND end_time > :end AND recipient_id=:beneficiaire AND resource_id=:room_id ORDER BY id';
				$req = $this->runRequest($sql, $q);
				$numOfResAfter = $req->rowCount();
				$resAfter = $req->fetchAll();
					
						
				//$heureAfter = 0;
				//foreach($resAfter as $rA){
				//	$heureAfter += (($searchDate_end - $rA[0])/3600);
				//}
						
				$heureAfter = 0;
				foreach($resAfter as $rA){
					$progress = $rA[0];
					while ($progress < $searchDate_end){
						$progress += $resolutionDomaine;
						$heureAfter += $resolutionDomaine/3600;
					}
				}
						
				$numOfReservation = $numOfResIn + $numOfResAfter;
				$heureTotale = $heureIn + $heureAfter;
				$heureEquipement[$j] += $heureTotale;
				$heureBeneficiaire += $heureTotale;
						
				$sheet->SetCellValue($colonne.$ligne,$heureTotale);
				$sheet->getStyle($colonne.$ligne)->applyFromArray($center);
				$sheet->getStyle($colonne.$ligne)->applyFromArray($borderR);
				$colonne++;
			}
			$sheet->SetCellValue($colonne.$ligne,$heureBeneficiaire);
			$sheet->getStyle($colonne.$ligne)->applyFromArray($center);
			$sheet->getStyle($colonne.$ligne)->applyFromArray($borderLR_Gras);

			$ligne++;
		}
		$colonne='A';
		$sheet->getRowDimension($ligne)->setRowHeight(25);
		$sheet->getStyle($colonne.$ligne)->getAlignment()->setWrapText(true);
		$sheet->SetCellValue($colonne.$ligne,"Total");
		$sheet->getStyle($colonne.$ligne)->applyFromArray($center);
		$sheet->getStyle($colonne.$ligne)->applyFromArray($border);
		
		$colonne++;
		$heureGlobale=0;
		for ($j = 0; $j < $numOfEquipement; $j++) {
			$sheet->SetCellValue($colonne.$ligne,$heureEquipement[$j]);
			$sheet->getStyle($colonne.$ligne)->applyFromArray($center);
			$sheet->getStyle($colonne.$ligne)->applyFromArray($borderRB);
			$colonne++;
			$heureGlobale += $heureEquipement[$j];
		}
		$sheet->SetCellValue($colonne.$ligne,$heureGlobale);
		$sheet->getStyle($colonne.$ligne)->applyFromArray($center);
		$sheet->getStyle($colonne.$ligne)->applyFromArray($borderRB);
		
		// Footer
		$sheet->getHeaderFooter()->setOddFooter('&L '.$footer.'&R Page &P / &N');
		$sheet->getHeaderFooter()->setEvenFooter('&L '.$footer.'&R Page &P / &N');
		
		$ImageNews='./Themes/logo.jpg';

		//on récupère l'extension du fichier
		$ExtensionPresumee = explode('.', $ImageNews);
		$ExtensionPresumee = strtolower($ExtensionPresumee[count($ExtensionPresumee)-1]);
		//on utilise la fonction php associé au bon type d'image
		if ($ExtensionPresumee == 'jpg' || $ExtensionPresumee == 'jpeg'){
			$ImageChoisie = imagecreatefromjpeg($ImageNews);
		}
		elseif($ExtensionPresumee == 'gif'){
			$ImageChoisie = imagecreatefromgif($ImageNews);
		}
		elseif($ExtensionPresumee == 'png'){
			$ImageChoisie = imagecreatefrompng($ImageNews);
		}
		
		//je redimensionne l’image
		$TailleImageChoisie = getimagesize($ImageNews);
		//la largeur voulu dans le document excel
		//$NouvelleLargeur = 150;
		$NouvelleHauteur = 80;
		//calcul du pourcentage de réduction par rapport à l’original
		//$Reduction = ( ($NouvelleLargeur * 100)/$TailleImageChoisie[0] );
		$Reduction = ( ($NouvelleHauteur * 100)/$TailleImageChoisie[1] );
		//PHPExcel m’aplatit verticalement l’image donc j’ai calculé de ratio d’applatissement de l’image et je l’étend préalablement
		//$NouvelleHauteur = (($TailleImageChoisie[1] * $Reduction)/100 );
		$NouvelleLargeur = (($TailleImageChoisie[0] * $Reduction)/100 );
		//j’initialise la nouvelle image
		$NouvelleImage = imagecreatetruecolor($NouvelleLargeur , $NouvelleHauteur) or die (“Erreur”);
		
		//je mets l’image obtenue après redimensionnement en variable
		imagecopyresampled($NouvelleImage , $ImageChoisie, 0, 0, 0, 0, $NouvelleLargeur, $NouvelleHauteur, $TailleImageChoisie[0],$TailleImageChoisie[1]);
		$gdImage=$NouvelleImage;
		
		//on créé l’objet de dessin et on lui donne un nom, l’image, la position de l’image, la compression de l’image, le type mime…
		$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
		$objDrawing->setName('Sample image');
		$objDrawing->setImageResource($gdImage);
		$objDrawing->setCoordinates('A1');
		$objDrawing->setOffsetX(50);
		$objDrawing->setOffsetY(8);
		$objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
		$objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
		//enfin on l’envoie à la feuille de calcul !
		//$objDrawing->setWorksheet($sheet);
		$writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		
		//$writer->save('./exportFiles/'.$nom);
		header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
		header('Content-Disposition: attachment;filename="'.$nom.'"');
		header('Cache-Control: max-age=0');
		
		$writer->save('php://output');
		
	}
	
	/**
	 * Generate a file containing the de details of all the reservation of a unit in a given period
	 * @param unknown $searchDate_start Starting date of the bill
	 * @param unknown $searchDate_end   End date of the bill
	 * @param number $unit_id ID of the unit to bill
	 * @param number $responsible_id ID of the responsible to bill
	 */
	public function generateDetail($searchDate_start, $searchDate_end, $unit_id, $responsible_id){
		
		include_once ("externals/PHPExcel/Classes/PHPExcel.php");
		include_once ("externals/PHPExcel/Classes/PHPExcel/Writer/Excel5.php");
		include_once ("externals/PHPExcel/Classes/PHPExcel/Writer/Excel2007.php");
		
		// /////////////////////////////////////////// // 
		//        get the input informations           //
		// /////////////////////////////////////////// //
		// convert start date to unix date
		$tabDate = explode("-",$searchDate_start);
		$date_debut = $tabDate[2].'/'.$tabDate[1].'/'.$tabDate[0];
		$searchDate_start= mktime(0,0,0,$tabDate[1],$tabDate[2],$tabDate[0]);
		
		// convert end date to unix date
		$tabDate = explode("-",$searchDate_end);
		$date_fin = $tabDate[2].'/'.$tabDate[1].'/'.$tabDate[0];
		$searchDate_end= mktime(0,0,0,$tabDate[1],$tabDate[2]+1,$tabDate[0]);
		
		$laboratoire = $unit_id;
		$modelUnit = new Unit();
		$unitInfo = $modelUnit->getUnit($unit_id);
		
		//----------------------------------------------------------------------------
		
		//On liste l'ensemble des réservations sur la période sélectionnée
		$q = array('start'=>$searchDate_start, 'end'=>$searchDate_end);
		$sql = 'SELECT DISTINCT recipient_id FROM sy_calendar_entry WHERE
		(start_time <:start AND end_time <= :end AND end_time>:start) OR
		(start_time >=:start AND end_time <= :end) OR
		(start_time >=:start AND start_time<:end AND end_time > :end) ORDER BY id';
		$req = $this->runRequest($sql, $q);
		$beneficiaire = $req->fetchAll();
		
		$i=0;
		foreach($beneficiaire as $b){
			// user info
			$modelUser = new User();
			$nomPrenom = $modelUser->getUserFromIdUnit(($b[0]), $unit_id);
			// name, firstname, id_responsible
			if (count($nomPrenom) != 0){
				$people[0][$i] = $nomPrenom[0]["name"]; 	//Nom du beneficiaire
				$people[1][$i] = $nomPrenom[0]["firstname"]; 	//Prénom du bénéficiaire
				$people[2][$i] = $b[0];				//Login du bénéficiaire
				$people[3][$i] = $modelUser->getUserFUllName($nomPrenom[0]["id_responsible"]);	//Responsable du bénéficiaire
				$people[4][$i] = $unitInfo['name'];	//laboratoire du bénificiaire
				$i++;
			}
		}
		array_multisort($people[0],SORT_ASC,$people[1],$people[2],$people[3],$people[4]);
		
		$liste_beneficiaire = '';
		for ($j = 0; $j < count($people[0]); $j++) {
			$liste_beneficiaire .= 'recipient_id="'.$people[2][$j].'"';
			if ($j < (count($people[0])-1)) {
				$liste_beneficiaire .= " OR ";
			}
		}
		
		$q = array('start'=>$searchDate_start, 'end'=>$searchDate_end);
		$sql = 'SELECT * FROM sy_calendar_entry WHERE start_time <:start AND end_time <= :end AND end_time>:start';
		if ($laboratoire != '0'){
			$sql .= ' AND ('.$liste_beneficiaire.')';
		}
		$sql .= ' ORDER BY start_time, end_time';
		$req = $this->runRequest($sql, $q);
		$resBefore = $req->fetchAll();
		$numOfResBefore = $req->rowCount();
		
		$q = array('start'=>$searchDate_start, 'end'=>$searchDate_end);
		$sql = 'SELECT * FROM sy_calendar_entry WHERE start_time >=:start AND end_time <= :end';
		if ($laboratoire != "0"){
			$sql .= ' AND ('.$liste_beneficiaire.')';
		}
		$sql .= ' ORDER BY start_time, end_time';
		$req = $this->runRequest($sql, $q);
		$resIn = $req->fetchAll();
		$numOfResIn = $req->rowCount();
		
		$q = array('start'=>$searchDate_start, 'end'=>$searchDate_end);
		$sql = 'SELECT * FROM sy_calendar_entry WHERE start_time >=:start AND start_time<:end AND end_time > :end';
		if ($laboratoire != "0"){
			$sql .= ' AND ('.$liste_beneficiaire.')';
		}
		$sql .= ' ORDER BY start_time, end_time';
		$req = $this->runRequest($sql, $q);
		$resAfter = $req->fetchAll();
		$numOfResAfter = $req->rowCount();

		// ///////////////////////////////////////// //
		//          Write xlsx content               //
		// ///////////////////////////////////////// //
		
		$nom = date('Y-m-d')."_detail_heures_sygrrif.xlsx";
		$today=date('d/m/Y');
		$header = "Date d'édition de ce document : \n".$today;
		$titre = "Détail des heures réservés du ".$date_debut." inclus au ".$date_fin." inclus";
		
		$footer = $nom;
		
		
		// Création de l'objet
		$objPHPExcel = new PHPExcel();
		
		// Définition de quelques propriétés
		$objPHPExcel->getProperties()->setCreator("Plate-forme " . Configuration::get("name"));
		$objPHPExcel->getProperties()->setLastModifiedBy("Plate-forme " . Configuration::get("name"));
		$objPHPExcel->getProperties()->setTitle("Liste d'utilisateurs autorises");
		$objPHPExcel->getProperties()->setSubject("Export SyGRRiF");
		$objPHPExcel->getProperties()->setDescription("Fichier genere avec PHPExel depuis la base de donnees SyGrrif");
		
		
		$center=array('alignment'=>array('horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'=>PHPExcel_Style_Alignment::VERTICAL_CENTER));
		$gras=array('font' => array('bold' => true));
		$border=array(
				'borders'=>array(
						'top'=>array(
								'style'=>PHPExcel_Style_Border::BORDER_MEDIUM),
						'left'=>array(
								'style'=>PHPExcel_Style_Border::BORDER_MEDIUM),
						'right'=>array(
								'style'=>PHPExcel_Style_Border::BORDER_MEDIUM),
						'bottom'=>array(
								'style'=>PHPExcel_Style_Border::BORDER_MEDIUM)));
		$borderLR=array(
				'borders'=>array(
						'top'=>array(
								'style'=>PHPExcel_Style_Border::BORDER_NONE),
						'left'=>array(
								'style'=>PHPExcel_Style_Border::BORDER_THIN),
						'right'=>array(
								'style'=>PHPExcel_Style_Border::BORDER_THIN),
						'bottom'=>array(
								'style'=>PHPExcel_Style_Border::BORDER_NONE)));
		
		$borderR=array(
				'borders'=>array(
						'top'=>array(
								'style'=>PHPExcel_Style_Border::BORDER_NONE),
						'left'=>array(
								'style'=>PHPExcel_Style_Border::BORDER_NONE),
						'right'=>array(
								'style'=>PHPExcel_Style_Border::BORDER_THIN),
						'bottom'=>array(
								'style'=>PHPExcel_Style_Border::BORDER_NONE)));
		
		$borderLR_Gras=array(
				'borders'=>array(
						'top'=>array(
								'style'=>PHPExcel_Style_Border::BORDER_NONE),
						'left'=>array(
								'style'=>PHPExcel_Style_Border::BORDER_MEDIUM),
						'right'=>array(
								'style'=>PHPExcel_Style_Border::BORDER_MEDIUM),
						'bottom'=>array(
								'style'=>PHPExcel_Style_Border::BORDER_NONE)));
		
		$borderRB=array(
				'borders'=>array(
						'top'=>array(
								'style'=>PHPExcel_Style_Border::BORDER_MEDIUM),
						'left'=>array(
								'style'=>PHPExcel_Style_Border::BORDER_NONE),
						'right'=>array(
								'style'=>PHPExcel_Style_Border::BORDER_THIN),
						'bottom'=>array(
								'style'=>PHPExcel_Style_Border::BORDER_MEDIUM)));
		
		$borderTop=array(
				'borders'=>array(
						'top'=>array(
								'style'=>PHPExcel_Style_Border::BORDER_THIN),
						'left'=>array(
								'style'=>PHPExcel_Style_Border::BORDER_NONE),
						'right'=>array(
								'style'=>PHPExcel_Style_Border::BORDER_NONE),
						'bottom'=>array(
								'style'=>PHPExcel_Style_Border::BORDER_NONE)));
		
		$style = array(
				'font'  => array(
						'bold'  => false,
						'color' => array('rgb' => '000000'),
						'size'  => 15,
						'name'  => 'Calibri'
				));
		
		// Nommage de la feuille
		$objPHPExcel->setActiveSheetIndex(0);
		$sheet=$objPHPExcel->getActiveSheet();
		$sheet->setTitle('Liste utilisateurs');
		
		// Mise en page de la feuille
		$sheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$sheet->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
		$sheet->getPageSetup()->setFitToWidth(1);
		$sheet->getPageSetup()->setFitToHeight(10);
		$sheet->getPageMargins()->SetTop(0.7);
		$sheet->getPageMargins()->SetBottom(0.2);
		$sheet->getPageMargins()->SetLeft(0.2);
		$sheet->getPageMargins()->SetRight(0.2);
		$sheet->getPageMargins()->SetHeader(0.2);
		$sheet->getPageMargins()->SetFooter(0.2);
		//$sheet->getPageSetup()->setHorizontalCentered(true);
		//$sheet->getPageSetup()->setVerticalCentered(false);
		
		// Header
		$objDrawing = new PHPExcel_Worksheet_HeaderFooterDrawing();
		$objDrawing->setName('PHPExcel logo');
		$objDrawing->setPath('./Themes/logo.jpg');
		$objDrawing->setHeight(60);
		$objPHPExcel->getActiveSheet()->getHeaderFooter()->addImage($objDrawing, PHPExcel_Worksheet_HeaderFooter::IMAGE_HEADER_LEFT);
		$sheet->getHeaderFooter()->setOddHeader('&L&G&R'.$header);
		
		// Titre
		$ligne=1;
		$sheet->getRowDimension($ligne)->setRowHeight(25);
		$sheet->mergeCells('A'.$ligne.':F'.$ligne);
		$sheet->SetCellValue('A'.$ligne, $titre);
		$sheet->getStyle('A'.$ligne)->applyFromArray($style);
		$sheet->getStyle('A'.$ligne)->applyFromArray($gras);
		$sheet->getStyle('A'.$ligne)->applyFromArray($center);
		$sheet->getStyle('A'.$ligne)->getAlignment()->setWrapText(true);
		
		
		// Nom des colonnes
		$ligne=2;
		$colonne='A';
		$sheet->getColumnDimension($colonne)->setWidth(20);
		$sheet->SetCellValue($colonne.$ligne,"N° de réservation");
		$sheet->getStyle($colonne.$ligne)->applyFromArray($center);
		$sheet->getStyle($colonne.$ligne)->applyFromArray($gras);
		$sheet->getStyle($colonne.$ligne)->applyFromArray($border);
		$colonne++;
		$sheet->getColumnDimension($colonne)->setWidth(35);
		$sheet->SetCellValue($colonne.$ligne,"Date de début\n&\nDate de fin");
		$sheet->getStyle($colonne.$ligne)->getAlignment()->setWrapText(true);
		$sheet->getStyle($colonne.$ligne)->applyFromArray($center);
		$sheet->getStyle($colonne.$ligne)->applyFromArray($gras);
		$sheet->getStyle($colonne.$ligne)->applyFromArray($border);
		$colonne++;
		$sheet->getColumnDimension($colonne)->setWidth(20);
		$sheet->SetCellValue($colonne.$ligne,"Nombre d'heure");
		$sheet->getStyle($colonne.$ligne)->getAlignment()->setWrapText(true);
		$sheet->getStyle($colonne.$ligne)->applyFromArray($center);
		$sheet->getStyle($colonne.$ligne)->applyFromArray($gras);
		$sheet->getStyle($colonne.$ligne)->applyFromArray($border);
		$colonne++;
		$sheet->getColumnDimension($colonne)->setWidth(35);
		$sheet->SetCellValue($colonne.$ligne,"Domaine\n&\nEquipement");
		$sheet->getStyle($colonne.$ligne)->getAlignment()->setWrapText(true);
		$sheet->getStyle($colonne.$ligne)->applyFromArray($center);
		$sheet->getStyle($colonne.$ligne)->applyFromArray($gras);
		$sheet->getStyle($colonne.$ligne)->applyFromArray($border);
		$colonne++;
		$sheet->getColumnDimension($colonne)->setWidth(35);
		$sheet->SetCellValue($colonne.$ligne,"Bénéficiaire\n(Réservé par)");
		$sheet->getStyle($colonne.$ligne)->getAlignment()->setWrapText(true);
		$sheet->getStyle($colonne.$ligne)->applyFromArray($center);
		$sheet->getStyle($colonne.$ligne)->applyFromArray($gras);
		$sheet->getStyle($colonne.$ligne)->applyFromArray($border);
		$colonne++;
		$sheet->getColumnDimension($colonne)->setWidth(35);
		$sheet->SetCellValue($colonne.$ligne,"Dernière mise à jour");
		$sheet->getStyle($colonne.$ligne)->getAlignment()->setWrapText(true);
		$sheet->getStyle($colonne.$ligne)->applyFromArray($center);
		$sheet->getStyle($colonne.$ligne)->applyFromArray($gras);
		$sheet->getStyle($colonne.$ligne)->applyFromArray($border);
		
		//
		$unwanted_array = array(    'Monday'=>'Lundi', 'Tuesday'=>'Mardi', 'Wednesday'=>'Mercredi', 'Thursday'=>'Jeudi',
				'Friday'=>'Vendredi', 'Saturday'=>'Samedi', 'Sunday'=>'Dimanche',
				'Jan'=>'Jan', 'Feb'=>'Fév', 'Mar'=>'Mar', 'Apr'=>'Avr', 'May'=>'Mai', 'Jun'=>'Juin', 'Jul'=>'Juil',
				'Aug'=>'Aoû', 'Sep'=>'Sep', 'Oct'=>'Oct', 'Nov'=>'Nov', 'Dec'=>'Déc');
		
		$ligne=3;
		foreach($resIn as $rI){
			$colonne='A';
			$sheet->getRowDimension($ligne)->setRowHeight(40);
		
			$sheet->SetCellValue($colonne.$ligne,$rI[0]);
			$sheet->getStyle($colonne.$ligne)->getAlignment()->setWrapText(true);
			$sheet->getStyle($colonne.$ligne)->applyFromArray($center);
			$sheet->getStyle($colonne.$ligne)->applyFromArray($border);
			$colonne++;
			$dDebut = strtr(date('l d M',$rI[1])." à ".date('H',$rI[1])."h".date('i',$rI[1]),$unwanted_array);
			$dFin = strtr(date('l d M',$rI[2])." à ".date('H',$rI[2])."h".date('i',$rI[2]),$unwanted_array);
			$sheet->SetCellValue($colonne.$ligne,$dDebut."\n".$dFin);
			$sheet->getStyle($colonne.$ligne)->getAlignment()->setWrapText(true);
			$sheet->getStyle($colonne.$ligne)->applyFromArray($center);
			$sheet->getStyle($colonne.$ligne)->applyFromArray($border);
			$colonne++;
			$nbHeure = ($rI[2] - $rI[1])/3600;
			$sheet->SetCellValue($colonne.$ligne,$nbHeure);
			$sheet->getStyle($colonne.$ligne)->getAlignment()->setWrapText(true);
			$sheet->getStyle($colonne.$ligne)->applyFromArray($center);
			$sheet->getStyle($colonne.$ligne)->applyFromArray($border);
			$colonne++;

			$q = array('id'=>$rI["resource_id"]);
			$sql = 'SELECT name, area_id FROM sy_resources WHERE id=:id';
			$req = $this->runRequest($sql, $q);
			$res = $req->fetchAll();
			$room_name = $res[0][0];
			$area_id = $res[0][1];
		
			$q = array('id'=>$area_id);
			$sql = 'SELECT name FROM sy_areas WHERE id=:id';
			$req = $this->runRequest($sql, $q);
			$res = $req->fetchAll();
			$area_name = $res[0][0];
		
			$sheet->SetCellValue($colonne.$ligne,$area_name."\n".$room_name);
			$sheet->getStyle($colonne.$ligne)->getAlignment()->setWrapText(true);
			$sheet->getStyle($colonne.$ligne)->applyFromArray($center);
			$sheet->getStyle($colonne.$ligne)->applyFromArray($border);
			$colonne++;
		
			$q = array('login'=>$rI["recipient_id"]);
			$sql = 'SELECT name, firstname FROM core_users WHERE id=:login';
			$req = $this->runRequest($sql, $q);
			$nomPrenom = $req->fetchAll();
			$beneficiaire = $nomPrenom[0][0]." ".$nomPrenom[0][1];
		
			$q = array('login'=>$rI["booked_by_id"]);
			$sql = 'SELECT name, firstname FROM core_users WHERE id=:login';
			$req = $this->runRequest($sql, $q);
			$nomPrenom = $req->fetchAll();
			$createur = $nomPrenom[0][0]." ".$nomPrenom[0][1];
		
			if ($beneficiaire == $createur) {
				$sheet->SetCellValue($colonne.$ligne,$beneficiaire);
			}
			else {
				$sheet->SetCellValue($colonne.$ligne,$beneficiaire."\n(".$createur.")");
			}
			$sheet->getStyle($colonne.$ligne)->getAlignment()->setWrapText(true);
			$sheet->getStyle($colonne.$ligne)->applyFromArray($center);
			$sheet->getStyle($colonne.$ligne)->applyFromArray($border);
			$colonne++;
			$sheet->SetCellValue($colonne.$ligne,$rI[6]);
			$sheet->getStyle($colonne.$ligne)->getAlignment()->setWrapText(true);
			$sheet->getStyle($colonne.$ligne)->applyFromArray($center);
			$sheet->getStyle($colonne.$ligne)->applyFromArray($border);

			$ligne++;
		}
		
		// Footer
		$sheet->getHeaderFooter()->setOddFooter('&L '.$footer.'&R Page &P / &N');
		$sheet->getHeaderFooter()->setEvenFooter('&L '.$footer.'&R Page &P / &N');
		
		$writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		
		//$writer->save('./exportFiles/'.$nom);
		header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
		header('Content-Disposition: attachment;filename="'.$nom.'"');
		header('Cache-Control: max-age=0');
		
		$writer->save('php://output');
	}
	
	/**
	 * Internal method to set the bill number in the template file
	 * @param unknown $objPHPExcel Template file
	 * @return unknown Template file
	 */
	protected function replaceBillNumber($objPHPExcel){
		// replace the bill number
		// calculate the number
		$modelBill = new SyBill();
		$bills = $modelBill->getBills("number");
		$lastNumber = "";
		$number = "";
		if (count($bills) > 0){
			$lastNumber = $bills[count($bills)-1]["number"];
		}
		if ($lastNumber != ""){
			$lastNumber = explode("-", $lastNumber);
			$lastNumberY = $lastNumber[0];
			$lastNumberN = $lastNumber[1];
		
			if ($lastNumberY == date("Y", time())){
				$lastNumberN = (int)$lastNumberN + 1;
			}
			$num = "".$lastNumberN."";
			if ($lastNumberN < 10){
				$num = "00" . $lastNumberN;
			}
			else if ($lastNumberN >= 10 && $lastNumberN < 100){
				$num = "0" . $lastNumberN;
			}
			$number = $lastNumberY ."-". $num ;
		}
		else{
			$number = date("Y", time())."-001";
		}
		// replace the number
		$rowIterator = $objPHPExcel->getActiveSheet()->getRowIterator();
		$col = array("A", "B","C","D","E","F","G","H","I","J","K","L");
		$insertCol = "";
		$keyfound = false;
		foreach($rowIterator as $row) {
			for ($i = 0 ; $i < count($col) ; $i++){
				$rowIndex = $row->getRowIndex ();
				$num = $objPHPExcel->getActiveSheet()->getCell($col[$i].$rowIndex)->getValue();
				if (strpos($num,"{nombre}") !== false){
					$insertLine = $rowIndex;
					$insertCol = $col[$i];
					$keyfound = true;
					break;
				}
			}
		}
		if($keyfound){
			$objPHPExcel->getActiveSheet()->SetCellValue($insertCol.$insertLine, $number);
		}
		
		$output = array();
		$output[0] = $number; 
		$output[1] = $objPHPExcel; 
		return $output;
	}
	
	/**
	 * Internal method to set the bill date in the template file
	 * @param unknown $objPHPExcel Template file
	 * @return unknown Template filewn
	 */
	protected function replaceDate($objPHPExcel){
		// replace the date
		$rowIterator = $objPHPExcel->getActiveSheet()->getRowIterator();
		$col = array("A", "B","C","D","E","F","G","H","I","J","K","L");
		$insertCol = "";
		$keyfound = false;
		foreach($rowIterator as $row) {
			for ($i = 0 ; $i < count($col) ; $i++){
				$rowIndex = $row->getRowIndex ();
				$num = $objPHPExcel->getActiveSheet()->getCell($col[$i].$rowIndex)->getValue();
				if (strpos($num,"{date}") !== false){
					$insertLine = $rowIndex;
					$insertCol = $col[$i];
					$keyfound = true;
					break;
				}
			}
		}
		if ($keyfound){
			$objPHPExcel->getActiveSheet()->SetCellValue($insertCol.$insertLine, date("d/m/Y", time()));
		}
		return $objPHPExcel;
	}
	
	/**
	 * Internal method get the line index where the bill table starts
	 * @param unknown $objPHPExcel Template file
	 * @return number Line index
	 */
	protected function getTableLine($objPHPExcel){
		$insertLine = 0;
		$rowIterator = $objPHPExcel->getActiveSheet()->getRowIterator();
		foreach($rowIterator as $row) {
				
			$rowIndex = $row->getRowIndex ();
			$num = $objPHPExcel->getActiveSheet()->getCell("A".$rowIndex)->getValue();
			if (strpos($num,"{table}") !== false){
				$insertLine = $rowIndex;
				break;
			}
		}
		return $insertLine;
	}
	
	/**
	 * Internal method to set the bill roject name in the template file
	 * @param unknown $objPHPExcel Template file
	 * @param string $projectName Project name
	 * @return unknown Template file
	 */
	public function replaceProject($objPHPExcel, $projectName){
		// replace the date
		$rowIterator = $objPHPExcel->getActiveSheet()->getRowIterator();
		$col = array("A", "B","C","D","E","F","G","H","I","J","K","L");
		$insertCol = "";
		$keyfound = false;
		foreach($rowIterator as $row) {
			for ($i = 0 ; $i < count($col) ; $i++){
				$rowIndex = $row->getRowIndex ();
				$num = $objPHPExcel->getActiveSheet()->getCell($col[$i].$rowIndex)->getValue();
				if (strpos($num,"{projet}") !== false){
					$insertLine = $rowIndex;
					$insertCol = $col[$i];
					$keyfound = true;
					break;
				}
			}
		}
		if ($keyfound){
			$objPHPExcel->getActiveSheet()->SetCellValue($insertCol.$insertLine, $projectName);
		}
		return $objPHPExcel;
	}
}
	
?>