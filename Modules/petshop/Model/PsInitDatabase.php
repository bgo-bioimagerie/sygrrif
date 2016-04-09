<?php

require_once 'Framework/Model.php';
require_once 'Modules/core/Model/ModulesManager.php';
require_once 'Modules/petshop/Model/PsSupplier.php';
require_once 'Modules/petshop/Model/PsType.php';
require_once 'Modules/petshop/Model/PsProceedings.php';
require_once 'Modules/petshop/Model/PsSector.php';
require_once 'Modules/petshop/Model/PsExitReason.php';
require_once 'Modules/petshop/Model/PsProjectType.php';
require_once 'Modules/petshop/Model/PsProject.php';
require_once 'Modules/petshop/Model/PsEntryReason.php';
require_once 'Modules/petshop/Model/PsAnimal.php';
require_once 'Modules/petshop/Model/PsPricing.php';
require_once 'Modules/petshop/Model/PsInvoiceHistory.php';

/**
 * Class defining methods to install and initialize the core database
 *
 * @author Sylvain Prigent
 */
class PsInitDatabase extends Model {

    /**
     * Create the core database
     *
     * @return boolean True if the base is created successfully
     */
    public function createDatabase() {


        $modulesupplier = new PsSupplier();
        $modulesupplier->createTable();
        $modulesupplier->createDefault();

        $moduletype = new PsType();
        $moduletype->createTable();
        $moduletype->createDefault();

        $moduleProceedings = new PsProceedings();
        $moduleProceedings->createTable();
        $moduleProceedings->createDefault();

        $moduleSectors = new PsSector();
        $moduleSectors->createTable();

        $modelE = new PsExitReason();
        $modelE->createTable();
        $modelE->createDefault();

        $modelPT = new PsProjectType();
        $modelPT->createTable();
        $modelPT->createDefault();

        $modelP = new PsProject();
        $modelP->createTable();

        $modelER = new PsEntryReason();
        $modelER->createTable();
        $modelER->createDefault();

        $modelA = new PsAnimal();
        $modelA->createTable();
        
        $modelPricing = new PsPricing();
        $modelPricing->createTable();
        
        $modelIH = new PsInvoiceHistory();
        $modelIH->createTable();

        $message = 'success';
        return $message;
    }

}
