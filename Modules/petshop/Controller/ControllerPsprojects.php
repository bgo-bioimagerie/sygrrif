<?php

require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/CoreTranslator.php';
require_once 'Modules/core/Model/CoreUnit.php';
require_once 'Modules/petshop/Model/PsProject.php';
require_once 'Modules/petshop/Model/PsType.php';
require_once 'Modules/petshop/Model/PsTranslator.php';
require_once 'Modules/petshop/Model/PsProceedings.php';
require_once 'Modules/petshop/Model/PsProjectType.php';
require_once 'Modules/petshop/Model/PsSector.php';
require_once 'Modules/petshop/Model/PsEntryReason.php';
require_once 'Modules/petshop/Model/PsSupplier.php';
require_once 'Modules/petshop/Model/PsAnimal.php';

require_once 'Framework/TableView.php';
require_once 'Framework/Form.php';

class ControllerPsprojects extends ControllerSecureNav {

    /**
     * (non-PHPdoc)
     * Show the config index page
     *
     * @see Controller::index()
     */
    public function index($closed = false) {

        // get project type id
        $projectTypeId = 0;
        if ($this->request->isParameterNotEmpty('actionid')) {
            $projectTypeId = $this->request->getParameter("actionid");
        }
        
        $navBar = $this->navBar();
        $lang = $this->getLanguage();

        // get the data list
        $modelProject = new PsProject();
        /*
        if ($closed){
            echo "closed = true <br/>";
        }
        else{
            echo "closed = false <br/>";
        }
         */
        $projectList = $modelProject->getAllOpenedClosedInfo($projectTypeId, $closed);
        

        // shorten the project names
        for ($i = 0; $i < count($projectList); $i++) {
            $nomProj = $projectList[$i]['name'];
            if (strlen($nomProj) > 50) {
                $nomProj = substr($nomProj, 0, 50);
                $nomProj .= "...";
            }
            $projectList[$i]['name'] = $nomProj;
            $projectList[$i]['date_reel_lancement'] = CoreTranslator::dateFromEn($projectList[$i]['date_reel_lancement'], $lang);
        }

        //print_r($projectList);

        $table = new TableView();
        //$table->ignoreEntry("id", 1);
        $table->setTitle(PsTranslator::Projects($lang));
        $table->addLineEditButton("psprojects/info");
        $table->addDeleteButton("psprojects/delete");
        $table->addPrintButton("psprojects/index/");

        $headersArray = array(
            "date_reel_lancement" => PsTranslator::Date($lang),
            "unit_name" => CoreTranslator::Unit($lang),
            "name" => CoreTranslator::Name($lang),
            "animal_type" => PsTranslator::AnimalSpecies($lang),
            "no_projet" => PsTranslator::Number($lang)
        );
        $tableHtml = $table->view($projectList, $headersArray);

        if ($table->isPrint()) {
            echo $tableHtml;
            return;
        }

        $this->generateView(array(
            'navBar' => $navBar,
            'tableHtml' => $tableHtml
        ), "index");
    }
    
    public function closedProjects(){
        $this->index(true);
    }

    public function delete() {

        $id = $this->request->getParameter("actionid");

        $modelProject = new PsProject();
        $modelProject->delete($id);

        // generate view
        $this->redirect("psprojects");
    }

