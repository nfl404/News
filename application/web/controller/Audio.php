<?php

namespace app\web\controller;

use think\Controller;

class Audio extends Controller
{
    //音乐播放器
    public function player()
    {
        return $this->fetch();
    }
}
