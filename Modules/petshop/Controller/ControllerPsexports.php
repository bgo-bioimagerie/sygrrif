<?php

require_once 'Framework/Form.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/CoreTranslator.php';
require_once 'Modules/petshop/Model/PsTranslator.php';
require_once 'Modules/petshop/Model/PsProjectType.php';
require_once 'Modules/petshop/Model/PsExport.php';

class ControllerPsexports extends ControllerSecureNav {


    public function __construct() {
        parent::__construct();
    }
    
    public function index(){
        
    }

    public function listing() {
        $lang = $this->getLanguage();

        // form
        // build the form
        $form = new Form($this->request, "psexports/listing");
        $form->setTitle(PsTranslator::Listing($lang));
        $form->addDate("beginPeriod", PsTranslator::BeginingPeriod($lang), true);
        $form->addDate("endPeriod", PsTranslator::EndPeriod($lang), true);

        $form->setValidationButton(CoreTranslator::Export($lang), "psexports/listing");

        if ($form->check()) {
            // run the database query
            $modelExport = new PsExport($lang);
            $beginPeriod = CoreTranslator::dateFromEn($form->getParameter("beginPeriod"), $lang);
            $endPeriod = CoreTranslator::dateFromEn($form->getParameter("endPeriod"), $lang);
            $modelExport->exportListing($beginPeriod, $endPeriod, $lang);
            
        } else {
            // set the view
            $formHtml = $form->getHtml($lang);
            // view
            $navBar = $this->navBar();
            $this->generateView(array(
                'navBar' => $navBar,
                'formHtml' => $formHtml
            ));
        }
    }
    
    public function invoice(){
        $lang = $this->getLanguage();

        // form
        $modelResp = new CoreResponsible();
        $users = $modelResp->responsibleSummaries("name");
        foreach ($users as $user) {
            $choiceUserID[] = $user["id"];
            $choiceUser[] = $user["name"] . " " . $user["firstname"];
        }
        
        // build the form
        $form = new Form($this->request, "psexports/invoice");
        $form->setTitle(PsTranslator::Invoicing($lang));
        $form->addDate("beginPeriod", PsTranslator::BeginingPeriod($lang), true);
        $form->addDate("endPeriod", PsTranslator::EndPeriod($lang), true);
        $form->addSelect("responsible", CoreTranslator::Responsible($lang), $choiceUser, $choiceUserID);

        $form->setValidationButton(CoreTranslator::Ok($lang), "psexports/invoice");

        if ($form->check()) {
            // run the database query
            $modelExport = new PsExport($lang);
            $beginPeriod = CoreTranslator::dateToEn($form->getParameter("beginPeriod"), $lang);
            $endPeriod = CoreTranslator::dateToEn($form->getParameter("endPeriod"), $lang);
            $responsible = $form->getParameter("responsible");
            $modelExport->invoiceResponsible($beginPeriod, $endPeriod, $responsible, $lang);
            
            
        } else {
            // set the view
            $formHtml = $form->getHtml($lang);
            // view
            $navBar = $this->navBar();
            $this->generateView(array(
                'navBar' => $navBar,
                'formHtml' => $formHtml
            ));
        }
    }
    
    public function invoiceall(){
        $lang = $this->getLanguage();

        // form
        // build the form
        $form = new Form($this->request, "psexports/invoiceall");
        $form->setTitle(PsTranslator::InvoicingAll($lang));
        $form->addDate("beginPeriod", PsTranslator::BeginingPeriod($lang), true);
        $form->addDate("endPeriod", PsTranslator::EndPeriod($lang), true);
        
        $form->setValidationButton(CoreTranslator::Ok($lang), "psexports/invoiceall");

        if ($form->check()) {
            // run the database query
            $modelExport = new PsExport($lang);
            $beginPeriod = CoreTranslator::dateToEn($form->getParameter("beginPeriod"), $lang);
            $endPeriod = CoreTranslator::dateToEn($form->getParameter("endPeriod"), $lang);
            $modelExport->invoiceall($beginPeriod, $endPeriod, $lang);
            
        } else {
            // set the view
            $formHtml = $form->getHtml($lang);
            // view
            $navBar = $this->navBar();
            $this->generateView(array(
                'navBar' => $navBar,
                'formHtml' => $formHtml
            ));
        }
    }

}
