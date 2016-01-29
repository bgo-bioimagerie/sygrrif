<?php

require_once 'Framework/Controller.php';
require_once 'Framework/Form.php';
require_once 'Framework/TableView.php';

require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/CoreTranslator.php';

require_once 'Modules/catalog/Model/CaTranslator.php';
require_once 'Modules/catalog/Model/CaAntibodyEntry.php';

require_once 'Modules/anticorps/Model/Anticorps.php';

class ControllerCatalogantibodyadmin extends ControllerSecureNav {

	public function index(){
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar
		) );
	}
	
	public function entries(){
            
		$navBar = $this->navBar ();
		$lang = $this->getLanguage();
		
		// get sort action
		$sortentry = "id";
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$sortentry = $this->request->getParameter ( "actionid" );
		}
		
		// get the user list
		$modelEntry = new CaAntibodyEntry();
		$dataArray = $modelEntry->getAllInfo();
		
		$table = new TableView();
		$table->setTitle(CaTranslator::Antibodies($lang));
		$table->addLineEditButton("catalogantibodyadmin/editentry", "id", "id");
		$table->addDeleteButton("catalogantibodyadmin/deleteentry", "id", "nom");
		$table->addPrintButton("catalogantibodyadmin/entries/");
		$tableHtml = $table->view($dataArray, array("no_h2p2" => "No", 
                                                            "nom" => CaTranslator::Name($lang), 
							    "fournisseur" => CaTranslator::Provider($lang), 
						            "reference" => CaTranslator::Reference($lang),
                                                            "especes" => CaTranslator::Spices($lang),
                                                            "ranking" => CaTranslator::Ranking($lang),
                                                            "staining" => CaTranslator::Staining($lang),
		));
                
		//$print = $this->request->getParameterNoException("print");
		if ($table->isPrint()){
			echo $tableHtml;
			return;
		}
		
		$this->generateView ( array (
				'navBar' => $navBar,
				'tableHtml' => $tableHtml
		) );
	}
	
	public function editentry() {
	
		// get action
		$id = 0;
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$id = $this->request->getParameter ( "actionid" );
		}
	
		$lang = $this->getLanguage();
	
		// get name
		$modelEntry = new CaAntibodyEntry();
		$entryInfo = array("title" => "", "id_antibody" => 0, "ranking" => "", "staining" => "");
		if ($id > 0){
			$entryInfo = $modelEntry->getInfo($id);
		}
	
		// categories choices
		$modelAntibodies = new Anticorps();
		$antibodies = $modelAntibodies->getAnticorps("nom");
		$cchoices = array();
		$cchoicesid = array();
		foreach($antibodies as $antib){
			$cchoices[] = $antib["nom"];
			$cchoicesid[] = $antib["id"];
		}
		
		// build the form
		$form = new Form($this->request, "formantibodies");
		$form->setTitle(CaTranslator::Antibodies($lang));
		$form->addHidden("id", $id);
		$form->addSelect("id_antibody", CaTranslator::Antibody($lang), $cchoices, $cchoicesid, $entryInfo["id_antibody"]);
		$form->addText("ranking", CaTranslator::Ranking($lang), false, $entryInfo["ranking"]);
                $form->addText("staining", CaTranslator::Staining($lang), false, $entryInfo["staining"]);
		$form->addDownload("illustration", CaTranslator::Illustration($lang));
		$form->setValidationButton(CoreTranslator::Ok($lang), "catalogantibodyadmin/editentry/".$id);
		$form->setCancelButton(CoreTranslator::Cancel($lang), "catalogantibodyadmin/entries");
	
		if ($form->check()){
			$id_antibody = $form->getParameter("id_antibody");
			$ranking = $form->getParameter("ranking");
                        $staining = $form->getParameter("staining");
			if ($id > 0){
				$modelEntry->edit($id, $id_antibody, $ranking, $staining);
			}
			else{
				$id = $modelEntry->add($id_antibody, $ranking, $staining);
			}
			
			//echo "file = " . $_FILES["illustration"]["name"] . "<br/>";
			if ($_FILES["illustration"]["name"] != ""){
				// download file
				$this->downloadIllustration();
				
				// set filename to database
				$modelEntry->setImageUrl($id, $_FILES["illustration"]["name"]);
			}
			$this->redirect("catalogantibodyadmin","entries");
		}
		else{
			// set the view
			$formHtml = $form->getHtml();
			// view
			$navBar = $this->navBar();
			$this->generateView ( array (
					'navBar' => $navBar,
					'formHtml' => $formHtml
			) );
		}
	}
	
	protected function downloadIllustration(){
		$target_dir = "data/catalog/";
		$target_file = $target_dir . $_FILES["illustration"]["name"];
		//echo "target file = " . $target_file . "<br/>";
		$uploadOk = 1;

		// Check file size
		if ($_FILES["illustration"]["size"] > 500000000) {
			return "Error: your file is too large.";
			//$uploadOk = 0;
		}
                
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			return  "Error: your file was not uploaded.";
			// if everything is ok, try to upload file
		} else {
			if (move_uploaded_file($_FILES["illustration"]["tmp_name"], $target_file)) {
				return  "The file logo file". basename( $_FILES["illustration"]["name"]). " has been uploaded.";
			} else {
				return "Error, there was an error uploading your file.";
			}
		}
	}
	
	public function deleteentry(){
		$id = $this->request->getParameter("actionid");
		$modelCategory = new CaAntibodyEntry();
                $modelCategory->delete($id);

		$this->redirect("catalogantibodyadmin/entries");
	}
}