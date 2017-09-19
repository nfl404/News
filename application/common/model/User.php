<?php

namespace app\common\model;

use think\Model;

class User extends Model
{
    protected $pk = 'user_id';
    protected $table = 'news_user';
    protected $insert = ['createdtime','loginip'];
    protected $auto = ['lastlogintime','lastlogintime'];
    protected function setCreatedTimeAttr()
    {
        return date("Y-m-d H:i:s", time()) ;
    }
    protected function setLoginIpAttr()
    {
        return $this->getclientip();
    }
    protected function setLastLoginTimeAttr()
    {
        return date('Y-m-d H:i:s', time());
    }
    protected function setLastLoginIpAttr()
    {
        return $this->getclientip();
    }

    public function saveUserInfoGetId($data)
    {
        $result = $this->allowField(true)->save($data);
        if ($result)
        {
            return $this;
        }else{
            return ['status'=>101,'msg'=>(new User())->getError()];
        }
    }

    /**
     * 用户授权
     */
    public function apiGetUserInfo($user_id)
    {
        $this->save(['lastlogintime'=>$this->setLastLoginTimeAttr(),'lastloginip'=>$this->setLastLoginIpAttr()],['user_id'=>$user_id]);
        $result = $this->where(['user_id'=>$user_id])->find();
        if ($result)
        {
            return ['status'=>200,'result'=>$result];
        }else{
            echo 2;exit;
            return ['status'=>105,'msg'=>'没有该用户信息'];
        }
    }

    /**
     * 获取客户端IP地址
     * @param integer $type
     * @return mixed
     */
    function getclientip() {
        static $realip = NULL;

        if($realip !== NULL){
            return $realip;
        }
        if(isset($_SERVER)){
            if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){ //但如果客户端是使用代理服务器来访问，那取到的就是代理服务器的 IP 地址，而不是真正的客户端 IP 地址。要想透过代理服务器取得客户端的真实 IP 地址，就要使用 $_SERVER["HTTP_X_FORWARDED_FOR"] 来读取。
                $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                /* 取X-Forwarded-For中第一个非unknown的有效IP字符串 */
                foreach ($arr AS $ip){
                    $ip = trim($ip);
                    if ($ip != 'unknown'){
                        $realip = $ip;
                        break;
                    }
                }
            }elseif(isset($_SERVER['HTTP_CLIENT_IP'])){//HTTP_CLIENT_IP 是代理服务器发送的HTTP头。如果是"超级匿名代理"，则返回none值。同样，REMOTE_ADDR也会被替换为这个代理服务器的IP。
                $realip = $_SERVER['HTTP_CLIENT_IP'];
            }else{
                if (isset($_SERVER['REMOTE_ADDR'])){ //正在浏览当前页面用户的 IP 地址
                    $realip = $_SERVER['REMOTE_ADDR'];
                }else{
                    $realip = '0.0.0.0';
                }
            }
        }else{
            //getenv环境变量的值
            if (getenv('HTTP_X_FORWARDED_FOR')){//但如果客户端是使用代理服务器来访问，那取到的就是代理服务器的 IP 地址，而不是真正的客户端 IP 地址。要想透过代理服务器取得客户端的真实 IP 地址
                $realip = getenv('HTTP_X_FORWARDED_FOR');
            }elseif (getenv('HTTP_CLIENT_IP')){ //获取客户端IP
                $realip = getenv('HTTP_CLIENT_IP');
            }else{
                $realip = getenv('REMOTE_ADDR');  //正在浏览当前页面用户的 IP 地址
            }
        }
        preg_match("/[\d\.]{7,15}/", $realip, $onlineip);
        $realip = !empty($onlineip[0]) ? $onlineip[0] : '0.0.0.0';
        return $realip;
    }

}
