<?php

namespace app\common\model;

use think\Model;

class Collection extends Model
{
    protected $pk = 'collection_id';
    protected $table = 'news_collection';
    protected $insert = ['collectiondate','collectiondategmt','collectionauthorip','collectionagent'];
    protected function setCollectionDateAttr()
    {
        return time();
    }
    protected function setCollectionDateGmtAttr()
    {
        return date('Y-m-d H:i:m',time());
    }
    protected function setCollectionAuthorIpAttr()
    {
        return $this->getclientip();
    }
    protected function setCollectionAgentAttr()
    {
        return $_SERVER['HTTP_USER_AGENT'];
    }

    //收藏/取消收藏
    public function apiCollection()
    {
        if (request()->isPost())
        {
            if (request()->param('collection_post_id')&&request()->param('collection_author_id')&&request()->param('collection_author')&&request()->param('collection_type'))
            {
                //取消收藏
                if (request()->param('action') == 'cancel')
                {
                    $result = $this->where(['collection_post_id'=>request()->param('collection_post_id'),'collection_author_id'=>request()->param('collection_author_id')])->delete();
                    if ($result)
                    {
                        return ['status'=>200,'type'=>0]; //取消收藏
                    }else{
                        return ['status'=>101,'msg'=>$this->getError()];
                    }
                } else {
                    $result = $this->allowField(true)->save(request()->param());
                    if ($result)
                    {
                        return ['status'=>200,'type'=>1]; //收藏
                    }else{
                        return ['status'=>101,'msg'=>$this->getError()];
                    }
                }
            }else{
                return ['status'=>101,'msg'=>'参数错误'];
            }

        }else{
            return ['status'=>103,'msg'=>'服务器异常'];
        }


    }

    //是否收藏
    public function apiIsCollection()
    {
        if (request()->isPost())
        {
            if (request()->param('collection_post_id')&&request()->param('collection_type')&&request()->param('collection_author_id'))
            {
                $result = $this->where(['collection_post_id'=>request()->param('collection_post_id'),'collection_type'=>request()->param('collection_type'),'collection_author_id'=>request()->param('collection_author_id')])->find();
                if ($result)
                {
                    return['status'=>200,'type'=>1]; //已收藏
                }else{
                    return['status'=>200,'type'=>0]; //未收藏
                }

            }else{
                return ['status'=>101,'msg'=>'参数错误'];
            }

        }else{
            return ['status'=>103,'msg'=>'服务器异常'];
        }
    }
    //获取收藏列表
    public function apiGetCollection()
    {
        if (request()->isPost())
        {
            if (request()->param('collection_author_id'))
            {
                $result = db('collection')
                    ->order('collection_id desc')
                    ->alias('c')
                    ->join('__ARTICLE__ a','c.collection_post_id=a.arc_id')->where(['a.is_recycle'=>2,'collection_author_id'=>request()->param('collection_author_id')])
                    ->field('a.arc_id,a.arc_title,a.arc_author,a.sendtime,a.arc_click,a.arc_thumb,a.arc_sort,c.collection_id')->paginate(10);
                if ($result)
                {
                    return ['status'=>200,'result'=>$result];
                }else{
                    return ['status'=>101,'msg'=>$this->getError()];
                }
            }else{
                return ['status'=>101,'msg'=>'参数错误'];
            }
        }else{
            return ['status'=>103,'msg'=>'服务器异常'];
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
