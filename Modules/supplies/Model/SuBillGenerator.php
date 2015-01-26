<?php

require_once 'Framework/Model.php';
require_once 'Modules/supplies/Model/SuUnitPricing.php';
require_once 'Modules/supplies/Model/SuItemPricing.php';
require_once("externals/PHPExcel/Classes/PHPExcel.php");

/**
 * Class defining the supplies pricing model
 *
 * @author Sylvain Prigent
 */
class SuBillGenerator extends Model {
	
	public function generateBill($unit_id, $responsible_id){
		
		
		// /////////////////////////////////////////// // 
		//        get the input informations           //
		// /////////////////////////////////////////// //
		// get the lab info
		$unitPricingModel = new SuUnitPricing();
		$LABpricingid = $unitPricingModel->getPricing($unit_id);
		
		// responsible fullname
		$modelUser = new SuUser();
		$responsibleFullName = $modelUser->getUserFUllName($responsible_id);
		
		// unit name
		$modelUnit = new SuUnit();
		$unitName = $modelUnit->getUnitName($unit_id);
		
		$unitInfo = $modelUnit->getUnit($unit_id);
		$unitAddress = $unitInfo[2];
		// /////////////////////////////////////////// //
		//            Pepare the xls output            //
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
				'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'startcolor' => array(
								'rgb' => 'FFFFFF',
						),
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
		foreach($rowIterator as $row) {
			for ($i = 0 ; $i < count($col) ; $i++){
				$rowIndex = $row->getRowIndex ();
				$num = $objPHPExcel->getActiveSheet()->getCell($col[$i].$rowIndex)->getValue();
				if (strpos($num,"{date}") !== false){
					$insertLine = $rowIndex;
					$insertCol = $col[$i];
					break;
				}
			}
		}
		$objPHPExcel->getActiveSheet()->SetCellValue($insertCol.$insertLine, date("d/m/Y", time()));
		
		// replace the responsible
		$rowIterator = $objPHPExcel->getActiveSheet()->getRowIterator();
		$col = array("A", "B","C","D","E","F","G","H","I","J","K","L");
		$insertCol = "";
		foreach($rowIterator as $row) {
			for ($i = 0 ; $i < count($col) ; $i++){
				$rowIndex = $row->getRowIndex ();
				$num = $objPHPExcel->getActiveSheet()->getCell($col[$i].$rowIndex)->getValue();
				if (strpos($num,"{responsable}") !== false){
					$insertLine = $rowIndex;
					$insertCol = $col[$i];
					break;
				}
			}
		}
		$objPHPExcel->getActiveSheet()->SetCellValue($insertCol.$insertLine, $responsibleFullName);
		
		// replace $unitName
		$rowIterator = $objPHPExcel->getActiveSheet()->getRowIterator();
		$col = array("A", "B","C","D","E","F","G","H","I","J","K","L");
		$insertCol = "";
		foreach($rowIterator as $row) {
			for ($i = 0 ; $i < count($col) ; $i++){
				$rowIndex = $row->getRowIndex ();
				$num = $objPHPExcel->getActiveSheet()->getCell($col[$i].$rowIndex)->getValue();
				if (strpos($num,"{unite}") !== false){
					$insertLine = $rowIndex;
					$insertCol = $col[$i];
					break;
				}
			}
		}
		$objPHPExcel->getActiveSheet()->SetCellValue($insertCol.$insertLine, $unitName);
		
		// replace address $unitAddress
		$rowIterator = $objPHPExcel->getActiveSheet()->getRowIterator();
		$col = array("A", "B","C","D","E","F","G","H","I","J","K","L");
		$insertCol = "";
		foreach($rowIterator as $row) {
			for ($i = 0 ; $i < count($col) ; $i++){
				$rowIndex = $row->getRowIndex ();
				$num = $objPHPExcel->getActiveSheet()->getCell($col[$i].$rowIndex)->getValue();
				if (strpos($num,"{adresse}") !== false){
					$insertLine = $rowIndex;
					$insertCol = $col[$i];
					break;
				}
			}
		}
		$objPHPExcel->getActiveSheet()->SetCellValue($insertCol.$insertLine, $unitAddress);
		
		
		
		
		
