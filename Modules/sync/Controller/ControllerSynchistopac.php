<?php
require_once 'Framework/Controller.php';
require_once 'Modules/anticorps/Model/AcProtocol.php';
require_once 'Modules/anticorps/Model/Anticorps.php';
require_once 'Modules/anticorps/Model/Isotype.php';
require_once 'Modules/anticorps/Model/Organe.php';
require_once 'Modules/anticorps/Model/Tissus.php';
require_once 'Modules/anticorps/Model/Espece.php';
require_once 'Modules/core/Model/CoreUser.php';

require_once 'externals/PHPExcel/Classes/PHPExcel.php';

class ControllerSynchistopac extends Controller {

	public function __construct() {
	}

	// affiche la liste des Sources
	public function index() {	
		
		/*
		// load xls file
		$file = "C:\Users\sprigent\Desktop\ListingAc12-03.xls";
		if (file_exists($file)){
			echo "file found ! <br/>";
		}
		else{
			echo "file not found ! <br/>";
		}
		$XLSDocument = new PHPExcel_Reader_Excel5();
		$objPHPExcel = $XLSDocument->load($file);
		$objPHPExcel->setActiveSheetIndex(0);
		
		// units from xls
		$this->syncProtocols($objPHPExcel);
		echo "sync protocols </br>";
		
		$this->syncAnticorps($objPHPExcel);
		echo "sync anticorps </br>";
		*/
		
		$this->addSources();
		echo "add sources </br>";
		
		$this->addEspeces();
		echo "add especes </br>";
		
		$this->addOrganes();
		echo "add organes </br>";
		
		$this->addIsotype();
		echo "add isotypes </br>";
		
		$this->syncAssociedProtocols();
		echo "sync associated proto </br>";
		
		$this->syncGeneralProtocols();
		echo "sync general proto </br>";
		
		$this->syncAssociedAnticorps();
		echo "sync associed proto </br>";
		
		$this->syncAnticorps1203();
		echo "sync Anticorps1203 </br>";
		
		$this->syncAnticorpsTissusProprio1203();
		echo "sync Anticorps tissus proprio 1203 </br>";
	}
	
	public function addSources(){
		$modelSource = new Source();
		$modelSource->addSource("--");
		$modelSource->addSource("Rabbit");
		$modelSource->addSource("Goat");
		$modelSource->addSource("Mouse");
		$modelSource->addSource("Rat");
	}
	
	public function addEspeces(){
		$modelEspece = new Espece();
		$modelEspece->addEspece("--");
		$modelEspece->addEspece("Rabbit");
		$modelEspece->addEspece("Goat");
		$modelEspece->addEspece("Mouse");
		$modelEspece->addEspece("Rat");
		$modelEspece->addEspece("Human");
		$modelEspece->addEspece("Dog");
		$modelEspece->addEspece("Pig");
		$modelEspece->addEspece("Chicken");
		$modelEspece->addEspece("Xenopus");
		$modelEspece->addEspece("Zebrafish");
		$modelEspece->addEspece("Trout");
	}
	
	public function addOrganes(){
		$modelOrgane = new Organe();
		$modelOrgane->addOrgane("--");
		$modelOrgane->addOrgane("vaisseaux");
		$modelOrgane->addOrgane("Liver");
		$modelOrgane->addOrgane("Lung");
		$modelOrgane->addOrgane("LYMPHOMNIMAPE");
		$modelOrgane->addOrgane("INTESTIN");
	}
	
	public function addIsotype(){
		//$modelIsotype = new Isotype();
		//$modelIsotype->addIsotype("default");
	}
	
	
	public function loadXlsFile($fileAdress){
		// load xls file
		if (file_exists($fileAdress)){
			echo "file found ! <br/>";
		}
		else{
			echo "file not found ! <br/>" + $fileAdress + "<br/>";
		}
		$XLSDocument = new PHPExcel_Reader_Excel5();
		$objPHPExcel = $XLSDocument->load($fileAdress);
		$objPHPExcel->setActiveSheetIndex(0);
		return $objPHPExcel;
	}
	
