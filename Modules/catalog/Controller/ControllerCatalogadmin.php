<?php

require_once 'Framework/Controller.php';
require_once 'Framework/Form.php';
require_once 'Framework/TableView.php';

require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/CoreTranslator.php';


require_once 'Modules/catalog/Model/CaTranslator.php';
require_once 'Modules/catalog/Model/CaCategory.php';
require_once 'Modules/catalog/Model/CaEntry.php';

class ControllerCatalogadmin extends ControllerSecureNav {

	public function index(){
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar
		) );
	}
	
	public function categories(){
		$navBar = $this->navBar ();
		
		$lang = $this->getLanguage();
		
		// get sort action
		$sortentry = "id";
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$sortentry = $this->request->getParameter ( "actionid" );
		}
		
		// get the user list
		$modelCategory = new CaCategory();
		$categoriesArray = $modelCategory->getAll();
		
		$table = new TableView();
		$table->setTitle(CaTranslator::Categories($lang));
		$table->addLineEditButton("catalogadmin/editcategory");
		$table->addDeleteButton("catalogadmin/deletecategory");
		$table->addPrintButton("catalogadmin/categories/");
		$tableHtml = $table->view($categoriesArray, array("id" => "ID", "name" => CoreTranslator::Name($lang), "display_order" => CoreTranslator::Display_order($lang)));
	
		if ($table->isPrint()){
			echo $tableHtml;
			return;
		}
		
		$this->generateView ( array (
				'navBar' => $navBar,
				'tableHtml' => $tableHtml
		) );
	}
	
	public function editcategory() {
		
		// get action
		$id = 0;
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$id = $this->request->getParameter ( "actionid" );
		}
		
		$lang = $this->getLanguage();
		
		// get name
		$name = "";
                $display_order = 0;
		$modelCategory = new CaCategory();
		if ($id > 0){
			$name = $modelCategory->getName($id);
                        $display_order = $modelCategory->getDisplayOrder($id);
		}
		
		// build the form
		$form = new Form($this->request, "formcategories");
		$form->setTitle(CaTranslator::Category($lang));
		$form->addHidden("id", $id);
		$form->addText("name", "name", true, $name);
                $form->addText("display_order", CoreTranslator::Display_order($lang), true, $display_order);
		$form->setValidationButton("Ok", "catalogadmin/editcategory/".$id);
		$form->setCancelButton(CoreTranslator::Cancel($lang), "catalogadmin/categories");
		
		if ($form->check()){
			if ($id > 0){
				$modelCategory->edit($form->getParameter("id"), $form->getParameter("name"), $form->getParameter("display_order"));
			}
			else{
				$modelCategory->add($form->getParameter("name"), $form->getParameter("display_order"));
			}
			
			$this->redirect("catalogadmin","categories");
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
	
	/**
	 * Remove a category from the database
	 */
	public function deletecategory(){
	
		$id = $this->request->getParameter("actionid");
		$modelCategory = new CaCategory();
		$modelCategory->delete($id);
	
		// generate view
		$this->redirect("catalogadmin/categories");
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
		$modelEntry = new CaEntry();
		$dataArray = $modelEntry->getAll();
		$modelCategory = new CaCategory();
		for($i = 0 ; $i < count($dataArray) ; $i++){
			$dataArray[$i]["id_category"] = $modelCategory->getName($dataArray[$i]["id_category"]);
		}
		
		$table = new TableView();
		$table->setTitle(CaTranslator::Entries($lang));
		$table->addLineEditButton("catalogadmin/editentry", "id", "id");
		$table->addDeleteButton("catalogadmin/deleteentry", "id", "title");
		$table->addPrintButton("catalogadmin/entries/");
		$tableHtml = $table->view($dataArray, array("id" => "ID", "title" => CaTranslator::Title($lang), 
													"id_category" => CaTranslator::Category($lang), 
													"short_desc" => CaTranslator::Short_desc($lang)
		));
		
		$print = $this->request->getParameterNoException("print");
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
		$name = "";
		$modelEntry = new CaEntry();
		$entryInfo = array("title" => "", "id_category" => 0, "short_desc" => "", "full_desc" => "");
		if ($id > 0){
			$entryInfo = $modelEntry->getInfo($id);
		}
	
		// categories choices
		$modelCategory = new CaCategory();
		$categories = $modelCategory->getAll();
		$cchoices = array();
		$cchoicesid = array();
		foreach($categories as $cat){
			$cchoices[] = $cat["name"];
			$cchoicesid[] = $cat["id"];
		}
		
		// build the form
		$form = new Form($this->request, "formcategories");
		$form->setTitle(CaTranslator::Entry($lang));
		$form->addHidden("id", $id);
		$form->addText("title", CaTranslator::Title($lang), true, $entryInfo["title"]);
		$form->addSelect("id_category", CaTranslator::Category($lang), $cchoices, $cchoicesid, $entryInfo["id_category"]);
		$form->addTextArea("short_desc", CaTranslator::Short_desc($lang), false, $entryInfo["short_desc"]);
		//$form->addTextArea("full_desc", CaTranslator::Full_desc($lang), false, $entryInfo["full_desc"]);
		$form->addDownload("illustration", CaTranslator::Illustration($lang));
		$form->setValidationButton(CoreTranslator::Ok($lang), "catalogadmin/editentry/".$id);
		$form->setCancelButton(CoreTranslator::Cancel($lang), "catalogadmin/entries");
	
		if ($form->check()){
			$id_category = $form->getParameter("id_category");
			$title = $form->getParameter("title");
			$short_desc = $form->getParameter("short_desc");
			$full_desc = "";//$form->getParameter("full_desc");
			if ($id > 0){
				$modelEntry->edit($id, $id_category, $title, $short_desc, $full_desc);
			}
			else{
				$id = $modelEntry->add($id_category, $title, $short_desc, $full_desc);
			}
			
			//echo "file = " . $_FILES["illustration"]["name"] . "<br/>";
			if ($_FILES["illustration"]["name"] != ""){
				// download file
				$this->downloadIllustration();
				
				// set filename to database
				$modelEntry->setImageUrl($id, $_FILES["illustration"]["name"]);
			}
			$this->redirect("catalogadmin","entries");
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
		//$imageFileType = pathinfo($_FILES["illustration"]["name"],PATHINFO_EXTENSION);
		
		// Check file size
		if ($_FILES["illustration"]["size"] > 500000000) {
			return "Error: your file is too large.";
			//$uploadOk = 0;
		}
		// Allow certain file formats
		/*
		if($imageFileType != "jpg" || $imageFileType != "jpeg") {
			return "Error: only jpg files are allowed.";
			$uploadOk = 0;
		}
		*/
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
		$modelCategory = new CaEntry();
		$modelCategory->delete($id);
		
		// generate view
		$this->redirect("catalogadmin/entries");
	}
}