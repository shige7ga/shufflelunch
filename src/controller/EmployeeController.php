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
        $valiables = $this->getCreateVariables();
        return $this->mainIndexControl($valiables);
    }

    public function create()
    {
        $valiables = $this->getCreateVariables();
        return $this->mainActionControl($valiables, __FUNCTION__, 'index');
    }

    public function updateIndex()
    {
        $valiables = $this->getUpdateVariables();
        return $this->mainIndexControl($valiables, 'index');
    }

    public function update()
    {
        $valiables = $this->getUpdateVariables();
        return $this->mainActionControl($valiables, __FUNCTION__, 'index');
    }

    public function deleteIndex()
    {
        $valiables = $this->getDeleteVariables();
        return $this->mainIndexControl($valiables, 'index');
    }

    public function delete()
    {
        $valiables = $this->getDeleteVariables();
        return $this->mainActionControl($valiables, __FUNCTION__, 'index');
    }

    private function mainIndexControl($valiables, $template = null)
    {
        if (!$this->request->isPost()) {
            throw new HttpNotFoundException;
        }
        $valiables['employees'] = $this->model->fetchEmployees();
        $valiables['inputEmpInfo'] = $this->inputEmpInfo;
        $valiables['errors'] = [];
        return $this->render($valiables, $template);
    }

    private function mainActionControl($valiables, $actionName, $template = null)
    {
         if (!$this->request->isPost()) {
            throw new HttpNotFoundException;
        }
        $empNo = $_POST['empNo'];
        $empName = '';
        if ($actionName === 'delete') {
            $empName = '';
        } else {
            $empName = $_POST['empName'];
        }
        $this->setInputEmpInfo($empNo, $empName);

        $errors = [];
        $errors = $this->model->validate($empNo, $empName, $actionName);
        if (empty($errors)) {
            $this->execAction($empNo, $empName, $actionName);
            $this->inputEmpInfo = $this->initializeInputEmpInfo();
        }
        $valiables['employees'] = $this->model->fetchEmployees();
        $valiables['inputEmpInfo'] = $this->inputEmpInfo;
        $valiables['errors'] = $errors;
        return $this->render($valiables, 'index');
    }

    private function execAction($empNo, $empName, $actionName)
    {
        if ($actionName === 'create') {
            $this->model->registerEmployee($empNo, $empName);
        } elseif ($actionName === 'update') {
            $this->model->updateEmployee($empNo, $empName);
        } elseif ($actionName === 'delete') {
            $this->model->deleteEmployee($empNo);
        }
    }

    private function getCreateVariables()
    {
        return $this->getVariables('社員登録', '登録フォーム', '/employee/create', 'create', '登録する');
    }

    private function getUpdateVariables()
    {
        return $this->getVariables('社員情報更新', '更新フォーム', '/employee/update', 'update', '更新する');
    }

    private function getDeleteVariables()
    {
        return  $this->getVariables('社員情報削除', '削除フォーム', '/employee/delete', 'delete', '削除する');
    }

    private function getVariables($pageTitle, $formTitle, $formAction, $actionName, $formButton)
    {
        $valiables = [];
        $valiables['pageTitle'] = $pageTitle;
        $valiables['formTitle'] = $formTitle;
        $valiables['formAction'] = $formAction;
        $valiables['actionName'] = $actionName;
        $valiables['formButton'] = $formButton;
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
