<?php

require_once 'Framework/Request.php';
/**
 * Class allowing to generate and check a form html view. 
 * 
 * @author Sylvain Prigent
 */
class Form
{
	/** request */
	private $request;
	
	/** form info */
	private $title;
	private $id;
	
	private $parseRequest;
	private $errorMessage;
	
    /** form description */
    private $types;
    private $names;
    private $values;
    private $labels;
    private $isMandatory;
    private $choices;
    private $choicesid;
    private $validated;
    
    /** Validations/cancel/delete buttons */
    private $validationButtonName;
    private $validationURL;
    private $cancelButtonName;
    private $cancelURL;
    private $deleteButtonName;
    private $deleteURL;
    private $deleteID;
    
    
    /** form display (in bootstrap column number) */
    private $totalWidth;
    private $labelWidth;
    private $inputWidth;

    /** for download feild */
    private $useDownload;
    
    /**
     * Constructor
     * @param Request $request Request that contains the post data
     * @param unknown $id Form ID
     */
    public function __construct(Request $request, $id){
    	$this->request = $request;
    	$this->id = $id;
    	$this->labelWidth = 4;
    	$this->inputWidth = 6;
    	$this->title = "";
    	$this->validationURL = "";
    	$this->cancelURL = "";
    	$this->deleteURL = "";
    	
    	$this->parseRequest = false;
    	$formID = $request->getParameterNoException("formid");
    	if ($formID == $this->id){
    		$this->parseRequest = true;
    	}
    	
    	$this->useDownload = false;
    }
    
    /**
     * Set the form title
     * @param string $title Form title
     */
    public function setTitle($title){
    	$this->title = $title;
    }
    
    /**
     * Set a validation button to the title
     * @param string $name Button text
     * @param string $url URL of the form post query
     */
    public function setValidationButton($name, $url){
    	$this->validationButtonName = $name;
    	$this->validationURL = $url;
    }
    
    /**
     * Set a cancel button to the form
     * @param string $name Button text
     * @param string $url URL redirection
     */
    public function setCancelButton($name, $url){
    	$this->cancelButtonName = $name;
    	$this->cancelURL = $url;
    }
    
    /**
     * set a delete button to the form
     * @param string $name Button text
     * @param string $url URL of the query
     * @param string|number $dataID ID of the data to delete
     */
    public function setDeleteButton($name, $url, $dataID){
    	$this->deleteButtonName = $name;
    	$this->deleteURL = $url;
    	$this->deleteID = dataID;
    }
    
    /**
     * Internal method to set an input value either using the default value, or the request value
     * @param string $name Value name
     * @param string $value Default value
     */
    protected function setValue($name, $value){
    	if ($this->parseRequest){
    		$this->values[] = $this->request->getParameter($name);
    	}
    	else{
    		$this->values[] = $value;
    	}
    }
    
    /**
     * Add hidden input to the form
     * @param string $name Input name
     * @param string $label Input label 
     * @param string $value Input default value
     */
    public function addHidden($name, $value = ""){
    	$this->types[] = "hidden";
    	$this->names[] = $name;
    	$this->labels[] = "";
		$this->setValue($name, $value);
    	$this->isMandatory[] = false;
    	$this->choices[] = array();
    	$this->choicesid[] = array();
    	$this->validated[] = true;
    }
    
    public function addDownload($name, $label){
    	$this->types[] = "download";
    	$this->names[] = $name;
    	$this->labels[] = $label;
    	$this->isMandatory[] = false;
    	$this->choices[] = array();
    	$this->choicesid[] = array();
    	$this->validated[] = true;
    	$this->useDownload = true;
    }
    /**
     * Add text input to the form
     * @param string $name Input name
     * @param string $label Input label 
     * @param string $isMandatory True if mandatory input
     * @param string $value Input default value
     */
    public function addText($name, $label, $isMandatory = false, $value = ""){
    	$this->types[] = "text";
    	$this->names[] = $name;
    	$this->labels[] = $label;
    	$this->setValue($name, $value);
    	$this->isMandatory[] = $isMandatory;
    	$this->choices[] = array();
    	$this->choicesid[] = array();
    	$this->validated[] = true;
    }
    
