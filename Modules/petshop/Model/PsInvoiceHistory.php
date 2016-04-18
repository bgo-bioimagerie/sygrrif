<?php

require_once 'Framework/Model.php';
require_once 'Modules/core/Model/CoreUnit.php';
require_once 'Modules/core/Model/CoreUser.php';

/**
 * Class defining the Bill model. It is used to store the history 
 * of the generated bills
 *
 * @author Sylvain Prigent
 */
class PsInvoiceHistory extends Model {

    /**
     * Create the table
     * @return PDOStatement
     */
    public function createTable() {
        $sql = "CREATE TABLE IF NOT EXISTS `ps_invoices_hist` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
                `number` varchar(50) NOT NULL,		
		`period_begin` DATE NOT NULL,		
		`period_end` DATE NOT NULL,
		`date_generated` DATE NOT NULL,	
		`date_paid` DATE NOT NULL,			
		`is_paid` int(1) NOT NULL,
		`id_unit` int(11) NOT NULL,
		`id_responsible` int(11) NOT NULL,
		`total_ht` float(11) NOT NULL,	
                `url` varchar(250) NOT NULL,
		PRIMARY KEY (`id`)
		);";

        $this->runRequest($sql);
    }

    /**
     * Add bill associated to a responsible
     * @param number $number
     * @param date $period_begin
     * @param date $period_end
     * @param date $date_generated
     * @param number $id_unit
     * @param number $id_responsible
     * @param number $totalHT
     * @param string $date_paid
     * @param number $is_paid
     * @return number Last inserted ID
     */
    public function add($number, $period_begin, $period_end, $date_generated, $id_unit, $id_responsible, $totalHT, $url, $date_paid = "", $is_paid = 0) {
        $sql = "insert into ps_invoices_hist(number, period_begin, period_end, date_generated, id_unit, id_responsible, total_ht, url, date_paid, is_paid)"
                . " values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $this->runRequest($sql, array($number, $period_begin, $period_end, $date_generated, $id_unit, $id_responsible, $totalHT, $url, $date_paid, $is_paid));
        return $this->getDatabase()->lastInsertId();
    }

    /**
     * Set the status of a bill 
     * @param number $id ID of the bill
     * @param number $is_paid Paid status
     */
    public function setPaid($id, $is_paid) {
        $sql = "update ps_invoices_hist set is_paid=? where id=?";
        $this->runRequest($sql, array($is_paid, $id));
    }

    /**
     * get bills informations
     *
     * @param string $sortentry Entry that is used to sort the units
     * @return multitype: array
     */
    public function getAll($sortentry = 'id') {

        $sql = "select * from ps_invoices_hist order by " . $sortentry . " ASC;";
        $user = $this->runRequest($sql);
        return $user->fetchAll();
    }

    /**
     * get bills informations when bill is for a unit
     * @param string $sortentry
     * @return multitype:
     */
    public function getAllInfo() {

        $sql = "SELECT ps_invoices_hist.*,
					   core_units.name AS unit,
					   core_users.name AS resp_name,
					   core_users.firstname AS resp_firstname
				FROM ps_invoices_hist
				INNER JOIN core_units ON ps_invoices_hist.id_unit = core_units.id
				INNER JOIN core_users ON ps_invoices_hist.id_responsible = core_users.id;";

        $req = $this->runRequest($sql);
        return $req->fetchAll();
    }

    /**
     * get the informations of an item
     *
     * @param int $id Id of the item to query
     * @throws Exception id the item is not found
     * @return mixed array
     */
    public function get($id) {
        $sql = "select * from ps_invoices_hist where id=?";
        $unit = $this->runRequest($sql, array($id));
        if ($unit->rowCount() == 1) {
            return $unit->fetch();
        } else {
            throw new Exception("Cannot find the item using the given id");
        }
    }


    /**
     * Edit the informations of a bill associated to a unit
     * @param number $id Bill ID
     * @param number $number
     * @param date $date_generated 
     * @param number $id_unit
     * @param number $id_responsible
     * @param date $date_paid
     * @param number $is_paid
     */
    public function edit($id, $date_paid, $is_paid, $total_ht) {

        $sql = "update ps_invoices_hist set date_paid=?, is_paid=?, total_ht=? where id=?";
        $this->runRequest($sql, array($date_paid, $is_paid, $total_ht, $id));
    }

    /**
     * Remove a bill from the table
     * @param number $id ID of the bill
     */
    public function delete($id) {
        $sql = "DELETE FROM ps_invoices_hist WHERE id = ?";
        $this->runRequest($sql, array($id));
    }

}
