<?php

require_once 'Configuration.php';
require_once 'Request.php';
require_once 'View.php';

/**
 * Abstract class defining a controller. 
 * 
 * @author Sylvain Prigent
 */
abstract class Controller
{
    /** Action to run */
    private $action;


    /** recieved request */
    protected $request;

    /** 
     * Define the input request
     * 
     * @param Request $requete Recieved request
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Run the action.
     * Call the method with the same name than the action in the curent controller
     * 
     * @throws Exception If the action does not exist in the curent controller
     */
    public function runAction($action)
    {
        if (method_exists($this, $action)) {
            $this->action = $action;
            $this->{$this->action}();
        }
        else {
            $classController = get_class($this);
            throw new Exception("Action '$action' not defined in the class '$classController'");
        }
    }

    /**
     * Define the default actin
     */
    public abstract function index();

    /**
     * Generate the vue associated to the curent controller
     * 
     * @param array $dataView Data neededbu the view
     * @param string $action Action associated to the view
     */
    protected function generateView($dataView = array(), $action = null)
    {
        // Use the curent action by default
        $actionView = $this->action;
        if ($action != null) {
        	$actionView = $action;
        }
        $classController = get_class($this);
        $controllerView = str_replace("Controller", "", $classController);

        // Geneate the view
        $view = new View($actionView, $controllerView);
        $view->generate($dataView);
    }

    /**
     * Redirect to a controller and a specific action
     * 
     * @param string $controllor Controller
     * @param type $action Action Action
     */
    protected function redirect($controller, $action = null)
    {
        $rootWeb = Configuration::get("rootWeb", "/");
        // Redirect to the URL /root_site/controller/action
        header("Location:" . $rootWeb . $controller . "/" . $action);
    }

}
