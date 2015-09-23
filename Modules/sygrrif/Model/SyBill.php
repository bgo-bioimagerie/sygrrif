<?php

require_once 'Framework/Model.php';
require_once 'Modules/core/Model/Unit.php';
require_once 'Modules/core/Model/User.php';

/**
 * Class defining the Bill model. It is used to store the history 
 * of the generated bills
 *
 * @author Sylvain Prigent
 */
class SyBill extends Model {

	/**
	 * Create the table
	 * @return PDOStatement
	 */
	public function createTable(){
		$sql = "CREATE TABLE IF NOT EXISTS `sy_bills` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
	    `number` varchar(50) NOT NULL,		
		`period_begin` DATE NOT NULL,		
		`period_end` DATE NOT NULL,
		`date_generated` DATE NOT NULL,	
		`date_paid` DATE NOT NULL,			
		`is_paid` int(1) NOT NULL,
		`id_unit` int(11) NOT NULL,
		`id_responsible` int(11) NOT NULL,
		`total_ht` float(11) NOT NULL,		
		`id_project` int(11) NOT NULL,						
		PRIMARY KEY (`id`)
		);";

		$pdo = $this->runRequest($sql);
		
		$sql = "SHOW COLUMNS FROM `sy_bills` LIKE 'total_ht'";
		$pdo = $this->runRequest($sql);
		$isColumn = $pdo->fetch();
		if ( $isColumn == false){
			$sql = "ALTER TABLE `sy_bills` ADD `total_ht` float(11) NOT NULL";
			$pdo = $this->runRequest($sql);
		}
	}
	
	/**
	 * add an bill to the table
	 *
	 * @param string $name name of the unit
	 */
	public function addBill($number, $date_generated, $date_paid="", $is_paid=0){
	
		$sql = "insert into sy_bills(number, date_generated, date_paid, is_paid)"
				. " values(?, ?, ?, ?)";
		$this->runRequest($sql, array($number, $date_generated, $date_paid, $is_paid));
		return $this->getDatabase()->lastInsertId();
	}
	
	/**
	 * Add bill associated to a unit
	 * @param number $number
	 * @param date $period_begin
	 * @param date $period_end
	 * @param date $date_generated
	 * @param number $id_unit
	 * @param number $id_responsible
	 * @param number $totalHT
	 * @param string $date_paid
	 * @param number $is_paid
	 * @return number Last inserted ID
	 */
	public function addBillUnit($number, $period_begin, $period_end, $date_generated, $id_unit, $id_responsible, $totalHT, $date_paid="", $is_paid=0){
		$sql = "insert into sy_bills(number, period_begin, period_end, date_generated, id_unit, id_responsible, total_ht, date_paid, is_paid)"
				. " values(?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$this->runRequest($sql, array($number, $period_begin, $period_end, $date_generated, $id_unit, $id_responsible, $totalHT, $date_paid, $is_paid));
		return $this->getDatabase()->lastInsertId();
	}
	
	/**
	 * Add bill associated to a project
	 * @param number $number
	 * @param date $period_begin
	 * @param date $period_end
	 * @param date $date_generated
	 * @param number $id_unit
	 * @param number $id_responsible
	 * @param number $totalHT
	 * @param string $date_paid
	 * @param number $is_paid
	 * @return number Last inserted ID
	 */
	public function addBillProject($number, $period_begin, $period_end, $date_generated, $id_project, $date_paid="", $is_paid=0){
		$sql = "insert into sy_bills(number, period_begin, period_end, date_generated, id_project, date_paid, is_paid)"
				. " values(?, ?, ?, ?, ?, ?, ?)";
		$this->runRequest($sql, array($number, $period_begin, $period_end, $date_generated, $id_project, $date_paid, $is_paid));
		return $this->getDatabase()->lastInsertId();
	}
	
	/**
	 * Set the status of a bill 
	 * @param number $id ID of the bill
	 * @param number $is_paid Paid status
	 */
	public function setPaid($id, $is_paid){
		$sql = "update sy_bills set is_paid=? where id=?";
		$unit = $this->runRequest($sql, array($is_paid, $id));
	}
	
	/**
	 * get bills informations
	 *
	 * @param string $sortentry Entry that is used to sort the units
	 * @return multitype: array
	 */
	public function getBills($sortentry = 'id'){
			
		$sql = "select * from sy_bills order by " . $sortentry . " ASC;";
		$user = $this->runRequest($sql);
		return $user->fetchAll();
	}
	
	/**
	 * get bills informations when bill is for a unit
	 * @param string $sortentry
	 * @return multitype:
	 */
	public function getBillsUnit($sortentry = 'id'){
		$sqlSort = "sy_bills.id";
		if ($sortentry == "number"){
			$sqlSort = "sy_bills.number";
		}
		else if ($sortentry == "date_generated"){
			$sqlSort = "sy_bills.date_generated";
		}
		else if ($sortentry == "date_paid"){
			$sqlSort = "sy_bills.date_paid";
		}
		else if ($sortentry == "is_paid"){
			$sqlSort = "sy_bills.is_paid";
		}
		else if ($sortentry == "unit"){
			$sqlSort = "core_units.name";
		}
		else if ($sortentry == "responsible"){
			$sqlSort = "core_users.name";
		}
		else if ($sortentry == "total_ht"){
			$sqlSort = "sy_bills.total_ht";
		}
		
		
		$sql = "SELECT sy_bills.id AS id, sy_bills.number AS number,
				       sy_bills.period_begin AS period_begin, 
					   sy_bills.period_end AS period_end, 
					   sy_bills.date_generated AS date_generated, 
					   sy_bills.date_paid AS date_paid, 
					   sy_bills.is_paid AS is_paid,
					   sy_bills.total_ht AS total_ht, 
					   core_units.name AS unit,
					   core_users.name AS resp_name,
					   core_users.firstname AS resp_firstname
				FROM sy_bills
				INNER JOIN core_units ON sy_bills.id_unit = core_units.id
				INNER JOIN core_users ON sy_bills.id_responsible = core_users.id	
				ORDER BY ". $sqlSort . ";";	
				
		/*
		$sql = "SELECT sy_resources.id AS id, sy_resources.name AS name, sy_resources.description AS description,
				       sy_resource_type.name AS type_name, sy_resourcescategory.name AS category_name, sy_areas.name AS area_name,
				       sy_resource_type.controller AS controller, sy_resource_type.edit_action AS edit_action
					from sy_resources
					     INNER JOIN sy_resource_type on sy_resources.type_id = sy_resource_type.id
					     INNER JOIN sy_resourcescategory on sy_resources.category_id = sy_resourcescategory.id
						 INNER JOIN sy_areas on sy_resources.area_id = sy_areas.id
					ORDER BY ". $sqlSort . ";";
					*/
		$req = $this->runRequest ( $sql );
		return $req->fetchAll ();
	}
	
	/**
	 * get the informations of an item
	 *
	 * @param int $id Id of the item to query
	 * @throws Exception id the item is not found
	 * @return mixed array
	 */
	public function getBill($id){
		$sql = "select * from sy_bills where id=?";
		$unit = $this->runRequest($sql, array($id));
		if ($unit->rowCount() == 1)
			return $unit->fetch();  // get the first line of the result
		else
			throw new Exception("Cannot find the item using the given id");
	}
	
	
	/**
	 * update the information of an item
	 *
	 * @param int $id Id of the item to update
	 * @param string $name New name of the item
	 */
	public function editBills($id, $number, $date_generated, $total_ht, $date_paid, $is_paid){
	
		$sql = "update sy_bills set number=?, date_generated=?, total_ht=?, date_paid=?, is_paid=?  where id=?";
		$unit = $this->runRequest($sql, array($number, $date_generated, $total_ht, $date_paid, $is_paid, $id));
	}

	/**
	 * Edit the informations of a bill associated to a unit
	 * @param number $id Bill ID
	 * @param number $number
	 * @param date $date_generated 
	 * @param number $id_unit
	 * @param number $id_responsible
	 * @param date $date_paid
	 * @param number $is_paid
	 */
	public function editBillUnit($id, $number, $date_generated, $id_unit, $id_responsible, $date_paid, $is_paid){
	
		$sql = "update sy_bills set number=?, date_generated=?, id_unit=?, id_responsible=?, date_paid=?, is_paid=?  where id=?";
		$unit = $this->runRequest($sql, array($number, $date_generated, $id_unit, $id_responsible, $date_paid, $is_paid, $id));
	}
	
	/**
	 * Edit the informations of a bill associated to a project
	 * @param number $id
	 * @param number $number
	 * @param date $date_generated
	 * @param number $id_project
	 * @param date $date_paid
	 * @param number $is_paid
	 */
	public function editBillProject($id, $number, $date_generated, $id_project, $date_paid, $is_paid){
	
		$sql = "update sy_bills set number=?, date_generated=?, id_project=?, date_paid=?, is_paid=?  where id=?";
		$unit = $this->runRequest($sql, array($number, $date_generated, $id_project, $date_paid, $is_paid, $id));
	}
	
	/**
	 * Remove a bill from the table
	 * @param number $id ID of the bill
	 */
	public function removeEntry($id){
		$sql="DELETE FROM sy_bills WHERE id = ?";
		$req = $this->runRequest($sql, array($id));
	}
	
	/**
	 * Export the bill list to a file.
	 * Only the bill generated between $searchDate_start and $searchDate_end are exported
	 * @param date $searchDate_start
	 * @param date $searchDate_end
	 */
	public function export($searchDate_start, $searchDate_end){
		// select 
		
		header_remove();
		$lang = "En";
		if (isset( $_SESSION["user_settings"]["language"])){
			$lang = $_SESSION["user_settings"]["language"];
		}
		
		$start_date_unix = $searchDate_start;
		$end_date_unix = $searchDate_end;

		$sql = "select * from sy_bills where period_begin >= ? AND period_end <= ?";
		//echo "sql = " . $sql . "</br>";
		$req = $this->runRequest($sql, array($start_date_unix, $end_date_unix));
		$res = $req->fetchAll();
		
		//print_r($res);
		//return;
		
		// write to xls file
		include_once ("externals/PHPExcel/Classes/PHPExcel.php");
		include_once ("externals/PHPExcel/Classes/PHPExcel/Writer/Excel5.php");
		include_once ("externals/PHPExcel/Classes/PHPExcel/Writer/Excel2007.php");
		
		// header
		$today=date('d/m/Y');
		$header = "Date d'édition de ce document : \n".$today;
		$titre = "Liste des factures émise comprises dans la periode du : ". CoreTranslator::dateFromEn($searchDate_start, $lang) . " au " . CoreTranslator::dateFromEn($searchDate_end, $lang);
		$avertissement = "";
		$reservation = "";
		
		// file name
		$nom = date('Y-m-d-H-i')."_liste_factures.xlsx";
		$teamName = Configuration::get("name");
		$footer = $teamName."/exportFiles/".$nom;
		
		// Création de l'objet
		$objPHPExcel = new PHPExcel();
		
		// Définition de quelques propriétés
		$objPHPExcel->getProperties()->setCreator($teamName);
		$objPHPExcel->getProperties()->setLastModifiedBy($teamName);
		$objPHPExcel->getProperties()->setTitle("Liste factures");
		$objPHPExcel->getProperties()->setSubject("periode du : ". CoreTranslator::dateFromEn($searchDate_start, $lang)  . " au " . CoreTranslator::dateFromEn($searchDate_end, $lang) );
		$objPHPExcel->getProperties()->setDescription("Fichier genere avec PHPExel depuis la base de donnees");
		
		$center=array('alignment'=>array('horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'=>PHPExcel_Style_Alignment::VERTICAL_CENTER));
		$gras=array('font' => array('bold' => true));
		$border=array(
				'borders'=>array(
						'top'=>array(
								'style'=>PHPExcel_Style_Border::BORDER_THIN),
						'left'=>array(
								'style'=>PHPExcel_Style_Border::BORDER_THIN),
						'right'=>array(
								'style'=>PHPExcel_Style_Border::BORDER_THIN),
						'bottom'=>array(
								'style'=>PHPExcel_Style_Border::BORDER_THIN)));
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
		
		$borderG=array(
				'borders'=>array(
						'top'=>array(
								'style'=>PHPExcel_Style_Border::BORDER_MEDIUM),
						'left'=>array(
								'style'=>PHPExcel_Style_Border::BORDER_MEDIUM),
						'right'=>array(
								'style'=>PHPExcel_Style_Border::BORDER_MEDIUM),
						'bottom'=>array(
								'style'=>PHPExcel_Style_Border::BORDER_MEDIUM)));
		
		$borderLRB=array(
				'borders'=>array(
						'top'=>array(
								'style'=>PHPExcel_Style_Border::BORDER_NONE),
						'left'=>array(
								'style'=>PHPExcel_Style_Border::BORDER_THIN),
						'right'=>array(
								'style'=>PHPExcel_Style_Border::BORDER_THIN),
						'bottom'=>array(
								'style'=>PHPExcel_Style_Border::BORDER_THIN)));
		
		$style = array(
				'font'  => array(
						'bold'  => false,
						'color' => array('rgb' => '000000'),
						'size'  => 15,
						'name'  => 'Calibri'
				));
		
		$style2 = array(
				'font'  => array(
						'bold'  => false,
						'color' => array('rgb' => '000000'),
						'size'  => 10,
						'name'  => 'Calibri'
				));
		
		// Nommage de la feuille
		$objPHPExcel->setActiveSheetIndex(0);
		$sheet=$objPHPExcel->getActiveSheet();
		$sheet->setTitle('Liste factures');
		
		// Mise en page de la feuille
		$sheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
		$sheet->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
		$sheet->setBreak( 'A55' , PHPExcel_Worksheet::BREAK_ROW );
		$sheet->setBreak( 'E55' , PHPExcel_Worksheet::BREAK_COLUMN );
		$sheet->setBreak( 'A110' , PHPExcel_Worksheet::BREAK_ROW );
		$sheet->setBreak( 'E110' , PHPExcel_Worksheet::BREAK_COLUMN );
		$sheet->setBreak( 'A165' , PHPExcel_Worksheet::BREAK_ROW );
		$sheet->setBreak( 'E165' , PHPExcel_Worksheet::BREAK_COLUMN );
		$sheet->setBreak( 'A220' , PHPExcel_Worksheet::BREAK_ROW );
		$sheet->setBreak( 'E220' , PHPExcel_Worksheet::BREAK_COLUMN );
		//$sheet->getPageSetup()->setFitToWidth(1);
		//$sheet->getPageSetup()->setFitToHeight(10);
		$sheet->getPageMargins()->SetTop(0.9);
		$sheet->getPageMargins()->SetBottom(0.5);
		$sheet->getPageMargins()->SetLeft(0.2);
		$sheet->getPageMargins()->SetRight(0.2);
		$sheet->getPageMargins()->SetHeader(0.2);
		$sheet->getPageMargins()->SetFooter(0.2);
		$sheet->getPageSetup()->setHorizontalCentered(true);
		//$sheet->getPageSetup()->setVerticalCentered(false);
		
		$sheet->getColumnDimension('A')->setWidth(16);
		$sheet->getColumnDimension('B')->setWidth(16);
		$sheet->getColumnDimension('C')->setWidth(16);
		$sheet->getColumnDimension('D')->setWidth(30);
		$sheet->getColumnDimension('E')->setWidth(30);
		$sheet->getColumnDimension('F')->setWidth(16);
		$sheet->getColumnDimension('G')->setWidth(16);
		$sheet->getColumnDimension('H')->setWidth(16);
		
		// Header
		$objDrawing = new PHPExcel_Worksheet_HeaderFooterDrawing();
		$objDrawing->setName('PHPExcel logo');
		$objDrawing->setPath('./Themes/logo.jpg');
		$objDrawing->setHeight(60);
		$objPHPExcel->getActiveSheet()->getHeaderFooter()->addImage($objDrawing, PHPExcel_Worksheet_HeaderFooter::IMAGE_HEADER_LEFT);
		$sheet->getHeaderFooter()->setOddHeader('&L&G&R'.$header);
		
		// Titre
		$ligne=1;
		$colonne='A';
		$sheet->getRowDimension($ligne)->setRowHeight(30);
		$sheet->SetCellValue($colonne.$ligne, $titre);
		$sheet->getStyle($colonne.$ligne)->applyFromArray($style);
		$sheet->getStyle($colonne.$ligne)->applyFromArray($gras);
		$sheet->getStyle($colonne.$ligne)->applyFromArray($center);
		$sheet->getStyle($colonne.$ligne)->getAlignment()->setWrapText(true);
		$sheet->mergeCells($colonne.$ligne.':H'.$ligne);
		
		$ligne=2;
		$sheet->SetCellValue('A'.$ligne,"Numéro");
		$sheet->getStyle('A'.$ligne)->applyFromArray($border);
		$sheet->getStyle('A'.$ligne)->applyFromArray($center);
		$sheet->getStyle('A'.$ligne)->applyFromArray($gras);
		$sheet->SetCellValue('B'.$ligne,"Responsable");
		$sheet->getStyle('B'.$ligne)->applyFromArray($border);
		$sheet->getStyle('B'.$ligne)->applyFromArray($center);
		$sheet->getStyle('B'.$ligne)->applyFromArray($gras);
		$sheet->SetCellValue('C'.$ligne,"Unité");
		$sheet->getStyle('C'.$ligne)->applyFromArray($border);
		$sheet->getStyle('C'.$ligne)->applyFromArray($center);
		$sheet->getStyle('C'.$ligne)->applyFromArray($gras);
		$sheet->SetCellValue('D'.$ligne,"Début période");
		$sheet->getStyle('D'.$ligne)->applyFromArray($border);
		$sheet->getStyle('D'.$ligne)->applyFromArray($center);
		$sheet->getStyle('D'.$ligne)->applyFromArray($gras);
		$sheet->SetCellValue('E'.$ligne,"Fin période");
		$sheet->getStyle('E'.$ligne)->applyFromArray($border);
		$sheet->getStyle('E'.$ligne)->applyFromArray($center);
		$sheet->getStyle('E'.$ligne)->applyFromArray($gras);
		$sheet->SetCellValue('F'.$ligne,"Date d'émission");
		$sheet->getStyle('F'.$ligne)->applyFromArray($border);
		$sheet->getStyle('F'.$ligne)->applyFromArray($center);
		$sheet->getStyle('F'.$ligne)->applyFromArray($gras);
		$sheet->SetCellValue('G'.$ligne,"Date règlement");
		$sheet->getStyle('G'.$ligne)->applyFromArray($border);
		$sheet->getStyle('G'.$ligne)->applyFromArray($center);
		$sheet->getStyle('G'.$ligne)->applyFromArray($gras);
		$sheet->SetCellValue('H'.$ligne,"Est réglée");
		$sheet->getStyle('H'.$ligne)->applyFromArray($border);
		$sheet->getStyle('H'.$ligne)->applyFromArray($center);
		$sheet->getStyle('H'.$ligne)->applyFromArray($gras);
		
		$ligne=3;
		$modelUser = new User();
		$modelUnit = new Unit();
		foreach($res as $r){
			$colonne='A';
			$sheet->getRowDimension($ligne)->setRowHeight(13);
			
			$sheet->SetCellValue($colonne.$ligne, $r["number"] ); // number
			$sheet->getStyle($colonne.$ligne)->applyFromArray($style2);
			$sheet->getStyle($colonne.$ligne)->applyFromArray($center);
			$sheet->getStyle($colonne.$ligne)->applyFromArray($borderLR);
			$colonne++;
			
			$ufn = $modelUser->getUserFUllName($r["id_responsible"]);
			$sheet->SetCellValue($colonne.$ligne, $ufn); // resp
			$sheet->getStyle($colonne.$ligne)->applyFromArray($style2);
			$sheet->getStyle($colonne.$ligne)->applyFromArray($center);
			$sheet->getStyle($colonne.$ligne)->applyFromArray($borderLR);
			$colonne++;
			
			$un = $modelUnit->getUnitName($r["id_unit"]);
			$sheet->SetCellValue($colonne.$ligne, $un ); // unit
			$sheet->getStyle($colonne.$ligne)->applyFromArray($style2);
			$sheet->getStyle($colonne.$ligne)->applyFromArray($center);
			$sheet->getStyle($colonne.$ligne)->applyFromArray($borderLR);
			$colonne++;
			
			$sheet->SetCellValue($colonne.$ligne, CoreTranslator::dateFromEn($r["period_begin"], $lang) ); // period_begin
			$sheet->getStyle($colonne.$ligne)->applyFromArray($style2);
			$sheet->getStyle($colonne.$ligne)->applyFromArray($center);
			$sheet->getStyle($colonne.$ligne)->applyFromArray($borderLR);
			$colonne++;
			
			$sheet->SetCellValue($colonne.$ligne, CoreTranslator::dateFromEn($r["period_end"], $lang) ); // period_end
			$sheet->getStyle($colonne.$ligne)->applyFromArray($style2);
			$sheet->getStyle($colonne.$ligne)->applyFromArray($center);
			$sheet->getStyle($colonne.$ligne)->applyFromArray($borderLR);
			$colonne++;
			
			$sheet->SetCellValue($colonne.$ligne, CoreTranslator::dateFromEn($r["date_generated"], $lang) ); // date_generated
			$sheet->getStyle($colonne.$ligne)->applyFromArray($style2);
			$sheet->getStyle($colonne.$ligne)->applyFromArray($center);
			$sheet->getStyle($colonne.$ligne)->applyFromArray($borderLR);
			$colonne++;
			
			$sheet->SetCellValue($colonne.$ligne, CoreTranslator::dateFromEn($r["date_paid"], $lang) ); // date_paid
			$sheet->getStyle($colonne.$ligne)->applyFromArray($style2);
			$sheet->getStyle($colonne.$ligne)->applyFromArray($center);
			$sheet->getStyle($colonne.$ligne)->applyFromArray($borderLR);
			$colonne++;
			
			$isPaid = "Non";
			if ($r["is_paid"]){
				$isPaid = "Oui";
			}
			$sheet->SetCellValue($colonne.$ligne, $isPaid ); // is_paid
			$sheet->getStyle($colonne.$ligne)->applyFromArray($style2);
			$sheet->getStyle($colonne.$ligne)->applyFromArray($center);
			$sheet->getStyle($colonne.$ligne)->applyFromArray($borderLR);
			$colonne++;
			
			$ligne++;
		}
		
		$writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		
		$writer->save('./data/'.$nom);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$nom.'"');
		header('Cache-Control: max-age=0');
		
		$writer->save('php://output');
	}
}