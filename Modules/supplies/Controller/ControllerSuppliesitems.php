<?php
require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/supplies/Model/SuItem.php';
require_once 'Modules/supplies/Model/SuPricing.php';
require_once 'Modules/supplies/Model/SuItemPricing.php';

class ControllerSuppliesitems extends ControllerSecureNav {
	
	/**
	 * User model object
	 */
	private $itemModel;
	
	public function __construct() {
		$this->itemModel = new SuItem ();
	}
	
	// Affiche la liste de tous les billets du blog
	public function index() {
		$navBar = $this->navBar ();
		
		// get sort action
		$sortentry = "id";
		if ($this->request->isParameterNotEmpty ( 'actionid' )) {
			$sortentry = $this->request->getParameter ( "actionid" );
		}
		
		// get the user list
		$itemsArray = $this->itemModel->getItems($sortentry );
		
		$this->generateView ( array (
				'navBar' => $navBar,
				'itemsArray' => $itemsArray 
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
		$is_active = "";
		
		
		if ($id != ""){ // get the resource informations
			
			// get common info
			$modelItem = new SuItem();
			$itemInfo = $modelItem->getItem($id);
			$name = $itemInfo["name"];
			$description = $itemInfo["description"];
			$is_active =  $itemInfo["is_active"];
		}
	
		// pricing
		$modelPricing = new SuPricing();
		$pricingTable = $modelPricing->getPrices();
		
		// fill the pricing table with the prices for this resource
		$modelItemPricing = new SuItemPricing();
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
				'pricingTable'=> $pricingTable
		) );
	}
	
	public function editquery() {
		// general data
		$id = $this->request->getParameterNoException('id');
		$name = $this->request->getParameter("name");
		$description = $this->request->getParameter("description");
		$is_active = $this->request->getParameter("is_active");

		// edit desc
		$modelItem = new SuItem();
		$id_item = $id;
		if ($id == ""){
			$id_item = $modelItem->addItem($name, $description);
		}
		else{
			$modelItem->editItem($id, $name, $description);
		}
		
		// edit active
		$modelItem->setActive($id_item, $is_active);
	
		// pricing
		$modelItemPricing = new SuItemPricing();
		$modelPricing = new SuPricing();
		$pricingTable = $modelPricing->getPrices();
		foreach ($pricingTable as $pricing){
			$pid = $pricing['id'];
			$pname = $pricing['tarif_name'];
			$price = $this->request->getParameter ($pid. "_price");
			$modelItemPricing->setPricing($id_item, $pid, $price);
		}
	
		$this->redirect ( "suppliesitems" );
	}
}