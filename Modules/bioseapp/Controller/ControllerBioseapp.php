<?php

require_once 'Framework/Controller.php';
require_once 'Framework/Form.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';

class ControllerBioseapp extends ControllerSecureNav {

	public function index() {
            $this->redirect("bioseprojects");
	}
}