<?php

class Application
{
    private $router;
    private $request;
    private $response;
    private $dbManager;

    public function __construct()
    {
        $this->router = new Router($this->registerRoutes());
        $this->request = new Request();
        $this->response = new Response();
        $this->dbManager = new DbManager();
    }

    public function run()
    {
        $params = $this->router->resolve($this->request->getPathInfo());
        $controller = $params['controller'];
        $action = $params['action'];
        $this->runAction($controller, $action);
        $this->response->send();
    }

    public function runAction($controllerName, $action)
    {
        $controllerClass = ucfirst($controllerName) . 'Controller';
        $controller = new $controllerClass($this);
        $content = $controller->run($action);
        $this->response->setContent($content);
    }

    private function registerRoutes()
    {
        return [
            '/' => ['controller' => 'shuffle', 'action' => 'index'],
            '/employee' => ['controller' => 'employee', 'action' => 'index'],
        ];
    }

    public function getRequest()
    {
        return $this->request;
    }
}
