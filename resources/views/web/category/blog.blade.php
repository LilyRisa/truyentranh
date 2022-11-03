@extends('web.layout')
@section('main')
<div class="container row mt-5">
  <section class="page-header">
     <div class="container-xl">
        <div class="text-center">
           <h1 class="mt-0 mb-2"><a href="{{Request::url()}}">{{ $oneItem->meta_title }}</a></h1>
           <p class="fst-italic">{{ $oneItem->meta_description }}</p>
           <nav aria-label="breadcrumb">
              <ol class="breadcrumb justify-content-center mb-0">
                 <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                 <li class="breadcrumb-item active" aria-current="page"><a href="{{$breadCrumb[0]['item']}}">{{$breadCrumb[0]['name']}}</a></li>
              </ol>
           </nav>
        </div>
     </div>
  </section>
  <div class="col-lg-8 col-12">
     <div class="row justify-content-between">
      @if(!empty($posts))
      @foreach($posts as $p)
        <div class="col-sm-6 mt-3">
           <div class="post post-grid rounded bordered">
              <div class="thumb top-rounded">
                 <a href="{{ getUrlCate($p->category) }}" class="category-badge position-absolute">{{ $p->category->title }}</a>
                 <span class="post-format"> 
                 <i class="icon-image"></i> 
                 </span> 
                 <a href="{{getUrlPost($p)}}">
                    <div class="inner"> 
                      {!! genImage($p->thumbnail, 550, 367, 'img-fluid thumb-post-list', $p->title) !!}
                    </div>
                 </a>
              </div>
              <div class="details mx-2 mt-4">
                 <ul class="meta list-inline mb-0">
                    <li class="list-inline-item">
                       <a href="#" class="text-decoration-none text-grey1"> 
                        {!! genImage($p->user->thumbnail, 30, 30, 'author avatar rounded-circle', $p->user->fullname) !!} {{$p->user->fullname}}</a>
                    </li>
                    <div class="list-inline-item small">{{convertDateTime($p->displayed_time)}}</div>
                 </ul>
                 <h5 class="post-title mb-3 mt-3">
                    <a href="{{getUrlPost($p)}}" class="text-decoration-none text-black">{{$p->title}}</a>
                 </h5>
                 <p class="excerpt mb-0 fix-h"> {!! $p->desc !!}</p>
              </div>
              <div class="post-bottom clearfix d-flex align-items-center mx-2">
                 <div class="icon-share2">
                 </div>
                 <div class="more-button ms-auto"> 
                    <a href="{{getUrlPost($p)}}">
                    <span class="icon-dots-three-horizontal"></span>
                    </a> 
                 </div>
              </div>
           </div>
        </div>
        @endforeach
        @else
        <div class="fs-1">Không có dữ liệu</div>
        @endif
     </div>
     <nav class="mt-2">
        <ul class="pagination justify-content-center post"> 
           <a href="#" class="category-badge active load-more" aria-current="page" data-page="1" data-category="6" data-url="load-more-posts">Xem thêm</a> 
        </ul>
     </nav>
  </div>
 @include('web.block._sidebar')
@endsection