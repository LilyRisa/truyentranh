<div class="col-lg-4 col-12">
    <div class="widget mt-3 rounded">
       <div class="widget-about data-bg-image text-center" data-bg-image="images/map-bg.png" style="background-image: url('images/map-bg.png');">
          <img src="/images/logo.png" alt="logo" class="mb-4" width="118" height="26"> 
          <p class="mb-4">{!! getSiteSetting('text_sidebar') !!}</p>
            <ul class="social-icons list-unstyled list-inline mb-0">
                <li class="list-inline-item"><a href="{{getSiteSetting('site_youtube')}}" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                <li class="list-inline-item"><a href="{{getSiteSetting('site_twitter')}}" target="_blank"><i class="fab fa-twitter"></i></a></li>
                <li class="list-inline-item"><a href="{{getSiteSetting('site_instagram')}}" target="_blank"><i class="fab fa-instagram"></i></a></li>
                {{-- <li class="list-inline-item"><a href="#"><i class="fab fa-pinterest"></i></a></li>
                <li class="list-inline-item"><a href="#"><i class="fab fa-medium"></i></a></li> --}}
                <li class="list-inline-item"><a href="{{getSiteSetting('site_youtube')}}" target="_blank"><i class="fab fa-youtube"></i></a></li>
            </ul>
       </div>
    </div>
    <div class="widget rounded mt-5">
       <div class="widget-header text-center">
          <h3 class="widget-title">Bài viết được bình chọn</h3>
          <img src="/images/wave.svg" class="wave" alt="wave" width="36" height="6"> 
       </div>
       <div class="widget-content">
        @if(!empty($post_rate_highest))
            @foreach($post_rate_highest as $h_p)
            <div class="post post-list-sm d-flex circle">
                <div class="thumb col-3 circle">
                    <a href="{{getUrlPost($h_p)}}">
                    <div class="inner"> 
                        {!! genImage($h_p->thumbnail, 60, 60, 'img-fluid rounded-circle', $h_p->title) !!}
                    </div>
                    </a>
                </div>
                <div class="details col-9 ps-2 clearfix">
                    <h6 class="post-title my-0">
                    <a href="{{getUrlPost($h_p)}}" class="fs-15 text-decoration-none text-dark">{{$h_p->title}}</a>
                    </h6>
                    <ul class="meta list-inline mt-1 mb-0">
                    <li class="list-inline-item">{{convertDateTime($h_p->displayed_time)}}</li>
                    </ul>
                </div>
            </div>
          @endforeach
        @else
            Đang cập nhật
        @endif
       </div>
    </div>
    <div class="widget rounded">
       <div class="widget-header text-center">
          <h3 class="widget-title">Khám phá chủ đề tin tức</h3>
          <img src="/images/wave.svg" class="wave" alt="wave" width="36" height="6"> 
       </div>
       <div class="widget-content">
            <ul class="list">
                @foreach($categoryTree as $value)
                <li {{ strpos($value['title'], '---') === false ? '' : 'class=ps-4' }}><a href="{{ getUrlCate((object) $value) }}">{!! str_replace('---', "<span class='mx-2'></span>", $value['title']) !!}</a><span>({{$value['count']}})</span></li>
                @endforeach
            </ul>
       </div>
    </div>
    <div class="d-none d-lg-block widget rounded">
       <div class="widget-header text-center">
          <h3 class="widget-title">Tag phổ biến</h3>
          <img src="/images/wave.svg" class="wave" alt="wave" width="36" height="6"> 
       </div>
       <div class="widget-content"> <a href="https://forextradingvn.top/treding-t1" class="tag">#Treding</a> </div>
    </div>
 </div>