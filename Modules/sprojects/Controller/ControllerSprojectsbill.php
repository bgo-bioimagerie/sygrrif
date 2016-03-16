<?php


require_once 'Framework/Controller.php';
require_once 'Framework/Form.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/sprojects/Model/SpBillGenerator.php';
require_once 'Modules/sprojects/Model/SpTranslator.php';

class ControllerSprojectsbill extends ControllerSecureNav {

	public function index() {
		
		$id_project = "id";
		if ($this->request->isParameterNotEmpty('actionid')){
			$id_project = $this->request->getParameter("actionid");
		}
		
		$modelBill = new SpBillGenerator();
		$modelBill->generateBill($id_project);
	}
        
        public function billperiod(){
            
            $date_start = $this->request->getParameterNoException("begin_period");
            $date_end = $this->request->getParameterNoException("end_period");
            
            // build the form
            $lang = $this->getLanguage();
            $form = new Form($this->request, "formbillperiod");
            $form->setTitle(SpTranslator::BillPerPeriode($lang));
            $form->addDate("begin_period", SpTranslator::Beginning_period($lang), true, $date_start);
            $form->addDate("end_period", SpTranslator::Beginning_period($lang), true, $date_end);
            $form->setValidationButton("Ok", "sprojectsbill/billperiod");
            $form->setCancelButton(CoreTranslator::Cancel($lang), "sprojects");
            
            if ($form->check()){
                // run the database query
                $modelBill = new SpBillGenerator();
                $modelBill->billAPeriod(CoreTranslator::dateToEn($date_start, $lang), CoreTranslator::dateToEn($date_end, $lang));
                return;
            }
            else{
                // set the view
		$formHtml = $form->getHtml();
		// view
		$navBar = $this->navBar();
		$this->generateView ( array (
                                    'navBar' => $navBar,
                                    'formHtml' => $formHtml
                    ) );
            }
        }
        
        public function onebillmultipleprojects(){
            
            // view
            $navBar = $this->navBar();
            $this->generateView ( array (
                                'navBar' => $navBar
                    ) );
        }
}