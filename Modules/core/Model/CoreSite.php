<?php

require_once 'Framework/Model.php';

/**
 * Class defining the Site model
 *
 * @author Sylvain Prigent
 */
class CoreSite extends Model {

	/**
	 * Create the site table
	 * 
	 * @return PDOStatement
	 */
	public function createTable(){
			
            $sql = "CREATE TABLE IF NOT EXISTS `core_sites` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(150) NOT NULL DEFAULT '',	
            PRIMARY KEY (`id`)
            );";
            $this->runRequest($sql);
            
            $sql2 = "CREATE TABLE IF NOT EXISTS `core_j_user_site` (
            `id_user` int(11) NOT NULL,
            `id_site` int(11) NOT NULL,
            `id_status` int(11) NOT NULL
            );";
            $this->runRequest($sql2);
	}
	
        public function setUserToSite($id_user, $id_site, $id_status){
            if ($this->isUserSite($id_user, $id_site)){
                $this->updateUserSite($id_user, $id_site, $id_status);
            }
            else{
                $this->addUserToSite($id_user, $id_site, $id_status);
            }
        }
        
        public function addUserToSite($id_user, $id_site, $id_status){
            $sql = "INSERT INTO core_j_user_site (id_user, id_site, id_status) VALUES(?,?,?)";
            $this->runRequest($sql, array($id_user, $id_site, $id_status));
        }
        
        public function updateUserSite($id_user, $id_site, $id_status){
            $sql = "update core_j_user_site set id_status=? where id_user=? AND id_site=?";
            $this->runRequest($sql, array($id_status, $id_user, $id_site));
        }
        
        public function isUserSite($id_user, $id_site){
            $sql = "select * from core_j_user_site where id_user=? AND id_site=?";
            $unit = $this->runRequest($sql, array($id_user, $id_site));
            if ($unit->rowCount() == 1){
                return true;
            }
            else{
                    return false;
            }
        }
        
	/**
	 * Create the default empty Site
	 * 
	 * @return PDOStatement
	 */
	public function createDefault(){
	
		if(!$this->isSite(1)){
			$sql = "INSERT INTO core_sites (name) VALUES(?)";
			$this->runRequest($sql, array("--"));
		}
	}
	
	/**
	 * get units informations
	 * 
	 * @param string $sortentry Entry that is used to sort the units
	 * @return multitype: array
	 */
	public function getAll($sortentry = 'id'){
		 
            $sql = "SELECT * FROM core_sites ORDER BY " . $sortentry . " ASC;";
            $user = $this->runRequest($sql);
            return $user->fetchAll();
	}
	
	/**
	 * get the names of all the units
	 *
	 * @return multitype: array
	 */
	public function names(){
			
		$sql = "select name from core_sites";
		$units = $this->runRequest($sql);
		return $units->fetchAll();
	}
	
	/**
	 * Get the units ids and names
	 *
	 * @return array
	 */
	public function getIDName(){
			
		$sql = "select id, name from core_sites";
		$units = $this->runRequest($sql);
		return $units->fetchAll();
	}
	
	/**
	 * add a unit to the table
	 *
	 * @param string $name name of the unit
	 * @param string $address address of the unit
	 */
	public function add($name){
		
		$sql = "insert into core_sites(name)"
				. " values(?)";
		$this->runRequest($sql, array($name));		
	}
       
	
	/**
	 * update the information of a unit
	 *
	 * @param int $id Id of the unit to update
	 * @param string $name New name of the unit
	 * @param string $address New Address of the unit
	 */
	public function edit($id, $name){
		
		$sql = "update core_sites set name=? where id=?";
		$this->runRequest($sql, array($name, $id));
	}
	
	/**
	 * Check if a unit exists
	 * @param string $id Unit id
	 * @return boolean
	 */
	public function isSite($id){
		$sql = "select * from core_sites where id=?";
		$unit = $this->runRequest($sql, array($id));
		if ($unit->rowCount() == 1){
			return true;
                }
		else{
			return false;
                }
	}
	
	/**
	 * Set a unit (add if not exists)
	 * @param string $name Unit name
	 */
	public function set($id, $name){
            if (!$this->isSite($id)){
                $this->add($name);
            }
            else{
                $this->editUnit($id, $name);
            }
	}
	
	/**
	 * get the informations of a unit
	 *
	 * @param int $id Id of the unit to query
	 * @throws Exception id the unit is not found
	 * @return mixed array
	 */
	public function get($id){
		$sql = "select * from core_sites where id=?";
		$unit = $this->runRequest($sql, array($id));
		if ($unit->rowCount() == 1){
                    return $unit->fetch();
                }
                else {
                    throw new Exception("Cannot find the site using the given id: " . $id); 
                }
	}
	
	/**
	 * get the id of a site from it's name
	 * 
	 * @param string $name Name of the unit
	 * @throws Exception if the unit connot be found
	 * @return mixed array
	 */
	public function getId($name){
		$sql = "select id from core_sites where name=?";
		$unit = $this->runRequest($sql, array($name));
		if ($unit->rowCount() == 1){
			$tmp = $unit->fetch();
			return $tmp[0];  // get the first line of the result
		}
		else{
			throw new Exception("Cannot find the site using the given name:" . $name );
		}
	}
	
	/**
	 * Delete a unit
	 * @param number $id Unit ID
	 */
	public function delete($id){
		$sql="DELETE FROM core_sites WHERE id = ?";
		$this->runRequest($sql, array($id));
	}
}
