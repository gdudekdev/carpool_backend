<?php
namespace Core;

class Router
{
      private $routes = [];

      public function get($path, $callback)
      {
            $this->addRoute('GET', $path, $callback);
      }

      public function post($path, $callback)
      {
            $this->addRoute('POST', $path, $callback);
      }

      public function put($path, $callback)
      {
            $this->addRoute('PUT', $path, $callback);
      }

      public function delete($path, $callback)
      {
            $this->addRoute('DELETE', $path, $callback);
      }

      private function addRoute($method, $path, $callback)
      {
            $path = trim($path, '/'); // Normalisation
            $this->routes[] = compact('method', 'path', 'callback');
      }


      public function dispatch($requestMethod, $requestUri)
      {
            Logger::request($requestMethod, $requestUri, file_get_contents("php://input"));

            foreach ($this->routes as $route) {
                  $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([^/]+)', $route['path']);
                  if ($route['method'] === $requestMethod && preg_match("#^$pattern$#", $requestUri, $matches)) {
                        array_shift($matches);

                        if (is_array($route['callback'])) {
                              [$controller, $method] = $route['callback'];
                              $controllerInstance = new $controller();
                              return call_user_func_array([$controllerInstance, $method], $matches);
                        } else {
                              return call_user_func_array($route['callback'], $matches);
                        }
                  }
            }

            Logger::error("Route non trouvée: $requestMethod $requestUri");
            http_response_code(404);
            echo json_encode(["error" => "Route not found"]);
      }

}
