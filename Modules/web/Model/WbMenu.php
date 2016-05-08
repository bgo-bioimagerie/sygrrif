<?php

require_once 'Framework/ModelAuto.php';

/**
 * Class defining the template table model. 
 *
 * @author Sylvain Prigent
 */
class WbMenu extends ModelAuto {

	public function __construct() {
            $this->tableName = "wb_menu";
            $this->setColumnsInfo("name", "varchar(100)", "");
            $this->setColumnsInfo("url", "text", "");
            $this->setColumnsInfo("display_order", "int(2)", 0);
            $this->primaryKey = "";
        }
	
	
}