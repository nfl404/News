<?php

namespace app\common\model;

use think\Model;

class Audio extends Model
{
    protected $pk = 'audio_id';
    protected $table = 'news_audio';
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
     * 音频列表
     */
    public function getAll($recycle=2)
    {
        $data = db('audio')->alias('a')->join('__CATE__ c','a.cate_id=c.cate_id')->where('is_recycle',$recycle)->field('a.audio_id,a.audio_title,a.audio_author,a.sendtime,a.updatetime,a.audio_sort,c.cate_name')->paginate(10);
        //halt($data);exit;
        return $data;
    }

    /**
     * 添加音频
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
                    'aud_id'=>$this->audio_id,
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
     * 编辑音频
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
        $result = $this->validate(true)->allowField(true)->save($data,[$this->pk=>$data['audio_id']]);
        if ($result)
        {
            ArcTag::where('aud_id','=',$data['audio_id'])->delete();
            //视频标签中间表添加
            foreach ($data['tag'] as $vo)
            {
                $audioTag=[
                    'aud_id'=>$this->audio_id,
                    'tag_id'=>$vo,
                ];
                (new ArcTag())->save($audioTag);
            }
            return ['valid'=>1,'msg'=>'操作成功'];
        }else{
            return ['valid'=>0,'msg'=>$this->getError()];
        }
    }
    /**
     * 将音频移到回收站
     */
    public function del($audio_id)
    {
        //halt($video_id);exit;
        $result = $this->db()->where('audio_id',$audio_id)->update(['is_recycle'=>1]);
        if ($result)
        {
            return ['valid'=>1,'msg'=>'操作成功'];
        }else{
            return ['valid'=>0,'msg'=>'操作失败'];
        }
    }
    /***
     * 从回收站移回音频列表
     */
    public function getRecycle($audio_id)
    {
        $result = $this->db()->where('audio_id',$audio_id)->update(['is_recycle'=>2]);
        if ($result)
        {
            return ['valid'=>1,'msg'=>'操作成功'];
        }else{
            return ['valid'=>0,'msg'=>'操作失败'];
        }
    }
    /**音频列表
     * @param $cate_id   分类id，必传
     * @param int $page  页数，默认为1，非必传
     * @return \think\Paginator
     */
    public function apiGetAudList($cate_id,$page=1)
    {
        if (request()->isPost())
        {
            //cate_id分类id必传
            if (request()->param('cate_id'))
            {
                $result = db('audio')
                    ->alias('a')
                    ->join('__CATE__ c','a.cate_id=c.cate_id')
                    ->where(['a.is_recycle'=>2,'a.cate_id'=>$cate_id])
                    ->field('a.audio_id,a.audio_title,a.audio_author,a.sendtime,a.updatetime,a.audio_click,a.is_recycle,a.audio_thumb,a.cate_id,a.admin_id,a.audio_sort,a.audio_url,c.cate_name')
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

    /**音频详情
     * @param $audio_id
     * @return array
     */
    public function apiGetAudDetail($audio_id){
        if(request()->isPost())
        {
            //arc_id文章id必传
            if (request()->param('audio_id'))
            {
                $result = $this->db()->where('audio_id',$audio_id)->find();
                return ['status'=>200,'result'=>$result];
            }else{
                return ['status'=>101,'msg'=>'参数错误'];
            }
        }
    }
}
