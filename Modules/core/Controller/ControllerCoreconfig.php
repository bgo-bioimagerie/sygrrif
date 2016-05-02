<?php

require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/ModulesManager.php';
require_once 'Modules/core/Model/CoreInitDatabase.php';
require_once 'Modules/core/Model/CoreConfig.php';
require_once 'Modules/core/Model/BackupDatabase.php';

class ControllerCoreconfig extends ControllerSecureNav {

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * (non-PHPdoc)
     * Show the config index page
     * 
     * @see Controller::index()
     */
    public function index() {

        if ($_SESSION["user_status"] < 4) {
            echo "permission denied";
            return;
        }

        // get available sites for the connected user
        $modelSite = new CoreSite();
        if ($_SESSION["user_status"] > 4){
            $sites = $modelSite->getAll("name");
        }
        else{
            $sites = $modelSite->getUserAdminSites($_SESSION["id_user"]);
        }

        // nav bar
        $navBar = $this->navBar();

        // activated menus list
        $ModulesManagerModel = new ModulesManager();
        $status = $ModulesManagerModel->getDataMenusUserType("sites");
        $menus[0] = array("name" => "sites", "status" => $status);
        $status = $ModulesManagerModel->getDataMenusUserType("users/institutions");
        $menus[1] = array("name" => "users/institutions", "status" => $status);
        $status = $ModulesManagerModel->getDataMenusUserType("projects");
        $menus[2] = array("name" => "projects", "status" => $status);
        
        // user setting
        $modelCoreConfig = new CoreConfig();
        $activeUserSetting = $modelCoreConfig->getParam('user_desactivate');
        $coremenucolor = $modelCoreConfig->getParam("coremenucolor");
        $coremenucolortxt = $modelCoreConfig->getParam("coremenucolortxt");

        // admin email
        $admin_email = $modelCoreConfig->getParam("admin_email");

        // user list setting
        $userListSettings = $this->getUserListSettings($modelCoreConfig);

        // maintenance
        $is_maintenance = $modelCoreConfig->getParam("is_maintenance");
        $maintenance_message = $modelCoreConfig->getParam("maintenance_message");

        // install section
        $installquery = $this->request->getParameterNoException("installquery");
        if ($installquery == "yes") {
            try {
                $installModel = new CoreInitDatabase();
                $installModel->createDatabase();
            } catch (Exception $e) {
                $installError = $e->getMessage();
                $installSuccess = "<b>Success:</b> the database have been successfully installed";
                $this->generateView(array('navBar' => $navBar,
                    'installError' => $installError,
                    'menus' => $menus,
                    'activeUserSetting' => $activeUserSetting,
                    'admin_email' => $admin_email,
                    'coremenucolor' => $coremenucolor,
                    'coremenucolortxt' => $coremenucolortxt,
                    'userListSettings' => $userListSettings,
                    'is_maintenance' => $is_maintenance,
                    'maintenance_message' => $maintenance_message,
                    'sites' => $sites
                ));
                return;
            }
            $installSuccess = "<b>Success:</b> the database have been successfully installed";
            $this->generateView(array('navBar' => $navBar,
                'installSuccess' => $installSuccess,
                'menus' => $menus,
                'activeUserSetting' => $activeUserSetting,
                'admin_email' => $admin_email,
                'coremenucolor' => $coremenucolor,
                'coremenucolortxt' => $coremenucolortxt,
                'userListSettings' => $userListSettings,
                'is_maintenance' => $is_maintenance,
                'maintenance_message' => $maintenance_message,
                'sites' => $sites
            ));
            return;
        }

        // set menus section
        $setmenusquery = $this->request->getParameterNoException("setmenusquery");
        if ($setmenusquery == "yes") {
            $menusStatus = $this->request->getParameterNoException("menus");

            $ModulesManagerModel = new ModulesManager();
            $ModulesManagerModel->setDataMenu("sites", "coresites", $menusStatus[0], "glyphicon glyphicon-flag");
            $ModulesManagerModel->setDataMenu("users/institutions", "coreusers", $menusStatus[1], "glyphicon-user");
            $ModulesManagerModel->setDataMenu("projects", "projects", $menusStatus[2], "glyphicon-tasks");

            
            $status = $ModulesManagerModel->getDataMenusUserType("sites");
            $menus[0] = array("name" => "sites", "status" => $status);
            $status = $ModulesManagerModel->getDataMenusUserType("users/institutions");
            $menus[1] = array("name" => "users/institutions", "status" => $status);
            $status = $ModulesManagerModel->getDataMenusUserType("projects");
            $menus[2] = array("name" => "projects", "status" => $status);

            $this->generateView(array('navBar' => $navBar,
                'menus' => $menus,
                'activeUserSetting' => $activeUserSetting,
                'admin_email' => $admin_email,
                'coremenucolor' => $coremenucolor,
                'coremenucolortxt' => $coremenucolortxt,
                'userListSettings' => $userListSettings,
                'is_maintenance' => $is_maintenance,
                'maintenance_message' => $maintenance_message,
                'sites' => $sites
            ));
            return;
        }

        // active user
        $setactivuserquery = $this->request->getParameterNoException("setactivuserquery");
        if ($setactivuserquery == "yes") {
            $activeUserSetting = $this->request->getParameterNoException("disableuser");


            $modelCoreConfig->setParam("user_desactivate", $activeUserSetting);

            $this->generateView(array('navBar' => $navBar,
                'menus' => $menus,
                'activeUserSetting' => $activeUserSetting,
                'admin_email' => $admin_email,
                'coremenucolor' => $coremenucolor,
                'coremenucolortxt' => $coremenucolortxt,
                'userListSettings' => $userListSettings,
                'is_maintenance' => $is_maintenance,
                'maintenance_message' => $maintenance_message,
                'sites' => $sites
            ));
            return;
        }

        // email admin
        $setadminemailquery = $this->request->getParameterNoException("setadminemailquery");
        if ($setadminemailquery == "yes") {
            $admin_email = $this->request->getParameterNoException("email");
            $modelCoreConfig->setParam("admin_email", $admin_email);
        }

        // setuserlistoptionsquery
        $setuserlistoptionsquery = $this->request->getParameterNoException("setuserlistoptionsquery");
        if ($setuserlistoptionsquery == "yes") {

            $id_site = $this->request->getParameterNoException("id_site");
            $date_convention = $this->request->getParameterNoException("visible_date_convention");
            $date_created = $this->request->getParameterNoException("visible_date_created");
            $date_last_login = $this->request->getParameterNoException("visible_date_last_login");
            $date_end_contract = $this->request->getParameterNoException("visible_date_end_contract");
            $source = $this->request->getParameterNoException("visible_source");

            $modelCoreConfig->setParam("visible_date_convention", $date_convention, $id_site);
            $modelCoreConfig->setParam("visible_date_created", $date_created, $id_site);
            $modelCoreConfig->setParam("visible_date_last_login", $date_last_login, $id_site);
            $modelCoreConfig->setParam("visible_date_end_contract", $date_end_contract, $id_site);
            $modelCoreConfig->setParam("visible_source", $source, $id_site);

            // get the user settings list
            $userListSettings = $this->getUserListSettings($modelCoreConfig);
        }



        // backup
        $setactivebackupquery = $this->request->getParameterNoException("setactivebackupquery");
        if ($setactivebackupquery == "yes") {
            $modelBackup = new BackupDatabase();
            $modelBackup->run();
            return;
        }

        // menu color:
        $menucolorquery = $this->request->getParameterNoException("menucolorquery");
        if ($menucolorquery == "yes") {

            $id_site = $this->request->getParameterNoException("id_site");
            $coremenucolor = $this->request->getParameterNoException("coremenucolor");
            $coremenucolortxt = $this->request->getParameterNoException("coremenucolortxt");

            $modelCoreConfig->setParam("coremenucolor", $coremenucolor, $id_site);
            $modelCoreConfig->setParam("coremenucolortxt", $coremenucolortxt, $id_site);
            $coremenucolor = $modelCoreConfig->getParam("coremenucolor");
            $coremenucolortxt = $modelCoreConfig->getParam("coremenucolortxt");
        }

        $maintenancequery = $this->request->getParameterNoException("maintenancequery");
        if ($maintenancequery == "yes") {
            $is_maintenance = $this->request->getParameterNoException("is_maintenance");
            $maintenance_message = $this->request->getParameterNoException("maintenance_message");

            $modelCoreConfig->setParam("is_maintenance", $is_maintenance);
            $modelCoreConfig->setParam("maintenance_message", $maintenance_message);
            $is_maintenance = $modelCoreConfig->getParam("is_maintenance");
            $maintenance_message = $modelCoreConfig->getParam("maintenance_message");
        }

        // default
        $this->generateView(array('navBar' => $navBar,
            'menus' => $menus,
            'activeUserSetting' => $activeUserSetting,
            'admin_email' => $admin_email,
            'coremenucolor' => $coremenucolor,
            'coremenucolortxt' => $coremenucolortxt,
            'userListSettings' => $userListSettings,
            'is_maintenance' => $is_maintenance,
            'maintenance_message' => $maintenance_message,
            'sites' => $sites
        ));
    }

    private function getUserListSettings($modelCoreConfig) {

        $userListSettings["visible_date_convention"] = $modelCoreConfig->getParam("visible_date_convention");
        $userListSettings["visible_date_created"] = $modelCoreConfig->getParam("visible_date_created");
        $userListSettings["visible_date_last_login"] = $modelCoreConfig->getParam("visible_date_last_login");
        $userListSettings["visible_date_end_contract"] = $modelCoreConfig->getParam("visible_date_end_contract");
        $userListSettings["visible_source"] = $modelCoreConfig->getParam("visible_source");
        return $userListSettings;
    }

    /**
     * Upload the sygrrif export template file
     * @return string
     */
    public function uploadTemplate() {
        $target_dir = "data/";
        $target_file = $target_dir . "template.xls";
        $uploadOk = 1;
        $imageFileType = pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION);

        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 500000000) {
            return "Error: your file is too large.";
            $uploadOk = 0;
        }
        // Allow certain file formats
        if ($imageFileType != "xls") {
            return "Error: only xls files are allowed.";
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            return "Error: your file was not uploaded.";
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                return "The file template file" . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
            } else {
                return "Error, there was an error uploading your file.";
            }
        }
    }

}
