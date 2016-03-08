<?php

require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/biblio/Model/PublicationManager.php';
require_once 'Modules/biblio/Model/Author.php';
require_once 'Modules/biblio/Model/Journal.php';
require_once 'Modules/biblio/Model/Conference.php';



class ControllerBiblio extends ControllerSecureNav {

	public function index() {
		// view
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,

		) );
	}
	
	public function uploadFile($fileToUpload, $target_file){
		
		$uploadOk = 1;
		
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			return  "Error: your file was not uploaded.";
			// if everything is ok, try to upload file
		} else {
			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
				return  "The file template file". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
			} else {
				return "Error, there was an error uploading your file.";
			}
		}
	
	}
	
	public function editpublication() {
		
		$id = "";
		if ($this->request->isParameterNotEmpty('actionid')){
			$id = $this->request->getParameter("actionid");
		}
		
		if ($id == ""){
			throw "unable to edit publication";
		}
		
		$id_array = explode("_", $id);	
		// get publicatio info
		$modelPubliManager = new PublicationManager();
		$pubicationInfos = array(); 
		if ($id_array[0] == "type"){
			$pubicationInfos = $modelPubliManager->defaultInfo($id_array[1]); 
		}
		else if ($id_array[0] == "id"){
			$pubicationInfos = $modelPubliManager->getPubliInfo($id_array[1]);
		}
		
		// data
		$authorsModel = new Author();
		$authors = $authorsModel->authors();
		
		$journalsModel = new Journal();
		$journals = $journalsModel->journals();
		
		$confModel = new Conference();
		$conferences = $confModel->Conferences();
		
		// view
		$navBar = $this->navBar();
		$this->generateView ( array (
				'authors' => $authors,
				'journals' => $journals,
				'conferences' => $conferences,
				'pubicationInfos' => $pubicationInfos,
				'navBar' => $navBar
		) );
	}
	
	public function editpublicationquery(){
		
		// get data
		$id_entry = $this->request->getParameterNoException('id');
		$type_name = $this->request->getParameterNoException('type_name');
		$title = $this->request->getParameterNoException('title');
		$auth_name = $this->request->getParameterNoException('auth_name');
		$auth_firstname = $this->request->getParameterNoException('auth_firstname');
		$auth_id = $this->request->getParameterNoException('auth_id');
		$year = $this->request->getParameterNoException('year');
		$month = $this->request->getParameterNoException('month');
		$note = $this->request->getParameterNoException('note');
		$fileToUpload = $this->request->getParameterNoException('fileToUpload');
		
		// journal
		$journal = $this->request->getParameterNoException('journal');
		$journal_id = $this->request->getParameterNoException('journal_id');	
		$volume = $this->request->getParameterNoException('volume');
		$pages = $this->request->getParameterNoException('pages');
		
		// misc
		$howpublished = $this->request->getParameterNoException('howpublished');
		
		// in book
		$chapter = $this->request->getParameterNoException('chapter');
		$publisher = $this->request->getParameterNoException('publisher');
		$series = $this->request->getParameterNoException('series');
		$address = $this->request->getParameterNoException('address');
		$edition = $this->request->getParameterNoException('edition');
		
		// conference
		$conference = $this->request->getParameterNoException('conference');
		$conference_id = $this->request->getParameterNoException('conference_id');
		echo "conference_id = " . $conference_id . "</br>";
		
		// book
		$publisher = $this->request->getParameterNoException('publisher');
		$series = $this->request->getParameterNoException('series');
		$isbn = $this->request->getParameterNoException('isbn');
		
		
		$pubicationInfos = array(
				'id' => $id_entry,
				'type_name' => $type_name,
				'title' => $title,
				'auth_name' => $auth_name,
				'auth_firstname' => $auth_firstname,
				'auth_id' => $auth_id,
				'journal' => $journal,
				'journal_id' => $journal_id,
				'year' => $year,
				'month' => $month,
				'volume' => $volume,
				'pages' => $pages,
				'note' => $note,
				'fileToUpload' => $fileToUpload, 

				'howpublished' => $howpublished,
				
				'chapter' => $chapter,
				'publisher' => $publisher,
				'series' => $series,
				'address' => $address,
				'edition' => $edition,
				
				'conference' => $conference,
				'conference_id' => $conference_id,
				
				'publisher' => $publisher,
				'series' => $series,
				'address' => $address,
				'isbn' => $isbn
		);
		
		// register entry
		$message = "Success: The publication has been added to the database !";
		try{
			$modelPubliManager = new PublicationManager();
			$modelPubliManager->editPublication($pubicationInfos);
		}
		catch (Exception $e){
			$message = "Error: " . $e->getMessage();
		}
			
		// view
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'message' => $message
		
		), 'index' );
	}
	
	public function allpublications(){
		
		
		$model = new PublicationManager();
		$publications = $model->allPublicationsDesc();
		
		// view
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'publications' => $publications
				));
	}
	
	public function yearpublications(){
	
		$year = $this->request->getParameterNoException("year");
	
		$thisYear = date('Y', time());
		$years = array();
		for ($i = 2010 ; $i <= $thisYear ; $i++){
			$years[] = $i;
		}
		
		$publications = null;
		if ($year == ""){
			$year = $thisYear;
		}
		
		$model = new PublicationManager();
		$publications = $model->publicationsDescOfYear($year);
		
		$message = "";
		if (count($publications)==0){
			$message = "There are no publication in " . $year;
		}
	
		// view
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'years' => $years,
				'selectedYear' => $year,
				'publications' => $publications,
				'message' => $message
		));
	}
	
	public function typepublications(){
	
		$type = $this->request->getParameterNoException("type");
		$types = PublicationManager::entriesTypes();
		$publications = null;
		
	
		if ($type == ""){
		$tmp = PublicationManager::entriesTypes();
			$type = $tmp[0]; 
		}
		
		$model = new PublicationManager();
		$publications = $model->publicationsDescOfType($type);
	
		$message = "";
		if (count($publications)==0){
			$message = "There are no publication of type " . $type;
		}
	
		// view
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'types' => $types,
				'selectedType' => $type,
				'publications' => $publications,
				'message' => $message
		));
	}
	
	public function authorpublications(){
	
		$author_id = $this->request->getParameterNoException("author_id");
		
		if ($author_id == ""){
			$author_id = 1;
		}
		
		$authorsModel = new Author();
		$authors = $authorsModel->authors();
		$publications = null;
	
		$model = new PublicationManager();
		$publications = $model->publicationsDescOfAuthor($author_id);
	
		$message = "";
		if (count($publications)==0){
			$message = "There are no publication for this author";
		}
	
		// view
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'authors' => $authors,
				'curentAuthor' => $author_id,
				'publications' => $publications,
				'message' => $message
		));
	}
}
?>