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

class ControllerWbarticles extends ControllerSecureNav {

    public function index() {

        $lang = $this->getLanguage();

        $model = new WbArticle();
        $modelMenu = new WbSubMenu();
        $data = $model->selectAll();
        for($i = 0 ; $i < count($data) ; $i++){
            $pmenu = $modelMenu->selectItem($data[$i]["id_parent_menu"]);
            $data[$i]["parent_menu"] = $pmenu["title"];
            $data[$i]["date_created"] = CoreTranslator::UnixDate($data[$i]["date_created"], $lang);
            $data[$i]["date_modified"] = CoreTranslator::UnixDate($data[$i]["date_modified"], $lang);
            if ($data[$i]["is_published"] > 0){
                $data[$i]["is_published"] = CoreTranslator::yes($lang);
            }
            else{
                $data[$i]["is_published"] = CoreTranslator::no($lang);
            }
        }
        
        $headers = array("id" => "ID",
            "title" => WbTranslator::Title($lang),
            "parent_menu" => WbTranslator::parent_menu($lang),
            "date_created" => WbTranslator::date_created($lang),
            "date_modified" => WbTranslator::date_modified($lang),
            "is_published" => WbTranslator::is_published($lang)
        );

        $table = new TableView();
        $table->setTitle(WbTranslator::Articles($lang));
        $table->addLineEditButton("wbarticles/edit");
        $table->addDeleteButton("wbarticles/delete", "id", "title");
        $tableHtml = $table->view($data, $headers);

        $navBar = $this->navBar();
        $this->generateView(array('lang' => $lang, 'navBar' => $navBar, 'tableHtml' => $tableHtml));
    }

    public function edit() {

        $navBar = $this->navBar();

        // get user id
        $id_data = 0;
        if ($this->request->isParameterNotEmpty('actionid')) {
            $id_data = $this->request->getParameter("actionid");
        }

        // get belonging info
        $model = new WbArticle();

        $data = array("id" => 0, "title" => "",
            "content" => "",
            "id_parent_menu" => "",
            "date_created" => "",
            "date_modified" => "",
            "is_published" => ""
        );
        if ($id_data > 0) {
            $data = $model->select($id_data);
        }
        
        

        $lang = $this->getLanguage();
        // form
        $modelMenus = New WbSubMenu();
        $menus = $modelMenus->selectAllSubMenu();
        $menusNames = array();
        $menusId = array();
        foreach($menus as $menu){
            $menusNames[] = $menu["title"];
            $menusId[] = $menu["id"];
        }
        // build the form
        $form = new Form($this->request, "wbarticles/edit");
        $form->setTitle(WbTranslator::Edit_Sub_Menu($lang));
        $form->addHidden("id", $data["id"]);
        $form->addText("title", CoreTranslator::Name($lang), true, $data["title"]);
        $form->addSelect("id_parent_menu", WbTranslator::parent_menu($lang), $menusNames, $menusId, $data["id_parent_menu"]);
        $form->addSelect("is_published", WbTranslator::is_published($lang), array(CoreTranslator::no($lang), CoreTranslator::yes($lang)), array(0, 1), $data["is_published"]);
        $form->addTextArea("content", WbTranslator::Content($lang), false, $data["content"]);

        $form->setValidationButton(CoreTranslator::Ok($lang), "wbarticles/edit");
        $form->setCancelButton(CoreTranslator::Cancel($lang), "wbarticles");

        if ($form->check()) {
            // run the database query
            $model->set($this->request->getParameter("id"), 
                    $this->request->getParameter("title"), 
                    $this->request->getParameter("content"), 
                    $this->request->getParameter("id_parent_menu"), 
                    $this->request->getParameter("is_published")); 
            
            $this->redirect("wbarticles");
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

    public function delete() {

        $id_data = 0;
        if ($this->request->isParameterNotEmpty('actionid')) {
            $id_data = $this->request->getParameter("actionid");
        }

        $model = new WbArticle();
        $model->delete($id_data);

        $this->redirect("wbarticles");
    }

}
