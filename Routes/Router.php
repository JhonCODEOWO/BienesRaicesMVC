<?php

namespace Routes;
use Routes\Request;

class Router {
    /** Stored routes by key METHOD with children PATH and CALLABLE | ARRAY values */
    private array $routes = [];
    
    /**
     *  Verify if a route exists inside routes before resolve it.
     *
     * @return void
     */
    public function checkRoutes() {
        $actualURL = $_SERVER['PATH_INFO'] ?? '/';
        $method = $_SERVER['REQUEST_METHOD'];

        $this->resolve($method, $actualURL);
    }
    
    /**
     *  store a new GET request
     *
     * @param  string $path The path to store
     * @param  callable | array $handler The callback to execute or an array with class controller name and handler function.
     * @return void
     */
    public function get(string $path, callable|array $handler){
        $this->addRoute('GET', $path, $handler);
    }

    /**
     *  store a new POST request
     *
     * @param  string $path The path to store
     * @param  callable | array $handler The callback to execute or an array with class controller name and handler function.
     * @return void
     */
    public function post(string $path, callable|array $handler){
        $this->addRoute('POST', $path, $handler);
    }

    // Main structural handler to store paths
    private function addRoute(string $method, string $path, callable|array $handler): void {
        // Normalize the route pattern and parse named variables if needed
        $this->routes[$method][$path] = $handler;
    }
    
    /**
     *  find the callable or array for a path inside routes property and execute it
     *
     * @param  string $method The method key to search in
     * @param  string $path The path children of $method key
     * @return void
     */
    private function resolve(string $method, string $path){
        $incomingReqSegments = explode('/', parse_url($path, PHP_URL_PATH));
        $methodRegisteredRoutes = $this->routes[$method]; //Get all routes by method
        $routeMatch = null;

        //Check if almost one of them matches with incoming path
        foreach ($methodRegisteredRoutes as $registeredRoute => $value) {
            $regSegments = explode('/', $registeredRoute);

            //If the incoming request path doesn't match with registered path segments skip it
            if(count($incomingReqSegments) != count($regSegments)) continue;

            $isMatch = true;

            //Check if the incoming path match
            foreach ($regSegments as $index => $urlSegment) {
                $totalChars = strlen($urlSegment);
                if($totalChars === 0) continue;
                
                $isParam = ($urlSegment[0] === '{' && $urlSegment[$totalChars - 1] === '}' && $totalChars > 0);
                if($isParam) continue;

                if($urlSegment != $incomingReqSegments[$index]) {
                    $isMatch = false;
                    break;
                };
            }

            if($isMatch) {
                $routeMatch = $registeredRoute;
                break;
            }
        }

        if(!isset($routeMatch)){
            http_response_code(404);
            echo "404 - The requested route doesn't exists";
            exit;
        }

        //Work with url params now...
        $urlParams = [];
        $handler = $this->routes[$method][$routeMatch];
        foreach (explode('/', $routeMatch) as $index => $value) {
            if(strlen($value) === 0) continue;
            if($value[0] === '{' && $value[strlen($value) - 1] === '}') {
                $urlParams[contentInsideBrackets($value)] = $incomingReqSegments[$index];
            };
            continue;
        }

        if(isset($handler)){
            $req = new Request([
                "urlParams" => $urlParams,
                "queryParams" => $_GET,
                "method" => $method,
                "body" => $_POST,
            ]);
            $this->execHandler($handler, $req);
        }
    }
    
    /**
     *  Execute the handler provided
     *
     * @param  callable | array $handler An array with (classname, fnName) or a callback.
     * @return void
     */
    private function execHandler(callable | array $handler, Request $req){
        //Check if its a callback and execute it
        if(is_callable($handler)) return call_user_func($handler, $req);

        //Check if its an array
        if(is_array($handler)){
            [$class, $fn] = $handler;
            if(class_exists($class)){
                $controller = new $class();
                if(method_exists($controller, $fn)){
                    return call_user_func([$controller, $fn], $req);
                }
            }
        }
    }
}