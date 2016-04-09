<?php

require_once 'Framework/Model.php';

class PsAnimal extends Model {

    public function createTable() {

        $sql = "CREATE TABLE IF NOT EXISTS `ps_animals` (
                        `id` int(11) NOT NULL AUTO_INCREMENT,
                        `id_project` varchar(50) NOT NULL,
                        `no_animal` int(11) NOT NULL,
                        `date_entry` date NOT NULL,
                        `lineage` varchar(50) NOT NULL,
                        `birth_date` varchar(150) NOT NULL,
                        `father` varchar(50) NOT NULL,
                        `mother` varchar(50) NOT NULL,
                        `sexe` varchar(50) NOT NULL,
                        `type_animal` varchar(50) NOT NULL,
                        `genotypage` varchar(50) NOT NULL,
                        `supplier` int(11) NOT NULL,
                        `num_bon` varchar(50) NOT NULL,
                        `observation` varchar(500) NOT NULL,
                        `date_exit` date NOT NULL,
                        `exit_reason` varchar(50) NOT NULL,
                        `entry_reason` varchar(50) NOT NULL,
                        `user1` int(11) NOT NULL,
                        `user2` int(11) NOT NULL,
                        `collaboration` varchar(150) NOT NULL,
                        `avertissement` varchar(500) NOT NULL,
                        PRIMARY KEY (`id`)
                    );";

        $this->runRequest($sql);

