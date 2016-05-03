<?php

require_once 'Modules/petshop/Model/PsSector.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/CoreUnit.php';
require_once 'Modules/petshop/Model/PsProject.php';
require_once 'Modules/petshop/Model/PsSupplier.php';
require_once 'Modules/petshop/Model/PsAnimal.php';
require_once 'Modules/petshop/Model/PsType.php';
require_once 'Modules/petshop/Model/PsProjectType.php';
require_once 'Modules/mailer/Model/MailerSend.php';
require_once 'Modules/petshop/Model/PsEntryReason.php';
require_once 'Modules/petshop/Model/PsExitReason.php';
require_once 'Modules/petshop/Model/PsTranslator.php';

class ControllerPsanimals extends ControllerSecureNav {

    public function index() {
        
    }

    public function edit($animalId = "", $message = "") {

        $navBar = $this->navBar();
        if ($this->request->isParameterNotEmpty('actionid')) {
            $animalId = $this->request->getParameter("actionid");
        }

        $modelSupplier = new PsSupplier();
        $suppliers = $modelSupplier->getAll();
        $modelAnimal = new PsAnimal();
        $animal = $modelAnimal->get($animalId);

        $modelSector = new PsSector();
        $sectors = $modelSector->getallsectors();

        $modelProjects = new PsProject();
        $projets = $modelProjects->getAllInfo();

        $modelUnits = new CoreUnit();
        $units = $modelUnits->getUnits("name");

        $modelUsers = new CoreUser();
        $users = $modelUsers->getActiveUsers("name");

        $modelEntryReason = new PsEntryReason();
        $entryReasons = $modelEntryReason->getAll("name");
        
        $modelExitReason = new PsExitReason();
        $exitReasons = $modelExitReason->getAll("name");

        $this->generateView(array('animal' => $animal, 'sectors' => $sectors, 'navBar' => $navBar,
            'suppliers' => $suppliers, 'projects' => $projets, "users" => $users,
            'units' => $units, "entryReasons" => $entryReasons, "exitReasons" => $exitReasons, "message" => $message
                ), "edit");
    }

    public function editquery() {

        // animal informations
        $id = $this->request->getParameter("id");
        $no_animal = $this->request->getParameter("no_animal");
        $id_projet = $this->request->getParameter("id_project");
        $date_entry = $this->request->getParameter("date_entry");
        $entry_reason = $this->request->getParameter("entry_reason");
        $lineage = $this->request->getParameter("lineage");
        $birth_date = $this->request->getParameter("birth_date");
        $father = $this->request->getParameter("father");
        $mother = $this->request->getParameter("mother");
        $sexe = $this->request->getParameter("sexe");
        $genotypage = $this->request->getParameter("genotypage");
        $supplier = $this->request->getParameter("supplier");
        $collaboration = $this->request->getParameter("collaboration");
        $num_bon = $this->request->getParameter("num_bon");
        $user1 = $this->request->getParameter("user1");
        $user2 = $this->request->getParameter("user2");
        $date_exit = $this->request->getParameter("date_exit");
        $exit_reason = $this->request->getParameter("exit_reason");
        $observation = $this->request->getParameter("observation");
        $warning = $this->request->getParameter("avertissement");

        // history	
        $sector = $this->request->getParameter("sector");
        $date_entry_sect = $this->request->getParameter("date_entry_sect");
        $date_exit_sect = $this->request->getParameter("date_exit_sect");
        $unit_hist = $this->request->getParameter("unit_hist");
        $no_room = $this->request->getParameter("no_room");

        // update the anima information
        $modelAnimal = new PsAnimal();
        $modelAnimal->update($id, $no_animal, $id_projet, $date_entry, $entry_reason, $lineage, $birth_date, $father, $mother, $sexe, $genotypage, $supplier, $collaboration, $num_bon, $user1, $user2, $date_exit, $exit_reason, $observation, $warning);

        // update the history
        $modelAnimal->updatehistory($id, $sector, $date_entry_sect, $date_exit_sect, $unit_hist, $no_room);

        $lang = $this->getLanguage();
        $this->edit($id, PsTranslator::AnimalModificationSaved($lang));
    }

}
