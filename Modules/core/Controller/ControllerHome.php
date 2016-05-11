<?php

require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerOpen.php';

/**
 * 
 * @author sprigent
 * Controller for the home page
 */
class ControllerHome extends ControllerOpen {

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * (non-PHPdoc)
     * @see Controller::index()
     */
    public function index() {

        $modelConfig = new CoreConfig();
        $home_url = $modelConfig->getParam("home_url");
        if ($home_url != "") {
            $this->redirect($home_url);
        } else {
            $this->redirect("tiles");
        }
    }

}
