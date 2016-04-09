<?php

require_once 'Framework/Model.php';

class PsProceedings extends Model {
    /* function create : creation de la table procedure
     */

    public function createTable() {

        $sql = "CREATE TABLE IF NOT EXISTS `ps_proceedings` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`name` varchar(30) NOT NULL,
                PRIMARY KEY (`id`)
		);";

        $this->runRequest($sql);
    }

    public function createDefault() {

        if (!$this->exists(1)) {
            $sql = "INSERT INTO ps_proceedings (name) VALUES(?)";
            $this->runRequest($sql, array("--"));
        }
    }

    /**
     * get proceedings informations
     * 
     * @param string $sortentry Entry that is used to sort the proceedings
     * @return multiproceeding: array
     */
    public function getAll($sortentry = 'id') {

        $sql = "SELECT * FROM ps_proceedings ORDER BY " . $sortentry . " ASC;";
        $req = $this->runRequest($sql);
        return $req->fetchAll();
    }

    /**
     * add a proceeding to the table
     *
     * @param string $name name of the proceeding
     * @param string $address address of the proceeding
     */
    public function add($name) {

        $sql = "insert into ps_proceedings(name) values(?)";
        $this->runRequest($sql, array($name));
    }

    /**
     * update the information of a proceeding
     *
     * @param int $id Id of the proceeding to update
     * @param string $name New name of the proceeding
     * @param string $address New Address of the proceeding
     */
    public function edit($id, $name) {

        $sql = "update ps_proceedings set name=? where id=?";
        $this->runRequest($sql, array($name, $id));
    }

    /**
     * Check if a proceeding exists
     * @param string $id proceeding id
     * @return boolean
     */
    public function exists($id) {
        $sql = "select * from ps_proceedings where id=?";
        $unit = $this->runRequest($sql, array($id));
        if ($unit->rowCount() == 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Set a proceeding (add if not exists)
     * @param string $name proceeding name
     */
    public function set($id, $name) {
        if (!$this->exists($id)) {
            $this->add($name);
        } else {
            $this->edit($id, $name);
        }
    }

    /**
     * get the informations of a proceeding
     *
     * @param int $id Id of the proceeding to query
     * @throws Exception id the proceeding is not found
     * @return mixed array
     */
    public function get($id) {
        $sql = "select * from ps_proceedings where id=?";
        $req = $this->runRequest($sql, array($id));
        if ($req->rowCount() == 1) {
            return $req->fetch();
        } else {
            return "Unknown";
        }
    }

    /**
     * get the id of a proceeding from it's name
     * 
     * @param string $name Name of the exit reason
     * @throws Exception if the proceeding connot be found
     * @return mixed array
     */
    public function getId($name) {
        $sql = "select id from ps_proceedings where name=?";
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
     * @param number $id proceeding ID
     */
    public function delete($id) {
        $sql = "DELETE FROM ps_proceedings WHERE id = ?";
        $this->runRequest($sql, array($id));
    }

}
