<?php

namespace app\admin\controller;

class Entry extends Common
{
    //首页
    public function index()
    {
      // 加载模版文件
      return $this->fetch();
    }
}
