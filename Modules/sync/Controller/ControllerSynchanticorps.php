<?php
require_once 'Framework/Controller.php';
require_once 'Modules/anticorps/Model/AcProtocol.php';
require_once 'Modules/anticorps/Model/Anticorps.php';
require_once 'Modules/anticorps/Model/Isotype.php';
require_once 'Modules/anticorps/Model/Organe.php';
require_once 'Modules/anticorps/Model/Tissus.php';
require_once 'Modules/anticorps/Model/Espece.php';
require_once 'Modules/anticorps/Model/Prelevement.php';
require_once 'Modules/anticorps/Model/Kit.php';
require_once 'Modules/anticorps/Model/Proto.php';
require_once 'Modules/anticorps/Model/Fixative.php';
require_once 'Modules/anticorps/Model/AcOption.php';
require_once 'Modules/anticorps/Model/Enzyme.php';
require_once 'Modules/anticorps/Model/Dem.php';
require_once 'Modules/anticorps/Model/Aciinc.php';
require_once 'Modules/anticorps/Model/Linker.php';
require_once 'Modules/anticorps/Model/Inc.php';
require_once 'Modules/anticorps/Model/Acii.php';
require_once 'Modules/core/Model/User.php';

require_once 'externals/PHPExcel/Classes/PHPExcel.php';

class ControllerSynchanticorps extends Controller {

	public function __construct() {
	}

