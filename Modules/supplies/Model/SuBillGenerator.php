<?php

require_once 'Framework/Model.php';
require_once 'Modules/core/Model/CoreBelonging.php';
require_once 'Modules/supplies/Model/SuItemPricing.php';
require_once 'Modules/supplies/Model/SuBill.php';
require_once 'Modules/supplies/Model/SuEntry.php';
require_once("externals/PHPExcel/Classes/PHPExcel.php");

/**
 * Class defining the supplies pricing model
 *
 * @author Sylvain Prigent
 */
class SuBillGenerator extends Model {
	
        public function invoiceResponsible($responsibleID, $lang){
            $invoiceNumber = $this->calculateBillNumber();
            if ($responsibleID <= 2){
                echo "Cannot find the person in charge of the unit <br/>";
            }
            $this->invoice($responsibleID, $invoiceNumber, "", $lang);
        }
        
        public function billAll($lang){
            
            $sql = "SELECT DISTINCT id_user FROM su_entries WHERE id_status=1";
            $users = $this->runRequest($sql)->fetchAll();
            
            $modelResp = new CoreResponsible();
            //$resps = array();
            //print_r($users); echo "<br/>";
            foreach($users as $user){
                //print_r($user); echo "<br/>";
                $resps[] = $modelResp->getResponsibleId($user[0]);
                //echo "resp of " . $user[0] . " is " . $modelResp->getResponsibleId($user[0]) . "<br/>";
            }
            //print_r($resps); echo "<br/>";
            $respsList = array_unique($resps);
            
            // create the output dir
            $dataDir = date("y-m-d_H-i-s");
            $billDir = "data/supplies/".$dataDir;
            if (!mkdir($billDir)){
                return;
            }
            
            $invoiceNumber = $this->calculateBillNumber();
            
            $pass = 0;
            foreach($respsList as $resp){
                
                //echo "generate bill for resp :" . $resp . "<br/>";
                if ($resp > 0){
                    $pass++;
                    // increment bill number
                    if ($pass > 1){
                        $noArray = explode("-", $invoiceNumber);
                        $numYearBill = floatval($noArray[1]) + 1;
                        $invoiceNumber = $noArray[0] . "-" . $this->float2ZeroStr($numYearBill);
                    }
                    $this->invoice($resp, $invoiceNumber, $billDir, $lang);
                }
            }
            
            // generate output file
            $this->generateZipFile($billDir);
        }
    
	public function invoice($responsible_id, $invoiceNumber, $billDir, $lang){
		
		
		// /////////////////////////////////////////// // 
		//        get the input informations           //
		// /////////////////////////////////////////// //
                
		// get the responsibnle info
		// responsible fullname
		$modelUser = new CoreUser();
		$responsibleFullName = $modelUser->getUserFUllName($responsible_id);
                //echo "responsible_id = " . $responsible_id . "<br/>";
		$unit_id = $modelUser->getUserUnit($responsible_id); 	
                
                if ($unit_id < 2){
                    echo "unit id = " . $unit_id . "<br/>";
                    return;
                }
		// unit name
		$modelUnit = new CoreUnit();
		$unitName = $modelUnit->getUnitName($unit_id);
		
		$LABpricingid = $modelUnit->getBelonging($unit_id);
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
		$file = "data/supplies/template_supplies.xls";
		$XLSDocument = new PHPExcel_Reader_Excel5();
		$objPHPExcel = $XLSDocument->load($file);
		
		// get the line where to insert the table
		$insertLine = 0;
		
		// replace the date
                $this->replaceVariable($objPHPExcel, "date", date("d/m/Y", time()));
		
		// replace the year
                $this->replaceVariable($objPHPExcel, "annee", date("Y", time()));
		
		// replace the responsible
                $this->replaceVariable($objPHPExcel, "responsable", $responsibleFullName);
                
		// replace $unitName
                $this->replaceVariable($objPHPExcel, "unite", $unitName);
                
                
		// replace address $unitAddress
                $this->replaceVariable($objPHPExcel, "adresse", $unitAddress);
               
		// replace the bill number
                $this->replaceVariable($objPHPExcel, "nombre", $invoiceNumber);
		
		// get table row index table
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
		
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$curentLine, "Equipement");
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
                // get all users having an active order
		$sql = "SELECT DISTINCT id_user FROM su_entries WHERE id_status = 1";
		$req = $this->runRequest($sql);
		$beneficiaire = $req->fetchAll();
		
