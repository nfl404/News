<?php

namespace app\common\model;

use think\Model;

class Message extends Model
{
    protected $pk = 'relation_id';
    protected $table = 'news_relation_log';
    protected $insert = ['relationauthorip','relationdate','relationdategmt','relationagent'];
    protected function setRelationAuthorIpAttr()
    {
        return request()->ip();
    }
    protected function setRelationDateAttr()
    {
        return time();
    }
    protected function setRelationDateGmtAttr()
    {
        return date('Y-m-d H:i:m', time());
    }
    protected function setRelationAgentAttr()
    {
        return $_SERVER['HTTP_USER_AGENT'];
    }


    //获取我的消息动
    public function apiGetMyMessages()
    {
        if (request()->isPost())
        {
            if (request()->param('relation_user_id'))
            {
                //1.查找我关注的人
                //2.关联我关注的人的动态（评论）
                $result = $this
                    ->order('relation_id desc')
                    ->alias('r')
                    ->join('__USER__ u','r.relation_author_id=u.user_id')
                    ->where(['relation_user_id'=>request()->param('relation_user_id')])
                    ->paginate(10);
                if ($result)
                {
                    return ['status'=>200,'result'=>$result];
                }else{
                    return ['status'=>103,'msg'=>$this->getError()];
                }

            }else{
                return ['status'=>101,'msg'=>'参数错误'];
            }
        }else{
            return ['status'=>103,'msg'=>'错误的请求方式'];
        }
    }

}
