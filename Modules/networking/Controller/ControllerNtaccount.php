<?php

require_once 'Framework/Controller.php';
require_once 'Framework/Form.php';
require_once 'Framework/TableView.php';
require_once 'Framework/Upload.php';

require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/CoreTranslator.php';
require_once 'Modules/core/Model/CoreUser.php';
require_once 'Modules/core/Model/CoreUnit.php';
require_once 'Modules/core/Model/CoreStatus.php';

require_once 'Modules/networking/Model/NtTranslator.php';

class ControllerNtaccount extends ControllerSecureNav {

    public function index() {
        $navBar = $this->navBar();
        $lang = $this->getLanguage();
        
        // get user id
        $userId = 0;
        $userId = $this->request->getSession()->getAttribut("id_user");

        // get user info
        $userModel = new CoreUser();
        $user = $userModel->userAllInfo($userId);

        // Lists for the form
        // get status list
        $modelStatus = new CoreStatus();
        $status = $modelStatus->getStatusName($user['id_status']);

        // get units list
        $modelUnit = new CoreUnit();
        $unit = $modelUnit->getUnitName($user['id_unit']);


        // is responsoble user
        $respModel = new CoreResponsible();
        $user['is_responsible'] = $respModel->isResponsible($user['id']);

        // generate the view
        $this->generateView(array(
            'navBar' => $navBar, 'status' => $status['name'],
            'unit' => $unit,
            'user' => $user,
            'lang' => $lang
        ));
    }

}
