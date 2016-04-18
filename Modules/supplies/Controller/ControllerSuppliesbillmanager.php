<?php
require_once 'Framework/Controller.php';
require_once 'Framework/TableView.php';
require_once 'Framework/Form.php';

require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/CoreTranslator.php';
require_once 'Modules/core/Model/CoreUnit.php';

require_once 'Modules/supplies/Model/SuBill.php';
require_once 'Modules/supplies/Model/SuTranslator.php';

/**
 * Manage the bills: history of generated bills with status (generated, payed)
 * 
 * @author sprigent
 *
 */
class ControllerSuppliesbillmanager extends ControllerSecureNav {
	
	/**
	 * (non-PHPdoc)
	 * @see Controller::index()
	 */
	public function index() {
		
		// get the sort entry
		$sortentry = "id";
		if ($this->request->isParameterNotEmpty("actionid")) {
			$sortentry = $this->request->getParameter ( "actionid" );
		}
		
		// get bill list
                $modelInvoice = new SuBill();
		$billsList = $modelInvoice->getAllInfo();
		
		$lang = $this->getLanguage();
		for($i = 0 ; $i < count($billsList) ; $i++){
                    //id_responsible
			$billsList[$i]["responsible"] = $billsList[$i]['resp_name'] . " " . $billsList[$i]['resp_firstname'];
			if ($billsList[$i]['is_paid'] == 1){
				$billsList[$i]['is_paid'] = SuTranslator::Yes($lang);
			}
			else{
				$billsList[$i]['is_paid'] = SuTranslator::No($lang);
			}
			$billsList[$i]['date_generated'] = CoreTranslator::dateFromEn($billsList[$i]['date_generated'], $lang);
			$billsList[$i]['date_paid'] = CoreTranslator::dateFromEn($billsList[$i]['date_paid'], $lang);
		}
		
		$table = new TableView ();
		
		$table->setTitle ( SuTranslator::Bills_manager($lang) );
		$table->ignoreEntry("id", 1);
		$table->addLineEditButton ( "suppliesbillmanager/edit" );
		$table->addDeleteButton ( "suppliesbillmanager/delete", "id", "number" );
		$table->addPrintButton ( "suppliesbillmanager/index/" );
		
		$tableContent = array (
                    "number" => SuTranslator::Number($lang),
                    "responsible" => CoreTranslator::Responsible($lang),
                    "unit" =>  CoreTranslator::Unit($lang),
                    "date_generated" => SuTranslator::Date_Generated($lang),
                    "total_ht" => SuTranslator::Total_HT($lang),
                    "date_paid" => SuTranslator::Date_Paid($lang),
                    "is_paid" => SuTranslator::Is_Paid($lang)
                    );
		
		$tableHtml = $table->view ( $billsList, $tableContent );
		
		//$print = $this->request->getParameterNoException ( "print" );
		if ($table->isPrint ()) {
			echo $tableHtml;
			return;
		}
		
		$navBar = $this->navBar ();
		$this->generateView ( array (
				'navBar' => $navBar,
				'tableHtml' => $tableHtml
		) );
	}
	
	/**
	 * Form to edit a bill history
	 */
	public function edit(){
        
            $id = "";
            if ($this->request->isParameterNotEmpty("actionid")) {
                $id = $this->request->getParameter ( "actionid" );
            }
	
            if ($id == ""){
                $id = $this->request->getParameter ( "id" );
            }
            
            // lang
            $lang = $this->getLanguage();
            
            // get
            $modelInvoice = new SuBill();
            $info = $modelInvoice->getBill($id);
            
            // get names
            $modelUnit = new CoreUnit();
            $unitName = $modelUnit->getUnitName($info["id_unit"]);
            
            $modelUser = new CoreUser();
            $responsibleName = $modelUser->getUserFUllName($info["id_resp"]);

            // form
            // build the form
            $form = new Form($this->request, "suppliesbillmanager/edit");
            $form->setTitle(SuTranslator::Edit_Bill_Informations($lang));
            $form->addHidden("id", $info["id"]);
            $form->addText("number", SuTranslator::Number($lang), true, $info["number"], "readonly");
            $form->addText("id_unit", CoreTranslator::Unit($lang), true, $unitName, "readonly");
            $form->addText("id_responsible", CoreTranslator::Responsible($lang), true, $responsibleName, "readonly");
            $form->addText("date_generated", SuTranslator::Date_Generated($lang), true, CoreTranslator::dateFromEn($info["date_generated"],$lang), "readonly");
            $dp = $info["date_paid"];
            if ($dp == "0000-00-00"){
                $dp = "";
            }
            $form->addDate("date_paid", SuTranslator::Date_Paid($lang), true, CoreTranslator::dateFromEn($dp,$lang));
            $form->addSelect("is_paid", SuTranslator::Is_Paid($lang), array(SuTranslator::No($lang), SuTranslator::Yes($lang)), array(0,1), $info["is_paid"]);
            $form->addText("total_ht", SuTranslator::Total_HT($lang), true, $info["total_ht"]);
            $form->addDownloadButton(SuTranslator::Download($lang), $info["url"]);
            
            $form->setValidationButton(CoreTranslator::Ok($lang), "suppliesbillmanager/edit");
            $form->setCancelButton(CoreTranslator::Cancel($lang), "suppliesbillmanager");

            if ($form->check()) {
                // run the database query
                
                $modelInvoice->edit( $this->request->getParameter("id"),
                        CoreTranslator::dateToEn($this->request->getParameter("date_paid"), $lang), 
                        $this->request->getParameter("is_paid"),
                        $this->request->getParameter("total_ht")
                        );

                $this->redirect("suppliesbillmanager");
                 
            } else {
                // set the view
                $formHtml = $form->getHtml();
                // view
                $navBar = $this->navBar();
                $this->generateView(array(
                    'navBar' => $navBar,
                    'formHtml' => $formHtml
                ));
            }
	}
	
	/**
	 * Query to remove a bill from history
	 */
	public function delete(){
		$id = "";
		if ($this->request->isParameterNotEmpty("actionid")) {
			$id = $this->request->getParameter ( "actionid" );
		}
		
		if ($id != ""){
			$modelBillManager = new SuBill();
			$modelBillManager->delete($id);
		}
		$this->redirect("suppliesbillmanager");
	}

}