    public function addDate($name, $label, $isMandatory = false, $value = ""){
    	$this->types[] = "date";
    	$this->names[] = $name;
    	$this->labels[] = $label;
    	$this->setValue($name, $value);
    	$this->isMandatory[] = $isMandatory;
    	$this->choices[] = array();
    	$this->choicesid[] = array();
    	$this->validated[] = true;
    }
    
    /**
     * Add color input to the form
     * @param string $name Input name
     * @param string $label Input label
     * @param string $isMandatory True if mandatory input
     * @param string $value Input default value
     */
    public function addColor($name, $label, $isMandatory = false, $value = ""){
    	$this->types[] = "color";
    	$this->names[] = $name;
    	$this->labels[] = $label;
    	$this->setValue($name, $value);
    	$this->isMandatory[] = $isMandatory;
    	$this->choices[] = array();
    	$this->choicesid[] = array();
    	$this->validated[] = true;
    }
    
    /**
     * Add email input to the form
     * @param string $name Input name
     * @param string $label Input label 
     * @param string $isMandatory True if mandatory input
     * @param string $value Input default value
     */
    public function addEmail($name, $label, $isMandatory = false, $value = ""){
    	$this->types[] = "email";
    	$this->names[] = $name;
    	$this->labels[] = $label;
    	$this->setValue($name, $value);
    	$this->isMandatory[] = $isMandatory;
    	$this->choices[] = array();
    	$this->choicesid[] = array();
    	$this->validated[] = true;
    }
    
    /**
     * Add number input to the form
     * @param string $name Input name
     * @param string $label Input label
     * @param string $isMandatory True if mandatory input
     * @param string $value Input default value
     */
    public function addNumber($name, $label, $isMandatory = false, $value = ""){
    	$this->types[] = "number";
    	$this->names[] = $name;
    	$this->labels[] = $label;
    	$this->setValue($name, $value);
    	$this->isMandatory[] = $isMandatory;
    	$this->choices[] = array();
    	$this->choicesid[] = array();
    	$this->validated[] = true;
    }
   	/**
   	 * Add select input to the form
     * @param string $name Input name
     * @param string $label Input label
   	 * @param unknown $choices List of options names
   	 * @param unknown $choicesid List of options ids
     * @param string $value Input default value
   	 */
    public function addSelect($name, $label, $choices, $choicesid, $value = ""){
    	$this->types[] = "select";
    	$this->names[] = $name;
    	$this->labels[] = $label;
    	$this->setValue($name, $value);
    	$this->isMandatory[] = false;
    	$this->choices[] = $choices;
    	$this->choicesid[] = $choicesid;
    	$this->validated[] = true;
    }
    
    /**
     * Add textarea input to the form
     * @param string $name Input name
     * @param string $label Input label
     * @param string $isMandatory True if mandatory input
     * @param string $value Input default value
     */
    public function addTextArea($name, $label, $isMandatory = false, $value = ""){
    	$this->types[] = "textarea";
    	$this->names[] = $name;
    	$this->labels[] = $label;
    	$this->setValue($name, $value);
    	$this->isMandatory[] = $isMandatory;
    	$this->choices[] = array();
    	$this->choicesid[] = array();
    	$this->validated[] = true;
    }
    
