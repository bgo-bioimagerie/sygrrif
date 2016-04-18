<?php

require_once 'Framework/TableView.php';
require_once 'Framework/Form.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/CoreStatus.php';
require_once 'Modules/petshop/Model/PsProjectType.php';
require_once 'Modules/petshop/Model/PsTranslator.php';

class ControllerPsprojecttypes extends ControllerSecureNav {

    /**
     * User model object
     */
    private $model;

    /**
     * Constructor
     */
    public function __construct() {
        Parent::__construct();
        $this->model = new PsProjectType();
    }

    /**
     * (non-PHPdoc)
     * @see Controller::index()
     */
    public function index() {
        $navBar = $this->navBar();

        $lang = $this->getLanguage();

        // get sort action
        $sortentry = "id";
        if ($this->request->isParameterNotEmpty('actionid')) {
            $sortentry = $this->request->getParameter("actionid");
        }

        // get the user list
        $unitsArray = $this->model->getAll($sortentry);
        $modelStatus = new CoreStatus();
        for ($i = 0; $i < count($unitsArray); $i++) {
            $unitsArray[$i]["who_can_see"] = $modelStatus->getStatusName($unitsArray[$i]["who_can_see"]);
            $unitsArray[$i]["who_can_see"] = CoreTranslator::Translate_status($lang, $unitsArray[$i]["who_can_see"] [0]);
        }

        $table = new TableView();
        //$table->ignoreEntry("id", 1);
        $table->setTitle(PsTranslator::ProjectsTypes($lang));
        $table->addLineEditButton("psprojecttypes/edit");
        $table->addDeleteButton("psprojecttypes/delete");
        $table->addPrintButton("psprojecttypes/index/");
        $tableHtml = $table->view($unitsArray, array("id" => "ID", "name" => CoreTranslator::Name($lang),
            "who_can_see" => PsTranslator::who_can_see($lang)));

        if ($table->isPrint()) {
            echo $tableHtml;
            return;
        }

        $this->generateView(array(
            'navBar' => $navBar,
            'tableHtml' => $tableHtml
        ));
    }

    /**
     * Edit an unit form
     */
    public function edit() {
        $navBar = $this->navBar();

        // get user id
        $unitId = 0;
        if ($this->request->isParameterNotEmpty('actionid')) {
            $unitId = $this->request->getParameter("actionid");
        }

        // get belonging info
        $unit = array("id" => 0, "name" => "", "who_can_see" => 1);
        if ($unitId > 0) {
            $unit = $this->model->get($unitId);
        }

        // lang
        $lang = $this->getLanguage();

        // form
        // build the form
        $form = new Form($this->request, "psprojecttypes/edit");
        $form->setTitle(PsTranslator::Edit_Project_Type($lang));
        $form->addHidden("id", $unit["id"]);
        $form->addText("name", CoreTranslator::Name($lang), true, $unit["name"]);

        $modelStatus = new CoreStatus();
        $status = $modelStatus->allStatus();
        //print_r($status);
        foreach ($status as $st) {
            $choices[] = $st["name"];
            $choicesid[] = $st["id"];
        }
        $form->addSelect("who_can_see", PsTranslator::who_can_see($lang), $choices, $choicesid, $unit["who_can_see"]);
        $form->setValidationButton(CoreTranslator::Ok($lang), "psprojecttypes/edit");
        $form->setCancelButton(CoreTranslator::Cancel($lang), "psprojecttypes");

        if ($form->check()) {
            // run the database query
            $this->model->set($form->getParameter("id"), $form->getParameter("name"), $form->getParameter("who_can_see"));

            $this->redirect("psprojecttypes");
        } else {
            // set the view
            $formHtml = $form->getHtml();
            // view
            $navBar = $this->navBar();
            $this->generateView(array(
                'navBar' => $navBar,
                'formHtml' => $formHtml
            ));
        }
    }

    /**
     * Edit an unit to database
     */
    public function editquery() {

        // get form variables
        $id = $this->request->getParameter("id");
        $name = $this->request->getParameter("name");

        // get the user list
        $this->model->edit($id, $name);
        $this->redirect("psprojecttypes");
    }

    /**
     * Remove an unit query to database
     */
    public function delete() {

        $id = $this->request->getParameter("actionid");
        $this->model->delete($id);

        // generate view
        $this->redirect("psprojecttypes");
    }

}
