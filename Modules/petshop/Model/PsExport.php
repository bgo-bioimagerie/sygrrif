<?php

require_once 'Framework/Model.php';
require_once 'Modules/petshop/Model/PsAnimal.php';
require_once 'Modules/petshop/Model/PsType.php';
require_once 'Modules/petshop/Model/PsInvoiceHistory.php';
require_once 'Modules/petshop/Model/PsSector.php';
require_once 'Modules/petshop/Model/PsPricing.php';
require_once 'Modules/petshop/Model/PsProject.php';

require_once 'externals/PHPExcel/Classes/PHPExcel.php';

class PsExport extends Model {

    public function exportListing($beginPeriod, $endPeriod, $lang){
        
        //echo "beginPeriod = " . $beginPeriod . "<br/>";
        //echo "endPeriod = " . $endPeriod . "<br/>";
        
        // ////////////////////////////////////////////////////
        //              Create new PHPExcel object
        // ////////////////////////////////////////////////////
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Platform-Manager");
        $objPHPExcel->getProperties()->setLastModifiedBy("Platform-Manager");
        $objPHPExcel->getProperties()->setTitle("Animals listing");
        $objPHPExcel->getProperties()->setSubject("Animals listing");
        $objPHPExcel->getProperties()->setDescription("");
        
        // ////////////////////////////////////////////////////
        //              stylesheet
        // ////////////////////////////////////////////////////
        $styleBorderedCell = array(
            'font' => array(
                'name' => 'Times',
                'size' => 10,
                'bold' => false,
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
                    'rgb' => 'ffffff',
                ),
            ),
            'alignment' => array(
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            ),
        );
        
        $styleBorderedCenteredCell = array(
            'font' => array(
                'name' => 'Times',
                'size' => 10,
                'bold' => false,
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
                    'rgb' => 'ffffff',
                ),
            ),
            'alignment' => array(
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
        );
        
        // query
        $modelAnimal = new PsAnimal();
        $modelPsAnimalType = new PsType();
        $animalsTypes = $modelPsAnimalType->getAll("name");
        
        //print_r($animalsTypes);
        
