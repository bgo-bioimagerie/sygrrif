<?php

require_once 'Framework/Controller.php';

require_once 'Framework/Form.php';
require_once 'Framework/TableView.php';

require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/CoreConfig.php';
require_once 'Modules/core/Model/CoreTranslator.php';

require_once 'Modules/web/Model/WbTranslator.php';
require_once 'Modules/web/Model/WbSubMenu.php';

class ControllerWbsubmenus extends ControllerSecureNav {

    public function index() {

        $lang = $this->getLanguage();

        $model = new WbSubMenu();
        $data = $model->selectAllSubMenu();

        $table = new TableView();
        $table->setTitle(WbTranslator::Submenus($lang));
        $table->addLineEditButton("wbsubmenus/edit");
        $table->addDeleteButton("wbsubmenus/delete", "id", "title");
        $tableHtml = $table->view($data, array("id" => "ID", "title" => WbTranslator::Title($lang)));

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
        $model = new WbSubMenu();
        $data = array("id" => 0, "title" => "");
        if ($id_data > 0) {
            $data = $model->selectSubMenu($id_data);
        }

        $lang = $this->getLanguage();
        // form
        // build the form
        $form = new Form($this->request, "wbsubmenus/edit");
        $form->setTitle(WbTranslator::Edit_Sub_Menu($lang));
        $form->addHidden("id", $data["id"]);
        $form->addText("title", CoreTranslator::Name($lang), true, $data["title"]);

        $form->setValidationButton(CoreTranslator::Ok($lang), "wbsubmenus/edit");
        $form->setCancelButton(CoreTranslator::Cancel($lang), "wbsubmenus");


        if ($form->check()) {
            // run the database query
            $model->setSubMenu($form->getParameter("id"), $form->getParameter("title"));
            $this->redirect("wbsubmenus");
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

        $model = new WbSubMenu();
        $model->deleteSubMenu($id_data);

        $this->redirect("wbsubmenus");
    }

    public function items() {

        $lang = $this->getLanguage();

        $model = new WbSubMenu();
        $data = $model->selectAllItems();
        for ($i = 0; $i < count($data); $i++) {
            $menu = $model->selectSubMenu($data[$i]["id_menu"]);
            $data[$i]["menu"] = $menu["title"];
        }

        $table = new TableView();
        $table->setTitle(WbTranslator::Submenus($lang));
        $table->addLineEditButton("wbsubmenus/edit");
        $table->addDeleteButton("wbsubmenus/delete", "id", "title");
        $tableHtml = $table->view($data, array("id" => "ID", "title" => WbTranslator::Title($lang), "url" => WbTranslator::Url($lang), "menu" => WbTranslator::Submenus($lang), "display_order" => CoreTranslator::Display_order($lang)));

        $navBar = $this->navBar();
        $this->generateView(array('lang' => $lang, 'navBar' => $navBar, 'tableHtml' => $tableHtml));
    }

    public function edititem() {
        $navBar = $this->navBar();

        // get user id
        $id_data = 0;
        if ($this->request->isParameterNotEmpty('actionid')) {
            $id_data = $this->request->getParameter("actionid");
        }

        // get belonging info
        $model = new WbSubMenu();
        $data = array("id" => 0, "title" => "", "url" => "", "id_menu" => 0, "display_order" => 0);

        if ($id_data > 0) {
            $data = $model->selectItem($id_data);
        }

        $menus = $model->selectAllSubMenu();
        $menusNames = array();
        $menusId = array();
        foreach ($menus as $menu) {
            $menusNames[] = $menu["title"];
            $menusId[] = $menu["id"];
        }

        $lang = $this->getLanguage();
        // form
        // build the form
        $form = new Form($this->request, "wbsubmenus/edit");
        $form->setTitle(WbTranslator::Edit_Sub_Menu($lang));
        $form->addHidden("id", $data["id"]);
        $form->addText("title", CoreTranslator::title($lang), true, $data["title"]);
        $form->addText("url", WbTranslator::Url($lang), true, $data["url"]);
        $form->addSelect("id_menu", CoreTranslator::title($lang), $menusNames, $menusId, $data["id_menu"]);
        $form->addNumber("display_order", CoreTranslator::title($lang), true, $data["display_order"]);

        $form->setValidationButton(CoreTranslator::Ok($lang), "wbsubmenus/edititem");
        $form->setCancelButton(CoreTranslator::Cancel($lang), "wbsubmenus/items");


        if ($form->check()) {
            // run the database query
            $model->setItem($form->getParameter("id"), $form->getParameter("title"), $form->getParameter("url"), $form->getParameter("id_menu"), $form->getParameter("display_order")
            );
            $this->redirect("wbsubmenus/items");
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

}
