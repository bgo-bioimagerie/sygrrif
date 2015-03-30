<?php
require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/anticorps/Model/AcInstall.php';
require_once 'Modules/anticorps/Model/Anticorps.php';
require_once 'Modules/anticorps/Model/Espece.php';
require_once 'Modules/anticorps/Model/Organe.php';
require_once 'Modules/anticorps/Model/Prelevement.php';
require_once 'Modules/core/Model/User.php';
require_once 'Modules/core/Model/CoreTranslator.php';

class ControllerAnticorps extends ControllerSecureNav {
	
	public function __construct() {
	}
	
	// Affiche la liste de tous les billets du blog
	public function index() {
		
		// get sort action
		$sortentry = "id";
		if ($this->request->isParameterNotEmpty('actionid')){
			$sortentry = $this->request->getParameter("actionid");
		}
			
		// get the user list
		$anticorpsModel = new Anticorps();
		$anticorpsArray = $anticorpsModel->getAnticorpsInfo($sortentry);
		
		$navBar = $this->navBar();
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
		
		// get especes list
		$organesModel = new Organe();
		$organes = $organesModel->getOrganes("nom");
		
		// get proto list
		$protoModel = new AcProtocol();
		$protocols = $protoModel->getProtocolsNo();
		
		// get users List
		$modelUser = new User();
		$users = $modelUser->getUsersSummary('name');
		
		// get prelevements list
		$modelPrelevement = new Prelevement();
		$prelevements = $modelPrelevement->getPrelevements("nom"); 
		
			
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
				'organes' => $organes,
				'users' => $users,
				'protocols' => $protocols,
				'prelevements' => $prelevements	  
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
		$no_dossier = $this->request->getParameter ("no_dossier");
		
		$espece = $this->request->getParameter ("espece");
		$organe = $this->request->getParameter ("organe");
		$valide = $this->request->getParameter ("status");
		$ref_bloc = $this->request->getParameter ("ref_bloc");
		$prelevement = $this->request->getParameter ("prelevement");
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
			//echo "date proprio = " . $date_recept[$i];
			if ($proprio > 1 ){
				$date_r = CoreTranslator::dateToEn($date_recept[$i], $lang); 
				$modelAnticorps->addOwner($proprio, $id, $date_r, $disponible[$i], $no_dossier[$i]);
			}
		}
		// add to the tissus table
		for ($i = 0 ; $i <  count($espece) ; $i++){
			$modelTissus->addTissus($id, $espece[$i], $organe[$i], $valide[$i], $ref_bloc[$i],
					$dilution[$i], $temps_incubation[$i], $ref_protocol[$i], $prelevement[$i]);
		}
		    