        $iter = -1;
        foreach ($animalsTypes as $anType){
            if ($anType["name"] != "--"){
                $iter++;
                if ($iter > 0){
                    $objPHPExcel->createSheet();
                }
                $objPHPExcel->setActiveSheetIndex($iter);
                $objPHPExcel->getActiveSheet()->setTitle($anType["name"]);
                $objPHPExcel->setActiveSheetIndex($iter);
                $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);

                $curentLine = 1;

                $objPHPExcel->getActiveSheet()->setCellValue('A' . $curentLine, PsTranslator::NoAnimal($lang));
                $objPHPExcel->getActiveSheet()->SetCellValue('B' . $curentLine, PsTranslator::Project($lang));
                $objPHPExcel->getActiveSheet()->SetCellValue('C' . $curentLine, PsTranslator::DateEntry($lang));
                $objPHPExcel->getActiveSheet()->SetCellValue('D' . $curentLine, PsTranslator::ExitDate($lang));
                $objPHPExcel->getActiveSheet()->SetCellValue('E' . $curentLine, PsTranslator::Lineage($lang));
                $objPHPExcel->getActiveSheet()->SetCellValue('F' . $curentLine, PsTranslator::BirthDate($lang));
                $objPHPExcel->getActiveSheet()->SetCellValue('G' . $curentLine, PsTranslator::Father($lang));
                $objPHPExcel->getActiveSheet()->SetCellValue('H' . $curentLine, PsTranslator::Mother($lang));
                $objPHPExcel->getActiveSheet()->SetCellValue('I' . $curentLine, PsTranslator::Sexe($lang));
                $objPHPExcel->getActiveSheet()->SetCellValue('J' . $curentLine, PsTranslator::Genotype($lang));
                $objPHPExcel->getActiveSheet()->SetCellValue('K' . $curentLine, PsTranslator::Supplier($lang));
                $objPHPExcel->getActiveSheet()->SetCellValue('L' . $curentLine, CoreTranslator::User($lang));
                $objPHPExcel->getActiveSheet()->SetCellValue('M' . $curentLine, PsTranslator::Sector($lang));
                $objPHPExcel->getActiveSheet()->SetCellValue('N' . $curentLine, CoreTranslator::Unit($lang));
                $objPHPExcel->getActiveSheet()->SetCellValue('O' . $curentLine, "ID");


                $objPHPExcel->getActiveSheet()->getStyle('A' . $curentLine)->applyFromArray($styleBorderedCell);
                $objPHPExcel->getActiveSheet()->getStyle('B' . $curentLine)->applyFromArray($styleBorderedCell);
                $objPHPExcel->getActiveSheet()->getStyle('C' . $curentLine)->applyFromArray($styleBorderedCell);
                $objPHPExcel->getActiveSheet()->getStyle('D' . $curentLine)->applyFromArray($styleBorderedCell);
                $objPHPExcel->getActiveSheet()->getStyle('E' . $curentLine)->applyFromArray($styleBorderedCell);
                $objPHPExcel->getActiveSheet()->getStyle('F' . $curentLine)->applyFromArray($styleBorderedCell);
                $objPHPExcel->getActiveSheet()->getStyle('G' . $curentLine)->applyFromArray($styleBorderedCell);
                $objPHPExcel->getActiveSheet()->getStyle('H' . $curentLine)->applyFromArray($styleBorderedCell);
                $objPHPExcel->getActiveSheet()->getStyle('I' . $curentLine)->applyFromArray($styleBorderedCell);
                $objPHPExcel->getActiveSheet()->getStyle('J' . $curentLine)->applyFromArray($styleBorderedCell);
                $objPHPExcel->getActiveSheet()->getStyle('K' . $curentLine)->applyFromArray($styleBorderedCell);
                $objPHPExcel->getActiveSheet()->getStyle('L' . $curentLine)->applyFromArray($styleBorderedCell);
                $objPHPExcel->getActiveSheet()->getStyle('M' . $curentLine)->applyFromArray($styleBorderedCell);
                $objPHPExcel->getActiveSheet()->getStyle('N' . $curentLine)->applyFromArray($styleBorderedCell);
                $objPHPExcel->getActiveSheet()->getStyle('O' . $curentLine)->applyFromArray($styleBorderedCell);


                $animalsList = $modelAnimal->getAnimalIn($beginPeriod, $endPeriod, $anType["id"]);
                //echo "<br/>";print_r($animalsList); echo "<br/>";
                foreach($animalsList as $animal){
                    $curentLine++;
                    $objPHPExcel->getActiveSheet()->SetCellValue('A' . $curentLine, $animal["no_animal"]);
                    $objPHPExcel->getActiveSheet()->SetCellValue('B' . $curentLine, $animal["projectName"]);
                    $objPHPExcel->getActiveSheet()->SetCellValue('C' . $curentLine, $animal["date_entry"]);
                    $objPHPExcel->getActiveSheet()->SetCellValue('D' . $curentLine, $animal["date_exit"]);
                    $objPHPExcel->getActiveSheet()->SetCellValue('E' . $curentLine, $animal["lineage"]);
                    $objPHPExcel->getActiveSheet()->SetCellValue('F' . $curentLine, $animal["birth_date"]);
                    $objPHPExcel->getActiveSheet()->SetCellValue('G' . $curentLine, $animal["father"]);
                    $objPHPExcel->getActiveSheet()->SetCellValue('H' . $curentLine, $animal["mother"]);
                    $objPHPExcel->getActiveSheet()->SetCellValue('I' . $curentLine, $animal["sexe"]);
                    $objPHPExcel->getActiveSheet()->SetCellValue('J' . $curentLine, $animal["genotypage"]);
                    $objPHPExcel->getActiveSheet()->SetCellValue('K' . $curentLine, $animal["supplierName"]);
                    $objPHPExcel->getActiveSheet()->SetCellValue('L' . $curentLine, $animal["userName"]);
                    $objPHPExcel->getActiveSheet()->SetCellValue('M' . $curentLine, $animal["hist"][0]["sectorName"]);
                    $objPHPExcel->getActiveSheet()->SetCellValue('N' . $curentLine, $animal["hist"][0]["unitName"]);
                    $objPHPExcel->getActiveSheet()->SetCellValue('O' . $curentLine, $animal["id"]);    

                    $objPHPExcel->getActiveSheet()->getStyle('A' . $curentLine)->applyFromArray($styleBorderedCell);
                    $objPHPExcel->getActiveSheet()->getStyle('B' . $curentLine)->applyFromArray($styleBorderedCell);
                    $objPHPExcel->getActiveSheet()->getStyle('C' . $curentLine)->applyFromArray($styleBorderedCell);
                    $objPHPExcel->getActiveSheet()->getStyle('D' . $curentLine)->applyFromArray($styleBorderedCell);
                    $objPHPExcel->getActiveSheet()->getStyle('E' . $curentLine)->applyFromArray($styleBorderedCell);
                    $objPHPExcel->getActiveSheet()->getStyle('F' . $curentLine)->applyFromArray($styleBorderedCell);
                    $objPHPExcel->getActiveSheet()->getStyle('G' . $curentLine)->applyFromArray($styleBorderedCell);
                    $objPHPExcel->getActiveSheet()->getStyle('H' . $curentLine)->applyFromArray($styleBorderedCell);
                    $objPHPExcel->getActiveSheet()->getStyle('I' . $curentLine)->applyFromArray($styleBorderedCell);
                    $objPHPExcel->getActiveSheet()->getStyle('J' . $curentLine)->applyFromArray($styleBorderedCell);
                    $objPHPExcel->getActiveSheet()->getStyle('K' . $curentLine)->applyFromArray($styleBorderedCell);
                    $objPHPExcel->getActiveSheet()->getStyle('L' . $curentLine)->applyFromArray($styleBorderedCell);
                    $objPHPExcel->getActiveSheet()->getStyle('M' . $curentLine)->applyFromArray($styleBorderedCell);
                    $objPHPExcel->getActiveSheet()->getStyle('N' . $curentLine)->applyFromArray($styleBorderedCell);
                    $objPHPExcel->getActiveSheet()->getStyle('O' . $curentLine)->applyFromArray($styleBorderedCell);

                }
            }
        }
        // write excel file
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);

        //On enregistre les modifications et on met en téléchargement le fichier Excel obtenu
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="platorm-manager-animal_listing.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
    }
    
    public function invoiceResponsible($beginPeriod, $endPeriod, $responsibleID, $lang){
        $invoiceNumber = $this->calculateInvoiceNumber();
        $this->invoice($beginPeriod, $endPeriod, $responsibleID, $invoiceNumber, "", $lang);
    }
    
    public function invoice($beginPeriod, $endPeriod, $responsibleID, $invoiceNumber, $billDir, $lang){
        
        // get infos
        $modelUser = new CoreUser();
        $responsibleName = $modelUser->getUserFUllName($responsibleID);
        $id_unit = $modelUser->getUserUnit($responsibleID);
        $modelUnit = new CoreUnit();
        $id_belonging = $modelUnit->getBelonging($id_unit);
        $unitName = $modelUnit->getUnitName($id_unit);
        $unitAddress = $modelUnit->getAdress($id_unit);
        
        $modelAnimal = new PsAnimal();
        $modelPsSector = new PsSector();
        $sectors = $modelPsSector->getallsectors();
        
        $modelType = new PsType();
        $types = $modelType->getAll();
        
        $modelPricing = new PsPricing();
        
        // initialise the xls file
        // /////////////////////////////////////////// //
	//             xls output                      //
	// /////////////////////////////////////////// //
	// stylesheet
	$stylesheet = $this->stylesheet();
        
        // load the template
	$file = "data/petshop/template.xls";
	$XLSDocument = new PHPExcel_Reader_Excel5();
	$objPHPExcel = $XLSDocument->load($file);
          
        // set informations
        $objPHPExcel = $this->replaceVariable($objPHPExcel, "unite", $unitName);
        $objPHPExcel = $this->replaceVariable($objPHPExcel, "adresse", $unitAddress);
        $objPHPExcel = $this->replaceVariable($objPHPExcel, "date", CoreTranslator::dateFromEn(date("Y-m-d"), $lang));
        $objPHPExcel = $this->replaceVariable($objPHPExcel, "annee", date("Y"));
        $objPHPExcel = $this->replaceVariable($objPHPExcel, "responsable", $responsibleName);
        $objPHPExcel = $this->replaceVariable($objPHPExcel, "nombre", $invoiceNumber);
        
        
        // fill table
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
		
	$titleTab = PsTranslator::hostedAnimalsFrom($lang) . $beginPeriod. PsTranslator::to($lang) . $endPeriod;
        
	$objPHPExcel->getActiveSheet()->SetCellValue('A'.$curentLine, $titleTab);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$curentLine)->getFont()->setBold(true);
	$curentLine++;
		
	// set the row
	$objPHPExcel->getActiveSheet()->insertNewRowBefore($curentLine, 1);
	$objPHPExcel->getActiveSheet()->getRowDimension($curentLine)->setRowHeight(25);
		
	$objPHPExcel->getActiveSheet()->SetCellValue('A'.$curentLine, PsTranslator::Sector($lang));
	$objPHPExcel->getActiveSheet()->getStyle('A'.$curentLine)->applyFromArray($stylesheet["styleTableHeader"]);
		
	$objPHPExcel->getActiveSheet()->SetCellValue('B'.$curentLine, PsTranslator::AnimalsType($lang));
	$objPHPExcel->getActiveSheet()->getStyle('B'.$curentLine)->applyFromArray($stylesheet["styleTableHeader"]);
		
	$objPHPExcel->getActiveSheet()->SetCellValue('C'.$curentLine, PsTranslator::NumberOfDay($lang));
	$objPHPExcel->getActiveSheet()->getStyle('C'.$curentLine)->getAlignment()->setWrapText(true);
	$objPHPExcel->getActiveSheet()->getStyle('C'.$curentLine)->applyFromArray($stylesheet["styleTableHeader"]);
		
	$objPHPExcel->getActiveSheet()->SetCellValue('D'.$curentLine, PsTranslator::UnitaryPrice($lang));
	$objPHPExcel->getActiveSheet()->getStyle('D'.$curentLine)->applyFromArray($stylesheet["styleTableHeader"]);
		
	$objPHPExcel->getActiveSheet()->SetCellValue('E'.$curentLine, PsTranslator::Total($lang));
	$objPHPExcel->getActiveSheet()->getStyle('E'.$curentLine)->applyFromArray($stylesheet["styleTableHeader"]);
		
	$total = 0;
        $firtLine = $curentLine+1;
        foreach($sectors as $sector){
            foreach($types as $type){
            
                $daysNum = $modelAnimal->countNumberOfDays($beginPeriod, $endPeriod, $sector["id"], $type["id"], $responsibleID);
                
                if ($daysNum > 0){
                    $curentLine++;
                    $price = $modelPricing->getPrice($sector["id"], $id_belonging, $type["id"]);
                    /*
                    echo "price = " . $price . "<br/>";
                    echo "sector = " . $sector["id"] . "<br/>";
                    echo "id_belonging = " . $id_belonging . "<br/>";
                    echo "type = " . $type["id"] . "<br/>";
                    
                     */
                    $total += $daysNum*$price;
                    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$curentLine, $sector["name"]);
                    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$curentLine, $type["name"]);
                    $objPHPExcel->getActiveSheet()->SetCellValue('C'.$curentLine, $daysNum);
                    $objPHPExcel->getActiveSheet()->SetCellValue('D'.$curentLine, $price);
                    $objPHPExcel->getActiveSheet()->SetCellValue('E'.$curentLine, "=C".$curentLine."*D".$curentLine);
						
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$curentLine)->applyFromArray($stylesheet["styleTableCell"]);
                    $objPHPExcel->getActiveSheet()->getStyle('B'.$curentLine)->applyFromArray($stylesheet["styleTableCell"]);
                    $objPHPExcel->getActiveSheet()->getStyle('C'.$curentLine)->applyFromArray($stylesheet["styleTableCell"]);
                    $objPHPExcel->getActiveSheet()->getStyle('D'.$curentLine)->applyFromArray($stylesheet["styleTableCell"]);
                    $objPHPExcel->getActiveSheet()->getStyle('E'.$curentLine)->applyFromArray($stylesheet["styleTableCell"]);
                  			
                }
            }
        }
        
        $lastLine = $curentLine;
        $modelConfig = new CoreConfig();
        if($modelConfig->getParam("ps_invoice_tva") == 1){
            // TVA 20p
            $curentLine++;
            $tvaLine = $curentLine;
            $objPHPExcel->getActiveSheet()->insertNewRowBefore($curentLine + 1, 1);
            $objPHPExcel->getActiveSheet()->SetCellValue('D'.$curentLine, "T.V.A.:20%");
          
            $objPHPExcel->getActiveSheet()->SetCellValue('E'.$curentLine, "=SUM(E".$firtLine."E".$lastLine.")");

            $objPHPExcel->getActiveSheet()->getStyle('D'.$curentLine)->applyFromArray($stylesheet["styleTableCell"]);
            $objPHPExcel->getActiveSheet()->getStyle('D'.$curentLine)->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('E'.$curentLine)->applyFromArray($stylesheet["styleTableCell"]);

            // space
            $curentLine++;
            $objPHPExcel->getActiveSheet()->insertNewRowBefore($curentLine + 1, 1);
            $objPHPExcel->getActiveSheet()->SetCellValue('D'.$curentLine, "");
            $objPHPExcel->getActiveSheet()->SetCellValue('E'.$curentLine, "----");
        }
	// TTC
	$curentLine++;
	$objPHPExcel->getActiveSheet()->insertNewRowBefore($curentLine + 1, 1);
	$objPHPExcel->getActiveSheet()->SetCellValue('D'.$curentLine, PsTranslator::Total($lang));
        
        $content = "=SUM(E".$firtLine.":E".$lastLine.")";
        if($modelConfig->getParam("ps_invoice_tva") == 1){
            $content .= "+E".$tvaLine;
        }
        
	$objPHPExcel->getActiveSheet()->SetCellValue('E'.$curentLine, $content);
		
	$objPHPExcel->getActiveSheet()->getStyle('E'.$curentLine)->applyFromArray($stylesheet["styleTableCell"]);
	$objPHPExcel->getActiveSheet()->getStyle('E'.$curentLine)->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('F'.$curentLine)->applyFromArray($stylesheet["styleTableCellTotal"]);
	
	// export the xls file
	// Save the xls file
	$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
	$nom = $unitName . '_' . $responsibleName . "_" . $beginPeriod . "_" . $endPeriod ."_invoice.xls";
	
        // add invoice to the database
        $modelInvoiceHist = new PsInvoiceHistory();
        if ($billDir == ""){
            $invoiceurl = "data/petshop/".$nom;
        }
        else{
            $invoiceurl = $billDir . "/" . $nom;
        }
        $modelInvoiceHist->add($invoiceNumber, $beginPeriod, $endPeriod, date("Y-m-d"), $id_unit, $responsibleID, $total, $invoiceurl);
        
        if ($billDir == ""){
            
            $objWriter->save($invoiceurl);
            
            header_remove();
            //ob_clean();
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'.$nom.'"');
            header('Cache-Control: max-age=0');
            readfile($invoiceurl);
            //$objWriter->save('php://output');
            

        }
        else{
            //echo "save bill file to :" . $billDir . "/" . $nom;
            $objWriter->save($invoiceurl);
        }
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
        
        
        public function calculateInvoiceNumber(){
		// calculate the number
		$modelBill = new PsInvoiceHistory();
		$bills = $modelBill->getAll("number");
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
                            return date("Y", time()) . "-0001";
                        }
			$num = "".$lastNumberN."";
			if ($lastNumberN < 10){
				$num = "000" . $lastNumberN;
			}
			else if ($lastNumberN >= 10 && $lastNumberN < 100){
				$num = "00" . $lastNumberN;
			}
                        else if ($lastNumberN >= 100 && $lastNumberN < 1000){
				$num = "0" . $lastNumberN;
			}
			$number = $lastNumberY ."-". $num ;
		}
		else{
			$number = date("Y", time()) . "-0001";
		}
		
		return $number;
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
        
        public function invoiceall($beginPeriod, $endPeriod, $lang){
            
            // get all responsibles
            $modelResp = new CoreResponsible();
            $resps = $modelResp->responsiblesIds();
            
            // create the output dir
            $dataDir = date("y-m-d_H-i-s");
            $billDir = "data/petshop/".$dataDir;
            if (!mkdir($billDir)){
                return;
            }
            
            $invoiceNumber = $this->calculateInvoiceNumber();
           
            // generate bill when there are animals to invoice
            $modelProject = new PsProject();
            $pass = 0;
            foreach($resps as $resp){
                // get resp projects
                $projects = $modelProject->getByResponsible($resp[0]);
                foreach($projects as $project){
                    // invoic only if some animals are in the periode
                    $sql = "SELECT id FROM ps_animals WHERE id_project=? AND (date_exit=? OR (date_entry < ? AND date_exit > ?))";
                    $req = $this->runRequest($sql, array($project["id"], "0000-00-00", $endPeriod, $beginPeriod));
                    if ($req->rowCount() > 0){
                        $pass++;
                        if ($pass > 1){
                            $noArray = explode("-", $invoiceNumber);
                            $numYearBill = floatval($noArray[1]) + 1;
                            $invoiceNumber = $noArray[0] . "-" . $this->float2ZeroStr($numYearBill);
                        }
                        
                        $this->invoice($beginPeriod, $endPeriod, $resp[0], $invoiceNumber, $billDir, $lang);
                    }
                }
            }
            
            $this->generateZipFile($billDir);
        }
        
        public function float2ZeroStr($numYearBill){
                    $nyb = "";
                    if ($numYearBill < 10){
                        $nyb = "000" . $numYearBill; 
                    }
                    else if($numYearBill >= 10 && $numYearBill < 100){
                        $nyb = "00" . $numYearBill; 
                    }
                    else if($numYearBill >= 100 && $numYearBill < 1000){
                        $nyb = "0" . $numYearBill; 
                    }
                    else{
                        $nyb = $numYearBill;
                    }
                    return $nyb;
        }
        
        public function generateZipFile($billDir){
            
            
            $zip = new ZipArchive();
            $fileUrl = "data/petshop/tmp.zip";
      
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
