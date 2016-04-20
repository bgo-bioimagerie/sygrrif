<?php

require_once 'Framework/TableView.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/CoreBelonging.php';
require_once 'Modules/petshop/Model/PsSector.php';
require_once 'Modules/petshop/Model/PsTranslator.php';
require_once 'Modules/petshop/Model/PsProjectType.php';
require_once 'Modules/petshop/Model/PsType.php';
require_once 'Modules/petshop/Model/PsPricing.php';

class ControllerPssectors extends ControllerSecureNav {

    private $model;

    public function __construct() {
        parent::__construct();
        $this->model = new PsSector();
    }

    public function index() {
        $navBar = $this->navBar();
        $lang = $this->getLanguage();

        // get the user list
        $dataArray = $this->model->getallsectors();

        //print_r($dataArray);

        $table = new TableView();
        //$table->ignoreEntry("id", 1);
        $table->setTitle(PsTranslator::SectorAndPricing($lang));
        $table->addLineEditButton("pssectors/edit");
        $table->addDeleteButton("pssectors/delete");
        $table->addPrintButton("pssectors/index/");
        $tableHtml = $table->view($dataArray, array("id" => "ID", "name" => CoreTranslator::Name($lang)));

        if ($table->isPrint()) {
            echo $tableHtml;
            return;
        }

        $this->generateView(array(
            'navBar' => $navBar,
            'tableHtml' => $tableHtml
        ));
    }

    public function edit() {
        $navBar = $this->navBar();

        // get user id
        $secteurId = 0;
        if ($this->request->isParameterNotEmpty('actionid')) {
            $secteurId = $this->request->getParameter("actionid");
        }

        // get secteur info
        $secteur["id"] = 0;
        $secteur["name"] = "";
        if ($secteurId != 0) {
            $secteur = $this->model->getSector($secteurId);
        }

        // get info for pricing
        $modelBelonging = new CoreBelonging();
        $belongings = $modelBelonging->getAll();
        
        $modelType = new PsType();
        $antypes = $modelType->getAll("name");
        
        $this->generateView(array(
            'navBar' => $navBar,
            'secteur' => $secteur,
            'belongings' => $belongings,
            'antypes' => $antypes
        ));
    }

    public function editquery() {

        // get form variables
        $id_secteur = $this->request->getParameter("id");
        $name = $this->request->getParameter("name");

        //echo "id = " . $id_secteur . "<br/>";
        //echo "name = " . $name . "<br/>";
        // edit secteur
        if ($id_secteur > 0) {
            $this->model->editSector($id_secteur, $name);
        } else {
            $id_secteur = $this->model->addSector($name);
        }

        // edit prices
        // pricing
        $modelBelonging = new CoreBelonging();
        $belongings = $modelBelonging->getall();
        
        $modelType = new PsType();
        $antypes = $modelType->getAll();
        
        $modelPricing = new PsPricing();
        
        //$pricingTable = $this->modelsecteur->getPrices($id_secteur);
        foreach ($antypes as $type) {
            
            foreach($belongings as $belonging){
                $paramID = "p_" . $type["id"] . "_" . $belonging["id"];
                if ($this->request->isParameterNotEmpty($paramID)){
                    $price = $this->request->getParameter($paramID);
                    $modelPricing->setPricing($id_secteur, $belonging["id"], $type["id"], $price);
                }
            }
        }

        $this->redirect("pssectors");
    }

    /**
     * Remove an unit query to database
     */
    public function delete() {

        $id = $this->request->getParameter("actionid");
        $this->model->delete($id);

        // generate view
        $this->redirect("pssectors");
    }

}
