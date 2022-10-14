<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/css/main.css?ver=2.01">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="{{$seo_data['index'] ?? ''}}">
    <title>{{$seo_data['meta_title'] ?? ''}}</title>
    @if(!empty($seo_data['meta_keyword']))
        <meta name="keywords" content="{{$seo_data['meta_keyword']}}">
    @endif
    <meta name="description" content="{{$seo_data['meta_description'] ?? getSiteSetting('site_description')}}">
    <link rel="canonical" href="{{$seo_data['canonical'] ?? ''}}" />
    <meta property="og:title" content="{{$seo_data['meta_title'] ?? ''}}">
    @if(!empty($seo_data['site_image']))
        <meta property="og:image" content="{{$seo_data['site_image']}}">
    @endif
    <meta property="og:url" content="{{url()->current()}}">
    <meta property="og:type" content="{{getCurrentController() == 'post' ? 'article' : 'website'}}">
    <meta property="og:site_name" content="forextradingvn.top">
    <meta property="og:description" content="{{$seo_data['meta_description'] ?? ''}}">
    @if(!empty($seo_data['published_time']))
        <meta property="article:published_time" content="{{$seo_data['published_time']}}" />
    @endif
    @if(!empty($seo_data['modified_time']))
        <meta property="article:modified_time" content="{{$seo_data['modified_time']}}" />
    @endif
    @if(!empty($seo_data['updated_time']))
        <meta property="article:updated_time" content="{{$seo_data['updated_time']}}" />
    @endif

    <meta name="twitter:card" content="summary" />
    <meta name="twitter:title" content="{{$seo_data['meta_title'] ?? ''}}" />
    <meta name="twitter:description" content="{{$seo_data['meta_description'] ?? getSiteSetting('site_description')}}" />
    <meta name="twitter:site" content="@fxtradingvn" />
    <meta name="twitter:url" content="{{$seo_data['twitter_url'] ?? 'https://forextradingvn.top/'}}" />
    @if(!empty($seo_data['site_image']))
        <meta name="twitter:image" content="{{url($seo_data['site_image'])}}" />
    @endif
    @if(!empty($seo_data['amphtml']))
        <link rel="amphtml" href="{{$seo_data['amphtml']}}">
    @endif

    <link rel="shortcut icon" href="{{url('images/favicon.png')}}" />
    <link rel="apple-touch-icon" href="{{url('images/favicon.png')}}" />
    
	<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

	@if(!empty($schema))
		{!!$schema!!}
	@endif
</head>

<body>

  @include('web._header')
  <div class="main">
    @yield('main')
  </div>
  <img src="img/to-top.png" class="img-back-to-top d-sm-none d-md-none d-lg-block d-none" width="200rem" class="img-fluid" alt="">
  
    <button
        type="button"
        class="btn btn-dark bg_secondary ve-center btn-floating btn-lg rounded-circle justify-content-center"
        id="btn-back-to-top"
        >
  <i class="icon-arrow-up2 fs-25 d-inline"></i>
</button>

  

<script>
  //Get the button
let mybutton = document.getElementById("btn-back-to-top");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function () {
  scrollFunction();
};

function scrollFunction() {
  if (
    document.body.scrollTop > 20 ||
    document.documentElement.scrollTop > 20
  ) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}
// When the user clicks on the button, scroll to the top of the document
mybutton.addEventListener("click", backToTop);

function backToTop() {
  document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
}
</script>

  @include('web._footer')
  <script src="/js/app.js?1"></script>
</body>

</html>