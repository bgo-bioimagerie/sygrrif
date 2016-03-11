<?php

require_once 'Framework/Controller.php';
require_once 'Framework/TableView.php';
require_once 'Framework/Form.php';

require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/CoreTranslator.php';
require_once 'Modules/core/Model/CoreUser.php';
require_once 'Modules/core/Model/CoreUnit.php';

require_once 'Modules/sprojects/Model/SpProject.php';
require_once 'Modules/sprojects/Model/SpTranslator.php';
require_once 'Modules/sprojects/Model/SpItem.php';
require_once 'Modules/sprojects/Model/SpBill.php';
require_once 'Modules/sprojects/Model/SpStats.php';

require_once 'externals/PHPExcel/Classes/PHPExcel.php';

class ControllerSprojectsbalancesheet extends ControllerSecureNav {

    // Affiche la liste de tous les billets du blog
    public function index() {

        $lang = $this->getLanguage();

        // build the form
        $form = new Form($this->request, "formbalancesheet");
        $form->setTitle(SpTranslator::Balance_sheet($lang));
        $form->addDate("begining_period", SpTranslator::Beginning_period($lang), true, "0000-00-00");
        $form->addDate("end_period", SpTranslator::End_period($lang), true, "0000-00-00");

        $form->setValidationButton("Ok", "sprojectsbalancesheet/index");

        $stats = "";
        if ($form->check()) {
            $this->generateBalance($form->getParameter("begining_period"), $form->getParameter("end_period"));
            return;
        }

        // set the view
        $formHtml = $form->getHtml();
        // view
        $navBar = $this->navBar();
        $this->generateView(array(
            'navBar' => $navBar,
            'formHtml' => $formHtml,
            'stats' => $stats
        ));
    }

    private function generateBalance($periodStart, $periodEnd) {

        //echo "not yet implemented <br/> " . $periodStart . "<br/>" . $periodEnd . "<br/>";
        // get all the opened projects informations
        $modelProjects = new SpProject();
        $openedProjects = $modelProjects->getProjectsOpenedPeriod($periodStart, $periodEnd);

        // get all the priced projects details
        $projectsBalance = $modelProjects->getBalances($periodStart, $periodEnd);

        // get the stats
        $modelStats = new SpStats();
        $stats = $modelStats->computeStats($periodStart, $periodEnd);

        // get the bill manager list
        $modelBillManager = new SpBill();
        $invoices = $modelBillManager->getBillsPeriod($periodStart, $periodEnd);


        $this->makeBalanceXlsFile($periodStart, $periodEnd, $openedProjects, $projectsBalance, $invoices, $stats);
    }

    private function makeBalanceXlsFile($periodStart, $periodEnd, $openedProjects, $projectsBalance, $invoices, $stats) {

        $modelUser = new CoreUser();
        $modelUnit = new CoreUnit();

        $lang = $this->getLanguage();
        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set properties
        $objPHPExcel->getProperties()->setCreator("Platform-Manager");
        $objPHPExcel->getProperties()->setLastModifiedBy("Platform-Manager");
        $objPHPExcel->getProperties()->setTitle("Project balance sheet");
        $objPHPExcel->getProperties()->setSubject("Project balance sheet");
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
		
        // ////////////////////////////////////////////////////
        //                  opened projects
        // ////////////////////////////////////////////////////
        $objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
        $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleBorderedCell);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($styleBorderedCell);
        $objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($styleBorderedCell);
        $objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($styleBorderedCell);
        $objPHPExcel->getActiveSheet()->getStyle('F1')->applyFromArray($styleBorderedCell);
        $objPHPExcel->getActiveSheet()->getStyle('H1')->applyFromArray($styleBorderedCell);
        $objPHPExcel->getActiveSheet()->getStyle('J1')->applyFromArray($styleBorderedCell);
        $objPHPExcel->getActiveSheet()->getStyle('K1')->applyFromArray($styleBorderedCell);
        
        
        
        $objPHPExcel->getActiveSheet()->setTitle(SpTranslator::OPENED($lang));
        $objPHPExcel->getActiveSheet()->SetCellValue('A2', CoreTranslator::Responsible($lang));
        $objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($styleBorderedCell);

        $objPHPExcel->getActiveSheet()->SetCellValue('B2', CoreTranslator::Unit($lang));
        $objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray($styleBorderedCell);

