<?php

namespace app\common\model;

use think\Db;
use think\Model;

class UserAuth extends Model
{
    protected $pk = 'id';
    protected $table = 'news_user_auth';
    protected $insert = ['createdtime'];
    protected function setCreatedTimeAttr()
    {
        return time();
    }


    public function apiSetUserAuth()
    {
        if (request()->isPost())
        {
            if (request()->param('type')&&request()->param('identifier')&&request()->param('credential'))
            {
                //1.判断是否已授权
                $result = $this->db()->where(['type'=>request()->param('type'),'identifier'=>request()->param('identifier')])->find();
                if ($result)
                {
                    //2.已经授权，返回用户信息
                    return (new User())->apiGetUserInfo($result['user_id']);
                }else{
                    //3.未授权，添加用户信息
                    $userInfo = (new User())->saveUserInfoGetId(request()->param());

                    //4.添加授权信息
                    $userAuthData = [
                        'user_id'=>$userInfo['user_id'],
                        'type'=>request()->param('type'),
                        'identifier'=>request()->param('identifier'),
                        'credential'=>request()->param('credential')
                    ];

                    $res = $this->save($userAuthData);
                    if ($res)
                    {
                        return ['status'=>200,'result'=>$userInfo];
                    }else{
                        return ['status'=>102,'msg'=>'授权失败'];
                    }
                }
            }else{
                return ['status'=>101,'msg'=>'参数错误'];
            }

        }else{
            return ['status'=>103,'msg'=>'服务器异常'];
        }

    }

}