        $sqlH = "CREATE TABLE IF NOT EXISTS `ps_history` (
                        `id_animal` int(11) NOT NULL,
                        `id_sector` int(11) NOT NULL,
                        `date_entry` date NOT NULL,
                        `date_exit` date NOT NULL,
                        `id_unit` int(11) NOT NULL,
                        `no_room` varchar(100) NOT NULL
                        );";
        $this->runRequest($sqlH);
    }

    public function add($id_project, $id_unit, $nbr_animals, $no_animals, $id_sector, $no_salle, $type_animal, $date_entry, $entry_reason, $lineage, $birth_date, $father, $mother, $sexe, $genotypage, $supplier, $collaboration, $num_bon, $user1, $user2, $observation
    ) {

        $no_animals--; // = $no_animals -1;
        for ($i = 0; $i < $nbr_animals; $i++) {
            $no_animals++; //=$no_animals+1;

            $idanimal = $this->addOne($id_project, $no_animals, $type_animal, $date_entry, $entry_reason, $lineage, $birth_date, $father, $mother, $sexe, $genotypage, $supplier, $collaboration, $num_bon, $user1, $user2, $observation);

            $this->addhistory($idanimal, $id_sector, $date_entry, "", $id_unit, $no_salle);
        }
    }

    public function addOne($id_project, $no_animals, $type_animal, $date_entry, $entry_reason, $lineage, $birth_date, $father, $mother, $sexe, $genotypage, $supplier, $collaboration, $num_bon, $user1, $user2, $observation) {

        $sql = "INSERT INTO ps_animals (id_project, no_animal, type_animal, date_entry, entry_reason, 
                                            lineage, birth_date, father, mother, sexe, 
                                            genotypage, supplier, collaboration,
                                            num_bon, user1, user2, observation
                                            ) 
                                VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

        $this->runRequest($sql, array($id_project, $no_animals,
            $type_animal, $date_entry, $entry_reason,
            $lineage, $birth_date, $father, $mother, $sexe,
            $genotypage, $supplier, $collaboration, $num_bon,
            $user1, $user2, $observation));
        return $this->getDatabase()->lastInsertId();
    }

    public function getProjectAnimalsID($id_project, $exitDate) {
        $sql = "SELECT id FROM ps_animals WHERE `date_exit`LIKE ? AND id_project=? ORDER BY no_animal ASC;";
        return $this->runRequest($sql, array($exitDate, $id_project))->fetchAll();
    }

    public function get($id) {
        $sql = "SELECT an.*, proj.name as name, user.name as userName, user.firstname as userFirstname,
                        fourn.name as aupplierName
			FROM ps_animals as an
                        INNER JOIN ps_projects AS proj ON an.id_project = proj.id
                        INNER JOIN core_users AS user ON an.user1 = user.id
                        INNER JOIN ps_suppliers AS fourn ON an.supplier = fourn.id "
                . "WHERE an.id=?";

        $animal = $this->runRequest($sql, array($id))->fetch();

        // get the history for each animals
        $sql = "SELECT hist.*, unit.name as unitName, sector.name as sectorName "
                . "FROM ps_history as hist "
                . "INNER JOIN core_units AS unit ON hist.id_unit = unit.id "
                . "INNER JOIN ps_sectors AS sector ON hist.id_sector = sector.id "
                . "WHERE id_animal=? ORDER BY date_entry DESC; ";
        $animal["hist"] = $this->runRequest($sql, array($id))->fetchAll();

        return $animal;
    }

    public function getAnimalIn($beginPeriod, $endPeriod, $anType){
        $sql = "SELECT an.*, proj.name as projectName, user.name as userName, user.firstname as userFirstname,
                        fourn.name as supplierName
			FROM ps_animals as an
                        INNER JOIN ps_projects AS proj ON an.id_project = proj.id
                        INNER JOIN core_users AS user ON an.user1 = user.id
                        INNER JOIN ps_suppliers AS fourn ON an.supplier = fourn.id";
        $sql .= " WHERE an.date_entry >= ? AND an.date_exit <= ? AND an.type_animal=?";
        
        $animals = $this->runRequest($sql, array($beginPeriod, $endPeriod, $anType))->fetchAll();
        
        // get the history for each animals
        for ($i = 0; $i < count($animals); $i++) {
            $sql = "SELECT hist.*, unit.name as unitName, sector.name as sectorName "
                    . "FROM ps_history as hist "
                    . "INNER JOIN core_units AS unit ON hist.id_unit = unit.id "
                    . "INNER JOIN ps_sectors AS sector ON hist.id_sector = sector.id "
                    . "WHERE id_animal=? ORDER BY date_entry DESC; ";
            $animals[$i]["hist"] = $this->runRequest($sql, array($animals[$i]["id"]))->fetchAll();
        }
        return $animals;
        
    }
    
    public function getProjectAnimals($id_project, $isOut = false) {
        $sql = "SELECT an.*, proj.name as name, user.name as userName, user.firstname as userFirstname,
                        fourn.name as supplierName
			FROM ps_animals as an
                        INNER JOIN ps_projects AS proj ON an.id_project = proj.id
                        INNER JOIN core_users AS user ON an.user1 = user.id
                        INNER JOIN ps_suppliers AS fourn ON an.supplier = fourn.id";

        if ($isOut) {
            $sql .= " WHERE `date_exit` NOT LIKE ? AND an.id_project=? ORDER BY an.no_animal ASC;";
        } else {
            $sql .= " WHERE `date_exit` LIKE ? AND an.id_project=? ORDER BY an.no_animal ASC;";
        }


        $animals = $this->runRequest($sql, array("0000-00-00", $id_project))->fetchAll();

        // get the history for each animals
        for ($i = 0; $i < count($animals); $i++) {
            $sql = "SELECT hist.*, unit.name as unitName, sector.name as sectorName "
                    . "FROM ps_history as hist "
                    . "INNER JOIN core_units AS unit ON hist.id_unit = unit.id "
                    . "INNER JOIN ps_sectors AS sector ON hist.id_sector = sector.id "
                    . "WHERE id_animal=? ORDER BY date_entry DESC; ";
            $animals[$i]["hist"] = $this->runRequest($sql, array($animals[$i]["id"]))->fetchAll();
        }
        return $animals;
    }

    public function exitAnimal($id, $date_exit, $exit_reason) {
        // exit in the animal table
        $sql = "UPDATE ps_animals SET date_exit=?, exit_reason=? WHERE id=?";
        $this->runRequest($sql, array($date_exit, $exit_reason, $id));
        
        // exit in the history table
        $sql1 = "SELECT * FROM ps_history WHERE id_animal=? ORDER BY date_entry DESC;";
        $histInfo = $this->runRequest($sql1, array($id))->fetch();
       
        $sql2 = "UPDATE ps_history SET date_exit=? WHERE id_animal=? AND id_sector=? AND date_entry=?;";   
        $this->runRequest($sql2, array($date_exit, $histInfo["id_animal"], $histInfo["id_sector"], $histInfo["date_entry"]));
        
    }

    public function update($id, $no_animal, $id_projet, $date_entry, $entry_reason, $lineage, $birth_date, $father, $mother, $sexe, $genotypage, $supplier, $collaboration, $num_bon, $user1, $user2, $date_exit, $exit_reason, $observation, $warning) {

        $sql = "UPDATE ps_animals SET no_animal=?, id_project=?, date_entry=?, entry_reason=?, lineage=?, birth_date=?,
                      father=?, mother=?, sexe=?, genotypage=?, supplier=?, collaboration=?, num_bon=?,
                      user1=?, user2=?, date_exit=?, exit_reason=?, observation=?, avertissement=?
                 WHERE id=?";

        $this->runRequest($sql, array($no_animal, $id_projet, $date_entry, $entry_reason, $lineage, $birth_date,
            $father, $mother, $sexe, $genotypage, $supplier, $collaboration, $num_bon,
            $user1, $user2, $date_exit, $exit_reason, $observation, $warning, $id));
    }

    public function updatehistory($id, $sector, $date_entry_sect, $date_exit_sect, $unit_hist, $no_room) {
        $this->deletehistory($id);
        for ($i = 0; $i < count($sector); $i++) {
            $this->addhistory($id, $sector[$i], $date_entry_sect[$i], $date_exit_sect[$i], $unit_hist[$i], $no_room[$i]);
        }
    }

    public function addhistory($id, $sector, $date_entry_sect, $date_exit_sect, $unit_hist, $no_room) {
        $sql = "INSERT INTO ps_history (id_animal, id_sector, date_entry, date_exit, id_unit, no_room) VALUES (?,?,?,?,?,?)";
        $this->runRequest($sql, array($id, $sector, $date_entry_sect, $date_exit_sect, $unit_hist, $no_room));
    }

    public function deletehistory($id) {
        $sql = "DELETE FROM `ps_history` WHERE id_animal=?";
        $this->runRequest($sql, array($id));
    }

    public function delete($id){
        $sql = "DELETE FROM `ps_animals` WHERE id=?";
        $this->runRequest($sql, array($id));
        
        $this->deletehistory($id);
    }
    
    public function countNumberOfDays($beginPeriod, $endPeriod, $id_sector, $id_type, $responsibleID){
        
        // get the opened projects of the responsible
        $sql = "SELECT id FROM ps_projects WHERE id_responsible=?";
        $req = $this->runRequest($sql, array($responsibleID));
        $projects = $req->fetchAll();
        
        $numDays = 0;
        // count the number of animals in each projects
        foreach($projects as $projectid){
            
            //echo "projectid = " . print_r($projectid) . "<br/>"; 
            $sql = "SELECT * FROM ps_history WHERE id_sector=? AND id_animal IN (SELECT id FROM ps_animals WHERE id_project=? AND type_animal=?)";  
            $req = $this->runRequest($sql, array($id_sector, $projectid["id"], $id_type));
            $hists = $req->fetchAll();
            
            //print_r($hists); echo "<br/>";
            
            foreach($hists as $hist){
                
                $entryDate = $hist["date_entry"];
                $exitDate = $hist["date_exit"];
                if ($hist["date_exit"] == "0000-00-00" || $hist["date_exit"] == ""){
                    $exitDate = $endPeriod;
                }
                
                if ($entryDate < $endPeriod && $exitDate > $beginPeriod ){ 
                    
                    $endPricing = $endPeriod;
                    if ( $exitDate <  $endPeriod){
                        $endPricing = $exitDate;
                    }
                    
                    $startPricing = $beginPeriod;
                    if ( $entryDate > $beginPeriod){
                        $startPricing = $entryDate;
                    }
                    
                    //echo "add animal period = from " . $startPricing . " to " . $endPricing . "<br/>";
                    //echo "entryDate = " . $entryDate . " exitDate = " . $exitDate . "<br/> <br/>";
                    $numDays += $this->countDays($startPricing, $endPricing);
                }
            }
        }
        return $numDays;
    }
    
    protected function countDays($date1, $date2){
        $d2 = strtotime($date2); // or your date as well
        $d1 = strtotime($date1);
        $datediff = abs($d2 - $d1);
        return floor($datediff/(60*60*24));
    }
}
