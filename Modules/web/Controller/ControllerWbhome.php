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

class ControllerWbhome extends ControllerOpen {

    public function index() {

        $lang = $this->getLanguage();
        $modelCoreCongig = new CoreConfig();
        
        $modelCarousel = new WbCarousel();
        $carousel = $modelCarousel->selectAll("id");
        
        $modelFeature = new WbFeature();
        $features = $modelFeature->selectAll("id");
        
        $modelArticles = new WbArticle();
        $news = $modelArticles->getLastNews(3);
        
        $viewFeatures = $modelCoreCongig->getParam("webViewFeatures");
        $viewNews = $modelCoreCongig->getParam("webViewNews");
        $viewEvents = $modelCoreCongig->getParam("webViewEvents");
        
        // view
        $this->generateView(array(
            'carousel' => $carousel,
            'viewFeatures' => $viewFeatures,
            'viewNews' => $viewNews,
            'viewEvents' => $viewEvents,
            'features' => $features,
            'news' => $news,
            'lang' => $lang
        ));
    }
}
