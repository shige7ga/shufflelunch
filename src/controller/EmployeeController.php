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
            'actionName' => 'create',
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
        $errors = $employeeModel->validate($empNo, $empName, __FUNCTION__);
        if (empty($errors)) {
            $employeeModel->registerEmployee($empNo, $empName);
        }
        $employees = $employeeModel->fetchEmployees();
        return $this->render([
            'pageTitle' => '社員登録',
            'formTitle' => '登録フォーム',
            'formAction' => '/employee/create',
            'actionName' => 'create',
            'formButton' => '登録する',
            'employees' => $employees,
            'errors' => $errors,
        ], 'index');
    }

    public function updateIndex()
    {
        if (!$this->request->isPost()) {
            throw new HttpNotFoundException;
        }
        $employees = $this->dbManager->getModel('Employee')->fetchEmployees();
        return $this->render([
            'pageTitle' => '社員情報更新',
            'formTitle' => '更新フォーム',
            'formAction' => '/employee/update',
            'actionName' => 'update',
            'formButton' => '更新する',
            'employees' => $employees,
            'errors' => [],
        ], 'index');
    }

    public function update()
    {
        if (!$this->request->isPost()) {
            throw new HttpNotFoundException;
        }
        $empNo = $_POST['empNo'];
        $empName = $_POST['empName'];

        $errors = [];
        $employeeModel = $this->dbManager->getModel('Employee');
        $errors = $employeeModel->validate($empNo, $empName, __FUNCTION__);
        if (empty($errors)) {
            $employeeModel->updateEmployee($empNo, $empName);
        }
        $employees = $employeeModel->fetchEmployees();
        return $this->render([
            'pageTitle' => '社員情報更新',
            'formTitle' => '更新フォーム',
            'formAction' => '/employee/update',
            'actionName' => 'update',
            'formButton' => '更新する',
            'employees' => $employees,
            'errors' => $errors,
        ], 'index');
    }

    public function deleteIndex()
    {
        if (!$this->request->isPost()) {
            throw new HttpNotFoundException;
        }
        $employees = $this->dbManager->getModel('Employee')->fetchEmployees();
        return $this->render([
            'pageTitle' => '社員情報削除',
            'formTitle' => '削除フォーム',
            'formAction' => '/employee/delete',
            'actionName' => 'delete',
            'formButton' => '削除する',
            'employees' => $employees,
            'errors' => [],
        ], 'index');
    }

    public function delete()
    {
        if (!$this->request->isPost()) {
            throw new HttpNotFoundException;
        }
        $empNo = $_POST['empNo'];

        $errors = [];
        $employeeModel = $this->dbManager->getModel('Employee');
        $errors = $employeeModel->validate($empNo, '', __FUNCTION__);
        if (empty($errors)) {
            $employeeModel->deleteEmployee($empNo);
        }
        $employees = $employeeModel->fetchEmployees();
        return $this->render([
            'pageTitle' => '社員情報削除',
            'formTitle' => '削除フォーム',
            'formAction' => '/employee/delete',
            'actionName' => 'delete',
            'formButton' => '削除する',
            'employees' => $employees,
            'errors' => $errors,
        ], 'index');
    }

}
