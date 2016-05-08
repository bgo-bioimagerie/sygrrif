<?php

require_once 'Framework/Controller.php';
require_once 'Framework/Form.php';
require_once 'Framework/Upload.php';

require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/CoreConfig.php';
require_once 'Modules/core/Model/CoreTranslator.php';

require_once 'Modules/web/Model/WbTranslator.php';
require_once 'Modules/web/Model/WbMenu.php';

class ControllerWbmenu extends ControllerSecureNav {

    public function index() {

        $modelConfig = new CoreConfig();
        
        $lang = $this->getLanguage();
        $form = new Form($this->request, "wbmenu/index");
        $form->setTitle(WbTranslator::Menu($lang));
        $form->addSelect("webMenuActive", WbTranslator::Is_active($lang), array(CoreTranslator::yes($lang), CoreTranslator::no($lang)), array(1,0), $modelConfig->getParam("webMenuActive"));
        $form->addText("webMenuTitle", CoreTranslator::title($lang), true, $modelConfig->getParam("webMenuTitle"));
        $form->addDownload("logo", CoreTranslator::logo($lang));
        
        $form->setValidationButton(CoreTranslator::Ok($lang), "wbmenu/index");
        $form->setCancelButton(CoreTranslator::Cancel($lang), "wbmenu");


        if ($form->check()) {
            // run the database query
            $webMenuActive = $form->getParameter("webMenuActive");
            $modelConfig->setParam("webMenuActive", $webMenuActive);
            if ($webMenuActive == 1){
                $modelConfig->setParam("menuUrl", "Modules/web/View/menubar.php");
            }
            else{
                $modelConfig->setParam("menuUrl", "");
            }
            $webMenuTitle = $form->getParameter("webMenuTitle");
            $modelConfig->setParam("webMenuTitle", $webMenuTitle);
            
            // upload file	
            $webDataDir = "data/web";
            if ($_FILES["logo"]["name"] != ""){
                Upload::uploadFile($webDataDir, "logo");
                $modelConfig->setParam("webMenuIcon", $webDataDir . $_FILES["logo"]["name"]);
            }
            
            $this->redirect("wbmenu");
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

    public function links(){
        
        $modelMenu = new WbMenu();
        $menuItems = $modelMenu->selectAll("display_order");
        
        //print_r($menuItems);
        
        $navBar = $this->navBar();
            $this->generateView(array(
                'navBar' => $navBar,
                'menuItems' => $menuItems
            ));
    }
    
    public function linksquery(){
        
        $name = $this->request->getParameter("name");
        $url = $this->request->getParameter("url");
        $display_order = $this->request->getParameter("display_order");
        
        $modelMenu = new WbMenu();
        $modelMenu->deleteAll();
        for($i = 0 ; $i < count($name) ; $i++){
            $modelMenu->insert(array("name" => $name[$i], "url" => $url[$i] , "display_order" => $display_order[$i]) );
        }
        
        $this->redirect("wbmenu/links");
    }
}
