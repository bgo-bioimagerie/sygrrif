<?php
require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/anticorps/Model/AcInstall.php';
require_once 'Modules/anticorps/Model/Anticorps.php';
require_once 'Modules/core/Model/User.php';

class ControllerAnticorps extends ControllerSecureNav {
	
	public function __construct() {
	}
	
	// Affiche la liste de tous les billets du blog
	public function index() {
		
		$navBar = $this->navBar();
		
		// get sort action
		$sortentry = "id";
		if ($this->request->isParameterNotEmpty('actionid')){
			$sortentry = $this->request->getParameter("actionid");
		}
			
		// get the user list
		$anticorpsModel = new Anticorps();
		$anticorpsArray = $anticorpsModel->getAnticorpsInfo($sortentry);
		
		
		$this->generateView ( array (
				'navBar' => $navBar, 'anticorpsArray' => $anticorpsArray
		) );
	
	}
	
	public function add(){
		$navBar = $this->navBar();
	
		
		// Lists for the form	
		// get isotypes list
		$modelIsotype = new Isotype();
		$isotypesList = $modelIsotype->getIsotypes();
	
		// get sources list
		$modelSource = new Source();
		$sourcesList = $modelSource->getSources();
		
		// get users List
		$modelUser = new User();
		$users = $modelUser->getUsersSummary('name');
			
	
		$this->generateView ( array (
				'navBar' => $navBar,
				'isotypesList' => $isotypesList,
				'sourcesList' => $sourcesList,
				'users' => $users  
		) );
	}
	public function addquery(){
		
		// add in anticorps table
		$nom = $this->request->getParameter ("nom");
		$no_h2p2 = $this->request->getParameter ("no_h2p2");
		$date_recept = $this->request->getParameter ("date_recept");
		$reference = $this->request->getParameter ("reference");
		$clone = $this->request->getParameter ("clone");
		$fournisseur = $this->request->getParameter ("fournisseur");
		$lot = $this->request->getParameter ("lot");
		$id_isotype = $this->request->getParameter ("id_isotype");
		$id_source = $this->request->getParameter ("id_source");
		$stockage = $this->request->getParameter ("stockage");
		$No_Proto = $this->request->getParameter ("No_Proto");
		$disponible = $this->request->getParameter ("disponible");
		$id_proprietaire = $this->request->getParameter("id_proprietaire");
		
		// add anticorps to table
		$modelAnticorps = new Anticorps();
		$id = $modelAnticorps->addAnticorps($nom, $no_h2p2, $date_recept, 
		                              $reference, $clone, $fournisseur, 
		                              $lot, $id_isotype, $id_source, $stockage, 
		                              $No_Proto, $disponible);
		
		// add the owner
		$modelAnticorps->addOwner($id_proprietaire, $id);

	    // add to the tissus table
	    $espece = $this->request->getParameter ("espece");
	    $organe = $this->request->getParameter ("organe");
	    $valide = $this->request->getParameter ("valide");
	    $ref_bloc = $this->request->getParameter ("ref_bloc");
	    
	    print_r($espece);
	    print_r($organe);
	    print_r($valide);
	    print_r($ref_bloc);
	    
	    $modelTissus = new Tissus();
	    for ($i = 0 ; $i <  count($espece) ; $i++){
	    	$modelTissus->addTissus($id, $espece[$i], $organe[$i], $valide[$i], $ref_bloc[$i]);
	    }
	    
	    // generate view
	    $navBar = $this->navBar();
	    $this->generateView ( array (
	    		'navBar' => $navBar
	    ) );
	    
	}
	
	
}
