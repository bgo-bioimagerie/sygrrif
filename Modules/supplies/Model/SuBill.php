<?php

require_once 'Framework/Model.php';

/**
 * Class defining the Bill model. It is used to store the history 
 * of the generated bills
 *
 * @author Sylvain Prigent
 */
class SuBill extends Model {

    public function createTable() {
        $sql = "CREATE TABLE IF NOT EXISTS `su_bills` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
                `number` varchar(50) NOT NULL,
		`id_unit` int(11) NOT NULL,
		`id_resp` int(11) NOT NULL,
		`date_generated` DATE NOT NULL,
		`total_ht` varchar(50) NOT NULL,		
		`date_paid` DATE NOT NULL,			
		`is_paid` int(1) NOT NULL,		
		PRIMARY KEY (`id`)
		);";

        $this->runRequest($sql);
        $this->addColumn("su_bills", "url", "varchar(200)", "");
    }

    /**
     * add an item to the table
     *
     * @param string $name name of the unit
     */
    public function addBill($number, $id_unit, $id_resp, $date_generated, $total_ht, $url) {

        $sql = "insert into su_bills(number, id_unit, id_resp, date_generated, total_ht, url)"
                . " values(?, ?, ?, ?, ?, ?)";
        $this->runRequest($sql, array($number, $id_unit, $id_resp, $date_generated, $total_ht, $url));
        return $this->getDatabase()->lastInsertId();
    }

    public function setPaid($id, $is_paid) {
        $sql = "update su_bills set is_paid=? where id=?";
        $this->runRequest($sql, array($is_paid, $id));
    }

    /**
     * get bills informations
     *
     * @param string $sortentry Entry that is used to sort the units
     * @return multitype: array
     */
    public function getBills($sortentry = 'id') {

        $sql = "select * from su_bills order by " . $sortentry . " ASC;";
        $user = $this->runRequest($sql);
        return $user->fetchAll();
    }

    public function getAllInfo() {

        $sql = "SELECT su_bills.*,
                            core_units.name AS unit,
                            core_users.name AS resp_name,
                            core_users.firstname AS resp_firstname
                    FROM su_bills
                    INNER JOIN core_units ON su_bills.id_unit = core_units.id
                    INNER JOIN core_users ON su_bills.id_resp = core_users.id;";

        $req = $this->runRequest($sql);
        return $req->fetchAll();
    }

    /**
     * get the informations of a invoice
     *
     * @param int $id Id of the item to query
     * @throws Exception id the item is not found
     * @return mixed array
     */
    public function getBill($id) {
        $sql = "select * from su_bills where id=?";
        $unit = $this->runRequest($sql, array($id));
        if ($unit->rowCount() == 1) {
            return $unit->fetch();  // get the first line of the result
        } else {
            throw new Exception("Cannot find the bill using the given id");
        }
    }

    /**
     * update the information of an item
     *
     * @param int $id Id of the item to update
     * @param string $name New name of the item
     */
    public function edit($id, $date_paid, $is_paid, $total_ht) {

        $sql = "update su_bills set date_paid=?, is_paid=?, total_ht=?  where id=?";
        $this->runRequest($sql, array($date_paid, $is_paid, $total_ht, $id));
    }

    public function delete($id) {
        $sql = "DELETE FROM su_bills WHERE id = ?";
        $this->runRequest($sql, array($id));
    }

}
