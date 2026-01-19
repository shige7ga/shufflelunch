<?php

class EmployeeController extends Controller
{
    private $inputEmpInfo;
    private $model;
    public function __construct($application)
    {
        parent::__construct($application);
        $this->model = $this->dbManager->getModel('Employee');
        $this->inputEmpInfo = $this->initializeInputEmpInfo();
    }

    public function index()
    {
        if (!$this->request->isPost()) {
            throw new HttpNotFoundException;
        }
        $employees = $this->model->fetchEmployees();
        $valiables = $this->getVariables(
            '社員登録',
            '登録フォーム',
            '/employee/create',
            'create',
            $this->inputEmpInfo,
            '登録する',
            $employees,
            []);
        return $this->render($valiables);
    }

    public function create()
    {
        if (!$this->request->isPost()) {
            throw new HttpNotFoundException;
        }
        $empNo = $_POST['empNo'];
        $empName = $_POST['empName'];
        $this->setInputEmpInfo($empNo, $empName);

        $errors = [];
        $errors = $this->model->validate($empNo, $empName, __FUNCTION__);
        if (empty($errors)) {
            $this->model->registerEmployee($empNo, $empName);
            $this->inputEmpInfo = $this->initializeInputEmpInfo();
        }
        $employees = $this->model->fetchEmployees();
        $valiables = $this->getVariables(
            '社員登録',
            '登録フォーム',
            '/employee/create',
            'create',
            $this->inputEmpInfo,
            '登録する',
            $employees,
            $errors);
        return $this->render($valiables, 'index');
    }

    public function updateIndex()
    {
        if (!$this->request->isPost()) {
            throw new HttpNotFoundException;
        }
        $employees = $this->model->fetchEmployees();
        $valiables = $this->getVariables(
            '社員情報更新',
            '更新フォーム',
            '/employee/update',
            'update',
            $this->inputEmpInfo,
            '更新する',
            $employees,
            []);
        return $this->render($valiables, 'index');
    }

    public function update()
    {
        if (!$this->request->isPost()) {
            throw new HttpNotFoundException;
        }
        $empNo = $_POST['empNo'];
        $empName = $_POST['empName'];
        $this->setInputEmpInfo($empNo, $empName);

        $errors = [];
        $errors = $this->model->validate($empNo, $empName, __FUNCTION__);
        if (empty($errors)) {
            $this->model->updateEmployee($empNo, $empName);
            $this->inputEmpInfo = $this->initializeInputEmpInfo();
        }
        $employees = $this->model->fetchEmployees();
        $valiables = $this->getVariables(
            '社員情報更新',
            '更新フォーム',
            '/employee/update',
            'update',
            $this->inputEmpInfo,
            '更新する',
            $employees,
            $errors);
        return $this->render($valiables, 'index');
    }

    public function deleteIndex()
    {
        if (!$this->request->isPost()) {
            throw new HttpNotFoundException;
        }
        $employees = $this->model->fetchEmployees();
        $valiables = $this->getVariables(
            '社員情報削除',
            '削除フォーム',
            '/employee/delete',
            'delete',
            $this->inputEmpInfo,
            '削除する',
            $employees,
            []);
        return $this->render($valiables, 'index');
    }

    public function delete()
    {
        if (!$this->request->isPost()) {
            throw new HttpNotFoundException;
        }
        $empNo = $_POST['empNo'];
        $this->setInputEmpInfo($empNo);

        $errors = [];
        $errors = $this->model->validate($empNo, '', __FUNCTION__);
        if (empty($errors)) {
            $this->model->deleteEmployee($empNo);
            $this->inputEmpInfo = $this->initializeInputEmpInfo();
        }
        $employees = $this->model->fetchEmployees();
        $valiables = $this->getVariables(
            '社員情報削除',
            '削除フォーム',
            '/employee/delete',
            'delete',
            $this->inputEmpInfo,
            '削除する',
            $employees,
            $errors);
        return $this->render($valiables, 'index');
    }

    private function mainIndexControl($valiables, $template = null)
    {
        if (!$this->request->isPost()) {
            throw new HttpNotFoundException;
        }
        $employees = $this->model->fetchEmployees();
        return $this->render($valiables, $template);
    }

    private function getVariables($pageTitle, $formTitle, $formAction, $actionName, $inputEmpInfo, $formButton, $employees, $errors)
    {
        $valiables = [];
        $valiables['pageTitle'] = $pageTitle;
        $valiables['formTitle'] = $formTitle;
        $valiables['formAction'] = $formAction;
        $valiables['actionName'] = $actionName;
        $valiables['inputEmpInfo'] = $inputEmpInfo;
        $valiables['formButton'] = $formButton;
        $valiables['employees'] = $employees;
        $valiables['errors'] = $errors;
        return $valiables;
    }

    private function initializeInputEmpInfo()
    {
        return [
            'empNo' => '',
            'empName' => '',
        ];
    }

    private function setInputEmpInfo($empNo, $empName = '')
    {
        $this->inputEmpInfo['empNo'] = $empNo;
        $this->inputEmpInfo['empName'] = $empName;
    }
}
