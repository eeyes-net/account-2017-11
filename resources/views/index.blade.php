<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="/css/index.css" rel="stylesheet">
</head>

<body>
    <div class="site-wrapper">
        <div class="site-wrapper-inner">
            <div class="cover-container">
                <div class="masthead clearfix">
                    <div class="inner">
                        <h3 class="masthead-brand">
                            <a href="https://www.eeyes.net/" target="_blank">
                                <img class="brand-eeyes-logo" src="//img.eeyes.net/eeyes_common/images/eeyes_logo_white_text.gif" alt="eeyes logo">
                            </a>
                        </h3>
                        <nav>
                            <ul class="nav masthead-nav">
                                @if (auth()->check())
                                    <li><a href="/home">个人中心</a></li>
                                    <li><a href="/logout">退出登录</a></li>
                                @else
                                    <li><a href="/login">CAS登录</a></li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                </div>

                <div class="inner cover">
                    <h1 class="cover-heading">{{ config('app.name', 'Laravel') }}</h1>
                    <p class="lead">
                        为您在e瞳浏览提供统一的信息服务<br>
                        保护您在e瞳的数据安全可靠<br>
                        将自己开发的应用接入e瞳API
                    </p>
                    <p class="lead">
                        @if(auth()->check())
                            <a href="/home" class="btn btn-default">进入个人中心</a>
                        @else
                            <a href="/login" class="btn btn-default">使用CAS登录</a>
                        @endif
                    </p>
                </div>

                <div class="mastfoot">
                    <div class="inner">
                        <p>精彩有e瞳，美妙无异同</p>
                        <p>
                            <span class="text-inline-block">Copyright©2017 <a href="https://www.eeyes.net/">eeYes.net</a></span>
                            <span class="text-inline-block">All Rights Reserved</span>
                            <span class="text-inline-block">陕ICP备030061号</span>
                            <span class="text-inline-block">GitHub: <a href="https://github.com/eeyes-net">@eeyes-net</a></span>
                        </p>
                        <p style="display: none;">Cover template for <a href="http://getbootstrap.com">Bootstrap</a>, by <a href="https://twitter.com/mdo">@mdo</a>.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
