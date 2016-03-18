<?php

require_once 'Framework/Controller.php';
require_once 'Framework/Form.php';
require_once 'Framework/TableView.php';

require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/CoreBelonging.php';

require_once 'Modules/quotes/Model/QoQuote.php';
require_once 'Modules/quotes/Model/QoTranslator.php';


class ControllerQuotes extends ControllerSecureNav {

	public function index() {
		
		$navBar = $this->navBar ();
		
		$lang = $this->getLanguage();
		
		// get the user list
                $modelQuote = new QoQuote();
                $data = $modelQuote->getAll();
                
                $modelUser = new CoreUser();
                $modelUnit = new CoreUnit();
                $modelBelonging = new CoreBelonging();
                for($i = 0 ; $i <  count($data) ; $i++){
                    if ($data[$i]["id_user"] > 0){
                        $data[$i]["recipient"] = $modelUser->getUserFUllName($data[$i]["id_user"]);
                        $idUnit = $modelUser->getUserUnit($data[$i]["id_user"]);
                        $data[$i]["address"] = $modelUnit->getAdress($idUnit);
                        $data[$i]["belonging"] = $modelBelonging->getName($modelUnit->getBelonging($idUnit));
                    }
                    else{
                        $data[$i]["belonging"] = $modelBelonging->getName($data[$i]["id_belonging"]);
                    }
                    $data[$i]["date_open"] = CoreTranslator::dateFromEn($data[$i]["date_open"], $lang);
                    $data[$i]["date_last_modified"] = CoreTranslator::dateFromEn($data[$i]["date_last_modified"], $lang);
                }
                
		$table = new TableView();
		$table->setTitle(QoTranslator::Quotes($lang));
		$table->addLineEditButton("quotes/edit");
		$table->addDeleteButton("quotes/delete", "id", "id");
		$table->addPrintButton("quotes/index/");
		$tableHtml = $table->view($data, array("id" => "ID", "recipient" => QoTranslator::Recipient($lang), "address" => CoreTranslator::Address($lang), "belonging" => CoreTranslator::Belonging($lang),
                                                        "date_open" => QoTranslator::DateCreated($lang), "date_last_modified" => QoTranslator::DateLastModified($lang)));
	
		if ($table->isPrint()){
			echo $tableHtml;
			return;
		}
		
		$this->generateView ( array (
				'navBar' => $navBar,
				'tableHtml' => $tableHtml 
		) );
        }
        
        public function edit(){
            
            // get parameters
            $id = $this->request->getParameter ( "actionid" );
            
            $modelQuote = new QoQuote();
            if ($id > 0){
                $entry = $modelQuote->getInfo($id);
            }
            else{
                $entry = $modelQuote->getDefault();
            }
            
            // get the content
            $content = $modelQuote->getContent($id);
            
            // get the list of entries
            $entryList = $modelQuote->getAllSupplies();
            //print_r($entryList);
            
            // belongings
            $modelBelonging = new CoreBelonging();
            $belongings = $modelBelonging->getBelongings("name");
            
            // view
            $navBar = $this->navBar ();
            $this->generateView ( array (
				'navBar' => $navBar,
				'belongings' => $belongings,
                                'entry' => $entry,
                                'content' => $content,
                                'entryList' => $entryList
		) );
        }
        
        public function editquery(){
            
            // get post 
            $id = $this->request->getParameter ( "id" );
            $recipient = $this->request->getParameterNoException ( "recipient" );
            $address = $this->request->getParameterNoException ( "address" );
            $id_belonging = $this->request->getParameterNoException ( "id_belonging" );
            $id_user = $this->request->getParameterNoException ( "id_user" );
            $contentKeys = $this->request->getParameter ( "cid" );
            $contentValues = $this->request->getParameter ( "cvalue" );
            
            // calculate dates
            $modelQuote = new QoQuote();
            if ($id == 0){
                $date_open = date("Y-m-d");
            }
            else{
                $date_open = $modelQuote->getDateCreated($id);
            }
            $date_last_modified = date("Y-m-d");
            
            // set to database
            $quoteID = $modelQuote->set($id, $id_user, $recipient, $address, $id_belonging, $date_open, $date_last_modified);
            $modelQuote->setContent($quoteID, $contentKeys, $contentValues);
            
            // todo generate a xls quote
            $modelQuote->generateQuoteXls($quoteID);
            
            //$this->redirect("quotes");
        }
        
        public function editexistinguser(){
            // get parameters
            $id = $this->request->getParameter ( "actionid" );
            
            $modelQuote = new QoQuote();
            if ($id > 0){
                $entry = $modelQuote->getInfo($id);
            }
            else{
                $entry = $modelQuote->getDefault();
            }
            
            // get the content
            $content = $modelQuote->getContent($id);
            
            // get the list of entries
            $entryList = $modelQuote->getAllSupplies();
            //print_r($entryList);
            
            $UserModel = new CoreUser();
            $users = $UserModel->getActiveUsers();
            
             // view
            $navBar = $this->navBar ();
            $this->generateView ( array (
				'navBar' => $navBar,
				'users' => $users,
                                'entry' => $entry,
                                'content' => $content,
                                'entryList' => $entryList
		) );
        }
        
        public function delete(){
            $id = $this->request->getParameterNoException ( "actionid" );
            
            $modelQuotes = new QoQuote();
            $modelQuotes->delete($id);
            
            $this->redirect("quotes");
        }
}