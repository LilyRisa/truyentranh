@extends('web.layout')
@section('main')
    <div>
        <div id="carouselExampleControls" class="carousel slide d-none d-lg-block" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="/images/banner.webp" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="/images/banner.webp" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="/images/banner.webp" class="d-block w-100" alt="...">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        <div
            class="position-absolute absolute-center justify-content-center cate-bar bg_secondary w-75 d-none d-lg-block d-flex rounded">
            
            <ul class="text-center mt-3 d-flex justify-content-center align-items-center">
                @if(!empty($menu_home))
                    @foreach($menu_home as $item)
                    <li class="list-inline-item text-uppercase ms-3"><a class="text-decoration-none text-white fw-bold"
                            href="{{$item->url}}">{{$item->name}}</a></li>
                    @endforeach  
                @endif
                <li class="list-inline-item ms-3 ms-auto me-3">
                    <button class="btn bg-white all-button text-uppercase text_secondary fw-bold">all manga</button>
                </li>
            </ul>
           

        </div>
    </div>


    <div class="main container-lg">
        {{-- section1 --}}

        <div class="section-1 mt-5 row">

            <div class="col-lg-9">
                <div class="d-flex p-0 rounded">
                <p class="fs-22 text-uppercase fw-bold">
                    truyện hot!
                </p>
                <a class="ms-auto text-decoration-none" href="#">
                <p class="text_secondary fs-16 fw-bold">
                    xem thêm >>
                </p>
                </a>
                </div>
                <div class="row justify-content-between mt-am-2">
                    @if(!empty($category_h))
                    @foreach($category_h as $vh)
            
                        <div class="col-lg-3 mt-2 col-6">
                            <div class="card p-0 ml-2">
                                {!! genImage($vh->thumbnail, 225, 330, 'img-fluid', $vh->title) !!}
                                <div class="card-body dark-linear position-absolute fixed-bottom">
                                    <a href="{{getUrlStory($vh)}}" class="d-none d-lg-block p-0 m-0 text-white border-bottom fw-bold" title="{{$vh->title}}">{{$vh->title}}</a>
                                    <a href="{{getUrlCate($vh->categories[0])}}" class="d-block p-0 m-0 text-info" title="{{$vh->categories[0]->title}}">{{$vh->categories[0]->title}}</a>
                                    <p class="p-0 m-0 text-grey1 d-flex align-items-center"><i class="icon-eye pe-1"></i> Lượt xem: {{$vh->view_count}}</p>
                                </div>
                            </div>
                        </div>


                        @endforeach
                    @endif
                </div>
            </div>
            

            <div class="col-lg-3 mt-5 mt-lg-0">
                <div class="ms-2 d-flex">
                    <p class="fs-22 fw-bold">
                        BXH
                    </p>
                    <div class="ms-auto pe-0">
                    <a class="text-end text_secondary text-decoration-none fs-18 fw-bold" href="#">
                        xem thêm >>
                    </div>
                    </a>
                    </div>

                <div class="pt-1">
                    @if(!empty($view_hight))
                    @foreach ($view_hight as $k => $v)
                        <div class="ms-2 mt-2 pb-2 border-bottom d-flex d-nowrap">
                            <div class="col-1 p-0">
                                <p
                                    class="text-start {{ ($k+1) == 1 ? 'text-danger' : ( ($k+1) == 2 ? 'text-success' : ( ($k+1) == 3 ? 'text-primary' : 'text-secondary')) }} ">
                                    {{ ($k+1) }}</p>
                            </div>
                            
                            <div class="col-3">{!! genImage($v->thumbnail, 225, 330, 'img-fluid ps-2 w-100', $v->title) !!}</div>
                            <div class="col-8">
                                <a href="{{getUrlStory($v)}}" title="{{$v->title}}" class="d-block m-0 p-0 ps-2 max-line-2">{{$v->title}}</a>
                                <div class="col-9 fs-12 ps-2 text-grey1">{{$v->author}}</div>
                                <div class="row mt-1 ms-0">

                                    <div class="col-9 fs-12 ps-2">{{$v->is_update}}</div>
                                    <div class="col-3 text-end fs-12 fst-italic d-flex"><i class="icon-eye pt-1"></i><p class="ms-1"> {{$v->view_count}}</p></div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @endif
                </div>
            </div>
            
        </div>
{{-- end-section1 --}}
        <div class="section-2 mt-5">
            
                
            

            <div class="ms-2 d-flex">
                <p class="fs-22 text-uppercase fw-bold">
                    truyện đề cử!
                </p>
                <div class="ms-auto pe-0">
                <a class="text-end text_secondary text-decoration-none fs-18 fw-bold" href="#">
                    xem thêm >>
                </div>
                </a>
                </div>
            <div class="row" >
                @if(!empty($story_feature))
                @foreach ($story_feature as $ft)
                    <div class="col-lg-2 col-6">
                        <div class="card mt-2 h-314">
                            {!! genImage($ft->thumbnail, 200, 200,'card-img-top mt-2 rounded-circle h-178 w-100 p-0 img-fluid px-2', $ft->title) !!}
                            <div class="card-body justify-content-center">
                                <h5 class="card-title text-center max-line-2">{{ $ft->title }}</h5>
                                <div class="w-100 d-flex justify-content-center bottom-10">
                                    <a href="{{getUrlStory($ft)}}" class="btn btn-secondary">Đọc truyện</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>

        <div class="section-3 mt-5">
            <img src="img/section3.jpg" class="w-100 img-fluid">
        </div>

        <div class="section-4 mt-5 row">
            <div class="col-lg-9">
                
                    
                
                <div class="ms-2 d-flex">
                    <p class="fs-22 text-uppercase fw-bold">
                        mới cập nhật!
                    </p>
                    <div class="ms-auto pe-0">
                    <a class="text-end text_secondary text-decoration-none fw-bold fs-18" href="#">
                    
                        xem thêm >>
                    
                    </div>
                    </a>
                    </div>
                
                <div class="row justify-content-between mt-am-2">
                    @if (!empty($new))
                        @foreach($new as $n)
                            @php
                                $chap = explode('- ', $n->chapter[max(array_keys($n->chapter->toArray()))]->title);
                                $chap = end($chap);
                              
                            @endphp
                        <div class="col-lg-3 col-6 mt-2">
                                <a href="{{getUrlStory($n)}}" class="card p-0 ml-2">
                                    {!! genImage($n->thumbnail, 225, 330, 'img-fluid', $n->title) !!}
                                    <div class="card-body dark-linear position-absolute fixed-bottom">
                                        <p class="p-0 m-0 text-white border-bottom fw-bold">{{$n->title}}</p>
                                        <p class="p-0 m-0 text-info">{{$n->categories[0]->title}}</p>
                                        <p class="p-0 m-0 text_secondary">{{ $chap }}</p>
                                        <p class="p-0 m-0 text-grey1 d-flex align-items-center"><i class="icon-eye pt-1 pe-1"></i> Lượt xem: {{$vh->view_count}}</p>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="text-center">
                <button class="btn btn-secondary bg-white text-dark mt-2">Xem thêm <span class="icon-arrow_forward_ios"></span></button>
                </div>

                @if(!empty($follow))
                <div class="slide">
                    <h3 class="fs-22 text-uppercase fw-bold">{{$follow_status}}</h3>
                    <ul class="follow">
                        @foreach ($follow as $fl)
                            @php
                                $chap = explode('- ', $n->chapter[max(array_keys($n->chapter->toArray()))]->title);
                                $chap = end($chap);
                            @endphp
                            <li class="item d-block">
                                <a href="{{getUrlStory($fl)}}" class="card p-0 ml-2">
                                    {!! genImage($fl->thumbnail, 300, 300, 'img-fluid', $fl->title) !!}
                                    <div class="card-body dark-linear position-absolute fixed-bottom">
                                        <p class="p-0 m-0 text-white border-bottom fw-bold">{{$fl->title}}</p>
                                        <p class="p-0 m-0 text-info">{{$fl->categories[0]->title}}</p>
                                        <p class="p-0 m-0 text_secondary">{{$chap}}</p>
                                        <p class="p-0 m-0 text-grey1 d-flex align-items-center"><i class="icon-eye pt-1 pe-1"></i> Lượt xem: {{$fl->view_count}}</p>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="bg_secondary p-2 mt-5 rounded">
                    <p class="p-0 text-uppercase fs-22 fw-bold">Từ khóa hot!</p>
                    <div class="d-flex">
                        <div class="bg-secondary ms-2 px-2 rounded-pill text-white text-center">
                            girl
                        </div>

                        <div class="bg-secondary ms-2 px-2 rounded-pill text-white text-center">
                            wife house
                        </div>

                        <div class="bg-secondary ms-2 px-2 rounded-pill text-white text-center">
                            harem
                        </div>


                    </div>

                </div>
                <div class="mt-5 d-flex justify-content-between max-100">
                    <div class="row">
                    @for($i=0;$i<3;$i++)
                    <div class="col-lg-4 col-12">
                        <div class="">
                    <a href="#" class="">
                        <img src="img/naruto.jpg" class="w-100 max-100 m-0 p-0 mt-2 mt-lg-0 rounded img-fluid" alt="">
                    </a>
                    </div>
                    </div>
                    @endfor
                </div>
                </div>
            </div>


            <div class="col-lg-3">
                

                <div class="ms-2 d-flex">
                    <p class="fs-22 pt-lg-0 pt-4 text-uppercase fw-bold">
                        xu hướng
                    </p>
                    <div class="ms-auto pt-lg-0 pt-4 pe-0">
                    <a class="text-end text_secondary text-decoration-none fw-bold fs-18" href="#">
                    
                        xem thêm >>
                    
                    </div>
                    </a>
                    </div>
                

                <div class="row">
                @if(!empty($get_story_rate_highest))
                @foreach($get_story_rate_highest as $key => $_rate)
                @php
                    // $chap = explode('- ', $_rate->chapter[max(array_keys($_rate->chapter->toArray()))]->title);
                    // $chap = end($chap);
                @endphp
                <div class="ms-2 mt-2 pb-2 border-bottom d-flex d-nowrap">
                    <div class="col-1 p-0 mt-1 bg-danger rounded sq-2">
                        <p class="text-center text-white fww-bold rounded {{ ($key + 1) == 1 ? 'bg-danger' : (($key + 1) == 2 ? 'bg-success' : (($key + 1) == 3 ? 'bg-primary' : 'bg-secondary')) }}">{{$key+1}}</p>
                    </div>
                    <div class="col-11">
                        <a href="{{getUrlStory($_rate)}}" title="{{$_rate->title}}" class="d-block m-0 p-0 col-12 ps-2 fw-bold text-black1">{{$_rate->title}}</a>
                        <div class="row ms-0">
                            <div class="col-9 fs-12 ps-2 d-flex">
                                <div class="d-flex me-2 align-items-center">
                                    <i class="icon-star-full me-1 text-yellow1"></i>
                                    Lượt đánh giá: {{$_rate->count_vote}}
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="icon-heart me-1 text-red2"></i>
                                    {{$_rate->count_vote_avg}}/5
                                </div>
                                

                            </div>
                            <div class="col-3 text-end fs-12 fst-italic d-flex"><i class="icon-eye pt-1"></i><p class="ms-1 mb-0"> {{$_rate->view_count}}</p></div>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
                </div>
                

        

                <div class="ms-2 mt-4 d-flex">
                    <p class="fs-22 text-uppercase">
                        Danh sách chuyên mục
                    </p>
                    <div class="ms-auto pe-0">
                    
                    </div>
                </div>
                <div class="row">
                    <div class="widget">
                        <div class="widget-content">
                            <ul class="list px-0">
                                @foreach($category as $value)
                                <li class="d-flex {{ strpos($value['title'], '---') === false ? '' : 'ps-4' }}">
                                    <a href="{{ getUrlCate((object) $value) }}">{!! str_replace('---', "<span class='mx-2'></span>", $value['title']) !!}</a>
                                    <span class="ms-1">({{$value['count_post'] == 0 ? $value['count_story'] : $value['count_post']}})</span>
                                    <span class="ms-auto">{{$value['category_post'] == 1 ? 'Tin tức' : 'Truyện'}}</span>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
            </div>
                
            </div>
        </div>
    </div>
    @endsection
