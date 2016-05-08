<?php

require_once 'Framework/Controller.php';
require_once 'Framework/Form.php';
require_once 'Framework/TableView.php';
require_once 'Framework/Upload.php';

require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/CoreTranslator.php';

require_once 'Modules/networking/Model/NtTranslator.php';
require_once 'Modules/networking/Model/NtProject.php';
require_once 'Modules/networking/Model/NtRole.php';
require_once 'Modules/networking/Model/NtComment.php';

class ControllerNtprojects extends ControllerSecureNav {

    public function index(){
        $lang = $this->getLanguage();
        
        $modelProjects = new NtProject();
        $projects = $modelProjects->getAll();
        
        $navBar = $this->navBar();
        $this->generateView ( array (
            'navBar' => $navBar,
            'lang' => $lang,
            'projects' => $projects
	) );
    }
    
    public function edit(){
        $id = 0;
        if ($this->request->isParameterNotEmpty('actionid')){
            $id = $this->request->getParameter("actionid");
	}
        
        // get project info
        $modelProject = new NtProject();
        if ($id > 0){
            $project = $modelProject->get($id);
        }
        else{
            $project = $modelProject->getDefault();
        }
        
        // lang
	$lang = $this->getLanguage();

	// form edit info
        $form = new Form($this->request, "Ntprojects/edit");
        $form->setColumnsWidth(2, 10);
        $form->setButtonsWidth(2, 10);
	$form->addHidden("id", $project["id"]);
	$form->addText("name", CoreTranslator::Name($lang), true, $project["name"]);
        $form->addTextArea("adressed_problem", NtTranslator::adressed_problem($lang), false, $project["adressed_problem"]);
        $form->addTextArea("expected_results", NtTranslator::expected_results($lang), false, $project["expected_results"]);
        $form->addTextArea("protocol", NtTranslator::protocol($lang), false, $project["protocol"]);
        
        $form->addDownload("image_url", NtTranslator::Image($lang));	

        $form->setValidationButton(CoreTranslator::Ok($lang), "Ntprojects/edit");
        if ($project["id"] > 0){
            $form->setDeleteButton(CoreTranslator::Delete($lang), "Ntprojects/delete", $project["id"]);
        }
        
        if ($form->check()){
            // run the database query
            $projectsDataDir = "data/networking/projects/";
            $project_id = $modelProject->set(
                    $this->request->getParameter("id"), 
                    $this->request->getParameter("name"), 
                    $this->request->getParameter("adressed_problem"), 
                    $this->request->getParameter("expected_results"), 
                    $this->request->getParameter("protocol"),
                    time()
                    );
            
            // add the curent user as a group admin
            $modelProject->setUserToProject($project_id, $_SESSION["id_user"], 2);
            
	    // upload file	
            if ($_FILES["image_url"]["name"] != ""){
                Upload::uploadFile($projectsDataDir, "image_url");
                $modelProject->setImageUrl($project_id, $projectsDataDir . $_FILES["image_url"]["name"]);
            }
            
            // redirect
            $this->redirect("Ntprojects/read/" . $project_id);
        }
        else{
            // view
            $formHtml = $form->getHtml($lang);
            $navBar = $this->navBar();
            $this->generateView ( array (
                    'navBar' => $navBar,
                    'formHtml' => $formHtml,
                    'lang' => $lang,
                    'group' => $project,
            ) );
        }
    }
    
