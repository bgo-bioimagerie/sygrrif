<?php

require_once 'Framework/Controller.php';
require_once 'Framework/Form.php';
require_once 'Framework/TableView.php';
require_once 'Framework/Upload.php';

require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/CoreTranslator.php';

require_once 'Modules/networking/Model/NtTranslator.php';
require_once 'Modules/networking/Model/NtGroup.php';
require_once 'Modules/networking/Model/NtRole.php';
require_once 'Modules/networking/Model/NtComment.php';

class ControllerNtgroups extends ControllerSecureNav {

    public function index(){
        $lang = $this->getLanguage();
        
        $modelGroups = new NtGroup();
        $groups = $modelGroups->getAll();
        
        $navBar = $this->navBar();
        $this->generateView ( array (
            'navBar' => $navBar,
            'lang' => $lang,
            'groups' => $groups
	) );
    }
    
    public function edit(){
        
        $id = 0;
        if ($this->request->isParameterNotEmpty('actionid')){
            $id = $this->request->getParameter("actionid");
	}
        
        $group = array("id" => 0, "name" => "", "description" => "");
        $groupusers = array();
        $is_user_admin = true;
        $modelGroup = new NtGroup();
        if ($id > 0){
            $group = $modelGroup->get($id);
            $is_user_admin = $modelGroup->isUserGroupAdmin($id, $_SESSION["id_user"]);
        }
        
        // lang
	$lang = $this->getLanguage();

	// form edit info
	$form = new Form($this->request, "Ntgroups/edit");
        $form->setColumnsWidth(3, 9);
        $form->setButtonsWidth(6, 6);
	$form->addHidden("id", $group["id"]);
	$form->addText("name", CoreTranslator::Name($lang), true, $group["name"]);
        $form->addTextArea("description", CoreTranslator::Description($lang), false, $group["description"]);
        if ($is_user_admin){
            $form->addDownload("image_url", NtTranslator::Image($lang));	

            $form->setValidationButton(CoreTranslator::Ok($lang), "Ntgroups/edit");
            if ($group["id"] > 0){
                $form->setDeleteButton(CoreTranslator::Delete($lang), "Ntgroups/delete", $group["id"]);
            }
        }
        
        // form user
        $modelRole = new NtRole();
        $roles = $modelRole->getAll();
        $rolesNames = array();
        $rolesId = array();
        foreach($roles as $role){
            $rolesNames[] = $role["name"];
            $rolesId[] = $role["id"];
        }
        
        $modeluser = new CoreUser();
        $users = $modeluser->getActiveUsers("name");
        $usersNames = array();
        $usersId = array();
        foreach($users as $user){
            $usersNames[] = $user["name"] . " " . $user["firstname"];
            $usersId[] = $user["id"];
        }
        
        
        $formUser = new Form($this->request, "Ntgroups/adduser");
        $formUser->setColumnsWidth(3, 9);
        $formUser->setButtonsWidth(2, 10);
        $formUser->addHidden("id_group", $group["id"]);
        $formUser->addSelect("id_user", CoreTranslator::User($lang), $usersNames, $usersId);
        $formUser->addSelect("id_role", NtTranslator::Role($lang), $rolesNames, $rolesId);
        $formUser->setValidationButton(CoreTranslator::Ok($lang), "Ntgroups/edit");
        
        // formComment
        $formComment = new Form($this->request, "Ntgroupscomment");
        $formComment->setColumnsWidth(0, 12);
        $formComment->setButtonsWidth(2, 10);
        $formComment->addHidden("id_group", $group["id"]);
        $formComment->addTextArea("comment", "", true);
        $formComment->setValidationButton(NtTranslator::Publish($lang), "Ntgroups/edit");
        
	if ($form->check()){
            // run the database query
            $groupsDataDir = "data/networking/groups/";
            $model = new NtGroup();
            $group_id = $model->set($form->getParameter("id"), 
                        $form->getParameter("name"), 
                        $form->getParameter("description"),
                        $groupsDataDir . $_FILES["image_url"]["name"]
                    );
            
            // add the curent user as a group admin
            $model->setUserToGroup($group_id, $_SESSION["id_user"], 2);
            
	    // upload file	
            if ($_FILES["image_url"]["name"] != ""){
                Upload::uploadFile($groupsDataDir, "image_url");
            }
            
            // redirect
            $this->redirect("Ntgroups/edit/" . $group_id);
	}
        else if($formUser->check()){
            // query
            $model = new NtGroup();
            $id_group = $this->request->getParameter("id_group");
            $id_user = $this->request->getParameter("id_user");
            $id_role = $this->request->getParameter("id_role");
            $model->setUserToGroup($id_group, $id_user, $id_role);
            // redirect
            $this->redirect("Ntgroups/edit/" . $id_group);
        }
        else if($formComment->check()){
            $model = new NtComment();
            $id_group = $this->request->getParameter("id_group");
            $comment = $this->request->getParameter("comment");
            
            $id_comment = $model->add($comment, $_SESSION["id_user"], time());
            
            $modelGroup->setCommentToGroup($id_group, $id_comment);
            
            $this->redirect("Ntgroups/edit/" . $id_group);
        }
	else{
            // set the view
            $formHtml = $form->getHtml();
            $formUserHtml = "";
            if ($is_user_admin){
                $formUserHtml = $formUser->getHtml();
            }
            $formCommentHtml = $formComment->getHtml();
            $comments = $modelGroup->getAllComments($id);
            $_SESSION["networking_opened_group"] = $id;
            
            $groupusers = $modelGroup->getUsers($id);
            $tableUsers = new TableView();
            if ($is_user_admin){
                $tableUsers->addDeleteButton("Ntgroups/deleteuser");
            }
            $groupusershtml = $tableUsers->view($groupusers, array("name" => CoreTranslator::Name($lang), "firstname" => CoreTranslator::Firstname($lang), "role" => NtTranslator::Role($lang)));
		
            // view
            $navBar = $this->navBar();
            $this->generateView ( array (
                    'navBar' => $navBar,
                    'formHtml' => $formHtml,
                    'lang' => $lang,
                    'group_id' => $id,
                    'group' => $group,
                    'groupusershtml' => $groupusershtml,
                    'formUserHtml' => $formUserHtml,
                    'formCommentHtml' => $formCommentHtml,
                    'comments' => $comments
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
    
    public function delete(){
        
        $id = $this->request->getParameter("actionid");
        
        $lang = $this->getLanguage();
        $modelGroup = new NtGroup();
        $group = $modelGroup->get($id);
        
        $navBar = $this->navBar();
        $this->generateView ( array (
            'navBar' => $navBar,
            'group' => $group,
            'lang' => $lang
        ) );
        
    }
    
    public function deletequery(){
        
        $id = $this->request->getParameter("id_group");
        
        //echo "delete group " . $id . "<br/>";
        
        $modelGroup = new NtGroup();
        $modelGroup->delete($id);
        
        $this->redirect("ntgroups");
    }
    
    public function deleteuser(){
        
        $id_group = $_SESSION["networking_opened_group"];
        $id_user = $this->request->getParameter("actionid");
        
        $modelGroup = New NtGroup();
        $modelGroup->removeUserFromGroup($id_group, $id_user);
        
        $this->redirect("ntgroups/edit/" . $id_group);
    }
}