    public function info() {
        $navBar = $this->navBar();
        $lang = $this->getLanguage();

        // get user id
        $projectId = 0;
        if ($this->request->isParameterNotEmpty('actionid')) {
            $projectId = $this->request->getParameter("actionid");
        }

        // get belonging info
        $modelProject = new PsProject();
        if ($projectId > 0) {
            $project = $modelProject->get($projectId);
        } else {
            $project = $modelProject->getDefault();
        }

        // queries
        $modelUser = new CoreUser();
        $users = $modelUser->getActiveUsers("name");
        foreach ($users as $user) {
            $choiceUserID[] = $user["id"];
            $choiceUser[] = $user["name"] . " " . $user["firstname"];
        }

        $modelUnit = new CoreUnit();
        $units = $modelUnit->getUnits("name");
        foreach ($units as $unit) {
            $choiceUnitID[] = $unit["id"];
            $choiceUnit[] = $unit["name"];
        }

        $modelAnimalType = new PsType();
        $annimalsTypes = $modelAnimalType->getAll("name");
        foreach ($annimalsTypes as $annimalsType) {
            $choiceAnimalTypeID[] = $annimalsType["id"];
            $choiceAnimalType[] = $annimalsType["name"];
        }

        $modelProceeding = new PsProceedings();
        $proceedings = $modelProceeding->getAll("name");
        foreach ($proceedings as $proceeding) {
            $choiceProceedingID[] = $proceeding["id"];
            $choiceProceeding[] = $proceeding["name"];
        }

        $modelProjectType = new PsProjectType();
        $projTypes = $modelProjectType->getAll("name");
        foreach ($projTypes as $projType) {
            $choiceProjectTypeID[] = $projType["id"];
            $choiceProjectType[] = $projType["name"];
        }
        
        $modelResp = new CoreResponsible();
        $resps = $modelResp->responsibleSummaries("name");
        foreach ($resps as $resp) {
            $choiceRespID[] = $resp["id"];
            $choiceResp[] = $resp["name"] . " " . $resp["firstname"];
        }

        // form
        // build the form
        $form = new Form($this->request, "psprojects/info");
        $form->setTitle(PsTranslator::Edit_Project($lang));
        $form->addHidden("id", $project["id"]);
        $form->addText("name", CoreTranslator::Name($lang), false, $project["name"]);
        $form->addNumber("no_projet", PsTranslator::Number($lang), false, $project["no_projet"]);

        $form->addSelect("id_unit", CoreTranslator::Unit($lang), $choiceUnit, $choiceUnitID, $project["id_unit"]);
        $form->addSelect("id_responsible", CoreTranslator::Responsible($lang), $choiceResp, $choiceRespID, $project["id_responsible"]);
        
        $form->addSelect("user1", CoreTranslator::User($lang) . " 1", $choiceUser, $choiceUserID, $project["user1"]);
        $form->addSelect("user2", CoreTranslator::User($lang) . " 2", $choiceUser, $choiceUserID, $project["user2"]);

        $form->addDate("date_envoi", PsTranslator::kick_off($lang), false, CoreTranslator::dateFromEn($project["date_envoi"], $lang));
        $form->addDate("date_rencontre_commite", PsTranslator::CommiteeMeeting($lang), false, CoreTranslator::dateFromEn($project["date_rencontre_commite"], $lang));

        $form->addSelect("type_animal", PsTranslator::AnimalsType($lang), $choiceAnimalType, $choiceAnimalTypeID, $project["type_animal"]);
        $form->addText("souche_lignee", PsTranslator::Stem_lineage($lang), true, $project["souche_lignee"]);

        $form->addNumber("nbr_animaux", PsTranslator::AnimalsNumber($lang), false, $project["nbr_animaux"]);
        $form->addNumber("nbr_procedures", PsTranslator::Procedure($lang), false, $project["nbr_procedures"]);
        $form->addSelect("type_procedure", PsTranslator::ProcedureType($lang), $choiceProceeding, $choiceProceedingID, $project["type_procedure"]);
        $form->addSelect("chirurgie", PsTranslator::Surgery($lang), array(CoreTranslator::yes($lang), CoreTranslator::no($lang)), array(1, 2), $project["chirurgie"]);

        $form->addSelect("type_project", PsTranslator::ProjectType($lang), $choiceProjectType, $choiceProjectTypeID, $project["type_project"]);
        $form->addDate("date_reel_lancement", PsTranslator::Reallaunching($lang), false, CoreTranslator::dateFromEn($project["date_reel_lancement"], $lang));
        $form->addDate("date_closed", PsTranslator::DateClosed($lang), false, CoreTranslator::dateFromEn($project["date_closed"], $lang));    
        $form->setValidationButton(CoreTranslator::Save($lang), "psprojects/info/");

        if ($form->check()) {
            // run the database query
            $pid = $this->request->getParameter("id");

            $pidout = $modelProject->set(
                    $pid, $this->request->getParameter("name"), $this->request->getParameter("no_projet"), $this->request->getParameter("id_unit"), $this->request->getParameter("id_responsible"), $this->request->getParameter("user1"), $this->request->getParameter("user2"), CoreTranslator::dateToEn($this->request->getParameter("date_envoi"), $lang), CoreTranslator::dateToEn($this->request->getParameter("date_rencontre_commite"), $lang), $this->request->getParameter("type_animal"), $this->request->getParameter("souche_lignee"), $this->request->getParameter("nbr_animaux"), $this->request->getParameter("nbr_procedures"), $this->request->getParameter("type_procedure"), $this->request->getParameter("chirurgie"), $this->request->getParameter("type_project"), CoreTranslator::dateToEn($this->request->getParameter("date_reel_lancement"), $lang), CoreTranslator::dateToEn($this->request->getParameter("date_closed"), $lang)
            );

            //echo "redirect to " . $pid . "<br/>";
            //return;
            $this->redirect("psprojects/info/" . $pidout);
        } else {
            // set the view
            $formHtml = $form->getHtml($lang);
            $headerInfo = array("curentTab" => "info", "projectId" => $project["id"], "projectName" => $project["name"]);
            // view
            $navBar = $this->navBar();
            $this->generateView(array(
                'navBar' => $navBar,
                'formHtml' => $formHtml,
                'headerInfo' => $headerInfo
            ));
        }
    }

