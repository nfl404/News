<?php

namespace app\admin\validate;
use think\Validate;

class Video extends Validate
{
    protected $rule = [
        'video_title'=>'require',
        'video_author'=>'require',
        'video_sort'=>'require|between:1,999',
        'cate_id'=>'notIn:0',
        'video_thumb'=>'require',
        'video_url'=>'require',
        'video_digest'=>'require',
        'video_content'=>'require',
    ];
    protected $message = [
        'video_title.require'=>'请输入视频标题',
        'video_author.require'=>'请输入视频上传作者',
        'video_sort.require'=>'请输入视频排序',
        'video_sort.between'=>'视频排序需要1-999之间',
        'cate_id.notIn'=>'请选择视频所属分类',
        'video_thumb.require'=>'请视频缩略图',
        'video_url.require'=>'请选择视频文件',
        'video_digest.require'=>'请输入视频摘要',
        'video_content.require'=>'请输入视频内容',
    ];
}