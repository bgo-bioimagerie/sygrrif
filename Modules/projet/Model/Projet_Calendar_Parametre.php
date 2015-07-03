<?php


require_once 'Framework/Model.php';
require_once 'Modules/sygrrif/Controller/ControllerSygrrifconfig.php';
/**
 * Class defining the booking settings model
 *
 * @author Sylvain Prigent
 */
class Projet_Calendar_Parametre extends Model {

	
	/**
	 * Create the booking settings entry table
	 *
	 * @return PDOStatement
	 */
	public function createTable(){
			
		$sql = "CREATE TABLE IF NOT EXISTS `projet_calendar_parametre` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`tag_name` varchar(100) NOT NULL,
		`is_visible` int(1) NOT NULL,			
		`is_tag_visible` int(1) NOT NULL,
		`display_order` int(5) NOT NULL,
		`font` varchar(20) NOT NULL,									
		PRIMARY KEY (`id`)
		);";

		$pdo = $this->runRequest($sql);
		return $pdo;
	}
	
	
	public function defaultEntries(){
		$this->setEntry("User", 1, 1, 1, "normal");
		$this->setEntry("Acronyme", 1, 1, 1, "normal");
		$this->setEntry("Numéro de visite", 1, 1, 2, "normal");
		$this->setEntry("Code d'anonymation", 1, 1, 3, "normal");
		$this->setEntry("Commentaire", 0, 0, 4, "normal");
	}
	
	public function entries($sortEntry = "id"){
		
		try{
		//if ($this->isTable("sy_booking_settings")){
			$sql="select * from projet_calendar_parametre order by " . $sortEntry;
			$req = $this->runRequest($sql);
			return $req->fetchAll();
		//}
		//else{
		//	return "";
		//}
		}
		catch (Exception $e){
			return "";
		}
	}
	
	public function addEntry($tag_name, $is_visible, $is_tag_visible, 
			                 $display_order, $font){
		$sql = "insert into projet_calendar_parametre(tag_name, is_visible, is_tag_visible, 
			                                    display_order, font)"
				. " values(?,?,?,?,?)";
		$this->runRequest($sql, array($tag_name, $is_visible, $is_tag_visible, 
			                          $display_order, $font));
		return $this->getDatabase()->lastInsertId();
	}
	
	public function isEntry($tag_name){
		$sql = "select id from projet_calendar_parametre where tag_name=?";
		$data = $this->runRequest ( $sql, array (
				$tag_name
		) );
		if ($data->rowCount () == 1)
			return true;
		else
			return false;
	}
	
	public function setEntry($tag_name, $is_visible, $is_tag_visible, 
			                 $display_order, $font){
			                 	
		if (!$this->isEntry($tag_name)){
			$this->addEntry($tag_name, $is_visible, $is_tag_visible, $display_order, $font);
		}
		else{
			$id = $this->getEntryID($tag_name);
			$this->updateEntry($id, $tag_name, $is_visible, $is_tag_visible, $display_order, $font);
		}
		
	}
	
	public function getEntryID($tag_name){
		$sql = "select id from projet_calendar_parametre where tag_name=?";
		$req = $this->runRequest($sql, array($tag_name));
		$tmp = $req->fetch();
		return $tmp[0];
	}
	
	public function getEntry($id){
		$sql = "select * from projet_calendar_parametre where id=?";
		$req = $this->runRequest($sql, array($id));
		return $req->fetch();
	}
	
	public function updateEntry($id, $tag_name, $is_visible, $is_tag_visible, 
			                 $display_order, $font){
		$sql = "update projet_calendar_parametre set tag_name=?, is_visible=?, is_tag_visible=?, 
			                 display_order=?, font=?
			                 where id=?";
		$this->runRequest($sql, array($tag_name, $is_visible, $is_tag_visible, 
			                 $display_order, $font, $id));
	}
	
	public function getSummary($user, $acronyme, $codeanonyma, $commentaire, $numvisite, $displayHorizontal = true){
		
		$lang = "En";
		if (isset($_SESSION["user_settings"]["language"])){
			$lang = $_SESSION["user_settings"]["language"];
		}
		$entryList = $this->entries("display_order");
		$summary= "";
		// user
		for ($i = 0; $i < count($entryList) ; $i++){
			$last = false;
			if ($i == count($entryList)-1){$last = true;}
			if ($entryList[$i]['tag_name'] == "User"){
				$summary= $this->summaryEntry($i, $summary, $entryList, $user, $displayHorizontal, "Utilisateur", $last);
			}
			elseif ($entryList[$i]['tag_name'] == "Acronyme"){
				$summary= $this->summaryEntry($i, $summary, $entryList, $acronyme, $displayHorizontal, "Acronyme", $last);
			}
			elseif ($entryList[$i]['tag_name'] == "Code danonymisation"){
				$summary= $this->summaryEntry($i, $summary, $entryList, $codeanonyma, $displayHorizontal,  "Code danonymisation", $last);
			}
			elseif ($entryList[$i]['tag_name'] == "Commentaire"){
				$summary= $this->summaryEntry($i, $summary, $entryList, $commentaire, $displayHorizontal,"Commentaire", $last);
			}
		
			elseif ($entryList[$i]['tag_name'] == "Numero de visite"){
				$summary= $this->summaryEntry($i, $summary, $entryList, $numvisite, $displayHorizontal, "Numero de visite", $last);
			}
		
		}
		
		return $summary;
		
	}
		
	
	
	protected function summaryEntry($i, $summary, $entryList, $content, $displayHorizontal, $tagNameTr, $last){
		
		if ($entryList[$i]['is_visible'] == 1){
			if ($entryList[$i]['is_tag_visible'] == 1){
				$summary .= "<b>" . $tagNameTr . ": </b>";
			}
			if ($entryList[$i]['font'] == "bold"){$summary .= "<b>";}
			elseif ($entryList[$i]['font'] == "italic"){$summary .= "<i>";}
			$summary .= $content;
			if ($entryList[$i]['font'] == "bold"){$summary .= "</b>";}
			elseif ($entryList[$i]['font'] == "italic"){$summary .= "</i>";}
			if ($last == false){
				if ($displayHorizontal){$summary .= " ";}else{$summary .= "<br/>";}
			}
		}
		return $summary;
	}
}