    public function animalsadd() {
        $navBar = $this->navBar();
        $lang = $this->getLanguage();

        // get user id
        $pid = 0;
        if ($this->request->isParameterNotEmpty('actionid')) {
            $pid = $this->request->getParameter("actionid");
        }
        if ($this->request->getParameterNoException("projet") != "") {
            $pid = $this->request->getParameterNoException("projet");
        }

        // queries
        $modelUser = new CoreUser();
        $users = $modelUser->getActiveUsers("name");
        foreach ($users as $user) {
            $choiceUserID[] = $user["id"];
            $choiceUser[] = $user["name"] . " " . $user["firstname"];
        }

        $modelUnit = new CoreUnit();
        $units = $modelUnit->getUnits("name");
        foreach ($units as $unit) {
            $choicesUnitid[] = $unit["id"];
            $choicesUnit[] = $unit["name"];
        }

        $modelSector = new PsSector();
        $sectors = $modelSector->getallsectors("name");
        foreach ($sectors as $sector) {
            $choicesSectorid[] = $sector["id"];
            $choicesSector[] = $sector["name"];
        }

        $modelProject = new PsProject();
        $projects = $modelProject->getAllInfo();
        foreach ($projects as $projectt) {
            $choicesProjectid[] = $projectt["id"];
            $choicesProject[] = $projectt["name"];
        }
        $project = $modelProject->get($pid);

        $modelAnimalType = new PsType();
        $annimalsTypes = $modelAnimalType->getAll("name");
        foreach ($annimalsTypes as $annimalsType) {
            $choicesPsTypeid[] = $annimalsType["id"];
            $choicesPsType[] = $annimalsType["name"];
        }

        $modelEntryReason = new PsEntryReason();
        $entryReasons = $modelEntryReason->getAll("name");
        foreach ($entryReasons as $entryReason) {
            $choicesEntryReasonid[] = $entryReason["id"];
            $choicesEntryReason[] = $entryReason["name"];
        }

        $modelSupplier = new PsSupplier();
        $supliers = $modelSupplier->getAll("name");
        foreach ($supliers as $suplier) {
            $choicesSupplierid[] = $suplier["id"];
            $choicesSupplier[] = $suplier["name"];
        }

        // form
        // build the form
        $form = new Form($this->request, "psprojects/animalsadd");
        $form->setTitle(PsTranslator::Add_Animals($lang));
        $form->addSelect("projet", PsTranslator::Project($lang), $choicesProject, $choicesProjectid, $pid);
        $form->addSelect("id_unit", CoreTranslator::Unit($lang), $choicesUnit, $choicesUnitid, $project["id_unit"]);
        $form->addNumber("nbr_animals", PsTranslator::AnimalsNumber($lang));
        $form->addNumber("no_animals", PsTranslator::NoAnimal($lang));
        $form->addSelect("id_sector", PsTranslator::Sector($lang), $choicesSector, $choicesSectorid);
        $form->addText("no_salle", PsTranslator::NoRoom($lang), false);
        $form->addSelect("type_animal", PsTranslator::AnimalsType($lang), $choicesPsType, $choicesPsTypeid);
        $form->addDate("date_entree", PsTranslator::DateEntry($lang), false);
        $form->addSelect("motif_entree", PsTranslator::EntryReason($lang), $choicesEntryReason, $choicesEntryReasonid);
        $form->addText("Lignee", PsTranslator::Lineage($lang), false);
        $form->addDate("date_naissance", PsTranslator::BirthDate($lang), false);
        $form->addText("pere", PsTranslator::Father($lang), false);
        $form->addText("mere", PsTranslator::Mother($lang), false);
        $form->addSelect("sexe", PsTranslator::Sexe($lang), array(PsTranslator::Male($lang), PsTranslator::female($lang)), array("M", "F"));
        $form->addText("genotypage", PsTranslator::Genotype($lang), false);
        $form->addSelect("fournisseur", PsTranslator::supplier($lang), $choicesSupplier, $choicesSupplierid);
        $form->addText("collaboration", PsTranslator::Collaboration($lang), false);
        $form->addText("num_bon", PsTranslator::Num_bon($lang), false);
        $form->addSelect("user1", CoreTranslator::User($lang) . " 1", $choiceUser, $choiceUserID, $project["user1"]);
        $form->addSelect("user2", CoreTranslator::User($lang) . " 2", $choiceUser, $choiceUserID, $project["user2"]);
        $form->addTextArea("observation", PsTranslator::Observation($lang), false);

        $form->setValidationButton(CoreTranslator::Save($lang), "psprojects/animalsadd/");

        if ($form->check()) {
            // run the database query
            $modelAnimal = new PsAnimal();
            $modelAnimal->add(
                    $this->request->getParameter("projet"), $this->request->getParameter("id_unit"), $this->request->getParameter("nbr_animals"), $this->request->getParameter("no_animals"), $this->request->getParameter("id_sector"), $this->request->getParameter("no_salle"), $this->request->getParameter("type_animal"), CoreTranslator::dateToEn($this->request->getParameter("date_entree"), $lang), $this->request->getParameter("motif_entree"), $this->request->getParameter("Lignee"), CoreTranslator::dateToEn($this->request->getParameter("date_naissance"), $lang), $this->request->getParameter("pere"), $this->request->getParameter("mere"), $this->request->getParameter("sexe"), $this->request->getParameter("genotypage"), $this->request->getParameter("fournisseur"), $this->request->getParameter("collaboration"), $this->request->getParameter("num_bon"), $this->request->getParameter("user1"), $this->request->getParameter("user2"), $this->request->getParameter("observation")
            );

            //echo "redirect to " . $pid . "<br/>";
            //return;
            $this->redirect("psprojects/animalsin/" . $pid);
        } else {
            // set the view
            $formHtml = $form->getHtml($lang);
            $proj = $modelProject->get($pid);
            $headerInfo = array("curentTab" => "animaladd", "projectId" => $pid, "projectName" => $proj["name"]);
            // view
            $navBar = $this->navBar();
            $this->generateView(array(
                'navBar' => $navBar,
                'formHtml' => $formHtml,
                'headerInfo' => $headerInfo
            ));
        }
    }

