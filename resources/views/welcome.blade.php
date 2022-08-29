<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="typesheet" href="/css/main.css">
    <title>Laravel</title>
</head>

<body>
    <div class="top-bar">
        <div class="container"> <a href="/"> <img class="top-bar-logo" src="//static.fanfox.net/v202020210123121/mangafox/images/logo.png"> </a>
            <div class="top-bar-list"> <a class="active" href="/">Home</a> <a href="/releases/">Lastest Updates</a> <a href="/ranking/">Ranking</a> <a href="/directory/">Browse</a> </div>
            <div class="top-bar-avatar-con"> <a href="/login/?from=%2f"> <img class="top-bar-avatar-img" src="//static.fanfox.net/v202020210123121/mangafox/images/top-bar-avatar-img.png "> </a> </div>
            <div class="top-bar-right-list">
                <form id="searchform" action="/search" method="get" style="display: inline;"><input class="person-main-right-sortBar-input" name="title" type="text" id="fastsearch" placeholder="Search Manga"></form> <a href="javascript:void(0);" class="fastsearchbt" style="margin-left: -50px;padding-bottom: 5px;"></a> <a class="top-bar-right-list-2" target="_blank" href="http://www.mangazoneapp.com/">Get the App</a> <span class="top-bar-right-list-3-con"> <a class="top-bar-right-list-3" href="/comichistory/">History</a> </span>
            </div>
        </div>
    </div>
</body>

</html>