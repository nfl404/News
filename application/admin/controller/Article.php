<?php

namespace app\admin\controller;

use app\common\model\Category;
use think\Controller;

class Article extends Controller
{
    protected $db;
    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        $this->db = new \app\common\model\Article();
    }

    //文章列表首页
    public function index()
    {
        $field = $this->db->getAll(2);
        $this->assign('field',$field);
        return $this->fetch();
    }
    //添加
    public function store()
    {
        if (request()->isPost())
        {
            //halt($_POST);
            $res = $this->db->store(input('post.'));
            if ($res['valid'])
            {
                $this->success($res['msg'],'index');exit;
            }else{
                $this->error($res['msg']);exit;
            }
        }
        //1.获取分类数据
        $cateData = (new Category())->getAll();
        //halt($cateData);
        $this->assign('cateData',$cateData);
        //2。获取标签数据
        $tagData = db('tag')->select();
        //halt($tagData);
        $this->assign('tagData',$tagData);
        return $this->fetch();
    }
    //编辑
    public function edit()
    {
        if (request()->isPost())
        {
            $res = $this->db->edit(input('post.'));
            if ($res['valid'])
            {
                $this->success($res['msg'],'index');exit;
            }else{
                $this->error($res['msg']);exit;
            }
        }

        //接收文章arc_id
        $arc_id = input('param.arc_id');
        //halt($arc_id);
        //获取旧数据
        $oldData = $this->db->find($arc_id);
        //halt($oldData);
        $this->assign('oldData',$oldData);

        //1.获取分类数据
        $cateData = (new Category())->getAll();
        //halt($cateData);
        $this->assign('cateData',$cateData);
        //2。获取标签数据
        $tagData = db('tag')->select();
        //halt($tagData);
        $this->assign('tagData',$tagData);

        //获取文章标签数据
        $arcTag = db('arc_tag')->select();
        //halt($arc_tag[0]);
        $this->assign('arcTag',$arcTag);

        return $this->fetch();
    }
    /**
     * 删除到回收站
     */
    public function del()
    {
        //$arc_id = input('get.arc_id');
        //halt($arc_id);
        $res = $this->db->del(input('get.arc_id'));
        if ($res['valid'])
        {
            $this->success($res['msg'],'index');exit;
        }else{
            $this->error($res['msg']);exit;
        }
    }
}
