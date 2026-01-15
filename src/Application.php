<?php

class Application
{
    private $router;
    private $request;
    public function __construct()
    {
        $this->router = new Router($this->registerRoutes());
        $this->request = new Request;
    }

    public function run()
    {
        $params = $this->router->resolve($this->request->getPathInfo());
        $controller = $params['controller'];
        $action = $params['action'];
        $this->runAction($controller, $action);
    }

    public function runAction($controllerName, $action)
    {
        $controllerClass = ucfirst($controllerName) . 'Controller';
        $controller = new $controllerClass($this);
        $controller->run($action);
    }

    private function registerRoutes()
    {
        return [
            '/' => ['controller' => 'shuffle', 'action' => 'index'],
        ];
    }

    public function getRequest()
    {
        return $this->request;
    }
}
