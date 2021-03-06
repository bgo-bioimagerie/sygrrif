<?php

require_once 'Framework/Model.php';

/**
 * Class defining the Espece model
 *
 * @author Sylvain Prigent
 */
class AcStaining extends Model {

    /**
     * Create the espece table
     * 
     * @return PDOStatement
     */
    public function createTable() {

        $sql = "CREATE TABLE IF NOT EXISTS `ac_stainings` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`name` varchar(30) NOT NULL,
				PRIMARY KEY (`id`)
				);";

        $this->runRequest($sql);
        
        if (!$this->isEntry("--")){
            $this->addStaining("--");
        }
    }

    /**
     * get especes informations
     *
     * @param string $sortentry Entry that is used to sort the especes
     * @return multitype: array
     */
    public function getStainings($sortentry = 'id') {

        $sql = "select * from ac_stainings order by " . $sortentry . " ASC;";
        $user = $this->runRequest($sql);
        return $user->fetchAll();
    }

    /**
     * get the informations of an espece
     *
     * @param int $id Id of the espece to query
     * @throws Exception id the espece is not found
     * @return mixed array
     */
    public function getStaining($id) {
        $sql = "select * from ac_stainings where id=?";
        $unit = $this->runRequest($sql, array($id));
        if ($unit->rowCount() == 1) {
            return $unit->fetch();
        } else {
            throw new Exception("Cannot find the staining using the given id");
        }
    }

    /**
     * add an espece to the table
     *
     * @param string $name name of the espece
     * 
     */
    public function addStaining($name) {

        $sql = "insert into ac_stainings(name)"
                . " values(?)";
        $this->runRequest($sql, array($name));
    }

    /**
     * update the information of a 
     *
     * @param int $id Id of the  to update
     * @param string $name New name of the 
     */
    public function editStaining($id, $name) {

        $sql = "update ac_stainings set name=? where id=?";
        $this->runRequest($sql, array("" . $name . "", $id));
    }

    public function getIdFromName($name) {
        $sql = "select id from ac_stainings where name=?";
        $unit = $this->runRequest($sql, array($name));
        if ($unit->rowCount() == 1) {
            $tmp = $unit->fetch();
            return $tmp[0];
        } else {
            return 0;
        }
    }

    public function getNameFromId($id) {
        $sql = "select name from ac_stainings where id=?";
        $unit = $this->runRequest($sql, array($id));
        if ($unit->rowCount() == 1) {
            $tmp = $unit->fetch();
            return $tmp[0];
        } else {
            return "";
        }
    }

    public function isEntry($name){
        $sql = "select id from ac_stainings where name=?";
        $req = $this->runRequest($sql, array($name));
        if ($req->rowCount() == 1) {
            return true;
        } else {
            return false;
        }
    }
    
    public function delete($id) {
        $sql = "DELETE FROM ac_stainings WHERE id = ?";
        $this->runRequest($sql, array($id));
    }

}
