<?php

require_once 'Configuration.php';

/**
 * Abstract class Model
 * A model define an access to the database
 *
 * @author Sylvain Prigent
 */
abstract class ModelAuto extends Model
{
    /** PDO object of the database 
     */
    protected $tableName;
    private $columnsNames;
    private $columnsTypes;
    private $columnsDefaultValue;
    protected $primaryKey;

    public function createTable(){
        
        // create database if not exists
        $sql = "CREATE TABLE IF NOT EXISTS `".$this->tableName."` (";
        for($i = 0 ; $i < count($this->columnsNames) ; $i++){
            $sql .= "`".$this->columnsNames[$i]."` ".$this->columnsTypes[$i]." NOT NULL ";
            if ($this->columnsDefaultValue[$i] != ""){
                $sql .= "DEFAULT ". $this->columnsDefaultValue[$i] . " " ;
            }
            if ($this->columnsNames[$i] == $this->primaryKey){
                $sql .= " AUTO_INCREMENT ";
            }
            
            if ($i != count($this->columnsNames)-1){
                $sql .= ", ";
            }
        }
        if ($this->primaryKey != ""){
            $sql .= ", PRIMARY KEY (`".$this->primaryKey."`)";
        }
        $sql .= ");";
        
        //echo "request = " . $sql . "<br/>";
        //return
        $this->runRequest($sql);
        
        // add columns if added later
        for($i = 0 ; $i < count($this->columnsNames) ; $i++){
            $this->addColumn($this->tableName, $this->columnsNames[$i], $this->columnsTypes[$i], $this->columnsDefaultValue[$i]);
        }
    }
    
    public function setColumnsInfo($name, $type, $value){
        $this->columnsNames[] = $name;
        $this->columnsTypes[] = $type;
        $this->columnsDefaultValue[] = $value;
    }
    
    public function insert($data){
        $sql = "INSERT INTO " . $this->tableName ;
        $keyString = "";
        $valuesString = "";
        foreach ($data as $key => $value) {
            //echo "key = " . $key . "<br/>";
            //echo "value = " . $value . "<br/>";
            $keyString .= $key . ",";
            $valuesString .= "'" . $value . "'" . ",";
        }
        $sql .= " (" . substr($keyString, 0, -1) . ") VALUES (" . substr($valuesString, 0, -1) . ");";
        
        //echo "query = " . $sql . "<br/>";
        $this->runRequest($sql);
        $this->getDatabase()->lastInsertId();
    }
    
    public function update($conditions, $data){
        $sql = "UPDATE ".$this->tableName." SET ";
        $condStr = "";
        foreach($conditions as $k => $v){
            $condStr .= $k . "=" . $v . " AND";
        }
        $dataStr = "";
        foreach($data as $k => $v){
            $dataStr .= $k . "=\"" . $v . "\",";
        }
        $sql .= substr($dataStr, 0, -1) . " WHERE " . substr($condStr, 0, -3);
        $this->runRequest($sql);
        
    }
    
    public function selectAll($sortEntry = ""){
        $sql = "SELECT * FROM " . $this->tableName;
        if($sortEntry != ""){
           $sql .=  " ORDER BY ".$sortEntry." ASC;";
        }
        return $this->runRequest($sql)->fetchAll();
    }
    
    public function select($conditions, $columnsToSelect = array()){
        $sql = "SELECT ";
        if (count($columnsToSelect) < 1){
            $sql .= " * ";
        }
        else{
            $cols = "";
            foreach($columnsToSelect as $c){
                $cols .= $c . ",";
            }
            $sql .= substr($c, 0, -1);
        }
        $sql .= " FROM " . $this->tableName . "WHERE ";
        $conds = "";
        foreach($conditions as $key => $value){
            $conds .=  " " . $key . "=" . $value . " AND";
        }
        $sql .= substr($conds, 0, -3);
        return $this->runRequest($sql);
    }
    
    public function isEntry($key, $value){
        $sql = "SELECT ".$key." FROM ".$this->tableName." WHERE ".$key."=".$value;
            $req = $this->runRequest($sql);
            if ($req->rowCount() == 1){
                return true;
            }
            return false;
    }
    
    public function deleteAll(){
        $sql = "DELETE FROM " . $this->tableName;
        $this->runRequest($sql);
    }
}
