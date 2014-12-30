<?php

require_once 'Framework/Model.php';
require_once 'Modules/biblio/Model/EntriesArticle.php';
require_once 'Modules/biblio/Model/EntriesBook.php';
require_once 'Modules/biblio/Model/EntriesConference.php';
require_once 'Modules/biblio/Model/EntriesInBook.php';
require_once 'Modules/biblio/Model/EntriesMisc.php';
require_once 'Modules/biblio/Model/Publication.php';
require_once 'Modules/biblio/Model/AuthorPubli.php';

/**
 * Class defining methods to query on publications
 *
 * @author Sylvain Prigent
 */
class PublicationManager extends Model {
	
	
	static function entriesTypes(){
		$entry[0] = "Article";
		$entry[1] = "Book";
		$entry[2] = "Conference";
		$entry[3] = "InBook";
		$entry[4] = "Misc";
		return $entry; 
	}
	
	public function defaultInfo($type_name){
		
		$pubicationInfos['type_name'] = $type_name;
		$pubicationInfos['title'] = "";
		$pubicationInfos['month'] = "";
		$pubicationInfos['year'] = "";
		$pubicationInfos['note'] = "";
	
		$modelName = "Entries" . $type_name; 
		$model = new $modelName();
		$sinfo = $model->defaultEntry(); 
		
		return array_merge($pubicationInfos, $sinfo);
	}
	
	public function getPubliInfo($publi_id){
		// general info
		$modelpubli = new Publication();
		$ginfo = $modelpubli->getPublication($publi_id);
		
		// author
		$modelAuth = new AuthorPubli();
		$ginfo['authors_id'] = $modelAuth->getAuthorsForPubli($publi_id);
		
		// specific info
		$modelName = "Entries" . $ginfo['type_name'];
		$model = new $modelName();
		$sinfo = $model->getEntry($publi_id);
		
		return array_merge($ginfo, $sinfo);
	}
	
	public function editPublication($pubicationInfos){
		
		// common info
		$pubicationInfos = $this->editCommonInfo($pubicationInfos);
		
		$modelName = "Entries" . $pubicationInfos['type_name']; 
		$model = new $modelName();
		$model->editEntry($pubicationInfos);
	}
	
	private function editCommonInfo($pubicationInfos){
		
		// infos
		$auth_name = $pubicationInfos["auth_name"];
		$auth_firstname = $pubicationInfos["auth_firstname"]; 
		$auth_id = $pubicationInfos["auth_id"];
		$id = $pubicationInfos["id"];
		$fileToUpload = $pubicationInfos["fileToUpload"];
		$title = $pubicationInfos["title"];
		$month = $pubicationInfos["month"];
		$year = $pubicationInfos["year"];
		$note = $pubicationInfos["note"];
		$type_name = $pubicationInfos["type_name"];
		
		// get the authors id list, and add user to database
		$autho_list = array();
		$modelAuth = new Author();
		for ($i = 0 ; $i < count($auth_name) ; $i++){
			if ($auth_id[$i] > 0 ){
				$autho_list[] = $auth_id[$i];
			}
			else{
				$ida = $modelAuth->addAuthor($auth_name[$i], $auth_firstname[$i]);
				$autho_list[] = $ida;
			}
		}
		
		// add the publication
		$modelPubli = new Publication();
		$publi_id = $id;
		if ($id == ""){
			//echo "add publi title = " . $title . "</br>";
			$publi_id = $modelPubli->addPublication($type_name, $title, $month, $year, $note);
		}
		else{
			$modelPubli->updatePublication($publi_id, $type_name, $title, $month, $year, $note);
		}
		
		// authors links
		$modelConnect = new AuthorPubli();
		$modelConnect->removeAllAuthors($publi_id);
		for($i = 0 ; $i < count($autho_list) ; $i++){
			$modelConnect->setJointAuthorPubli($publi_id, $autho_list[$i], $i+1);
		}

		// file
		//echo "file to upload = </br>";
		//print_r($_FILES["fileToUpload"]);
		if ($_FILES["fileToUpload"]["name"] != ""){
			// file url
			$firstauthorname = $modelAuth->getAuthor($autho_list[0])["name"];
			$fileType = pathinfo($_FILES["fileToUpload"]["name"],PATHINFO_EXTENSION);
			$target_dir = "data/biblio/";
			$target_file = $target_dir . $publi_id . "_" . $year . "." . $fileType;
			$modelPubli->setPublicationURL($publi_id, $target_file);
		
			// save the publication file
			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			} else {
				throw new Exception("Error, there was an error uploading your file.");
			}
		}
		
		$pubicationInfos["publi_id"] = $publi_id;
		return $pubicationInfos;
	}
	
	public function allPublicationsDesc(){
		
		$modelG = new Publication();
		$publications = $modelG->allPublications();
		$descs = array();
		foreach ($publications as $publi){
			//print_r($publi);
			$descs[] = $this->getPubliDescription($publi);
		}
		return $descs;
	}
	
	public function publicationsDescOfYear($year){
	
		$modelG = new Publication();
		$publications = $modelG->publicationsOfYear($year);
		$descs = array();
		foreach ($publications as $publi){
			$descs[] = $this->getPubliDescription($publi);
		}
		return $descs;
	}
	
	public function publicationsDescOfType($typeName){
	
		$modelG = new Publication();
		$publications = $modelG->publicationsOfType($typeName);
		$descs = array();
		foreach ($publications as $publi){
			$descs[] = $this->getPubliDescription($publi);
		}
		return $descs;
	}
	
	public function publicationsDescOfAuthor($author_id){
	
		$modelG = new Publication();
		$publications = $modelG->publicationsOfAuthor($author_id);
		$descs = array();
		foreach ($publications as $publi){
			$descs[] = $this->getPubliDescription($publi);
		}
		//echo "return desc </br>";
		return $descs;
	}
	
	private function getPubliDescription($publi){
		$id_publi = $publi['id'];
		
		//echo "title = " . $publi['title'] . "</br>";
		$publiDesc = "";
			
		// get title
		$publiDesc .= "<b>" . $publi['title'] . "</b></br>";
			
		//echo "get author </br>";
		// get the author list
		$modelAuthor = new AuthorPubli();
		$authIDS = $modelAuthor->getAuthorsForPubli($id_publi);
		//print_r($authIDS);
		$modelAuthor = new Author();
		//echo "get author for loop </br>";
		foreach ($authIDS as $Aid){
			$auth = $modelAuthor->getAuthor($Aid[0]);
			$publiDesc .= $auth['firstname'] . " " . $auth['name']. ", ";
		}
		$publiDesc .= "</br>";
			
		//echo "aithor done </br>";
		
		$modelName = "Entries" . $publi['type_name'];
		$model = new $modelName();
		$publiDesc .= $model->getDescription($id_publi);
			
		$publiDesc .= ", " . monthShortNames($publi['month']) . ", " . $publi['year'];
		//echo "publi description = " . $publiDesc . "</br>";
		return array('desc' => $publiDesc, 'id' => $id_publi, 'url' => $publi['url']);
	}
}

?>