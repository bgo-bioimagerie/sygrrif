<?php

require_once 'Framework/Controller.php';
require_once 'Framework/TableView.php';
require_once 'Framework/Form.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/petshop/Model/PsEntryReason.php';
require_once 'Modules/petshop/Model/PsTranslator.php';
require_once 'Modules/petshop/Model/PsProjectType.php';

/**
 * Manage the units (each user belongs to an unit)
 * 
 * @author sprigent
 *
 */
class ControllerPsentryreason extends ControllerSecureNav {

    /**
     * User model object
     */
    private $model;

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        $this->model = new PsEntryReason ();
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

        $table = new TableView();
        $table->ignoreEntry("id", 1);
        $table->setTitle(PsTranslator::EntryReason($lang));
        $table->addLineEditButton("psentryreason/edit");
        $table->addDeleteButton("psentryreason/delete");
        $table->addPrintButton("psentryreason/index/");
        $tableHtml = $table->view($unitsArray, array("id" => "ID", "name" => CoreTranslator::Name($lang)));

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
        $unit = array("id" => 0, "name" => "");
        if ($unitId > 0) {
            $unit = $this->model->get($unitId);
        }

        // lang
        $lang = $this->getLanguage();

        // form
        // build the form
        $form = new Form($this->request, "psentryreason/edit");
        $form->setTitle(PsTranslator::Edit_entry_reason($lang));
        $form->addHidden("id", $unit["id"]);
        $form->addText("name", CoreTranslator::Name($lang), true, $unit["name"]);

        $form->setValidationButton(CoreTranslator::Ok($lang), "psentryreason/edit");
        $form->setCancelButton(CoreTranslator::Cancel($lang), "psentryreason");

        if ($form->check()) {
            // run the database query
            $this->model->set($form->getParameter("id"), $form->getParameter("name"));

            $this->redirect("psentryreason");
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
        $this->redirect("psentryreason");
    }

    /**
     * Remove an unit query to database
     */
    public function delete() {

        $id = $this->request->getParameter("actionid");
        $this->model->delete($id);

        // generate view
        $this->redirect("psentryreason");
    }

}
