<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:80:"/Users/huadiwenhua/Desktop/News/public/../application/admin/view/video/edit.html";i:1502439603;s:74:"/Users/huadiwenhua/Desktop/News/public/../application/admin/view/base.html";i:1502421069;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>华地艺术品（上海）有限公司 - 艺术资讯网站后台管理系统</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link href="__STATIC__/admin/bootstrap-3.3.0-dist/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="__STATIC__/admin/css/site.css" rel="stylesheet">
    <link href="__STATIC__/admin/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="__STATIC__/admin/js/jquery.min.js"></script>
    <script src="__STATIC__/admin/bootstrap-3.3.0-dist/dist/js/bootstrap.min.js"></script>
    <!--<script src="resource/hdjs/app/util.js"></script>-->
    <!--<script src="resource/hdjs/require.js"></script>-->
    <!--<script src="resource/hdjs/app/config.js"></script>-->
    <!--[if lt IE 9]>
    <script src="http://cdn.bootcss.com/html5shiv/r29/html5.min.js"></script>
    <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script>
        if (navigator.appName == 'Microsoft Internet Explorer') {
            if (navigator.userAgent.indexOf("MSIE 5.0") > 0 || navigator.userAgent.indexOf("MSIE 6.0") > 0 || navigator.userAgent.indexOf("MSIE 7.0") > 0) {
                alert('您使用的 IE 浏览器版本过低, 推荐使用 Chrome 浏览器或 IE8 及以上版本浏览器.');
            }
        }
    </script>
    <style>
        i {
            color: #337ab7;
        }
    </style>
    <meta name="csrf-token" content="{{csrf_token()}}">
    <script>
        //模块配置项
        var hdjs = {
            //框架目录
            'base': '__STATIC__/node_modules/hdjs',
            //上传文件后台地址
            'uploader': "<?php echo url('system/component/uploader'); ?>",
            //获取文件列表的后台地址

            'filesLists': "<?php echo url('system/component/filesLists'); ?>?",
        };
    </script>
    <script src="__STATIC__/node_modules/hdjs/app/util.js"></script>
    <script src="__STATIC__/node_modules/hdjs/require.js"></script>
    <script src="__STATIC__/node_modules/hdjs/config.js"></script>