	    // generate view
	    $this->redirect("anticorps", "index");
	    
	}
	
	public function searchquery(){
		
		$lang = "En";
		if (isset($_SESSION["user_settings"]["language"])){
			$lang = $_SESSION["user_settings"]["language"];
		}
		
		$searchColumn = $this->request->getParameter ("searchColumn");
		$searchTxt = $this->request->getParameter ("searchTxt");
		
		$anticorpsArray = "";
		$anticorpsModel = new Anticorps();
		if($searchColumn == "0"){
			$anticorpsArray = $anticorpsModel->getAnticorpsInfo();
		}	
		else if($searchColumn == "Nom"){
			$anticorpsArray = $anticorpsModel->getAnticorpsInfoSearch("nom", $searchTxt);
		}
		else if($searchColumn == "No_h2p2"){
			$anticorpsArray = $anticorpsModel->getAnticorpsInfoSearch("no_h2p2", $searchTxt);
		}
		else if($searchColumn == "Fournisseur"){
			$anticorpsArray = $anticorpsModel->getAnticorpsInfoSearch("fournisseur", $searchTxt);
		}
		else if($searchColumn == "Source"){
			
			$modelSource = new Source();
			$st = $modelSource->getIdFromName($searchTxt);
			$anticorpsArray = $anticorpsModel->getAnticorpsInfoSearch("id_source", $st);
		}
		else if($searchColumn == "Reference"){
			$anticorpsArray = $anticorpsModel->getAnticorpsInfoSearch("reference", $searchTxt);
		}
		else if($searchColumn == "Clone"){
			$anticorpsArray = $anticorpsModel->getAnticorpsInfoSearch("clone", $searchTxt);
		}
		else if($searchColumn == "lot"){
			$anticorpsArray = $anticorpsModel->getAnticorpsInfoSearch("lot", $searchTxt);
		}
		else if($searchColumn == "Isotype"){
			
			$modelIsotype = new Isotype();
			$st = $modelIsotype->getIdFromName($searchTxt);
			$anticorpsArray = $anticorpsModel->getAnticorpsInfoSearch("id_isotype", $st);
		}
		else if($searchColumn == "Stockage"){
			$anticorpsArray = $anticorpsModel->getAnticorpsInfoSearch("stockage", $searchTxt);
		}
		else if($searchColumn == "dilution"){
			$anticorpsArray = $anticorpsModel->getAnticorpsTissusSearch("dilution", $searchTxt);
		}
		else if($searchColumn == "temps_incub"){
			$anticorpsArray = $anticorpsModel->getAnticorpsTissusSearch("temps_incubation", $searchTxt);
		}
		else if($searchColumn == "ref_proto"){
			$anticorpsArray = $anticorpsModel->getAnticorpsTissusSearch("ref_protocol", $searchTxt);
		}
		else if($searchColumn == "espece"){
			$modelEspece = new Espece();
			$id = $modelEspece->getIdFromName($searchTxt);
			$anticorpsArray = $anticorpsModel->getAnticorpsTissusSearch("espece", $searchTxt);
		}
		else if($searchColumn == "organe"){
			//$modelOrgane = new Organe();
			//$id = $modelOrgane->getIdFromName($searchTxt);
			$anticorpsArray = $anticorpsModel->getAnticorpsTissusSearch("organe", $searchTxt);
		}
		else if($searchColumn == "valide"){
			$anticorpsArray = $anticorpsModel->getAnticorpsTissusSearch("valide", $searchTxt);
		}
		else if($searchColumn == "ref_bloc"){
			$anticorpsArray = $anticorpsModel->getAnticorpsTissusSearch("ref_bloc", $searchTxt);
		}
		else if($searchColumn == "nom_proprio"){
			$anticorpsArray = $anticorpsModel->getAnticorpsProprioSearch("nom_proprio", $searchTxt);
		}
		else if($searchColumn == "disponibilite"){
			$anticorpsArray = $anticorpsModel->getAnticorpsProprioSearch("disponibilite", $searchTxt);
		}
		else if($searchColumn == "date_recept"){
			$anticorpsArray = $anticorpsModel->getAnticorpsProprioSearch("date_recept", CoreTranslator::dateToEn($searchTxt, $lang));
		}
		
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar, 'anticorpsArray' => $anticorpsArray,
				'searchColumn' => $searchColumn, 'searchTxt' => $searchTxt
		), "index" );

	}
	
	public function advsearchquery(){
		
		$searchName = $this->request->getParameterNoException("searchName");
		$searchNoH2P2 = $this->request->getParameterNoException ("searchNoH2P2");
		$searchSource = $this->request->getParameterNoException ("searchSource");
		$searchCible = $this->request->getParameterNoException ("searchCible");
		$searchValide = $this->request->getParameterNoException ("searchValide");
		$searchResp = $this->request->getParameterNoException ("searchResp");
		
		$anticorpsModel = new Anticorps();
		$anticorpsArray = $anticorpsModel->searchAdv($searchName, $searchNoH2P2, $searchSource, $searchCible, $searchValide, $searchResp);
		//$anticorpsArray = $anticorpsModel->getAnticorpsInfo("id");
		
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar, 'anticorpsArray' => $anticorpsArray,
				'searchName' => $searchName, 
				'searchNoH2P2' => $searchNoH2P2, 
				'searchSource' => $searchSource, 
				'searchCible' => $searchCible, 
				'searchValide' => $searchValide, 
				'searchResp' => $searchResp
		), "index" );
	}
	
}
