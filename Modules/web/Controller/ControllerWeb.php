<?php


require_once 'Framework/Controller.php';
require_once 'Framework/Form.php';

require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/web/Model/WbTranslator.php';


class ControllerWeb extends ControllerSecureNav {
 
    public function index() {
        $navBar = $this->navBar();
        $this->generateView(
                array("navBar" => $navBar));
    }
}