<?php

namespace app\common\model;

use think\Model;

class History extends Model
{
    protected $pk = 'history_id';
    protected $table = 'news_history';
    protected $insert = ['sendtime','sendtimegmt','historyauthorip','historyagent'];
    protected $update = ['updatetime','updatetimegmt'];
    protected function setSendTimeAttr()
    {
        return time();
    }
    protected function setSendTimeGmtAttr()
    {
        return date('Y-m-d H:i:m',time());
    }
    protected function setUpdateTimeAttr()
    {
        return time();
    }
    protected function setUpdateTimeGmtAttr()
    {
        return date('Y-m-d H:i:m',time());
    }
    protected function setHistoryAuthorIpAttr()
    {
        return request()->ip();
    }
    protected function setHistoryAgentAttr()
    {
        return $_SERVER['HTTP_USER_AGENT'];
    }
    //历史/删除历史
    public function apiHistory()
    {
        if (request()->isPost())
        {
            if (request()->param('history_post_id')&&request()->param('history_author_id')&&request()->param('history_author')&&request()->param('history_type'))
            {
                //删除历史记录
                if (request()->param('action') == 'del')
                {
                    $result = $this->where(['history_post_id'=>request()->param('history_post_id'),'history_author_id'=>request()->param('history_author_id')])->delete();
                    if ($result)
                    {
                        return ['status'=>200,'type'=>0]; //删除历史
                    }else{
                        return ['status'=>101,'msg'=>$this->getError()];
                    }
                } else {
                    //return request()->param();exit;
                    $result = $this->where(['history_post_id'=>request()->param('history_post_id'),'history_author_id'=>request()->param('history_author_id')])->find();
                    //return $result;exit;
                    if ($result)
                    {
                        $result = $this->allowField(true)->save(request()->param(),['history_post_id'=>request()->param('history_post_id'),'history_author_id'=>request()->param('history_author_id')]);
                    }else {
                        $result = $this->allowField(true)->save(request()->param());
                    }

                    if ($result)
                    {
                        return ['status'=>200,'type'=>1]; //历史记录
                    }else{
                        return ['status'=>101,'msg'=>$this->getError()];
                    }
                }
            }else{
                return ['status'=>101,'msg'=>'参数错误'];
            }

        }else{
            return ['status'=>103,'msg'=>'错误的请求方式'];
        }


    }

    //获取我的历史列表
    public function apiGetMyHistories()
    {
        if (request()->isPost())
        {
            if (request()->param('history_author_id'))
            {
                $result = db('history')
                    ->order('sendtime')
                    ->alias('h')
                    ->join('__ARTICLE__ a','h.history_post_id=a.arc_id')->where(['a.is_recycle'=>2,'history_author_id'=>request()->param('history_author_id')])
                    ->field('a.arc_id,a.arc_title,a.arc_author,a.sendtime,a.arc_click,a.arc_thumb,a.arc_sort,h.history_id')->paginate(10);
                if ($result)
                {
                    return ['status'=>200,'result'=>$result];
                }else{
                    return ['status'=>101, $this->getError()];
                }
            }else{
                return ['status'=>101,'msg'=>'参数错误'];
            }
        }else{
            return ['status'=>103,'msg'=>'错误的请求方式'];
        }
    }

    //查询历史
    public function find()
    {
//        return request()->param();
        $result = $this->where(['history_post_id'=>request()->param('history_post_id'),'history_author_id'=>request()->param('history_author_id')])->find();
        return $result;
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
