<?php

namespace app\common\model;

use think\Model;

class Relation extends Model
{
    protected $pk = 'relation_id';
    protected $table = 'news_relation';
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

    //关注／取消关注
    public function apiRelation()
    {
        if (request()->isPost())
        {
            if (request()->param('relation_author_id')&&request()->param('relation_user_id'))
            {
                //判断不能关注自己
                if (request()->param('relation_author_id')==request()->param('relation_user_id'))
                {
                    return ['status'=>101,'msg'=>'不能关注自己'];
                }else{
                    //判断是关注／取消关注
                    if (request()->param('action') == 'cancel')
                    {
                        $result = $this->where(['relation_author_id'=>request()->param('relation_author_id'),'relation_user_id'=>request()->param('relation_user_id')])->delete();
                        (new Message())->allowField(true)->save(request()->param());
                        if ($result)
                        {
                            return ['status'=>200,'msg'=>'取消关注成功'];

                        }else{
                            return ['status'=>101,'msg'=>$this->getError()];
                        }

                    }else{
                        //return request()->param();
                        //1.添加关注
                        //2.判断是否已经关注
                        $result = $this->where(['relation_author_id'=>request()->param('relation_author_id'), 'relation_user_id'=>request()->param('relation_user_id')])->find();
                        //return $result;
                        (new Message())->allowField(true)->save(request()->param());
                        if ($result)
                        {
                            return ['status'=>200,'msg'=>'已经关注了'];
                        }else{
                            $result = $this->allowField(true)->save(request()->param());
                            if ($result)
                            {
                                return ['status'=>200, 'msg'=>'已成功关注'];
                            }else{
                                return ['status'=>101, 'msg'=>'关注失败'];
                            }
                        }
                    }
                }
            }else{
                return ['status'=>101,'msg'=>'参数错误'];
            }
        }else{
            return ['status'=>103,'msg'=>'错误的请求方式'];
        }
    }

    //关注用户的最新动态
    public function apiGetRelations()
    {
        if (request()->isPost())
        {
            if (request()->param('relation_author_id'))
            {
                //1.查找我关注的人
                //2.关联我关注的人的动态（评论）
                $result = $this
                    ->order('relation_id desc')
                    ->alias('r')
                    ->join('__COMMENTS__ c','r.relation_user_id=c.comment_author_id')
                    ->join('__ARTICLE__ a','a.arc_id=c.comment_post_id')
                    ->join('__USER__ u','r.relation_user_id=u.user_id')
                    ->where(['relation_author_id'=>request()->param('relation_author_id')])
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

    //获取我关注的用户
    public function apiGetMyFollows()
    {
        if (request()->isPost())
        {
            if (request()->param('relation_author_id'))
            {
                //查找我关注的人
                $result = $this
                    ->order('relation_id desc')
                    ->alias('r')
                    ->join('__USER__ u','r.relation_user_id=u.user_id')
                    ->where(['relation_author_id'=>request()->param('relation_author_id')])
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

    //获取我的粉丝
    public function apiGetMyFollowers()
    {
        if (request()->isPost())
        {
            if (request()->param('relation_author_id'))
            {
                //查找我关注的人
                $result = $this
                    ->order('relation_id desc')
                    ->alias('r')
                    ->join('__USER__ u','r.relation_author_id=u.user_id')
                    ->where(['relation_user_id'=>request()->param('relation_author_id')])
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
