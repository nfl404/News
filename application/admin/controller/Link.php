<?php

namespace app\admin\controller;

use think\Controller;

class Link extends Controller
{
    //友链首页
    public function index()
    {
        return $this->fetch();
    }
    //添加友情连接
    public function store()
    {
        return $this->fetch();
    }
}
