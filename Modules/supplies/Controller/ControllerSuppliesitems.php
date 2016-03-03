<?php
require_once 'Framework/Controller.php';
require_once 'Framework/TableView.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/CoreBelonging.php';
require_once 'Modules/supplies/Model/SuItem.php';
require_once 'Modules/supplies/Model/SuItemPricing.php';
require_once 'Modules/supplies/Model/SuTranslator.php';

class ControllerSuppliesitems extends ControllerSecureNav {
	
	/**
	 * User model object
	 */
	private $itemModel;
	
	public function __construct() {
                parent::__construct();
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
		$lang = $this->getLanguage();
		$itemsArray = $this->itemModel->getItems($sortentry );
		for($i = 0 ; $i < count($itemsArray) ; $i++){
			if ($itemsArray[$i]["is_active"] == 1){
				$itemsArray[$i]["is_active"] = CoreTranslator::yes($lang);
			}
			else{
				$itemsArray[$i]["is_active"] = CoreTranslator::no($lang);
			}
		}
		
		// fill table
		
		$table = new TableView();
		
		$table->setTitle(SuTranslator::Supplies($lang));
		$table->addLineEditButton("suppliesitems/edit");
		$table->addDeleteButton("suppliesitems/delete");
		$table->addPrintButton("suppliesitems/index/");
		$tableContent =  array(
				"id" => "ID",
				"name" => CoreTranslator::Name($lang),
				"description" => SuTranslator::Description($lang),
				"is_active" => SuTranslator::Is_active($lang)
		);	
		
		$tableHtml = $table->view($itemsArray,$tableContent);
		
		//$print = $this->request->getParameterNoException("print");
		if ($table->isPrint()){
			echo $tableHtml;
			return;
		}
		
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
		$modelConfig = new CoreConfig();
		$supliesusersdatabase = $modelConfig->getParam("supliesusersdatabase");
		
		if ($supliesusersdatabase == "local"){
			$modelBelonging = new SuBelonging();
		}
		else{
			$modelBelonging = new CoreBelonging();
		}
		$belongingTable = $modelBelonging->getAll();
		
		// fill the pricing table with the prices for this resource
		$modelItemPricing = new SuItemPricing();
		for ($i = 0 ; $i < count($belongingTable) ; ++$i){
			$pid = $belongingTable[$i]['id'];
			$inter = $modelItemPricing->getPrice($id, $pid);
			$belongingTable[$i]['val_price'] = $inter['price'];
		}
		
		// view
		$navBar = $this->navBar();
		$this->generateView ( array (
				'navBar' => $navBar,
				'id' => $id,
				'name' => $name,
				'description' => $description,
				'is_active' => $is_active,
				'pricingTable'=> $belongingTable
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
		$modelBelonging = "";
		
		$modelConfig = new CoreConfig();
		$supliesusersdatabase = $modelConfig->getParam("supliesusersdatabase");
		
		if($supliesusersdatabase == "local"){
			$modelBelonging = new SuBelonging();
		}
		else{
			$modelBelonging = new CoreBelonging();
		}
		
		$pricingTable = $modelBelonging->getBelongings();
		foreach ($pricingTable as $pricing){
			$pid = $pricing['id'];
			if ($pid > 1){
				//$pname = $pricing['name'];
				$price = $this->request->getParameterNoException($pid. "_price");
				if ($price != ""){
					$modelItemPricing->setPricing($id_item, $pid, $price);
				}
			}
		}
	
		$this->redirect ( "suppliesitems" );
	}
	
	/**
	 * Query to delete an item
	 */
	public function delete(){
	
		$id = $this->request->getParameter("actionid");
	
		$modelItem = new SuItem();
		$modelItem->delete($id);
	
		// generate view
		$this->redirect("suppliesitems");
	}
}