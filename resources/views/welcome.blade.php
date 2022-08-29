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
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Dropdown
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
        </li>
      </ul>
      <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>
</body>

</html>