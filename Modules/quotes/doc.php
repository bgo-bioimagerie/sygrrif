<?php
/// \file doc.cpp
/// \brief File that descibe the framework and how to create a module
///
/// \mainpage Platform-Manager Documentation
/// \author S. PRIGENT 
///
///
///
/// \section Framework 1- Framework
///
/// Platform-Manager is implemented using the MVC architecture. The Framework sources can be found in the directory "Framework". 
/// 
/// Each page address is based on the format: index.php?controller=xxx&action=yyy&id=zzz, and the rewrite engine of php display
/// the URL as xxx/yyy/zzz.
/// Basically, each time a URL is requested, it calls the rooter from index.php. The rooter parse the adresse, to find which controller 
/// and which action to call. For example, if the requested adress is template/index/1, the rooter will call the method ControllerTemplate::index().
/// The rooter will also store the action id in the Request class. Then the method ControllerTemplate::index() can get the action id, process some
/// database data using the model classes and will display a new page by calling a view. The view is called using the method "Controller::generateView()" 
///
/// The Controller::generateView() method generate an html page from the file named View/Controller/action.php. The view file has to be name exacly as the controller
/// name and action name for the rooter to be able to load it
///
/// The Framework provides 3 convenient classes: 
/// - Configuration: a class that allow to read and write data in the Platform-Manager configuration file
/// - Request: a class that merge all the data emitted in a html request ($_GET, $_POST, action id)
/// - Session: a class that allows to read and write session variables.
/// 
/// \section CreateModule 2- How to create a module
/// The easiest way to create a new module is to use the module "Template" which is provided in the Platform-Manager sources.
/// Basically, a module contains a configuration system, and a home page that is a entry point to the tool implemented in the module.
///
/// \subsection ConfigModule 2.1 The configuration systeme
/// The entry point of the module configuration systeme is the controller "ControllerTemplateConfig.php". It allows to create 
/// tables in the database and setup the tool in the Platform-Manager menu.
///
/// "ControllerTemplateConfig.php" has only one index page. This page contains 2 forms. One for the tables installation and one for the
/// menu configuration. 
///
/// When the "Install" button is clicked in the Templateconfig index page, the tables are created by calling the method "createDatabase" of
/// the model "TeInslall". The role of "TeInslall", is to call the "createTable" of all the models used by the module. In the template example,
/// TeInstall::createDatabase() call the  TeTable::createTable() which is the only one model available in the template exammple. If one need to
/// initialise the tables with default entries, the initialisation method of the model should be call inside the TeInstall::createDatabase() method
///
/// When the "save" button is clicked in the Templateconfig index page, the tool menu settings are updated by Templateconfig::index method 
///
/// \subsection HomePage 2.1 The home page
/// The entry point of the tools implemented in the module is the controller ControllerTemplate. In the template module, the method ControllerTemplate::index()
/// is implemented with an "hello word" view. One can implement its module starting from this controller using the MVC architecture


