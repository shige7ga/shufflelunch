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
        $errors = $employeeModel->validate($empNo, $empName);
        if (empty($errors)) {
            $employeeModel->registerEmployee($empNo, $empName);
        }
        $employees = $employeeModel->fetchEmployees();
        return $this->render([
            'pageTitle' => '社員登録',
            'formTitle' => '登録フォーム',
            'formButton' => '登録する',
            'employees' => $employees,
            'errors' => $errors,
        ], 'index');
    }
}