</head>
<body>
<div class="container-fluid admin-top">
    <!--导航-->
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <h4 style="display: inline;line-height: 50px;float: left;margin: 0px">
                    <img src="__STATIC__/images/logo.png" style="width: 50px; margin: 10px;float:left">
                    <a href="index.html" style="color: white;margin-left: 14px;margin-top: 10px ;float: left">华地艺术品（上海）有限公司 - 艺术资讯网站后台管理系统</a>
                </h4>
                <div class="navbar-header">
                    <ul class="nav navbar-nav">
                        <!--<li>-->
                        <!--<a href="http://www.kancloud.cn/manual/thinkphp5/118003" target="_blank"><i class="fa fa-w fa-file-code-o"></i>-->
                        <!--在线文档</a>-->
                        <!--</li>-->
                        <!--<li>-->
                        <!--<a href="http://fontawesome.dashgame.com/" target="_blank"><i-->
                        <!--class="fa fa-w fa-hand-o-right"></i> 图标库</a>-->
                        <!--</li>-->
                        <!--<li>-->
                        <!--<a href="http://bbs.houdunwang.com" target="_blank"><i class="fa fa-w fa-forumbee"></i> 论坛</a>-->
                        <!--</li>-->
                    </ul>
                </div>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">
                            <i class="fa fa-w fa-user"></i>
                            <?php echo session('admin.admin_username'); ?>
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo url('admin/entry/pass'); ?>">修改密码</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="javascript:" onclick="logOut()">退出</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!--导航end-->
</div>
<!--主体-->
<div class="container-fluid admin_menu">
    <div class="row">
        <div class="col-xs-12 col-sm-3 col-lg-2 left-menu">
            <div class="panel panel-default" id="menus">
                <!--栏目管理-->
                <div class="panel-heading" role="button" data-toggle="collapse" href="#collapseExample"
                     aria-expanded="false" aria-controls="collapseExample"
                     style="border-top: 1px solid #ddd;border-radius: 0%">
                    <h4 class="panel-title">栏目管理</h4>
                    <a class="panel-collapse" data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                        <i class="fa fa-chevron-circle-down"></i>
                    </a>
                </div>
                <ul class="list-group menus collapse in" id="collapseExample">
                    <a href="<?php echo url('admin/category/index'); ?>" class="list-group-item">
                        <i class="fa fa-institution " aria-hidden="true"></i>
                        <span class="pull-right" href=""></span>
                        栏目列表
                    </a>
                </ul>
                <!--栏目管理 end-->

                <!--标签管理-->
                <div class="panel-heading" role="button" data-toggle="collapse" href="#collapseExample2"
                     aria-expanded="false" aria-controls="collapseExample">
                    <h4 class="panel-title">标签管理</h4>
                    <a class="panel-collapse" data-toggle="collapse" href="#collapseExample2" aria-expanded="true">
                        <i class="fa fa-chevron-circle-down"></i>
                    </a>
                </div>
                <ul class="list-group menus collapse in" id="collapseExample2">
                    <a href="<?php echo url('admin/tag/index'); ?>" class="list-group-item">
                        <i class="fa fa-tags" aria-hidden="true"></i>
                        <span class="pull-right" href=""></span>
                        标签列表
                    </a>
                </ul>
                <!--标签管理 end-->

                <!--文章管理-->
                <div class="panel-heading" role="button" data-toggle="collapse" href="#collapseExample3"
                     aria-expanded="false" aria-controls="collapseExample">
                    <h4 class="panel-title">文章管理</h4>
                    <a class="panel-collapse" data-toggle="collapse" href="#collapseExample3" aria-expanded="true">
                        <i class="fa fa-chevron-circle-down"></i>
                    </a>
                </div>
                <ul class="list-group menus collapse in" id="collapseExample3">
                    <a href="<?php echo url('admin/article/index'); ?>" class="list-group-item">
                        <i class="fa fa-navicon" aria-hidden="true"></i>
                        <span class="pull-right" href=""></span>
                        文章列表
                    </a>
                    <a href="<?php echo url('admin/recycle/index'); ?>" class="list-group-item">
                        <i class="fa fa-bitbucket" aria-hidden="true"></i>
                        <span class="pull-right" href=""></span>
                        回收站
                    </a>
                </ul>
                <!--文章管理 end-->

                <!--视频管理-->
                <div class="panel-heading" role="button" data-toggle="collapse" href="#collapseExample6"
                     aria-expanded="false" aria-controls="collapseExample">
                    <h4 class="panel-title">视频管理</h4>
                    <a class="panel-collapse" data-toggle="collapse" href="#collapseExample6" aria-expanded="true">
                        <i class="fa fa-chevron-circle-down"></i>
                    </a>
                </div>
                <ul class="list-group menus collapse in" id="collapseExample6">
                    <a href="<?php echo url('admin/video/index'); ?>" class="list-group-item">
                        <i class="fa fa-indent" aria-hidden="true"></i>
                        <span class="pull-right" href=""></span>
                        视频列表
                    </a>
                    <a href="<?php echo url('admin/video/recycle'); ?>" class="list-group-item">
                        <i class="fa fa-bitbucket" aria-hidden="true"></i>
                        <span class="pull-right" href=""></span>
                        回收站
                    </a>
                </ul>
                <!--视频管理 end-->

                <!--音频管理-->
                <div class="panel-heading" role="button" data-toggle="collapse" href="#collapseExample7"
                     aria-expanded="false" aria-controls="collapseExample">
                    <h4 class="panel-title">音频管理</h4>
                    <a class="panel-collapse" data-toggle="collapse" href="#collapseExample7" aria-expanded="true">
                        <i class="fa fa-chevron-circle-down"></i>
                    </a>
                </div>
                <ul class="list-group menus collapse in" id="collapseExample7">
                    <a href="<?php echo url('admin/article/index'); ?>" class="list-group-item">
                        <i class="fa fa-list-ul" aria-hidden="true"></i>
                        <span class="pull-right" href=""></span>
                        音频列表
                    </a>
                    <a href="<?php echo url('admin/recycle/index'); ?>" class="list-group-item">
                        <i class="fa fa-bitbucket" aria-hidden="true"></i>
                        <span class="pull-right" href=""></span>
                        回收站
                    </a>
                </ul>
                <!--音频管理 end-->

                <!--友情链接管理-->
                <div class="panel-heading" role="button" data-toggle="collapse" href="#collapseExample4"
                     aria-expanded="false" aria-controls="collapseExample">
                    <h4 class="panel-title">友链管理</h4>
                    <a class="panel-collapse" data-toggle="collapse" href="#collapseExample4" aria-expanded="true">
                        <i class="fa fa-chevron-circle-down"></i>
                    </a>
                </div>
                <ul class="list-group menus collapse in" id="collapseExample4">
                    <a href="<?php echo url('admin/link/index'); ?>" class="list-group-item">
                        <i class="fa fa-paper-plane-o" aria-hidden="true"></i>
                        <span class="pull-right" href=""></span>
                        友链首页
                    </a>
                </ul>
                <!--友情链接管理 end-->

                <!--站点管理-->
                <div class="panel-heading" role="button" data-toggle="collapse" href="#collapseExample5"
                     aria-expanded="false" aria-controls="collapseExample">
                    <h4 class="panel-title">站点管理</h4>
                    <a class="panel-collapse" data-toggle="collapse" href="#collapseExample5" aria-expanded="true">
                        <i class="fa fa-chevron-circle-down"></i>
                    </a>
                </div>
                <ul class="list-group menus collapse in" id="collapseExample5">
                    <a href="<?php echo url('admin/website/index'); ?>" class="list-group-item">
                        <i class="fa fa-wrench" aria-hidden="true"></i>
                        <span class="pull-right" href=""></span>
                        网站配置
                    </a>
                </ul>
                <!--站点管理 end-->
            </div>
        </div>
        <!--右侧主体区域部分 start-->
        <div class="col-xs-12 col-sm-9 col-lg-10">
            
