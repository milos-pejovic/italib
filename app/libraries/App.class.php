<?php

/**
 * This is the main router. It takes the url and extracts controller, method and 
 * parameters.
 * 
 * Currently both the user-eneterd controller and method have to exist, if not, 
 * defaults will be used (controller = 'home', method = 'index').
 * 
 * Commenting line '$this->controller = 'home';' in Setting the controller
 * will allow for the user-entered controller to be called even if the user-entered
 * method does not exist.
 * 
 * In order for user-entered parameters to be entered into the script, user has
 * to enter an existing controller and an existing method.
 */

class App {

    private $controller = 'home';
    private $controller_name = 'home';
    private $model_name = '';
    private $method = 'index';
    private $parameters = [];
    
/**
 * parseUrl - Takes the URL, checks if it is empty, sanytizes it and
 *            splits it into an array.
 * 
 * @return array - The URL in the form of array.
 */
    
    public function parseUrl() {
        $url = isset($_GET['url']) ? $_GET['url'] : '';
        
        if ($url === '') {
            return (array) $url;
        }
        
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $url = rtrim($url, '/');
        $url = explode('/', $url);
        return $url;
    }
    
/**
 * callEverything - Takes the controller, method and parameters and calls 
 *                  the page. It also instantiates the model using the name of
 *                  controller. (If such model exists).
 */
    
    public function callEverything() {
        if (gettype($this->controller) == 'string') {
            require_once CONTROLLERS . $this->controller . '.php';
            $this->controller = new $this->controller;
        }

        $this->model_name = $this->controller_name . '_model';
//        $this->model_file_name = $this->model_name . '.php';

        if (file_exists(MODELS . $this->model_name . '.php')) {
            require_once MODELS . $this->model_name . '.php';
            $this->controller->model = new $this->model_name;
        }
        
        call_user_func_array([$this->controller, $this->method], $this->parameters);
        return;
    }

/**
 * __construct - Main routing functionality.
 *               Calls parseUrl to get the url array. 
 *               Checks if the first url parameter corresponds to any existing controller.
 *                  If yes, requires it, instantiates an object from it and places
 *                  the reference to it into $this->controller.
 *                  If not, calls the page with default values.
 *               Checks if the second parameter corresponds to any method of the 
 *               controller.
 *                  If yes, changes the value of $this->method to that method.
 *                  If not, calls the page with default values.
 *               Checks if there are any values left in the url array. If yes they 
 *               become the parameters.
 *               If the page has not been called yet, it is called now. 
 */   
    
    public function __construct() {
        
        $url = $this->parseUrl();
        
    // Setting the controller

        if (file_exists(CONTROLLERS . $url[0] . '.php')) {
            $this->controller_name = $url[0];
            unset($url[0]);
        } else {
            $this->callEverything();
        }
        
        require_once CONTROLLERS . $this->controller_name . '.php';
        $this->controller = new $this->controller_name;
        
    // Seting the method
        
        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            } else {
                $this->controller = 'home';
                $this->callEverything();
            }
        }
        
    // Setting the parameters
        
        $this->parameters = $url ? array_values($url) : [];
        
    // Calling the page
        
        $this->callEverything($this->controller, $this->method, $this->parameters);
    }
}