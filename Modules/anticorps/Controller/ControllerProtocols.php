<?php
require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/anticorps/Model/AcProtocol.php';

class ControllerProtocols extends ControllerSecureNav {
	
	/**
	 * User model object
	 */
	private $protocolModel;
	
	public function __construct() {
		$this->protocolModel = new AcProtocol();
	}
	
	// affiche la liste des isotypes
	public function index() {
		$navBar = $this->navBar ();
		
		// get sort action
		$sortentry = "id";
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$sortentry = $this->request->getParameter ( "actionid" );
		}
		
		// get the user list
		$protocolesArray = $this->protocolModel->getProtocols2( $sortentry );
		
		$this->generateView ( array (
				'navBar' => $navBar,
				'protocols' => $protocolesArray 
		) );
	}
	
	public function protoref(){
		$protocolRef = 0;
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$protocolRef = $this->request->getParameter ( "actionid" );
		}
		
		// get the user list
		$protocolesArray = $this->protocolModel->getProtocolsByRef($protocolRef);
		
		
		// view
		$navBar = $this->navBar ();
		$this->generateView ( array (
				'navBar' => $navBar,
				'protocols' => $protocolesArray
		), "index" );
	}
	
	public function edit() {
		$navBar = $this->navBar ();
		
		// get isotype id
		$protocolId = 0;
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$protocolId = $this->request->getParameter ( "actionid" );
		}
		
		$protocol ['id'] = "";
		$protocol ['kit'] = "";
		$protocol ['no_proto'] = "";
		$protocol ['proto'] = "";
		$protocol ['fixative'] = "";
		$protocol ['option_'] = "";
		$protocol ['enzyme'] = "";
		$protocol ['dem'] = "";
		$protocol ['acl_inc'] = "";
		$protocol ['linker'] = "";
		$protocol ['inc'] = "";
		$protocol ['acll'] = "";
		$protocol ['inc2'] = "";
		$protocol ['associe'] = "";
		
		if ($protocolId != 0){
			// get isotype info
			$protocol = $this->protocolModel->getProtocol ( $protocolId );
		}
		
		//print_r ( $isotype );
		
		$this->generateView ( array (
				'navBar' => $navBar,
				'protocol' => $protocol 
		) );
	}
	
	public function editquery() {
		
		// get form variables
		$id = $this->request->getParameterNoException( "id" );
		$kit = $this->request->getParameter ( "kit" );
		$no_proto = $this->request->getParameter ( "no_proto" );
		$proto = $this->request->getParameter ( "proto" );
		$fixative = $this->request->getParameter ( "fixative" );
		$option = $this->request->getParameter ( "option" );
		$enzyme = $this->request->getParameter ( "enzyme" );
		$dem = $this->request->getParameter ( "dem" );
		$acl_inc = $this->request->getParameter ( "acl_inc" );
		$linker = $this->request->getParameter ( "linker" );
		$inc = $this->request->getParameter ( "inc" );
		$acll = $this->request->getParameter ( "acll" );
		$inc2 = $this->request->getParameter ( "inc2" );
		$associe = $this->request->getParameter ( "associate" );
		
		// add query
		if ($id == ""){
			$this->protocolModel->addProtocol($kit, $no_proto, $proto, $fixative, $option, $enzyme, $dem, $acl_inc, $linker, $inc, $acll, $inc2, $associe);
		}
		else{
			$this->protocolModel->editProtocol($id, $kit, $no_proto, $proto, $fixative, $option, $enzyme, $dem, $acl_inc, $linker, $inc, $acll, $inc2, $associe);
		}
		
		$this->redirect ( "protocols" );
	}
	
	public function delete(){
	
		// get source id
		$id = 0;
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$id = $this->request->getParameter ( "actionid" );
		}
	
		// get source info
		$source = $this->protocolModel->delete($id );
	
		$this->redirect ( "protocols" );
	}
}