	// affiche la liste des Sources
	public function index() {	

		$dsn_grr = 'mysql:host=localhost;dbname=test_h2p2;charset=utf8';
		$login_grr = "root";
		$pwd_grr = "";
		
		$pdo_grr = new PDO($dsn_grr, $login_grr, $pwd_grr,
				array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		
		
		$this->kit($pdo_grr);
		echo "add kit <br/>";
		
		$this->proto($pdo_grr);
		echo "add proto <br/>";
		
		$this->fixative($pdo_grr);
		echo "add fixative <br/>";
		
		$this->acoption($pdo_grr);
		echo "add acoption <br/>";
		
		$this->enzyme($pdo_grr);
		echo "add enzyme <br/>";
		
		$this->dem($pdo_grr);
		echo "add dem <br/>";
		
		$this->aciinc($pdo_grr);
		echo "add aciinc <br/>";
		
		$this->linker($pdo_grr);
		echo "add linker <br/>";
		
		$this->inc($pdo_grr);
		echo "add inc <br/>";
		
		$this->acii($pdo_grr);
		echo "add acii <br/>";
		
		$this->importProtos($pdo_grr);
		echo "add proto <br/>";
		
		$this->importSourceAndAll($pdo_grr);
		echo "add sources et all <br/>";
		
		$this->importAnticorps($pdo_grr);
		echo "add anticorps <br/>";
		
		$this->importAnticorpsJoints($pdo_grr);
		echo "add joins <br/>";
		
	}
	
	public function kit($pdo_grr){
		$sql = "select distinct kit from ac_protocol";
		$entry_oldq = $pdo_grr->query($sql);
		$entry_old = $entry_oldq->fetchAll();
		
		$modelKit = new Kit();
		$modelKit->addKit("--");
		foreach ($entry_old as $entry){
			if($entry[0] && $entry[0]!="/" && $entry[0]!=""){
				$modelKit->addKit($entry[0]);
			}
		}
	}
	
	public function proto($pdo_grr){
		$sql = "select distinct proto from ac_protocol";
		$entry_oldq = $pdo_grr->query($sql);
		$entry_old = $entry_oldq->fetchAll();
		
		$modelProto = new Proto();
		$modelProto->addProto("--");
		foreach ($entry_old as $entry){
			if($entry[0] && $entry[0]!="/" && $entry[0]!=""){	
				$modelProto->addProto($entry[0]);
			}
		}
	}
	
	public function fixative($pdo_grr){
		$sql = "select distinct fixative from ac_protocol";
		$entry_oldq = $pdo_grr->query($sql);
		$entry_old = $entry_oldq->fetchAll();
		
		$modelFixative = new Fixative();
		$modelFixative->addFixative("--");
		foreach ($entry_old as $entry){
			if($entry[0] && $entry[0]!="/" && $entry[0]!=""){
				$modelFixative->addFixative($entry[0]);
			}
		}
	}
	
	public function acoption($pdo_grr){
		$sql = "select distinct option_ from ac_protocol";
		$entry_oldq = $pdo_grr->query($sql);
		$entry_old = $entry_oldq->fetchAll();
		
		$modeloption = new AcOption();
		$modeloption->addOption("--");
		foreach ($entry_old as $entry){
			if($entry[0] && $entry[0]!="/" && $entry[0]!=""){
				$modeloption->addOption($entry[0]);
			}
		}
	}
	
	public function enzyme($pdo_grr){
		$sql = "select distinct enzyme from ac_protocol";
		$entry_oldq = $pdo_grr->query($sql);
		$entry_old = $entry_oldq->fetchAll();
		
		$modelenzyme = new Enzyme();
		$modelenzyme->addEnzyme("--");
		foreach ($entry_old as $entry){
			if($entry[0] && $entry[0]!="/" && $entry[0]!=""){
				$modelenzyme->addEnzyme($entry[0]);
			}
		}
	}
	
	public function dem($pdo_grr){
		$sql = "select distinct dem from ac_protocol";
		$entry_oldq = $pdo_grr->query($sql);
		$entry_old = $entry_oldq->fetchAll();
		
		$model = new Dem($pdo_grr);
		$model->addDem("--");
		foreach ($entry_old as $entry){
			if($entry[0] && $entry[0]!="/" && $entry[0]!=""){	
				$model->addDem($entry[0]);
			}
		}
	}
	
	public function aciinc($pdo_grr){
		$sql = "select distinct acl_inc from ac_protocol";
		$entry_oldq = $pdo_grr->query($sql);
		$entry_old = $entry_oldq->fetchAll();
		
		$model = new Aciinc();
		$model->addAciinc("--");
		foreach ($entry_old as $entry){
			if($entry[0] && $entry[0]!="/" && $entry[0]!=""){	
				$model->addAciinc($entry[0]);
			}
		}
	}
	
	public function linker($pdo_grr){
		$sql = "select distinct linker from ac_protocol";
		$entry_oldq = $pdo_grr->query($sql);
		$entry_old = $entry_oldq->fetchAll();
		
		$model = new Linker();
		$model->addLinker("--");
		foreach ($entry_old as $entry){
			if($entry[0] && $entry[0]!="/" && $entry[0]!=""){
				$model->addLinker($entry[0]);
			}
		}
	}
	
	public function inc($pdo_grr){
		$sql = "select distinct inc from ac_protocol";
		$entry_oldq = $pdo_grr->query($sql);
		$entry_old = $entry_oldq->fetchAll();
		
		$model = new Inc();
		$model->addInc("--");
		foreach ($entry_old as $entry){
			if($entry[0] && $entry[0]!="/" && $entry[0]!=""){
				$model->addInc($entry[0]);
			}
		}
		
		$sql = "select distinct inc2 from ac_protocol";
		$entry_oldq = $pdo_grr->query($sql);
		$entry_old = $entry_oldq->fetchAll();
		foreach ($entry_old as $entry){
			if($entry[0] && $entry[0]!="/" && $entry[0]!=""){
				if (!$model->isInc($entry[0])){
					$model->addInc($entry[0]);
				}
			}
		}
		
	}
	
	public function acii($pdo_grr){
		$sql = "select distinct acll from ac_protocol";
		$entry_oldq = $pdo_grr->query($sql);
		$entry_old = $entry_oldq->fetchAll();
		
		$model = new Acii();
		$model->addAcii("--");
		foreach ($entry_old as $entry){
			if($entry[0] && $entry[0]!="/" && $entry[0]!=""){
				$model->addAcii($entry[0]);
			}
		}
	}
	
	public function importProtos($pdo_grr){
		$sql = "select * from ac_protocol";
		$entry_oldq = $pdo_grr->query($sql);
		$entry_old = $entry_oldq->fetchAll();
		
		$modelProtocol = new AcProtocol();
		$modelKit = new Kit();
		$modelProto = new Proto();
		$modelFixative = new Fixative();
		$modelOption = new AcOption();
		$modelEnzyme = new Enzyme();
		$modelDem = new Dem();
		$modelAciinc = new Aciinc();
		$modelLinker = new Linker();
		$modelInc = new Inc();
		$modelAcii = new Acii();
		foreach ($entry_old as $entry){
			
			//print_r($entry);
			
			$id = $entry["id"];
			$kit = $modelKit->getIdFromName($entry["kit"]);
			$no_proto = $entry["no_proto"]; 
			$proto = $modelProto->getIdFromName($entry["proto"]);
			$fixative = $modelFixative->getIdFromName($entry["fixative"]);
			$acoption = $modelOption->getIdFromName($entry["option_"]);
			$enzyme = $modelEnzyme->getIdFromName($entry["enzyme"]);
			$dem = $modelDem->getIdFromName($entry["dem"]);
			$acl_inc = $modelAciinc->getIdFromName($entry["acl_inc"]);
			$linker = $modelFixative->getIdFromName($entry["linker"]);
			$inc = $modelInc->getIdFromName($entry["inc"]);
			$acll = $modelAcii->getIdFromName($entry["acll"]);
			$inc2 = $modelInc->getIdFromName($entry["inc2"]);
			
			//echo "inc = " . $inc . "<br/>";
			
			$associe = $entry["associe"];
			
			if($kit == 0){$kit = 1;}
			if($proto == 0){$proto = 1;}
			if($fixative == 0){$fixative = 1;}
			if($acoption == 0){$acoption = 1;}
			if($enzyme == 0){$enzyme = 1;}
			if($dem == 0){$dem = 1;}
			if($acl_inc == 0){$acl_inc = 1;}
			if($linker == 0){$linker = 1;}
			if($inc == 0){$inc = 1;}
			if($acll == 0){$acll = 1;}
			if($inc2 == 0){$inc2 = 1;}
			
			
			if ($modelProtocol->isProtocolOfID($id)){
				$modelProtocol->editProtocol($id, $kit, $no_proto, $proto, $fixative, $acoption, $enzyme, $dem, $acl_inc, $linker, $inc, $acll, $inc2, $associe);
			}
			else{
				$modelProtocol->importProtocol($id, $kit, $no_proto, $proto, $fixative, $acoption, $enzyme, $dem, $acl_inc, $linker, $inc, $acll, $inc2, $associe);
			}
		}
	}
	
	public function importSourceAndAll($pdo_grr){
		
		// Source
		$sql = "select * from ac_sources";
		$entry_oldq = $pdo_grr->query($sql);
		$entry_old = $entry_oldq->fetchAll();
		
		$model = new Source();
		foreach($entry_old as $entry){
			$model->importSource($entry["id"], $entry["nom"]);
		}
		echo "add sources <br/>";
		
		// Isotype
		$sql = "select * from ac_isotypes";
		$entry_oldq = $pdo_grr->query($sql);
		$entry_old = $entry_oldq->fetchAll();
		
		$model = new Isotype();
		foreach($entry_old as $entry){
			$model->importIsotype($entry["id"], $entry["nom"]);
		}
		echo "add isotype <br/>";
		
		// Espèce
		$sql = "select * from ac_especes";
		$entry_oldq = $pdo_grr->query($sql);
		$entry_old = $entry_oldq->fetchAll();
		
		$model = new Espece();
		foreach($entry_old as $entry){
			$model->importEspece($entry["id"], $entry["nom"]);
		}
		echo "add espece <br/>";
		
		// organe
		$sql = "select * from ac_organes";
		$entry_oldq = $pdo_grr->query($sql);
		$entry_old = $entry_oldq->fetchAll();
		
		$model = new Organe();
		foreach($entry_old as $entry){
			$model->importOrgane($entry["id"], $entry["nom"]);
		}
		echo "add organe <br/>";
		
		// Prelevement
		$sql = "select * from ac_prelevements";
		$entry_oldq = $pdo_grr->query($sql);
		$entry_old = $entry_oldq->fetchAll();
		
		$model = new Prelevement();
		foreach($entry_old as $entry){
			$model->importPrelevement($entry["id"], $entry["nom"]);
		}
		echo "add prelevement <br/>";
		
	}
	
	public function importAnticorps($pdo_grr){
		$sql = "select * from ac_anticorps";
		$entry_oldq = $pdo_grr->query($sql);
		$entry_old = $entry_oldq->fetchAll();
		
		$model = new Anticorps();
		foreach ($entry_old as $entry){
			
			$id = $entry["id"]; 
			$nom = $entry["nom"]; 
			$no_h2p2 = $entry["no_h2p2"]; 
			$fournisseur = $entry["fournisseur"];
			$id_source = $entry["id_source"];
			$reference = $entry["reference"];
			$clone = $entry["clone"];
			$lot = $entry["lot"];
			$id_isotype = $entry["id_isotype"];
			$stockage = $entry["stockage"];
			
			if (!$model->isAnticorpsID($id)){
				$model->importAnticorps($id, $nom, $no_h2p2, $fournisseur, $id_source, $reference, $clone,
										$lot, $id_isotype, $stockage);
			}
			else{
				$model->updateAnticorps($id, $nom, $no_h2p2, $fournisseur, $id_source, $reference, $clone,
						$lot, $id_isotype, $stockage);
			}
		}
	}
	
	public function importAnticorpsJoints($pdo_grr){
		$sql = "select * from ac_j_tissu_anticorps";
		$entry_oldq = $pdo_grr->query($sql);
		$entry_old = $entry_oldq->fetchAll();
		
		$model = new Tissus();
		foreach($entry_old as $entry){
			$id = $entry["id"];
			$id_anticorps = $entry["id_anticorps"];
			$espece = $entry["espece"];
			$organe = $entry["organe"];
			$status = $entry["status"];
			$ref_bloc = $entry["ref_bloc"];
			$dilution = $entry["dilution"];
			$temps_incubation = $entry["temps_incubation"];
			$ref_protocol = $entry["ref_protocol"];
			$prelevement = $entry["prelevement"];
			$model->importTissus($id, $id_anticorps, $espece, $organe, $status, $ref_bloc, $dilution, $temps_incubation, $ref_protocol, $prelevement);
		}
		
		$sql = "select * from ac_j_user_anticorps";
		$entry_oldq = $pdo_grr->query($sql);
		$entry_old = $entry_oldq->fetchAll();
		
		$model = new Anticorps();
		foreach($entry_old as $entry){
			$id_utilisateur = $entry["id_utilisateur"];
			$id_anticorps = $entry["id_anticorps"];
			$date_recept = $entry["date_recept"];
			$disponible = $entry["disponible"];
			$no_dossier = $entry["no_dossier"];
			$model->addOwner($id_utilisateur, $id_anticorps, $date_recept, $disponible, $no_dossier);
		}
	}
}
?>