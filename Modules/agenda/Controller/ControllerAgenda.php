<?php

require_once 'Framework/Controller.php';
require_once 'Framework/Form.php';

require_once 'Modules/core/Controller/ControllerOpen.php';

require_once 'Modules/agenda/Model/AgEvent.php';
require_once 'Modules/agenda/Model/AgEventType.php';
require_once 'Modules/agenda/Model/AgTranslator.php';

require_once 'Modules/core/Model/CoreTranslator.php';



class ControllerAgenda extends ControllerOpen {
	
	public function __construct() {
            parent::__construct();
	}
	
	public function index() {
                $lang = $this->getLanguage();
            
		$action = "";
		if ($this->request->isParameterNotEmpty('actionid')){
			$action = $this->request->getParameter("actionid");
		}
		
		$month=date("n");
		$year=date("Y");
		
		
		if ($action!=""){
			$act = explode("_", $action);
			if ($act[0] == "p"){
				$month = $act[1]-1;
			}
			else{
				$month = $act[1]+1;
			}	
			$year = $act[2];
			
			if ($month < 1){
				$month = 12;
				$year = $year - 1;
			}
			if ($month > 12){
				$month = 1;
				$year = $year + 1;
			}
		}
		
		$modelEntry = new AgEvent();
		$events = $modelEntry->getEventsMonth($month, $year);
		$lastEvents = $modelEntry->getLastEvents();
		
		$modelEventTypes = new AgEventType();
		$eventTypes = $modelEventTypes->selectAll();
		
		$this->generateView( array(
				"month" => $month,
				"year" => $year,
				"events" => $events,
				"lastEvents" => $lastEvents,
				"eventTypes" => $eventTypes,
                                "lang" => $lang
		));
	}
	
	public function events(){
	
                $lang = $this->getLanguage();
                
		$eventid = "";
		if ($this->request->isParameterNotEmpty('actionid')){
			$eventid = $this->request->getParameter("actionid");
		}
	
		$events = array();
		$modelEntry = new AgEvent();
		if ($eventid == ""){
			$events = $modelEntry->getEventsdesc("date_end");
		}
		else{
			$events[] = $modelEntry->select($eventid);
		}
	
		$allevents = $modelEntry->getEventsdesc("date_end");
	
                $modelEventTypes = new AgEventType();
		$eventTypes = $modelEventTypes->selectAll();
                
		$this->generateView( array(
				"events" => $events,
				"allevents" => $allevents,
                                "eventTypes" => $eventTypes,
                                "lang" => $lang
		));
	}
	
	public function eventsbytype(){
		
                $lang = $this->getLanguage();
                
		$eventtypeid = "";
		if ($this->request->isParameterNotEmpty('actionid')){
			$eventtypeid = $this->request->getParameter("actionid");
		}
		
		$allevents = array();
		$modelEntry = new AgEvent();
		
		$allevents = $modelEntry->getEventsByType($eventtypeid);
		
                $modelEventTypes = new AgEventType();
		$eventTypes = $modelEventTypes->selectAll();
                
		$this->generateView( array(
				"events" => $allevents,
				"allevents" => $allevents,
                                "eventTypes" => $eventTypes,
                                "lang" => $lang
		), "events");
	}
}
