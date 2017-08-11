<?php

namespace app\common\model;

use think\Model;

class Tag extends Model
{
    protected $pk = 'tag_id';//主键
    protected $table = 'news_tag';//表名
    /**
     * 添加标签
     */
    public function store($data)
    {
        //1.验证
        //2.执行添加
        $result = $this->validate(true)->save($data,$data['tag_id']);
        if ($result)
        {
            //说明执行成功
            return ['valid'=>1,'msg'=>'操作成功'];
        }else{
            return ['valid'=>0,'msg'=>$this->getError()];
        }


    }
}