    /**
     * Generate the html code
     * @return string
     */
    public function getHtml(){
    	
    	$html = "";
 
    	// form title
    	$html .= "<div class=\"page-header\">";
    	$html .= 	"<h1>".$this->title."</h1>";
    	$html .= "</div>";
    	
    	if ($this->errorMessage != ""){
    		$html .= "<div class=\"alert alert-danger text-center\">";
    		$html .=     	"<p>".$this->errorMessage."</p>";
    		$html .= "</div>";
    	}
    	
    	// form header
    	if (!$this->useDownload){
    		$html .= "<form role=\"form\" class=\"form-horizontal\" action=\"".$this->validationURL."\" method=\"post\">";
    	}
    	else{
    		$html .= "<form role=\"form\" class=\"form-horizontal\" action=\"".$this->validationURL."\" method=\"post\" enctype=\"multipart/form-data\">";
    	}
    	
    	// form id
    	$html .= "<input class=\"form-control\" type=\"hidden\" name=\"formid\" value=\"".$this->id."\" />";
    	
    	
    	for( $i = 0 ; $i < count($this->types) ; $i++){
    		
    		$required = "";
    		if ($this->isMandatory[$i]){
    			$required = "required";
    		}
    		$validated = "";
    		if ($this->validated[$i] == false){
    			$validated = "alert alert-danger";
    		}
    		
    		if($this->types[$i] == "hidden"){
    			$html .= "<input class=\"form-control\" type=\"hidden\" name=\"".$this->names[$i]."\"";
    			$html .= "value=\"".$this->values[$i]."\"" . $required;
    			$html .= "/>";

    		}
    		if($this->types[$i] == "text"){
    			$html .= "<div class=\"form-group".$validated."\">";
    			$html .= "<label class=\"control-label col-xs-".$this->labelWidth."\">".$this->labels[$i]."</label>";
    			$html .=			"<div class=\"col-xs-".$this->inputWidth."\">";
    			$html .=				"<input class=\"form-control\" type=\"text\" name=\"".$this->names[$i]."\"";
    			$html .=				       "value=\"".$this->values[$i]."\"" . $required;  
    			$html .=				"/>";
    			$html .=			"</div>";
    			$html .= "</div>";
    		}
    		if($this->types[$i] == "date"){
    			$html .= "<div class=\"form-group".$validated."\">";
    			$html .= "<label class=\"control-label col-xs-".$this->labelWidth."\">".$this->labels[$i]."</label>";
    			$html .=			"<div class=\"col-xs-".$this->inputWidth."\">";
    			$html .=				"<input class=\"form-control\" type=\"date\" name=\"".$this->names[$i]."\"";
    			$html .=				       "value=\"".$this->values[$i]."\"" . $required;
    			$html .=				"/>";
    			$html .=			"</div>";
    			$html .= "</div>";
    		}
    		if($this->types[$i] == "color"){
    			$html .= "<div class=\"form-group".$validated."\">";
    			$html .= "<label class=\"control-label col-xs-".$this->labelWidth."\">".$this->labels[$i]."</label>";
    			$html .=			"<div class=\"col-xs-".$this->inputWidth."\">";
    			$html .=				"<input class=\"form-control\" type=\"color\" name=\"".$this->names[$i]."\"";
    			$html .=				       "value=\"".$this->values[$i]."\"" . $required;
    			$html .=				"/>";
    			$html .=			"</div>";
    			$html .= "</div>";
    		}
    		if($this->types[$i] == "email"){
    			$html .= "<div class=\"form-group ".$validated."\">";
    			$html .= "<label class=\"control-label col-xs-".$this->labelWidth."\">".$this->labels[$i]."</label>";
    			$html .=			"<div class=\"col-xs-".$this->inputWidth."\">";
    			$html .=				"<input class=\"form-control\" type=\"text\" name=\"".$this->names[$i]."\"";
    			$html .=				       "value=\"".$this->values[$i]."\"" . $required;
    			$html .=				"/>";
    			$html .=			"</div>";
    			$html .= "</div>";
    		}
    		if($this->types[$i] == "number"){
    			$html .= "<div class=\"form-group\">";
    			$html .= "<label class=\"control-label col-xs-".$this->labelWidth."\">".$this->labels[$i]."</label>";
    			$html .=			"<div class=\"col-xs-".$this->inputWidth."\">";
    			$html .=				"<input class=\"form-control\" type=\"number\" name=\"".$this->names[$i]."\"";
    			$html .=				       "value=\"".$this->values[$i]."\"" . $required;
    			$html .=				"/>";
    			$html .=			"</div>";
    			$html .= "</div>";
    		}
    		if($this->types[$i] == "textarea"){
    			$html .= "<div class=\"form-group\">";
    			$html .= "<label class=\"control-label col-xs-".$this->labelWidth."\">".$this->labels[$i]."</label>";
    			$html .= 	"<div class=\"col-xs-".$this->inputWidth."\">";    			 
    			$html .= 		"<textarea class=\"form-control\" name=\"".$this->names[$i]."\">".$this->values[$i]."</textarea>";
    			$html .=	"</div>";
    			$html .= "</div>";
    		}
    	    if($this->types[$i] == "download"){
    	    	$html .= "<div class=\"form-group\">";
    	    	$html .= "<label class=\"control-label col-xs-".$this->labelWidth."\">".$this->labels[$i]."</label>";
    	    	$html .= 	"<div class=\"col-xs-".$this->inputWidth."\">";
    	    	$html .= 		" <input type=\"file\" name=\"".$this->names[$i]."\" id=\"".$this->names[$i]."\"> ";
    	    	$html .=	"</div>";
    			$html .= "</div>";
	  		}
    		if($this->types[$i] == "select"){
    			$html .= "<div class=\"form-group\">";
    			$html .= "<label class=\"control-label col-xs-".$this->labelWidth."\">".$this->labels[$i]."</label>";
    			$html .= "	<div class=\"col-xs-".$this->inputWidth."\">";
    			$html .= "	<select class=\"form-control\" name=\"".$this->names[$i]."\">"; 
    							for ($v = 0 ; $v < count($this->choices[$i]) ; $v++){
    								$selected = "";
    							    if ($this->values[$i]==$this->choicesid[$i][$v]){
    							    		$selected = "selected=\"selected\"";
    							    }
    							    $html .= "<OPTION value=\"".$this->choicesid[$i][$v]."\"".$selected.">".$this->choices[$i][$v]."</OPTION>";
    							}
    			$html .= 	"</select>";
    			$html .=   "</div>";
    			$html .= "</div>";
    		}
    	}
    	
    	// buttons area
    	$html .= "<div class=\"col-xs-6 col-xs-offset-6\">";
    	if ($this->validationURL != ""){
    		$html .= "<input type=\"submit\" class=\"btn btn-primary\" value=\"".$this->validationButtonName."\" />";
    	}
    	if ($this->cancelURL != ""){
    		$html .= "<button type=\"button\" onclick=\"location.href='".$this->cancelURL."'\" class=\"btn btn-default\">".$this->cancelButtonName."</button>";
    	}
    	if ($this->deleteURL != ""){
    		$html .= "<button type=\"button\" onclick=\"location.href='".$this->deleteURL."/".$this->deleteID."'\" class=\"btn btn-danger\">".$this->deleteButtonName."</button>";
    	}
    	$html .= "</div>";
    	
    	return $html;
    }
    
    /**
     * Check if the form is valid
     * @return number
     */
    public function check(){
    	    	
    	$formID = $this->request->getParameterNoException("formid");
    	if ($formID ==  $this->id){
	    	for($i = 0 ; $i < count($this->types) ; $i++ ){
	    		if ($this->types[$i] == "email"){
	    			//echo "check email " . $this->request->getParameter($this->names[$i]) . " <br/>";
	    			
	    			if ( !preg_match( '#^[\w.-]+@[\w.-]+\.[a-z]{2,6}$#i', $this->request->getParameter($this->names[$i]) )) {
	    				$this->validated[$i] = false;
	    				$this->errorMessage = "The email address is not valid";
	    				return 0;
	    			}
	    		}
	    	}
	    	return 1;
    	}
    	return 0;
    }
    
    /**
     * Get input from query
     * @param unknown $name Input name
     * @return string Input value
     */
    public function getParameter($name){
    	return $this->request->getParameter($name);
    }
}
