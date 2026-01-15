<?php

class ShuffleController extends Controller
{
    public function run($action)
    {
        $this->$action();
    }
    private function index()
    {
        echo 'Hello World';
    }
}
