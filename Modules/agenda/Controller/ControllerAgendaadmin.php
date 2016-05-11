<?php

require_once 'Framework/Controller.php';
require_once 'Framework/Form.php';
require_once 'Framework/TableView.php';

require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/core/Model/CoreTranslator.php';

require_once 'Modules/agenda/Model/AgTranslator.php';
require_once 'Modules/agenda/Model/AgEventType.php';
require_once 'Modules/agenda/Model/AgEvent.php';

class ControllerAgendaadmin extends ControllerSecureNav {

    public function index() {
        
        $navBar = $this->navBar();
        $this->generateView(
                array('navBar' => $navBar)
                );
       
    }

    public function eventtypes(){
        
        $lang = $this->getLanguage();
        
        $modelEnventType = new AgEventType();
        $data = $modelEnventType->selectAll();
        $headers = array("id" => "ID", "name" => CoreTranslator::Name($lang), 
                         "color" => CoreTranslator::color($lang), 
                         "display_order" => CoreTranslator::Display_order($lang));
        
        $table = new TableView();
        $table->setTitle(AgTranslator::EventTypes($lang));
        $table->addLineEditButton("agendaadmin/editeventtype");
        $table->addDeleteButton("agendaadmin/deleteeventtype", "id", "name");
        $tableHtml = $table->view($data, $headers);
        
        $navBar = $this->navBar();
        $this->generateView(
                array('navBar' => $navBar, 'tableHtml' => $tableHtml)
                );
    }
    
    public function editeventtype(){
        
        $lang = $this->getLanguage();
        // get user id
	$id = 0;
	if ($this->request->isParameterNotEmpty ( 'actionid' )) {
            $id = $this->request->getParameter ( "actionid" );
	}
        
        $eventType = array("id" => 0, "name" => "", "color" => "ffffff", "display_order" => 0);
        $modelEnventType = new AgEventType();
        if ($id > 0){
            $eventType = $modelEnventType->select($id);
        }
        
        // build the form
        $myform = new Form($this->request, "editeventtypes");
        $myform->setTitle(AgTranslator::EditEventType($lang));
        $myform->addHidden("id", $id);
        $myform->addText("name", CoreTranslator::Name($lang), true, $eventType["name"]);
        $myform->addColor("color", CoreTranslator::color($lang), false, $eventType["color"]);
        $myform->addNumber("display_order", CoreTranslator::Display_order($lang), false, $eventType["display_order"]);
        
        $myform->setValidationButton(CoreTranslator::Ok($lang), "agendaadmin/editeventtype");

        if ($myform->check()) {
            // run the database query
           $modelEnventType->set($this->request->getParameter("id"), 
                   $this->request->getParameter("name"), 
                   $this->request->getParameter("color"), 
                   $this->request->getParameter("display_order"));
           
           $this->redirect("agendaadmin/eventtypes");
        } else {
            // set the view
            $formHtml = $myform->getHtml();
            // view
            $navBar = $this->navBar();
            $this->generateView(array(
                'navBar' => $navBar,
                'formHtml' => $formHtml
            ));
        }
    }
    
    public function events(){
        
        $lang = $this->getLanguage();
        
        $modelEnventType = new AgEvent();
        $modelEventType = new AgEventType();
        $data = $modelEnventType->selectAll();
        for($i = 0 ; $i < count($data) ; $i++){
            $tmp = $modelEventType->getName($data[$i]["id_type"]);
            $data[$i]["type"] = $tmp[0]; 
            
            $data[$i]["date_begin"] = date("Y-m-d H:i", $data[$i]["date_begin"]);
            $data[$i]["date_end"] = date("Y-m-d H:i", $data[$i]["date_end"]);
        }
        
        $headers = array("id" => "ID", "name" => CoreTranslator::Name($lang), 
                         "date_begin" => AgTranslator::Date_begin($lang),
                         "date_end" => AgTranslator::Date_end($lang),
                         "type" => AgTranslator::Type($lang),
            );
       
        $table = new TableView();
        $table->setTitle(AgTranslator::EventTypes($lang));
        $table->addLineEditButton("agendaadmin/editevent");
        $table->addDeleteButton("agendaadmin/deleteevent", "id", "name");
        $tableHtml = $table->view($data, $headers);
        
        $navBar = $this->navBar();
        $this->generateView(
                array('navBar' => $navBar, 'tableHtml' => $tableHtml)
                );
    }
    
