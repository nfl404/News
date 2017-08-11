<?php

namespace app\api\controller;

use app\common\model\Article;
use app\common\model\Category;
use app\common\model\Video;
use think\Controller;

class news extends Controller
{
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

}
