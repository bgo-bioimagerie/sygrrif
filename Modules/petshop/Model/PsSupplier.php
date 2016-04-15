<?php

require_once 'Framework/Model.php';

class PsSupplier extends Model {

    public function createTable() {
        $sql = "CREATE TABLE IF NOT EXISTS `ps_suppliers` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`name` varchar(100) NOT NULL DEFAULT '',
		`address` text NOT NULL DEFAULT '',			
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
            $sql = "INSERT INTO ps_suppliers (name, address) VALUES(?,?)";
            $this->runRequest($sql, array("--", "--"));
        }
    }

    public function exists($id) {
        $sql = "select * from ps_suppliers where id=?";
        $unit = $this->runRequest($sql, array($id));
        if ($unit->rowCount() == 1) {
            return true;
        } else {
            return false;
        }
    }

    // return suppliers names
    public function getNames() {
        $sql = "SELECT `name` from `ps_suppliers`";
        return $this->runRequest($sql)->fetchAll();
    }

    // return all suppliers informations
    public function getAll() {
        $sql = "SELECT * from `ps_suppliers`";
        return $this->runRequest($sql)->fetchAll();
    }

    public function get($id) {
        $sql = "SELECT * from `ps_suppliers` where id=?";
        return $this->runRequest($sql, array($id))->fetch();
    }

    public function add($name, $address) {
        $sql = "insert into ps_suppliers(name, address)"
                . " values(?,?)";
        $this->runRequest($sql, array($name, $address));
    }
    
    public function import($id, $name, $address) {
        $sql = "insert into ps_suppliers(id, name, address)"
                . " values(?,?,?)";
        $this->runRequest($sql, array($id, $name, $address));
    }

    public function edit($id, $name, $address) {
        $sql = "update ps_suppliers set name=?,address=? where id=?";
        $this->runRequest($sql, array("" . $name . "", "" . $address . "", $id));
    }

    public function set($id, $name, $address) {
        if (!$this->exists($id)) {
            $this->add($name, $address);
        } else {
            $this->edit($id, $name, $address);
        }
    }

    public function delete($id) {
        $sql = "DELETE FROM `ps_suppliers` WHERE id=?";
        $this->runRequest($sql, array($id));
    }

}