	public function syncAssociedProtocols(){
		
		$objPHPExcel = $this->loadXlsFile("C:\\Users\\sprigent\\Desktop\\anticorps_h2p2\\ac_17-03.xls");
		
		$modelProto = new AcProtocol();
		//$modelProto->addManualProtocol();
		// add Anticorps
		$curentLine = 3;
		while ($curentLine <= 28){
		
			$kit = $objPHPExcel->getActiveSheet()->getCell("I".$curentLine."")->getValue();
			$no_proto = $objPHPExcel->getActiveSheet()->getCell("J".$curentLine."")->getValue();
			$proto = $objPHPExcel->getActiveSheet()->getCell("K".$curentLine."")->getValue();
			$fixative = $objPHPExcel->getActiveSheet()->getCell("L".$curentLine."")->getValue();
			$option = $objPHPExcel->getActiveSheet()->getCell("M".$curentLine."")->getValue();
			$enzyme = $objPHPExcel->getActiveSheet()->getCell("N".$curentLine."")->getValue();
			$dem = $objPHPExcel->getActiveSheet()->getCell("O".$curentLine."")->getValue();
			$acl_inc = $objPHPExcel->getActiveSheet()->getCell("P".$curentLine."")->getValue();
			$linker = $objPHPExcel->getActiveSheet()->getCell("R".$curentLine."")->getValue();
			$inc = $objPHPExcel->getActiveSheet()->getCell("Q".$curentLine."")->getValue();
			$acll = $objPHPExcel->getActiveSheet()->getCell("T".$curentLine."")->getValue();
			$inc2 = $objPHPExcel->getActiveSheet()->getCell("U".$curentLine."")->getValue();
				
				
			if(!$kit){
				$kit = "";
			}
			if(!$no_proto){
				$no_proto = 0;
			}
			if(!$proto){
				$proto = "";
			}
			if(!$fixative){
				$fixative = "";
			}
			if(!$option){
				$option = "";
			}
			if(!$enzyme){
				$enzyme = "";
			}
			if(!$dem){
				$dem = "";
			}
			if(!$acl_inc){
				$acl_inc = "";
			}
			if(!$linker){
				$linker = "";
			}
			if(!$inc){
				$inc = "";
			}
			if(!$acll){
				$acll = "";
			}
			if(!$inc2){
				$inc2 = "";
			}
				
			$associed = 1;	
			
			$add = true;
			if ($kit == "" || $kit == "KIT "){
				$add = false;
			}
			if($modelProto->existsProtocol($kit, $no_proto)){
				$add = false;
			}
			
			if($add){
				$modelProto->addProtocol($kit, $no_proto, $proto, $fixative, $option, $enzyme, $dem, $acl_inc, $linker, $inc, $acll, $inc2, $associed);
			}
			$curentLine++;
		}
	}
	
