<?php

require_once 'Configuration.php';

/**
 * Class model the view.
 *
 * @author Sylvain Prigent
 */
class View
{
    /** Name of the file associted to the view */
    private $file;

    /** title of the view */
    private $title;

    /**
     * Constructor
     * 
     * @param string $action Action to which the view is associated
     * @param string $controller Controller to which the view is associated
     */
    public function __construct($action, $controller = "")
    {
        // Find the view file using the patern : View/<$controller>/<$action>.php
    	$modulesNames = Configuration::get("modules");
    	$count = count($modulesNames);
    	
    	$controllerFound = false;
    	for($i = 0; $i < $count; $i++) {
    		$file = 'Modules/' . $modulesNames[$i] . '/View/';
    		if ($controller != "") {
    			$file = $file . $controller . "/";
    		}
    		$file = $file . $action . '.php';
    		//echo 'Test view file = ' . $file . '--';
    		if (file_exists($file)){
    			$this->file = $file;
    			return;
    		}
    	}
 
    }

    /**
     * Generate and send the view
     * 
     * @param array $data data that fill the view
     */
    public function generate($data)
    {
        // Generate the dedicated part of the view
        $contenu = $this->generatefile($this->file, $data);
        // Need the URI patern controller/action/id
        $rootWeb = Configuration::get("rootWeb", "/");
        // generate the layout using the dedicated view content
        $view = $this->generatefile('Modules/layout.php',
                array('title' => $this->title, 'content' => $contenu, 'rootWeb' => $rootWeb));
        // Send the view
        echo $view;
    }

    /**
     * Generate a view file and return the it's content
     * 
     * @param string $file URL of the view file vue to generate
     * @param array $data Needed data to generate the view
     * @return string Generated view
     * @throws Exception If the view file is not found
     */
    private function generatefile($file, $data)
    {
        if (file_exists($file)) {
            // sent the $data table elements accessibles in the view
            extract($data);
            
            ob_start();
            
            require $file;
            
            return ob_get_clean();
        }
        else {
            throw new Exception("unable to find the file: '$file' ");
        }
    }

    /**
     * Clean values inseted into HTML page for security
     * 
     * @param string $value Value to clean
     * @return string Value cleaned
     */
    private function clean($value)
    {
        // Convert special char to HTML
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8', false);
    }

}
