<?php

namespace app\common\model;

use think\Model;

class Article extends Model
{
    protected $pk = 'arc_id';
    protected $table = 'blog_article';
    protected $auto = ['admin_id'];
    protected $insert = ['sendtime'];
    protected $update = ['updatetime'];
    protected function setAdminIdAttr()
    {
        return session('admin.admin_id');
    }
    protected function setSendTimeAttr()
    {
        return time();
    }
    protected function setUpdateTimeAttr()
    {
        return time();
    }
    /**
     * 获取文章首页数据
     */
    public function getAll($recycle=2)
    {
        return $data = db('article')->alias('a')
            ->join('__CATE__ c','a.cate_id=c.cate_id')->where('a.is_recycle',$recycle)
            ->field('a.arc_id,a.arc_title,a.arc_author,a.sendtime,a.updatetime,a.arc_sort,c.cate_name')->paginate(10);
        //halt($data);
    }
    /**
     * 添加文章
     */
    public function store($data)
    {
        //halt($data);
        if (!isset($data['tag']))
        {
            //说明添加的时候没有选择标签
            return ['valid'=>0,'msg'=>'请选择标签'];
        }
        //1.验证
        //2.添加数据库
        //halt($data);die;
        $result = $this->validate(true)->allowField(true)->save($data);
        //halt($result);die;
        if ($result)
        {
            //文章标签中间表的添加
            foreach($data['tag'] as $v)
            {
                $arcTagData= [
                    'arc_id'=>$this->arc_id,
                    'tag_id'=>$v,
                ];
                (new ArcTag())->save($arcTagData);
            }
            //执行成功
            return ['valid'=>1,'msg'=>'文章上传成功'];
        }else{
            return ['valid'=>0,'msg'=>$this->getError()];
        }
    }
    /**
     * 编辑文章
     */
    public function edit($data)
    {
        //halt($data);
        if (!isset($data['tag']))
        {
            //说明添加的时候没有选择标签
            return ['valid'=>0,'msg'=>'请选择标签'];
        }
        //1.验证
        //2.添加数据库
        //halt($data);die;
        $result = $this->validate(true)->allowField(true)->save($data,[$this->pk=>$data['arc_id']]);
        //halt($result);die;
        if ($result)
        {
            //halt($data);
            ArcTag::where('arc_id','=',$data['arc_id'])->delete();
            //文章标签中间表的添加
            foreach($data['tag'] as $v)
            {
                $arcTagData= [
                    'arc_id'=>$this->arc_id,
                    'tag_id'=>$v,
                ];
                (new ArcTag())->save($arcTagData);
            }
            //执行成功
            return ['valid'=>1,'msg'=>'文章修改成功'];
        }else{
            return ['valid'=>0,'msg'=>$this->getError()];
        }
    }
    /**
     * 删除栏目
     */
    public function del($arc_id)
    {
        //更新当前文章is_recycle
        //halt($arc_id);
        $result = $this->where('arc_id',$arc_id)->update(['is_recycle'=>1]);
        //halt($result);
        if ($result)
        {
            return ['valid'=>1,'msg'=>'操作成功'];
        }else{
            return ['valid'=>0,'msg'=>'操作失败'];
        }


    }
    /***
     * 移回到文章列表
     */
    public function getBack($arc_id)
    {
        //halt($arc_id);
        $result = $this->where('arc_id',$arc_id)->update(['is_recycle'=>2]);
        if ($result)
        {
            return ['valid'=>1,'msg'=>'操作成功'];
        }else{
            return ['valid'=>0,'msg'=>'操作失败'];
        }
    }

}