    public function animalsin() {
        $navBar = $this->navBar();
        $lang = $this->getLanguage();

        // get user id
        $id_project = 0;
        if ($this->request->isParameterNotEmpty('actionid')) {
            $id_project = $this->request->getParameter("actionid");
        }

        $modelProject = new PsProject();
        $proj = $modelProject->get($id_project);
        $headerInfo = array("curentTab" => "animalsin", "projectId" => $id_project, "projectName" => $proj["name"]);

        $modelAnimals = new PsAnimal();
        $animals = $modelAnimals->getProjectAnimals($id_project, false);

        $this->generateView(array("animals" => $animals, "headerInfo" => $headerInfo, "navBar" => $navBar,
            "lang" => $lang, "id_project" => $id_project
        ));
    }

    public function exitanimals() {

        // get the post variables
        $id_project = $this->request->getParameter("id_project");

        $modelAnimal = new PsAnimal();
        $projectAnimals = $modelAnimal->getProjectAnimalsID($id_project, "0000-00-00");
        $exitArray = array();
        foreach ($projectAnimals as $an) {
            $name = "chk_" . $an["id"];
            if ($this->request->isParameterNotEmpty($name)) {
                $exitArray[] = $an["id"];
            }
        }

        // create the form
        $lang = $this->getLanguage();
        $_SESSION["exitArray"] = $exitArray;
        $form = new Form($this->request, "psprojects/animalsexit");
        $form->setTitle(PsTranslator::ExitAnimal($lang));
        $form->addHidden("id_project", $id_project);
        $form->addDate("exit_date", PsTranslator::ExitDate($lang), true, date("Y-m-d"));
        $form->addText("exit_reason", PsTranslator::ExitReason($lang), false);


        $form->setValidationButton(CoreTranslator::Save($lang), "psprojects/exitanimalsquery/");
        $form->setCancelButton(CoreTranslator::Cancel($lang), "psprojects/animalsin/");

        // set the view
        $formHtml = $form->getHtml($lang);
        $modelProject = new PsProject();
        $proj = $modelProject->get($id_project);
        $headerInfo = array("curentTab" => "animalsin", "projectId" => $id_project, "projectName" => $proj["name"]);
        // view
        $navBar = $this->navBar();
        $this->generateView(array(
            'navBar' => $navBar,
            'formHtml' => $formHtml,
            'headerInfo' => $headerInfo
        ));
    }

