<?php

class Router
{
    private $routes = array();  // Corrected variable name from $router to $routes for consistency

    public function register($method, $path, $action)
    {
        $this->routes[strtoupper($method)][$path] = $action;
    }

    public function dispatch($method, $uri)
    {
        $basepath = dirname($_SERVER['SCRIPT_NAME']);  // Remove the basepath from the URI
        if (substr($uri, 0, strlen($basepath)) == $basepath) {
            $uri = substr($uri, strlen($basepath));
        }

        $method = strtoupper($method);
        
        if (isset($this->routes[$method][$uri])) {
            $data = call_user_func($this->routes[$method][$uri]);  // Call the action associated with the route

            error_log(print_r($data, true));  // Debugging code

            header('Content-Type: application/json');  // Set the response 
            echo ($data);
        } else {
            http_response_code(404);
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Resource not found.'
            ]);
        }
    }
}