	public function syncGeneralProtocols(){
	
		$objPHPExcel = $this->loadXlsFile("C:\\Users\\sprigent\\Desktop\\anticorps_h2p2\\ac_17-03.xls");
	
		$modelProto = new AcProtocol();
		// add Anticorps
		$curentLine = 31;
		while ($curentLine <= 154){
	
			$kit = $objPHPExcel->getActiveSheet()->getCell("I".$curentLine."")->getValue();
			$no_proto = $objPHPExcel->getActiveSheet()->getCell("J".$curentLine."")->getValue();
			$proto = $objPHPExcel->getActiveSheet()->getCell("K".$curentLine."")->getValue();
			$fixative = $objPHPExcel->getActiveSheet()->getCell("L".$curentLine."")->getValue();
			$option = $objPHPExcel->getActiveSheet()->getCell("M".$curentLine."")->getValue();
			$enzyme = $objPHPExcel->getActiveSheet()->getCell("N".$curentLine."")->getValue();
			$dem = $objPHPExcel->getActiveSheet()->getCell("O".$curentLine."")->getValue();
			$acl_inc = $objPHPExcel->getActiveSheet()->getCell("P".$curentLine."")->getValue();
			$linker = $objPHPExcel->getActiveSheet()->getCell("R".$curentLine."")->getValue();
			$inc = $objPHPExcel->getActiveSheet()->getCell("Q".$curentLine."")->getValue();
			$acll = $objPHPExcel->getActiveSheet()->getCell("T".$curentLine."")->getValue();
			$inc2 = $objPHPExcel->getActiveSheet()->getCell("U".$curentLine."")->getValue();
	
	
			if(!$kit){
				$kit = "";
			}
			if(!$no_proto){
				$no_proto = 0;
			}
			if(!$proto){
				$proto = "";
			}
			if(!$fixative){
				$fixative = "";
			}
			if(!$option){
				$option = "";
			}
			if(!$enzyme){
				$enzyme = "";
			}
			if(!$dem){
				$dem = "";
			}
			if(!$acl_inc){
				$acl_inc = "";
			}
			if(!$linker){
				$linker = "";
			}
			if(!$inc){
				$inc = "";
			}
			if(!$acll){
				$acll = "";
			}
			if(!$inc2){
				$inc2 = "";
			}
	
			$associed = 0;
			$add = true;
			if ($kit == "" || $kit == "KIT "){
				$add = false;
			}
			if($modelProto->existsProtocol($kit, $no_proto)){
				$add = false;
			}
			
			if($add){
				$modelProto->addProtocol($kit, $no_proto, $proto, $fixative, $option, $enzyme, $dem, $acl_inc, $linker, $inc, $acll, $inc2, $associed);
			}
			$curentLine++;
		}
	}
	
	public function syncAssociedAnticorps(){
	
		$objPHPExcel = $this->loadXlsFile("C:\\Users\\sprigent\\Desktop\\anticorps_h2p2\\ac_17-03.xls");
	
		$modelAc = new Anticorps();
		$modelTissus = new Tissus();
		$modelEspece = new Espece();
		$modelOrgane = new Organe();
		$modelSource = new Source();
		
		// add Anticorps
		$curentLine = 3;
		while ($curentLine <= 28){
	
			$name = $objPHPExcel->getActiveSheet()->getCell("A".$curentLine."")->getValue();
			$no_h2p2 = $objPHPExcel->getActiveSheet()->getCell("B".$curentLine."")->getValue();
			$fournisseur = $objPHPExcel->getActiveSheet()->getCell("C".$curentLine."")->getValue();
			$source = $objPHPExcel->getActiveSheet()->getCell("D".$curentLine."")->getValue();
			
	
			if(!$name){
				$name = "";
			}
	
			$reference = "";
			$clone = "";
			$lot = "";
			$id_isotype = 1; 
			$stockage = "";

			if($source == "Ms"){
				$source = "Mouse";
			}
			elseif($source == "Rb"){
				$source = "Rabbit";
			}
			
			$id_source = $modelSource->getIdFromName($source);
			
			if ($name != ""){
				
				
				if (!$modelAc->isAnticorps($no_h2p2)){
					$modelAc->addAnticorps($name, $no_h2p2, $fournisseur, $id_source, $reference, $clone, $lot, $id_isotype, $stockage);
				}
				// assicaite proto/tussus
				$no_proto = $objPHPExcel->getActiveSheet()->getCell("J".$curentLine."")->getValue();
				$tissus_cible = $objPHPExcel->getActiveSheet()->getCell("E".$curentLine."")->getValue();
				$organe = $objPHPExcel->getActiveSheet()->getCell("F".$curentLine."")->getValue();
				$validation = $objPHPExcel->getActiveSheet()->getCell("H".$curentLine."")->getValue();
				
				if ($validation == "validé"){
					$validation = 1;
				}
				elseif ($validation == "non validé" || $validation == "ne marche pas"){
					$validation = 2;
				}
				else{
					$validation = 3;
				}
				
				
				$tissus_cible_es = explode("_", $tissus_cible);
				if (count($tissus_cible_es) == 0){
					$tissus_cible_es = array();
					$tissus_cible_es[0] = $tissus_cible;
				}
				foreach ( $tissus_cible_es as $tissus_cible_e ){
					if ($tissus_cible_e == "Ms"){
						$tissus_cible_e = "Mouse";
					}
					elseif ($tissus_cible_e == "Hu"){
						$tissus_cible_e = "Human";
					}
					
					$id_anticorps = $modelAc->getAnticorpsIdFromNoH2p2($no_h2p2); // get id from $no_h2p2
					$espece = $modelEspece->getIdFromName($tissus_cible_e); // get id from $tissus_cible_e
					$organe = $modelOrgane->getIdFromName($organe); // get id from $organe
					$status = $validation;
					$ref_bloc = "";
					$dilution = $objPHPExcel->getActiveSheet()->getCell("P".$curentLine."")->getValue();
					$temps_incubation = $objPHPExcel->getActiveSheet()->getCell("U".$curentLine."")->getValue();
					$ref_protocol = $objPHPExcel->getActiveSheet()->getCell("J".$curentLine."")->getValue();
					if(!$ref_protocol){
						$ref_protocol = 0;
					}
					if(!$dilution){
						$dilution = "";
					}
					if(!$temps_incubation){
						$temps_incubation = "";
					}
					
				
					$modelTissus->addTissus($id_anticorps[0], $espece, $organe, $status, $ref_bloc, $dilution, $temps_incubation, $ref_protocol);	
				}
			}
			$curentLine++;
		}
	}
	
