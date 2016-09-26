<?php

require_once 'Framework/Model.php';
require_once 'Modules/sprojects/Model/SpProject.php';

require_once 'Modules/sprojects/Model/SpBill.php';
require_once 'Modules/sprojects/Model/SpItem.php';
require_once 'Modules/sprojects/Model/SpItemPricing.php';

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
		$projectInfo = $modelProject->getProject($id_project);
		
		// get the pricing
		$modelUser = new CoreUser();
		$modelUnit = new CoreUnit();
		$modelBelonging = new CoreBelonging();
		
		// get the user unit:
		//echo "resp id = " . $id_resp . "<br/>";
		$id_unit = $modelUser->getUserUnit($id_resp);
		//echo "id_unit id = " . $id_unit . "<br/>";
		
		// get the pricing

		$LABpricingid = $modelUnit->getBelonging($id_unit);
		//echo "lab pricing id = " . $LABpricingid . "<br/>";
		$unitName = $modelUnit->getUnitName($id_unit);
                $userName = $modelUser->getUserFUllName($id_user);
		$responsibleFullName = $modelUser->getUserFUllName($id_resp);
		//$userFullName = $modelUser->getUserFUllName($id_user);
		
		// get the lab info
		//echo "get the lab info <br/>";

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
		$file = "data/sprojects/template_supplies.xls";
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
                
                // replace the project number
		$rowIterator = $objPHPExcel->getActiveSheet()->getRowIterator();
		$col = array("A", "B","C","D","E","F","G","H","I","J","K","L");
		$insertCol = "";
		foreach($rowIterator as $row) {
			for ($i = 0 ; $i < count($col) ; $i++){
				$rowIndex = $row->getRowIndex ();
				$num = $objPHPExcel->getActiveSheet()->getCell($col[$i].$rowIndex)->getValue();
				if (strpos($num,"{no_projet}") !== false){
					$insertLine = $rowIndex;
					$insertCol = $col[$i];
					break;
				}
			}
		}
		if ($insertCol != ""){
			$objPHPExcel->getActiveSheet()->SetCellValue($insertCol.$insertLine, $projectInfo["name"]);
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
		
                // replace the user
                $rowIterator = $objPHPExcel->getActiveSheet()->getRowIterator();
		$col = array("A", "B","C","D","E","F","G","H","I","J","K","L");
		$insertCol = "";
		foreach($rowIterator as $row) {
			for ($i = 0 ; $i < count($col) ; $i++){
				$rowIndex = $row->getRowIndex ();
				$num = $objPHPExcel->getActiveSheet()->getCell($col[$i].$rowIndex)->getValue();
				if (strpos($num,"{utilisateur}") !== false){
					$insertLine = $rowIndex;
					$insertCol = $col[$i];
					break;
				}
			}
		}
		if ($insertCol != ""){
			$objPHPExcel->getActiveSheet()->SetCellValue($insertCol.$insertLine, $userName);
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
			else{
				$lastNumberY = date("Y", time());
				$lastNumberN = 1;
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
		
		
		// add the project informations
		$titleTab = "";
		/*
		if ($projectInfo["date_open"] == $projectInfo["date_close"]){
			$titleTab = "Prestations du ". CoreTranslator::dateFromEn($projectInfo["date_open"], "Fr")."";
		}
		else{
			$date_close = $projectInfo["date_close"];
			if ($date_close == "0000-00-00"){
				$date_close = date("d/m/Y", time());
			}
			$titleTab = "Prestations du ". CoreTranslator::dateFromEn($projectInfo["date_open"], "Fr")." au ". CoreTranslator::dateFromEn($date_close, "Fr")."";
		}
                 */
		$titleTab .= "Prestations du project No: " .  $projectInfo["name"];
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$curentLine, $titleTab);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$curentLine)->getFont()->setBold(true);
		
		$objPHPExcel->getActiveSheet()->insertNewRowBefore($curentLine + 1, 1);
		$curentLine++;

		
		// set the row
		$objPHPExcel->getActiveSheet()->insertNewRowBefore($curentLine + 1, 1);
		$objPHPExcel->getActiveSheet()
		->getRowDimension($curentLine)
		->setRowHeight(25);
		
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$curentLine, "Consommable");
		$objPHPExcel->getActiveSheet()->getStyle('A'.$curentLine)->applyFromArray($styleTableHeader);
		
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$curentLine, "Quantité");
		$objPHPExcel->getActiveSheet()->getStyle('B'.$curentLine)->applyFromArray($styleTableHeader);
		
		$objPHPExcel->getActiveSheet()->SetCellValue('C'.$curentLine, "Tarif Unitaire");
		$objPHPExcel->getActiveSheet()->getStyle('C'.$curentLine)->applyFromArray($styleTableHeader);
		
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$curentLine, "Montant");
		$objPHPExcel->getActiveSheet()->getStyle('D'.$curentLine)->applyFromArray($styleTableHeader);
		
		// ///////////////////////////////////////// //
		//             Main query                    //
		// ///////////////////////////////////////// //
		
                // add the order to the history
		$projectItems = $modelProject->getProjectEntriesItems($id_project);
                
		$itemPricing = new SpItemPricing();
		$data = array();
		foreach($projectItems as $item){
                    
                        //print_r($item);
                    
                        // calculate the item quantity
                        $projectItemEntries = $modelProject->getProjectItemEntries($id_project, $item["id"]);
                        $quantity = 0;
                        foreach($projectItemEntries as $entry){
                            if ($entry["invoice_id"] == 0){
                                $quantity += $entry["quantity"];
                            }
                        }
                        
                        // get the item price
                        $unitaryPrice = $itemPricing->getPrice($item["id"], $LABpricingid);
                        
			
			if ($item["type_id"] == 1 || $item["type_id"] == 3){
				$price = (float)$quantity*(float)$unitaryPrice["price"];
			}
			else if($item["type_id"] == 2){
				$q = (float)$quantity/60.0;
				$price = (float)$q*(float)$unitaryPrice["price"];
				$quantity = $quantity . " min";
			}
			else if($item["type_id"] == 4){
				$price = $quantity;
				$quantity = "-";
				$unitaryPrice["price"] = $price;
			}
			
			$data[] = array("item_name" => $item["name"], "quantity" => $quantity,
							"unitary_price" => $unitaryPrice["price"], "price" => $price  );
		}
		
		$addedLine = 0;
                $totalHT = 0;
		foreach($data as $dat){
			
			if ($dat["price"] > 0){
			
				$addedLine++;
				$lineIdx = $curentLine + 1;
				$curentLine = $lineIdx;
				$totalHT += $dat["price"];
					
				$objPHPExcel->getActiveSheet()->insertNewRowBefore($lineIdx, 1);
					
				// Consommable
				$objPHPExcel->getActiveSheet()->SetCellValue('A'.$lineIdx, $dat["item_name"]);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$lineIdx)->applyFromArray($styleTableCell);
					
				// order quantity
				$objPHPExcel->getActiveSheet()->SetCellValue('B'.$lineIdx, $dat["quantity"]);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$lineIdx)->applyFromArray($styleTableCell);
					
				// unitary price
				//echo "line idx = " . $lineIdx . "<br/>";
				//echo "unit price = " . $dat["unitary_price"] . "<br/>";
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$lineIdx, $dat["unitary_price"]);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$lineIdx)->applyFromArray($styleTableCell);
					
				// Total HT
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$lineIdx, $dat["price"]);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$lineIdx)->applyFromArray($styleTableCell);
			}
		}
		
		// bilan
		// total HT
		$curentLine++;
		$objPHPExcel->getActiveSheet()->insertNewRowBefore($curentLine + 1, 1);
		$objPHPExcel->getActiveSheet()->SetCellValue('C'.$curentLine, "Total H.T.");
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$curentLine, $totalHT." €");
		
		$objPHPExcel->getActiveSheet()->getStyle('C'.$curentLine)->applyFromArray($styleTableCell);
		$objPHPExcel->getActiveSheet()->getStyle('C'.$curentLine)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('D'.$curentLine)->applyFromArray($styleTableCell);
		
		// TVA 20p
		$curentLine++;
		$objPHPExcel->getActiveSheet()->insertNewRowBefore($curentLine + 1, 1);
		$objPHPExcel->getActiveSheet()->SetCellValue('C'.$curentLine, "T.V.A.:20%");
		$honoraireTVA = 0.2*$totalHT;
		$honoraireTVA = number_format(round($honoraireTVA,2), 2, '.', ' ');
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$curentLine, number_format(round($honoraireTVA,2), 2, ',', ' ')." €");
		
		$objPHPExcel->getActiveSheet()->getStyle('C'.$curentLine)->applyFromArray($styleTableCell);
		$objPHPExcel->getActiveSheet()->getStyle('C'.$curentLine)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('D'.$curentLine)->applyFromArray($styleTableCell);
		
		// space
		$curentLine++;
		$objPHPExcel->getActiveSheet()->insertNewRowBefore($curentLine + 1, 1);
		$objPHPExcel->getActiveSheet()->SetCellValue('C'.$curentLine, "");
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$curentLine, "----");
		
		// TTC
		$curentLine++;
		$objPHPExcel->getActiveSheet()->insertNewRowBefore($curentLine + 1, 1);
		$objPHPExcel->getActiveSheet()->SetCellValue('C'.$curentLine, "Total T.T.C.");
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$curentLine, number_format(round((float)$totalHT*(float)(1.2),2), 2, ',', ' ')."€");		

		$objPHPExcel->getActiveSheet()->getStyle('C'.$curentLine)->applyFromArray($styleTableCell);
		$objPHPExcel->getActiveSheet()->getStyle('C'.$curentLine)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('D'.$curentLine)->applyFromArray($styleTableCellTotal);
		
		// Save the xls file
		$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
		$filename = $responsibleFullName . date("Y-m-d") ."_sprojects_invoice.xls";
                $fileURL = "data/sprojects" . "/" . $filename;
                
                // set the file to the bill manager
                $billManagerId = $modelBill->addBill($number, $projectInfo["name"], $id_resp, date("Y-m-d", time()), $totalHT);
                $modelBill->setBillFile($billManagerId, $fileURL);
                
                //echo "invoice ID = " . $billManagerId . "<br/>";
                $modelProject->setEntryInvoiceId($id_project, $billManagerId);
                
                // save the file
                $objWriter->save($fileURL);
                
		return $filename;
			
	}
        
        protected function billResponsible($resp, $date_start, $date_end, $billDir, $noBill){
            
            $modelProject = new SpProject();
            
            // get the projects names
            $projectsIdNames = $modelProject->getRespOpenedProjects($resp);
            //echo "projects ids names <br/>";
            //print_r($projectsIdNames);
            
            // get the belonging
            $modelUnit = new CoreUnit();
            $modelUser = new CoreUser();
            $belongingID = $modelUnit->getBelonging($modelUser->getUserUnit($resp));
            
            // get the items count for this resp
            $itemsCounts = $modelProject->getProjectItemsCount($resp, $date_start, $date_end);
            
            // generate xls
            $idBill = $this->generatePeriodBill($resp, $projectsIdNames, $belongingID, $date_start, $date_end, $itemsCounts,$billDir, $noBill);
            
            // set items as billed
            $modelProject->setPojectItemsAsBilled($resp, $date_start, $date_end, $idBill);
        }
        
        public function generatePeriodBill($resp, $projectsIdNames, $belongingID, $date_start, $date_end, $itemsCounts, $billDir, $noBill){
            	
            $projectsNames = "";
            for($i = 0 ; $i < count($projectsIdNames) ; $i++){
                $projectsNames .= $projectsIdNames[$i]["name"];
                if ($i < count($projectsIdNames)-1){
                    $projectsNames .= ", ";
                }
            }
            
            $modelUser = new CoreUser();
            $modelUnit = new CoreUnit();
            $id_unit = $modelUser->getUserUnit($resp);
            $unitName = $modelUnit->getUnitName($id_unit);
            $responsibleFullName = $modelUser->getUserFUllName($resp);
           
            $unitInfo = $modelUnit->getUnit($id_unit);
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
            $file = "data/sprojects/template_supplies.xls";
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
                
            // replace the project number
            $rowIterator = $objPHPExcel->getActiveSheet()->getRowIterator();
            $col = array("A", "B","C","D","E","F","G","H","I","J","K","L");
            $insertCol = "";
            foreach($rowIterator as $row) {
		for ($i = 0 ; $i < count($col) ; $i++){
			$rowIndex = $row->getRowIndex ();
			$num = $objPHPExcel->getActiveSheet()->getCell($col[$i].$rowIndex)->getValue();
			if (strpos($num,"{no_projet}") !== false){
				$insertLine = $rowIndex;
				$insertCol = $col[$i];
				break;
			}
		}
            }
            if ($insertCol != ""){
            	$objPHPExcel->getActiveSheet()->SetCellValue($insertCol.$insertLine, $projectsNames);
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
                $objPHPExcel->getActiveSheet()->SetCellValue($insertCol.$insertLine, $noBill);
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
		
		
		// add the project informations
		$titleTab = "";
		if ($date_start == $date_end){
			$titleTab = "Prestations du ". CoreTranslator::dateFromEn($date_start, "Fr")."";
		}
		else{
			$date_close = $date_end;
			if ($date_close == "0000-00-00"){
				$date_close = date("d/m/Y", time());
			}
			$titleTab = "Prestations du ". CoreTranslator::dateFromEn($date_start, "Fr")." au ". CoreTranslator::dateFromEn($date_end, "Fr")."";
		}
		//$titleTab .= "Prestations du project No: " .  $projectInfo["name"];
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$curentLine, $titleTab);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$curentLine)->getFont()->setBold(true);
		
		$objPHPExcel->getActiveSheet()->insertNewRowBefore($curentLine + 1, 1);
		$curentLine++;

		
		// set the row
		$objPHPExcel->getActiveSheet()->insertNewRowBefore($curentLine + 1, 1);
		$objPHPExcel->getActiveSheet()
		->getRowDimension($curentLine)
		->setRowHeight(25);
		
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$curentLine, "Consommable");
		$objPHPExcel->getActiveSheet()->getStyle('A'.$curentLine)->applyFromArray($styleTableHeader);
		
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$curentLine, "Quantité");
		$objPHPExcel->getActiveSheet()->getStyle('B'.$curentLine)->applyFromArray($styleTableHeader);
		
		$objPHPExcel->getActiveSheet()->SetCellValue('C'.$curentLine, "Tarif Unitaire");
		$objPHPExcel->getActiveSheet()->getStyle('C'.$curentLine)->applyFromArray($styleTableHeader);
		
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$curentLine, "Montant");
		$objPHPExcel->getActiveSheet()->getStyle('D'.$curentLine)->applyFromArray($styleTableHeader);
		
		// ///////////////////////////////////////// //
		//             Main query                    //
		// ///////////////////////////////////////// //
		$itemPricing = new SpItemPricing();
		$data = array();
		foreach($itemsCounts as $item){
                        
                        // get the item price
                        $unitaryPrice = $itemPricing->getPrice($item["id"], $belongingID);
                        $quantity = $item["count"];
			
			if ($item["type_id"] == 1 || $item["type_id"] == 3){
				$price = (float)$quantity*(float)$unitaryPrice["price"];
			}
			else if($item["type_id"] == 2){
				$q = (float)$quantity/60.0;
				$price = (float)$q*(float)$unitaryPrice["price"];
				$quantity = $quantity . " min";
			}
			else if($item["type_id"] == 4){
				$price = $quantity;
				$quantity = "-";
				$unitaryPrice["price"] = $price;
			}
			
			$data[] = array("item_name" => $item["name"], "quantity" => $quantity,
							"unitary_price" => $unitaryPrice["price"], "price" => $price  );
		}
		
		$addedLine = 0;
                $totalHT = 0;
		foreach($data as $dat){
			
			if ($dat["price"] > 0){
			
				$addedLine++;
				$lineIdx = $curentLine + 1;
				$curentLine = $lineIdx;
				$totalHT += $dat["price"];
					
				$objPHPExcel->getActiveSheet()->insertNewRowBefore($lineIdx, 1);
					
				// Consommable
				$objPHPExcel->getActiveSheet()->SetCellValue('A'.$lineIdx, $dat["item_name"]);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$lineIdx)->applyFromArray($styleTableCell);
					
				// order quantity
				$objPHPExcel->getActiveSheet()->SetCellValue('B'.$lineIdx, $dat["quantity"]);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$lineIdx)->applyFromArray($styleTableCell);
					
				// unitary price
				//echo "line idx = " . $lineIdx . "<br/>";
				//echo "unit price = " . $dat["unitary_price"] . "<br/>";
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$lineIdx, $dat["unitary_price"]);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$lineIdx)->applyFromArray($styleTableCell);
					
				// Total HT
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$lineIdx, $dat["price"]);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$lineIdx)->applyFromArray($styleTableCell);
			}
		}
		
		// bilan
		// total HT
		$curentLine++;
		$objPHPExcel->getActiveSheet()->insertNewRowBefore($curentLine + 1, 1);
		$objPHPExcel->getActiveSheet()->SetCellValue('C'.$curentLine, "Total H.T.");
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$curentLine, $totalHT." €");
		
		$objPHPExcel->getActiveSheet()->getStyle('C'.$curentLine)->applyFromArray($styleTableCell);
		$objPHPExcel->getActiveSheet()->getStyle('C'.$curentLine)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('D'.$curentLine)->applyFromArray($styleTableCell);
		
		// TVA 20p
		$curentLine++;
		$objPHPExcel->getActiveSheet()->insertNewRowBefore($curentLine + 1, 1);
		$objPHPExcel->getActiveSheet()->SetCellValue('C'.$curentLine, "T.V.A.:20%");
		$honoraireTVA = 0.2*$totalHT;
		$honoraireTVA = number_format(round($honoraireTVA,2), 2, '.', ' ');
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$curentLine, number_format(round($honoraireTVA,2), 2, ',', ' ')." €");
		
		$objPHPExcel->getActiveSheet()->getStyle('C'.$curentLine)->applyFromArray($styleTableCell);
		$objPHPExcel->getActiveSheet()->getStyle('C'.$curentLine)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('D'.$curentLine)->applyFromArray($styleTableCell);
		
		// space
		$curentLine++;
		$objPHPExcel->getActiveSheet()->insertNewRowBefore($curentLine + 1, 1);
		$objPHPExcel->getActiveSheet()->SetCellValue('C'.$curentLine, "");
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$curentLine, "----");
		
		// TTC
		$curentLine++;
		$objPHPExcel->getActiveSheet()->insertNewRowBefore($curentLine + 1, 1);
		$objPHPExcel->getActiveSheet()->SetCellValue('C'.$curentLine, "Total T.T.C.");
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$curentLine, (float)$totalHT*(float)(1.2)."€");		

		$objPHPExcel->getActiveSheet()->getStyle('C'.$curentLine)->applyFromArray($styleTableCell);
		$objPHPExcel->getActiveSheet()->getStyle('C'.$curentLine)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('D'.$curentLine)->applyFromArray($styleTableCellTotal);
		
		// Save the xls file
		$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
		$filename = $responsibleFullName . date("Y-m-d") ."_sprojects_invoice.xls";
                $fileURL = $billDir . $filename;
                
                // set the file to the bill manager
                $modelBill = new SpBill();
                $billManagerId = $modelBill->addBill($noBill, $projectsNames, $resp, date("Y-m-d", time()), $totalHT);
                $modelBill->setBillFile($billManagerId, $fileURL);
                
                //echo "invoice ID = " . $billManagerId . "<br/>";
                //$modelProject->setEntryInvoiceId($id_project, $billManagerId);
                
                // save the file
                $objWriter->save($fileURL);
                
		return $billManagerId;
        }
        
        public function billAPeriod($date_start, $date_end){
            
            //echo "date_start = " . $date_start . "<br/>"; 
            //echo "date_end = " . $date_end . "<br/>"; 
            
            // get all the responsibles having a service offer in the period
            $responsibles = $this->getResponsiblesHavingServices($date_start, $date_end);
            if (count($responsibles) == 0){
                echo "no unbilled services found during the selected periode";
                return;
            }
            
            // get last bill number
            $noBill = $this->getlastBillNumber();
            
            // create directory
            $dataDir = date("y-m-d_H-i-s");
            $billDir = "data/sprojects/".$dataDir."/";
            if (!mkdir($billDir)){
                echo "cannot create the directory to generate bills";
                return;
            }
            
            // bill each responsible
            foreach($responsibles as $resp){
                $noBill = $this->incrementBillNumber($noBill);
                //echo "no_bill = " . $noBill . "<br/>";
                $this->billResponsible($resp["id_resp"], $date_start, $date_end, $billDir, $noBill);
            }
            
            // set the zip file to download
            $this->generateZipFile($billDir);
            
        }
        
        protected function getResponsiblesHavingServices($date_start, $date_end){
            
            $sql = "SELECT DISTINCT id_resp FROM sp_projects WHERE id IN (SELECT DISTINCT id_proj FROM sp_projects_entries WHERE date>=? AND date<=? AND invoice_id=0)";
            $req = $this->runRequest($sql, array($date_start, $date_end));
            return $req->fetchAll();
            
        }
        
        protected function incrementBillNumber($noBill){
            $noArray = explode("-", $noBill);
            $noArray[1] = floatval($noArray[1]) + 1;
            return $noArray[0] . "-" . $noArray[1];
        }
        
        protected function getlastBillNumber(){
            
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
		else{
                    $lastNumberY = date("Y", time());
                    $lastNumberN = 1;
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
        
        public function generateZipFile($billDir){
            
            $zip = new ZipArchive();
            $fileUrl = "data/sprojects/tmp.zip";
      
            if(is_dir($billDir))
            {
                // On teste si le dossier existe, car sans ça le script risque de provoquer des erreurs.
	
                if($zip->open($fileUrl, ZipArchive::CREATE) == TRUE)
                {
                    // Ouverture de l’archive réussie.

                    // Récupération des fichiers.
                    $fichiers = scandir($billDir);
                    // On enlève . et .. qui représentent le dossier courant et le dossier parent.
                    unset($fichiers[0], $fichiers[1]);
	  
                    foreach($fichiers as $f)
                    {
                        // On ajoute chaque fichier à l’archive en spécifiant l’argument optionnel.
                        // Pour ne pas créer de dossier dans l’archive.
                        //echo "add file " . $f . "<br/>";
                        if(!$zip->addFile($billDir.'/'.$f, $f))
                        {
                            echo 'Impossible d&#039;ajouter &quot;'.$f.'&quot;.<br/>';
                        }
                    }
	
                    // On ferme l’archive.
                    $zip->close();
                    //return;
                    // On peut ensuite, comme dans le tuto de DHKold, proposer le téléchargement.
                    header('Content-Transfer-Encoding: binary'); //Transfert en binaire (fichier).
                    header('Content-Disposition: attachment; filename="invoice.zip"'); //Nom du fichier.
                    header('Content-Length: '.filesize($fileUrl)); //Taille du fichier.

                    readfile($fileUrl);
                    unlink($fileUrl);
                }
                else
                {
                    // Erreur lors de l’ouverture.
                    // On peut ajouter du code ici pour gérer les différentes erreurs.
                    echo 'Erreur, impossible de créer l&#039;archive.';
                }
            }
            else
            {
              // Possibilité de créer le dossier avec mkdir().
              echo 'Le dossier &quot;upload/&quot; n&#039;existe pas.';
            } 
        }
}
