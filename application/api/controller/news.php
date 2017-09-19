<?php

namespace app\api\controller;

use app\common\model\Article;
use app\common\model\Audio;
use app\common\model\Category;
use app\common\model\Collection;
use app\common\model\Comment;
use app\common\model\History;
use app\common\model\Message;
use app\common\model\Relation;
use app\common\model\User;
use app\common\model\UserAuth;
use app\common\model\Video;
use think\Controller;

class news extends Controller
{
    /***文章******／
    /**
     * 文章分类
     */
    public function arc_cate()
    {
        $result = (new Category())->apiGetCate();
        exit(json_encode($result));
    }

    /**
     * 文章列表
     */
    public function arc_list()
    {
        $result = (new Article())->apiGetArcList(request()->param('cate_id'),request()->param('page'));
        exit(json_encode($result));
    }

    /**
     * 文章详情
     */
    public function arc_detail()
    {
        $result = (new Article())->apiGetArcDetail(request()->param('article_id'));
        exit(json_encode($result));
    }
    /**
     * 文章搜索
     */
    public function arc_search()
    {
        $result = (new Article())->apiGetArcSearch();
        exit(json_encode($result));
    }

    /***视频******／
    /**
     * 视频分类
     */
    public function vid_cate()
    {
        $result = (new Category())->apiGetCate();
        exit(json_encode($result));
    }
    /**
     * 视频列表
     */
    public function vid_list()
    {
        $result = (new Video())->apiGetVidList(request()->param('cate_id'),request()->param('page'));
        exit(json_encode($result));
    }
    /**
     * 视频详情
     */
    public function vid_detail()
    {
        $result = (new Video())->apiGetVidDetail(request()->param('video_id'));
        exit(json_encode($result));
    }


    /***音频******／
    /**
     * 音频分类
     */
    public function aud_cate()
    {
        $result = (new Category())->apiGetCate();
        exit(json_encode($result));
    }
    /**
     * 音频列表
     */
    public function aud_list()
    {
        $result = (new Audio())->apiGetAudList(request()->param('cate_id'),request()->param('page'));
        exit(json_encode($result));
    }
    /**
     * 音频详情
     */
    public function aud_detail()
    {
        $result = (new Audio())->apiGetAudDetail(request()->param('audio_id'));
        exit(json_encode($result));
    }

    /****登录/授权*****/
    /**
     * 授权
     */
    public function user_auth()
    {
        $result = (new UserAuth())->apiSetUserAuth();
        exit(json_encode($result));
    }
    /**
     * 获取用户信息登录
     */
    public function user_info()
    {
        $result = (new User())->apiGetUserInfo();
        exit(json_encode($result));
    }

    /****评论*****/
    /**
     * 评论
     */
    public function comment()
    {
        $result = (new Comment())->apiComment();
        exit(json_encode($result));
    }

    /**
     * 获取文章/音频/视频评论
     */
    public function get_comments()
    {
        $result = (new Comment())->apiGetComments();
        exit(json_encode($result));
    }

    /**
     * 获取用户评论
     */
    public function get_my_comments()
    {
        $result = (new Comment())->apiGetMyComments();
        exit(json_encode($result));
    }

    /****收藏*****/
    /**
     * 收藏/取消收藏
     */

    public function collection()
    {
        $result = (new Collection())->apiCollection();
        exit(json_encode($result));
    }

    /**
     * 是否收藏
     */
    public function is_collection()
    {
        $result = (new Collection())->apiIsCollection();
        exit(json_encode($result));
    }

    /**
     * 我的收藏列表
     */
    public function get_collections()
    {
        $result = (new Collection())->apiGetCollection();
        exit(json_encode($result));
    }

    /****历史记录*****/
    /**
     * 历史/删除历史记录
     */
    public function history()
    {
        $result = (new History())->apiHistory();
        exit(json_encode($result));
    }

    /**
     * 我的历史记录
     */
    public function get_my_histories()
    {
        $result = (new History())->apiGetMyHistories();
        exit(json_encode($result));
    }

    /****关注记录*****/
    /**
     * 关注/取消关注
     */
    public function relation()
    {
        $result = (new Relation())->apiRelation();
        exit(json_encode($result));
    }

    /**
     * 关注用户的最新动态
     */
    public function get_my_relations()
    {
        $result = (new Relation())->apiGetRelations();
        exit(json_encode($result));
    }

    /**
     * 我的关注用户
     */
    public function get_my_follows()
    {
        $result = (new Relation())->apiGetMyFollows();
        exit(json_encode($result));
    }

    /**
     * 我的粉丝
     */
    public function get_my_followers()
    {
        $result = (new Relation())->apiGetMyFollowers();
        exit(json_encode($result));
    }

    /****消息*****/
    /**
     * 我的消息
     */
    public function get_my_messages()
    {
        $result = (new Message())->apiGetMyMessages();
        exit(json_encode($result));
    }



}
