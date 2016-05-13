<?php

require_once 'Framework/Controller.php';
require_once 'Framework/Form.php';
require_once 'Framework/Upload.php';
require_once 'Framework/TableView.php';

require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/CoreConfig.php';
require_once 'Modules/core/Model/CoreTranslator.php';

require_once 'Modules/web/Model/WbContact.php';
require_once 'Modules/web/Model/WbTranslator.php';
require_once 'Modules/web/Model/WbTeam.php';


class ControllerWbteamadmin extends ControllerSecureNav {

    public function index() {
        
        $lang = $this->getLanguage();
        $modelTeam = new WbTeam();
        $data = $modelTeam->selectAll();
        $headers = array("name" => CoreTranslator::Name($lang),
                         "email" => CoreTranslator::Email($lang),
                         "tel" => CoreTranslator::Phone($lang)
            );
        
        $table = new TableView();
        $table->setTitle(WbTranslator::People($lang));
        $table->addLineEditButton("Wbteamadmin/edit", "id");
        $table->addDeleteButton("Wbteamadmin/delete");
        $tableHtml = $table->view($data, $headers);
        
        $navBar = $this->navBar();
        $this->generateView(array('navBar' => $navBar, 
                                  'tableHtml' => $tableHtml));
        
    }
    
    public function edit(){
        
        $lang = $this->getLanguage();
        
        $id_data = 0;
        if ($this->request->isParameterNotEmpty('actionid')) {
            $id_data = $this->request->getParameter("actionid");
        }
        
        $modelTeam = new WbTeam();
        $content = $modelTeam->get($id_data);
        if (count($content) == 0){
            $content = array("id" => 0, "name" => "", "job" => "", "tel" => "", "email" => "", "misc" => "");
        }
        
        $form = new Form($this->request, "Wbteamadmin/edit");
        $form->setTitle(WbTranslator::People($lang));
        $form->addHidden("id", $content["id"]);
        $form->addText("name", CoreTranslator::Name($lang), false, $content["name"]);
        $form->addText("job", WbTranslator::Job($lang), false, $content["job"]);
        $form->addText("tel", CoreTranslator::Phone($lang), false, $content["tel"]);
        $form->addText("email", CoreTranslator::Email($lang), false, $content["email"]);
        $form->addText("misc", WbTranslator::Content($lang), false, $content["misc"]);
        $form->addDownload("image_url", WbTranslator::Image_Url());
        
        $form->setButtonsWidth(2, 10);
        $form->setValidationButton(CoreTranslator::Save($lang), "Wbteamadmin/edit");
        
        if ($form->check()){
            
            $id = $modelTeam->set($this->request->getParameter("id"), 
                    $this->request->getParameter("name"), 
                    $this->request->getParameter("job"), 
                    $this->request->getParameter("tel"), 
                    $this->request->getParameter("email"), 
                    $this->request->getParameter("misc")
                );
            
            $target_dir = "data/web/";
            if ($_FILES["image_url"]["name"] != ""){
                Upload::uploadFile($target_dir, "image_url");
                $modelTeam->setImage($id, $target_dir . $_FILES["image_url"]["name"]);
            }
            
            $this->redirect("Wbteamadmin/index");
        }
        else{
            $formHtml = $form->getHtml($lang);
            // view
            $navBar = $this->navBar();
            $this->generateView(array(
                'navBar' => $navBar,
                'formHtml' => $formHtml
            ));
        }
    }
   
}
