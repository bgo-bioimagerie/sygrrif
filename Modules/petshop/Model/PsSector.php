<?php

require_once 'Framework/Model.php';

class PsSector extends Model {
    /* function create : creation de la table secteur
     */

    public function createTable() {

        // secteur
        $sql1 = "CREATE TABLE IF NOT EXISTS `ps_sectors` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`name` varchar(150) NOT NULL,
                                PRIMARY KEY (`id`)
				);";
        $this->runRequest($sql1);
    }

    public function getallsectors() {
        $sql = "SELECT * FROM ps_sectors";
        $secteur = $this->runRequest($sql)->fetchAll();
        return $secteur;
    }

    public function addSector($name) {

        $sql = "insert into ps_sectors(name) values(?)";
        $this->runRequest($sql, array($name));
        return $this->getDatabase()->lastInsertId();
    }

    public function editSector($id, $name) {

        $sql = "update ps_sectors set name=? where id=?";
        $this->runRequest($sql, array("" . $name . "", $id));
    }

    public function getSector($id) {
        $sql = "select * from ps_sectors where id=?";
        $unit = $this->runRequest($sql, array($id));
        if ($unit->rowCount() == 1) {
            return $unit->fetch();
        } else {
            return "unknown";
        }
    }

    public function getSectorName($id) {
        $sql = "select name from an_sector where id=?";
        $unit = $this->runRequest($sql, array($id));
        if ($unit->rowCount() == 1) {
            return $unit->fetch();
        } else {
            return "";
        }
    }

    public function delete($id) {
        $sql = "DELETE FROM `ps_sectors` WHERE id=?";
        $this->runRequest($sql, array($id));
    }

}
