<?php

require_once 'Framework/Model.php';
require_once 'Modules/supplies/Model/SuUser.php';
require_once 'Modules/core/Model/User.php';


/**
 * Class defining the Consomable items model
 *
 * @author Sylvain Prigent
 */
class SuEntry extends Model {

	public function createTable(){
		$sql = "CREATE TABLE IF NOT EXISTS `su_entries` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
	    `id_user` int(11) NOT NULL,
		`content` varchar(500) NOT NULL,
		`id_status` int(1) NOT NULL,
		`date_open` DATE NOT NULL,						
		`date_last_modified` DATE NOT NULL,
		`date_close` DATE NOT NULL,
		PRIMARY KEY (`id`)
		);";

		$pdo = $this->runRequest($sql);
		return $pdo;
	}
	
	public function addEntry($id_user, $content, $id_status, $date_open, $date_last_modified="", $date_close=""){
		$sql = "INSERT INTO su_entries (id_user, content, id_status, date_open, date_last_modified, date_close)
				 VALUES(?,?,?,?,?,?)";
		$pdo = $this->runRequest ( $sql, array (
				$id_user, $content, $id_status, $date_open, $date_last_modified, $date_close
		) );
	}
	
	public function updateEntry($id, $id_user, $content, $id_status, $date_open, $date_last_modified="", $date_close=""){
		$sql = "update su_entries set id_user=?, content=?, id_status=?, date_open=?, date_last_modified=?, date_close=?
		        where id=?";
		$this->runRequest($sql, array($id_user, $content, $id_status, $date_open, $date_last_modified, $date_close, $id));
	}
	
	public function entries($sortentry = 'id'){
			
		$sql = "select * from su_entries order by " . $sortentry . " ASC;";
		$req = $this->runRequest($sql);
		$entries = $req->fetchAll();
		
		$modelUser = "";
		$modelConfig = new CoreConfig();
		$supliesusersdatabase = $modelConfig->getParam("supliesusersdatabase");
		if ($supliesusersdatabase == "local"){
			$modelUser = new SuUser();
		}
		else{
			$modelUser = new User();
		}
		for ($i = 0 ; $i < count($entries) ; $i++){
			$entries[$i]["user_name"] =  $modelUser->getUserFUllName($entries[$i]['id_user']);
		}
		return $entries;
	}
	
	public function openedEntries($sortentry = 'id'){
		$sql = "select * from su_entries where id_status=1 order by " . $sortentry . " ASC;";
		$req = $this->runRequest($sql);
		
		$entries = $req->fetchAll();
		$modelUser = new SuUser();
		for ($i = 0 ; $i < count($entries) ; $i++){
			$entries[$i]["user_name"] =  $modelUser->getUserFUllName($entries[$i]['id_user']);
		}
		return $entries;
	}
	
	public function closedEntries($sortentry = 'id'){
		$sql = "select * from su_entries where id_status=0 order by " . $sortentry . " ASC;";
		$req = $this->runRequest($sql);
		
		$entries = $req->fetchAll();
		$modelUser = new SuUser();
		for ($i = 0 ; $i < count($entries) ; $i++){
			$entries[$i]["user_name"] =  $modelUser->getUserFUllName($entries[$i]['id_user']);
		}
		return $entries;
	}
	
	public function defaultEntryValues(){
		
		$entry["id"] = "";
		$entry["id_user"] = "";
		$entry["content"] = "";
		$entry["id_status"] = 1;
		$entry["date_open"] = date("Y-m-d", time());
		$entry["date_last_modified"] = "";
		$entry["date_close"] = "";
		$entry["orders"] = array();
		return $entry;
	}
	
	public function getEntry($id){
		$sql = "select * from su_entries where id=?";
		$req = $this->runRequest($sql, array($id));
		$entry = $req->fetch();
		
		return $entry;
	}
	
	public function setEntryCloded($id){
		$sql = "update su_entries set id_status=0, date_close=?
		        where id=?";
		$this->runRequest($sql, array(date("Y-m-d", time()), $id));
	}
}