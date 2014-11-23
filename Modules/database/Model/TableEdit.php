<?php

require_once 'Framework/Model.php';

/**
 * Give access to the tables created by the database module 
 * 
 * @author Sylvain Prigent
 */
class TableEdit extends Model {

	
	public function createTable($table_name, $entry_name, $entry_type, $entry_type_length){
		$sql = 'create table dbu_' . $table_name . '(';
		$sql = $sql . 'id integer primary key auto_increment,';
		
		for ($i = 0 ; $i < count($entry_name) ; $i++){
			$sql = $sql .  $entry_name[$i] . ' ' . $entry_type[$i] . '(' . $entry_type_length[$i] . ') not null';
			if ($i < count($entry_name)-1){
				$sql = $sql .  ',';
			}
		}
		$sql = $sql . ');';
		
		echo 'sql = ' .$sql. '--';
		
		try {
			return $this->runRequest($sql);
		}
		catch (Exception $e){
			return null;
		}
		
		return $result;
		
	}
	
	public function modifyTable($table_name, $entry_name, $entry_type, $entry_type_length){
		
		// 0- Get the table columns before edit
		$columns = tableColumnsFormated($table_name);
		
		// 1- A column name has been modified
		
		// 2- A column type has been modified
		
		// 3- A column has been added
	}
	
	public function addTableToList($tablename){
		$sql = 'insert into db_tables(name)'
				. ' values(?)';
		// rq: does not add the 'db_' here, it will be added when request this table
		$this->runRequest($sql, array($tablename));
	}
	
	public function tablesList(){
		$sql = 'select name from db_tables';
		$tablesNames = $this->runRequest($sql);
		return $tablesNames;
	}
	
	public function tableColumns($tablename){
		$sql = 'SHOW COLUMNS from dbu_' . $tablename;
		$tableColumns = $this->runRequest($sql);
		return $tableColumns;
	}
	
	public function tableColumnsFormated($tablename){
		
		$columns = $this->tableColumns($tablename);
		
		$entry_name = Array(); 
		$entry_type = Array(); 
		$entry_type_length = Array();
		if ($columns){
			$i = -1;
			foreach ( $columns as $tableColumn ) {
				$i++;
				// print_r($tableColumn);
				// extract column name
				$entry_name[$i] = $tableColumn ['Field'];
				
				// extract column type name
				$entry_type[$i] = '';
				if (strpos ( $tableColumn ['Type'], 'int' ) === false) {
				} else {
					$entry_type[$i] = 'INTEGER';
				}
				if (strpos ( $tableColumn ['Type'], 'varchar' ) === false) {
				} else {
					$entry_type[$i] = 'VARCHAR';
				}
				if (strpos ( $tableColumn ['Type'], 'date' ) === false) {
				} else {
					$entry_type[$i] = 'DATE';
				}
				
				// extract column type size
				$entry_type_length[$i] = 0;
				if (preg_match ( '!\(([^\)]+)\)!', $tableColumn ['Type'], $match )) {
					$entry_type_length[$i] = $match [1];
				}
			}		
		}
		$columnsData = Array('entry_name' => $entry_name, 'entry_type' => $entry_type,
				             'entry_type_length' => $entry_type_length
				);
		
		return $columnsData;
	}
	
	public function tableContent($tablename){
		$sql = 'select * from dbu_' . $tablename;
		$tableContent = $this->runRequest($sql);
		return $tableContent; 
	}
}