<?php

require_once 'Framework/Model.php';
require_once 'Modules/core/Model/ModulesManager.php';
require_once 'Modules/agenda/Model/AgEvent.php';
require_once 'Modules/agenda/Model/AgEventType.php';

/**
 * Class defining methods to install and initialize the Suplies database
 *
 * @author Sylvain Prigent
 */
class AgInstall extends Model {

    /**
     * Create the core database
     *
     * @return boolean True if the base is created successfully
     */
    public function createDatabase() {

        $model1 = new AgEvent();
        $model1->createTable();

        $model2 = new AgEventType();
        $model2->createTable();

        $message = 'success';
        return $message;
    }

}
