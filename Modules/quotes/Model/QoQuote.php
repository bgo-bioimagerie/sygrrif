<?php

require_once 'Framework/Model.php';
require_once 'Modules/core/Model/CoreUnit.php';
require_once 'Modules/core/Model/CoreUser.php';

require_once("externals/PHPExcel/Classes/PHPExcel.php");

/**
 * Class defining the template table model. 
 *
 * @author Sylvain Prigent
 */
class QoQuote extends Model {

	public function createTable(){
		$sql = "CREATE TABLE IF NOT EXISTS `qo_quotes` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
                `recipient` varchar(100) NOT NULL DEFAULT '',
                `address` text NOT NULL DEFAULT '',
                `id_belonging` int(11) NOT NULL DEFAULT 0,
                `id_user` int(11) NOT NULL DEFAULT 0,
                `date_open` DATE NOT NULL,						
		`date_last_modified` DATE NOT NULL,
                `content` varchar(1000) NOT NULL DEFAULT '',
		PRIMARY KEY (`id`)
		);";

		$this->runRequest($sql);
		
                $this->addColumn("qo_quotes", "id_user", "int(11)", 0);
	}
	
	/*
	 * 
	 * Add here the query methods
	 * 
	 */
        public function set($id, $id_user, $recipient, $address, $id_belonging, $date_open, $date_last_modified){
            if ($id > 0){
                $sql = "UPDATE qo_quotes SET id_user=?, recipient=?, address=?, id_belonging=?, date_open=?, date_last_modified=?
		        WHERE id=?";
		$this->runRequest($sql, array($id_user, $recipient, $address, $id_belonging, $date_open, $date_last_modified, $id));
                return $id;
            }
            else{
                $sql = "INSERT INTO qo_quotes (id_user, recipient, address, id_belonging, date_open, date_last_modified)
				 VALUES(?,?,?,?,?,?)";
		$this->runRequest ( $sql, array (
				$id_user, $recipient, $address, $id_belonging, $date_open, $date_last_modified
		) );
                return $this->getDatabase()->lastInsertId();
            }
            
        }
      
        public function get($id){
            $sql = "SELECT content FROM qo_quotes WHERE id=?";
            $req = $this->runRequest($sql, array($id));
            $tmp = $req->fetch();
            return $tmp[0];
        }
        
        public function getInfo($id){
            $sql = "SELECT * FROM qo_quotes WHERE id=?";
            $req = $this->runRequest($sql, array($id));
            return $req->fetch();
            
        }
        
        public function getDateCreated($id){
            $sql = "SELECT date_open FROM qo_quotes WHERE id=?";
            $req = $this->runRequest($sql, array($id));
            $tmp = $req->fetch();
            return $tmp[0];
        }
        
        public function delete($id){
            $sql="DELETE FROM qo_quotes WHERE id = ?";
            $this->runRequest($sql, array($id));
        } 
        
        public function getAll($sortentry = "date_open"){
       
            $sql = "SELECT *
    			FROM qo_quotes
    			ORDER BY " . $sortentry . " ASC;";
            $req = $this->runRequest($sql);
            return $req->fetchAll();
        }
        
        public function setContent($quoteID, $contentKeys, $contentValues){
            // create the content line
            $content = "";
            for($i = 0 ; $i < count($contentKeys) ; $i++){
                $content .= $contentKeys[$i] . "=" . $contentValues[$i] . ";";
            }
            
            $sql = "UPDATE qo_quotes SET content=? WHERE id=?";
            $this->runRequest($sql, array($content, $quoteID));
        }
        
        public function getContent($quoteID){
            $sql = "SELECT content FROM qo_quotes WHERE id=?";
            $req = $this->runRequest($sql, array($quoteID));
            $tmp = $req->fetch();
            $content = $tmp[0];
            
            $entries = explode(";", $content);
            $contentArray = array();
            foreach($entries as $entry){
                $entryData = explode("=", $entry);
                if (count($entryData) == 2){
                    $contentArray[$entryData[0]] = $entryData[1];
                }
            }
            return $contentArray;
        }
        
        public function getDefault(){
            $quote['id'] = 0;
            $quote['recipient'] = "";
            $quote['address'] = "";
            $quote['id_belonging'] = 0;
            $quote['id_user'] = 0;
            $quote['date_open'] = 0;
            $quote['date_last_modified'] = 0;
        }
        
        public function getAllSupplies(){
            
            $supplies = array();
            // from sygrrif
            if ($this->isTable("sy_resources")){
                $sql = "SELECT id, name FROM sy_resources";
                $res = $this->runRequest($sql)->fetchAll();
                for($i = 0 ; $i < count($res) ; $i++){
                    $supplies['sy_'.$res[$i]['id']] = $res[$i]['name']; 
                }
            }
            
            if ($this->isTable("sp_items")){
                $sql = "SELECT id, name FROM sp_items";
                $res = $this->runRequest($sql)->fetchAll();
                for($i = 0 ; $i < count($res) ; $i++){
                    $supplies['sp_'.$res[$i]['id']] = $res[$i]['name']; 
                }
            }
            return $supplies;
        }
        
        public function generateQuoteXls($idQuote){
            	
		// get the quote informations
                $quoteInfo = $this->getInfo($idQuote);
		$LABpricingid = $quoteInfo["id_belonging"];
                if ($LABpricingid == 0 || $LABpricingid == ""){
                    $modelUser = new CoreUser();
                    $unit_id = $modelUser->getUserUnit($quoteInfo["id_user"]);
                    
                    $modelUnit = new CoreUnit();
                    $LABpricingid = $modelUnit->getBelonging($unit_id);
                }
 
                $quoteInfo["unit"] = "";
                if ($quoteInfo["id_user"] > 0){
                    
                    $modelUser = new CoreUser();
                    $modelUnit = new CoreUnit();
                    $unitID = $modelUser->getUserUnit($quoteInfo["id_user"]);
                    $quoteInfo["unit"] = $modelUnit->getUnitName($unitID); 
                    $quoteInfo["address"] = $modelUnit->getAdress($unitID);
                    $quoteInfo["recipient"] = $modelUser->getUserFUllName($quoteInfo["id_user"]);
                }
                
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
		$file = "data/quotes/template.xls";
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
			$objPHPExcel->getActiveSheet()->SetCellValue($insertCol.$insertLine, $quoteInfo["recipient"]);
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
			$objPHPExcel->getActiveSheet()->SetCellValue($insertCol.$insertLine, $quoteInfo["unit"]);
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
			$objPHPExcel->getActiveSheet()->SetCellValue($insertCol.$insertLine, $quoteInfo["address"]);
		}
		
		
		
		// get the table index
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
		
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$curentLine, "Prestation");
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
                $content = $this->getContent($idQuote);
	
		$addedLine = 0;
		$totalHT = 0;
		foreach($content as $datKey => $datValue){
			
			if ($datValue > 0){
			
				$addedLine++;
				$lineIdx = $curentLine + 1;
				$curentLine = $lineIdx;
                                
                                // get the prestation name
                                //echo "key = " . $datKey . ", value = " . $datValue ."<br/>";
                                $prestaName = $this->getPrestationNameFromKey($datKey);
                                
                                // get the prestation price
                                
                                $prestaPrice = $this->getPrestationPriceFromKey($datKey, $LABpricingid);
                                
                                $datPice = (float)$datValue*(float)$prestaPrice;
                                
				$totalHT += $datPice;
					
				$objPHPExcel->getActiveSheet()->insertNewRowBefore($lineIdx, 1);
					
				// Consommable
				$objPHPExcel->getActiveSheet()->SetCellValue('A'.$lineIdx, $prestaName);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$lineIdx)->applyFromArray($styleTableCell);

					
				// order quantity
				$objPHPExcel->getActiveSheet()->SetCellValue('B'.$lineIdx, $datValue);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$lineIdx)->applyFromArray($styleTableCell);
					
				// unitary price
				//echo "line idx = " . $lineIdx . "<br/>";
				//echo "unit price = " . $dat["unitary_price"] . "<br/>";
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$lineIdx, $prestaPrice);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$lineIdx)->applyFromArray($styleTableCell);
					
				// Total HT
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$lineIdx, $datPice);
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
		$filename = $quoteInfo["recipient"] . date("Y-m-d") ."_quote.xls";
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
		$objWriter->save('php://output');
			
	}
        
        private function getPrestationNameFromKey($datKey){
            $keyArray = explode("_", $datKey);
            if (count($keyArray) == 2){
                if ($keyArray[0] == "sy"){
                    $sql = "SELECT name FROM sy_resources WHERE id=?";
                    $tmp = $this->runRequest($sql, array($keyArray[1]))->fetch();
                    return $tmp[0]; 
                }
                else if($keyArray[0] == "sp"){
                    $sql = "SELECT name FROM sp_items WHERE id=?";
                    $tmp = $this->runRequest($sql, array($keyArray[1]))->fetch();
                    return $tmp[0]; 
                }
            }
            return "";
        }
        
        private function getPrestationPriceFromKey($datKey, $id_belonging){
            $keyArray = explode("_", $datKey);
            if (count($keyArray) == 2){
                if ($keyArray[0] == "sy"){
                    $sql = "SELECT price_day FROM sy_j_resource_pricing WHERE id_resource=? AND id_pricing=?";
                    $tmp = $this->runRequest($sql, array($keyArray[1], $id_belonging))->fetch();
                    return $tmp[0]; 
                }
                else if($keyArray[0] == "sp"){
                    $sql = "SELECT price FROM sp_j_item_pricing WHERE id_item=? AND id_pricing=?";
                    $tmp = $this->runRequest($sql, array($keyArray[1], $id_belonging))->fetch();
                    return $tmp[0]; 
                }
            }
            return 0;
        }
}