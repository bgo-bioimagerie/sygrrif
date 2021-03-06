<?php

require_once 'Framework/Model.php';

/**
 * Class defining the Belonging model
 *
 * @author Sylvain Prigent
 */
class CoreBelonging extends Model {

	/**
	 * Create the belonging table
	 * 
	 * @return PDOStatement
	 */
	public function createTable(){
			
		$sql = "CREATE TABLE IF NOT EXISTS `core_belongings` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`name` varchar(150) NOT NULL DEFAULT '',
		`color` varchar(7) NOT NULL DEFAULT '#ffffff',
		`type` int(1) NOT NULL DEFAULT 1,		
		PRIMARY KEY (`id`)
		);";
		
		$pdo = $this->runRequest($sql);
		return $pdo;
	}
	
	/**
	 * Create the default empty belonging
	 * 
	 * @return PDOStatement
	 */
	public function createDefault(){
	
		if(!$this->exists(1)){
			$sql = "INSERT INTO core_belongings (name) VALUES(?)";
			$this->runRequest($sql, array("--"));
		}
	}
	
	/**
	 * get belongings informations
	 * 
	 * @param string $sortentry Entry that is used to sort the belongings
	 * @return multitype: array
	 */
	public function getBelongings($sortentry = 'id'){
		 
		$sql = "select * from core_belongings order by " . $sortentry . " ASC;";
		$user = $this->runRequest($sql);
		return $user->fetchAll();
	}
	
	/**
	 * get the names of all the belongings
	 *
	 * @return multitype: array
	 */
	public function getNames(){
			
		$sql = "select name from core_belongings";
		$req = $this->runRequest($sql);
		$inter = $req->fetchAll();
		$names = array();
		foreach($inter as $name){
			$names[] = $name['name'];
		}
		return $names;
	}
	
	/**
	 * Get the belongings ids and names
	 *
	 * @return array
	 */
	public function getAll(){
			
		$sql = "select id, name, color, type from core_belongings";
		$req = $this->runRequest($sql);
		return $req->fetchAll();
	}
	
	public function getIds(){
			
		$sql = "select id from core_belongings";
		$req = $this->runRequest($sql);
		$inter = $req->fetchAll();
		$ids = array();
		foreach($inter as $id){
			$ids[] = $id['id']; 
		} 
		return $ids;
	}
	
	
	/**
	 * add a belongong to the table
	 *
	 * @param string $name name of the belonging
	 */
	public function add($name, $color, $type){
		
		$sql = "insert into core_belongings(name, color, type)"
				. " values(?,?,?)";
		$user = $this->runRequest($sql, array($name, $color, $type));		
	}
	
	/**
	 * update the information of a belonging
	 *
	 * @param int $id Id of the belonging to update
	 * @param string $name New name of the belonging
	 */
	public function edit($id, $name, $color, $type){
		
		$sql = "update core_belongings set name=?, color=?, type=? where id=?";
		$this->runRequest($sql, array($name, $color, $type, $id));
	}
	
	/**
	 * Check if a Belonging exists
	 * @param string $name Belonging name
	 * @return boolean
	 */
	public function exists($id){
		$sql = "select * from core_belongings where id=?";
		$req = $this->runRequest($sql, array($id));
		if ($req->rowCount() == 1){
			return true;
                }
		else{
			return false;
                }
	}
	
	/**
	 * Set a Belonging (add if not exists)
	 * @param string $name Belonging name
	 */
	public function set($id, $name, $color, $type){
		if (!$this->exists($id)){
			$this->add($name, $color, $type);
		}
		else{
			$this->edit($id, $name, $color, $type);
		}
	}
	
	/**
	 * get the informations of a core_belongings
	 *
	 * @param int $id Id of the belonging to query
	 * @throws Exception id the belonging is not found
	 * @return mixed array
	 */
	public function getInfo($id){
		$sql = "select * from core_belongings where id=?";
		$req = $this->runRequest($sql, array($id));
		if ($req->rowCount() == 1){
                    return $req->fetch();  // get the first line of the result
                }
                else{
                    return array('id' => 0, "name" => 'unknown', 'color' => '#ffffff', 'type' => 1);
                }
	}
	
	/**
	 * get the name of a belonging
	 *
	 * @param int $id Id of the belonging to query
	 * @throws Exception if the belonging is not found
	 * @return mixed array
	 */
	public function getName($id){
		$sql = "select name from core_belongings where id=?";
		$req = $this->runRequest($sql, array($id));
		if ($req->rowCount() == 1){
			$tmp = $req->fetch();
			return $tmp[0];  // get the first line of the result
		}
		else{
			return "";
		}
	}
	
	/**
	 * get the id of a belonging from it's name
	 * 
	 * @param string $name Name of the belonging
	 * @throws Exception if the belonging connot be found
	 * @return mixed array
	 */
	public function getId($name){
		$sql = "select id from core_belongings where name=?";
		$req = $this->runRequest($sql, array($name));
		if ($req->rowCount() == 1){
			$tmp = $req->fetch();
			return $tmp[0];  // get the first line of the result
		}
		else{
			throw new Exception("Cannot find the belonging using the given name:" . $name );
		}
	}
	
	/**
	 * Delete a belonging
	 * @param number $id belonging ID
	 */
	public function delete($id){
		$sql="DELETE FROM core_belongings WHERE id=?";
		$req = $this->runRequest($sql, array($id));
	}

}

