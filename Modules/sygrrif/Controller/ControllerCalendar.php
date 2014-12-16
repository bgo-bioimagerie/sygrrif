<?php

require_once 'Framework/Controller.php';
require_once 'Modules/sygrrif/Controller/ControllerBooking.php';
require_once 'Modules/sygrrif/Model/SyResourceCalendar.php';
require_once 'Modules/sygrrif/Model/SyResource.php';
require_once 'Modules/sygrrif/Model/SyResourceType.php';
require_once 'Modules/sygrrif/Model/SyPricing.php';
require_once 'Modules/sygrrif/Model/SyResourcesCategory.php';
require_once 'Modules/sygrrif/Model/SyArea.php';
require_once 'Modules/sygrrif/Model/SyResourcePricing.php';

class ControllerCalendar extends ControllerBooking {

	public function index() {
		
	}
	
	public function editcalendarresource(){
		
		$id = "";
		if ($this->request->isParameterNotEmpty("actionid")) {
			$id = $this->request->getParameter ( "actionid" );
		}
		
		// default values
		$name = "";
		$description = "";
		$accessibility_id = 4;
		$category_id = 0;
		$area_id = 0;
		// default values specific
		$nb_people_max = -1;
		$available_days = "1,1,1,1,1,1,1";
		$day_begin = 8;
		$day_end = 19;
		$size_bloc_resa = 1800;
		
		// type id
		$mrs = new SyResourceType();
		$type_id = $mrs->getTypeId("Calendar");
		
		if ($id != ""){ // get the resource informations
			
			// get common info
			$modelResource = new SyResource();
			$resourceInfo = $modelResource->resource($id);
			$name = $resourceInfo["name"]; 
			$description = $resourceInfo["description"]; 
			$accessibility_id = $resourceInfo["accessibility_id"]; 
			$type_id = $resourceInfo["type_id"]; 
			$category_id = $resourceInfo["category_id"]; 
			$area_id = $resourceInfo["area_id"]; 
			
			$modelCResource = new SyResourceCalendar();
			$resourceCInfo = $modelCResource->resource($id);
			$nb_people_max = $resourceCInfo["nb_people_max"];
			$available_days = $resourceCInfo["available_days"];
			$day_begin = $resourceCInfo["day_begin"];
			$day_end = $resourceCInfo["day_end"];
			$size_bloc_resa = $resourceCInfo["size_bloc_resa"];
		}
		
		// parse de days
		$days_array = explode(",", $available_days);

		// pricing
		$modelPricing = new SyPricing();
		$pricingTable = $modelPricing->getPrices();
		
		// fill the pricing table with the prices for this resource
		$modelResourcesPricing = new SyResourcePricing();
		for ($i = 0 ; $i < count($pricingTable) ; ++$i){
			$pid = $pricingTable[$i]['id'];
			$inter = $modelResourcesPricing->getPrice($id, $pid);
			$pricingTable[$i]['val_day'] = $inter['price_day'];
			$pricingTable[$i]['val_night'] = $inter['price_night'];
			$pricingTable[$i]['val_we'] = $inter['price_we'];
		}
		
		// resources categories
		$modelcategory = new SyResourcesCategory();
		$cateoriesList = $modelcategory->getResourcesCategories("name");
		
		// areas list
		$modelArea = new SyArea();
		$areasList = $modelArea->getAreasIDName();
		
		// view
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'id' => $id,
				'name' => $name,
				'description' => $description,
				'accessibility_id' => $accessibility_id,
				'type_id' => $type_id,
				'category_id' => $category_id,
				'nb_people_max' => $nb_people_max,
				'available_days' => $available_days,
				'day_begin' => $day_begin,
				'day_end' => $day_end,
				'size_bloc_resa' => $size_bloc_resa,
				'days_array' => $days_array,
				'pricingTable'=> $pricingTable,
				'cateoriesList' => $cateoriesList,
				'areasList' => $areasList,
				'area_id' => $area_id
		) );
		
	}
	
	public function editcalendarresourcequery(){
		
		// general data
		$id = $this->request->getParameterNoException('id');
		$name = $this->request->getParameter("name");
		$description = $this->request->getParameter("description");
		$accessibility_id = $this->request->getParameter("accessibility_id");
		$category_id = $this->request->getParameter("category_id");
		$area_id = $this->request->getParameter("area_id");
		
		// type id
		$mrs = new SyResourceType();
		$type_id = $mrs->getTypeId("Calendar");
		
		$modelResource = new SyResource();
		$id_resource = $id;
		if ($id == ""){
			$id_resource = $modelResource->addResource($name, $description, $accessibility_id, $type_id, $area_id, $category_id);
		}
		else{
			$modelResource->editResource($id, $name, $description, $accessibility_id, $type_id, $area_id, $category_id);
		}
		
		// specific to calendar query
		$nb_people_max = $this->request->getParameter("nb_people_max");
		$day_begin = $this->request->getParameter("day_begin");
		$day_end = $this->request->getParameter("day_end");
		$size_bloc_resa = $this->request->getParameter("size_bloc_resa");

		$lundi = $this->request->getParameterNoException ( "monday");
		$mardi = $this->request->getParameterNoException ( "tuesday");
		$mercredi = $this->request->getParameterNoException ( "wednesday");
		$jeudi = $this->request->getParameterNoException ( "thursday");
		$vendredi = $this->request->getParameterNoException ( "friday");
		$samedi = $this->request->getParameterNoException ( "saturday");
		$dimanche = $this->request->getParameterNoException ( "sunday");
		
		if ($lundi != ""){$lundi = "1";}else{$lundi = "0";}
		if ($mardi != ""){$mardi = "1";}else{$mardi = "0";}
		if ($mercredi != ""){$mercredi = "1";}else{$mercredi = "0";}
		if ($jeudi != ""){$jeudi = "1";}else{$jeudi = "0";}
		if ($vendredi != ""){$vendredi = "1";}else{$vendredi = "0";}
		if ($samedi != ""){$samedi = "1";}else{$samedi = "0";}
		if ($dimanche != ""){$dimanche = "1";}else{$dimanche = "0";}
		
		$available_days = $lundi . "," . $mardi . "," . $mercredi . "," . $jeudi . "," . $vendredi . "," . $samedi . "," . $dimanche;
		
		$modelCResource = new SyResourceCalendar();
		$modelCResource->setResource($id_resource, $nb_people_max, $available_days, $day_begin, $day_end, $size_bloc_resa);
		
		// pricing
		$modelResourcePricing = new SyResourcePricing();
		$modelPricing = new SyPricing();
		$pricingTable = $modelPricing->getPrices();
		foreach ($pricingTable as $pricing){
			$pid = $pricing['id'];
			$pname = $pricing['tarif_name'];
			$punique = $pricing['tarif_unique'];
			$pnight = $pricing['tarif_night'];
			$pwe = $pricing['tarif_we'];
			$priceDay = $this->request->getParameter ($pid. "_day");
			$price_night = 0;
			if ($pnight){
				$price_night = $this->request->getParameter ($pid . "_night");
			}
			$price_we = 0;
			if ($pwe){
				$price_we = $this->request->getParameter ($pid . "_we");
			}
		
			$modelResourcePricing->setPricing($id_resource, $pid, $priceDay, $price_night, $price_we);
		}
		
		$this->redirect("sygrrif", "resources");
	}
	
	public function day(){
		
		$curentAreaId = 1;
		$curentResource = 1;
		$curentDate = date("Y-m-d", time());
		$menuData = $this->calendarMenuData($curentAreaId, $curentResource, $curentDate);
		
		// view
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'menuData' => $menuData
		) );
	}
	
}