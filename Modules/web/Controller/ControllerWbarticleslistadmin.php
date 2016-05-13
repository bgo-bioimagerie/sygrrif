<?php

require_once 'Framework/Controller.php';

require_once 'Framework/Form.php';
require_once 'Framework/TableView.php';

require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/CoreConfig.php';
require_once 'Modules/core/Model/CoreTranslator.php';

require_once 'Modules/web/Model/WbTranslator.php';
require_once 'Modules/web/Model/WbSubMenu.php';
require_once 'Modules/web/Model/WbArticle.php';
require_once 'Modules/web/Model/WbArticleList.php';

class ControllerWbarticleslistadmin extends ControllerSecureNav {

    public function index() {

        $lang = $this->getLanguage();

        $model = new WbArticleList();
        $modelMenu = new WbSubMenu();
        $data = $model->selectAll();
        for ($i = 0; $i < count($data); $i++) {
            $pmenu = $modelMenu->selectItem($data[$i]["id_parent_menu"]);
            $data[$i]["parent_menu"] = $pmenu["title"];
            if ($data[$i]["is_published"] > 0) {
                $data[$i]["is_published"] = CoreTranslator::yes($lang);
            } else {
                $data[$i]["is_published"] = CoreTranslator::no($lang);
            }
        }

        $headers = array("id" => "ID",
            "title" => WbTranslator::Title($lang),
            "parent_menu" => WbTranslator::parent_menu($lang),
            "is_published" => WbTranslator::is_published($lang)
        );

        $table = new TableView();
        $table->setTitle(WbTranslator::ArticlesList($lang));
        $table->addLineEditButton("Wbarticleslistadmin/edit");
        $table->addDeleteButton("Wbarticleslistadmin/delete", "id", "title");
        $tableHtml = $table->view($data, $headers);

        $navBar = $this->navBar();
        $this->generateView(array('lang' => $lang, 'navBar' => $navBar, 'tableHtml' => $tableHtml));
    }

    public function edit() {

        // get user id
        $id_data = 0;
        if ($this->request->isParameterNotEmpty('actionid')) {
            $id_data = $this->request->getParameter("actionid");
        }

        // get belonging info
        $modelArticle = new WbArticle();
        $articles = $modelArticle->selectAll("id");

        $modelArticleList = new WbArticleList();
        $articleListInfo = $modelArticleList->select($id_data);
        $articleList = $modelArticleList->getArticles($id_data);

        $modelMenu = new WbSubMenu();
        $menus = $modelMenu->selectAllSubMenu();

        $lang = $this->getLanguage();

        // build the form
        // view
        $navBar = $this->navBar();
        $this->generateView(array(
            'navBar' => $navBar,
            'articles' => $articles,
            'articleListInfo' => $articleListInfo,
            'articleList' => $articleList,
            'menus' => $menus,
            'lang' => $lang
        ));
    }

    public function delete() {

        $id_data = 0;
        if ($this->request->isParameterNotEmpty('actionid')) {
            $id_data = $this->request->getParameter("actionid");
        }

        $model = new WbArticleList();
        $model->delete($id_data);

        $this->redirect("wbarticleslistadmin");
    }
    
    public function editquery(){
        
        $id = $this->request->getParameter("id");
        $title = $this->request->getParameter("title");
        $id_parent_menu = $this->request->getParameter("id_parent_menu");
        $is_published = $this->request->getParameter("is_published");
        $articles_ids = $this->request->getParameter("articles_ids");
        
        $model = new WbArticleList();
        $id_list = $model->set($id, $title, $id_parent_menu, $is_published);
        
        $model->removeLinks($id_list);
        foreach($articles_ids as $article){
            $model->addLink($id_list, $article);
        }
        
        $this->redirect("wbarticleslistadmin");
    }

}
