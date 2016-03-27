<?php

require_once 'Framework/Model.php';

/**
 * Class defining the template table model. 
 *
 * @author Sylvain Prigent
 */
class BiRunInfo extends Model {

    private $content;
        
    public function __construct(){
    	$this->content = "";
    }

    public function addProcessInfo($name, $version){
        $this->content .= "<h1 style=\"font-size:26px; color:#333333;\">Process info</h1>";
        $this->content .= "<table class=\"table table-striped table-bordered\">";
        $this->content .= "<thead>";
        $this->content .= "<tr>";
        $this->content .= "<th>Info</th>";
        $this->content .= "<th>Value</th>";
        $this->content .= "</tr>";
        $this->content .= "</thead>";
        $this->content .= "<tbody>";
        $this->content .= "<tr>";
        $this->content .= "<td>name</td>";
        $this->content .= "<td>".$name."</td>";
        $this->content .= "</tr>";
        $this->content .= "<tr>";
        $this->content .= "<td>version</td>";
        $this->content .= "<td>".$version."</td>";
        $this->content .= "</tr>";
        $this->content .= "<tr>";
        $this->content .= "<td>Software</td>";
        $this->content .= "<td>macro Fiji</td>";
        $this->content .= "</tr>";
        $this->content .= "<tbody>";
        $this->content .= "</table>";
    }
    
    public function addParameters($keys, $values){
        $this->content .= "<h1 style=\"font-size:26px; color:#333333;\">Parameters info</h1>";
        $this->content .= "<table  class=\"table table-striped table-bordered\">";
        $this->content .= "<thead>";
        $this->content .= "<tr>";
        $this->content .= "<th>Key</th>";
        $this->content .= "<th>Value</th>";
        $this->content .= "</tr>";
        $this->content .= "</thead>";
        $this->content .= "<tbody>";
        for($i = 0 ; $i < count($keys) ; $i++){
            $this->content .= "<tr>";
            $this->content .= "<td>".$keys[$i]."</td>";
            $this->content .= "<td>".$values[$i]."</td>";
            $this->content .= "</tr>";
        }
        $this->content .= "<tbody>";
        $this->content .= "</table>";
    }
    
    public function save($fileUrl){
        file_put_contents($fileUrl, $this->content);
    }
                 
}