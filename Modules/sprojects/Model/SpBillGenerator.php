<?php

require_once 'Framework/Model.php';
require_once 'Modules/sprojects/Model/SpProject.php';
require_once 'Modules/sprojects/Model/SpUnitPricing.php';
require_once 'Modules/sprojects/Model/SpBill.php';
require_once 'Modules/sprojects/Model/SpItem.php';
require_once 'Modules/sprojects/Model/SpItemPricing.php';

require_once 'Modules/core/Model/Unit.php';
require_once 'Modules/core/Model/User.php';
require_once("externals/PHPExcel/Classes/PHPExcel.php");

/**
 * Class defining the supplies pricing model
 *
 * @author Sylvain Prigent
 */
class SpBillGenerator extends Model {
	
	public function generateBill($id_project){
		
		
		//echo "id project = " . $id_project . "<br/>";
		// /////////////////////////////////////////// // 
		//        get the input informations           //
		// /////////////////////////////////////////// //
		
		$modelProject = new SpProject();
		// get the pricing information
		$id_resp = $modelProject->getResponsible($id_project);
		$id_user = $modelProject->getUser($id_project);
		
		// get the pricing
		$modelUser = "";
		$modelUnit = "";
		$modelConfig = new CoreConfig();
		$sprojectsusersdatabase = $modelConfig->getParam ( "sprojectsusersdatabase" );
		if ($sprojectsusersdatabase == "local"){
			$modelUser = new SpUser();
			$modelUnit = new SpUnit();
		}
		else{
			$modelUser = new User();
			$modelUnit = new Unit();
		}
		
		// get the user unit:
		//echo "resp id = " . $id_resp . "<br/>";
		$id_unit = $modelUser->getUserUnit($id_resp);
		//echo "id_unit id = " . $id_unit . "<br/>";
		
		// get the pricing
		$modelPricing = new SpUnitPricing();
		$LABpricingid = $modelPricing->getPricing($id_unit);
		//echo "lab pricing id = " . $LABpricingid . "<br/>";
		$unitName = $modelUnit->getUnitName($id_unit);
		$responsibleFullName = $modelUser->getUserFUllName($id_resp);
		$userFullName = $modelUser->getUserFUllName($id_user);
		
		// get the lab info
		//echo "get the lab info <br/>";
		$unitPricingModel = new SpUnitPricing();
		$LABpricingid = $unitPricingModel->getPricing($id_unit);
		//echo "get unit: " . $id_unit . "<br/>";
		$unitInfo = $modelUnit->getUnit($id_unit);
		$unitAddress = $unitInfo[2];
		//echo "get unit done <br/>";
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
		$file = "data/template_supplies.xls";
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
		if ($insertCol != ""){
			$objPHPExcel->getActiveSheet()->SetCellValue($insertCol.$insertLine, date("d/m/Y", time()));
		}
		
		// replace the year
		$rowIterator = $objPHPExcel->getActiveSheet()->getRowIterator();
		$col = array("A", "B","C","D","E","F","G","H","I","J","K","L");
		$insertCol = "";
		foreach($rowIterator as $row) {
			for ($i = 0 ; $i < count($col) ; $i++){
				$rowIndex = $row->getRowIndex ();
				$num = $objPHPExcel->getActiveSheet()->getCell($col[$i].$rowIndex)->getValue();
				if (strpos($num,"{annee}") !== false){
					$insertLine = $rowIndex;
					$insertCol = $col[$i];
					break;
				}
			}
		}
		if($insertCol != ""){
			$objPHPExcel->getActiveSheet()->SetCellValue($insertCol.$insertLine, date("Y", time()));
		}
		
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
		if ($insertCol != ""){
			$objPHPExcel->getActiveSheet()->SetCellValue($insertCol.$insertLine, $responsibleFullName);
		}
		
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
		if ($insertCol != ""){
			$objPHPExcel->getActiveSheet()->SetCellValue($insertCol.$insertLine, $unitName);
		}
		
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
		if ($insertCol != ""){
			$objPHPExcel->getActiveSheet()->SetCellValue($insertCol.$insertLine, $unitAddress);
		}
		
		// replace the bill number
		// calculate the number
		$modelBill = new SpBill();
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
		foreach($rowIterator as $row) {
			for ($i = 0 ; $i < count($col) ; $i++){
				$rowIndex = $row->getRowIndex ();
				$num = $objPHPExcel->getActiveSheet()->getCell($col[$i].$rowIndex)->getValue();
				if (strpos($num,"{nombre}") !== false){
					$insertLine = $rowIndex;
					$insertCol = $col[$i];
					break;
				}
			}
		}
		if ($insertCol != ""){
			$objPHPExcel->getActiveSheet()->SetCellValue($insertCol.$insertLine, $number);
		}
		
		
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
		$curentLine++;
		
		// set the row
		$objPHPExcel->getActiveSheet()->insertNewRowBefore($curentLine + 1, 1);
		$objPHPExcel->getActiveSheet()
		->getRowDimension($curentLine)
		->setRowHeight(25);
		
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$curentLine, "Consommable");
		$objPHPExcel->getActiveSheet()->getStyle('A'.$curentLine)->applyFromArray($styleTableHeader);
		
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$curentLine, "Utilisateur");
		$objPHPExcel->getActiveSheet()->getStyle('B'.$curentLine)->applyFromArray($styleTableHeader);
		
		$objPHPExcel->getActiveSheet()->SetCellValue('C'.$curentLine, "Nombre de \n commandes");
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
		$projectEntries = $modelProject->getProjectEntries($id_project);
		$projectItems = $modelProject->getProjectEntriesItems($id_project);
		
		$itemPricing = new SpItemPricing();
		$data = array();
		foreach($projectItems as $item){
			
			// count the number of each items
			$quantity = 0;
			$commandNumber = 0;
			foreach($projectEntries as $entry){
				$content = $entry["content"];
				if (isset($content["item_" . $item["id"]])){
					$quantity += $content["item_" . $item["id"]];
					$commandNumber++;
				}
			}
			//echo "get item price : item = " . $item["id"] . ", price = " . $LABpricingid . "<br/>"; 
			$unitaryPrice = $itemPricing->getPrice($item["id"], $LABpricingid);
			//print_r($unitaryPrice);
			$price = (float)$quantity*(float)$unitaryPrice["price"];
			
			$data[] = array("item_name" => $item["name"], "quantity" => $quantity, "commandNumber" => $commandNumber, 
							"unitary_price" => $unitaryPrice["price"], "price" => $price  );
		}
		
		$addedLine = 0;
		$totalHT = 0;
		foreach($data as $dat){
			
			if ($dat["quantity"] > 0){
			
				$addedLine++;
				$lineIdx = $curentLine + 1;
				$curentLine = $lineIdx;
				$totalHT += $dat["price"];
					
				$objPHPExcel->getActiveSheet()->insertNewRowBefore($lineIdx, 1);
					
				// Consommable
				$objPHPExcel->getActiveSheet()->SetCellValue('A'.$lineIdx, $dat["item_name"]);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$lineIdx)->applyFromArray($styleTableCell);
					
				// user full name
				$objPHPExcel->getActiveSheet()->SetCellValue('B'.$lineIdx, $userFullName);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$lineIdx)->applyFromArray($styleTableCell);
					
				// number of order
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$lineIdx, $dat["commandNumber"]);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$lineIdx)->applyFromArray($styleTableCell);
					
				// order quantity
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$lineIdx, $dat["quantity"]);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$lineIdx)->applyFromArray($styleTableCell);
					
				// unitary price
				//echo "line idx = " . $lineIdx . "<br/>";
				//echo "unit price = " . $dat["unitary_price"] . "<br/>";
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$lineIdx, $dat["unitary_price"]);
				$objPHPExcel->getActiveSheet()->getStyle('E'.$lineIdx)->applyFromArray($styleTableCell);
					
				// Total HT
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.$lineIdx, $dat["price"]);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$lineIdx)->applyFromArray($styleTableCell);
			}
		}
		
		
		// close the orders
		$modelProject->closeProject($id_project);
		// add the order to thehistory
		$modelBill->addBill($number, date("Y-m-d", time()));
				
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
		$filename = $responsibleFullName . date("Y-m-d") ."_sprojects_invoice.xls";
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
		$objWriter->save('php://output');
			
	}
}