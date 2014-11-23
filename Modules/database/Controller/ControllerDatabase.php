<?php
require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/database/Model/TableEdit.php';

class ControllerDatabase extends ControllerSecureNav {

	//private $billet;
	public function __construct() {
		//$this->billet = new Billet ();
	}

	// Affiche la liste de tous les billets du blog
	public function index() {

		$navBar = $this->navBar();

		$this->generateView ( array (
				'navBar' => $navBar
		) );
	}
	
	public function createtable(){
		
		$navBar = $this->navBar();
	
		$this->generateView ( array (
				'navBar' => $navBar
		) );
	
	}
	
	public function createtablequery(){
		echo 'createtablequery begin ';
		$table_name = $this->request->getParameter("table_name");
		$entry_name = $this->request->getParameter("entry_name");
		$entry_type = $this->request->getParameter("entry_type");
		$entry_type_length = $this->request->getParameter("entry_type_length");
		
		$tableEdit = new TableEdit;
		$result = $tableEdit->createTable($table_name, $entry_name, $entry_type, $entry_type_length);
		
		// add table table to the db tables list
		if ($result){
			$tableEdit->addTableToList($table_name);
		}
		
		echo 'createtablequery build the view ';
		$navBar = $this->navBar();
		
		$this->generateView ( array (
				'navBar' => $navBar, 'result' => $result
		) );
	}
	
	public function edittable(){
		
		// 0- get the navigation bar
		$navBar = $this->navBar();
	
		// 1- get the tables list
		$model = new TableEdit;
		$tableList = $model->tablesList();
	
		// 2- get the table content
		$tableColumns = null;
		$tablename = '';
		if ($this->request->isParameter('actionid')){
			$tablename = $this->request->getParameter("actionid");
			$tableColumns = null;
			if ($tablename != ''){
				$tableModel = new TableEdit();
				$tableColumns = $tableModel->tableColumnsFormated($tablename);
			}
		}
		
		$this->generateView ( array (
				'navBar' => $navBar, 'tablesNames' => $tableList, 
				'tableColumns' => $tableColumns, 'tablename' => $tablename
		) );
	
	}
	
	public function edittablequery(){
		echo 'edittablequery begin ';
		$table_name = $this->request->getParameter("table_name");
		$entry_name = $this->request->getParameter("entry_name");
		$entry_type = $this->request->getParameter("entry_type");
		$entry_type_length = $this->request->getParameter("entry_type_length");
		
		$tableEdit = new TableEdit;
		$result = $tableEdit->modifyTable($table_name, $entry_name, $entry_type, $entry_type_length);
		
		echo 'edittablequery build the view ';
		$navBar = $this->navBar();
		
		$this->generateView ( array (
				'navBar' => $navBar, 'result' => $result
		) );
	}
	
	public function edittablecontent(){
	
		// add here the code
	
	
		$navBar = $this->navBar();
	
		$this->generateView ( array (
				'navBar' => $navBar
		) );
	
	}
	
}