	public function syncProtocols($objPHPExcel){
	
		// active sheet to protocols
		
		$objPHPExcel->setActiveSheetIndex(1);
		
		// models
		$modelProto = new AcProtocol();
		$modelOrgane = new Organe();
		
		// add organes
		$curentLine = 2;
		$column = "D";
		while ($curentLine <= 70){
				
			// get units
			$organeName = $objPHPExcel->getActiveSheet()->getCell("".$column.$curentLine."")->getValue();
			if ($modelOrgane->getIdFromName($organeName) == 0){
				$modelOrgane->addOrgane($organeName);
			}
			$curentLine++;
		}
		// add Anticorps
		$curentLine = 2;
		while ($curentLine <= 70){
		
			// get units
			
			$kit = $objPHPExcel->getActiveSheet()->getCell("F".$curentLine."")->getValue();
			$no_proto = $objPHPExcel->getActiveSheet()->getCell("B".$curentLine."")->getValue();
			$proto = $objPHPExcel->getActiveSheet()->getCell("H".$curentLine."")->getValue();
			$fixative = $objPHPExcel->getActiveSheet()->getCell("I".$curentLine."")->getValue();
			$option = $objPHPExcel->getActiveSheet()->getCell("J".$curentLine."")->getValue();
			$enzyme = $objPHPExcel->getActiveSheet()->getCell("K".$curentLine."")->getValue();
			$dem = $objPHPExcel->getActiveSheet()->getCell("L".$curentLine."")->getValue();
			$acl_inc = $objPHPExcel->getActiveSheet()->getCell("M".$curentLine."")->getValue();
			$linker = $objPHPExcel->getActiveSheet()->getCell("O".$curentLine."")->getValue();
			$inc = $objPHPExcel->getActiveSheet()->getCell("P".$curentLine."")->getValue();
			$acll = $objPHPExcel->getActiveSheet()->getCell("Q".$curentLine."")->getValue();
			$inc2 = $objPHPExcel->getActiveSheet()->getCell("R".$curentLine."")->getValue();
			
			
			if(!$kit){
				$kit = "";
			}
			if(!$no_proto){
				$no_proto = "";
			}
			if(!$proto){
				$proto = "";
			}
			if(!$fixative){
				$fixative = "";
			}
			if(!$option){
				$option = "";
			}
			if(!$enzyme){
				$enzyme = "";
			}
			if(!$dem){
				$dem = "";
			}
			if(!$acl_inc){
				$acl_inc = "";
			}
			if(!$linker){
				$linker = "";
			}
			if(!$inc){
				$inc = "";
			}
			if(!$acll){
				$acll = "";
			}
			if(!$inc2){
				$inc2 = "";
			}
			
			
			
			$modelProto->addProtocol($kit, $no_proto, $proto, $fixative, $option, $enzyme, $dem, $acl_inc, $linker, $inc, $acll, $inc2);
			$curentLine++;
		}
	}
	