<ol class="breadcrumb" style="background-color: #f9f9f9;padding:8px 0;margin-bottom:10px;">
    <li>
        <a href=""><i class="fa fa-cogs"></i>
            视频管理</a>
    </li>
    <li class="active">
        <a href="">视频编辑</a>
    </li>
</ol>
<ul class="nav nav-tabs" role="tablist">
    <li><a href="<?php echo url('index'); ?>">视频管理</a></li>
    <li class="active"><a href="">视频编辑</a></li>
</ul>
<form class="form-horizontal" id="form"  action="" method="post">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">视频管理</h3>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label for="" class="col-sm-2 control-label">视频标题</label>
                <div class="col-sm-9">
                    <input type="text" name="video_title"  class="form-control" placeholder="视频标题" value="<?php echo $videoData['video_title']; ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-sm-2 control-label">上传作者</label>
                <div class="col-sm-9">
                    <input type="text" name="video_author"  class="form-control" placeholder="上传作者" value="<?php echo $videoData['video_author']; ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-sm-2 control-label">视频排序</label>
                <div class="col-sm-9">
                    <input type="number" name="video_sort"  class="form-control" placeholder="视频排序" value="<?php echo $videoData['video_sort']; ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-sm-2 control-label">所属分类</label>
                <div class="col-sm-9">
                    <select class="js-example-basic-single form-control" name="cate_id">
                        <option value="0">请选择分类</option>
                        <?php if(is_array($cateData) || $cateData instanceof \think\Collection || $cateData instanceof \think\Paginator): if( count($cateData)==0 ) : echo "" ;else: foreach($cateData as $key=>$vo): ?>
                        <option <?php if($videoData['cate_id']==$vo['cate_id']): ?>selected<?php endif; ?> value="<?php echo $vo['cate_id']; ?>"><?php echo $vo['_cate_name']; ?></option>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-sm-2 control-label">标签</label>
                <div class="col-sm-9">
                    <?php if(is_array($tagData) || $tagData instanceof \think\Collection || $tagData instanceof \think\Paginator): if( count($tagData)==0 ) : echo "" ;else: foreach($tagData as $key=>$vo): ?>
                    <label class="checkbox-inline">
                        <input type="checkbox" name="tag[]" value="<?php echo $vo['tag_id']; ?>" <?php if(is_array($arcTag) || $arcTag instanceof \think\Collection || $arcTag instanceof \think\Paginator): if( count($arcTag)==0 ) : echo "" ;else: foreach($arcTag as $key=>$v): if($v['vid_id']==$videoData['video_id']&$v['tag_id']==$vo['tag_id']): ?>checked="checked"<?php endif; endforeach; endif; else: echo "" ;endif; ?>> <?php echo $vo['tag_name']; ?>
                    </label>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-sm-2 control-label">缩略图</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <input type="text" class="form-control" name="video_thumb" readonly="" value="<?php echo $videoData['video_thumb']; ?>">
                        <div class="input-group-btn">
                            <button onclick="upImage(this)" class="btn btn-default" type="button">选择图片</button>
                        </div>
                    </div>
                    <div class="input-group" style="margin-top:5px;">
                        <img src="<?php echo $videoData['video_thumb']; ?>" class="img-responsive img-thumbnail" width="150">
                        <em class="close" style="position:absolute; top: 0px; right: -14px;" title="删除这张图片" onclick="removeImg(this)">×</em>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-sm-2 control-label">视频文件</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <input type="text" class="form-control" name="video_url" readonly="" value="<?php echo $videoData['video_url']; ?>">
                        <div class="input-group-btn">
                            <button onclick="upFile(this)" class="btn btn-default" type="button">选择文件</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-sm-2 control-label">视频摘要</label>
                <div class="col-sm-9">
                    <textarea type="text" name="video_digest"  class="form-control" placeholder="视频摘要"><?php echo $videoData['video_digest']; ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label for=""  class="col-sm-2 control-label">视频内容</label>
                <div class="col-sm-9">
                    <textarea id="container"name="video_content" style="height:300px;width:100%;"><?php echo $videoData['video_content']; ?></textarea>
                    <script>
                        util.ueditor('container', {hash:2,data:'hd'}, function (editor) {
                            //这是回调函数 editor是百度编辑器实例
                        });
                    </script>
                    <!--第二个参数为添加到数据表中字段，hash为确定上传文件标识（可以以用户编号，标识为此用户上传的文件，系统使用这个字段值来显示文件列表），data为数据表中的data字段值，开发者根据业务需要自行添加-->
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="video_id" value="<?php echo $videoData['video_id']; ?>">
    <button class="btn btn-primary" type="submit">确定</button>
