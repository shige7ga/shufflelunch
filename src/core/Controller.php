<?php

class Controller
{
    protected $request;
    protected $actionName;
    protected $dbManager;

    public function __construct($application)
    {
        $this->request = $application->getRequest();
        $this->dbManager = $application->getDbManager();
    }

    public function run($action)
    {
        $this->actionName = $action;
        if(!method_exists($this, $action)) {
            throw new HttpNotFoundException();
        }
        return $this->$action();
    }

    public function render($variables, $template = null, $layout = 'layout')
    {
        $view = new View(__DIR__ . '/../views');
        if (is_null($template)) {
            $template = $this->actionName;
        }
        $controllerName = strtolower(substr(get_class($this), 0, -10));
        $path = $controllerName . '/' . $template;
        return $view->render($path, $variables, $layout);
    }
}
