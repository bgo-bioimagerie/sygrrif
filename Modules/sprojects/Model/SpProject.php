<?php
require_once 'Framework/Model.php';
require_once 'Modules/sprojects/Model/SpUser.php';
require_once 'Modules/core/Model/CoreUser.php';
require_once 'Modules/core/Model/CoreConfig.php';

/**
 * Class defining the Consomable items model
 *
 * @author Sylvain Prigent
 */
class SpProject extends Model {
	public function createTable() {
		$sql = "CREATE TABLE IF NOT EXISTS `sp_projects` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`name` varchar(150) NOT NULL DEFAULT '',
		`id_resp` int(11) NOT NULL,					
	    `id_user` int(11) NOT NULL,
		`id_status` int(1) NOT NULL,
		`date_open` DATE NOT NULL,
		`date_close` DATE NOT NULL,
		`new_team` int(4) NOT NULL DEFAULT 1,
		`new_project` int(4) NOT NULL DEFAULT 1,
		`time_limit` varchar(100) NOT NULL DEFAULT '', 	
		PRIMARY KEY (`id`)
		);";
		
		$pdo = $this->runRequest ( $sql );
		
		// add columns if no exists
		$sql = "SHOW COLUMNS FROM `sp_projects` LIKE 'new_team'";
		$pdo = $this->runRequest($sql);
		$isColumn = $pdo->fetch();
		if ( $isColumn == false){
			$sql = "ALTER TABLE `sp_projects` ADD `new_team` int(4) NOT NULL DEFAULT 1";
			$pdo = $this->runRequest($sql);
		}
		
		$sql = "SHOW COLUMNS FROM `sp_projects` LIKE 'new_project'";
		$pdo = $this->runRequest($sql);
		$isColumn = $pdo->fetch();
		if ( $isColumn == false){
			$sql = "ALTER TABLE `sp_projects` ADD `new_project` int(4) NOT NULL DEFAULT 1";
			$pdo = $this->runRequest($sql);
		}
		
		$sql = "SHOW COLUMNS FROM `sp_projects` LIKE 'time_limit'";
		$pdo = $this->runRequest($sql);
		$isColumn = $pdo->fetch();
		if ( $isColumn == false){
			$sql = "ALTER TABLE `sp_projects` ADD `time_limit` varchar(100) NOT NULL DEFAULT ''";
			$pdo = $this->runRequest($sql);
		}
		
