<?php

class ShuffleController extends Controller
{
    public function index()
    {
        return $this->render([
            'pageTitle' => 'トップ',
            'formTitle' => '操作一覧',
        ]);
    }
}
