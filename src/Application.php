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
        try {
            $params = $this->router->resolve($this->request->getPathInfo());
            if(!$params) {
                throw new HttpNotFoundException();
            }
            $controller = $params['controller'];
            $action = $params['action'];
            $this->runAction($controller, $action);
        } catch (HttpNotFoundException) {
            $this->render404Page();
        }
        $this->response->send();
    }

    public function runAction($controllerName, $action)
    {
        $controllerClass = ucfirst($controllerName) . 'Controller';
        if(!class_exists($controllerClass)) {
            throw new HttpNotFoundException();
        }
        $controller = new $controllerClass($this);
        $content = $controller->run($action);
        $this->response->setContent($content);
    }

    private function registerRoutes()
    {
        return [
            '/' => ['controller' => 'shuffle', 'action' => 'index'],
            '/shuffle' => ['controller' => 'shuffle', 'action' => 'create'],
            '/employee' => ['controller' => 'employee', 'action' => 'index'],
            '/employee/create' => ['controller' => 'employee', 'action' => 'create'],
            '/employee/update' => ['controller' => 'employee', 'action' => 'update'],
            '/employee/updateAction' => ['controller' => 'employee', 'action' => 'updateAction'],
        ];
    }

    public function getRequest()
    {
        return $this->request;
    }

    public function getDbManager()
    {
        return $this->dbManager;
    }

    public function render404Page()
    {
        $this->response->setStatusContent(404, 'Not Found');
        $content = <<<EOT
        <!DOCTYPE html>
        <html lang="ja">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>404 page</title>
        </head>
        <body>
        <h1>404 Not Found</h1>
        </body>
        </html>
        EOT;
        $this->response->setContent($content);
    }
}
