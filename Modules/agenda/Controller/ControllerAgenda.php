<?php

require_once 'Framework/Controller.php';
require_once 'Framework/Form.php';

require_once 'Modules/core/Controller/ControllerOpen.php';

require_once 'Modules/agenda/Model/AgEvent.php';
require_once 'Modules/agenda/Model/AgEventType.php';

class ControllerAgenda extends ControllerOpen {
	
	public function __construct() {
            parent::__construct();
	}
	
	public function index() {
		
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
				"eventTypes" => $eventTypes
		));
	}
	
	public function events(){
	
		$eventid = "";
		if ($this->request->isParameterNotEmpty('actionid')){
			$eventid = $this->request->getParameter("actionid");
		}
	
		$events = array();
		$modelEntry = new AgEvent();
		if ($eventid == ""){
			$events = $modelEntry->getEventsdesc("id");
		}
		else{
			$events[] = $modelEntry->getEvent($eventid);
		}
	
		$allevents = $modelEntry->getEventsdesc("id");
	
		$this->generateView( array(
				"events" => $events,
				"allevents" => $allevents
		));
	}
	
	public function eventsbytype(){
		
		$eventtypeid = "";
		if ($this->request->isParameterNotEmpty('actionid')){
			$eventtypeid = $this->request->getParameter("actionid");
		}
		
		$events = array();
		$modelEntry = new EventEntry();
		
		$allevents = $modelEntry->getEventsByType($eventtypeid);
		
		$this->generateView( array(
				"events" => $allevents,
				"allevents" => $allevents
		), "events");
	}
}
