<?php

class EmployeeController extends Controller
{
    public function index()
    {
        if (!$this->request->isPost()) {
            throw new HttpNotFoundException;
        }
        $employees = $this->dbManager->getModel('Employee')->fetchEmployees();
        return $this->render([
            'pageTitle' => '社員登録',
            'formTitle' => '登録フォーム',
            'formAction' => '/employee/create',
            'formButton' => '登録する',
            'employees' => $employees,
            'errors' => [],
        ]);
    }

    public function create()
    {
        if (!$this->request->isPost()) {
            throw new HttpNotFoundException;
        }
        $empNo = $_POST['empNo'];
        $empName = $_POST['empName'];

        $errors = [];
        $employeeModel = $this->dbManager->getModel('Employee');
        $errors = $employeeModel->validate($empNo, $empName, 'create');
        if (empty($errors)) {
            $employeeModel->registerEmployee($empNo, $empName);
        }
        $employees = $employeeModel->fetchEmployees();
        return $this->render([
            'pageTitle' => '社員登録',
            'formTitle' => '登録フォーム',
            'formAction' => '/employee/create',
            'formButton' => '登録する',
            'employees' => $employees,
            'errors' => $errors,
        ], 'index');
    }

    public function update()
    {
        if (!$this->request->isPost()) {
            throw new HttpNotFoundException;
        }
        $employees = $this->dbManager->getModel('Employee')->fetchEmployees();
        return $this->render([
            'pageTitle' => '社員情報更新',
            'formTitle' => '更新フォーム',
            'formAction' => '/employee/updateAction',
            'formButton' => '更新する',
            'employees' => $employees,
            'errors' => [],
        ], 'index');
    }

    public function updateAction()
    {
        if (!$this->request->isPost()) {
            throw new HttpNotFoundException;
        }
        $empNo = $_POST['empNo'];
        $empName = $_POST['empName'];

        $errors = [];
        $employeeModel = $this->dbManager->getModel('Employee');
        $errors = $employeeModel->validate($empNo, $empName, 'update');
        if (empty($errors)) {
            $employeeModel->updateEmployee($empNo, $empName);
        }
        $employees = $employeeModel->fetchEmployees();
        return $this->render([
            'pageTitle' => '社員情報更新',
            'formTitle' => '更新フォーム',
            'formAction' => '/employee/updateAction',
            'formButton' => '更新する',
            'employees' => $employees,
            'errors' => $errors,
        ], 'index');
    }

}
