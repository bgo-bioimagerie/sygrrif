<?php

require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';

class ControllerStatistics extends ControllerSecureNav {

	//private $billet;
	public function __construct() {
		//$this->billet = new Billet ();
	}

	// Affiche la liste de tous les billets du blog
	public function index() {

		$navBar = $this->navBar();

		$this->generateView ( array (
				'navBar' => $navBar
		) );
	}
}