		// select users whose unit and responsible is the selected one
		$i=0;
		$people = array();
		$modelResp = new CoreResponsible();
                foreach($beneficiaire as $b){
			// user info
			
                    if ($modelResp->isUserRespJoin($b[0], $responsible_id) ){
                        $sql = "SELECT name, firstname FROM core_users WHERE id=?";
                        $req = $this->runRequest($sql, array($b[0]));
                        
                        $nomPrenom = $req->fetch();
                        $people[0][$i] = $nomPrenom["name"]; 	//Nom du beneficiaire
                        $people[1][$i] = $nomPrenom["firstname"]; 	//Prénom du bénéficiaire
                        $people[2][$i] = $b[0];				//id du bénéficiaire
                        $people[3][$i] = $modelUser->getUserResponsibles($b[0]);	//Responsable du bénéficiaire
                        $people[4][$i] = $LABpricingid;	//Tarif appliqué
                        $i++;
                    }
                        
		}
		if (count($people) == 0){
                    echo "There are no open orders for the given responsible";
                    return;
		}
		array_multisort($people[0],SORT_ASC,$people[1],$people[2],$people[3],$people[4]);
		
		// get the items
		$sql = 'SELECT * FROM su_items ORDER BY name';
		$req = $this->runRequest($sql);
		$items = $req->fetchAll();
		$i=0;
		$modelItemPricing = new SuItemPricing();
		 
		$totalHT = 0;
		$ordersToClose = array();
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
				$sql = "SELECT id, content FROM su_entries WHERE id_user=" . $people[2][$j] . " AND id_status=1";
				$req = $this->runRequest($sql);
				$queryouts = $req->fetchAll();
				//print_r($queryouts);
				$quantity = 0;
				$orderNumber = count($queryouts);
				foreach ($queryouts as $out){
					$ordersToClose[] = $out["id"];
					$content = $out["content"];
					//print_r($content);
					// get the quentity for item=itemID
					$citems = explode(";", $content);
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
				$curentLine ++;//= $addedLine -1;
				$roomspan = $curentLine + $addedLine -1;
				$objPHPExcel->getActiveSheet()->mergeCells('A'.$curentLine.':A'.$roomspan);
				$objPHPExcel->getActiveSheet()->SetCellValue('A'.$curentLine, $itemName); // item name
				$objPHPExcel->getActiveSheet()->getStyle('A'.$curentLine)->applyFromArray($styleTableCell);
				$curentLine += $addedLine -1;
			}
		}
		
		// close the orders
                //print_r($ordersToClose);
		$modelEntry = new SuEntry();
		foreach ($ordersToClose as $toClose){
			$modelEntry->setEntryCloded($toClose);
		}
				
		// bilan
		// total HT
		$curentLine++;
		$objPHPExcel->getActiveSheet()->insertNewRowBefore($curentLine + 1, 1);
		$objPHPExcel->getActiveSheet()->SetCellValue('E'.$curentLine, "Total H.T.");
		$objPHPExcel->getActiveSheet()->SetCellValue('F'.$curentLine, number_format(round($totalHT,2), 2, ',', ' ')." €");
		
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
		$objPHPExcel->getActiveSheet()->SetCellValue('F'.$curentLine, number_format(round((float)$totalHT*(float)1.2,2), 2, ',', ' ')." €");		

		$objPHPExcel->getActiveSheet()->getStyle('E'.$curentLine)->applyFromArray($styleTableCell);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$curentLine)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('F'.$curentLine)->applyFromArray($styleTableCellTotal);
		
                $nom = $unitName . '_' . $responsibleFullName ."_supplies.xls";
		// add the order to thehistory
                if ($billDir == ""){
                    $invoiceurl = "data/supplies/".$nom;
                }
                else{
                    $invoiceurl = $billDir . "/" . $nom;
                }
                $modelBill = new SuBill();
                $modelBill->addBill($invoiceNumber, $unit_id, $responsible_id, date("Y-m-d", time()), $totalHT, $invoiceurl);
		
		// Save the xls file
                $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
                //echo "bill dir = " . $billDir . "<br/>";
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
        
        public function calculateBillNumber(){
            // calculate the number
		$modelBill = new SuBill();
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
                            $number = date("Y", time()) . "-001";
                        }
			$num = "".$lastNumberN."";
			$number = $lastNumberY ."-". $this->float2ZeroStr($num) ;
		}
		else{
			$number = date("Y", time()) . "-001";
		}
                return $number;
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
        
        public function generateZipFile($billDir){
            
            
            $zip = new ZipArchive();
            $fileUrl = "data/supplies/tmp.zip";
      
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