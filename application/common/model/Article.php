<?php

namespace app\common\model;

use think\Model;

class Article extends Model
{
    protected $pk = 'arc_id';
    protected $table = 'news_article';
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
        return $data = db('article')
            ->order('arc_id desc')
            ->alias('a')
            ->join('__CATE__ c','a.cate_id=c.cate_id')->where('a.is_recycle',$recycle)
            ->field('a.arc_id,a.arc_title,a.arc_author,a.sendtime,a.updatetime,a.arc_sort,c.cate_name')->paginate(10);
//        halt($data);
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
                $arcTagData = [
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




    /********************API***************************/


    /**文章列表
     * @param $cate_id   分类id，必传
     * @param int $page  页数，默认为1，非必传
     * @return \think\Paginator
     */
    public function apiGetArcList($cate_id,$page=1)
    {
        if (request()->isPost())
        {
            //cate_id分类id必传
            if (request()->param('cate_id'))
            {
                $result = db('article')
                    ->order('arc_id desc')
                    ->alias('a')
                    ->join('__CATE__ c','a.cate_id=c.cate_id')
                    ->where(['a.is_recycle'=>2,'a.cate_id'=>$cate_id])
                    ->field('a.arc_id,a.arc_title,a.arc_author,a.sendtime,a.updatetime,a.arc_click,a.is_recycle,a.arc_thumb,a.cate_id,a.admin_id,a.arc_sort,c.cate_name')
                    ->paginate(10,false,[
                        'page'=>$page,
                    ]);

                if ($result)
                {
                    foreach ($result as $val)
                    {
                        $val['arc_thumb'] = 'sssss';

                    }
                    return  $result;
                }

                if ($result)
                {
                    return ['status'=>200,'result'=>$result];
                }else{
                    return ['status'=>103,'msg'=>'服务器异常'];
                }
            }else{
                return ['status'=>101,'msg'=>'参数错误'];
            }
        }
    }

    /**文章详情
     * @param $arc_id
     * @return array
     */
    public function apiGetArcDetail(){
        if(request()->isPost())
        {
            //arc_id文章id必传
            if (request()->param('article_id'))
            {
                //如果用户登录，保存用户浏览记录
                if (request()->param('history_post_id')&&request()->param('history_author_id')&&request()->param('history_author')&&request()->param('history_type'))
                {
//                    $res = (new History())->find(request()->param());
                    $res = (new History())->where(['history_post_id'=>request()->param('history_post_id'),'history_author_id'=>request()->param('history_author_id')])->find();
                    if ($res)
                    {
                        (new History())->allowField(true)->save(request()->param(),['history_post_id'=>request()->param('history_post_id'),'history_author_id'=>request()->param('history_author_id')]);
                    }else {
                        (new History())->allowField(true)->save(request()->param());
                    }
                }

                $result = $this->db()->where(['arc_id'=>request()->param('article_id'),'is_recycle'=>2])->find();
                //获取浏览量
                //浏览量+1
                $click_num = $result['arc_click'];
                $this->where('arc_id',request()->param('article_id'))->update(['arc_click'=>$click_num+1]);
                if ($result)
                {
                    return ['status'=>200,'result'=>$result];
                }else{
                    return ['status'=>103,'msg'=>'服务器异常'];
                }

            }else{
                return ['status'=>101,'msg'=>'参数错误'];
            }
        }else{
            if (request()->param('article_id'))
            {
                $result = $this->db()->where(['arc_id'=>request()->param('article_id'),'is_recycle'=>2])->find();
                //获取浏览量
                //浏览量+1
                $click_num = $result['arc_click'];
                $this->where('arc_id',request()->param('article_id'))->update(['arc_click'=>$click_num+1]);
                if ($result)
                {
                    return $result;
                }else{
                    halt($this->getError());
                }

            }
        }
    }

    //文章搜索
    public function apiGetArcSearch()
    {
        if(request()->isPost()) {
            //return request()->param();exit;
            if (request()->param('arc_content'))
            {
                $where['arc_title'] = array('like','%'.request()->param('arc_content').'%');
                $whereOr['arc_content'] = array('like','%'.request()->param('arc_content').'%');
                $result = $this->db()->order('arc_id desc')->where($where)->whereOr($whereOr)->paginate(10);
                return ['status'=>200, 'result'=>$result];
            }else{
                return ['status'=>101,'msg'=>'参数错误'];
            }
        }else{
            return ['status'=>103,'msg'=>'错误的请求方式'];
        }
    }


}
