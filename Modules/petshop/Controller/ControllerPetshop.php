<?php

require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/petshop/Model/PsProjectType.php';

class ControllerPetshop extends ControllerSecureNav {

    public function __construct() {
        Parent::__construct();
    }

    /**
     * (non-PHPdoc)
     * Show the config index page
     *
     * @see Controller::index()
     */
    public function index() {
        $navBar = $this->navBar();
        $this->generateView(array('navBar' => $navBar));
    }

}
