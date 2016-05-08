<?php

require_once 'Framework/Controller.php';
require_once 'Framework/Form.php';
require_once 'Framework/Upload.php';

require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/CoreConfig.php';
require_once 'Modules/core/Model/CoreTranslator.php';

require_once 'Modules/web/Model/WbTranslator.php';
require_once 'Modules/web/Model/WbMenu.php';
require_once 'Modules/web/Model/WbCarousel.php';
require_once 'Modules/web/Model/WbFeature.php';

class ControllerWbadminhome extends ControllerSecureNav {

    public function index() {

    }
    
    public function carousel(){
        
        $lang = $this->getLanguage();
        
        $modelCarousel = new WbCarousel();
        $carousel = $modelCarousel->selectAll("id");
        
        $form = new Form($this->request, "wbhome/request");
        $form->setTitle(WbTranslator::Carousel($lang));
        
        for($i=1 ; $i < 4 ; $i++){
            $form->addSeparator(WbTranslator::Carousel($lang) . " " . strval($i) );
            $form->addHidden("id" . strval($i), $carousel[$i-1]["id"]);
            $form->addText("title" . strval($i), WbTranslator::Title($lang), false, $carousel[$i-1]["title"]);  
            $form->addText("description" . strval($i), WbTranslator::Description($lang), false, $carousel[$i-1]["description"]);  
            $form->addText("link_url" . strval($i), WbTranslator::Link($lang), false, $carousel[$i-1]["link_url"]);     
            $form->addNumber("display_order" . strval($i), WbTranslator::Display_order($lang), false, $carousel[$i-1]["display_order"]);        
            $form->addDownload("image_url" . strval($i), WbTranslator::Image_Url($lang));        
        }
        $form->setButtonsWidth(2, 10);
        $form->setValidationButton(CoreTranslator::Save($lang), "wbhome/carousel");
        
        if ($form->check()){
            
            for($i=1 ; $i < 4 ; $i++){
                $modelCarousel->update(array("id" => $i), 
                                       array("title" => $this->request->getParameter("title" . strval($i)),
                                             "description" => $this->request->getParameter("description" . strval($i)),
                                             "link_url" => $this->request->getParameter("link_url" . strval($i)), 
                                             "display_order" => $this->request->getParameter("display_order" . strval($i)), 
                                            ) 
                                       );
                $target_dir = "data/web/";
                if ($_FILES["image_url" . $i]["name"] != ""){
                    Upload::uploadFile($target_dir, "image_url" . $i);
                    $modelCarousel->update(array("id" => $i),
                                           array("image_url" => $target_dir . $_FILES["image_url" . $i]["name"])
                                          ); 
                }
            }
            $this->redirect("wbhome/carousel");
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
    
    public function features(){
        
        $lang = $this->getLanguage();
        
        $modelFeature = new WbFeature();
        $modelCoreConfig = new CoreConfig();
        $carousel = $modelFeature->selectAll("id");
        
        $form = new Form($this->request, "wbhome/feature");
        $form->setTitle(WbTranslator::Features($lang));
        $form->addSelect("webViewFeatures", WbTranslator::ViewFeatures($lang), array(CoreTranslator::no($lang), CoreTranslator::yes($lang)), array(0,1), $modelCoreConfig->getParam("webViewFeatures"));
        
        for($i=1 ; $i < 4 ; $i++){
            $form->addSeparator(WbTranslator::Feature($lang) . " " . strval($i) );
            $form->addHidden("id" . strval($i), $carousel[$i-1]["id"]);
            $form->addText("title" . strval($i), WbTranslator::Title($lang), false, $carousel[$i-1]["title"]);  
            $form->addText("description" . strval($i), WbTranslator::Description($lang), false, $carousel[$i-1]["description"]);  
            $form->addText("link_url" . strval($i), WbTranslator::Link($lang), false, $carousel[$i-1]["link_url"]);     
            $form->addNumber("display_order" . strval($i), WbTranslator::Display_order($lang), false, $carousel[$i-1]["display_order"]);        
            $form->addDownload("image_url" . strval($i), WbTranslator::Image_Url($lang));        
        }
        $form->setButtonsWidth(2, 10);
        $form->setValidationButton(CoreTranslator::Save($lang), "wbhome/features");
        
        if ($form->check()){
            
            $modelCoreConfig->setParam("webViewFeatures", $this->request->getParameter("webViewFeatures"));
            
            for($i=1 ; $i < 4 ; $i++){
                $modelFeature->update(array("id" => $i), 
                                       array("title" => $this->request->getParameter("title" . strval($i)),
                                             "description" => $this->request->getParameter("description" . strval($i)),
                                             "link_url" => $this->request->getParameter("link_url" . strval($i)), 
                                             "display_order" => $this->request->getParameter("display_order" . strval($i)), 
                                            ) 
                                       );
                $target_dir = "data/web/";
                if ($_FILES["image_url" . $i]["name"] != ""){
                    Upload::uploadFile($target_dir, "image_url" . $i);
                    $modelFeature->update(array("id" => $i),
                                           array("image_url" => $target_dir . $_FILES["image_url" . $i]["name"])
                                          ); 
                }
            }
            $this->redirect("wbhome/features");
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
