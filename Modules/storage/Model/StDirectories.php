<?php
require_once 'Framework/Model.php';

/**
 * Class defining methods to store the data directories
 *
 * @author Sylvain Prigent
 */
class StDirectories extends Model {
	
	/**
	 * Create the database
	 *
	 * @return boolean True if the base is created successfully
	 */
	public function createTable() {
		$sql = "CREATE TABLE IF NOT EXISTS `st_directories` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`name` varchar(100) NOT NULL DEFAULT 'local',
		PRIMARY KEY (`id`)
		);";
		
		$pdo = $this->runRequest ( $sql );
		return $pdo;
	}
	
	/**
	 * Get all the directories
	 */
	public function getDirectories(){
		$sql = "select * from st_directories";
		$data = $this->runRequest ( $sql );
		return $data->fetchAll();
	}
	
	/**
	 * Add a directory
	 * @param string $dirname
	 */
	public function addDir($dirname){
		$sql = "INSERT INTO st_directories (name)
				 VALUES(?)";
		$this->runRequest( $sql, array ($dirname) );
	}
	
	/**
	 * Update a dir name
	 * @param number $id
	 * @param string $dirname
	 */
	public function updateDir($id, $dirname){
		$sql = "update st_directories set name=? where id=?";
		$unit = $this->runRequest ( $sql, array (
				$dirname,
				$id
		) );
	}
	
	/**
	 * Add a directory if $id does not exists, otherwise create update the directory of name dirname
	 * @param number $id
	 * @param string $name
	 */
	public function setDir($id, $name){
		if ($this->isDir($id)){
			$this->updateDir($id, $name);
		}
		else{
			$this->addDir($name);
		}
	}
	
	/**
	 * Verify that a dir ID is in the database
	 *
	 * @param string $login
	 *        	the login
	 * @return boolean True if the user is in the database
	 */
	public function isDir($id) {
		$sql = "select name from st_directories where id=?";
		$user = $this->runRequest ( $sql, array (
				$id
		) );
		if ($user->rowCount () == 1)
			return true; // get the first line of the result
		else
			return false;
	}
	
	/**
	 * Remove a directory
	 * @param number $id Directory ID
	 */
	public function removeDir($id){
		$sql="DELETE FROM st_directories WHERE id = ?";
		$req = $this->runRequest($sql, array($id));
	}
	
	/**
	 * Free the table
	 */
	public function removeAll(){
		$sql="DELETE FROM st_directories";
		$req = $this->runRequest($sql);
	}
}

?>