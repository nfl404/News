<?php

namespace app\admin\controller;

use app\common\model\Admin;

class Entry extends Common
{
    /*首页*/
    public function index()
    {
      // 加载模版文件
      return $this->fetch();
    }
    /**修改密码
     * @return mixed
     */
    public function pass()
    {
        if (request()->isPost())
        {
            $res = (new Admin())->pass(input('post.'));
            if ($res['valid'])
            {
                //清除session中登录的信息
                session(null);
                //执行成功
                $this->success($res['msg'],'admin/entry/index');exit;
            }else{
                $this->error($res['msg']);exit;
            }
        }
        return $this->fetch();
    }

    /**
     * 退出登录
     */
    public function logOut()
    {
        session(null);
        $this->success('已退出登录','admin/entry/index');exit;
    }

}
