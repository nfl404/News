<?php

namespace app\admin\controller;

use app\common\model\Admin;
use houdunwang\crypt\Crypt;
use think\Controller;

class Login extends Controller
{
    //登录
    /**
     * @return mixed
     */
    public function login()
    {
//        echo Crypt::encrypt('admin11');//加密串：baLuK2TWcDm5sPQP1oz4Og==
//        echo Crypt::decrypt('baLuK2TWcDm5sPQP1oz4Og==');//测试解密：admin11

        //测试数据库连接
//      $da = db('admin')->find(1);
//      dump($da);

        if (request()->isPost())
        {
            $res = (new Admin())->login(input('post.'));
            if ($res['valid'])
            {
                //说明登录成功
                $this->success($res['msg'],'admin/entry/index');exit;

            }else{
                $this->error($res['msg']);exit;
            }
        }
       // 加载登录页面
       return $this->fetch('index');
    }
}
