<?php


require_once 'Framework/Controller.php';
require_once 'Framework/Form.php';

require_once 'Modules/core/Controller/ControllerSecureNav.php';

class ControllerTetris extends ControllerSecureNav {

	public function index() {
		
			// view
			$navBar = $this->navBar();
			$this->generateView ( array (
					'navBar' => $navBar
			) );
        }
}