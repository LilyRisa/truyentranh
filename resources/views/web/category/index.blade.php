@extends('web.layout')
@section('main')


    {{-- bread-cum --}}
    
    <div class="bg-grey1 py-2">
       
        <div class="container d-flex flex-wrap bg-grey1">
            <div class="col-lg-3 col-12">
                <div class="fs-18 fw-bold mt-2 text-nowrap">Từ khóa tìm kiếm</div> 
                <form class="w-100 d-flex mt-1" action="" method="get">
                    <input type="text" class="rounded-pill-left form-control" name="title" @if(!empty($search_title)) value="{{$search_title}}"  @else placeholder="  Tìm kiếm.." @endif id="">
                    <button class="btn btn-default rounded-pill-right p-0 bg_secondary text-white fw-bold fs-12 p-1" type="submit"><i class="icon-search fs-16"></i></button>
                </form>
               
            </div>
                
        </div>
        <div>
            <div class="ms-lg-auto container d-flex flex-wrap bg-grey1">
                <div class="col-lg-2">
                        <div class="d-flex fs-18 fw-bold mt-2">Thể loại</div>
                        <div class="d-flex mt-2 flex-wrap">
                            @if(!empty($listCategory))
                            <select class="form-select" name="" id="">
                                <option value="0">Chọn chuyên mục</option>
                                @foreach($listCategory as $cate)
                                <option value="{{$cate->id}}">{{$cate->title}}</option>
                                @endforeach
                            </select>
                            @endif
                        </div>
                </div>
                <div class="ms-lg-auto">
                
                    <div class="fs-18 fw-bold mt-2">Sắp xếp theo</div> 
                    <div class="mt-2"> 
                        <button class="d-inline btn bg-white border text-secondary"> Chữ cái đầu tiên </button>
                        <button class="d-inline btn bg-white border ms-2 text-secondary"> Lượt đọc </button>
                        <button class="d-inline btn bg-white border ms-2 text-secondary"> Đánh giá </button>
                        <button class="d-inline btn bg-white border ms-2 text-secondary"> Số tập </button>
                    </div>
                </div>
                <div class="ms-lg-auto">
                   
                    <div class="fs-18 fw-bold mt-2">Trạng thái</div> 
                    <div class="mt-2">
                        <button class="d-inline btn bg-white border text-secondary"> Tất cả </button>
                        <button class="d-inline btn bg-white border ms-2 text-secondary"> Mới cập nhật </button>
                        <button class="d-inline btn bg-white border ms-2 text-secondary"> Hoàn thành </button>
                        <button class="d-inline btn bg-white border ms-2 text-secondary"> Đang tiến hành </button>
                    
                    </div>
                    </div>
                </div>  
        </div>
    
    <div class="container mt-3 border-top">
    <h1 class="text-center text-uppercase text_secondary">{{$oneItem->title}}</h1>
    <p class="text-center">{!! $oneItem->description !!}</p>
    <div class="row mt-am-2">
        @if(!empty($story))
        @foreach($story as $item)
        @php
            $chap = explode('- ', $item->chapter[max(array_keys($item->chapter->toArray()))]->title);
            $chap = end($chap);
            
        @endphp
        <div class="col-lg-2 col-6 mt-2">
                <div class="card p-0 ml-2"> 
                    {!! genImage($item->thumbnail, 194, 259, 'img-fluid', $item->title) !!}
                    <div class="card-body dark-linear position-absolute fixed-bottom">
                        <a href="{{getUrlStory($item)}}" class="d-block p-0 m-0 text-white border-bottom" title="{{$item->title}}">{{$item->title}}</a>
                        <a href="{{getUrlCate($item->categories[0])}}" class="p-0 m-0 text-info" title="{{$item->categories[0]->title}}">{{$item->categories[0]->title}}</a>
                        <p class="p-0 m-0 text_secondary">{{$chap}}</p>
                        <p class="p-0 m-0 text-grey1 d-flex align-items-center"><i class="icon-eye pt-1 pe-1"></i> Lượt xem: {{$item->view_count}}</p>
                    </div>
                </div>
            </div>
            @endforeach
        @endif
    </div>
    </div>
@endsection