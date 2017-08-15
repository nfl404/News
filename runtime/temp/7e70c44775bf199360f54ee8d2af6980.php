<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:82:"/Users/huadiwenhua/Desktop/News/public/../application/web/view/article/detail.html";i:1502784951;}*/ ?>
<!DOCTYPE html>
<html lang="en" style="font-size: 124.4px">
<head>
    <meta charset="UTF-8">
    <title><?php echo $field['arc_title']; ?></title>
    <style>
        html {
            background: #eee;
        }

        body, div, span, object, iframe, h1, h2, h3, h4, h5, h6, p, blockquote, a, code, em, img, q, small, strong, dd, dl, dt, li, ol, ul, fieldset, form, label, table, tbody, tr, th, td, input {
            margin: 0;
            padding: 0;
            border: 0;
        }
        div {
            display: block;
        }
        body {
            font-size: 32px;
            font-size: .32rem;
            max-width: 1080px;
            margin: 0 auto;
            background: #f6f6f6;
            font-family: 'STHeiti', 'Microsoft YaHei', Helvetica, Arial, sans-serif;
            -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
        }
        body{
            width: 7.5rem;
            min-height: 13.34rem;
            background-color: #eee;
        }
        main {
            border: 0;
            border-bottom-color: #FFF;
            border-image-width: 0;
            display: block;
        }
        article{
            padding: 0 .3rem .4rem .3rem;
            border-bottom:1px solid #e6e6e6;
            background-color: #f6f6f6;
            display: block;
        }
        article .head{
            font-weight: normal;
            padding: .54rem 0 0 0;
            margin: 0;
            border: 0;
        }
        article .head .title{
            font-size: .46rem;
            font-weight: bold;
            padding: 0 0 .2rem 0;
            color: #404040;
        }
        article .head .info {
            font-size: .28rem;
            font-weight: normal;
            margin: 0 0 .12rem 0;
            color: #888;
        }
        article .head .source {
            padding-left: .2rem;
        }
        article .head .click {
            padding-left: .2rem;
        }


        article .content {
            font-size: .36rem;
            line-height: 1.5em;
            word-break: break-all;
            color: #404040;
        }
    </style>
</head>
<body>

    <main>
        <!--文章内容-->
        <article>
            <div class="head">
                <h1 class="title"><?php echo $field['arc_title']; ?></h1>
                <div class="info">
                    <span class="time js-time"><?php echo date('Y-m-d h:i',$field['sendtime']); ?></span>
                    <span class="source js-source"><?php echo $field['arc_author']; ?></span>
                    <span class="click js-source">阅读<?php echo $field['arc_click']; ?>次</span>
                </div>
            </div>
            <hr style="margin: .2rem 0 0 0">
            <div class="content">
                <div class="page js-page on"></div>
                <div class="page js-page"></div>
                <?php echo $field['arc_content']; ?>
            </div>
        </article>

    </main>
</body>
</html>