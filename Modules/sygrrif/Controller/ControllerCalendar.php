<?php
 
require_once 'Framework/Controller.php';
require_once 'Modules/core/Model/CoreUser.php';
require_once 'Modules/core/Model/CoreProject.php';
require_once 'Modules/core/Model/CoreTranslator.php';
require_once 'Modules/core/Model/CoreBelonging.php';
require_once 'Modules/core/Model/UserSettings.php';
require_once 'Modules/sygrrif/Controller/ControllerBooking.php';
require_once 'Modules/sygrrif/Model/SyResourceCalendar.php';
require_once 'Modules/sygrrif/Model/SyResource.php';
require_once 'Modules/sygrrif/Model/SyResourceType.php';
require_once 'Modules/sygrrif/Model/SyPricing.php';
require_once 'Modules/sygrrif/Model/SyResourcesCategory.php';
require_once 'Modules/sygrrif/Model/SyArea.php';
require_once 'Modules/sygrrif/Model/SyResourcePricing.php';
require_once 'Modules/sygrrif/Model/SyResourceCalendar.php';
require_once 'Modules/sygrrif/Model/SyCalendarEntry.php';
require_once 'Modules/sygrrif/Model/SyCalendarEntry.php';
require_once 'Modules/sygrrif/Model/SyCalendarSeries.php';
require_once 'Modules/sygrrif/Model/SyTranslator.php';
require_once 'Modules/sygrrif/Model/SyCalSupplementary.php';
require_once 'Modules/mailer/Model/MailerSend.php';
require_once 'Modules/sygrrif/Model/SyBookingTableCSS.php';
require_once 'Modules/sygrrif/Model/SyPackage.php';

/**
 * Controller for the calendar booking pages
 *  
 * @author sprigent
 *
 */
class ControllerCalendar extends ControllerBooking {
	
	/**
	 * (non-PHPdoc)
	 * @see Controller::index()
	 */
	public function index() {
		
	}
	
	/**
	 * Edit form for a resource of type "calendar"
	 */
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
		$resa_time_setting = 0;
		$default_color_id = 0;
		$display_order = 0;
                $use_package = 1;
                $booking_time_scale = 1;
		
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
			$display_order = $resourceInfo["display_order"];
			
			if ($accessibility_id > $_SESSION["user_status"]){
				echo "Permission denied: you're not allowed to edit this resource";
				return;
			}
			