    public function editevent(){
        
        $lang = $this->getLanguage();
        // get user id
	$id = 0;
	if ($this->request->isParameterNotEmpty ( 'actionid' )) {
            $id = $this->request->getParameter ( "actionid" );
	}
        
        $event = array("id" => 0, "name" => "", "content" => "",  "date_begin" => 0, "date_end" => 0, "image_url" => "", "id_type" => 0);
        $modelEnvent = new AgEvent();
        if ($id > 0){
            $event = $modelEnvent->select($id);
        }
       
        $modelEnventType = new AgEventType();
        $eventTypes = $modelEnventType->selectAll("name");
        $choices = array(); $choicesid = array();
        foreach($eventTypes as $etype){
            $choices[] = $etype["name"];
            $choicesid[] = $etype["id"];
        }
        
        //echo "date begin = " . $event["date_begin"] . "<br/>";
        $event["date_begin"] = date("Y-m-d", $event["date_begin"]);
        $event["date_end"] = date("Y-m-d", $event["date_end"]);
        
        // build the form
        $myform = new Form($this->request, "editeventtypes");
        $myform->setTitle(AgTranslator::EditEventType($lang));
        $myform->addHidden("id", $id);
        $myform->addText("name", CoreTranslator::Name($lang), true, $event["name"]);
        $myform->addDate("date_begin", AgTranslator::Date_begin($lang), true, $event["date_begin"]);
        $myform->addDate("date_end", AgTranslator::Date_end($lang), true, $event["date_end"]);
        $myform->addSelect("id_type", AgTranslator::EventType($lang), $choices, $choicesid, $event["id_type"]);
        $myform->addDownload("image_url", AgTranslator::Image_url($lang));
        $myform->addTextArea("content", AgTranslator::Content($lang), false, $event["content"]);
        
        $myform->setValidationButton(CoreTranslator::Ok($lang), "agendaadmin/editevent");

        if ($myform->check()) {
            // run the database query
            $date_begin = strtotime(CoreTranslator::dateToEn($this->request->getParameter("date_begin"), $lang));
            $date_end = strtotime(CoreTranslator::dateToEn($this->request->getParameter("date_end"), $lang));
            
            //echo "date_begin = " . print_r($date_begin) . "<br/>";
            //echo "date_end = " . $date_end . "<br/>";
            //return; 
            $id_event = $this->request->getParameter("id");
            $modelEnvent->set($id_event, 
                    $this->request->getParameter("name"), 
                    $this->request->getParameter("content"),
                    $date_begin, 
                    $date_end, 
                    $this->request->getParameter("id_type"));
            
            $target_dir = "data/agenda/";
            if ($_FILES["image_url"]["name"] != ""){
                Upload::uploadFile($target_dir, "image_url");
                $modelEnvent->setImage($id_event, $target_dir . $_FILES["image_url"]["name"]);
            }
            $this->redirect("agendaadmin/events");
        } else {
            // set the view
            $formHtml = $myform->getHtml($lang);
            // view
            $navBar = $this->navBar();
            $this->generateView(array(
                'navBar' => $navBar,
                'formHtml' => $formHtml
            ));
        }
    }
    
    public function deleteeventtype(){
        
        $id = 0;
	if ($this->request->isParameterNotEmpty ( 'actionid' )) {
            $id = $this->request->getParameter ( "actionid" );
	}
        
        $model = new AgEventType();
        $model->delete($id);
        
        $this->redirect("agendaadmin/eventtypes");
    }
    
    public function deleteevent(){
        
        $id = 0;
	if ($this->request->isParameterNotEmpty ( 'actionid' )) {
            $id = $this->request->getParameter ( "actionid" );
	}
        
        $model = new AgEvent();
        $model->delete($id);
        
        $this->redirect("agendaadmin/events");
    }
}
