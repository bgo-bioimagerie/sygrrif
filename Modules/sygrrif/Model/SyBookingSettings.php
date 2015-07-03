<?php

require_once 'Framework/Model.php';
require_once 'Modules/sygrrif/Controller/ControllerSygrrifconfig.php';
/**
 * Class defining the booking settings model
 *
 * @author Sylvain Prigent
 */
class SyBookingSettings extends Model {

	
	/**
	 * Create the booking settings entry table
	 *
	 * @return PDOStatement
	 */
	public function createTable(){
			
		$sql = "CREATE TABLE IF NOT EXISTS `sy_booking_settings` (
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
		$this->setEntry("Phone", 1, 1, 2, "normal");
		$this->setEntry("Short desc", 1, 1, 3, "normal");
		$this->setEntry("Desc", 0, 0, 4, "normal");
		if(isset($isneurinfo)){
		$this->setEntry("Acronyme", 1, 1, 1, "normal");
		$this->setEntry("Numéro de visite", 1, 1, 2, "normal");
		$this->setEntry("Code d'anonymation", 1, 1, 3, "normal");}
		$this->setEntry("Desc", 0, 0, 4, "normal");
				
	}
	
	public function entries($sortEntry = "id"){
		
		try{
		//if ($this->isTable("sy_booking_settings")){
			$sql="select * from sy_booking_settings order by " . $sortEntry;
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
		$sql = "insert into sy_booking_settings(tag_name, is_visible, is_tag_visible, 
			                                    display_order, font)"
				. " values(?,?,?,?,?)";
		$this->runRequest($sql, array($tag_name, $is_visible, $is_tag_visible, 
			                          $display_order, $font));
		return $this->getDatabase()->lastInsertId();
	}
	
	public function isEntry($tag_name){
		$sql = "select id from sy_booking_settings where tag_name=?";
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
		$sql = "select id from sy_booking_settings where tag_name=?";
		$req = $this->runRequest($sql, array($tag_name));
		$tmp = $req->fetch();
		return $tmp[0];
	}
	
	public function getEntry($id){
		$sql = "select * from sy_booking_settings where id=?";
		$req = $this->runRequest($sql, array($id));
		return $req->fetch();
	}
	
	public function updateEntry($id, $tag_name, $is_visible, $is_tag_visible, 
			                 $display_order, $font){
		$sql = "update sy_booking_settings set tag_name=?, is_visible=?, is_tag_visible=?, 
			                 display_order=?, font=?
			                 where id=?";
		$this->runRequest($sql, array($tag_name, $is_visible, $is_tag_visible, 
			                 $display_order, $font, $id));
	}
	
	public function getSummary($user, $phone, $short_desc, $desc, $displayHorizontal = true){
		
		$lang = "En";
		if (isset($_SESSION["user_settings"]["language"])){
			$lang = $_SESSION["user_settings"]["language"];
		}
		$entryList = $this->entries("display_order");
		$summary = "";
		// user
		for ($i = 0; $i < count($entryList) ; $i++){
			$last = false;
			if ($i == 3){$last = true;}
			if ($entryList[$i]['tag_name'] == "User"){
				$summary = $this->summaryEntry($i, $summary, $entryList, $user, $displayHorizontal, SyTranslator::User($lang), $last);
			}
			elseif ($entryList[$i]['tag_name'] == "Phone"){
				$summary = $this->summaryEntry($i, $summary, $entryList, $phone, $displayHorizontal, SyTranslator::Phone($lang), $last);
			}
			elseif ($entryList[$i]['tag_name'] == "Short desc"){
				$summary = $this->summaryEntry($i, $summary, $entryList, $short_desc, $displayHorizontal, SyTranslator::Short_desc($lang), $last);
			}
			elseif ($entryList[$i]['tag_name'] == "Desc"){
				$summary = $this->summaryEntry($i, $summary, $entryList, $desc, $displayHorizontal, SyTranslator::Desc($lang), $last);
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