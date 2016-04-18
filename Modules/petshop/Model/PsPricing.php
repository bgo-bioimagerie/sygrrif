<?php

require_once 'Framework/Model.php';

class PsPricing extends Model {

    public function createTable() {

        // joint prices
        $sql = "CREATE TABLE IF NOT EXISTS `ps_pricings` (
				`id_sector` int(11) NOT NULL,
                                `id_belonging` int(11) NOT NULL,
                                `id_type` int(11) NOT NULL,
				`price` varchar(30) NOT NULL
				);";
        $this->runRequest($sql);
    }

    public function getPrices($id_sector) {
        $sql = "SELECT * FROM ps_pricings WHERE id_sector=?";
        $secteur = $this->runRequest($sql, array($id_sector))->fetchAll();
        return $secteur;
    }

    public function addPricing($id_sector, $id_belonging, $id_type, $price) {

        $sql = "INSERT INTO ps_pricings (id_sector, id_belonging, id_type, price)
				 VALUES(?,?,?,?)";
        $pdo = $this->runRequest($sql, array(
            $id_sector, $id_belonging, $id_type, $price
        ));
        return $pdo;
    }
    
    public function getPrice($id_sector, $id_belonging, $id_type){
        $sql = "select price from ps_pricings where id_sector=? AND id_belonging=? AND id_type=?";
        $req = $this->runRequest($sql, array($id_sector, $id_belonging, $id_type));
        if($req->rowCount() == 1){
            $tmp = $req->fetch();
            return $tmp[0];
        }
        return 0;
    }

    public function editPricing($id_sector, $id_belonging, $id_type, $price) {

        $sql = "update ps_pricings set price=?
		        where id_sector=? AND id_belonging=? AND id_type=?";
        $this->runRequest($sql, array($price, $id_sector, $id_belonging, $id_type));
    }

    public function setPricing($id_sector, $id_belonging, $id_type, $price) {

        if ($this->isPricing($id_sector, $id_belonging, $id_type)) {
            $this->editPricing($id_sector, $id_belonging, $id_type, $price);
        } else {
            $this->addPricing($id_sector, $id_belonging, $id_type, $price);
        }
    }

    public function isPricing($id_sector, $id_belonging, $id_type) {
        $sql = "select * from ps_pricings where id_sector=? AND id_belonging=? AND id_type=?";
        $user = $this->runRequest($sql, array($id_sector, $id_belonging, $id_type));
        return ($user->rowCount() == 1);
    }

    public function delete($id) {
        $sql = "DELETE FROM ps_pricings WHERE id=?";
        $this->runRequest($sql, array($id));
    }

}
