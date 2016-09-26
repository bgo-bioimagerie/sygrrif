<?php

require_once 'Framework/Controller.php';
require_once 'Framework/Form.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/supplies/Model/SuBillGenerator.php';
require_once 'Modules/core/Model/CoreUnit.php';
require_once 'Modules/core/Model/CoreUser.php';

class ControllerSuppliesbill extends ControllerSecureNav {

    // Affiche la liste de tous les billets du blog
    public function index() {

        $unit_id = $this->request->getParameterNoException('unit');
        $responsible_id = $this->request->getParameterNoException('responsible');

        // get the selected unit
        $selectedUnitId = 0;
        if ($unit_id != "" && $unit_id > 1) {
            $selectedUnitId = $unit_id;
        }

        $modelConfig = new CoreConfig();
        $supliesusersdatabase = $modelConfig->getParam("supliesusersdatabase");

        // get the responsibles for this unit
        $responsiblesList = array();
        if ($selectedUnitId > 0) {

            $responsiblesList = array();
            if ($supliesusersdatabase == "local") {
                $modeluser = new SuUser();
                $responsiblesList = $modeluser->getResponsibleOfUnit($selectedUnitId);
            } else {
                $modeluser = new CoreUser();
                $responsiblesList = $modeluser->getResponsibleOfUnit($selectedUnitId);
            }
        }

        if ($selectedUnitId != 0 && $responsible_id > 1) {

            // if the form is correct, calculate the output
            $this->billOutput($selectedUnitId, $responsible_id);
            return;
        }

        // get units list
        $unitsList = array();
        if ($supliesusersdatabase == "local") {
            $modelUnit = new SuUnit();
            $unitsList = $modelUnit->unitsIDName();
        } else {
            $modelUnit = new CoreUnit();
            $unitsList = $modelUnit->unitsIDName();
        }

        $errorMessage = "";

        $navBar = $this->navBar();
        $this->generateView(array(
            'navBar' => $navBar,
            'unitsList' => $unitsList,
            'responsiblesList' => $responsiblesList,
            'errorMessage' => $errorMessage,
            'selectedUnitId' => $selectedUnitId
        ));
    }

    protected function billOutput($responsible_id) {
        $lang = $this->getLanguage();
        $billgenaratorModel = new SuBillGenerator();
        $billgenaratorModel->invoiceResponsible($responsible_id, $lang);
    }

    public function billall() {

        $lang = $this->getLanguage();

        // view
        $navBar = $this->navBar();
        $this->generateView(array(
            'navBar' => $navBar,
            'lang' => $lang
        ));
    }

    public function billallquery() {

        $lang = $this->getLanguage();
        // get all the units and responsible with an opened 
        $modelBill = new SuBillGenerator();
        $modelBill->billAll($lang);
    }

}
