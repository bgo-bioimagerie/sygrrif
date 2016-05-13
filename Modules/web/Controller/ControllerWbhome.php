<?php

require_once 'Framework/Controller.php';
require_once 'Framework/Form.php';
require_once 'Framework/Upload.php';

require_once 'Modules/core/Controller/ControllerOpen.php';
require_once 'Modules/core/Model/CoreConfig.php';
require_once 'Modules/core/Model/CoreTranslator.php';

require_once 'Modules/web/Model/WbTranslator.php';
require_once 'Modules/web/Model/WbMenu.php';
require_once 'Modules/web/Model/WbCarousel.php';
require_once 'Modules/web/Model/WbFeature.php';
require_once 'Modules/web/Model/WbArticle.php';

require_once 'Modules/agenda/Model/AgEvent.php';

class ControllerWbhome extends ControllerOpen {

    public function index() {

        $lang = $this->getLanguage();
        $modelCoreCongig = new CoreConfig();
        
        $modelCarousel = new WbCarousel();
        $carousel = $modelCarousel->selectAll("id");
        $carouselFullWidth = true;
        
        $modelFeature = new WbFeature();
        $features = $modelFeature->selectAll("id");
        
        $modelArticles = new WbArticle();
        $news = $modelArticles->getLastNews(3);
        
        $viewFeatures = $modelCoreCongig->getParam("webViewFeatures");
        $viewNews = $modelCoreCongig->getParam("webViewNews");
        $viewEvents = $modelCoreCongig->getParam("webViewEvents");
        
        $events = array();
        if($viewEvents){
            $modelAgenda = new AgEvent();
            $events = $modelAgenda->getLastEvents();
        }
        
        
        $copyright = $modelCoreCongig->getParam("webCopyright");
        
        // view
        $this->generateView(array(
            'carousel' => $carousel,
            'carouselFullWidth' => $carouselFullWidth,
            'viewFeatures' => $viewFeatures,
            'viewNews' => $viewNews,
            'viewEvents' => $viewEvents,
            'features' => $features,
            'news' => $news,
            'events' => $events,
            'copyright' => $copyright,
            'lang' => $lang
        ));
    }
}
