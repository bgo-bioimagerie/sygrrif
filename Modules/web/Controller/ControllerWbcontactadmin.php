<?php

require_once 'Framework/Controller.php';
require_once 'Framework/Form.php';
require_once 'Framework/Upload.php';

require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/CoreConfig.php';
require_once 'Modules/core/Model/CoreTranslator.php';

require_once 'Modules/web/Model/WbContact.php';
require_once 'Modules/web/Model/WbTranslator.php';

class ControllerWbcontactadmin extends ControllerSecureNav {

    public function index(){
        
        $lang = $this->getLanguage();
        
        $modelContact = new WbContact();
        $content = $modelContact->get();
        if (count($content) == 0){
            $content = array("id" => 0, "name" => "", "tel" => "", "email" => "", "content" => "");
        }
        
        $form = new Form($this->request, "wbcontactadmin/index");
        $form->setTitle(WbTranslator::Contact($lang));
        $form->addHidden("id", $content["id"]);
        $form->addText("name", CoreTranslator::Name($lang), false, $content["name"]);
        $form->addText("tel", CoreTranslator::Phone($lang), false, $content["tel"]);
        $form->addText("email", CoreTranslator::Email($lang), false, $content["email"]);
        $form->addTextArea("content", WbTranslator::Content($lang), false, $content["content"]);
        
        $form->setButtonsWidth(2, 10);
        $form->setValidationButton(CoreTranslator::Save($lang), "wbcontactadmin/index");
        
        if ($form->check()){
            
            $modelContact->set($this->request->getParameter("id"), 
                    $this->request->getParameter("name"), 
                    $this->request->getParameter("tel"), 
                    $this->request->getParameter("email"), 
                    $this->request->getParameter("content")
                );
            
            $this->redirect("wbcontactadmin/index");
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