	public function filterIsotype($isotypeName){
		if (!$isotypeName){
			$isotypeName = "--";
		}
		if( $isotypeName == "IgG2b-k" || $isotypeName == "IgG2b,kappa " ){
			$isotypeName = "IgG2b-kappa";
		}
		if( $isotypeName == "IgG1-K" || $isotypeName == "IgG1-k" || $isotypeName == "IgG1-ka" || $isotypeName == "IgG1-Ka"
			|| $isotypeName == "IgG1 Kappa" || $isotypeName == "IgG1-k"	|| $isotypeName == "IgG1- K" 
			|| $isotypeName == "IgG1 Kappa " || $isotypeName == " IgG1 Kappa" || $isotypeName == "IgG1kappa"){
			$isotypeName = "IgG1-Kappa";
		}
		if( $isotypeName == "IgG2-K" || $isotypeName == "IgG2-k" || $isotypeName == "IgG2-ka" || $isotypeName == "IgG2-Ka" 
			 || $isotypeName == "IgG2-aK" || $isotypeName == "IgG2a, kappa" || $isotypeName == "IgG1κ" ){
			$isotypeName = "IgG2-Kappa";
		}
		if($isotypeName == "IgG2a-k" || $isotypeName == "IgG2a-K"){
			$isotypeName = "IgG2a-Kappa";
		}
		return $isotypeName;
	}
	
	public function filterSource($sourceName){
		if (!$sourceName){
			$sourceName = "--";
		}
		if( $sourceName == "Rabbit/Goat" || $sourceName == "rabbitt" || $sourceName == "Rabbit" || $sourceName == "rabbit"){
			$sourceName = "Rabbit";
		}
		if( $sourceName == "mouse" || $sourceName == "Mouse" || $sourceName == "IgG2-ka" || $sourceName == "IgG2-Ka" ){
			$sourceName = "Mouse";
		}
		return $sourceName;
	}
	
	public function filterEspece($tissus_cible_e){
		
		if ($tissus_cible_e == "Ms"){
			$tissus_cible_e = "Mouse";
		}
		elseif ($tissus_cible_e == "Hu"){
			$tissus_cible_e = "Human";
		}
		return $tissus_cible_e;
	}
	
	public function syncAnticorps1203(){
	
		// active sheet to protocols
	
		$objPHPExcel = $this->loadXlsFile("C:\\Users\\sprigent\\Desktop\\anticorps_h2p2\\ListingAc12-03.xls");
		$objPHPExcel->setActiveSheetIndex(0);
	
		// models
		$modelAnticorps = new Anticorps();
		$modelSource = new Source();
		$modelIsotype = new Isotype();
		
		// add Isotype
		$curentLine = 2;
		$column = "F";
		while ($curentLine <= 458){
		
			// get source
			$isotypeName = $objPHPExcel->getActiveSheet()->getCell("".$column.$curentLine."")->getValue();
			
			$isotypeName = $this->filterIsotype($isotypeName);
			if ($modelIsotype->getIdFromName($isotypeName) == 0){
				$modelIsotype->addIsotype($isotypeName);
			}
			$curentLine++;
		}
		
		echo "anticorps";
		// add Anticorps
		$curentLine = 2;
		while ($curentLine <= 458){
	
			// get units
			$nom = $objPHPExcel->getActiveSheet()->getCell("A".$curentLine."")->getValue();
			$no_h2p2 = $objPHPExcel->getActiveSheet()->getCell("B".$curentLine."")->getValue();
			$fournisseur = $objPHPExcel->getActiveSheet()->getCell("C".$curentLine."")->getValue();
			$id_source = $objPHPExcel->getActiveSheet()->getCell("D".$curentLine."")->getValue();
			$reference = $objPHPExcel->getActiveSheet()->getCell("H".$curentLine."")->getValue();
			$clone = $objPHPExcel->getActiveSheet()->getCell("E".$curentLine."")->getValue();
			$lot = $objPHPExcel->getActiveSheet()->getCell("G".$curentLine."")->getValue();
			$id_isotype = $objPHPExcel->getActiveSheet()->getCell("F".$curentLine."")->getValue();
			$stockage = $objPHPExcel->getActiveSheet()->getCell("I".$curentLine."")->getValue();
			
			if(!$nom){
				$nom = "";
			}
			if(!$no_h2p2){
				$no_h2p2 = "";
			}
			if(!$fournisseur){
				$fournisseur = "";
			}
			if(!$id_source){
				$id_source = "--";
			}
			$id_source = $this->filterSource($id_source);
			$id_source = $modelSource->getIdFromName($id_source);
			if($id_source == 0){
				$id_source = 1;
			}
			if(!$reference){
				$reference = "";
			}
			if(!$clone){
				$clone = "";
			}
			if(!$lot){
				$lot = "";
			}
			if(!$id_isotype){
				$id_isotype = "--";
			}
			$id_isotype = $this->filterIsotype($id_isotype);
			$id_isotype = $modelIsotype->getIdFromName($id_isotype);
			if($id_isotype == 0){
				$id_isotype = 1;
			}
			if(!$stockage){
				$stockage = "";
			}
			
			if (!$modelAnticorps->isAnticorps($no_h2p2)){
				$modelAnticorps->addAnticorps($nom, $no_h2p2, $fournisseur, $id_source, $reference, $clone, $lot, $id_isotype, $stockage);
			}
			$curentLine++;
		}
	}
	
