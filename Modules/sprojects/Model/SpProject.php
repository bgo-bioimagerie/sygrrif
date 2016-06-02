<?php

require_once 'Framework/Model.php';
require_once 'Modules/core/Model/CoreUser.php';
require_once 'Modules/core/Model/CoreConfig.php';
require_once 'Modules/sprojects/Model/SpItemPricing.php';

/**
 * Class defining the Consomable items model
 *
 * @author Sylvain Prigent
 */
class SpProject extends Model {

    public function createTable() {
        $sql = "CREATE TABLE IF NOT EXISTS `sp_projects` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`name` varchar(150) NOT NULL DEFAULT '',
		`id_resp` int(11) NOT NULL,					
                `id_user` int(11) NOT NULL,
		`date_open` DATE NOT NULL,
		`date_close` DATE NOT NULL,
		`new_team` int(4) NOT NULL DEFAULT 1,
		`new_project` int(4) NOT NULL DEFAULT 1,
		`time_limit` varchar(100) NOT NULL DEFAULT '', 	
		PRIMARY KEY (`id`)
		);";

        $this->runRequest($sql);

        // add columns if no exists
        $sql2 = "SHOW COLUMNS FROM `sp_projects` LIKE 'new_team'";
        $pdo2 = $this->runRequest($sql2);
        $isColumn2 = $pdo2->fetch();
        if ($isColumn2 == false) {
            $sql = "ALTER TABLE `sp_projects` ADD `new_team` int(4) NOT NULL DEFAULT 1";
            $pdo = $this->runRequest($sql);
        }

        $sql3 = "SHOW COLUMNS FROM `sp_projects` LIKE 'new_project'";
        $pdo3 = $this->runRequest($sql3);
        $isColumn3 = $pdo3->fetch();
        if ($isColumn3 == false) {
            $sql = "ALTER TABLE `sp_projects` ADD `new_project` int(4) NOT NULL DEFAULT 1";
            $pdo = $this->runRequest($sql);
        }

        $sql4 = "SHOW COLUMNS FROM `sp_projects` LIKE 'time_limit'";
        $pdo4 = $this->runRequest($sql4);
        $isColumn4 = $pdo4->fetch();
        if ($isColumn4 == false) {
            $sql = "ALTER TABLE `sp_projects` ADD `time_limit` varchar(100) NOT NULL DEFAULT ''";
            $pdo = $this->runRequest($sql);
        }

