<?php

require_once 'Framework/Controller.php';
require_once 'Framework/Form.php';
require_once 'Framework/Upload.php';

require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/ModulesManager.php';
require_once 'Modules/core/Model/LdapConfiguration.php';
require_once 'Modules/core/Model/CoreTranslator.php';


/**
 * 
 * @author sprigent
 * 
 * Config the home page informations
 */
class ControllerHomeconfig extends ControllerSecureNav {

	/**
	 * Constructor
	 */
	public function __construct() {
            parent::__construct();
	}

	/**
	 * (non-PHPdoc)
	 * Show the config index page
	 * 
	 * @see Controller::index()
	 */
	public function index() {
            
            $lang = $this->getLanguage();
        
            $modelSettings = new CoreConfig();
            $home_title = $modelSettings->getParam("home_title");
            $home_message = $modelSettings->getParam("home_message");

            $form = new Form($this->request, "homeconfig/request");
            $form->setTitle(CoreTranslator::ConnectionPageData($lang));
            $form->addText("home_title", CoreTranslator::title($lang), false, $home_title);
            $form->addText("home_message", CoreTranslator::Description($lang), false, $home_message);

            for($i=1 ; $i < 4 ; $i++){
                $form->addSeparator(CoreTranslator::Carousel($lang) . " " . strval($i) );
                $form->addDownload("image_url" . strval($i), CoreTranslator::Image_Url($lang));        
            }
            $form->setButtonsWidth(2, 10);
            $form->setValidationButton(CoreTranslator::Save($lang), "homeconfig/index");

            if ($form->check()){

                $modelSettings->setParam("home_title", $this->request->getParameter("home_title"));
                $modelSettings->setParam("home_message", $this->request->getParameter("home_message"));
                
                for($i=1 ; $i < 4 ; $i++){
                    $target_dir = "data/core/";
                    if ($_FILES["image_url" . $i]["name"] != ""){
                        Upload::uploadFile($target_dir, "image_url" . $i);
                        $modelSettings->setParam("connection_carousel" . strval($i), $target_dir . $_FILES["image_url" . $i]["name"]);
                    }
                }
                $this->redirect("homeconfig/index");
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