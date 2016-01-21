<?php

require_once 'Framework/Model.php';
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
			
			//ResAfter : Reservation qui commence dans la periode selectionnee et se termine aprÃ¨s la periode selectionnee
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
		
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$curentLine, "Nombre de \n seances");
		$objPHPExcel->getActiveSheet()->getStyle('B'.$curentLine)->applyFromArray($styleTableHeader);
		
		$objPHPExcel->getActiveSheet()->SetCellValue('C'.$curentLine, "Nombre d'heures");
		$objPHPExcel->getActiveSheet()->getStyle('C'.$curentLine)->applyFromArray($styleTableHeader);
		
		$titleUnitaryPricing = "Tarif Seance";
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
		$objPHPExcel->getActiveSheet()->SetCellValue('E'.$curentLine, number_format(round($totalHT,2), 2, ',', ' ')." euros");
		
		$objPHPExcel->getActiveSheet()->getStyle('D'.$curentLine)->applyFromArray($styleTableCell);
		$objPHPExcel->getActiveSheet()->getStyle('D'.$curentLine)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$curentLine)->applyFromArray($styleTableCell);
		
		// TVA 20p
		$curentLine++;
		$objPHPExcel->getActiveSheet()->insertNewRowBefore($curentLine + 1, 1);
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$curentLine, "T.V.A.:20%");
		$honoraireTVA = 0.2*$totalHT;
		$objPHPExcel->getActiveSheet()->SetCellValue('E'.$curentLine, number_format(round($honoraireTVA,2), 2, ',', ' ')." euros");
		
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
		$objPHPExcel->getActiveSheet()->SetCellValue('E'.$curentLine, number_format(round($honoraireTotal,2), 2, ',', ' ')." euros");
		
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
		
		$this->updateUnsetResponsibles(); // this is needed to setup responsible if a user has booked without setted responsible
		
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
		$modelUnit = new CoreUnit();
		$LABpricingid = $modelUnit->getBelonging($unit_id);
		if ($LABpricingid <= 1 ){
			$LABpricingid = 0;
		}

		// responsible fullname
		$modelUser = new CoreUser();
		$responsibleFullName = $modelUser->getUserFUllName($responsible_id);
		
		// unit name
		$modelUnit = new CoreUnit();
		$unitName = $modelUnit->getUnitName($unit_id);
		
		$unitInfo = $modelUnit->getUnit($unit_id);
		$unitAddress = $unitInfo[2];
		
		$sql = 'SELECT * FROM sy_resources ORDER BY name';
		$req = $this->runRequest($sql);
		$resources = $req->fetchAll();
		
		// ///////////////////////////////////////// //
		//             Main query                    //
		// ///////////////////////////////////////// //
		$bookingUsers = $this->generateBillGetBookersUsersInfo($searchDate_start, $searchDate_end, $LABpricingid, $unit_id, $responsible_id);
		if (count($bookingUsers) == 0){
			echo "ERROR: no reservations found ! <br/>";
			return;
		}
		
		$packagesPrices = $this->getUnitPackagePricesForEachResource($resources, $LABpricingid);
		$timePrices = $this->getUnitTimePricesForEachResource($resources, $LABpricingid);
		
		$reservationsSummary = $this->generateBillGetReservations($searchDate_start, $searchDate_end, $resources, $bookingUsers, 
				$packagesPrices, $timePrices);
		
		
		// ///////////////////////////////////////// //
		//             Generate invoice xls          //
		// ///////////////////////////////////////// //
		$stylesheet = $this->stylesheet();
		
		// load the template
		$file = "data/template.xls";
		$XLSDocument = new PHPExcel_Reader_Excel5();
		$objPHPExcel = $XLSDocument->load($file);
		
		// replace the date
		$objPHPExcel = $this->replaceVariable($objPHPExcel, "{date}", date("d/m/Y", time()));
		// replace the year
		$objPHPExcel = $this->replaceVariable($objPHPExcel, "{annee}", date("Y", time()));
		// replace the responsible
		$objPHPExcel = $this->replaceVariable($objPHPExcel, "{responsable}", $responsibleFullName);
		// replace unit name
		$objPHPExcel = $this->replaceVariable($objPHPExcel, "{unite}", $unitName);
		// replace unit address
		$objPHPExcel = $this->replaceVariable($objPHPExcel, "{adresse}", $unitAddress, true);
		// set bill number
		$number = $this->calculateBillNumber($objPHPExcel);
		$objPHPExcel = $this->replaceVariable($objPHPExcel, "{nombre}", $number);
		
		// fill the table
		$objPHPExcel = $this->fillTable($objPHPExcel, $date_debut, $date_fin, $resources, $reservationsSummary,
				 $packagesPrices, $timePrices, $stylesheet, $unitName, $unit_id, $responsibleFullName, $searchDate_start, $searchDate_end,
				 $number, $responsible_id);

	}
	
	protected function fillTable($objPHPExcel, $date_debut, $date_fin, $resources, $reservationsSummary, $packagesPrices, 
			$timePrices, $stylesheet, $unitName, $unit_id, $responsibleFullName, $searchDate_start, $searchDate_end, $number, $responsible_id){
		
		// search the table line index
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
		$objPHPExcel->getActiveSheet()->insertNewRowBefore($curentLine, 1);
		$objPHPExcel->getActiveSheet()->getRowDimension($curentLine)->setRowHeight(25);
		
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$curentLine, "Equipement");
		$objPHPExcel->getActiveSheet()->getStyle('A'.$curentLine)->applyFromArray($stylesheet["styleTableHeader"]);
		
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$curentLine, "Utilisateur");
		$objPHPExcel->getActiveSheet()->getStyle('B'.$curentLine)->applyFromArray($stylesheet["styleTableHeader"]);
		
		$objPHPExcel->getActiveSheet()->SetCellValue('C'.$curentLine, "Nombre de \n seances");
		$objPHPExcel->getActiveSheet()->getStyle('C'.$curentLine)->getAlignment()->setWrapText(true);
		$objPHPExcel->getActiveSheet()->getStyle('C'.$curentLine)->applyFromArray($stylesheet["styleTableHeader"]);
		
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$curentLine, "Quantité");
		$objPHPExcel->getActiveSheet()->getStyle('D'.$curentLine)->applyFromArray($stylesheet["styleTableHeader"]);
		
		$objPHPExcel->getActiveSheet()->SetCellValue('E'.$curentLine, "Tarif Unitaire");
		$objPHPExcel->getActiveSheet()->getStyle('E'.$curentLine)->applyFromArray($stylesheet["styleTableHeader"]);
		
		$objPHPExcel->getActiveSheet()->SetCellValue('F'.$curentLine, "Montant");
		$objPHPExcel->getActiveSheet()->getStyle('F'.$curentLine)->applyFromArray($stylesheet["styleTableHeader"]);
		
	
		// table content
		$total = 0;
		foreach($resources as $resource){
			
			$resSummary = $reservationsSummary[$resource["id"]];
			$rtimePrices = $timePrices[$resource["id"]];
			foreach($resSummary as $userResa){
				$userID = $userResa["user_id"];
				$packages = $userResa["packages"];
				$time = $userResa["time"];
				
				$modelUser = new CoreUser();
				$userName = $modelUser->getUserFUllName($userID);
				
				// print the packages
				foreach($packagesPrices[$resource["id"]] as $p){
					if ( $packages[$p["id"]] > 0){
						$curentLine++;
						$objPHPExcel->getActiveSheet()->insertNewRowBefore($curentLine+1, 1);
						
						$nbPackage =  $packages[$p["id"]];
						$prices =  $p["price"][0];
						$price = $nbPackage*$prices;
						$total += $price;
						
						$objPHPExcel->getActiveSheet()->SetCellValue('A'.$curentLine, $resource["name"]);
						$objPHPExcel->getActiveSheet()->SetCellValue('B'.$curentLine, $userName);
						$objPHPExcel->getActiveSheet()->SetCellValue('C'.$curentLine, $nbPackage);
						$objPHPExcel->getActiveSheet()->SetCellValue('D'.$curentLine, $p["name"]);
						$objPHPExcel->getActiveSheet()->SetCellValue('E'.$curentLine, $prices);
						$objPHPExcel->getActiveSheet()->SetCellValue('F'.$curentLine, $price);
						
						$objPHPExcel->getActiveSheet()->getStyle('A'.$curentLine)->applyFromArray($stylesheet["styleTableCell"]);
						$objPHPExcel->getActiveSheet()->getStyle('B'.$curentLine)->applyFromArray($stylesheet["styleTableCell"]);
						$objPHPExcel->getActiveSheet()->getStyle('C'.$curentLine)->applyFromArray($stylesheet["styleTableCell"]);
						$objPHPExcel->getActiveSheet()->getStyle('D'.$curentLine)->applyFromArray($stylesheet["styleTableCell"]);
						$objPHPExcel->getActiveSheet()->getStyle('E'.$curentLine)->applyFromArray($stylesheet["styleTableCell"]);
						$objPHPExcel->getActiveSheet()->getStyle('F'.$curentLine)->applyFromArray($stylesheet["styleTableCell"]);
					}
				}
				
				// print time reservation
				if ($time["nb_seance"] > 0){
					
					$curentLine++;
					$objPHPExcel->getActiveSheet()->insertNewRowBefore($curentLine+1, 1);
					
					if ($time["quantity"] > 0){

						$quantity =  $time["quantity"] ;
						$prices =  $rtimePrices["price_day"];
						$price = $time["quantity"]*$rtimePrices["price_day"];
						$total += $price;
						$objPHPExcel->getActiveSheet()->SetCellValue('A'.$curentLine, $resource["name"]);
						$objPHPExcel->getActiveSheet()->SetCellValue('B'.$curentLine, $userName);
						$objPHPExcel->getActiveSheet()->SetCellValue('C'.$curentLine, $time["nb_seance"]);
						$objPHPExcel->getActiveSheet()->SetCellValue('D'.$curentLine, $quantity);
						$objPHPExcel->getActiveSheet()->SetCellValue('E'.$curentLine, $prices);
						$objPHPExcel->getActiveSheet()->SetCellValue('F'.$curentLine, $price);
						
					}
					else{
						
						//$quantity =  $time["nb_hours_day"] . "hj " . $time["nb_hours_night"] . "hn " . $time["nb_hours_we"] . "hwe" ;
						
						$objRichTextQ = new PHPExcel_RichText();
						$objRichTextP = new PHPExcel_RichText();
						
						if ($time["nb_hours_night"] == 0 && $time["nb_hours_we"] == 0){
							$objRichTextQ->createTextRun($time["nb_hours_day"]);
							$objRichTextP->createTextRun($rtimePrices["price_day"]);
						}
						else{
							$objBold = $objRichTextQ->createTextRun($time["nb_hours_day"] . "hj ");
							$phpColor = new PHPExcel_Style_Color();
							$phpColor->setRGB('0000ff');
							$objBold->getFont()->setColor($phpColor);
							
							$objBold = $objRichTextP->createTextRun($rtimePrices["price_day"] . "hj ");
							$objBold->getFont()->setColor($phpColor);
							
							$objRichTextQ->createTextRun("|");
							$objRichTextP->createTextRun("|");
							
							$objBold = $objRichTextQ->createTextRun($time["nb_hours_night"] . "hn ");
							$phpColor = new PHPExcel_Style_Color();
							$phpColor->setRGB('777777');
							$objBold->getFont()->setColor($phpColor);
							
							$objBold = $objRichTextP->createTextRun($rtimePrices["price_night"] . "hn ");
							$objBold->getFont()->setColor($phpColor);
							
							$objRichTextQ->createTextRun("|");
							$objRichTextP->createTextRun("|");
							
							$objBold = $objRichTextQ->createTextRun($time["nb_hours_we"] . "hwe");
							$phpColor = new PHPExcel_Style_Color();
							$phpColor->setRGB('777777');
							$objBold->getFont()->setColor($phpColor);
							
							$objBold = $objRichTextP->createTextRun($rtimePrices["price_we"] . "hwe ");
							$objBold->getFont()->setColor($phpColor);
						}
						
						$prices =  $rtimePrices["price_day"] . "hj " . $rtimePrices["price_night"] . "hn " . $rtimePrices["price_we"] . "hwe" ;
						$price = $time["nb_hours_day"]*$rtimePrices["price_day"] + $time["nb_hours_night"]*$rtimePrices["price_night"] + $time["nb_hours_we"]*$rtimePrices["price_we"];
						$total += $price;
						$objPHPExcel->getActiveSheet()->SetCellValue('A'.$curentLine, $resource["name"]);
						$objPHPExcel->getActiveSheet()->SetCellValue('B'.$curentLine, $userName);
						$objPHPExcel->getActiveSheet()->SetCellValue('C'.$curentLine, $time["nb_seance"]);
						$objPHPExcel->getActiveSheet()->getCell('D'.$curentLine)->setValue($objRichTextQ);
						$objPHPExcel->getActiveSheet()->getCell('E'.$curentLine)->setValue($objRichTextP);
						//$objPHPExcel->getActiveSheet()->SetCellValue('D'.$curentLine, $quantity);
						//$objPHPExcel->getActiveSheet()->SetCellValue('E'.$curentLine, $prices);
						$objPHPExcel->getActiveSheet()->SetCellValue('F'.$curentLine, $price);

					}
					
					$objPHPExcel->getActiveSheet()->getStyle('A'.$curentLine)->applyFromArray($stylesheet["styleTableCell"]);
					$objPHPExcel->getActiveSheet()->getStyle('B'.$curentLine)->applyFromArray($stylesheet["styleTableCell"]);
					$objPHPExcel->getActiveSheet()->getStyle('C'.$curentLine)->applyFromArray($stylesheet["styleTableCell"]);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$curentLine)->applyFromArray($stylesheet["styleTableCell"]);
					$objPHPExcel->getActiveSheet()->getStyle('E'.$curentLine)->applyFromArray($stylesheet["styleTableCell"]);
					$objPHPExcel->getActiveSheet()->getStyle('F'.$curentLine)->applyFromArray($stylesheet["styleTableCell"]);

				}
			}
		}
		
		// bilan
		// total HT
		$curentLine++;
		$objPHPExcel->getActiveSheet()->insertNewRowBefore($curentLine + 1, 1);
		$objPHPExcel->getActiveSheet()->SetCellValue('E'.$curentLine, "Total H.T.");
		$objPHPExcel->getActiveSheet()->SetCellValue('F'.$curentLine, number_format(round($total,2), 2, ',', ' ')." €");
		
		$objPHPExcel->getActiveSheet()->getStyle('E'.$curentLine)->applyFromArray($stylesheet["styleTableCell"]);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$curentLine)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('F'.$curentLine)->applyFromArray($stylesheet["styleTableCell"]);
		
		// add the bill to the bill manager
		$modelBill = new SyBill();
		$modelBill->addBillUnit($number, $searchDate_start, $searchDate_end, date("Y-m-d", time()), $unit_id, $responsible_id, $total);
		
		
		// TVA 20p
		$curentLine++;
		$objPHPExcel->getActiveSheet()->insertNewRowBefore($curentLine + 1, 1);
		$objPHPExcel->getActiveSheet()->SetCellValue('E'.$curentLine, "T.V.A.:20%");
		$honoraireTVA = 0.2*$total;
		$honoraireTVA = number_format(round($honoraireTVA,2), 2, '.', ' ');
		$honoraireTotal = $total + $honoraireTVA;
		$objPHPExcel->getActiveSheet()->SetCellValue('F'.$curentLine, number_format(round($honoraireTVA,2), 2, ',', ' ')." €");
		
		$objPHPExcel->getActiveSheet()->getStyle('E'.$curentLine)->applyFromArray($stylesheet["styleTableCell"]);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$curentLine)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('F'.$curentLine)->applyFromArray($stylesheet["styleTableCell"]);
		
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
		
		$objPHPExcel->getActiveSheet()->getStyle('E'.$curentLine)->applyFromArray($stylesheet["styleTableCell"]);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$curentLine)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('F'.$curentLine)->applyFromArray($stylesheet["styleTableCellTotal"]);
		
		// export the xls file
		// Save the xls file
		$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
		$nom = $unitName . '_' . $responsibleFullName . "_" . date("d-m-Y", $searchDate_start) . "_" . date("d-m-Y", $searchDate_end-3600) ."_facture_sygrrif.xls";
		
		header_remove();
		//ob_clean();
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$nom.'"');
		header('Cache-Control: max-age=0');
		$objWriter->save('php://output');
	}
	
	protected function calculateBillNumber($objPHPExcel){
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
		
		return $number;
	}
	
	protected function replaceVariable($objPHPExcel, $key, $value, $wrapText = false){
		// replace the date
		$rowIterator = $objPHPExcel->getActiveSheet()->getRowIterator();
		$col = array("A", "B","C","D","E","F","G","H","I","J","K","L");
		$insertCol = "";
		$keyfound = false;
		foreach($rowIterator as $row) {
			for ($i = 0 ; $i < count($col) ; $i++){
				$rowIndex = $row->getRowIndex ();
				$num = $objPHPExcel->getActiveSheet()->getCell($col[$i].$rowIndex)->getValue();
				if (strpos($num,$key) !== false){
					$insertLine = $rowIndex;
					$insertCol = $col[$i];
					$keyfound = true;
					break;
				}
			}
		}
		if ($keyfound){
			$objPHPExcel->getActiveSheet()->SetCellValue($insertCol.$insertLine, $value);
			if ($wrapText){
				$objPHPExcel->getActiveSheet()->getStyle($insertCol.$insertLine)->getAlignment()->setWrapText(true);
			}
		}
		return $objPHPExcel;
	}
	
	protected function updateUnsetResponsibles(){
		$modelCalEntries = new SyCalendarEntry();
		$modelUser = new CoreUser();
		$entries = $modelCalEntries->getZeroRespEntries();
		foreach($entries as $entry){
			$recipientID = $entry["recipient_id"];
			$resps = $modelUser->getUserResponsibles($recipientID);
			if (count($resps) > 0){
				$modelCalEntries->setEntryResponsible($entry["id"], $resps[0]["id"]);
			}
		}
	}
	
	protected function generateBillGetBookersUsersInfo($searchDate_start, $searchDate_end, $LABpricingid, $unit_id,$responsible_id){
		// get the list of users in the selected period
		$q = array('start'=>$searchDate_start, 'end'=>$searchDate_end, 'resp'=>$responsible_id);
		$sql = 'SELECT DISTINCT recipient_id FROM sy_calendar_entry WHERE
				((start_time <:start AND end_time <= :end AND end_time>:start) OR
				(start_time >=:start AND end_time <= :end) OR
				(start_time >=:start AND start_time<:end AND end_time > :end))
				AND (responsible_id = :resp)
				ORDER BY id';
		$req = $this->runRequest($sql, $q);
		$beneficiaire = $req->fetchAll();	// Liste des beneficiaire dans la periode selectionee
		
		// get the users who booked
		$users = array();
		$i = 0;
		foreach($beneficiaire as $b){

			// user info
			$modelUser = new CoreUser();
			$nomPrenom = $modelUser->userAllInfo($b[0]);
			// name, firstname, id_responsible
			if (count($nomPrenom) != 0){
				$users[$i]["name"] = $nomPrenom["name"]; //Nom du beneficiaire
				$users[$i]["firstname"] = $nomPrenom["firstname"]; //Prenom du beneficiaire
				$users[$i]["id"] = $b[0]; //id du beneficiaire
				$users[$i]["id_responsible"] = $responsible_id; //Responsable du beneficiaire
				$users[$i]["pricing_id"] = $LABpricingid; //Tarif applique
				$i++;
			}
		}
		
		return $users;

	}
	
	protected function generateBillGetReservations($searchDate_start, $searchDate_end, $resources, $users, $packagesPrices, $timePrices){

		$reservationsSummaries = array();
		// calculate the reservations for each equipments
		foreach($resources as $resource){
	
			// get the reservations of each user
			$userCount = 0;
			foreach($users as $user){
				
				//print_r($user);
				
				// initialize packages ids
				$userPackages = array();
				foreach($packagesPrices[$resource["id"]] as $p){
					$userPackages[$p["id"]] = 0;
				}
				
				// initialize time booking summary
				$userTime = array();
				$userTime["nb_seance"] = 0;
				$userTime["nb_hours_day"] = 0;
				$userTime["nb_hours_night"] = 0;
				$userTime["nb_hours_we"] = 0;
				$userTime["quantity"] = 0;
				
				// initialize the counting array
				$userReservationSummary["user_id"] = $user["id"];
				
				// get all the reservations
				$q = array('start'=>$searchDate_start, 'end'=>$searchDate_end, 'res_id'=>$user["id"], ':resou_id'=>$resource["id"]);
				$sql = 'SELECT * FROM sy_calendar_entry WHERE
					recipient_id =:res_id AND resource_id =:resou_id AND (	
					(start_time <:start AND end_time <= :end AND end_time>:start) OR
					(start_time >=:start AND end_time <= :end) OR
					(start_time >=:start AND start_time<:end AND end_time > :end)) ORDER BY id';
				$req = $this->runRequest($sql, $q);
				$reservations = $req->fetchAll();
				
				// calculate the number of hours/packages
				foreach($reservations as $reservation){
					
					if ($reservation["package_id"] > 0){
						$userPackages[$reservation["package_id"]] ++;
					}
					else if($reservation["quantity"] > 0){
						$userTime["nb_seance"]++;
						$userTime["quantity"] += $reservation["quantity"]; 
					}
					else{
						$userTime["nb_seance"]++;
						$resaDayNightWe = $this->calculateTimeResDayNightWe($reservation, $timePrices[$resource["id"]]);
						$userTime["nb_hours_day"] += $resaDayNightWe["nb_hours_day"];
						$userTime["nb_hours_night"] += $resaDayNightWe["nb_hours_night"];
						$userTime["nb_hours_we"] += $resaDayNightWe["nb_hours_we"];
					}
				}
				$userReservationSummary["packages"] = $userPackages;
				$userReservationSummary["time"] = $userTime;
				
				$reservationsSummaries[$resource["id"]][$userCount] = $userReservationSummary;
				$userCount++;
			}
		}
		
		return $reservationsSummaries;
		
	}
	
	protected function calculateTimeResDayNightWe($reservation, $timePrices){
		
		// initialize output
		$nb_hours_day = 0;;
		$nb_hours_night = 0;
		$nb_hours_we = 0;
		
		// extract some variables
		$we_array = $timePrices["we_array"];
		$night_start = $timePrices['night_start'];
		$night_end = $timePrices['night_end'];
		
		$searchDate_start = $reservation["start_time"];
		$searchDate_end = $reservation["end_time"];
		
		// calulate pricing
		if ($timePrices["tarif_unique"] > 0){ // unique pricing
			$nb_hours_day = ($searchDate_end - $searchDate_start);
		}
		else{
			$gap = 60;
			$timeStep = $searchDate_start;
			while ($timeStep <= $searchDate_end){
				// test if pricing is we
				if (in_array(date("N", $timeStep), $we_array) && in_array(date("N", $timeStep+$gap), $we_array) ){  // we pricing
					$nb_hours_we += $gap;
				}
				else{ 
					$H = date("H", $timeStep);
					
					if ($H >= $night_end && $H < $night_start ){ // price day
						$nb_hours_day += $gap;
					}
					else{ // price night
						$nb_hours_night += $gap;
					}
				}
				$timeStep += $gap;
			}
		}
		
		$resaDayNightWe["nb_hours_day"] = round($nb_hours_day/3600, 1);
		$resaDayNightWe["nb_hours_night"] = round($nb_hours_night/3600, 1);
		$resaDayNightWe["nb_hours_we"] = round($nb_hours_we/3600, 1);
		
		return $resaDayNightWe;
	}
	
	protected function getUnitPackagePricesForEachResource($resources, $LABpricingid){
	
		// calculate the reservations for each equipments
		$packagesPrices = array();
		foreach($resources as $resource){
			// get the packages prices
			$sql = 'SELECT id, name FROM sy_packages WHERE id_resource=? ORDER BY name';
			$req = $this->runRequest($sql, array($resource["id"]));
			$packages = $req->fetchAll();
		
			$pricesPackages = array();
			for($i = 0 ; $i < count($packages) ; $i++){
		
				$sql = 'SELECT price FROM sy_j_packages_prices WHERE id_package=? and id_pricing=?';
				$req = $this->runRequest($sql, array($packages[$i]["id"], $LABpricingid));
				$price = $req->fetch();
				$packages[$i]["price"] = $price;
				$pricesPackages[] = $packages[$i];
			}
			$packagesPrices[$resource["id"]] = $pricesPackages;
		}
		
		//print_r($packagesPrices);
		return $packagesPrices;
			
	}
	protected function getUnitTimePricesForEachResource($resources, $LABpricingid){
		
		// get the pricing informations
		$pricingModel = new SyPricing();
		$pricingInfo = $pricingModel->getPricing($LABpricingid);
		//$tarif_name = $pricingInfo['tarif_name'];
		$tarif_unique = $pricingInfo['tarif_unique'];
		$tarif_nuit = $pricingInfo['tarif_night'];
		$tarif_we = $pricingInfo['tarif_we'];
		$night_start = $pricingInfo['night_start'];
		$night_end = $pricingInfo['night_end'];
		$we_array1 = explode(",", $pricingInfo['choice_we']);
		$we_array = array();
		for($s = 0 ; $s < count($we_array1) ; $s++ ){
			if ($we_array1[$s] > 0){
				$we_array[] = $s+1;
			}
		}
		
		$timePrices = array();
		foreach($resources as $resource){
			// get the time prices
			$modelRessourcePricing = new SyResourcePricing();
			$res = $modelRessourcePricing->getPrice($resource["id"], $LABpricingid);
			$timePrices[$resource["id"]]["tarif_unique"] = $tarif_unique;
			$timePrices[$resource["id"]]["tarif_night"] = $tarif_nuit;
			$timePrices[$resource["id"]]["tarif_we"] = $tarif_we;
			$timePrices[$resource["id"]]["night_end"] = $night_end;
			$timePrices[$resource["id"]]["night_start"] = $night_start;
			$timePrices[$resource["id"]]["we_array"] = $we_array;
			$timePrices[$resource["id"]]["price_day"] =  $res['price_day'];	//Tarif jour pour l'utilisateur selectionne
			$timePrices[$resource["id"]]["price_night"] = $res['price_night'];	//Tarif nuit pour l'utilisateur selectionne
			$timePrices[$resource["id"]]["price_we"] = $res['price_we'];		//Tarif w-e pour l'utilisateur selectionne
		
		}
		return $timePrices;
	}
	
	protected function stylesheet(){
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
		
		$styleNull = array(
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
										'rgb' => 'ffffff'),
						),
				),
				'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'startcolor' => array(
								'rgb' => 'ffffff',
						),
				),
		);
		
		$styleSheet["styleTableHeader"] = $styleTableHeader;
		$styleSheet["styleTableCell"] = $styleTableCell;
		$styleSheet["styleTableCellTotal"] = $styleTableCellTotal;
		$styleSheet["styleNull"] = $styleNull;
		return $styleSheet;
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
		$modelUser = new CoreUser();
		$responsibleFullName = $modelUser->getUserFUllName($responsible_id);
		
		
		// unit name
		$unitName = "";
		if ($unit_id > 0){
			$modelUnit = new CoreUnit();
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
			$modelUser = new CoreUser();
			$nomPrenom = $modelUser->getUserFromIdUnit(($b[0]), $unit_id);
			if (count($nomPrenom) != 0){
				
				if ($responsible_id == $modelUser->getUserResponsible($b[0])){
					// name, firstname, id_responsible
					$people[0][$i] = $nomPrenom[0]["name"]; 	//Nom du beneficiaire
					$people[1][$i] = $nomPrenom[0]["firstname"]; 	//Prenom du beneficiaire
					$people[2][$i] = $b[0];				//Login du beneficiaire
					$people[3][$i] = $modelUser->getUserFUllName($nomPrenom[0]["id_responsible"]);	//Responsable du beneficiaire
					$people[4][$i] = $unitName;	//laboratoire du benificiaire
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
		$header = "Date d'edition de ce document : \n".$today;
		$titre = "Decompte des heures reserves du ".$date_debut." inclu au ".$date_fin." inclu";
		
		//$footer = "https://bioimagerie.univ-rennes1.fr/h2p2_db-demo/exportFiles/".$nom;
		$footer = $nom;
		
		
		// Creation de l'objet
		$objPHPExcel = new PHPExcel();
		
		// Definition de quelques proprietes
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
		
		
		// Nom des equipements
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
		
		// Nom des beneficiaires
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

		//on recupÃ¨re l'extension du fichier
		$ExtensionPresumee = explode('.', $ImageNews);
		$ExtensionPresumee = strtolower($ExtensionPresumee[count($ExtensionPresumee)-1]);
		//on utilise la fonction php associe au bon type d'image
		if ($ExtensionPresumee == 'jpg' || $ExtensionPresumee == 'jpeg'){
			$ImageChoisie = imagecreatefromjpeg($ImageNews);
		}
		elseif($ExtensionPresumee == 'gif'){
			$ImageChoisie = imagecreatefromgif($ImageNews);
		}
		elseif($ExtensionPresumee == 'png'){
			$ImageChoisie = imagecreatefrompng($ImageNews);
		}
		
		//je redimensionne lâ€™image
		$TailleImageChoisie = getimagesize($ImageNews);
		//la largeur voulu dans le document excel
		//$NouvelleLargeur = 150;
		$NouvelleHauteur = 80;
		//calcul du pourcentage de reduction par rapport Ã  lâ€™original
		//$Reduction = ( ($NouvelleLargeur * 100)/$TailleImageChoisie[0] );
		$Reduction = ( ($NouvelleHauteur * 100)/$TailleImageChoisie[1] );
		//PHPExcel mâ€™aplatit verticalement lâ€™image donc jâ€™ai calcule de ratio dâ€™applatissement de lâ€™image et je lâ€™etend prealablement
		//$NouvelleHauteur = (($TailleImageChoisie[1] * $Reduction)/100 );
		$NouvelleLargeur = (($TailleImageChoisie[0] * $Reduction)/100 );
		//jâ€™initialise la nouvelle image
		$NouvelleImage = imagecreatetruecolor($NouvelleLargeur , $NouvelleHauteur) or die (â€œErreurâ€�);
		
		//je mets lâ€™image obtenue aprÃ¨s redimensionnement en variable
		imagecopyresampled($NouvelleImage , $ImageChoisie, 0, 0, 0, 0, $NouvelleLargeur, $NouvelleHauteur, $TailleImageChoisie[0],$TailleImageChoisie[1]);
		$gdImage=$NouvelleImage;
		
		//on cree lâ€™objet de dessin et on lui donne un nom, lâ€™image, la position de lâ€™image, la compression de lâ€™image, le type mimeâ€¦
		$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
		$objDrawing->setName('Sample image');
		$objDrawing->setImageResource($gdImage);
		$objDrawing->setCoordinates('A1');
		$objDrawing->setOffsetX(50);
		$objDrawing->setOffsetY(8);
		$objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
		$objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
		//enfin on lâ€™envoie Ã  la feuille de calcul !
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
		$modelUnit = new CoreUnit();
		$unitInfo = $modelUnit->getUnit($unit_id);
		
		//----------------------------------------------------------------------------
		
		//On liste l'ensemble des reservations sur la periode selectionnee
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
			$modelUser = new CoreUser();
			$nomPrenom = $modelUser->getUserFromIdUnit(($b[0]), $unit_id);
			// name, firstname, id_responsible
			if (count($nomPrenom) != 0){
				$people[0][$i] = $nomPrenom[0]["name"]; 	//Nom du beneficiaire
				$people[1][$i] = $nomPrenom[0]["firstname"]; 	//Prenom du beneficiaire
				$people[2][$i] = $b[0];				//Login du beneficiaire
				$people[3][$i] = $modelUser->getUserFUllName($nomPrenom[0]["id_responsible"]);	//Responsable du beneficiaire
				$people[4][$i] = $unitInfo['name'];	//laboratoire du benificiaire
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
		$header = "Date d'edition de ce document : \n".$today;
		$titre = "Detail des heures reserves du ".$date_debut." inclus au ".$date_fin." inclus";
		
		$footer = $nom;
		
		
		// Creation de l'objet
		$objPHPExcel = new PHPExcel();
		
		// Definition de quelques proprietes
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
		$sheet->SetCellValue($colonne.$ligne,"NÂ° de reservation");
		$sheet->getStyle($colonne.$ligne)->applyFromArray($center);
		$sheet->getStyle($colonne.$ligne)->applyFromArray($gras);
		$sheet->getStyle($colonne.$ligne)->applyFromArray($border);
		$colonne++;
		$sheet->getColumnDimension($colonne)->setWidth(35);
		$sheet->SetCellValue($colonne.$ligne,"Date de debut\n&\nDate de fin");
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
		$sheet->SetCellValue($colonne.$ligne,"Beneficiaire\n(Reserve par)");
		$sheet->getStyle($colonne.$ligne)->getAlignment()->setWrapText(true);
		$sheet->getStyle($colonne.$ligne)->applyFromArray($center);
		$sheet->getStyle($colonne.$ligne)->applyFromArray($gras);
		$sheet->getStyle($colonne.$ligne)->applyFromArray($border);
		$colonne++;
		$sheet->getColumnDimension($colonne)->setWidth(35);
		$sheet->SetCellValue($colonne.$ligne,"DerniÃ¨re mise Ã  jour");
		$sheet->getStyle($colonne.$ligne)->getAlignment()->setWrapText(true);
		$sheet->getStyle($colonne.$ligne)->applyFromArray($center);
		$sheet->getStyle($colonne.$ligne)->applyFromArray($gras);
		$sheet->getStyle($colonne.$ligne)->applyFromArray($border);
		
		//
		$unwanted_array = array(    'Monday'=>'Lundi', 'Tuesday'=>'Mardi', 'Wednesday'=>'Mercredi', 'Thursday'=>'Jeudi',
				'Friday'=>'Vendredi', 'Saturday'=>'Samedi', 'Sunday'=>'Dimanche',
				'Jan'=>'Jan', 'Feb'=>'Fev', 'Mar'=>'Mar', 'Apr'=>'Avr', 'May'=>'Mai', 'Jun'=>'Juin', 'Jul'=>'Juil',
				'Aug'=>'Aoû»', 'Sep'=>'Sep', 'Oct'=>'Oct', 'Nov'=>'Nov', 'Dec'=>'Déc');
		
		$ligne=3;
		foreach($resIn as $rI){
			$colonne='A';
			$sheet->getRowDimension($ligne)->setRowHeight(40);
		
			$sheet->SetCellValue($colonne.$ligne,$rI[0]);
			$sheet->getStyle($colonne.$ligne)->getAlignment()->setWrapText(true);
			$sheet->getStyle($colonne.$ligne)->applyFromArray($center);
			$sheet->getStyle($colonne.$ligne)->applyFromArray($border);
			$colonne++;
			$dDebut = strtr(date('l d M',$rI[1])." Ã  ".date('H',$rI[1])."h".date('i',$rI[1]),$unwanted_array);
			$dFin = strtr(date('l d M',$rI[2])." Ã  ".date('H',$rI[2])."h".date('i',$rI[2]),$unwanted_array);
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