        // entries
        $sql5 = "CREATE TABLE IF NOT EXISTS `sp_projects_entries` (
		`id_proj` int(11) NOT NULL,
		`date` DATE NOT NULL,
                `id_item` int(11) NOT NULL, 
		`quantity` varchar(150) NOT NULL,
                `comment` varchar(150) NOT NULL,
                `invoice_id` int(11) NOT NULL DEFAULT '0'
		);";

        $this->runRequest($sql5);
        $this->addColumn("sp_projects_entries", "invoice_id", "int(11)", "0");
        $this->addColumn("sp_projects_entries", "comment", "varchar(300)", "");
    }

    public function getProjectItemEntries($id_proj, $id_item) {
        $sql = "select * from sp_projects_entries where id_proj=? AND id_item=?";
        $req = $this->runRequest($sql, array(
            $id_proj,
            $id_item
        ));
        return $req->fetchAll();
    }
    
    public function getProjectEntries($id_proj) {
        $sql = "select * from sp_projects_entries where id_proj=?";
        $req = $this->runRequest($sql, array(
            $id_proj
        ));
        $entries = $req->fetchAll();
        
        $modelBill = new SpBill();
        for($i = 0 ; $i < count($entries) ; $i++){
            if ($entries[$i]["invoice_id"] > 0){
                $entries[$i]["invoice"] = $modelBill->getBillNumber($entries[$i]["invoice_id"]);
            }
        }
        
        return $entries;
    }

    public function getPeriodProjectEntries($id_proj, $beginPeriod, $endPeriod){
        $sql = "select * from sp_projects_entries where id_proj=? AND date>=? AND date<=?";
        $req = $this->runRequest($sql, array(
            $id_proj, $beginPeriod, $endPeriod
        ));
        $entries = $req->fetchAll();
        
        $modelBill = new SpBill();
        for($i = 0 ; $i < count($entries) ; $i++){
            if ($entries[$i]["invoice_id"] > 0){
                $entries[$i]["invoice"] = $modelBill->getBillNumber($entries[$i]["invoice_id"]);
            }
        }
        
        return $entries;
    }
    
    public function getPeriodBilledProjectEntries($id_proj, $beginPeriod, $endPeriod){
        $sql = "select * from sp_projects_entries where id_proj=? AND invoice_id IN (SELECT id FROM sp_bills WHERE date_generated>=? AND date_generated<=?)";
        $req = $this->runRequest($sql, array(
            $id_proj, $beginPeriod, $endPeriod
        ));
        $entries = $req->fetchAll();
        
        $modelBill = new SpBill();
        for($i = 0 ; $i < count($entries) ; $i++){
            if ($entries[$i]["invoice_id"] > 0){
                $entries[$i]["invoice"] = $modelBill->getBillNumber($entries[$i]["invoice_id"]);
            }
        }
        
        return $entries;
    }
    
    public function getProjectEntriesItemsIds($id_proj) {
        $sql = "select id from sp_projects_entries where id_proj=?";
        $req = $this->runRequest($sql, array(
            $id_proj
        ));
        return $req->fetchAll();
    }

    public function getProjectEntriesItems($id_proj) {
        
        $sql = "SELECT * FROM sp_items WHERE id IN(select distinct id_item from sp_projects_entries where id_proj=?) ORDER BY display_order ASC;";
        $req = $this->runRequest($sql, array(
            $id_proj
        ));
        return $req->fetchAll();

    }

    public function addProject($name, $id_resp, $id_user, $date_open, $date_close, $new_team, $new_project, $time_limit) {
        $sql = "INSERT INTO sp_projects (name, id_resp, id_user, date_open, date_close, new_team, new_project, time_limit)
				 VALUES(?,?,?,?,?,?,?,?)";
        $pdo = $this->runRequest($sql, array(
            $name,
            $id_resp,
            $id_user,
            $date_open,
            $date_close,
            $new_team,
            $new_project,
            $time_limit
        ));
        return $this->getDatabase()->lastInsertId();
    }

    public function updateProject($id, $name, $id_resp, $id_user, $date_open, $date_close, $new_team, $new_project, $time_limit) {
        $sql = "update sp_projects set name=?, id_resp=?, id_user=?, date_open=?, date_close=?, new_team=?, new_project=?, time_limit=?
		        where id=?";
        $this->runRequest($sql, array(
            $name,
            $id_resp,
            $id_user,
            $date_open,
            $date_close,
            $new_team,
            $new_project,
            $time_limit,
            $id
        ));
    }

    public function closeProject($id_project) {
        $sql = "update sp_projects set date_close=?
		        where id=?";
        $this->runRequest($sql, array(
            date("Y-m-d"),
            $id_project
        ));
    }

    public function setProject($id, $name, $id_resp, $id_user, $date_open, $date_close, $new_team, $new_project, $time_limit) {
        if ($this->isProject($id)) {
            $this->updateProject($id, $name, $id_resp, $id_user, $date_open, $date_close, $new_team, $new_project, $time_limit);
            return $id;
        } else {
            return $this->addProject($name, $id_resp, $id_user, $date_open, $date_close, $new_team, $new_project, $time_limit);
        }
    }

    public function isProject($id) {
        $sql = "select * from sp_projects where id=?";
        $unit = $this->runRequest($sql, array(
            $id
        ));
        if ($unit->rowCount() == 1){
            return true;
        }
        else{
            return false;
        }
    }

    public function getResponsible($id_project) {
        $sql = "SELECT id_resp FROM sp_projects WHERE id=?";
        $query = $this->runRequest($sql, array($id_project));
        $resp = $query->fetch();
        return $resp[0];
    }

    public function getUser($id_project) {
        $sql = "SELECT id_user FROM sp_projects WHERE id=?";
        $query = $this->runRequest($sql, array($id_project));
        $user = $query->fetch();
        return $user[0];
    }

    public function projects($sortentry = 'id') {
        $sql = "select * from sp_projects order by " . $sortentry . " ASC;";
        $req = $this->runRequest($sql);
        $entries = $req->fetchAll();

        $modelConfig = new CoreConfig ();
        $modelUser = new CoreUser ();
        
        for ($i = 0; $i < count($entries); $i ++) {
            $entries [$i] ["user_name"] = $modelUser->getUserFUllName($entries [$i] ['id_user']);
        }
        return $entries;
    }

    public function openedProjects($sortentry = 'id') {
        $sql = "select * from sp_projects where date_close='0000-00-00' order by " . $sortentry . " ASC;";
        $req = $this->runRequest($sql);

        $entries = $req->fetchAll();
        
        $modelUser = new CoreUser ();
        
        for ($i = 0; $i < count($entries); $i ++) {
            $entries [$i] ["user_name"] = $modelUser->getUserFUllName($entries [$i] ['id_user']);
        }
        return $entries;
    }

    public function closedProjects($sortentry = 'id') {
        $sql = "select * from sp_projects where date_close!='0000-00-00' order by " . $sortentry . " ASC;";
        $req = $this->runRequest($sql);

        $entries = $req->fetchAll();

        $modelUser = new CoreUser ();
        
        for ($i = 0; $i < count($entries); $i ++) {
            $entries [$i] ["user_name"] = $modelUser->getUserFUllName($entries [$i] ['id_user']);
        }
        return $entries;
    }

    public function defaultProjectValues() {
        $entry ["id"] = "";
        $entry ["name"] = "";
        $entry ["id_resp"] = 1;
        $entry ["id_user"] = 1;
        $entry ["id_status"] = 1;
        $entry ["date_open"] = date("Y-m-d", time());
        $entry ["date_close"] = "";
        $entry ["time_limit"] = "";
        return $entry;
    }

    public function getProject($id) {
        $sql = "select * from sp_projects where id=?";
        $req = $this->runRequest($sql, array(
            $id
        ));
        $entry = $req->fetch();

        return $entry;
    }

    // entries
    public function setProjectEntry($id_proj, $cdate, $ciditem, $cquantity, $ccomment, $cinvoiceid) {
        return $this->addProjectEntry($id_proj, $cdate, $ciditem, $cquantity, $ccomment, $cinvoiceid);
    }

    public function isProjectEntry($id) {
        $sql = "select * from sp_projects_entries where id=?";
        $unit = $this->runRequest($sql, array(
            $id
        ));
        if ($unit->rowCount() == 1){
            return true;
        }
        else{
            return false;
        }
    }

    public function addProjectEntry($id_proj, $cdate, $ciditem, $cquantity, $ccomment, $cinvoiceid) {
        $sql = "INSERT INTO sp_projects_entries (id_proj, date, id_item, quantity, comment, invoice_id)
				 VALUES(?,?,?,?,?,?)";
        $this->runRequest($sql, array(
            $id_proj,
            $cdate,
            $ciditem,
            $cquantity,
            $ccomment,
            $cinvoiceid
        ));
        return $this->getDatabase()->lastInsertId();
    }
    
    public function setEntryInvoiceId($id_project, $invoice_id){
        $sql = "update sp_projects_entries set invoice_id=?
		        where id_proj=? AND invoice_id=0";
        $this->runRequest($sql, array(
            $invoice_id,
            $id_project
        ));
    }

    public function setProjectCloded($id) {
        $sql = "update sp_projects set id_status=0, date_close=?
		        where id=?";
        $this->runRequest($sql, array(
            date("Y-m-d", time()),
            $id
        ));
    }

    /**
     * Delete a unit
     * 
     * @param number $id
     *        	Unit ID
     */
    public function delete($id) {
        $sql = "DELETE FROM sp_projects WHERE `id`=?";
        $this->runRequest($sql, array(
            $id
        ));
    }
    
    public function deleteAllProjetItems($id_project){
        $sql = "DELETE FROM sp_projects_entries WHERE id_proj=?";
        $this->runRequest($sql, array(
            $id_project
        ));
    }

    public function getProjectsOpenedPeriod($beginPeriod, $endPeriod) {
        $sql = "select * from sp_projects where date_open>=? AND date_open<=?";
        $req = $this->runRequest($sql, array($beginPeriod, $endPeriod));
        return $req->fetchAll();
    }

    public function getBalances($beginPeriod, $endPeriod) {
        $sql = "select * from sp_projects where date_close>=? AND date_close<=?";
        $req = $this->runRequest($sql, array($beginPeriod, $endPeriod));
        $projects = $req->fetchAll();
        $items = array();
        $modelUser = new CoreUser();
        $modelUnit = new CoreUnit();
        for ($i = 0; $i < count($projects); $i++) {

            $projectEntries = $this->getProjectEntries($projects[$i]["id"]);

            // get active items
            $activeItems = $this->getProjectItems($projectEntries);
            $itemsSummary = $this->getProjectItemsSymmary($projectEntries, $activeItems); 
            //print_r($itemsSummary);

            $projects[$i]["entries"] = $itemsSummary;
            //print_r($itemsSummary);
            foreach ($itemsSummary as $itSum){
                if ($itSum["pos"] > 0 && !in_array($itSum["id"], $items)){
                    $items[] = $itSum["id"];
                }
            }
      
            $id_unit = $modelUser->getUserUnit($projects[$i]["id_resp"]);
            $LABpricingid = $modelUnit->getBelonging($id_unit);
            $projects[$i]["total"] = $this->calculateProjectTotal($itemsSummary, $LABpricingid);
            
        }
        
        return array("items" => $items, "projects" => $projects);
    }

    public function getPeriodeServicesBalances($beginPeriod, $endPeriod){
        $sql = "select * from sp_projects where date_close<? OR date_close='0000-00-00'";
        $req = $this->runRequest($sql, array($beginPeriod));
        $projects = $req->fetchAll();
        $items = array();
        $modelUser = new CoreUser();
        $modelUnit = new CoreUnit();
        for ($i = 0; $i < count($projects); $i++) {

            $projectEntries = $this->getPeriodProjectEntries($projects[$i]["id"], $beginPeriod, $endPeriod);

            //if (count($projectEntries) > 0){
                // get active items
                $activeItems = $this->getProjectItems($projectEntries);
                $itemsSummary = $this->getProjectItemsSymmary($projectEntries, $activeItems); 
                //print_r($itemsSummary);

                $projects[$i]["entries"] = $itemsSummary;
                //print_r($itemsSummary);
                foreach ($itemsSummary as $itSum){
                    if ($itSum["pos"] > 0 && !in_array($itSum["id"], $items)){
                        $items[] = $itSum["id"];
                    }
                }

                $id_unit = $modelUser->getUserUnit($projects[$i]["id_resp"]);
                $LABpricingid = $modelUnit->getBelonging($id_unit);
                $projects[$i]["total"] = $this->calculateProjectTotal($itemsSummary, $LABpricingid);
            //}
        }
        
        return array("items" => $items, "projects" => $projects);
    }
    
    public function getPeriodeBilledServicesBalances($beginPeriod, $endPeriod){
   
        // get the projects 
        $sql1 = "select * from sp_projects where id IN (SELECT DISTINCT id_proj FROM sp_projects_entries WHERE invoice_id IN(SELECT id FROM sp_bills WHERE date_generated>=? AND date_generated<=?))";
        $req1 = $this->runRequest($sql1, array($beginPeriod, $endPeriod));
        $projects = $req1->fetchAll();
        
        $items = array();
        $modelUser = new CoreUser();
        $modelUnit = new CoreUnit();
        for ($i = 0; $i < count($projects); $i++) {

            $projectEntries = $this->getPeriodBilledProjectEntries($projects[$i]["id"], $beginPeriod, $endPeriod);

            // get active items
            $activeItems = $this->getProjectItems($projectEntries);
            $itemsSummary = $this->getProjectItemsSymmary($projectEntries, $activeItems); 
            //print_r($itemsSummary);

            $projects[$i]["entries"] = $itemsSummary;
            //print_r($itemsSummary);
            foreach ($itemsSummary as $itSum){
                if ($itSum["pos"] > 0 && !in_array($itSum["id"], $items)){
                    $items[] = $itSum["id"];
                }
            }
      
            $id_unit = $modelUser->getUserUnit($projects[$i]["id_resp"]);
            $LABpricingid = $modelUnit->getBelonging($id_unit);
            $projects[$i]["total"] = $this->calculateProjectTotal($itemsSummary, $LABpricingid);
            
        }
        
        return array("items" => $items, "projects" => $projects);
    }
    
    protected function getProjectItemsSymmary($projectEntries, $activeItems){
        
        $activeItemsSummary = array();
        for ($i = 0; $i < count($activeItems); $i++) {
            $qi = 0;
            foreach ($projectEntries as $order) {
                if ( $order["id_item"] == $activeItems[$i] ){
                    $qi += $order["quantity"];
                }
            }
            $activeItemsSummary[$i]["id"] = $activeItems[$i];
            $activeItemsSummary[$i]["pos"] = 0;
            if ($qi > 0) {
                $activeItemsSummary[$i]["pos"] = 1;
                $activeItemsSummary[$i]["sum"] = $qi;
            }
        }
        return $activeItemsSummary;
    }
    
    protected function getProjectItems($projectEntries) {
        
        $projectItems = array();
        foreach ($projectEntries as $entry) {
            $itemID = $entry["id_item"];
            $found = false;
            foreach ($projectItems as $item) {
                if ($item == $itemID) {
                    $found = true;
                }
            }
            if ($found == false) {
                $projectItems[] = $itemID;
            }
        }
        return $projectItems;
        
        /*
        // get active items
        $modelItem = new SpItem();
        $activeItems = $modelItem->getActiveItems("display_order");

        // add unactive items that were ordered at the order time
        foreach ($projectEntries as $entry) {
            $items_ids = $entry["content"]["items_ids"];
            //print_r($entry["content"]);
            foreach ($items_ids as $itemID) {
                $found = false;
                foreach ($activeItems as $item) {
                    if ($item["id"] == $itemID) {
                        $found = true;
                    }
                }
                if ($found == false) {
                    $inter = $modelItem->getItem($itemID);
                    $activeItems[] = $inter;
                }
            }
        }

        return $activeItems;
        */
    }
    
    public function getRespOpenedProjects($resp){
        $sql = "SELECT id, name FROM sp_projects WHERE id_resp=?";
        $req = $this->runRequest($sql, array($resp));
        return $req->fetchAll();
    }
    
    public function setPojectItemsAsBilled($resp, $date_start, $date_end, $noBill){
        
        $modelItem = new SpItem();
        $items = $modelItem->getItems();
        
        foreach($items as $item){
            $sql = "SELECT * FROM sp_projects_entries WHERE "
                    . "id_proj IN(SELECT id FROM sp_projects WHERE id_resp=?) "
                    . "AND id_item=? "
                    . "AND invoice_id=0 "
                    . "AND date>=? "
                    . "AND date<=? ;";
            $req = $this->runRequest($sql, array($resp, $item["id"], $date_start, $date_end));
            $founditems = $req->fetchAll();
            foreach($founditems as $it){
                
                $sql = "update sp_projects_entries set invoice_id=?
		        where id_proj=? AND date=? AND id_item=? AND quantity=? AND invoice_id=0";
                $this->runRequest($sql, array($noBill, $it["id_proj"], $it["date"], $it["id_item"], $it["quantity"]  ));
                 
            }
        }
    }
    
    
    public function getProjectItemsCount($resp, $date_start, $date_end){
        
        $modelItem = new SpItem();
        $items = $modelItem->getItems();
        
        $outItem = array();
        
        foreach($items as $item){
            $count = 0;
            $sql = "SELECT * FROM sp_projects_entries WHERE "
                    . "id_proj IN(SELECT id FROM sp_projects WHERE id_resp=?) "
                    . "AND id_item=? "
                    . "AND invoice_id=0 "
                    . "AND date>=? "
                    . "AND date<=? ;";
            $req = $this->runRequest($sql, array($resp, $item["id"], $date_start, $date_end));
            $founditems = $req->fetchAll();
            foreach($founditems as $it){
                $count += $it["quantity"];
            }
            if ($count > 0){
                $outItem[] = array("id" => $item["id"], "type_id" => $item["type_id"], "name" => $item["name"], "count" => $count);
            }
        }
        return $outItem;
    }

    protected function calculateProjectTotal($activeItems, $LABpricingid){

        $totalHT = 0;
        $itemPricing = new SpItemPricing();
        foreach ($activeItems as $item) {

            if ($item["pos"] > 0) {
                $unitaryPrice = $itemPricing->getPrice($item["id"], $LABpricingid);
                $totalHT += (float) $item["sum"] * (float) $unitaryPrice["price"];
            }
        }
        return $totalHT;
    }
}