        $objPHPExcel->getActiveSheet()->SetCellValue('C2', CoreTranslator::User($lang));
        $objPHPExcel->getActiveSheet()->getStyle('C2')->applyFromArray($styleBorderedCell);

        $objPHPExcel->getActiveSheet()->SetCellValue('D2', SpTranslator::Project_number($lang));
        $objPHPExcel->getActiveSheet()->getStyle('D2')->applyFromArray($styleBorderedCell);


        $objPHPExcel->getActiveSheet()->mergeCells('E1:F1');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', SpTranslator::New_team($lang));
        $objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($styleBorderedCenteredCell);

        $objPHPExcel->getActiveSheet()->SetCellValue('E2', SpTranslator::Academique($lang));
        $objPHPExcel->getActiveSheet()->getStyle('E2')->applyFromArray($styleBorderedCell);

        $objPHPExcel->getActiveSheet()->SetCellValue('F2', SpTranslator::Industry($lang));
        $objPHPExcel->getActiveSheet()->getStyle('F2')->applyFromArray($styleBorderedCell);


        $objPHPExcel->getActiveSheet()->mergeCells('G1:H1');
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', SpTranslator::New_project($lang));
        $objPHPExcel->getActiveSheet()->getStyle('G1')->applyFromArray($styleBorderedCenteredCell);

        $objPHPExcel->getActiveSheet()->SetCellValue('G2', SpTranslator::Academique($lang));
        $objPHPExcel->getActiveSheet()->getStyle('G2')->applyFromArray($styleBorderedCell);

        $objPHPExcel->getActiveSheet()->SetCellValue('H2', SpTranslator::Industry($lang));
        $objPHPExcel->getActiveSheet()->getStyle('H2')->applyFromArray($styleBorderedCell);


        $objPHPExcel->getActiveSheet()->SetCellValue('I2', SpTranslator::Opened_date($lang));
        $objPHPExcel->getActiveSheet()->getStyle('I2')->applyFromArray($styleBorderedCell);
        
        $objPHPExcel->getActiveSheet()->SetCellValue('J2', SpTranslator::Time_limite($lang));
        $objPHPExcel->getActiveSheet()->getStyle('J2')->applyFromArray($styleBorderedCell);

        $objPHPExcel->getActiveSheet()->SetCellValue('K2', SpTranslator::Closed_date($lang));
        $objPHPExcel->getActiveSheet()->getStyle('K2')->applyFromArray($styleBorderedCell);

