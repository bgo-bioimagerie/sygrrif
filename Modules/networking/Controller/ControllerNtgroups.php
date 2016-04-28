<?php

require_once 'Framework/Controller.php';
require_once 'Framework/Form.php';
require_once 'Framework/TableView.php';

require_once 'Modules/core/Controller/ControllerSecureNav.php';

require_once 'Modules/networking/Controller/NtTranslator.php';
require_once 'Modules/networking/Controller/NtGroup.php';

class ControllerNtgroups extends ControllerSecureNav {

    public function index(){
        $lang = $this->getLanguage();
        
        $modelGroups = new NtGroup();
        $groups = $modelGroups->getAll();
        
        $table = new TableView();
		
	$table->setTitle(NtTranslator::Groups($lang));
	$table->addLineEditButton("ntgroups/edit");
	$table->addDeleteButton("ntgroups/delete");
	$table->addPrintButton("ntgroups/index/");
	
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
            $modelGroup = new NtGroup();
            $modelGroup->get($id);
        }
        
        // lang
	$lang = $this->getLanguage();

	// form
	// build the form
	$form = new Form($this->request, "Ntgroups/edit");
	$form->setTitle(NtTranslator::Edit_Group($lang));
	$form->addHidden("id", $group["id"]);
	$form->addText("name", CoreTranslator::Name($lang), true, $group["name"]);
        $form->addText("description", CoreTranslator::Description($lang), false, $group["description"]);
		
	$form->setValidationButton(CoreTranslator::Ok($lang), "Ntgroups/edit");
	$form->setCancelButton(CoreTranslator::Cancel($lang), "Ntgroups");
		
	if ($form->check()){
            // run the database query
            $model = new NtGroup();
            $model->set($form->getParameter("id"), $form->getParameter("name"), $form->getParameter("description"));
			
            $this->redirect("Ntgroups");
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
    
    public function editusers(){
        
        $id = 0;
        if ($this->request->isParameterNotEmpty('actionid')){
            $id = $this->request->getParameter("actionid");
	}
        
        $modelGroup = new NtGroup();
        $groupUsers = $modelGroup->getGroupUsers($id);
        
        $modelUser = new CoreUser();
        $users = $modelUser->getActiveUsers("name");
        
        // view
        $navBar = $this->navBar();
        $this->generateView ( array (
            'navBar' => $navBar,
            'groupUsers' => $groupUsers,
            'users' => $users,
            'id_group' => $id
        ) );
    }
    
    public function editusersquery(){
        
        $id_group = $this->request->getParameter("id_group");
        $id_user = $this->request->getParameter("id_user");
        $id_role = $this->request->getParameter("is_role");
        
        $modelGroup = new NtGroup();
        for( $i = 0 ; $i < count($id_user) ; $i++){
            $modelGroup->setUserToGroup($id_group, $id_user[$i], $id_role[$i]);
        }
        
        $this->redirect("ntgroups");
    }
}