</form>
<script>
    //上传图片
    function upImage(obj) {
        require(['util'], function (util) {
            options = {
                multiple: false,//是否允许多图上传
                //data是向后台服务器提交的POST数据
                data:{name:'老聂',year:2099},
            };
            util.image(function (images) {          //上传成功的图片，数组类型

                $("[name='video_thumb']").val(images[0]);
                $(".img-thumbnail").attr('src', images[0]);
            }, options)
        });
    }

    //移除图片
    function removeImg(obj) {
        $(obj).prev('img').attr('src', '__STATIC__/images/nopic.jpg');
        $(obj).parent().prev().find('input').val('');
    }
</script>
<script>
    //上传文件
    function upFile(obj) {
        require(['util'], function (util) {
            options = {
                extensions: 'mp4',
                //data是向后台服务器提交的POST数据
                data:{name:'老聂',year:2099},
                //单个文件允许为5MB
                fileSingleSizeLimit:20 * 1024 * 1024
            };
            util.file(function (files) {
                //上传成功的文件，数组类型
                console.log(files);
                $("[name='video_url']").val(files[0]);
            }, options)
        });
    }
</script>

        </div>
    </div>
    <!--右侧主体区域部分结束 end-->
</div>
</div>
<div class="master-footer" style="margin-top: 150px">
    <br>
    Powered by <a href="http://www.niefuling.com">老聂</a> v1.0 © 2017.7.31
</div>
<script>
    function logOut() {
        util.confirm('确定退出登陆吗？',function(){
            //执行成功
            location.href="<?php echo url('admin/entry/logOut'); ?>";
        })
    }
</script>
</body>
</html>
