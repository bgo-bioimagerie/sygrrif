<?php

require_once 'Framework/Controller.php';
require_once 'Framework/Form.php';
require_once 'Framework/Upload.php';

require_once 'Modules/core/Controller/ControllerOpen.php';
require_once 'Modules/core/Model/CoreConfig.php';
require_once 'Modules/core/Model/CoreTranslator.php';

require_once 'Modules/web/Model/WbTeam.php';
require_once 'Modules/web/Model/WbTranslator.php';

class ControllerWbteam extends ControllerOpen {

    public function index(){
        
        $lang = $this->getLanguage();
        $model = new WbTeam();
        $content = $model->selectAll();
        
        // view
        $this->generateView(array(
            'lang' => $lang,
            'people' => $content
        ));
    }
}
