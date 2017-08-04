<?php

namespace app\admin\controller;

use think\Controller;

class Recycle extends Controller
{
    protected $db;
    protected function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        $this->db = new \app\common\model\Article();
    }

    //回收站文章列表首页
    public function index()
    {
        $field = $this->db->getAll(1);
        //halt($res);die;
        $this->assign('field', $field);
        return $this->fetch();
    }
    //编辑
    public function edit()
    {
        return $this->fetch();
    }
    //移回文章列表
    public function getBack()
    {
        //$arc_id = input('get.arc_id');
        //halt($arc_id);
        $res = $this->db->getBack(input('get.arc_id'));
        if ($res['valid'])
        {
            $this->success($res['msg'],'index');exit;
        }else{
            $this->error($res['msg']);exit;
        }
    }
}