		$rowIterator = $objPHPExcel->getActiveSheet()->getRowIterator();
		foreach($rowIterator as $row) {
				
			$rowIndex = $row->getRowIndex ();
			$num = $objPHPExcel->getActiveSheet()->getCell("A".$rowIndex)->getValue();
			if (strpos($num,"{table}") !== false){
				$insertLine = $rowIndex;
				break;
			}
		}
		$objPHPExcel->getActiveSheet()->SetCellValue("A".$rowIndex, "");
		
		$curentLine = $insertLine;
		// Fill the pricing table
		// table headers
		//$objPHPExcel->getActiveSheet()->insertNewRowBefore($curentLine + 1, 1);
		//$objPHPExcel->getActiveSheet()->mergeCells('A'.$curentLine.':F'.$curentLine);
		
		//$titleTab = "";
		//$titleTab = "Prestations du "." au "."";
		
		//$objPHPExcel->getActiveSheet()->SetCellValue('A'.$curentLine, $titleTab);
		//$objPHPExcel->getActiveSheet()->getStyle('A'.$curentLine)->getFont()->setBold(true);
		
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
		
		$objPHPExcel->getActiveSheet()->SetCellValue('C'.$curentLine, "Nombre de commandes");
		$objPHPExcel->getActiveSheet()->getStyle('C'.$curentLine)->applyFromArray($styleTableHeader);
		
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$curentLine, "Quantité");
		$objPHPExcel->getActiveSheet()->getStyle('D'.$curentLine)->applyFromArray($styleTableHeader);
		
		$objPHPExcel->getActiveSheet()->SetCellValue('E'.$curentLine, "Tarif Unitaire");
		$objPHPExcel->getActiveSheet()->getStyle('E'.$curentLine)->applyFromArray($styleTableHeader);
		
		$objPHPExcel->getActiveSheet()->SetCellValue('F'.$curentLine, "Montant");
		$objPHPExcel->getActiveSheet()->getStyle('F'.$curentLine)->applyFromArray($styleTableHeader);
		
		// ///////////////////////////////////////// //
		//             Main query                    //
		// ///////////////////////////////////////// //
		// get all users having an active order
		$sql = "SELECT DISTINCT id_user FROM su_entries WHERE id_status = 1";
		$req = $this->runRequest($sql);
		$beneficiaire = $req->fetchAll();
		
		// select users whose unit and responsible is the selected one
		$i=0;
		foreach($beneficiaire as $b){
			// user info
			$modelUser = new SuUser();
			$nomPrenom = $modelUser->getUserFromlup(($b[0]), $unit_id, $responsible_id);
			// name, firstname, id_responsible
			if (count($nomPrenom) != 0){
				$people[0][$i] = $nomPrenom[0]["name"]; 	//Nom du beneficiaire
				$people[1][$i] = $nomPrenom[0]["firstname"]; 	//Prénom du bénéficiaire
				$people[2][$i] = $b[0];				//id du bénéficiaire
				$people[3][$i] = $nomPrenom[0]["id_responsible"];	//Responsable du bénéficiaire
				$people[4][$i] = $LABpricingid;	//Tarif appliqué
				$i++;
			}
		}
		array_multisort($people[0],SORT_ASC,$people[1],$people[2],$people[3],$people[4]);
		
		// get the items
		$sql = 'SELECT * FROM su_items ORDER BY name';
		$req = $this->runRequest($sql);
		$items = $req->fetchAll();
		$i=0;
		$modelItemPricing = new SuItemPricing();
		$totalHT = 0;
		foreach ($items as $e){
			$itemID = $e[0];
			$itemName = $e[1];
			
			// get the unitary price of the curent item
			$unitaryPrice = $modelItemPricing->getPrice($itemID, $LABpricingid);
			$unitaryPrice = $unitaryPrice[0];
			//print_r($unitaryPrice);
			$addedLine = 0;
			
			for ( $j = 0 ; $j < count($people[0]) ; $j++ ){
				
				// get the quantity of curent item booked for the curent user
				$sql = "SELECT content FROM su_entries WHERE id_user=" . $people[2][$j];
				$req = $this->runRequest($sql);
				$contents = $req->fetchAll();
				$quantity = 0;
				$orderNumber = count($contents);
				foreach ($contents as $content){
					//print_r($content);
					// get the quentity for item=itemID
					$citems = explode(";", $content[0]);
					foreach ($citems as $citem){
						$vals = explode("=", $citem);
						if (count($vals)>1){
							$citemid = $vals[0];
							if ($citemid == $itemID){
								$quantity += $vals[1]; 
							}
						}	
					}
				}
				
				// calculate the HT total price
				$iutotalHT = (float)$quantity*(float)$unitaryPrice;
				
				
				// add one line for this user if $quantity > 0
				if ($quantity > 0){
					$addedLine++;
					$lineIdx = $curentLine + $addedLine;
					$totalHT += $iutotalHT;
					
					$objPHPExcel->getActiveSheet()->insertNewRowBefore($lineIdx, 1);
					
					// user full name
					$objPHPExcel->getActiveSheet()->SetCellValue('B'.$lineIdx, $people[0][$j] . " " . $people[1][$j]);
					$objPHPExcel->getActiveSheet()->getStyle('B'.$lineIdx)->applyFromArray($styleTableCell);
					
					// number of order
					$objPHPExcel->getActiveSheet()->SetCellValue('C'.$lineIdx, $orderNumber);
					$objPHPExcel->getActiveSheet()->getStyle('C'.$lineIdx)->applyFromArray($styleTableCell);
					
					// order quantity
					$objPHPExcel->getActiveSheet()->SetCellValue('D'.$lineIdx, $quantity);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$lineIdx)->applyFromArray($styleTableCell);
					
					// unitary price
					$objPHPExcel->getActiveSheet()->SetCellValue('E'.$lineIdx, $unitaryPrice);
					$objPHPExcel->getActiveSheet()->getStyle('E'.$lineIdx)->applyFromArray($styleTableCell);
					
					// Total HT
					$objPHPExcel->getActiveSheet()->SetCellValue('F'.$lineIdx, $iutotalHT);
					$objPHPExcel->getActiveSheet()->getStyle('F'.$lineIdx)->applyFromArray($styleTableCell);
				}
				
			} // end for people
				
				
			// add the item title	
			//echo "addedline=".$addedLine."<br/>";
			if ($addedLine > 0){
				$curentLine++;
				$roomspan = $curentLine + $addedLine -1;
				$objPHPExcel->getActiveSheet()->mergeCells('A'.$curentLine.':A'.$roomspan);
				$objPHPExcel->getActiveSheet()->SetCellValue('A'.$curentLine, $itemName); // item name
				$objPHPExcel->getActiveSheet()->getStyle('A'.$curentLine)->applyFromArray($styleTableCell);
			}
		}
				
		// bilan
		// total HT
		$curentLine++;
		$objPHPExcel->getActiveSheet()->insertNewRowBefore($curentLine + 1, 1);
		$objPHPExcel->getActiveSheet()->SetCellValue('E'.$curentLine, "Total H.T.");
		$objPHPExcel->getActiveSheet()->SetCellValue('F'.$curentLine, $totalHT." €");
		
		$objPHPExcel->getActiveSheet()->getStyle('E'.$curentLine)->applyFromArray($styleTableCell);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$curentLine)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('F'.$curentLine)->applyFromArray($styleTableCell);
		
		// TVA 20p
		$curentLine++;
		$objPHPExcel->getActiveSheet()->insertNewRowBefore($curentLine + 1, 1);
		$objPHPExcel->getActiveSheet()->SetCellValue('E'.$curentLine, "T.V.A.:20%");
		$honoraireTVA = 0.2*$totalHT;
		$honoraireTVA = number_format(round($honoraireTVA,2), 2, '.', ' ');
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
		$objPHPExcel->getActiveSheet()->SetCellValue('F'.$curentLine, (float)$totalHT*(float)1.2." €");		

		$objPHPExcel->getActiveSheet()->getStyle('E'.$curentLine)->applyFromArray($styleTableCell);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$curentLine)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('F'.$curentLine)->applyFromArray($styleTableCellTotal);
		
		// Save the xls file
		$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="bill.xls"');
		header('Cache-Control: max-age=0');
		$objWriter->save('php://output');
			
	}
}