			$modelCResource = new SyResourceCalendar();
			$resourceCInfo = $modelCResource->resource($id);
			$nb_people_max = $resourceCInfo["nb_people_max"];
			$available_days = $resourceCInfo["available_days"];
			$day_begin = $resourceCInfo["day_begin"];
			$day_end = $resourceCInfo["day_end"];
			$size_bloc_resa = $resourceCInfo["size_bloc_resa"];
			$resa_time_setting = $resourceCInfo["resa_time_setting"];
                        $booking_time_scale = $resourceCInfo["booking_time_scale"];
			$default_color_id = $resourceCInfo["default_color_id"];
                        $use_package = $resourceCInfo["use_package"];
		}
		
		// colors
		$colorModel = new SyColorCode();
		$colors = $colorModel->getColorCodes("display_order");
		
		// parse de days
		$days_array = explode(",", $available_days);

		// pricing
		$modelPricing = new SyPricing();
		$pricingTable = $modelPricing->getPrices();
		
		// fill the pricing table with the prices for this resource
		$modelResourcesPricing = new SyResourcePricing();
		$modelBelonging = new CoreBelonging();
		for ($i = 0 ; $i < count($pricingTable) ; ++$i){
			$pid = $pricingTable[$i]['id'];
			$inter = $modelResourcesPricing->getPrice($id, $pid);
			$pricingTable[$i]['val_day'] = $inter['price_day'];
			$pricingTable[$i]['val_night'] = $inter['price_night'];
			$pricingTable[$i]['val_we'] = $inter['price_we'];
			$pricingTable[$i]['name'] = $modelBelonging->getName($pricingTable[$i]["id"]);
		}
                
                //echo 'booking_time_scale = ' . $booking_time_scale . "<br/>";
		
		// resources categories
		$modelcategory = new SyResourcesCategory();
		$cateoriesList = $modelcategory->getResourcesCategories("name");
		
		// areas list
		$modelArea = new SyArea();
		$areasList = $modelArea->getAreasIDName();
		
		// get packages
		$modelPackage = new SyPackage();
		$pakages = $modelPackage->getPrices($id);
		//print_r($pakages);
		
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
				'resa_time_setting' => $resa_time_setting,
				'days_array' => $days_array,
				'pricingTable'=> $pricingTable,
				'cateoriesList' => $cateoriesList,
				'areasList' => $areasList,
				'area_id' => $area_id,
				'colors' => $colors,
				'default_color_id' => $default_color_id,
				'display_order' => $display_order,
				'pakages' => $pakages,
                                'use_package' => $use_package,
                                'booking_time_scale' => $booking_time_scale
		) );
		
	}
	
	/**
	 * Edit query for a resource of type "calendar"
	 */
	public function editcalendarresourcequery(){
		
		// general data
		$id = $this->request->getParameterNoException('id');
		$name = $this->request->getParameter("name");
		$description = $this->request->getParameter("description");
		$accessibility_id = $this->request->getParameter("accessibility_id");
		$category_id = $this->request->getParameter("category_id");
		$area_id = $this->request->getParameter("area_id");
		$display_order = $this->request->getParameter("display_order");
                $use_package = $this->request->getParameter("use_package");
                
		if ($this->secureEditCheck($id)){
			echo "Permission denied: you're not allowed to edit this resource";
			return;
		}
		
		// type id
		$mrs = new SyResourceType();
		$type_id = $mrs->getTypeId("Calendar");
		
		$modelResource = new SyResource();
		$id_resource = $id;
		if ($id == ""){
			$id_resource = $modelResource->addResource($name, $description, $accessibility_id, $type_id, $area_id, $category_id, $display_order);
		}
		else{
			$modelResource->editResource($id, $name, $description, $accessibility_id, $type_id, $area_id, $category_id, $display_order);
		}
		
		// specific to calendar query
		$nb_people_max = $this->request->getParameter("nb_people_max");
		$day_begin = $this->request->getParameter("day_begin");
		$day_end = $this->request->getParameter("day_end");
		$size_bloc_resa = $this->request->getParameter("size_bloc_resa");
		$resa_time_setting = $this->request->getParameter('resa_time_setting');
                $booking_time_scale = $this->request->getParameter("booking_time_scale");
		$default_color_id = $this->request->getParameter("default_color_id");
                
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
		
		
		//echo "default_color_id = " . $default_color_id . "<br/>";
		
		
		$modelCResource = new SyResourceCalendar();
		$modelCResource->setResource($id_resource, $nb_people_max, $available_days, $day_begin, $day_end, $size_bloc_resa, $resa_time_setting,"", $default_color_id, $use_package, $booking_time_scale);
		
		// pricing
		$modelResourcePricing = new SyResourcePricing();
		$modelPricing = new SyPricing();
		$pricingTable = $modelPricing->getPrices();
		foreach ($pricingTable as $pricing){
			$pid = $pricing['id'];
			//$pname = $pricing['tarif_name'];
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
		
		
                // package
		$packageID = $this->request->getParameterNoException("pid");
		$packageName = $this->request->getParameterNoException("pname");
		$packageDuration = $this->request->getParameterNoException("pduration");
                
                /*
                echo "package ID = ";
                print_r($packageID); echo "<br/>";
                echo "package name = ";
                print_r($packageName); echo "<br/>";
                echo "package duration = ";
                print_r($packageDuration); echo "<br/>";
                 */
                
                // add packages
		$modelPackage = new SyPackage();
		$count = 0;
                
                // get the last package id
                $lastID = 0;
                for( $p = 0 ; $p < count($packageID) ; $p++){
                    if ($packageName[$p] != "" ){
                        if ($packageID[$p] > $lastID){
                            $lastID = $packageID[$p];
                        }
                    }
                }
                
		for( $p = 0 ; $p < count($packageID) ; $p++){
			if ($packageName[$p] != "" ){
                            $curentID = $packageID[$p];

                            if ($curentID == ""){
                                $lastID++;
                                $curentID = $lastID;
                                $packageID[$p] = $lastID;
                            }
                            if ($curentID == 1 && $p > 0){
                                $lastID++;
                                $curentID = $lastID;
                                $packageID[$p] = $lastID;
                            }

                            //echo "set package (".$curentID." , " . $id_resource ." , " . $packageName[$p]." , ". $packageDuration[$p] . ")<br/>";
                            $package_id = $modelPackage->setPackage($curentID, $id_resource, $packageName[$p], $packageDuration[$p]);

                            //echo "package id = " . $package_id . "<br/>";

                            foreach ($pricingTable as $pricing){
                                    $price = $this->request->getParameterNoException("p_" . $pricing['id']); 
                                    $modelPackage->setPrice($package_id, $pricing['id'], $price[$count]);
                            } 
                            $count++;
                        }
		}
                
                // remove packages
                $modelPackage->removeUnlistedPackages($packageID, $id_resource);
		
		$this->redirect("sygrrifareasresources", "resources");
	}
	
	/**
	 * Remove a resource of type "calendar"
	 */
	public function deletecalendarresource(){
		
		$id_resource = "";
		if ($this->request->isParameterNotEmpty("actionid")) {
			$id_resource = $this->request->getParameter ( "actionid" );
		}

		// delete the calendar resource info
		$modelCalendar = new SyResourceCalendar();
		$modelCalendar->delete($id_resource);
		
		// delete from main resource tabl
		$modelResource = new SyResource();
		$modelResource->delete($id_resource);
		
		$this->redirect("sygrrifareasresources", "resources");
	}
	
	/**
	 * Edit form for a resource of type "unitary"
	 */
	public function editunitaryresource(){
	
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
		$quantity_name = "Quantity";
		$available_days = "1,1,1,1,1,1,1";
		$day_begin = 8;
		$day_end = 19;
		$size_bloc_resa = 1800;
		$resa_time_setting = 0;
		$display_order = 0;
	
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
			$display_order = $resourceInfo["display_order"];
				
			if ($accessibility_id > $_SESSION["user_status"]){
				echo "Permission denied: you're not allowed to edit this resource";
				return;
			}
			
			$modelCResource = new SyResourceCalendar();
			$resourceCInfo = $modelCResource->resource($id);
			$quantity_name = $resourceCInfo["quantity_name"];
			$available_days = $resourceCInfo["available_days"];
			$day_begin = $resourceCInfo["day_begin"];
			$day_end = $resourceCInfo["day_end"];
			$size_bloc_resa = $resourceCInfo["size_bloc_resa"];
			$resa_time_setting = $resourceCInfo["resa_time_setting"];
		}
	
		// colors
		$colorModel = new SyColorCode();
		$colors = $colorModel->getColorCodes("display_order");
		
		// parse de days
		$days_array = explode(",", $available_days);
	
		// pricing
		$modelPricing = new SyPricing();
		$pricingTable = $modelPricing->getPrices();
	
		// fill the pricing table with the prices for this resource
		$modelResourcesPricing = new SyResourcePricing();
		$modelBelonging = new CoreBelonging();
		for ($i = 0 ; $i < count($pricingTable) ; ++$i){
			$pid = $pricingTable[$i]['id'];
			$inter = $modelResourcesPricing->getPrice($id, $pid);
			$pricingTable[$i]['val_day'] = $inter['price_day'];
			$pricingTable[$i]['val_night'] = $inter['price_night'];
			$pricingTable[$i]['val_we'] = $inter['price_we'];
			$pricingTable[$i]['name'] = $modelBelonging->getName($pricingTable[$i]["id"]);
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
				'quantity_name' => $quantity_name,
				'available_days' => $available_days,
				'day_begin' => $day_begin,
				'day_end' => $day_end,
				'size_bloc_resa' => $size_bloc_resa,
				'resa_time_setting' => $resa_time_setting,
				'days_array' => $days_array,
				'pricingTable'=> $pricingTable,
				'cateoriesList' => $cateoriesList,
				'areasList' => $areasList,
				'area_id' => $area_id,
				'display_order' => $display_order,
				'colors' => $colors
		) );
	
	}
	
	
	private function secureEditCheck($id){
		
		$modelResource = new SyResource();
		$ressourceInfo = $modelResource->resource($id);
		$accessibility_id = $ressourceInfo["accessibility_id"];
		if ($accessibility_id > $_SESSION["user_status"]){
			return true;
		}
		return false;
	}
	/**
	 * Edit qurey for a resource of type "unitary"
	 */
	public function editunitaryresourcequery(){
	
		// general data
		$id = $this->request->getParameterNoException('id');
		$name = $this->request->getParameter("name");
		$description = $this->request->getParameter("description");
		$accessibility_id = $this->request->getParameter("accessibility_id");
		$category_id = $this->request->getParameter("category_id");
		$area_id = $this->request->getParameter("area_id");
		$display_order = $this->request->getParameter("display_order");
		
		if ($this->secureEditCheck($id)){
			echo "Permission denied: you're not allowed to edit this resource";
			return;
		}
	
		// type id
		$mrs = new SyResourceType();
		$type_id = $mrs->getTypeId("Unitary Calendar");
	
		$modelResource = new SyResource();
		$id_resource = $id;
		if ($id == ""){
			$id_resource = $modelResource->addResource($name, $description, $accessibility_id, $type_id, $area_id, $category_id, $display_order);
		}
		else{
			$modelResource->editResource($id, $name, $description, $accessibility_id, $type_id, $area_id, $category_id, $display_order);
		}
	
		// specific to calendar query
		$quantity_name = $this->request->getParameter("quantity_name");
		$day_begin = $this->request->getParameter("day_begin");
		$day_end = $this->request->getParameter("day_end");
		$size_bloc_resa = $this->request->getParameter("size_bloc_resa");
		$resa_time_setting = $this->request->getParameter("resa_time_setting");
		$default_color_id = $this->request->getParameter("default_color_id");
	
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
		$modelCResource->setResource($id_resource, 0, $available_days, $day_begin, $day_end, $size_bloc_resa, $resa_time_setting, $quantity_name, $default_color_id);
	
		// pricing
		$modelResourcePricing = new SyResourcePricing();
		$modelPricing = new SyPricing();
		$pricingTable = $modelPricing->getPrices();
		foreach ($pricingTable as $pricing){
			$pid = $pricing['id'];
			//$pname = $pricing['tarif_name'];
			$punique = 1;
			$pnight = 0;
			$pwe = 0;
			$priceDay = $this->request->getParameter ($pid. "_day");
			$price_night = 0;
			$price_we = 0;
			$modelResourcePricing->setPricing($id_resource, $pid, $priceDay, $price_night, $price_we);
		}
	
		$this->redirect("sygrrifareasresources", "resources");
	}
	
	/**
	 * Edit form for a resource of type "time unitary"
	 */
	public function edittimeunitaryresource(){
		
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
		$quantity_name = "Quantity";
		$available_days = "1,1,1,1,1,1,1";
		$day_begin = 8;
		$day_end = 19;
		$size_bloc_resa = 1800;
		$resa_time_setting = 0;
		$supplies = array();
		$default_color_id = 1;
		$display_order = 0;
		
		if ($id != ""){
			// get common info
			$modelResource = new SyResource();
			$resourceInfo = $modelResource->resource($id);
			$name = $resourceInfo["name"];
			$description = $resourceInfo["description"];
			$accessibility_id = $resourceInfo["accessibility_id"];
			$type_id = $resourceInfo["type_id"];
			$category_id = $resourceInfo["category_id"];
			$area_id = $resourceInfo["area_id"];
			$display_order = $resourceInfo["display_order"];
			
			if ($accessibility_id > $_SESSION["user_status"]){
				echo "Permission denied: you're not allowed to edit this resource";
				return;
			}
			
			$modelCResource = new SyResourceCalendar();
			$resourceCInfo = $modelCResource->resource($id);
			$quantity_name = $resourceCInfo["quantity_name"];
			$supplies = explode(",", $quantity_name);
			$available_days = $resourceCInfo["available_days"];
			$day_begin = $resourceCInfo["day_begin"];
			$day_end = $resourceCInfo["day_end"];
			$size_bloc_resa = $resourceCInfo["size_bloc_resa"];
			$resa_time_setting = $resourceCInfo["resa_time_setting"];
			$default_color_id = $resourceCInfo["default_color_id"];
		}
		
		// parse de days
		$days_array = explode(",", $available_days);
		
		// type id
		$mrs = new SyResourceType();
		$type_id = $mrs->getTypeId("Calendar");
		
		// resources categories
		$modelcategory = new SyResourcesCategory();
		$cateoriesList = $modelcategory->getResourcesCategories("name");
		
		// areas list
		$modelArea = new SyArea();
		$areasList = $modelArea->getAreasIDName();
		
		// colors
		$colorModel = new SyColorCode();
		$colors = $colorModel->getColorCodes("display_order");
		
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
				'quantity_name' => $quantity_name,
				'available_days' => $available_days,
				'day_begin' => $day_begin,
				'day_end' => $day_end,
				'size_bloc_resa' => $size_bloc_resa,
				'resa_time_setting' => $resa_time_setting,
				'days_array' => $days_array,
				'cateoriesList' => $cateoriesList,
				'areasList' => $areasList,
				'area_id' => $area_id,
				'supplies' => $supplies,
				'colors' => $colors,
				'default_color_id' => $default_color_id,
				'display_order' => $display_order
		) );
	}
	
	/**
	 * Get the base information of a resource
	 * 
	 * @return array resource base informations
	 */
	private function getResourceBase(){
		// general data
		$id = $this->request->getParameterNoException('id');
		$name = $this->request->getParameter("name");
		$description = $this->request->getParameter("description");
		$accessibility_id = $this->request->getParameter("accessibility_id");
		$category_id = $this->request->getParameter("category_id");
		$area_id = $this->request->getParameter("area_id");
		$display_order = $this->request->getParameter("display_order");
		
		if ($this->secureEditCheck($id)){
			echo "Permission denied: you're not allowed to edit this resource";
			return;
		}
		
		// type id
		$mrs = new SyResourceType();
		$type_id = $mrs->getTypeId("Unitary Calendar");
		
		$resource_base = array( "id" => $id, "name" => $name, "description" => $description,
				"accessibility_id" => $accessibility_id, "category_id" => $category_id,
				"area_id" => $area_id, "display_order" => $display_order);
		return $resource_base;
	}
	
	/**
	 * Get specific informations of a resource of type "calendar"
	 * @return multitype:string unknown
	 */
	private function getResourceInfo(){
		// specific to calendar query
		$supplynames = $this->request->getParameter("supplynames");
		$day_begin = $this->request->getParameter("day_begin");
		$day_end = $this->request->getParameter("day_end");
		$size_bloc_resa = $this->request->getParameter("size_bloc_resa");
		$resa_time_setting = $this->request->getParameter("resa_time_setting");
		$default_color_id = $this->request->getParameter("default_color_id");
		
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
		
		$resource_info = array( "supplynames" => $supplynames, "day_begin" => $day_begin, "day_end" => $day_end,
				"size_bloc_resa" => $size_bloc_resa, "resa_time_setting" => $resa_time_setting,
				"default_color_id" => $default_color_id, "available_days" => $available_days);
		
		return $resource_info;
	}
	
	/**
	 * form to edit the prices for a resource of type "unitary"
	 */
	public function edittimeunitaryresourceprices(){
		
		// general data
		$resource_base = $this->getResourceBase();
		$modelResource = new SyResource();
		
		// specific info
		$resource_info = $this->getResourceInfo();
		
		// pricing
		$modelPricing = new SyPricing();
		$pricingTable = $modelPricing->getPrices();
		
		// fill the pricing table with the prices for this resource
		$modelResourcesPricing = new SyResourcePricing();
		$modelBelonging = new CoreBelonging();
		$suppliesPrices = array();
		for ($i = 0 ; $i < count($pricingTable) ; ++$i){
			$pid = $pricingTable[$i]['id'];
			$inter = $modelResourcesPricing->getPrice($resource_base["id"], $pid);
			$prices = explode(",", $inter['price_day']);
		
			$pricingTable[$i]['val_day'] = $prices[0];
			$pricingTable[$i]['val_night'] = $inter['price_night'];
			$pricingTable[$i]['val_we'] = $inter['price_we'];
			$pricingTable[$i]['name'] = $modelBelonging->getName($pricingTable[$i]["id"]);
			
			$count = 0;
			
			foreach($prices as $price){
				if ($count > 0){
					$suppliesPrices[$i][] = $price;
				}
				$count++;
			}
		}
		
		// view
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'resource_base' => $resource_base,
 				'resource_info' => $resource_info,
				'pricingTable' => $pricingTable,
				'suppliesPrices' => $suppliesPrices
				
		) ); 
	}
	
	/**
	 * query to edit the prices for a resource of type "unitary"
	 */
	public function edittimeunitaryresourcequery(){
	
		// general data
		$resource_base = $this->getResourceBase();
		$id = $resource_base["id"];
		$id_resource = $id;
		$modelResource = new SyResource();
		if ($id == ""){
			$id_resource = $modelResource->addResource($resource_base["name"], $resource_base["description"], $resource_base["accessibility_id"], 
					                                   3, $resource_base["area_id"], $resource_base["category_id"], $resource_base["display_order"]);
		}
		else{
			$modelResource->editResource($resource_base["id"], $resource_base["name"], $resource_base["description"], 
					                     $resource_base["accessibility_id"], 3, $resource_base["area_id"], 
					                     $resource_base["category_id"], $resource_base["display_order"]);
		}
	
		// specific info
		$resource_info = $this->getResourceInfo();
		$modelCResource = new SyResourceCalendar();
		
		$quatity_name = "";
		$supplynames = $this->request->getParameter("supplynames");
		foreach ($supplynames as $supply){
			$quatity_name .= $supply . ","; 
		}
		$modelCResource->setResource($id_resource, 0, $resource_info["available_days"], $resource_info["day_begin"], 
				                     $resource_info["day_end"], $resource_info["size_bloc_resa"], $resource_info["resa_time_setting"], 
				                     $quatity_name, $resource_info["default_color_id"]);
	
		// pricing
		$modelResourcePricing = new SyResourcePricing();
		$modelPricing = new SyPricing();
		$pricingTable = $modelPricing->getPrices();
		foreach ($pricingTable as $pricing){
			$pid = $pricing['id'];
			
			// time pricing
			//$pname = $pricing['tarif_name'];
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

			$count = 0;
			foreach ($supplynames as $supply){
				$priceDay .= "," . $this->request->getParameter ($pid. "_" . $count);	
				$count++;
			}
			
			$modelResourcePricing->setPricing($id_resource, $pid, $priceDay, $price_night, $price_we);
		}
		
		// view
		$this->redirect("sygrrifareasresources", "resources");
	}
	
	/**
	 * Entry function to view a calendar/booking page
	 * @param string $message
	 */
	public function book($message = ""){
		
		$lastView = "";
		if (isset($_SESSION["user_settings"]["calendarDefaultView"])){
			$lastView = $_SESSION["user_settings"]["calendarDefaultView"];
		}
		if (isset($_SESSION['lastbookview'])){
			$lastView = $_SESSION['lastbookview'];
		}
		if ($lastView == "bookday"){
			$this->bookday($message);
			return;
		}
		else if ($lastView == "bookweek"){
			$this->bookweek($message);
			return;
		}
		else if ($lastView == "bookweekarea"){
			$this->bookweekarea($message);
			return;
		}
		else if($lastView == "bookdayarea"){
			$this->bookdayarea($message);
			return;
		}
		$this->bookday($message);
	}
	
	/**
	 * View a calendar booking page in day mode
	 * @param string $message
	 */
	public function bookday($message = ""){
		
                //print_r($_SESSION);
		$_SESSION['lastbookview'] = "bookday";
		
		$lang = "En";
		if (isset($_SESSION["user_settings"]["language"])){
			$lang = $_SESSION["user_settings"]["language"];
		}
		
		// get inputs
		$curentResource = $this->request->getParameterNoException('id_resource');
		$curentAreaId = $this->request->getParameterNoException('id_area');
		$curentDate = $this->request->getParameterNoException('curentDate');
		
                //echo "curent resource bookday 1 = " . $curentResource . "<br/>";
                
		if ($curentDate != ""){
			$curentDate = CoreTranslator::dateToEn($curentDate, $lang);
		}
		
		if ($curentAreaId == ""){
			$curentResource = $_SESSION['id_resource'];
			$curentAreaId = $_SESSION['id_area'];
			$curentDate = $_SESSION['curentDate'];
		}
		
                //print_r($_SESSION);
                //echo "curent resource bookday 2 = " . $curentResource . "<br/>";
                //sreturn;
		// change input if action
		$action = "";
		if ($this->request->isParameterNotEmpty("actionid")) {
			$action = $this->request->getParameter ( "actionid" );
		}
		if ($action == "daybefore" ){
			$curentDate = explode("-", $curentDate);
			$curentTime = mktime(0,0,0,$curentDate[1], $curentDate[2], $curentDate[0] );
			$curentTime = $curentTime - 86400;
			$curentDate = date("Y-m-d", $curentTime);
		}
		if ($action == "dayafter" ){
			$curentDate = explode("-", $curentDate);
			$curentTime = mktime(0,0,0,$curentDate[1], $curentDate[2], $curentDate[0] );
			$curentTime = $curentTime + 86400;
			$curentDate = date("Y-m-d", $curentTime);
		}
		if ($action == "today" ){
			$curentDate = date("Y-m-d", time());
		}
		
		$menuData = $this->calendarMenuData($curentAreaId, $curentResource, $curentDate);
		
		// save the menu info in the session
		$_SESSION['id_resource'] = $curentResource;
		$_SESSION['id_area'] = $curentAreaId;
		$_SESSION['curentDate'] = $curentDate;
		
		// get the resource info
		$modelRescal = new SyResourceCalendar();
		$resourceInfo = $modelRescal->resource($curentResource);
		
		if (count($resourceInfo) <=1 ){
			$this->redirect("calendar", "booking");
			return;
		}
		
		$modelRes = new SyResource();
		$resourceBase = $modelRes->resource($curentResource);
		
		// get the entries for this resource
		$modelEntries = new SyCalendarEntry();
		//echo "curent date line 470 = " . $curentDate . "<br/>";
		$dateArray = explode("-", $curentDate);
		$dateBegin = mktime(0,0,0,$dateArray[1],$dateArray[2],$dateArray[0]);
		$dateEnd = mktime(23,59,59,$dateArray[1],$dateArray[2],$dateArray[0]);
		$calEntries = $modelEntries->getEntriesForPeriodeAndResource($dateBegin, $dateEnd, $curentResource);
		
		// curentdate unix
		$temp = explode("-", $curentDate);
		$curentDateUnix = mktime(0,0,0,$temp[1], $temp[2], $temp[0]);
		
		// color code
		$modelColor = new SyColorCode();
		$colorcodes = $modelColor->getColorCodes("name");
		
		// isUserAuthorizedToBook	
		$isUserAuthorizedToBook = $this->hasAuthorization($resourceBase["category_id"], $resourceBase["accessibility_id"], 
								$_SESSION['id_user'], $_SESSION["user_status"], $curentDateUnix);
		
		
		// stylesheet
		$modelCSS = new SyBookingTableCSS();
		$agendaStyle = $modelCSS->getAreaCss($curentAreaId);
		//print_r($agendaStyle);
		
		// view
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'menuData' => $menuData,
				'resourceInfo' => $resourceInfo,
				'resourceBase' => $resourceBase,
				'date' => $curentDate,
				'date_unix' => $curentDateUnix,
				'calEntries' => $calEntries,
				'colorcodes' => $colorcodes,
				'isUserAuthorizedToBook' => $isUserAuthorizedToBook,
				'message' => $message,
				'agendaStyle' => $agendaStyle
		),"bookday" );
	}
	
	/**
	 * View a calendar booking page in week mode
	 * @param string $message
	 */
	public function bookweek($message = ""){
	
		$_SESSION['lastbookview'] = "bookweek";
		$lang = "En";
		if (isset($_SESSION["user_settings"]["language"])){
			$lang = $_SESSION["user_settings"]["language"];
		}
		
		// get inputs
		$curentResource = $this->request->getParameterNoException('id_resource');
		$curentAreaId = $this->request->getParameterNoException('id_area');
		$curentDate = $this->request->getParameterNoException('curentDate');

		if ($curentDate != ""){
			$curentDate = CoreTranslator::dateToEn($curentDate, $lang);
		}
	
		if ($curentAreaId == ""){
			$curentResource = $_SESSION['id_resource'];
			$curentAreaId = $_SESSION['id_area'];
			$curentDate = $_SESSION['curentDate'];
		}
	
		// change input if action
		$action = "";
		if ($this->request->isParameterNotEmpty("actionid")) {
			$action = $this->request->getParameter ( "actionid" );
		}
		if ($action == "dayweekbefore" ){
			$curentDate = explode("-", $curentDate);
			$curentTime = mktime(0,0,0,$curentDate[1], $curentDate[2], $curentDate[0] );
			$curentTime = $curentTime - 86400*7;
			$curentDate = date("Y-m-d", $curentTime);
		}
		if ($action == "dayweekafter" ){
			$curentDate = explode("-", $curentDate);
			$curentTime = mktime(0,0,0,$curentDate[1], $curentDate[2], $curentDate[0] );
			$curentTime = $curentTime + 86400*7;
			$curentDate = date("Y-m-d", $curentTime);
		}
		if ($action == "thisWeek" ){
			$curentDate = date("Y-m-d", time());
		}
		
		// get the closest monday to curent day
		$i = 0;
		//echo "curentDate = " . $curentDate . "<br/>";
		$curentDateE = explode("-", $curentDate);
		while(date('D',mktime(0,0,0,$curentDateE[1], $curentDateE[2]-$i, $curentDateE[0])) != "Mon") {
			$i++;
		} 
		$mondayDate = date('Y-m-d', mktime(0,0,0,$curentDateE[1], $curentDateE[2]-($i), $curentDateE[0]));
		$sundayDate  = date('Y-m-d', mktime(0,0,0,$curentDateE[1], $curentDateE[2]-($i)+6, $curentDateE[0]));
		
	
		$menuData = $this->calendarMenuData($curentAreaId, $curentResource, $curentDate);
	
		// save the menu info in the session
		$_SESSION['id_resource'] = $curentResource;
		$_SESSION['id_area'] = $curentAreaId;
		$_SESSION['curentDate'] = $curentDate;
	
		// get the resource info
		$modelRescal = new SyResourceCalendar();
		$resourceInfo = $modelRescal->resource($curentResource);
		
		if (count($resourceInfo) <=1 ){
			$this->redirect("calendar", "booking");
			return;
		}
	
		$modelRes = new SyResource();
		$resourceBase = $modelRes->resource($curentResource);
	
		// get the entries for this resource
		$modelEntries = new SyCalendarEntry();
		$dateArray = explode("-", $mondayDate);
		$dateBegin = mktime(0,0,0,$dateArray[1],$dateArray[2],$dateArray[0]);
		$dateEnd = mktime(23,59,59,$dateArray[1],$dateArray[2]+7,$dateArray[0]);
		$calEntries = $modelEntries->getEntriesForPeriodeAndResource($dateBegin, $dateEnd, $curentResource);
		
		//echo "Cal entry count = " . count($calEntries) . "</br>";
		
		
		// curentdate unix
		$temp = explode("-", $curentDate);
		$curentDateUnix = mktime(0,0,0,$temp[1], $temp[2], $temp[0]);
	
		// color code
		$modelColor = new SyColorCode();
		$colorcodes = $modelColor->getColorCodes("name");
	
		// isUserAuthorizedToBook
		$isUserAuthorizedToBook = $this->hasAuthorization($resourceBase["category_id"], $resourceBase["accessibility_id"],
				$_SESSION['id_user'], $_SESSION["user_status"], $curentDateUnix);
		
		// stylesheet
		$modelCSS = new SyBookingTableCSS();
		$agendaStyle = $modelCSS->getAreaCss($curentAreaId);
		
		// view
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'menuData' => $menuData,
				'resourceInfo' => $resourceInfo,
				'resourceBase' => $resourceBase,
				'date' => $curentDate,
				'date_unix' => $curentDateUnix,
				'mondayDate' => $mondayDate,
				'sundayDate' => $sundayDate,
				'calEntries' => $calEntries,
				'colorcodes' => $colorcodes,
				'isUserAuthorizedToBook' => $isUserAuthorizedToBook,
				'message' => $message,
				'agendaStyle' => $agendaStyle
		), "bookweek");
		
	}
	
	/**
	 * View a calendar booking page in month mode
	 * @param string $message
	 */
	public function bookmonth($message = ""){
	
		$_SESSION['lastbookview'] = "bookmonth";
		$lang = "En";
		if (isset($_SESSION["user_settings"]["language"])){
			$lang = $_SESSION["user_settings"]["language"];
		}
	
		// get inputs
		$curentResource = $this->request->getParameterNoException('id_resource');
		$curentAreaId = $this->request->getParameterNoException('id_area');
		$curentDate = $this->request->getParameterNoException('curentDate');
	
		if ($curentDate != ""){
			$curentDate = CoreTranslator::dateToEn($curentDate, $lang);
		}
	
		if ($curentAreaId == ""){
			$curentResource = $_SESSION['id_resource'];
			$curentAreaId = $_SESSION['id_area'];
			$curentDate = $_SESSION['curentDate'];
		}
	
		// change input if action
		$action = "";
		if ($this->request->isParameterNotEmpty("actionid")) {
			$action = $this->request->getParameter ( "actionid" );
		}
		$curentTime = time();
		if ($action == "daymonthbefore" ){
			$curentDate = explode("-", $curentDate);
			$curentTime = mktime(0,0,0,$curentDate[1], $curentDate[2], $curentDate[0] );
			$curentTime = $curentTime - 86400*30;
			$curentDate = date("Y-m-d", $curentTime);
		}
		if ($action == "daymonthafter" ){
			$curentDate = explode("-", $curentDate);
			$curentTime = mktime(0,0,0,$curentDate[1], $curentDate[2], $curentDate[0] );
			$curentTime = $curentTime + 86400*30;
			$curentDate = date("Y-m-d", $curentTime);
		}
		if ($action == "thisMonth" ){
			$curentDate = date("Y-m-d", time());
			$curentTime = time();
		}
	
		// get the closest monday to curent day
		
		$i = 0;
		//echo "curentDate = " . $curentDate . "<br/>";
		$curentDateE = explode("-", $curentDate);
		while(date('d',mktime(0,0,0,$curentDateE[1], $curentDateE[2]-$i, $curentDateE[0])) != 1) {
			$i++;
		}
		$mondayDate = date('Y-m-d', mktime(0,0,0,$curentDateE[1], $curentDateE[2]-($i), $curentDateE[0]));
		$sundayDate  = date('Y-m-d', mktime(0,0,0,$curentDateE[1], $curentDateE[2]-($i)+31, $curentDateE[0]));
	
		$menuData = $this->calendarMenuData($curentAreaId, $curentResource, $curentDate);
	
		// save the menu info in the session
		$_SESSION['id_resource'] = $curentResource;
		$_SESSION['id_area'] = $curentAreaId;
		$_SESSION['curentDate'] = $curentDate;
	
		// get the resource info
		$modelRescal = new SyResourceCalendar();
		$resourceInfo = $modelRescal->resource($curentResource);
	
		if (count($resourceInfo) <=1 ){
			$this->redirect("calendar", "booking");
			return;
		}
	
		$modelRes = new SyResource();
		$resourceBase = $modelRes->resource($curentResource);
	
		// get the entries for this resource
		$modelEntries = new SyCalendarEntry();
		$dateArray = explode("-", $mondayDate);
		$dateBegin = mktime(0,0,0,$dateArray[1],$dateArray[2],$dateArray[0]);
		$dateEnd = mktime(23,59,59,$dateArray[1],$dateArray[2]+31,$dateArray[0]);
		$calEntries = $modelEntries->getEntriesForPeriodeAndResource($dateBegin, $dateEnd, $curentResource);
	
		//echo "Cal entry count = " . count($calEntries) . "</br>";
	
	
		// curentdate unix
		$temp = explode("-", $curentDate);
		$curentDateUnix = mktime(0,0,0,$temp[1], $temp[2], $temp[0]);
	
		// color code
		$modelColor = new SyColorCode();
		$colorcodes = $modelColor->getColorCodes("name");
	
		// isUserAuthorizedToBook
		$isUserAuthorizedToBook = $this->hasAuthorization($resourceBase["category_id"], $resourceBase["accessibility_id"],
				$_SESSION['id_user'], $_SESSION["user_status"], $curentDateUnix);
	
		// view
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'menuData' => $menuData,
				'resourceInfo' => $resourceInfo,
				'resourceBase' => $resourceBase,
				'date' => $curentDate,
				'month' => date("n", $curentTime),
				'year' => date("Y", $curentTime),
				'date_unix' => $curentDateUnix,
				'mondayDate' => $mondayDate,
				'sundayDate' => $sundayDate,
				'calEntries' => $calEntries,
				'colorcodes' => $colorcodes,
				'isUserAuthorizedToBook' => $isUserAuthorizedToBook,
				'message' => $message
		), "bookmonth");
	}
	
	/**
	 * View a calendar booking page in day mode for all the resources of an area
	 * @param string $message
	 */
	public function bookdayarea($message = ""){
	
		$_SESSION['lastbookview'] = "bookdayarea";
	
		$lang = "En";
		if (isset($_SESSION["user_settings"]["language"])){
			$lang = $_SESSION["user_settings"]["language"];
		}
	
		// get inputs
		$curentResource = $this->request->getParameterNoException('id_resource');
		$curentAreaId = $this->request->getParameterNoException('id_area');
		$curentDate = $this->request->getParameterNoException('curentDate');
	
		if ($curentDate != ""){
			$curentDate = CoreTranslator::dateToEn($curentDate, $lang);
		}
	
		if ($curentAreaId == ""){
			$curentResource = $_SESSION['id_resource'];
			$curentAreaId = $_SESSION['id_area'];
			$curentDate = $_SESSION['curentDate'];
		}
	
		// change input if action
		$action = "";
		if ($this->request->isParameterNotEmpty("actionid")) {
			$action = $this->request->getParameter ( "actionid" );
		}
		if ($action == "daybefore" ){
			$curentDate = explode("-", $curentDate);
			$curentTime = mktime(0,0,0,$curentDate[1], $curentDate[2], $curentDate[0] );
			$curentTime = $curentTime - 86400;
			$curentDate = date("Y-m-d", $curentTime);
		}
		if ($action == "dayafter" ){
			$curentDate = explode("-", $curentDate);
			$curentTime = mktime(0,0,0,$curentDate[1], $curentDate[2], $curentDate[0] );
			$curentTime = $curentTime + 86400;
			$curentDate = date("Y-m-d", $curentTime);
		}
		if ($action == "today" ){
			$curentDate = date("Y-m-d", time());
		}
	
		$menuData = $this->calendarMenuData($curentAreaId, $curentResource, $curentDate);
	
		// save the menu info in the session
		$_SESSION['id_resource'] = $curentResource;
		$_SESSION['id_area'] = $curentAreaId;
		$_SESSION['curentDate'] = $curentDate;
	
		// get the area info
		$modelArea = new SyArea();
		$area = $modelArea->getArea($curentAreaId);
		
		// get the resource info
		$modelRes = new SyResource();
		$resourcesBase = $modelRes->resourcesForArea($curentAreaId);
		
		$modelRescal = new SyResourceCalendar();
		for ($t = 0 ; $t < count($resourcesBase) ; $t++){
			$resourcesInfo[$t] = $modelRescal->resource($resourcesBase[$t]["id"]);
		}
	
		// get the entries for this resource
		$modelEntries = new SyCalendarEntry();
		$dateArray = explode("-", $curentDate);
		$dateBegin = mktime(0,0,0,$dateArray[1],$dateArray[2],$dateArray[0]);
		$dateEnd = mktime(23,59,59,$dateArray[1],$dateArray[2],$dateArray[0]);
		for ($t = 0 ; $t < count($resourcesBase) ; $t++){
			$calEntries[] = $modelEntries->getEntriesForPeriodeAndResource($dateBegin, $dateEnd, $resourcesBase[$t]["id"]);
		}
		
		// curentdate unix
		$temp = explode("-", $curentDate);
		$curentDateUnix = mktime(0,0,0,$temp[1], $temp[2], $temp[0]);
	
		// color code
		$modelColor = new SyColorCode();
		$colorcodes = $modelColor->getColorCodes("name");
	
		// isUserAuthorizedToBook
		foreach ($resourcesBase as $resourceBase){
			$isUserAuthorizedToBook[] = $this->hasAuthorization($resourceBase["category_id"], $resourceBase["accessibility_id"],
				$_SESSION['id_user'], $_SESSION["user_status"], $curentDateUnix);
		}
	
		//print_r($calEntries);
		//return;
		
		// stylesheet
		$modelCSS = new SyBookingTableCSS();
		$agendaStyle = $modelCSS->getAreaCss($curentAreaId);
		
		
		// view
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'menuData' => $menuData,
				'resourcesInfo' => $resourcesInfo,
				'resourcesBase' => $resourcesBase,
				'date' => $curentDate,
				'date_unix' => $curentDateUnix,
				'calEntries' => $calEntries,
				'colorcodes' => $colorcodes,
				'isUserAuthorizedToBook' => $isUserAuthorizedToBook,
				'message' => $message,
				'agendaStyle' => $agendaStyle
		),"bookdayarea" );
	}
	
	/**
	 * View a calendar booking page in multiple ressource per week mode 
	 * @param string $message
	 */
	public function bookweekarea($message = ""){
	
		$_SESSION['lastbookview'] = "bookweekarea";
		
		$lang = "En";
		if (isset($_SESSION["user_settings"]["language"])){
			$lang = $_SESSION["user_settings"]["language"];
		}
		
		// get inputs
		$curentResource = $this->request->getParameterNoException('id_resource');
		$curentAreaId = $this->request->getParameterNoException('id_area');
		$curentDate = $this->request->getParameterNoException('curentDate');
		
		if ($curentDate != ""){
			$curentDate = CoreTranslator::dateToEn($curentDate, $lang);
		}
		
		if ($curentAreaId == ""){
			$curentResource = $_SESSION['id_resource'];
			$curentAreaId = $_SESSION['id_area'];
			$curentDate = $_SESSION['curentDate'];
			//echo "curent date n-2 = " . $curentDate . "<br/>";
		}
	
		//echo "curent date n-1= " . $curentDate . "<br/>";
		// change input if action
		$action = "";
		if ($this->request->isParameterNotEmpty("actionid")) {
			$action = $this->request->getParameter ( "actionid" );
		}
		if ($action == "dayweekbefore" ){
			$curentDate = explode("-", $curentDate);
			$curentTime = mktime(0,0,0,$curentDate[1], $curentDate[2], $curentDate[0] );
			$curentTime = $curentTime - 86400*7;
			$curentDate = date("Y-m-d", $curentTime);
		}
		if ($action == "dayweekafter" ){
			$curentDate = explode("-", $curentDate);
			$curentTime = mktime(0,0,0,$curentDate[1], $curentDate[2], $curentDate[0] );
			$curentTime = $curentTime + 86400*7;
			$curentDate = date("Y-m-d", $curentTime);
		}
		if ($action == "thisWeek" ){
			$curentDate = date("Y-m-d", time());
		}
	
		//echo "curent date n = " . $curentDate . "<br/>";
		// get the closest monday to curent day
		$i = 0;
		$curentDateE = explode("-", $curentDate);
		while(date('D',mktime(0,0,0,$curentDateE[1], $curentDateE[2]-$i, $curentDateE[0])) != "Mon") {
			$i++;
		}
		$mondayDate = date('Y-m-d', mktime(0,0,0,$curentDateE[1], $curentDateE[2]-($i), $curentDateE[0]));
		$sundayDate  = date('Y-m-d', mktime(0,0,0,$curentDateE[1], $curentDateE[2]-($i)+6, $curentDateE[0]));
	
		$menuData = $this->calendarMenuData($curentAreaId, $curentResource, $curentDate);
	
		// save the menu info in the session
		$_SESSION['id_resource'] = $curentResource;
		$_SESSION['id_area'] = $curentAreaId;
		$_SESSION['curentDate'] = $curentDate;
	
		// get the area info
		$modelArea = new SyArea();
		$area = $modelArea->getArea($curentAreaId);
		
		// get the resource info
		$modelRes = new SyResource();
		$resourcesBase = $modelRes->resourcesForArea($curentAreaId);
		
		$modelRescal = new SyResourceCalendar();
		for ($t = 0 ; $t < count($resourcesBase) ; $t++){
			$resourcesInfo[$t] = $modelRescal->resource($resourcesBase[$t]["id"]);
		}
	
		// get the entries for this resource
		$modelEntries = new SyCalendarEntry();
		$dateArray = explode("-", $mondayDate);
		$dateBegin = mktime(0,0,0,$dateArray[1],$dateArray[2],$dateArray[0]);
		$dateEnd = mktime(23,59,59,$dateArray[1],$dateArray[2]+7,$dateArray[0]);
		$calEntries = $modelEntries->getEntriesForPeriodeAndArea($dateBegin, $dateEnd, $curentAreaId);
	
		// curentdate unix
		$temp = explode("-", $curentDate);
		$curentDateUnix = mktime(0,0,0,$temp[1], $temp[2], $temp[0]);
	
		// color code
		$modelColor = new SyColorCode();
		$colorcodes = $modelColor->getColorCodes("name");
	
		// isUserAuthorizedToBook
		foreach ($resourcesBase as $resourceBase){
			$isUserAuthorizedToBook[] = $this->hasAuthorization($resourceBase["category_id"], $resourceBase["accessibility_id"],
				$_SESSION['id_user'], $_SESSION["user_status"], $curentDateUnix);
		}
		
		
		//echo "area id = "  . $curentAreaId . "</br>";
		//print_r($calEntries);
		//return;
		
		// stylesheet
		$modelCSS = new SyBookingTableCSS();
		$agendaStyle = $modelCSS->getAreaCss($curentAreaId);
		
		// view
		
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'menuData' => $menuData,
				'areaname' => $area["name"],
				'resourcesInfo' => $resourcesInfo,
				'resourcesBase' => $resourcesBase,
				'date' => $curentDate,
				'date_unix' => $curentDateUnix,
				'mondayDate' => $mondayDate,
				'sundayDate' => $sundayDate,
				'calEntries' => $calEntries,
				'colorcodes' => $colorcodes,
				'isUserAuthorizedToBook' => $isUserAuthorizedToBook,
				'message' => $message,
				'agendaStyle' => $agendaStyle
		), "bookweekarea");
	}
	
	public function editreservation(){
		
		$modelSettings = new CoreConfig();
		$editResaFunction = $modelSettings->getParam("sygrrifEditReservation");
		
		if($editResaFunction == "" || $editResaFunction == "calendar/editreservationdefault"){
			$this->editreservationdefault();
		}
		else{
			$modulesNames = Configuration::get("modules");
			$count = count($modulesNames);
			$controllerFound = false;
			
			$url = explode("/", $editResaFunction );
			$classController = "Controller".$url[0];
			$action = $url[1];
			for($i = 0; $i < $count; $i++) {
				$fileController = 'Modules/' . $modulesNames[$i] . "/Controller/" . $classController . ".php";
				if (file_exists($fileController)){
					// Instantiate controler
					$controllerFound = true;
					require ($fileController);
					$controller = new $classController ();
					$controller->setRequest ( $request );
					$controller->runAction($action);
				}
			}
			if ($controllerFound == false){
				throw new Exception("SyGRRif plugin " . $editResaFunction . " not found");
			}
		}
	}
	
	
	/**
	 * Form to edit a reservation
	 */
	public function editreservationdefault(){
		
		// get the action
		$action = '';
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$action = $this->request->getParameter ( "actionid" );
		}
		$contentAction = explode("_", $action);
		
		if (count($contentAction) > 3){
			$_SESSION["id_resource"] = $contentAction[3];
		}
		
		// get the cal sups
		$modelCalSup = new SyCalSupplementary();
		$calSups = $modelCalSup->calSups("name"); 
		$calSupsData = array();
		foreach ($calSups as $calSup){
			$calSupsData[$calSup["name"]] = "";
		}
		
		// get the menu info
		$id_resource = $this->request->getSession()->getAttribut('id_resource');
		$id_area = $this->request->getSession()->getAttribut('id_area');
		$curentDate = $this->request->getSession()->getAttribut('curentDate');
		
		// get the resource info
		$modelRescal = new SyResourceCalendar();
		$resourceInfo = $modelRescal->resource($id_resource);
		$modelRes = new SyResource();
		$resourceBase = $modelRes->resource($id_resource);
		
		// get users list
		$modelUser = new CoreUser();
		$users = $modelUser->getActiveUsers("Name");
		
		$curentuserid = $this->request->getSession()->getAttribut("id_user");
		$curentuser = $modelUser->userAllInfo($curentuserid);
		
		// navigation
		$navBar = $this->navBar();
		$menuData = $this->calendarMenuData($id_area, $id_resource, $curentDate);
		
		// color types
		$colorCodeModel = new SyColorCode();
		$colorCodes = $colorCodeModel->getColorCodes("display_order");
		
		// a user cannot delete a reservation in the past
		$canEditReservation = false;
		//echo "can edit reservation = " . $canEditReservation . " <br/>";
		$temp = explode("-", $curentDate);
		$H = date("H", time());
		$min = date("i", time());
		$curentDateUnix = mktime($H,$min+1,0,$temp[1], $temp[2], $temp[0]);
		if ($curentDateUnix >= time() && $_SESSION["user_status"] < 3 ){
			$canEditReservation = true;
		}
		if ($_SESSION["user_status"] >= 3){
			$canEditReservation = true;
		}
		//echo "can edit reservation = " . $canEditReservation . "<br/>";
		
		
		$ModulesManagerModel = new ModulesManager();
		$status = $ModulesManagerModel->getDataMenusUserType("projects");
		$projectsList = "";
		if ($status > 0){
			$modelProjects = new CoreProject();
			$projectsList = $modelProjects->openedProjectsIDName(); 
		}
		
		// is user allowed to series
		$modelCoreConfig = new CoreConfig();
		$seriesBooking = $modelCoreConfig->getParam("SySeriesBooking");
		$showSeries = false;
		if ($seriesBooking > 0 && $_SESSION["user_status"]>=$seriesBooking){
			$showSeries = true;
		}
		
		// packages
		$packagesModel = new SyPackage();
		$packages = $packagesModel->getPrices($id_resource);
		
		// set the view given the action		
		if ($contentAction[0] == "t"){ // add resa 
			
			$curentDate = $contentAction[1];
			$beginTime = $contentAction[2];
			$beginTime = str_replace("-", ".", $beginTime);
			$h = floor($beginTime);
			$m = $beginTime - $h;
			if ($m == 0.25){$m=15;}
			if ($m == 0.5){$m=30;}
			if ($m == 0.75){$m=45;}
			$timeBegin = array('h'=> $h, 'm' => $m);
			
			
			$timeEnd = array('h'=> $h+1, 'm' => $m);
			if( $resourceInfo["size_bloc_resa"] == 1800 ){
				if ( $m < 30){
					$m += 30;
				}
				else if($m >= 30){
					$m -= 30;
					$h += 1;
				}
				$timeEnd = array('h'=> $h, 'm' => $m);
			}
			if( $resourceInfo["size_bloc_resa"] == 900 ){
				if ( $m < 45){
					$m += 15;
				}
				else if($m >= 45){
					$m -= 45;
					$h += 1;
				}
				$timeEnd = array('h'=> $h, 'm' => $m);
			}
			
			// navigation
			$menuData = $this->calendarMenuData($id_area, $_SESSION["id_resource"], $curentDate);
			

			$responsiblesList = $modelUser->getUserResponsibles($curentuser["id"]);
			
			// view
			$this->generateView ( array (
					'navBar' => $navBar,
					'menuData' => $menuData,
					'resourceInfo' => $resourceInfo,
					'resourceBase' => $resourceBase,
					'date' => $curentDate,
					'timeBegin' => $timeBegin,
					'timeEnd' => $timeEnd,
					'users' => $users,
					'curentuser' => $curentuser,
					'canEditReservation' => $canEditReservation,
					'colorCodes' => $colorCodes,
					'projectsList' => $projectsList,
					'showSeries' => $showSeries,
					'calSups' => $calSups,
					'calSupsData' => $calSupsData,
					'packages' => $packages,
					'responsiblesList' => $responsiblesList,
                                        'id_new_resa' => true
			), "editreservation" );
		}
		else{ // edit resa
			$reservation_id = $contentAction[1];
			
			$modelResa = new SyCalendarEntry();
			$reservationInfo = $modelResa->getEntry($reservation_id);
			$resourceBase = $modelRes->resource($reservationInfo["resource_id"]);
			//print_r($reservationInfo);
			
			// navigation
			$_SESSION["id_resource"] = $reservationInfo["resource_id"];
			$menuData = $this->calendarMenuData($id_area, $_SESSION["id_resource"], $curentDate);
			
			
			//print_r($reservationInfo);
			if ($_SESSION["user_status"] < 3 && $reservationInfo["start_time"] <= time() ){
				$canEditReservation = false;
			}
			
			$seriesInfo = "";
			if ($reservationInfo['repeat_id'] > 0){
				$modelSeries = new SyCalendarSeries();
				$seriesInfo = $modelSeries->getEntry($reservationInfo['repeat_id']);
			}
			
			//print_r($seriesInfo);
			
			if ($_SESSION["user_status"] < 3 && $curentuserid != $reservationInfo["recipient_id"]){
				$canEditReservation = false;
			}
			
			// get sup data 
			$calSupsData = $modelCalSup->getSupData($reservation_id);
			
			$responsiblesList = $modelUser->getUserResponsibles($reservationInfo["recipient_id"]);
			
			$this->generateView ( array (
					'navBar' => $navBar,
					'menuData' => $menuData,
					'resourceInfo' => $resourceInfo,
					'resourceBase' => $resourceBase,
					'seriesInfo' => $seriesInfo,
					'date' => $curentDate,
					'users' => $users,
					'curentuser' => $curentuser,
					'reservationInfo' => $reservationInfo,
					'canEditReservation' => $canEditReservation,
					'colorCodes' => $colorCodes,
					'projectsList' => $projectsList,
					'showSeries' => $showSeries,
					'calSups' => $calSups,
					'calSupsData' => $calSupsData,
					'packages' => $packages,
					'responsiblesList' =>  $responsiblesList,
                                        'id_new_resa' => false
			), "editreservation");
		}
	}
	
	/**
	 * Internal method
	 * @param number $val
	 * @return boolean
	 */
	private function isMinutes($val){
		if (intval($val) < 0 || intval($val) > 60){
			//echo "minut not in [0, 60] <br/>";
			return false;
		}
		return true;
		
	}
	
	/**
	 * Internal method
	 * @param number $val
	 * @return boolean
	 */
	private function isHour($val){
		
		if (intval($val) < 0 || intval($val) > 23){
			return false;
		}
		return true;
		
	}

	/**
	 * Query to edit the reservation
	 */
	public function editreservationquery(){
		
		$lang = "En";
		if (isset($_SESSION['user_settings']['language'])){
			$lang = $_SESSION['user_settings']['language'];
		}
	
		// get reservation info
		$reservation_id = $this->request->getParameterNoException('reservation_id');
		$resource_id = $this->request->getParameter('resource_id');
		$booked_by_id = $this->request->getSession()->getAttribut("id_user");
		$recipient_id = $this->request->getParameter('recipient_id');
		$last_update = date("Y-m-d H:i:s", time());
		$color_type_id = $this->request->getParameter('color_code_id');
		$short_description = $this->request->getParameterNoException('short_description');
		$full_description = $this->request->getParameterNoException('full_description');
		$is_unitary = $this->request->getParameterNoException('is_unitary');
		$is_timeandunitary = $this->request->getParameterNoException('is_timeandunitary');
		$repeat_id = $this->request->getParameterNoException('repeat_id');
		$responsible_id = $this->request->getParameterNoException('responsible_id');
		
		$quantity = 0;
		if ($is_unitary != ""){
			$quantity = $this->request->getParameter('quantity');
		}
		if ($is_timeandunitary != ""){
			$quantities = $this->request->getParameter('quantity');
			$quantity = "";
			foreach ($quantities as $quant){
				$quantity .= $quant . ",";
			}
		}
		
		// get reservation date
		$beginDate = $this->request->getParameter('begin_date');
		$beginDate = CoreTranslator::dateToEn($beginDate, $lang);
		$beginDate = explode("-", $beginDate);
		$begin_hour =  $this->request->getParameter('begin_hour');
		$begin_hour = intval($begin_hour);
		//echo "begin hour = " . $begin_hour . "<br/>";
		if (!$this->isHour($begin_hour)){
			$this->book("Error: The start hour you gave is not correct");
			return;
		}
		$begin_min = $this->request->getParameter('begin_min');
		$begin_min = intval($begin_min);
		if ($begin_min == ""){
			$begin_min = 0;
		}
		if (!$this->isMinutes($begin_min)){
			$this->book("Error: The start minute you gave is not correct");
			return;
		}
		$start_time = mktime($begin_hour, $begin_min, 0, $beginDate[1], $beginDate[2], $beginDate[0]);
		
		$endDate = $this->request->getParameterNoException('end_date');
		if ($endDate != ""){
			$endDate = CoreTranslator::dateToEn($endDate, $lang);
		}
		$endDate = explode("-", $endDate);
		$end_hour =  $this->request->getParameterNoException('end_hour');
		$end_hour = intval($end_hour);
		if (!$this->isHour($end_hour)){
			$this->book("Error: The end hour you gave is not correct");
			return;
		}
		$end_min = $this->request->getParameterNoException('end_min');
		if ($end_min == ""){
			$end_min = 0;
		}
		$end_min = intval($end_min);
		//echo "end min = " . $end_min . "<br/>";
		if (!$this->isMinutes($end_min)){
			$this->book("Error: The end minute you gave is not correct");
			return;
		}

		if (count($endDate) > 2){
			$end_time = mktime($end_hour, $end_min, 0, $endDate[1], $endDate[2], $endDate[0]);
		}
		
		$duration = $this->request->getParameterNoException('duration');
		$duration_step = $this->request->getParameterNoException('duration_step');
		if ($duration != ""){
			$coef = 60;
			if ($duration_step == 1){
				$coef = 60;
			}
			if ($duration_step == 2){
				$coef = 3600;
			}
			if ($duration_step == 3){
				$coef = 3600*24;
			}
			$end_time = $start_time + $duration*$coef;
		}

		$use_package = $this->request->getParameterNoException("use_package");
		$package = 0;
		if ($use_package == "yes"){
			$packageID = $this->request->getParameterNoException("package_choice");
			$package = $packageID;
			$modelPackage = new SyPackage();
			$duration = $modelPackage->getPackageDuration($packageID);
			$end_time = $start_time + $duration*3600;
		}
		
		if ($start_time >= $end_time ){
			$this->book("Error: The start time you gave is after the end time");
			return;
		}
		
		// get the series info
		$series_type_id = $this->request->getParameterNoException("series_type_id");
		
		// get the responsible:
		if ( $responsible_id == "" ){
			$modelUser = new CoreUser();
			$respList = $modelUser->getUserResponsibles($recipient_id);
			$responsible_id = $respList[0]["id"]; 
		}
		
                //echo "series_type_id = " . $series_type_id . "</br>";
		if ($series_type_id == 0 || $series_type_id == ""){
			
			$modelCalEntry = new SyCalendarEntry();
			// test if a resa already exists on this periode
			$conflict = $modelCalEntry->isConflict($start_time, $end_time, $resource_id, $reservation_id);
			
			if ($conflict){
				$this->book("Error: There is already a reservation for the given slot");
				return;
			}
			
			if ($reservation_id == ""){
				$reservation_id = $modelCalEntry->addEntry($start_time, $end_time, $resource_id, $booked_by_id, $recipient_id,
										 $last_update, $color_type_id, $short_description, $full_description, $quantity, $package);
				
					$modelCalEntry->setEntryResponsible($reservation_id, $responsible_id);
					$this->sendEditREservationEmail($start_time, $end_time, $resource_id, $booked_by_id, $recipient_id, 
					                       $short_description, $full_description, $quantity, "add");
					
					
					
					
			}
			else{
				$modelCalEntry->updateEntry($reservation_id, $start_time, $end_time, $resource_id, $booked_by_id, 
						                   $recipient_id, $last_update, $color_type_id, $short_description, 
						                   $full_description, $quantity, $package);
				$modelCalEntry->setEntryResponsible($reservation_id, $responsible_id);
				$this->sendEditREservationEmail($start_time, $end_time, $resource_id, $booked_by_id, $recipient_id,
					$short_description, $full_description, $quantity, "edit");
				
			}
                        
                        //echo "send email <br/>";
                        $this->sendEmailToManagers($start_time, $end_time, $resource_id, $booked_by_id, $recipient_id,
					$short_description, $full_description, $quantity, "edit");
                        //return;
		}
		else{
			// get the series info
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
			
			$days_option = $lundi . "," . $mardi . "," . $mercredi . "," . $jeudi . "," . $vendredi . "," . $samedi . "," . $dimanche;
			$seriesEndDate = $this->request->getParameter("series_end_date");
			
			// get the list of all the entries in the series
			$modelCalSeries = new SyCalendarSeries();
			$seriesDates = $modelCalSeries->entriesDates($start_time, $end_time, $series_type_id, $days_option, $seriesEndDate);
			
			// test if there are conflicts
			$modelCalEntry = new SyCalendarEntry();
			for ($d = 0 ; $d < count($seriesDates) ; $d++){
				$conflict = $modelCalEntry->isConflict($seriesDates[$d]['start_time'], $seriesDates[$d]['end_time'], $resource_id, $reservation_id);
					
				if ($conflict){
					$this->book("Error: There is already a reservation for the given series slot");
					return;
				}
			}
			
			// create/update the series entry
			if ($repeat_id == "" || $repeat_id == "0"){
				$repeat_id = $modelCalSeries->addEntry($start_time, $end_time, $series_type_id, $seriesEndDate, $days_option, $resource_id, $booked_by_id,
									  $recipient_id, $last_update, $color_type_id, $short_description, $full_description);
			}
			else{
				$modelCalSeries->updateEntry($repeat_id, $start_time, $end_time, $series_type_id, $seriesEndDate, $days_option, $resource_id, 
											$booked_by_id, $recipient_id, $last_update, $color_type_id, $short_description, $full_description);
			}
			
			// create the entries
			for ($d = 0 ; $d < count($seriesDates) ; $d++){
				
				$start_time = $seriesDates[$d]['start_time'];
				$end_time = $seriesDates[$d]['end_time'];
				$reservation_id = $modelCalEntry->addEntry($start_time, $end_time, $resource_id, $booked_by_id, $recipient_id,
							$last_update, $color_type_id, $short_description, $full_description, $quantity);

				$modelCalEntry->setRepeatID($reservation_id, $repeat_id);
			}
		}
		
		// add the suplementary info
		if ($this->request->isParameter("calsupName")){
			$this->addSuplementaryInfo($this->request->getParameter("calsupName"), $this->request->getParameter("calsupValue"), $reservation_id);
		}
		
		
		$_SESSION['id_resource'] = $resource_id;
		$modelResource = new SyResource();
		$areaID = $modelResource->getAreaID($resource_id);
		$_SESSION['id_area'] = $areaID;
		$date = $this->request->getParameter('begin_date');
		//echo "date = " . $date . "<br />";
		if ($date != ""){
			$date = CoreTranslator::dateToEn($date, $lang);
		}
		//echo "DATE = " .  $date . "--";
		$_SESSION['curentDate'] = $date;
		
		$message = "Success: Your reservation has been saved";
		$this->book($message);
		//$this->redirect("calendar", "book");
	}
	
	/**
	 * Add suplementary informations to a reservation
	 * @param array $calsupNames Keys of the suplementary informations 
	 * @param array $calsupValues Values of the suplementary informations   
	 * @param number $reservation_id ID of the information to edit
	 */
	private function addSuplementaryInfo($calsupNames, $calsupValues, $reservation_id){
		
		$modelCalSup = new SyCalSupplementary();
		$modelCalSup->setEntrySupData($calsupNames, $calsupValues, $reservation_id);
	}
	
	/**
	 * Send email to advice user that a manager udpate his reservation
	 * @param date $start_time
	 * @param date $end_time
	 * @param number $resource_id
	 * @param number $booked_by_id
	 * @param number $recipient_id
	 * @param string $short_description
	 * @param string $full_description
	 * @param number $quantity
	 * @param number $editstatus
	 */
	private function sendEditReservationEmail($start_time, $end_time, $resource_id, $booked_by_id, $recipient_id,
						$short_description, $full_description, $quantity, $editstatus){
		
		
		$modelConfig = new CoreConfig();
		if ( $modelConfig->getParam("SyEditBookingMailing") >= 2 && $booked_by_id != $recipient_id){
		
			$modelUser = new CoreUser();
			$fromEmail = $modelUser->getUserEmail($booked_by_id);
			$toEmail = $modelUser->getUserEmail($recipient_id);
			
			if ($fromEmail != "" && $toEmail!= ""){
				
				$modelUserSettings = new UserSettings();
				$settings = $modelUserSettings->getUserSettings($recipient_id);
				$lang = "En";
				if (isset($settings["language"])){
					$lang = $settings["language"];
				}
				
				$subject = SyTranslator::Your_reservation($lang);
				$content = "";
				if ($editstatus == "add"){
					$content .= SyTranslator::Your_reservation_has_been_added($lang) . ": <br/>";
				}
				else if($editstatus == "edit"){
					$content .= SyTranslator::Your_reservation_has_been_modified($lang) . ": <br/>";
				}
				else if($editstatus == "deleted"){
					$content .= SyTranslator::Your_reservation_has_been_deleted($lang) . ": <br/>";
				}
				
				$modelResource = new SyResource();
				$resourceInfo = $modelResource->resource($resource_id);
				
				$content .= "<br/>";
				$content .= "<b>" . SyTranslator::Edited_by($lang) . ": </b> " . $modelUser->getUserFUllName($booked_by_id). "<br/>";
				$content .= "<b>" . SyTranslator::Recipient($lang) . ": </b> " . $modelUser->getUserFUllName($recipient_id). "<br/>";
				$content .= "<b>" . SyTranslator::Resource($lang) . "</b> " . $resourceInfo["name"]. "<br/>";
				$content .= "<b>" . SyTranslator::Beginning($lang) . ": </b> " . date("F j, Y, g:i a", $start_time). "<br/>";
				$content .= "<b>" . SyTranslator::End($lang) . ": </b> " . date("F j, Y, g:i a", $end_time). "<br/>";
				
				if ($short_description != ""){
					$content .= "<b>" . SyTranslator::Short_description($lang) . ": </b> " . $short_description . "<br/>";
				}
				if ($short_description != ""){
					$content .= "<b>" . SyTranslator::Full_description($lang) . ": </b> " . $full_description . "<br/>";
				}
				if ($quantity != ""){
					$content .= "<b>" . SyTranslator::Quantity($lang) . ": </b> " . $quantity . "<br/>";
				}
				
				/*
				echo "fromEmail = " . $fromEmail . "<br/>";
				echo "toEmail = " . $toEmail . "<br/>";
				echo "subject = " . $subject . "<br/>";
				echo "content = " . $content . "<br/>";
				*/
				
				$modelMailer = new MailerSend();
				$modelMailer->sendEmail($fromEmail, Configuration::get("name"), $toEmail, $subject, $content, false);
			}
		}
		
	}
        
        private function sendEmailToManagers($start_time, $end_time, $resource_id, $booked_by_id, $recipient_id,
					$short_description, $full_description, $quantity, $editstatus){
            
            $modelConfig = new CoreConfig();
            if ( $modelConfig->getParam("SyBookingMailingAdmins") >= 2){
		
                $modelUser = new CoreUser();
		$fromEmail = $modelUser->getUserEmail($booked_by_id);
		$toEmails = $modelUser->getActiveManagersEmails();
                $recipient_name = $modelUser->getUserFUllName($recipient_id);
			
		if ($fromEmail != "" && count($toEmails) > 0 ){
				
                    $modelUserSettings = new UserSettings();
                    $settings = $modelUserSettings->getUserSettings($recipient_id);
                    $lang = "En";
                    if (isset($settings["language"])){
                        $lang = $settings["language"];
                    }
				
                    $subject = SyTranslator::Reservation($lang) . " " . $recipient_name;
                    $content = "";
                    if ($editstatus == "add"){
                        $content .= SyTranslator::Your_reservation_has_been_added($lang) . ": <br/>";
                    }
                    else if($editstatus == "edit"){
                        $content .= SyTranslator::Your_reservation_has_been_modified($lang) . ": <br/>";
                    }
                    else if($editstatus == "deleted"){
                        $content .= SyTranslator::Your_reservation_has_been_deleted($lang) . ": <br/>";
                    }
				
                    $modelResource = new SyResource();
                    $resourceInfo = $modelResource->resource($resource_id);
				
                    $content .= "<br/>";
                    $content .= "<b>" . SyTranslator::Edited_by($lang) . ": </b> " . $modelUser->getUserFUllName($booked_by_id). "<br/>";
                    $content .= "<b>" . SyTranslator::Recipient($lang) . ": </b> " . $modelUser->getUserFUllName($recipient_id). "<br/>";
                    $content .= "<b>" . SyTranslator::Resource($lang) . "</b> " . $resourceInfo["name"]. "<br/>";
                    $content .= "<b>" . SyTranslator::Beginning($lang) . ": </b> " . date("F j, Y, g:i a", $start_time). "<br/>";
                    $content .= "<b>" . SyTranslator::End($lang) . ": </b> " . date("F j, Y, g:i a", $end_time). "<br/>";
				
                    if ($short_description != ""){
                        $content .= "<b>" . SyTranslator::Short_description($lang) . ": </b> " . $short_description . "<br/>";
                    }
                    if ($short_description != ""){
                        $content .= "<b>" . SyTranslator::Full_description($lang) . ": </b> " . $full_description . "<br/>";
                    }
                    if ($quantity != ""){
                        $content .= "<b>" . SyTranslator::Quantity($lang) . ": </b> " . $quantity . "<br/>";
                    }
				
                    $modelMailer = new MailerSend();
                    $modelMailer->sendEmail($fromEmail, Configuration::get("name"), $toEmails, $subject, $content, false);
		}
            }
        }
	
	/**
	 * Remove a reservation query
	 */
	public function removeentry(){
		// get the action
		$id = '';
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$id = $this->request->getParameter ( "actionid" );
		}
		
		$modelEntry = new SyCalendarEntry();
		$entry = $modelEntry->getEntry($id);
		$message = $modelEntry->removeEntry($id);
		
		$this->sendEditReservationEmail($entry["start_time"], $entry["end_time"], $entry["resource_id"], $entry["booked_by_id"], $entry["recipient_id"],
						$entry["short_description"], $entry["full_description"], $entry["quantity"], "deleted");
		
		$this->book($message);
	}
	
	/**
	 * Remove a series of reservation
	 */
	public function removeseries(){
		// get the action
		$id = '';
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$id = $this->request->getParameter ( "actionid" );
		}
		
		$modelSeries = new SyCalendarSeries();
		$modelSeries->removeSeries($id);
		
		$modelEntry = new SyCalendarEntry();
		$message = $modelEntry->removeEntriesFromSeriesID($id);
		
		$this->book($message);
	}
	
	/**
	 * Main booking page
	 */
	public function booking(){
		// get the menu info
		$id_resource = $this->request->getSession()->getAttribut('id_resource');
		$id_area = $this->request->getSession()->getAttribut('id_area');
		$curentDate = $this->request->getSession()->getAttribut('curentDate');
		
		// navigation
		$navBar = $this->navBar();
		$menuData = $this->calendarMenuData($id_area, $id_resource, $curentDate);
		
		// view
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'menuData' => $menuData
		));
	}
}