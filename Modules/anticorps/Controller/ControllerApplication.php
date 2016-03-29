<?php

require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/anticorps/Model/AcApplication.php';

class ControllerApplication extends ControllerSecureNav {

    /**
     * User model object
     */
    private $model;

    public function __construct() {
        parent::__construct();
        $this->model = new AcApplication();
    }

    // affiche la liste des Prelevements
    public function index() {
        $navBar = $this->navBar();

        // get sort action
        $sortentry = "id";
        if ($this->request->isParameterNotEmpty('actionid')) {
            $sortentry = $this->request->getParameter("actionid");
        }

        // get the user list
        $optionsArray = $this->model->getApplications($sortentry);

        $this->generateView(array(
            'navBar' => $navBar,
            'applications' => $optionsArray
        ));
    }

    public function edit() {
        $navBar = $this->navBar();

        // get isotype id
        $especeId = 0;
        if ($this->request->isParameterNotEmpty('actionid')) {
            $especeId = $this->request->getParameter("actionid");
        }

        // get isotype info
        $option = $this->model->getApplication($especeId);

        //print_r ( $isotype );
        $this->generateView(array(
            'navBar' => $navBar,
            'application' => $option
        ));
    }

    public function add() {
        $navBar = $this->navBar();

        $this->generateView(array(
            'navBar' => $navBar
        ));
    }

    public function addquery() {

        // get form variables
        $name = $this->request->getParameter("nom");

        // add query
        $this->model->addApplication($name);

        $this->redirect("application");
    }

    public function editquery() {

        // get form variables
        $id = $this->request->getParameter("id");
        $name = $this->request->getParameter("nom");

        // edit query
        $this->model->editApplication($id, $name);

        $this->redirect("application");
    }

    public function delete() {

        // get source id
        $id = 0;
        if ($this->request->isParameterNotEmpty('actionid')) {
            $id = $this->request->getParameter("actionid");
        }

        // get source info
        $this->model->delete($id);

        $this->redirect("application");
    }

}
