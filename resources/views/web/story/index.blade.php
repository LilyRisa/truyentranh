@extends('web.layout')
@section('main')
<div class="position-relative d-flex justify-content-center bg_secondary w-100 max-100">
    <div class="d-flex flex-wrap bg-white mt-auto container h-75">
        <div class="col-lg-3 col-12 d-flex justify-content-center">
        {!! genImage($oneItem->thumbnail, 249, 322, 'img-fluid rounded-top') !!}
        </div>
        <div class="mt-4 d-flex flex-lg-inline flex-wrap col-lg-9 col-12"> 
           <ul class="w-100">
                <li class="list-unstyled d-flex"><span class="fs-25">{{$oneItem->title}} <span class="fs-13 ms-4 text_secondary">{{$oneItem->is_update}}</span></span></li>
                <li class="list-unstyled"><p class="fs-13 text-secondary">Author: {{$oneItem->author}}</p></li>
                <li class="list-unstyled d-flex">
                    @include('web.block._vote', ['data' => $oneItem, 'url' => '/story/ajax_rate'])
                </li>
                <li class="list-unstyled d-flex mt-1">
                    @if(!empty($oneItem->tags))
                        @foreach ($oneItem->tags as $t)
                            <div class="rounded-pill mx-2 border px-1"><a href="{{getUrlTag($t)}}">{{$t->title}}</a></div>
                        @endforeach
                    @endif
                </li>
                <li class="list-unstyled mt-3"><span>{{$oneItem->description}}</span></li>
                <li class="list-unstyled d-flex mt-5"><a class="btn btn-secondary border-0"><i class="icon-star-full text_secondary"></i> Thêm vào tủ</a></li>
                <li class="list-unstyled d-flex mt-3"><a href="{{getUrlChapter($oneItem->chapter[0])}}" class="btn btn-secondary bg_secondary text-white border-0">Đọc từ đầu</a><a href="{{getUrlChapter($oneItem->chapter[0])}}" class="btn btn-secondary bg_secondary ms-2 text-white border-0">Đọc mới nhất</a></li>
           </ul>
           <ul>
            <li class="list-unstyled d-flex">
                <i class="icon-facebook1 text-primary"></i>
                <i class="icon-twitter1 ms-2 text-primary"></i>
                <i class="icon-youtube2 ms-2 text-danger"></i>
            </li>
           </ul>
        </div>
    </div>
</div>

<div class="container position-relative bg-white">
    <div class="row mt-0 pt-3">
    <div class="col-lg-9">
        <div class="d-flex container mt-2">
        <p class="text-nowrap">
            Chương (321)
        </p>
        <p class="text-end">
            Cập nhật lần cuối 25/12/2021
        </p>
    </div>

        
    <div class="col-12 container position-relative">
        <ul class="list-unstyled row">
            @if(!empty($oneItem->chapter))
                @foreach($oneItem->chapter as $chapter)
                <li class="col-12">
                    <a href="{{getUrlChapter($chapter)}}" class="d-block list-group-item bg-light my-1 mx-0 d-flex">
                        @php
                            $title = explode("- ", $chapter->title);
                            $title = end($title);
                        @endphp
                        <p class="pb-0 mb-0">{{$title}}</p>
                        <p class="small text-secondary ms-auto mb-0">{{$chapter->update_origin}}</p>
                    </a>
                </li>
                @endforeach
            @endif
        </ul>
        </div>
        
    </div>
    <div class="col-lg-3">
        <div class="mt-2 d-flex">
            <p class="fs-16 text-uppercase">
                Cùng tác giả
            </p>
            <div class="ms-auto pe-0">
            <a class="text-end text_secondary text-decoration-none" href="#">
                xem thêm >>
            </div>
            </a>
        </div>
        <div class="">
            @for ($i = 1; $i < 8; $i++)
                <div class="mt-2 pb-2 border-bottom row">
                    <div class="col-3"><img src="img/book1.jpeg" class="img-fluid"></div>
                    <div class="col-9">
                        <div class="m-0 p-0">Tên truyện</div>
                        <div class="row mt-2">
                            <div class="col-9 fs-12">Chương 123</div>
                            <div class="col-3 text-end fs-12 fst-italic d-flex"><i class="icon-eye pt-1"></i><p class="ms-1"> 1205</p></div>
                        </div>
                    </div>
                </div>
            @endfor
        </div>
    </div>
</div>

@endsection