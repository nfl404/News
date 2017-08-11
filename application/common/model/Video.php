<?php

namespace app\common\model;

use think\Model;

class Video extends Model
{
    protected $pk = 'video_id';
    protected $table = 'news_video';
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
     * 视频列表
     */
    public function getAll($recycle=2)
    {
        $data = db('video')->alias('v')->join('__CATE__ c','v.cate_id=c.cate_id')->where('is_recycle',$recycle)->field('v.video_id,v.video_title,v.video_author,v.sendtime,v.updatetime,v.video_sort,c.cate_name')->paginate(10);
        //halt($data);exit;
        return $data;
    }

    /**
     * 添加视频
     */
    public function store($data)
    {
        //halt($data);exit;
        if (!isset($data['tag']))
        {
            return ['valid'=>0,'msg'=>'请选择标签'];
        }
        //验证
        //添加数据库
        $result = $this->validate(true)->allowField(true)->save($data);
        if ($result)
        {
            //视频标签中间表添加
            foreach ($data['tag'] as $vo)
            {
                $videoTag=[
                    'vid_id'=>$this->video_id,
                    'tag_id'=>$vo,
                ];
                (new ArcTag())->save($videoTag);
            }
            return ['valid'=>1,'msg'=>'操作成功'];
        }else{
            return ['valid'=>0,'msg'=>$this->getError()];
        }
    }
    /**
     * 编辑视频
     */
    public function edit($data)
    {
        //halt($data);exit;
        if (!isset($data['tag']))
        {
            return ['valid'=>0,'msg'=>'请选择标签'];
        }
        //验证
        //添加数据库
        $result = $this->validate(true)->allowField(true)->save($data,[$this->pk=>$data['video_id']]);
        if ($result)
        {
            ArcTag::where('vid_id','=',$data['video_id'])->delete();
            //视频标签中间表添加
            foreach ($data['tag'] as $vo)
            {
                $videoTag=[
                    'vid_id'=>$this->video_id,
                    'tag_id'=>$vo,
                ];
                (new ArcTag())->save($videoTag);
            }
            return ['valid'=>1,'msg'=>'操作成功'];
        }else{
            return ['valid'=>0,'msg'=>$this->getError()];
        }
    }
    /**
     * 删除视频
     */
    public function del($video_id)
    {
        //halt($video_id);exit;
        $result = $this->db()->where('video_id',$video_id)->update(['is_recycle'=>1]);
        if ($result)
        {
            return ['valid'=>1,'msg'=>'操作成功'];
        }else{
            return ['valid'=>0,'msg'=>'操作失败'];
        }
    }
    /***
     * 从回收站移回视频列表
     */
    public function getRecycle($video_id)
    {
        $result = $this->db()->where('video_id',$video_id)->update(['is_recycle'=>2]);
        if ($result)
        {
            return ['valid'=>1,'msg'=>'操作成功'];
        }else{
            return ['valid'=>0,'msg'=>'操作失败'];
        }
    }
    /**视频列表
     * @param $cate_id   分类id，必传
     * @param int $page  页数，默认为1，非必传
     * @return \think\Paginator
     */
    public function apiGetVidList($cate_id,$page=1)
    {
        if (request()->isPost())
        {
            //cate_id分类id必传
            if (request()->param('cate_id'))
            {
                $result = db('video')
                    ->alias('v')
                    ->join('__CATE__ c','v.cate_id=c.cate_id')
                    ->where(['v.is_recycle'=>2,'v.cate_id'=>$cate_id])
                    ->field('v.video_id,v.video_title,v.video_author,v.sendtime,v.updatetime,v.video_click,v.is_recycle,v.video_thumb,v.cate_id,v.admin_id,v.video_sort,v.video_url,c.cate_name')
                    ->paginate(10,false,[
                        'page'=>$page,
                    ]);
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

    /**视频详情
     * @param $video_id
     * @return array
     */
    public function apiGetVidDetail($video_id){
        if(request()->isPost())
        {
            //arc_id文章id必传
            if (request()->param('video_id'))
            {
                $result = $this->db()->where('video_id',$video_id)->find();
                return ['status'=>200,'result'=>$result];
            }else{
                return ['status'=>101,'msg'=>'参数错误'];
            }
        }
    }
}
