<?php
namespace app\api\validate;

use think\Validate;

class ValidateCode extends Validate
{
    protected $rule = [
      'cate_id'=>'require|number',
    ];

    protected $message = [
        'cate_id.require' => '参数错误',
        'care_id.number'=>'参数错误',
    ];
}