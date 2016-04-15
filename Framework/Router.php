<?php
require_once 'Controller.php';
require_once 'Request.php';
require_once 'View.php';

/**
 * Class that rout the input requests
 * 
 * @author Sylvain Prigent
 */
class router {
	
	/**
	 * Main method called by the frontal controller
	 * Examine a request and run the dedicated action
	 */
	public function routerRequest() {
            
		try {
			// Merge parameters GET and POST
			$request = new Request ( array_merge ( $_GET, $_POST ) );
			
			$controller = $this->createController ( $request );
			$action = $this->createAction ( $request );
			
			$controller->runAction ( $action );
		} catch ( Exception $e ) {
			$this->manageError ( $e );
		}
	}
	
	/**
	 * Instantiate the controller dedicated to the request
	 *
	 * @param Request $request
	 *        	Input Request
	 * @return Instance of a controller
	 * @throws Exception If the controller cannot be instanciate
	 */
	private function createController(Request $request) {
		// URL are of type : index.php?controller=XXX&action=YYY&id=ZZZ
		$controller = "Home"; // default controller
		if ($request->isParameterNotEmpty( 'controller' )) {
			$controller = $request->getParameter ( 'controller' );
			// First letter in upper
			$controller = ucfirst ( strtolower ( $controller ) );
		}
		// Create the name of the controller such as : Controller/Controller<$controller>.php
		
		$classController = "Controller" . $controller;
		//echo "controler name = " . $classController . "--"; 
		
		// modifications starts here
		$modulesNames = Configuration::get("modules");
		$count = count($modulesNames);
		
		$controllerFound = false;
		for($i = 0; $i < $count; $i++) {
			$fileController = 'Modules/' . $modulesNames[$i] . "/Controller/" . $classController . ".php";
			if (file_exists($fileController)){
				// Instantiate controler
				$controllerFound = true;
				require ($fileController);
				$controller = new $classController ();
				$controller->setRequest ( $request );
				return $controller;
			}
		}
		if (!$controllerFound){
			throw new Exception ( "Unable to find the file '$fileController' " );
		}
		
	}
	
	/**
	 * Find the action to run depending on the request
	 *
	 * @param Request $request
	 *        	input request
	 * @return string Action to run
	 */
	private function createAction(Request $request) {
		$action = "index"; // default action
		if ($request->isParameterNotEmpty( 'action' )) {
			$action = $request->getParameter ( 'action' );
		}
		return $action;
	}
	
	/**
	 * Manage error (exception)
	 *
	 * @param Exception $exception
	 *        	Thrown exception
	 */
	private function manageError(Exception $exception) {
		$view = new View ( 'error' );
		$view->generate ( array (
				'msgError' => $exception->getMessage () 
		) );
	}
}
