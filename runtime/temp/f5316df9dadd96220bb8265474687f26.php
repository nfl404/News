<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:80:"/Users/huadiwenhua/Desktop/News/public/../application/web/view/audio/player.html";i:1502763237;}*/ ?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>jQuery流媒体音乐播放器特效</title>
    <meta name="viewpoint" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
    <link rel="stylesheet" type="text/css" href="__STATIC__/web/css/main.css">

</head>
<body>
<div class='jAudio--player'>

    <audio></audio>

    <div class='jAudio--ui'>

        <div class='jAudio--thumb'></div>

        <div class='jAudio--status-bar'>

            <div class='jAudio--details'></div>
            <div class='jAudio--volume-bar'></div>

            <div class='jAudio--progress-bar'>
                <div class='jAudio--progress-bar-wrapper'>
                    <div class='jAudio--progress-bar-played'>
                        <span class='jAudio--progress-bar-pointer'></span>
                    </div>
                </div>
            </div>

            <div class='jAudio--time'>
                <span class='jAudio--time-elapsed'>00:00</span>
                <span class='jAudio--time-total'>00:00</span>
            </div>

        </div>

    </div>


    <div class='jAudio--playlist'>
    </div>

    <div class='jAudio--controls'>
        <ul>
            <li><button class='btn' data-action='prev' id='btn-prev'><span></span></button></li>
            <li><button class='btn' data-action='play' id='btn-play'><span></span></button></li>
            <li><button class='btn' data-action='next' id='btn-next'><span></span></button></li>
        </ul>
    </div>

</div>

<script src='__STATIC__/web/js/jquery-2.1.4.min.js'></script>
<script src='__STATIC__/web/js/jaudio.js'></script>
<script>
    var t = {
        playlist:[
            {
                file: "http://10.0.0.81:8888/uploads/20170814/c72074a7d873d8c7a6be2c1322cb4ee3.mp3",
                thumb: "http://10.0.0.81:8888/uploads/20170803/cc70dd717c8c581325b65afc9ab044d6.png",
                trackName: "Dusk",
                trackArtist: "Tobu & Syndec",
                trackAlbum: "Single",
            },
            {
                file: "http://10.0.0.81:8888/uploads/20170814/c72074a7d873d8c7a6be2c1322cb4ee3.mp3",
                thumb: "http://10.0.0.81:8888/uploads/20170803/cc70dd717c8c581325b65afc9ab044d6.png",
                trackName: "Blank",
                trackArtist: "Disfigure",
                trackAlbum: "Single",
            },
            {
                file: "http://10.0.0.81:8888/uploads/20170814/c72074a7d873d8c7a6be2c1322cb4ee3.mp3",
                thumb: "http://10.0.0.81:8888/uploads/20170803/cc70dd717c8c581325b65afc9ab044d6.png",
                trackName: "Fade",
                trackArtist: "Alan Walker",
                trackAlbum: "Single",
            },
            {
                file: "http://10.0.0.81:8888/uploads/20170814/c72074a7d873d8c7a6be2c1322cb4ee3.mp3",
                thumb: "http://10.0.0.81:8888/uploads/20170803/cc70dd717c8c581325b65afc9ab044d6.png",
                trackName: "Dusk",
                trackArtist: "Tobu & Syndec",
                trackAlbum: "Single",
            },
            {
                file: "http://10.0.0.81:8888/uploads/20170814/c72074a7d873d8c7a6be2c1322cb4ee3.mp3",
                thumb: "http://10.0.0.81:8888/uploads/20170803/cc70dd717c8c581325b65afc9ab044d6.png",
                trackName: "Blank",
                trackArtist: "Disfigure",
                trackAlbum: "Single",
            },
            {
                file: "http://10.0.0.81:8888/uploads/20170814/c72074a7d873d8c7a6be2c1322cb4ee3.mp3",
                thumb: "http://10.0.0.81:8888/uploads/20170803/cc70dd717c8c581325b65afc9ab044d6.png",
                trackName: "Fade",
                trackArtist: "Alan Walker",
                trackAlbum: "Single",
            }
        ],
        autoPlay:false
    }

    $(".jAudio--player").jAudio(t);
</script>

</body>
</html>