        $objPHPExcel->getActiveSheet()->mergeCells('I1:K1');
        $objPHPExcel->getActiveSheet()->getStyle('I1')->applyFromArray($styleBorderedCell);

        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);

        $curentLine = 2;
        foreach ($openedProjects as $proj) {
            // responsable, unité, utilisateur, no dossier, nouvelle equipe (accademique, PME), nouveau proj(ac, pme), delai (def, respecte), date cloture
            $curentLine++;
            $unitName = $modelUnit->getUnitName($modelUser->getUserUnit($proj["id_resp"]));

            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $curentLine, $modelUser->getUserFUllName($proj["id_resp"]));
            $objPHPExcel->getActiveSheet()->getStyle('A' . $curentLine)->applyFromArray($styleBorderedCell);

            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $curentLine, $unitName);
            $objPHPExcel->getActiveSheet()->getStyle('B' . $curentLine)->applyFromArray($styleBorderedCell);

            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $curentLine, $modelUser->getUserFUllName($proj["id_user"]));
            $objPHPExcel->getActiveSheet()->getStyle('C' . $curentLine)->applyFromArray($styleBorderedCell);

            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $curentLine, $proj["name"]);
            $objPHPExcel->getActiveSheet()->getStyle('D' . $curentLine)->applyFromArray($styleBorderedCell);

            if ($proj["new_team"] == 1) {
                $objPHPExcel->getActiveSheet()->SetCellValue('E' . $curentLine, 1);
            } else if ($proj["new_team"] == 2) {
                $objPHPExcel->getActiveSheet()->SetCellValue('F' . $curentLine, 1);
            }
            $objPHPExcel->getActiveSheet()->getStyle('E' . $curentLine)->applyFromArray($styleBorderedCenteredCell);
            $objPHPExcel->getActiveSheet()->getStyle('F' . $curentLine)->applyFromArray($styleBorderedCenteredCell);


            if ($proj["new_project"] == 1) {
                $objPHPExcel->getActiveSheet()->SetCellValue('G' . $curentLine, 1);
            } else if ($proj["new_project"] == 2) {
                $objPHPExcel->getActiveSheet()->SetCellValue('H' . $curentLine, 1);
            }
            $objPHPExcel->getActiveSheet()->getStyle('G' . $curentLine)->applyFromArray($styleBorderedCenteredCell);
            $objPHPExcel->getActiveSheet()->getStyle('H' . $curentLine)->applyFromArray($styleBorderedCenteredCell);

            $dateClosed = "";
            if ($proj["date_close"] != "0000-00-00"){
                $dateClosed = CoreTranslator::dateFromEn($proj["date_close"], $lang);
            }
            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $curentLine, CoreTranslator::dateFromEn($proj["date_open"], $lang));
            $objPHPExcel->getActiveSheet()->SetCellValue('J' . $curentLine, CoreTranslator::dateFromEn($proj["time_limit"], $lang));
            $objPHPExcel->getActiveSheet()->SetCellValue('K' . $curentLine, $dateClosed);
            $objPHPExcel->getActiveSheet()->getStyle('I' . $curentLine)->applyFromArray($styleBorderedCell);
            $objPHPExcel->getActiveSheet()->getStyle('J' . $curentLine)->applyFromArray($styleBorderedCell);
            $objPHPExcel->getActiveSheet()->getStyle('K' . $curentLine)->applyFromArray($styleBorderedCell);

        }
        
        for($col = 'A'; $col !== 'L'; $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }

        $objPHPExcel->getActiveSheet()->insertNewRowBefore(1, 1);
        $objPHPExcel->getActiveSheet()->mergeCells('A1:K1');
        $text = SpTranslator::BalanceSheetFrom($lang) . CoreTranslator::dateFromEn($periodStart, $lang)
                . SpTranslator::To($lang) . CoreTranslator::dateFromEn($periodEnd, $lang);
        $objPHPExcel->getActiveSheet()->setCellValue('A1', $text);
        
        // ////////////////////////////////////////////////////
        //                  closed projects details
        // ////////////////////////////////////////////////////
        $objWorkSheet = $objPHPExcel->createSheet();
        $objWorkSheet->setTitle(SpTranslator::Invoice_details($lang));
        $objPHPExcel->setActiveSheetIndex(1);
        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);


        $curentLine = 1;
        $objPHPExcel->getActiveSheet()->SetCellValue('A' . $curentLine, CoreTranslator::Unit($lang));
        $objPHPExcel->getActiveSheet()->SetCellValue('B' . $curentLine, CoreTranslator::User($lang));
        $objPHPExcel->getActiveSheet()->SetCellValue('C' . $curentLine, SpTranslator::Date_paid($lang));
        $objPHPExcel->getActiveSheet()->SetCellValue('D' . $curentLine, SpTranslator::No_Projet($lang));
        
        $objPHPExcel->getActiveSheet()->getStyle('A' . $curentLine)->applyFromArray($styleBorderedCell);
        $objPHPExcel->getActiveSheet()->getStyle('B' . $curentLine)->applyFromArray($styleBorderedCell);
        $objPHPExcel->getActiveSheet()->getStyle('C' . $curentLine)->applyFromArray($styleBorderedCell);
        $objPHPExcel->getActiveSheet()->getStyle('D' . $curentLine)->applyFromArray($styleBorderedCell);

        $itemIdx = 4;
        $items = $projectsBalance["items"];
        $modelItem = new SpItem();
        foreach ($items as $item) {
            $itemIdx++;
            $name = $modelItem->getItemName($item);
            $objPHPExcel->getActiveSheet()->SetCellValue($this->get_col_letter($itemIdx) . $curentLine, $name);
        }
        $itemIdx++;
        //$objPHPExcel->getActiveSheet()->SetCellValue($this->get_col_letter($itemIdx) . $curentLine, SpTranslator::TotalPrice($lang));

        $projects = $projectsBalance["projects"];
        foreach ($projects as $proj) {
            $curentLine++;
            $unitName = $modelUnit->getUnitName($modelUser->getUserUnit($proj["id_resp"]));
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $curentLine, $unitName);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $curentLine, $modelUser->getUserFUllName($proj["id_resp"]));
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $curentLine, $proj["date_close"]);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $curentLine, $proj["name"]);
            
            $objPHPExcel->getActiveSheet()->getStyle('A' . $curentLine)->applyFromArray($styleBorderedCell);
            $objPHPExcel->getActiveSheet()->getStyle('B' . $curentLine)->applyFromArray($styleBorderedCell);
            $objPHPExcel->getActiveSheet()->getStyle('C' . $curentLine)->applyFromArray($styleBorderedCell);
            $objPHPExcel->getActiveSheet()->getStyle('D' . $curentLine)->applyFromArray($styleBorderedCell);

            // "entries"

            $entries = $proj["entries"];

            foreach ($entries as $entry) {
                $pos = $this->findItemPos($items, $entry["id"]);
                if ($pos > 0 && $entry["pos"] > 0) {
                    //print_r($entry);
                    $objPHPExcel->getActiveSheet()->SetCellValue($this->get_col_letter($pos + 4) . $curentLine, $entry["sum"]);
                    $objPHPExcel->getActiveSheet()->getStyle($this->get_col_letter($pos + 4) . $curentLine)->applyFromArray($styleBorderedCell);
        
                }
            }
            //$objPHPExcel->getActiveSheet()->SetCellValue($this->get_col_letter($itemIdx) . $curentLine, $proj["total"]);
        }

        for($r=1 ; $r <= $curentLine ; $r++){
            for($c=1 ; $c <= $itemIdx ; $c++){
                $objPHPExcel->getActiveSheet()->getStyle($this->get_col_letter($c).$r)->applyFromArray($styleBorderedCell);
            }
        }
        for($col = 'A'; $col !== $this->get_col_letter($itemIdx+1); $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }
        
        $objPHPExcel->getActiveSheet()->insertNewRowBefore(1, 1);
        $objPHPExcel->getActiveSheet()->mergeCells('A1:K1');
        $text = SpTranslator::BalanceSheetFrom($lang) . CoreTranslator::dateFromEn($periodStart, $lang)
                . SpTranslator::To($lang) . CoreTranslator::dateFromEn($periodEnd, $lang);
        $objPHPExcel->getActiveSheet()->setCellValue('A1', $text);
        
        // ////////////////////////////////////////////////////
        //                  Bill list
        // ////////////////////////////////////////////////////
        $objWorkSheet = $objPHPExcel->createSheet();
        $objWorkSheet->setTitle(SpTranslator::invoices($lang));
        $objPHPExcel->setActiveSheetIndex(2);
        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);


        $curentLine = 1;
        $objPHPExcel->getActiveSheet()->SetCellValue('A' . $curentLine, CoreTranslator::Unit($lang));
        $objPHPExcel->getActiveSheet()->SetCellValue('B' . $curentLine, CoreTranslator::User($lang));
        $objPHPExcel->getActiveSheet()->SetCellValue('C' . $curentLine, SpTranslator::No_Projet($lang));
        $objPHPExcel->getActiveSheet()->SetCellValue('D' . $curentLine, SpTranslator::Total_HT($lang));

        $total = 0;
        foreach ($invoices as $invoice) {
            $curentLine++;

            $unitName = $modelUnit->getUnitName($modelUser->getUserUnit($invoice["id_resp"]));
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $curentLine, $unitName);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $curentLine, $modelUser->getUserFUllName($invoice["id_resp"]));
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $curentLine, $invoice["no_project"]);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $curentLine, $invoice["total_ht"]);
            $total += $invoice["total_ht"];
        }
        $curentLine++;
        $objPHPExcel->getActiveSheet()->mergeCells('A' . $curentLine . ':C' . $curentLine);
        $objPHPExcel->getActiveSheet()->SetCellValue('C' . $curentLine, SpTranslator::Total_HT($lang));
        $objPHPExcel->getActiveSheet()->SetCellValue('D' . $curentLine, $total);

        for($r=1 ; $r <= $curentLine ; $r++){
            for($c='A' ; $c !== 'E' ; $c++){
                $objPHPExcel->getActiveSheet()->getStyle($c.$r)->applyFromArray($styleBorderedCell);
            }
        }
        for($col = 'A'; $col !== 'E'; $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }
        
        $objPHPExcel->getActiveSheet()->insertNewRowBefore(1, 1);
        $objPHPExcel->getActiveSheet()->mergeCells('A1:K1');
        $text = SpTranslator::BalanceSheetFrom($lang) . CoreTranslator::dateFromEn($periodStart, $lang)
                . SpTranslator::To($lang) . CoreTranslator::dateFromEn($periodEnd, $lang);
        $objPHPExcel->getActiveSheet()->setCellValue('A1', $text);
        // ////////////////////////////////////////////////////
        //                  Stats
        // ////////////////////////////////////////////////////

        $objWorkSheet = $objPHPExcel->createSheet();
        $objWorkSheet->setTitle(SpTranslator::StatisticsMaj($lang));
        $objPHPExcel->setActiveSheetIndex(3);

        $curentLine = 1;
        $objPHPExcel->getActiveSheet()->SetCellValue('A' . $curentLine, SpTranslator::numberNewIndustryTeam($lang));
        $objPHPExcel->getActiveSheet()->SetCellValue('B' . $curentLine, $stats["numberNewIndustryTeam"] . " (" . $stats["purcentageNewIndustryTeam"] . "%)");
        $curentLine++;
        $objPHPExcel->getActiveSheet()->SetCellValue('A' . $curentLine, SpTranslator::numberIndustryProjects($lang));
        $objPHPExcel->getActiveSheet()->SetCellValue('B' . $curentLine, $stats["numberIndustryProjects"]);
        $curentLine++;
        $objPHPExcel->getActiveSheet()->SetCellValue('A' . $curentLine, SpTranslator::loyaltyIndustryProjects($lang));
        $objPHPExcel->getActiveSheet()->SetCellValue('B' . $curentLine, $stats["loyaltyIndustryProjects"] . " (" . $stats["purcentageloyaltyIndustryProjects"] . "%)");
        $curentLine++;
        $curentLine++;
        $objPHPExcel->getActiveSheet()->SetCellValue('A' . $curentLine, SpTranslator::numberNewAccademicTeam($lang));
        $objPHPExcel->getActiveSheet()->SetCellValue('B' . $curentLine, $stats["numberNewAccademicTeam"] . " (" . $stats["purcentageNewAccademicTeam"] . "%)");
        $curentLine++;
        $objPHPExcel->getActiveSheet()->SetCellValue('A' . $curentLine, SpTranslator::numberAccademicProjects($lang));
        $objPHPExcel->getActiveSheet()->SetCellValue('B' . $curentLine, $stats["numberAccademicProjects"]);
        $curentLine++;
        $objPHPExcel->getActiveSheet()->SetCellValue('A' . $curentLine, SpTranslator::loyaltyAccademicProjects($lang));
        $objPHPExcel->getActiveSheet()->SetCellValue('B' . $curentLine, $stats["loyaltyAccademicProjects"] . " (" . $stats["purcentageloyaltyAccademicProjects"] . "%)");
        $curentLine++;
        $curentLine++;
        $objPHPExcel->getActiveSheet()->SetCellValue('A' . $curentLine, SpTranslator::totalNumberOfProjects($lang));
        $objPHPExcel->getActiveSheet()->SetCellValue('B' . $curentLine, $stats["totalNumberOfProjects"]);

        for($r=1 ; $r <= $curentLine ; $r++){
            for($c='A' ; $c !== 'C' ; $c++){
                $objPHPExcel->getActiveSheet()->getStyle($c.$r)->applyFromArray($styleBorderedCell);
            }
        }
        for($col = 'A'; $col !== 'C'; $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }
        
        $objPHPExcel->getActiveSheet()->insertNewRowBefore(1, 1);
        $objPHPExcel->getActiveSheet()->mergeCells('A1:K1');
        $text = SpTranslator::BalanceSheetFrom($lang) . CoreTranslator::dateFromEn($periodStart, $lang)
                . SpTranslator::To($lang) . CoreTranslator::dateFromEn($periodEnd, $lang);
        $objPHPExcel->getActiveSheet()->setCellValue('A1', $text);

        // write excel file
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);

        //On enregistre les modifications et on met en téléchargement le fichier Excel obtenu
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="platorm-manager-projet-bilan.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
    }

    private function findItemPos($items, $id) {
        $c = 0;
        foreach ($items as $item) {
            $c++;
            if ($item == $id) {
                return $c;
            }
        }
        return 0;
    }

    function get_col_letter($num) {
        $comp = 0;
        $letters = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');

        //if the number is greater than 26, calculate to get the next letters
        if ($num > 26) {
            //divide the number by 26 and get rid of the decimal
            $comp = floor($num / 26);

            //add the letter to the end of the result and return it
            if ($comp != 0) {
                // don't subtract 1 if the comparative variable is greater than 0
                return $this->get_col_letter($comp) . $letters[($num - $comp * 26)];
            } else {
                return $this->get_col_letter($comp) . $letters[($num - $comp * 26) - 1];
            }
        } else {
            //return the letter
            return $letters[($num - 1)];
        }
    }

}