    public function exitanimalsquery() {
        $lang = $this->getLanguage();
        $modelAnimal = new PsAnimal();

        $animaslIds = $_SESSION["exitArray"];

        foreach ($animaslIds as $ids) {
            $modelAnimal->exitAnimal(
                    $ids, CoreTranslator::dateToEn($this->request->getParameter("exit_date"), $lang), $this->request->getParameter("exit_reason"));
        }

        // redirect to animals 
        $id_project = $this->request->getParameter("id_project");
        $this->redirect("psprojects/animalsin/" . $id_project);
    }

    public function animalsout() {

        $navBar = $this->navBar();
        $lang = $this->getLanguage();

        // get user id
        $id_project = 0;
        if ($this->request->isParameterNotEmpty('actionid')) {
            $id_project = $this->request->getParameter("actionid");
        }

        $modelAnimals = new PsAnimal();
        $animals = $modelAnimals->getProjectAnimals($id_project, true);

        for ($i = 0; $i < count($animals); $i++) {
            $animals[$i]["unitName"] = $animals[$i]["hist"][0]["unitName"];
            $animals[$i]["sectorName"] = $animals[$i]["hist"][0]["sectorName"];
            $animals[$i]["no_room"] = $animals[$i]["hist"][0]["no_room"];
        }

        $table = new TableView();
        $table->setTitle("");
        $table->addLineEditButton("psanimals/edit");
        $table->addDeleteButton("psprojects/deleteanimalout", "id", "no_animal");

        $headersArray = array(
            "no_animal" => PsTranslator::NoAnimal($lang),
            "birth_date" => PsTranslator::BirthDate($lang),
            "date_entry" => PsTranslator::DateEntry($lang),
            "date_exit" => PsTranslator::ExitDate($lang),
            "exit_reason" => PsTranslator::ExitReason($lang),
            "lineage" => PsTranslator::Lineage($lang),
            "sexe" => PsTranslator::Sexe($lang),
            "userName" => CoreTranslator::User($lang),
            "unitName" => CoreTranslator::Unit($lang),
            "sectorName" => PsTranslator::Sector($lang),
            "no_room" => PsTranslator::NoRoom($lang),
            "name" => PsTranslator::Project($lang),
            "observation" => PsTranslator::Observation($lang)
        );
        $tableHtml = $table->view($animals, $headersArray);

        $modelProject = new PsProject();
        $proj = $modelProject->get($id_project);
        $headerInfo = array("curentTab" => "animalsout", "projectId" => $id_project, "projectName" => $proj["name"]);

        $this->generateView(array(
            'navBar' => $navBar,
            'tableHtml' => $tableHtml,
            'headerInfo' => $headerInfo
        ));
    }

    public function deleteanimalin(){
        
        $id = 0;
        if ($this->request->isParameterNotEmpty('actionid')) {
            $id = $this->request->getParameter("actionid");
        }
        
        $modelAnimal = new PsAnimal();
        $modelAnimal->delete($id);
        
        $this->redirect("psprojects/animalsin/".$_SESSION["id_anproj"]);
        
    }
    
    public function deleteanimalout(){
        
        $id = 0;
        if ($this->request->isParameterNotEmpty('actionid')) {
            $id = $this->request->getParameter("actionid");
        }
        
        $modelAnimal = new PsAnimal();
        $modelAnimal->delete($id);
        
        $this->redirect("psprojects/animalsout/".$_SESSION["id_anproj"]);
        
    }
    
}
