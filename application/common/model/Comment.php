<?php

namespace app\common\model;

use think\Model;

class Comment extends Model
{
    protected $pk = 'comment_id';
    protected $table = 'news_comments';
    protected $insert = ['commentdate','commentdategmt','commentauthorip','commentagent'];
    protected function setCommentDateAttr()
    {
        return time();
    }
    protected function setCommentDateGmtAttr()
    {
        return date('Y-m-d H:i:s',time());
    }
    protected function setCommentAuthorIpAttr()
    {
        return $this->getclientip();
    }
    protected function setCommentAgentAttr()
    {
        return $_SERVER['HTTP_USER_AGENT'];
    }

    /**
     * 用户评论
     */
    public function apiComment()
    {
        if (request()->isPost())
        {
            //return request()->param();exit;
            if (request()->param('comment_post_id')&&request()->param('comment_author')&&request()->param('comment_author_id')&&request()->param('comment_content')){
                $result = $this->allowField(true)->save(request()->param());
                if ($result)
                {
                    return ['status'=>200,'result'=>$this];
                }else{
                    return ['status'=>101,'msg'=>(new User())->getError()];
                }
            }else{
                return ['status'=>101,'msg'=>'参数错误'];
            }
        }else{
            return ['status'=>103,'mst'=>'服务器异常'];
        }
    }

    /**
     * 获取评论列表
     */
    public function apiGetComments()
    {
        if (request()->isPost())
        {
            if (request()->param('comment_post_id')&&request()->param('comment_type'))
            {
                //return request()->param();exit;
                $result = $this->order('comment_id desc')
                    ->alias('c')
                    ->join('__USER__ u','c.comment_author_id=u.user_id')
                    ->where(['comment_post_id'=>request()->param('comment_post_id'),'comment_type'=>request()->param('comment_type')])
                    ->paginate(10);
                return ['status'=>200,'result'=>$result];
            }else{
                return ['status'=>101,'msg'=>'参数错误'];
            }
        }else{
            return ['status'=>103,'msg'=>'服务器异常'];
        }
    }

    /**
     * 获取我的评论列表
     */

    public function apiGetMyComments()
    {
        if (request()->isPost())
        {
            if (request()->param('comment_author_id'))
            {
                $result = db('comments')
                    ->order('comment_id desc, commentdate desc')
                    ->alias('c')
                    ->join('__ARTICLE__ a','c.comment_post_id=a.arc_id')
                    ->join('__USER__ u','c.comment_author_id=u.user_id')
                    ->where(['a.is_recycle'=>2,'c.comment_author_id'=>request()->param('comment_author_id')])
                    ->field('a.arc_id,a.arc_title,a.arc_author,a.sendtime,a.arc_click,a.arc_thumb,a.arc_sort,c.comment_id,c.commentdate,c.commentdategmt,c.comment_content,c.comment_author,u.avatar')->paginate(10);
                if ($result)
                {
                    return ['status'=>200,'result'=>$result];
                }else{
                    return ['status'=>200,'msg'=>$this->getError()];
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
