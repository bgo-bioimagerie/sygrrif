<?php
require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/sprojects/Model/SpItem.php';
require_once 'Modules/sprojects/Model/SpPricing.php';
require_once 'Modules/sprojects/Model/SpItemPricing.php';
require_once 'Modules/sprojects/Model/SpTranslator.php';
require_once 'Modules/sprojects/Model/SpItemsTypes.php';
require_once 'Framework/TableView.php';

class ControllerSprojectsitems extends ControllerSecureNav {
	
	/**
	 * User model object
	 */
	private $itemModel;
	
	public function __construct() {
		$this->itemModel = new SpItem ();
	}
	
	// Affiche la liste de tous les billets du blog
	public function index() {
		$navBar = $this->navBar ();
		
		// Lang
		$lang = "En";
		if (isset($_SESSION["user_settings"]["language"])){
			$lang = $_SESSION["user_settings"]["language"];
		}
		
		// get sort action
		$sortentry = "id";
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$sortentry = $this->request->getParameter ( "actionid" );
		}
		
		// get the user list
		$itemsArray = $this->itemModel->getItems($sortentry );
		$modelItemType = new SpItemsTypes();
		for($i = 0 ; $i < count($itemsArray) ; $i++){
			$localName = $modelItemType->getLocalName($itemsArray[$i]["type_id"]);
			$itemsArray[$i]["local_name"] = $localName;
			
			if ($itemsArray[$i]["is_active"]){
				$itemsArray[$i]["is_active"] = CoreTranslator::yes($lang);
			}
			else{
				$itemsArray[$i]["is_active"] = CoreTranslator::no($lang);
			}
		}
		
		$table = new TableView();
		$table->setTitle(SpTranslator::sprojects_Items($lang));
		$table->addLineEditButton("sprojectsitems/edit");
		$tableHtml = $table->view($itemsArray, array("id" => "ID", "name" => CoreTranslator::Name($lang), "description" => CoreTranslator::Description($lang), "local_name" => SpTranslator::Type($lang), "is_active" => "actif", "display_order" => CoreTranslator::Display_order($lang)));
		
		
		$this->generateView ( array (
				'navBar' => $navBar,
				'tableHtml' => $tableHtml 
		) );
	}
	public function edit() {
			
		$id = "";
		if ($this->request->isParameterNotEmpty("actionid")) {
			$id = $this->request->getParameter ( "actionid" );
		}
		
		// default values
		$name = "";
		$description = "";
		$is_active = 1;
		$displayOrder = 0;
		$type_id = 1;
		
		if ($id != ""){ // get the resource informations
			
			// get common info
			$modelItem = new SpItem();
			$itemInfo = $modelItem->getItem($id);
			$name = $itemInfo["name"];
			$description = $itemInfo["description"];
			$is_active =  $itemInfo["is_active"];
			$displayOrder = $itemInfo["display_order"];
			$type_id = $itemInfo["type_id"];
		}
	
		// items tpes
		$modelItemsTypes = new SpItemsTypes();
		$itemsTypes = $modelItemsTypes->getAll();
		
		// pricing
		$modelPricing = new SpPricing();
		$pricingTable = $modelPricing->getPrices();
		
		// fill the pricing table with the prices for this resource
		$modelItemPricing = new SpItemPricing();
		for ($i = 0 ; $i < count($pricingTable) ; ++$i){
			$pid = $pricingTable[$i]['id'];
			$inter = $modelItemPricing->getPrice($id, $pid);
			$pricingTable[$i]['val_price'] = $inter['price'];
		}
		
		// view
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'id' => $id,
				'name' => $name,
				'description' => $description,
				'is_active' => $is_active,
				'pricingTable'=> $pricingTable,
				'displayOrder' => $displayOrder,
				'type_id' => $type_id,
				'itemsTypes' => $itemsTypes
		) );
	}
	
	public function editquery() {
		// general data
		$id = $this->request->getParameterNoException('id');
		$name = $this->request->getParameter("name");
		$description = $this->request->getParameter("description");
		$is_active = $this->request->getParameter("is_active");
		$display_order = $this->request->getParameter("display_order");
		$type_id = $this->request->getParameter("type_id");

		// edit desc
		$modelItem = new SpItem();
		$id_item = $id;
		if ($id == ""){
			$id_item = $modelItem->addItem($name, $description, $display_order, $type_id);
		}
		else{
			$modelItem->editItem($id, $name, $description, $display_order, $type_id);
		}
		
		// edit active
		$modelItem->setActive($id_item, $is_active);
	
		// pricing
		$modelItemPricing = new SpItemPricing();
		$modelPricing = new SpPricing();
		$pricingTable = $modelPricing->getPrices();
		foreach ($pricingTable as $pricing){
			$pid = $pricing['id'];
			$pname = $pricing['tarif_name'];
			$price = $this->request->getParameter ($pid. "_price");
			$modelItemPricing->setPricing($id_item, $pid, $price);
		}
	
		$this->redirect ( "sprojectsitems" );
	}
}