    public function read(){
        
        $id = 0;
        if ($this->request->isParameterNotEmpty('actionid')){
            $id = $this->request->getParameter("actionid");
	}
        
        $modelProject = new NtProject();
        $projectusers = array();
        $is_user_admin = true;
        if ($id > 0){
            $project = $modelProject->get($id);
            $is_user_admin = $modelProject->isUserProjectAdmin($id, $_SESSION["id_user"]);
        }
        else{
            $project = $modelProject->getDefault();
        }
        
        // lang
	$lang = $this->getLanguage();

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
        
        
        $formUser = new Form($this->request, "Ntprojects/adduser");
        $formUser->setColumnsWidth(3, 9);
        $formUser->setButtonsWidth(2, 10);
        $formUser->addHidden("id_project", $project["id"]);
        $formUser->addSelect("id_user", CoreTranslator::User($lang), $usersNames, $usersId);
        $formUser->addSelect("id_role", NtTranslator::Role($lang), $rolesNames, $rolesId);
        $formUser->setValidationButton(CoreTranslator::Ok($lang), "Ntprojects/read");
        
        // formComment
        $formComment = new Form($this->request, "Ntprojectscomment");
        $formComment->setColumnsWidth(0, 12);
        $formComment->setButtonsWidth(2, 10);
        $formComment->addHidden("id_project", $project["id"]);
        $formComment->addTextArea("comment", "", true);
        $formComment->setValidationButton(NtTranslator::Publish($lang), "Ntprojects/read");
        
        // formFiles
        $formFiles = new Form($this->request, "Ntprojectsfiles");
        $formFiles->setColumnsWidth(0, 12);
        $formFiles->setButtonsWidth(2, 10);
        $formFiles->addHidden("id_project", $project["id"]);
        $formFiles->addDownload("file", "");
        $formFiles->setValidationButton(CoreTranslator::Ok($lang), "Ntprojects/read");
        
        if($formUser->check()){
            
            // query
            
            $id_project = $this->request->getParameter("id_project");
            $id_user = $this->request->getParameter("id_user");
            $id_role = $this->request->getParameter("id_role");
            $modelProject->setUserToProject($id_project, $id_user, $id_role);
            // redirect
            $this->redirect("ntprojects/read/" . $id_project);
        }
        else if($formComment->check()){
            
            $modelComment = new NtComment();
            $id_project = $this->request->getParameter("id_project");
            $comment = $this->request->getParameter("comment");
            
            $id_comment = $modelComment->add($comment, $_SESSION["id_user"], time());
            
            $modelProject->setCommentToProject($id_project, $id_comment);
            
            $this->redirect("ntprojects/read/" . $id_project);
        }
        else if ($formFiles->check()){
            
            $projectsDataDir = "data/networking/projects/";
            $project_id = $this->request->getParameter("id_project");
            $modelProject->addData(
                    $this->request->getParameter("id_project"), 
                    $projectsDataDir . $_FILES["file"]["name"]
                    );
            
            if ($_FILES["file"]["name"] != ""){
                Upload::uploadFile($projectsDataDir, "file");
            }
            
            // redirect
            $this->redirect("Ntprojects/read/" . $project_id);
        }
	else{
            // set the view
            $formUserHtml = "";
            if ($is_user_admin){
                $formUserHtml = $formUser->getHtml($lang);
            }
            $formCommentHtml = $formComment->getHtml($lang);
            $comments = $modelProject->getAllComments($id);
            $_SESSION["networking_opened_group"] = $id;
            
            // users
            $projectusers = $modelProject->getUsers($id);
            $tableUsers = new TableView();
            if ($is_user_admin){
                $tableUsers->addDeleteButton("Ntprojects/deleteuser");
            }
            $projectusershtml = $tableUsers->view($projectusers, array("name" => CoreTranslator::Name($lang), "firstname" => CoreTranslator::Firstname($lang), "role" => NtTranslator::Role($lang)));
		
            // data
            $formFilesHtml = $formFiles->getHtml($lang);
            $dataList = $modelProject->getData($id);
            
            // view
            $navBar = $this->navBar();
            $this->generateView ( array (
                    'navBar' => $navBar,
                    'lang' => $lang,
                    'project_id' => $id,
                    'project' => $project,
                    'groupusershtml' => $projectusershtml,
                    'formUserHtml' => $formUserHtml,
                    'formCommentHtml' => $formCommentHtml,
                    'formFilesHtml' => $formFilesHtml,
                    'dataList' => $dataList,
                    'comments' => $comments
            ) );
	}
    }
    
    public function editusers(){
        
        $id = 0;
        if ($this->request->isParameterNotEmpty('actionid')){
            $id = $this->request->getParameter("actionid");
	}
        
        $modelProject = new NtProject();
        $projectUsers = $modelProject->getGroupUsers($id);
        
        $modelUser = new CoreUser();
        $users = $modelUser->getActiveUsers("name");
        
        // view
        $navBar = $this->navBar();
        $this->generateView ( array (
            'navBar' => $navBar,
            'groupUsers' => $projectUsers,
            'users' => $users,
            'id_project' => $id
        ) );
    }
    
    public function editusersquery(){
        
        $id_project = $this->request->getParameter("id_project");
        $id_user = $this->request->getParameter("id_user");
        $id_role = $this->request->getParameter("is_role");
        
        $modelProject = new NtProject();
        for( $i = 0 ; $i < count($id_user) ; $i++){
            $modelProject->setUserToGroup($id_project, $id_user[$i], $id_role[$i]);
        }
        
        $this->redirect("ntprojects");
    }
    
    public function delete(){
        
        $id = $this->request->getParameter("actionid");
        
        $lang = $this->getLanguage();
        $modelProject = new NtProject();
        $project = $modelProject->get($id);
        
        $navBar = $this->navBar();
        $this->generateView ( array (
            'navBar' => $navBar,
            'group' => $project,
            'lang' => $lang
        ) );
        
    }
    
    public function deletequery(){
        
        $id = $this->request->getParameter("id_project");
        
        //echo "delete group " . $id . "<br/>";
        
        $modelProject = new NtProject();
        $modelProject->delete($id);
        
        $this->redirect("ntprojects");
    }
    
    public function deleteuser(){
        
        $id_project = $_SESSION["networking_opened_group"];
        $id_user = $this->request->getParameter("actionid");
        
        $modelProject = New NtProject();
        $modelProject->removeUserFromProject($id_project, $id_user);
        
        $this->redirect("ntprojects/edit/" . $id_project);
    }
}