		// entries
		$sql = "CREATE TABLE IF NOT EXISTS `sp_projects_entries` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`id_proj` int(11) NOT NULL,
		`date` DATE NOT NULL,
		`content` TEXT NOT NULL,
		PRIMARY KEY (`id`)
		);";
		
		$pdo = $this->runRequest ( $sql );
	}
	public function getProjectEntries($id_proj) {
		$sql = "select * from sp_projects_entries where id_proj=? ORDER BY date ASC";
		$req = $this->runRequest ( $sql, array (
				$id_proj 
		) );
		$entries = $req->fetchAll ();
		
		for($i = 0 ; $i < count($entries) ; $i++){
			$orderc = explode(";", $entries[$i]["content"]);
			$content = array();
			$itemIDS = array();
			foreach($orderc as $oc){
				$ockv = explode("=", $oc);
				if (count($ockv) > 1){
					$content["item_".$ockv[0]] = $ockv[1];
					$itemIDS[] = $ockv[0];
				}
			}
			$content["items_ids"] = $itemIDS;
			$entries[$i]["content"] = $content;
		}
		
		return $entries;
	}
	
	public function getProjectEntriesItemsIds($id_proj){
		$sql = "select id from sp_projects_entries where id_proj=?";
		$req = $this->runRequest ( $sql, array (
				$id_proj
		) );
		return $req->fetchAll ();
	}
	public function getProjectEntriesItems($id_proj){
		$sql = "select * from sp_projects_entries where id_proj=?";
		$req = $this->runRequest ( $sql, array (
				$id_proj
		) );
		$entries = $req->fetchAll ();
		
		$items = array();
		$modelItem = new SpItem();
		for($i = 0 ; $i < count($entries) ; $i++){
			$orderc = explode(";", $entries[$i]["content"]);
			$content = array();
			$itemIDS = array();
			foreach($orderc as $oc){
				$ockv = explode("=", $oc);
				if (count($ockv) > 1){
					$item_id = $ockv[0];
					$items[$item_id] = $modelItem->getItem($item_id);
				}
			}
		}
		
		// sort due to the display order column
		foreach ($items as $key => $row) {
			$volume[$key]  = $row['display_order'];
			$edition[$key] = $row['id'];
		}

		array_multisort($volume, SORT_ASC, $edition, SORT_ASC, $items);
		
		return $items;
	}
	
	public function addProject($name, $id_resp, $id_user, $id_status, $date_open, $date_close, $new_team, $new_project, $time_limit) {
		$sql = "INSERT INTO sp_projects (name, id_resp, id_user, id_status, date_open, date_close, new_team, new_project, time_limit)
				 VALUES(?,?,?,?,?,?,?,?,?)";
		$pdo = $this->runRequest ( $sql, array (
				$name,
				$id_resp,
				$id_user,
				$id_status,
				$date_open,
				$date_close,
				$new_team, 
				$new_project, 
				$time_limit
		) );
		return $this->getDatabase ()->lastInsertId ();
	}
	public function updateProject($id, $name, $id_resp, $id_user, $id_status, $date_open, $date_close, $new_team, $new_project, $time_limit) {
		$sql = "update sp_projects set name=?, id_resp=?, id_user=?, id_status=?, date_open=?, date_close=?, new_team=?, new_project=?, time_limit=?
		        where id=?";
		$this->runRequest ( $sql, array (
				$name,
				$id_resp,
				$id_user,
				$id_status,
				$date_open,
				$date_close,
				$new_team, 
				$new_project, 
				$time_limit,
				$id 
		) );
	}
	
	public function closeProject($id_project){
		$sql = "update sp_projects set id_status=0
		        where id=?";
		$this->runRequest ( $sql, array (
				$id_project
		) );
	}
	
	public function setProject($id, $name, $id_resp, $id_user, $id_status, $date_open, $date_close, $new_team, $new_project, $time_limit) {
		if ($this->isProject ( $id )) {
			$this->updateProject ( $id, $name, $id_resp, $id_user, $id_status, $date_open, $date_close, $new_team, $new_project, $time_limit);
			return $id;
		} else {
			return $this->addProject ( $name, $id_resp, $id_user, $id_status, $date_open, $date_close, $new_team, $new_project, $time_limit);
		}
	}
	public function isProject($id) {
		$sql = "select * from sp_projects where id=?";
		$unit = $this->runRequest ( $sql, array (
				$id 
		) );
		if ($unit->rowCount () == 1)
			return true;
		else
			return false;
	}
	
	public function getResponsible($id_project){
		$sql = "SELECT id_resp FROM sp_projects WHERE id=?";
		$query = $this->runRequest($sql, array($id_project));
		$resp = $query->fetch();
		return $resp[0];
	}
	
	public function getUser($id_project){
		$sql = "SELECT id_user FROM sp_projects WHERE id=?";
		$query = $this->runRequest($sql, array($id_project));
		$user = $query->fetch();
		return $user[0];
	}
	
	public function projects($sortentry = 'id') {
		$sql = "select * from sp_projects order by " . $sortentry . " ASC;";
		$req = $this->runRequest ( $sql );
		$entries = $req->fetchAll ();
		
		$modelUser = "";
		$modelConfig = new CoreConfig ();
		$sprojectsusersdatabase = $modelConfig->getParam ( "sprojectsusersdatabase" );
		if ($sprojectsusersdatabase == "local") {
			$modelUser = new SpUser ();
		} else {
			$modelUser = new CoreUser ();
		}
		for($i = 0; $i < count ( $entries ); $i ++) {
			$entries [$i] ["user_name"] = $modelUser->getUserFUllName ( $entries [$i] ['id_user'] );
		}
		return $entries;
	}
	public function openedProjects($sortentry = 'id') {
		$sql = "select * from sp_projects where id_status=1 order by " . $sortentry . " ASC;";
		$req = $this->runRequest ( $sql );
		
		$entries = $req->fetchAll ();
		$modelConfig = new CoreConfig();
		$sprojectsusersdatabase = $modelConfig->getParam ( "sprojectsusersdatabase" );
		$modelUser = "";
		if ($sprojectsusersdatabase == "local") {
			$modelUser = new SpUser ();
		} else {
			$modelUser = new CoreUser ();
		}
		for($i = 0; $i < count ( $entries ); $i ++) {
			$entries [$i] ["user_name"] = $modelUser->getUserFUllName ( $entries [$i] ['id_user'] );
		}
		return $entries;
	}
	
	public function closedProjects($sortentry = 'id') {
		$sql = "select * from sp_projects where id_status=0 order by " . $sortentry . " ASC;";
		$req = $this->runRequest ( $sql );
		
		$entries = $req->fetchAll ();
		$modelConfig = new CoreConfig();
		$sprojectsusersdatabase = $modelConfig->getParam ( "sprojectsusersdatabase" );
		$modelUser = "";
		if ($sprojectsusersdatabase == "local") {
			$modelUser = new SpUser ();
		} else {
			$modelUser = new CoreUser ();
		}
		for($i = 0; $i < count ( $entries ); $i ++) {
			$entries [$i] ["user_name"] = $modelUser->getUserFUllName ( $entries [$i] ['id_user'] );
		}
		return $entries;
	}
	public function defaultProjectValues() {
		$entry ["id"] = "";
		$entry ["name"] = "";
		$entry ["id_resp"] = 1;
		$entry ["id_user"] = 1;
		$entry ["id_status"] = 1;
		$entry ["date_open"] = date ( "Y-m-d", time () );
		$entry ["date_close"] = "";
		$entry ["time_limit"] = "";
		return $entry;
	}
	public function getProject($id) {
		$sql = "select * from sp_projects where id=?";
		$req = $this->runRequest ( $sql, array (
				$id 
		) );
		$entry = $req->fetch ();
		
		return $entry;
	}
	
	
	// entries
	public function setProjectEntry($id, $id_project, $date, $content){
		if ($this->isProjectEntry ( $id )) {
			$this->updateProjectEntry ( $id, $id_project, $date, $content );
			return $id;
		} else {
			return $this->addProjectEntry ( $id_project, $date, $content );
		}
	}
	
	public function isProjectEntry($id) {
		$sql = "select * from sp_projects_entries where id=?";
		$unit = $this->runRequest ( $sql, array (
				$id
		) );
		if ($unit->rowCount () == 1)
			return true;
		else
			return false;
	}
	
	public function addProjectEntry($id_project, $date, $content) {
		$sql = "INSERT INTO sp_projects_entries (id_proj, date, content)
				 VALUES(?,?,?)";
		$pdo = $this->runRequest ( $sql, array (
				$id_project,
				$date,
				$content
		) );
		return $this->getDatabase ()->lastInsertId ();
	}
	public function updateProjectEntry($id, $id_project, $date, $content) {
		$sql = "update sp_projects_entries set id_proj=?, date=?, content=?
		        where id=?";
		$this->runRequest ( $sql, array (
				$id_project,
				$date,
				$content,
				$id
		) );
	}
	
	
	
	
	
	
	
	
	public function setProjectCloded($id) {
		$sql = "update sp_projects set id_status=0, date_close=?
		        where id=?";
		$this->runRequest ( $sql, array (
				date ( "Y-m-d", time () ),
				$id 
		) );
	}
	
	/**
	 * Delete a unit
	 * 
	 * @param number $id
	 *        	Unit ID
	 */
	public function delete($id) {
		$sql = "DELETE FROM sp_projects WHERE `id`=?";
		$req = $this->runRequest ( $sql, array (
				$id 
		) );
	}
	
	public function deleteProjectItem($id) {
		$sql = "DELETE FROM sp_projects_entries WHERE id=?";
		$req = $this->runRequest ( $sql, array (
				$id
		) );
	}
	
}