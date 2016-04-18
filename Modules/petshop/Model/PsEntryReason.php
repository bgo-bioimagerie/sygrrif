<?php

require_once 'Framework/Model.php';

/**
 * Class defining the Unit model
 *
 * @author Sylvain Prigent
 */
class PsEntryReason extends Model {

    /**
     * Create the exit reason table
     * 
     * @return PDOStatement
     */
    public function createTable() {

        $sql = "CREATE TABLE IF NOT EXISTS `ps_entry_reason` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`name` varchar(150) NOT NULL DEFAULT '',	
		PRIMARY KEY (`id`)
		);";

        $this->runRequest($sql);
    }

    /**
     * Create the default empty Unit
     * 
     * @return PDOStatement
     */
    public function createDefault() {

        if (!$this->exists(1)) {
            $sql = "INSERT INTO ps_entry_reason (name) VALUES(?)";
            $this->runRequest($sql, array("--"));
        }
    }

    /**
     * get exit reasons informations
     * 
     * @param string $sortentry Entry that is used to sort the exit reasons
     * @return multitype: array
     */
    public function getAll($sortentry = 'id') {

        $sql = "SELECT *
    			FROM ps_entry_reason
    			ORDER BY " . $sortentry . " ASC;";

        $req = $this->runRequest($sql);
        return $req->fetchAll();
    }

    /**
     * add a exit reason to the table
     *
     * @param string $name name of the exit reason
     * @param string $address address of the exit reason
     */
    public function add($name) {

        $sql = "insert into ps_entry_reason(name)"
                . " values(?)";
        $this->runRequest($sql, array($name));
    }
    
    public function import($id, $name) {

        $sql = "insert into ps_entry_reason(id, name)"
                . " values(?,?)";
        $this->runRequest($sql, array($id, $name));
    }

    /**
     * update the information of a exit reason
     *
     * @param int $id Id of the exit reason to update
     * @param string $name New name of the exit reason
     * @param string $address New Address of the exit reason
     */
    public function edit($id, $name) {

        $sql = "update ps_entry_reason set name=? where id=?";
        $this->runRequest($sql, array($name, $id));
    }

    /**
     * Check if a exit reason exists
     * @param string $id Unit id
     * @return boolean
     */
    public function exists($id) {
        $sql = "select * from ps_entry_reason where id=?";
        $exitreason = $this->runRequest($sql, array($id));
        if ($exitreason->rowCount() == 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Set a exit reason (add if not exists)
     * @param string $name Exit status name
     */
    public function set($id, $name) {
        if (!$this->exists($id)) {
            $this->add($name);
        } else {
            $this->edit($id, $name);
        }
    }

    /**
     * get the informations of a exit reason
     *
     * @param int $id Id of the exit reason to query
     * @throws Exception id the exit reason is not found
     * @return mixed array
     */
    public function get($id) {
        $sql = "select * from ps_entry_reason where id=?";
        $req = $this->runRequest($sql, array($id));
        if ($req->rowCount() == 1) {
            return $req->fetch();
        } else {
            return "Unknown";
        }
    }

    /**
     * get the id of a Exit reason from it's name
     * 
     * @param string $name Name of the exit reason
     * @throws Exception if the exit reason connot be found
     * @return mixed array
     */
    public function getId($name) {
        $sql = "select id from ps_entry_reason where name=?";
        $exitreason = $this->runRequest($sql, array($name));
        if ($exitreason->rowCount() == 1) {
            $tmp = $exitreason->fetch();
            return $tmp[0];  // get the first line of the result
        } else {
            return "Unknown";
        }
    }

    /**
     * Delete a exit reason
     * @param number $id Unit ID
     */
    public function delete($id) {
        $sql = "DELETE FROM ps_entry_reason WHERE id = ?";
        $this->runRequest($sql, array($id));
    }

}
