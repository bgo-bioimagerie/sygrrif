<?php

require_once 'Framework/ModelAuto.php';

/**
 * Class defining the template table model. 
 *
 * @author Sylvain Prigent
 */
class WbCarousel extends ModelAuto {

	public function __construct() {
            $this->tableName = "wb_carousel";
            $this->setColumnsInfo("id", "int(11)", "");
            $this->setColumnsInfo("title", "varchar(100)", "");
            $this->setColumnsInfo("description", "varchar(300)", "");
            $this->setColumnsInfo("image_url", "varchar(300)", "");
            $this->setColumnsInfo("link_url", "varchar(300)", "");
            $this->setColumnsInfo("display_order", "int(2)", 0);
            $this->primaryKey = "id";
        }
	
        public function createDefault(){
            for ($i = 1 ; $i < 4 ; $i++){
                if (!$this->isEntry("id", $i)){
                    $this->insert(array("id" => $i, "title" => "", 
                                        "description" => "", "image_url" => "",
                                        "image_url" => "", "link_url" => "", "display_order" =>$i));
                }
            }
        }
}