	public function syncAnticorpsTissusProprio1203(){
	
		// active sheet to protocols
	
		$objPHPExcel = $this->loadXlsFile("C:\\Users\\sprigent\\Desktop\\anticorps_h2p2\\ListingAc12-03.xls");
		$objPHPExcel->setActiveSheetIndex(0);
	
		// models
		$modelAnticorps = new Anticorps();
		$modelSource = new Source();
		$modelIsotype = new Isotype();
		$modelTissus = new Tissus();
		$modelEspece = new Espece();
		$modelUser = new CoreUser();
	
		// add Isotype
		$curentLine = 2;
		$column = "F";
		while ($curentLine <= 458){
			
			// get tissus info from xls
			$no_h2p2 = $objPHPExcel->getActiveSheet()->getCell("B".$curentLine."")->getValue();
			if (!$no_h2p2){$no_h2p2 = "";}
			$id_anticorps = $modelAnticorps->getAnticorpsIdFromNoH2p2($no_h2p2);
			
			$tissus_especeValide = $objPHPExcel->getActiveSheet()->getCell("K".$curentLine."")->getValue();
			if (!$tissus_especeValide){$tissus_especeValide = "";}
			$espece = $modelEspece->getIdFromName($this->filterEspece($tissus_especeValide));
			
			$tissus_status = 1;
			$tissus_dilution = $objPHPExcel->getActiveSheet()->getCell("S".$curentLine."")->getValue();
			if (!$tissus_dilution){$tissus_dilution = "";}
			$tissus_tmp_inc = $objPHPExcel->getActiveSheet()->getCell("T".$curentLine."")->getValue();
			if (!$tissus_tmp_inc){$tissus_tmp_inc = "";}	
			
			$resp = $objPHPExcel->getActiveSheet()->getCell("V".$curentLine."")->getValue();
			if (!$resp){$resp = "";}
			$respID = $modelUser->findFromAC($resp); 
			
			// add tissus
			$organe = 1;
			$ref_bloc = "";
			$ref_protocol = 0;
			//print_r($id_anticorps);
			if ($id_anticorps[0] > 0){
				$modelTissus->addTissus($id_anticorps[0], $espece, $organe, $tissus_status, $ref_bloc, $tissus_dilution, $tissus_tmp_inc, $ref_protocol);
			
				// add propriétaire
				if ($respID > 0){
					$modelAnticorps->addOwner($respID, $id_anticorps[0], "", 1, "");
				}
			}
			$curentLine++;
		}
	}
}
?>