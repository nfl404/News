<?php

namespace app\admin\controller;

use think\Controller;

class Tag extends Controller
{
    protected  $db;
    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        $this->db = new \app\common\model\Tag();
    }

    public function index()
    {
        //获取首页的数据
        // 查询状态为1的用户数据 并且每页显示10条数据
        //$list = Db::name('user')->where('status',1)->paginate(10);
        // 查询标签数据 并且每页显示10条数据
        $field = db('tag')->paginate(5);
        //halt($field);
        $this->assign('field',$field);
        return $this->fetch();
    }
    /**
     * 添加标签
     */
    public function store()
    {
        $tag_id = input('param.tag_id');

        if (request()->isPost())
        {
            //halt($_POST);
            $res = $this->db->store(input('post.'));
            if ($res['valid'])
            {
                //执行成功
                $this->success($res['msg'],'index');eixt;
            }else{
                $this->error($res['msg']);exit;
            }
        }
        if ($tag_id)
        {
            //编辑请求
            $oldData = $this->db->find($tag_id);
            //halt($oldData);
        }else{
            //添加
            $oldData = ['tag_name'=>''];
        }
        $this->assign('oldData',$oldData);
        return $this->fetch();
    }
    /**
     * 删除
     */
    public function del()
    {
        //echo 1;die;
        $tag_id = input('get.tag_id');
        //halt($tag_id);
        //执行删除
        if (\app\common\model\Tag::destroy($tag_id))
        {
            //成功提示
            $this->success('操作成功','index');exit;
        }else{
            $this->error('操作失败');exit;
        }
    }
}
