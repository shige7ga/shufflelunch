<?php

class EmployeeController extends Controller
{
    private $inputEmpInfo;
    private $model;
    private $variables;
    public function __construct($application)
    {
        parent::__construct($application);
        $this->model = $this->dbManager->getModel('Employee');
        $this->initializeInputEmpInfo();
    }

    public function index()
    {
        $this->setCreateVariables();
        return $this->mainIndexControl();
    }

    public function create()
    {
        $this->setCreateVariables();
        return $this->mainActionControl(__FUNCTION__, 'index');
    }

    public function updateIndex()
    {
        $this->setUpdateVariables();
        return $this->mainIndexControl('index');
    }

    public function update()
    {
        $this->setUpdateVariables();
        return $this->mainActionControl(__FUNCTION__, 'index');
    }

    public function deleteIndex()
    {
        $this->setDeleteVariables();
        return $this->mainIndexControl('index');
    }

    public function delete()
    {
        $this->setDeleteVariables();
        return $this->mainActionControl(__FUNCTION__, 'index');
    }

    private function mainIndexControl($template = null)
    {
        if (!$this->request->isPost()) {
            throw new HttpNotFoundException;
        }
        $this->variables['employees'] = $this->model->fetchEmployees();
        $this->variables['inputEmpInfo'] = $this->inputEmpInfo;
        $this->variables['errors'] = [];
        return $this->render($this->variables, $template);
    }

    private function mainActionControl($actionName, $template = null)
    {
         if (!$this->request->isPost()) {
            throw new HttpNotFoundException;
        }
        $empNo = $_POST['empNo'];
        $empName = '';
        if ($actionName !== 'delete') {
            $empName = $_POST['empName'];
        }
        $this->setInputEmpInfo($empNo, $empName);

        $errors = [];
        $errors = $this->model->validate($empNo, $empName, $actionName);
        if (empty($errors)) {
            $this->execAction($empNo, $empName, $actionName);
            $this->initializeInputEmpInfo();
        }
        $this->variables['employees'] = $this->model->fetchEmployees();
        $this->variables['inputEmpInfo'] = $this->inputEmpInfo;
        $this->variables['errors'] = $errors;
        return $this->render($this->variables, 'index');
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

    private function setCreateVariables()
    {
        $this->setVariables('社員登録', '登録フォーム', '/employee/create', 'create', '登録する');
    }

    private function setUpdateVariables()
    {
        $this->setVariables('社員情報更新', '更新フォーム', '/employee/update', 'update', '更新する');
    }

    private function setDeleteVariables()
    {
        $this->setVariables('社員情報削除', '削除フォーム', '/employee/delete', 'delete', '削除する');
    }

    private function setVariables($pageTitle, $formTitle, $formAction, $actionName, $formButton)
    {
        $this->variables['pageTitle'] = $pageTitle;
        $this->variables['formTitle'] = $formTitle;
        $this->variables['formAction'] = $formAction;
        $this->variables['actionName'] = $actionName;
        $this->variables['formButton'] = $formButton;
    }

    private function initializeInputEmpInfo()
    {
        $this->inputEmpInfo = ['empNo' => '', 'empName' => ''];
    }

    private function setInputEmpInfo($empNo = '', $empName = '')
    {
        $this->inputEmpInfo['empNo'] = $empNo;
        $this->inputEmpInfo['empName'] = $empName;
    }
}
