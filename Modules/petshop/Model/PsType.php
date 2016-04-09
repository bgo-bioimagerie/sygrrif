<?php

require_once 'Framework/Model.php';

class PsType extends Model {

    /**
     * function create : creation de la table type
     */
    public function createTable() {


        $sql = "CREATE TABLE IF NOT EXISTS `ps_types` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`name` varchar(30) NOT NULL,
                PRIMARY KEY (`id`)
		);";

        $this->runRequest($sql);
    }

    /**
     * Create the default empty type
     * 
     * @return PDOStatement
     */
    public function createDefault() {

        if (!$this->exists(1)) {
            $sql = "INSERT INTO ps_types (name) VALUES(?)";
            $this->runRequest($sql, array("--"));
        }
    }

    /**
     * get types informations
     * 
     * @param string $sortentry Entry that is used to sort the types
     * @return multitype: array
     */
    public function getAll($sortentry = 'id') {

        $sql = "SELECT * FROM ps_types ORDER BY " . $sortentry . " ASC;";
        $req = $this->runRequest($sql);
        return $req->fetchAll();
    }

    /**
     * add a type to the table
     *
     * @param string $name name of the type
     * @param string $address address of the type
     */
    public function add($name) {

        $sql = "insert into ps_types(name) values(?)";
        $this->runRequest($sql, array($name));
    }

    /**
     * update the information of a type
     *
     * @param int $id Id of the type to update
     * @param string $name New name of the type
     * @param string $address New Address of the type
     */
    public function edit($id, $name) {

        $sql = "update ps_types set name=? where id=?";
        $this->runRequest($sql, array($name, $id));
    }

    /**
     * Check if a type exists
     * @param string $id type id
     * @return boolean
     */
    public function exists($id) {
        $sql = "select * from ps_types where id=?";
        $unit = $this->runRequest($sql, array($id));
        if ($unit->rowCount() == 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Set a type (add if not exists)
     * @param string $name type name
     */
    public function set($id, $name) {
        if (!$this->exists($id)) {
            $this->add($name);
        } else {
            $this->edit($id, $name);
        }
    }

    /**
     * get the informations of a type
     *
     * @param int $id Id of the type to query
     * @throws Exception id the type is not found
     * @return mixed array
     */
    public function get($id) {
        $sql = "select * from ps_types where id=?";
        $req = $this->runRequest($sql, array($id));
        if ($req->rowCount() == 1) {
            return $req->fetch();
        } else {
            return "Unknown";
        }
    }

    /**
     * get the id of a type from it's name
     * 
     * @param string $name Name of the exit reason
     * @throws Exception if the type connot be found
     * @return mixed array
     */
    public function getId($name) {
        $sql = "select id from ps_types where name=?";
        $unit = $this->runRequest($sql, array($name));
        if ($unit->rowCount() == 1) {
            $tmp = $unit->fetch();
            return $tmp[0];  // get the first line of the result
        } else {
            return "Unknown";
        }
    }

    /**
     * Delete a unit
     * @param number $id type ID
     */
    public function delete($id) {
        $sql = "DELETE FROM ps_types WHERE id = ?";
        $this->runRequest($sql, array($id));
    }

}
