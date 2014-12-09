<?php

require_once 'Framework/ModelGRR.php';
require_once 'Modules/sygrrif/Model/SyResourceTypeGRR.php';
require_once 'Modules/sygrrif/Model/SyAreaGRR.php';
require_once 'Modules/sygrrif/Model/SyResource.php';
require_once 'Modules/sygrrif/Model/SyResourcesCategory.php';

/**
 * Class defining the GRR resource model
 *
 * @author Sylvain Prigent
 */
class SyResourceGRR extends ModelGRR {
	

	public function resourcesBasicInfo($sortEntry = "id"){
		
		$sql = "select id, area_id, room_name, description from grr_room order by " . $sortEntry . " ASC;";
		$data = $this->runRequest($sql);
		return $data->fetchAll();
	}
	
	public function resourcesInfo($sortEntry = "id"){
		$basicInfo = $this->resourcesBasicInfo($sortEntry);
		
		$modelArea = new SyAreaGRR();
		$modelType = new SyResourceTypeGRR();
		$modelRes = new SyResource();
		$modelCategory = new SyResourcesCategory();
		for ($i = 0 ; $i < count($basicInfo) ; ++$i){
			// add to sygrrif list f not exists
			if (!$modelRes->isResource($basicInfo[$i]['id'])){
				$modelRes->addResource($basicInfo[$i]['id'], $basicInfo[$i]['room_name']);
			}
			
			$basicInfo[$i]['area'] = $modelArea->getAreaName($basicInfo[$i]['area_id']);
			$typeID = $modelType->getResourceTypeID($basicInfo[$i]['id']);
			if ($typeID <= 0){
				$basicInfo[$i]['type_id'] = 1;
				$modelType->addResourceType($basicInfo[$i]['id'], 1);
			}
			else{
				$basicInfo[$i]['type_id'] = $typeID;
			}
			$basicInfo[$i]['type_name'] = $modelType->getTypeName($basicInfo[$i]['type_id'])[0];
			$categoryArray = $modelCategory->getCategory($basicInfo[$i]['id']);
			$basicInfo[$i]['id_category'] = $categoryArray['id_category'];
			$basicInfo[$i]['name_category'] = $categoryArray['name_category'];
		}
		return $basicInfo;
	}
	
	public function getResource($id){
		$sql = "select * from grr_room where id=?";
		$data = $this->runRequest($sql, array($id));
		$basicInfo = $data->fetch();
		
		//print_r($basicInfo);
		
		// get area and type info
		$modelArea = new SyAreaGRR();
		$modelType = new SyResourceTypeGRR();
		$modelCategory = new SyResourcesCategory();
		$basicInfo['area'] = $modelArea->getAreaName($basicInfo['area_id']);
		$basicInfo['type_id'] = $modelType->getResourceTypeID($basicInfo['id']);
		$basicInfo['type_name'] = $modelType->getTypeName($basicInfo['type_id'])[0];
		$basicInfo['id_category'] = $modelCategory->getCategoryID($basicInfo['id']);
		
		return $basicInfo;

	}
	
	public function addResource($room_name, $description, $id_domaine, $order_display, $who_can_see, $statut_room,
				                     $type_affichage_reser, $capacity, $max_booking, $delais_max_resa_room, $delais_min_resa_room,
				                     $delais_option_reservation, $moderate, $allow_action_in_past, $dont_allow_modify,
				                     $qui_peut_reserver_pour, $active_ressource_empruntee){
		
		$sql = "insert into grr_room
            SET room_name='".$room_name."',
            area_id='".$id_domaine."',
            description='".$description."',
            picture_room='',
            comment_room='',
            order_display='".$order_display."',		
            active_ressource_empruntee = '".$active_ressource_empruntee."',
            capacity='".$capacity."',
            delais_max_resa_room='".$delais_max_resa_room."',
            delais_min_resa_room='".$delais_min_resa_room."',
            delais_option_reservation='".$delais_option_reservation."',
            allow_action_in_past='".$allow_action_in_past."',
            dont_allow_modify='".$dont_allow_modify."',
            qui_peut_reserver_pour = '".$qui_peut_reserver_pour."',
            who_can_see = '".$who_can_see."',
            type_affichage_reser='".$type_affichage_reser."',
            max_booking='".$max_booking."',
            moderate='".$moderate."',
            statut_room='".$statut_room."'";
		$this->runRequest($sql);
		
		return $this->getDatabase()->lastInsertId();
	}
	
	public function editResource($id, $room_name, $description, $id_domaine, $order_display, $who_can_see, $statut_room,
			$type_affichage_reser, $capacity, $max_booking, $delais_max_resa_room, $delais_min_resa_room,
			$delais_option_reservation, $moderate, $allow_action_in_past, $dont_allow_modify,
			$qui_peut_reserver_pour, $active_ressource_empruntee){
	
		$sql = "update grr_room
            SET room_name='".$room_name."',
            area_id='".$id_domaine."',
            description='".$description."',
            picture_room='',
            comment_room='',
            order_display='".$order_display."',		
            active_ressource_empruntee = '".$active_ressource_empruntee."',
            capacity='".$capacity."',
            delais_max_resa_room='".$delais_max_resa_room."',
            delais_min_resa_room='".$delais_min_resa_room."',
            delais_option_reservation='".$delais_option_reservation."',
            allow_action_in_past='".$allow_action_in_past."',
            dont_allow_modify='".$dont_allow_modify."',
            qui_peut_reserver_pour = '".$qui_peut_reserver_pour."',
            who_can_see = '".$who_can_see."',
            type_affichage_reser='".$type_affichage_reser."',
            max_booking='".$max_booking."',
            moderate='".$moderate."',
            statut_room='".$statut_room."'
            where id='".$id."'";		
		$this->runRequest($sql);
	
		return $this->getDatabase()->lastInsertId();
	}
	
}
