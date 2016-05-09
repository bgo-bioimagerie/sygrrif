<?php

require_once 'Framework/Controller.php';

require_once 'Framework/Form.php';
require_once 'Framework/TableView.php';

require_once 'Modules/core/Controller/ControllerOpen.php';
require_once 'Modules/core/Model/CoreConfig.php';
require_once 'Modules/core/Model/CoreTranslator.php';

require_once 'Modules/web/Model/WbTranslator.php';
require_once 'Modules/web/Model/WbSubMenu.php';
require_once 'Modules/web/Model/WbArticle.php';

class ControllerWbarticles extends ControllerOpen {

    public function index() {

        // list all articles of the page
        $lang = $this->getLanguage();
        $this->generateView(array('lang' => $lang));
    }

    public function article() {

        // get user id
        $id_article = 0;
        if ($this->request->isParameterNotEmpty('actionid')) {
            $id_article = $this->request->getParameter("actionid");
        }

        // get belonging info
        $modelArticle = new WbArticle();
        $article = $modelArticle->select($id_article);
        
        $modelSubMenu = new WbSubMenu();
        $menuInfo = $modelSubMenu->selectSubMenu($article["id_parent_menu"]);
        $menuItems = $modelSubMenu->selectSubMenuItems($article["id_parent_menu"]);

        // view
        $this->generateView(array(
            'article' => $article,
            'menuInfo' => $menuInfo,
            'menuItems' => $menuItems
        ));
        
    }

}
