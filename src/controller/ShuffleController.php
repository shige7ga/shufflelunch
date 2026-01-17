<?php

class ShuffleController extends Controller
{
    public function index()
    {
        return $this->render([
            'pageTitle' => 'トップ',
            'formTitle' => '操作一覧',
            'groups' => []
        ]);
    }

    public function create()
    {
        if (!$this->request->isPost()) {
            throw new HttpNotFoundException;
        }
        $groups = $this->dbManager->getModel('Employee')->getShuffleEmployees();
        return $this->render([
            'pageTitle' => 'トップ - シャッフル結果',
            'formTitle' => '操作一覧',
            'groups' => $groups,
        ], 'index');
    }
}
