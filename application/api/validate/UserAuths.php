<?php
namespace app\api\validate;

use think\Validate;

class UserAuths extends Validate
{
    protected $rul = [
        'nickname'=> 'require',
        'avatar'=>'require',
        'gender'=>'require',
        'city'=>'require',
        'province'=>''
    ];

    protected $message = [
        'nickname.require'=>'没有用户昵称',
        'avatar.require'=>'没有用户头像',
        'gender.require'=>'没有用户性别',
        'city.require'=>'没有城市',
        'province.require'=>'没有所在省份'
    ];
}