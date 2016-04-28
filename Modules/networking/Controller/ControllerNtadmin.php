<?php


require_once 'Framework/Controller.php';
require_once 'Framework/Form.php';
require_once 'Framework/TableView.php';

require_once 'Modules/core/Controller/ControllerSecureNav.php';

require_once 'Modules/networking/Model/NtTranslator.php';
require_once 'Modules/networking/Model/NtGroup.php';

class ControllerNtadmin extends ControllerSecureNav {

    public function index(){
        // view
        $navBar = $this->navBar();
        $this->generateView ( array (
            'navBar' => $navBar
	) );
    }
 
}