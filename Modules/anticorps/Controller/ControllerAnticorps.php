<?php
require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/anticorps/Model/AcInstall.php';
require_once 'Modules/anticorps/Model/Anticorps.php';
require_once 'Modules/anticorps/Model/Espece.php';
require_once 'Modules/core/Model/User.php';
require_once 'Modules/core/Model/CoreTranslator.php';

class ControllerAnticorps extends ControllerSecureNav {
	
	public function __construct() {
	}
	
	// Affiche la liste de tous les billets du blog
	public function index() {
		
		/// @todo remove this and make an install tab
		$installModel = new AcInstall();
		$installModel->createDatabase();
		
		
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
	
	public function edit(){

		// Lists for the form	
		// get isotypes list
		$modelIsotype = new Isotype();
		$isotypesList = $modelIsotype->getIsotypes();
	
		// get sources list
		$modelSource = new Source();
		$sourcesList = $modelSource->getSources();
		
		// get especes list
		$especesModel = new Espece();
		$especes = $especesModel->getEspeces("nom");
		
		// get proto list
		$protoModel = new AcProtocol();
		$protocols = $protoModel->getProtocolsNo();
		
		// get users List
		$modelUser = new User();
		$users = $modelUser->getUsersSummary('name');
			
		// get edit id
		$editID = "";
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$editID = $this->request->getParameter ( "actionid" );
		}
		
		$anticorps = array();
		$modelAnticorps = new Anticorps();
		if ($editID != ""){	
			$anticorps = $modelAnticorps->getAnticorpsFromId($editID);
		}
		else{
			$anticorps = $modelAnticorps->getDefaultAnticorps();
		}
		
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'isotypesList' => $isotypesList,
				'sourcesList' => $sourcesList,
				'anticorps' => $anticorps,
				'especes' => $especes,
				'users' => $users,
				'protocols' => $protocols	  
		) );
	}
	public function editquery(){
		
		$lang = "En";
		if (isset($_SESSION["user_settings"]["language"])){
			$lang = $_SESSION["user_settings"]["language"];
		}
		
		// add in anticorps table
		$id = $this->request->getParameterNoException("id");
		$nom = $this->request->getParameter ("nom");
		$no_h2p2 = $this->request->getParameter ("no_h2p2");
		$reference = $this->request->getParameter ("reference");
		$clone = $this->request->getParameter ("clone");
		$fournisseur = $this->request->getParameter ("fournisseur");
		$lot = $this->request->getParameter ("lot");
		$id_isotype = $this->request->getParameter ("id_isotype");
		$id_source = $this->request->getParameter ("id_source");
		$stockage = $this->request->getParameter ("stockage");
		
		$id_proprietaire = $this->request->getParameter("id_proprietaire");
		$disponible = $this->request->getParameter ("disponible");
		$date_recept = $this->request->getParameter ("date_recept");
		
		$espece = $this->request->getParameter ("espece");
		$organe = $this->request->getParameter ("organe");
		$valide = $this->request->getParameter ("valide");
		$ref_bloc = $this->request->getParameter ("ref_bloc");
		$dilution = $this->request->getParameter ("dilution");
		$temps_incubation = $this->request->getParameter ("temps_incubation");
		$ref_protocol = $this->request->getParameter ("ref_protocol");
		
		
		$modelAnticorps = new Anticorps();
		$modelTissus = new Tissus();
		if ($id == ""){
			// add anticorps to table 
			$id = $modelAnticorps->addAnticorps($nom, $no_h2p2, $fournisseur, $id_source, $reference, $clone,
												$lot, $id_isotype, $stockage);
			
		}
		else{
			
			// update antibody
			$modelAnticorps->updateAnticorps($id, $nom, $no_h2p2, $fournisseur, $id_source, $reference, $clone,
					$lot, $id_isotype, $stockage);
			
			// remove all the owners
			$modelAnticorps->removeOwners($id);
			
			// remove all the Tissus
			$modelTissus->removeTissus($id);
			
		}
		
		// add the owner
		$i = -1;
		foreach ($id_proprietaire as $proprio){
			$i++;
			$date_r = CoreTranslator::dateToEn($date_recept[$i], $lang); 
			$modelAnticorps->addOwner($proprio, $id, $date_r, $disponible[$i]);
		}
		// add to the tissus table
		
		for ($i = 0 ; $i <  count($espece) ; $i++){
			$modelTissus->addTissus($id, $espece[$i], $organe[$i], $valide[$i], $ref_bloc[$i],
					$dilution[$i], $temps_incubation[$i], $ref_protocol[$i]);
		}
		    
	    // generate view
	    $this->redirect("anticorps", "index");
	    
	}
	
	
}
