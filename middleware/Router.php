<?php

class Router
{
    private $routes = array(); // Corrected variable name from $router to $routes for consistency
    
    public function register($method, $path, $action)
    {
        $this->routes[strtoupper($method)][$path] = $action;
        return $this;
    }

    public function dispatch($method, $uri)
    {
        $basepath = dirname($_SERVER['SCRIPT_NAME']); // Remove the basepath from the URI
        if (substr($uri, 0, strlen($basepath)) == $basepath) {
            $uri = substr($uri, strlen($basepath));
        }

        $method = strtoupper($method);
        $found = false;

        if (isset($this->routes[$method])) {
            foreach ($this->routes[$method] as $route => $action) {
                $routePattern = preg_replace('/\{[^\}]+\}/', '([^/]+)', $route);
                if (preg_match('#^' . $routePattern . '$#', $uri, $matches)) {
                    array_shift($matches);
                    $params = [];
                    if (preg_match_all('/\{([^\}]+)\}/', $route, $paramNames)) {
                        foreach ($paramNames[1] as $index => $name) {
                            $params[$name] = $matches[$index];
                        }
                    }
                    $found = true;

                    // Call the action
                    $data = call_user_func($action, $params);
                    
                    error_log(print_r($data, true));
                    
                    header('Content-Type: application/json');
                    echo $data;
                    break;
                }
            }
        }

        if (!$found) {
            http_response_code(404);
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Resource not found.'
            ]);
        }
    }
}
?>