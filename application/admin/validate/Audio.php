<?php

namespace app\admin\validate;

use think\Validate;

class Audio extends Validate
{
    protected $rule = [
        'audio_title' => 'require',
        'audio_author' => 'require',
        'audio_sort' => 'require|between:1,999',
        'cate_id' => 'notIn:0',
        'audio_thumb' => 'require',
        'audio_url' => 'require',
        'audio_digest' => 'require',
        'audio_content' => 'require',
    ];
    protected $message = [
        'audio_title.require' => '请输入音频标题',
        'audio_author.require' => '请输入音频上传作者',
        'audio_sort.require' => '请输入音频排序',
        'audio_sort.between' => '音频排序需要1-999之间',
        'cate_id.notIn' => '请选择音频所属分类',
        'audio_thumb.require' => '请音频缩略图',
        'audio_url.require' => '请选择音频文件',
        'audio_digest.require' => '请输入音频摘要',
        'audio_content.require' => '请输入音频内容',
    ];
}