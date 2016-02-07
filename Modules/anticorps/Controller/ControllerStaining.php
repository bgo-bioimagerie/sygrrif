<?php

require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/anticorps/Model/AcStaining.php';

class ControllerStaining extends ControllerSecureNav {

    /**
     * User model object
     */
    private $model;

    public function __construct() {
        parent::__construct();
        $this->model = new AcStaining();
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
        $optionsArray = $this->model->getStainings($sortentry);

        $this->generateView(array(
            'navBar' => $navBar,
            'stainings' => $optionsArray
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
        $option = $this->model->getStaining($especeId);

        //print_r ( $isotype );
        $this->generateView(array(
            'navBar' => $navBar,
            'staining' => $option
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
        $this->model->addStaining($name);

        $this->redirect("staining");
    }

    public function editquery() {

        // get form variables
        $id = $this->request->getParameter("id");
        $name = $this->request->getParameter("nom");

        // edit query
        $this->model->editStaining($id, $name);

        $this->redirect("staining");
    }

    public function delete() {

        // get source id
        $id = 0;
        if ($this->request->isParameterNotEmpty('actionid')) {
            $id = $this->request->getParameter("actionid");
        }

        // get source info
        $this->model->delete($id);

        $this->redirect("staining");
    }

}
