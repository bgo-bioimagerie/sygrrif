<?php

require_once 'Framework/ModelGRR.php';

/**
 * Class defining the GRR area model
 *
 * @author Sylvain Prigent
 */
class SyAreaGRR extends ModelGRR {

	public function getAreaName($id){

		$sql = "select area_name from grr_area where id=?;";
		$data = $this->runRequest($sql, array($id));
		if ($data->rowCount () == 1)
			return $data->fetch ()[0]; // get the first line of the result
		else
			return "not found";
	}
	
	public function getAreasIDName(){
		$sql = "select id, area_name from grr_area;";
		$data = $this->runRequest($sql);
		return $data->fetchAll();
	}

}