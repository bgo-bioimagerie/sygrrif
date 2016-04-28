<?php

require_once 'Framework/Controller.php';
require_once 'Framework/Form.php';
require_once 'Framework/TableView.php';

require_once 'Modules/core/Controller/ControllerSecureNav.php';

require_once 'Modules/networking/Controller/NtTranslator.php';
require_once 'Modules/networking/Controller/NtRoles.php';

class ControllerNtroles extends ControllerSecureNav {

    public function index(){
        $lang = $this->getLanguage();
        
        $modelGroups = new NtRoles();
        $groups = $modelGroups->getAll();
        
        $table = new TableView();
		
	$table->setTitle(NtTranslator::Groups($lang));
	$table->addLineEditButton("ntroles/edit");
	$table->addDeleteButton("ntroles/delete");
	$table->addPrintButton("ntroles/index/");
	
	$tableContent =  array(
            "id" => "ID",
            "name" => CoreTranslator::Name($lang)
	);
        
        $tableHtml = $table->view($groups,$tableContent);
	
        // view
        $navBar = $this->navBar();
        $this->generateView ( array (
            'navBar' => $navBar,
            'tableHtml' => $tableHtml
	) );
    }
    
    public function edit(){
        
        $id = 0;
        if ($this->request->isParameterNotEmpty('actionid')){
            $id = $this->request->getParameter("actionid");
	}
        
        $group = array("id" => 0, "name" => "");
        if ($id > 0){
            $modelGroup = new NtRoles();
            $modelGroup->get($id);
        }
        
        // lang
	$lang = $this->getLanguage();

	// form
	// build the form
	$form = new Form($this->request, "Ntroles/edit");
	$form->setTitle(NtTranslator::Edit_Group($lang));
	$form->addHidden("id", $group["id"]);
	$form->addText("name", CoreTranslator::Name($lang), true, $group["name"]);
       	
	$form->setValidationButton(CoreTranslator::Ok($lang), "Ntroles/edit");
	$form->setCancelButton(CoreTranslator::Cancel($lang), "Ntroles");
		
	if ($form->check()){
            // run the database query
            $model = new NtRoles();
            $model->set($form->getParameter("id"), $form->getParameter("name"));
			
            $this->redirect("Ntroles");
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
    
    
    public function delete(){
        
        $id = 0;
        if ($this->request->isParameterNotEmpty('actionid')){
            $id = $this->request->getParameter("actionid");
	}
        
        $model = new NtRole();
        $model->delete($id);
        
        $this->redirect("ntroles");
    }
}