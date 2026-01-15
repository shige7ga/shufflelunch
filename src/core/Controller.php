<?php

class Controller
{
    protected $request;

    public function __construct($application)
    {
        $this->request = $application->getRequest();
    }
}
