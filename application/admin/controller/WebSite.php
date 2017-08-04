<?php

namespace app\admin\controller;

use think\Controller;

class WebSite extends Controller
{
    //首页
    public function index()
    {
        return $this->fetch();
    }
}
