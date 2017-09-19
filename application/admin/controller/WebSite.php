<?php

namespace app\admin\controller;


class WebSite extends Common
{
    //首页
    public function index()
    {
        return $this->fetch();
    }
}
