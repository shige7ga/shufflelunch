<?php

class EmployeeController extends Controller
{
    public function index()
    {
        return $this->render([
            'pageTitle' => '社員登録',
            'formTitle' => '登録フォーム',
            'formButton' => '登録する',
        ]);
    }
}
