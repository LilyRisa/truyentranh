@extends('web.layout')
@section('main')


    {{-- bread-cum --}}
    
    <div class="bg-grey1">
       
        <div class="container d-flex flex-wrap bg-grey1">
            <div class="col-lg-3 col-12">
                <div class="fs-18 fw-bold mt-2 text-nowrap">Từ khóa tìm kiếm</div> 
                <form class="w-100 d-flex mt-1" action="" method="get">
                    <input type="text" class="rounded-pill-left form-control" name="title" placeholder="  Tìm kiếm.." id="">
                    <button class="btn btn-default rounded-pill-right p-0 bg_secondary text-white fw-bold fs-12 p-1" type="submit">Tìm kiếm</button>
                </form>
               
            </div>
            <div class="ms-lg-auto">
                <div class="fs-18 fw-bold mt-2">Sắp xếp theo</div> 
                <div class="mt-2"> 
                    <button class="d-inline text-secondary"> Chữ cái đầu tiên </button>
                    <button class="d-inline ms-2 text-secondary"> Lượt đọc </button>
                    <button class="d-inline ms-2 text-secondary"> Đánh giá </button>
                    <button class="d-inline ms-2 text-secondary"> Số tập </button>
                </div>
            </div>
            <div class="ms-auto">
                <div class="fs-18 fw-bold mt-2">Trạng thái</div> 
                <div class="mt-2">
                    <p class="d-inline text-secondary"> Tất cả </p>
                    <p class="d-inline ms-2 text-secondary"> Mới cập nhật </p>
                    <p class="d-inline ms-2 text-secondary"> Hoàn thành </p>
                    <p class="d-inline ms-2 text-secondary"> Đang tiến hành </p>
                </div>
            </div>


            
        </div>
        <div class="container bg-grey1 pb-3">
        <div class="d-flex fs-18 fw-bold mt-3">Thể loại</div>
            <div class="d-flex flex-wrap">
                @for($i=0;$i<12;$i++)
                <div class="col-lg-2 col-4 text-center text-secondary mt-2">Thể loại</div>
                @endfor
            </div>
        </div>
    </div>
    <div class="container mt-2">
    <h1 class="text-center text-uppercase text_secondary">{{$oneItem->title}}</h1>
    <p class="text-center">{!! $oneItem->description !!}</p>
    <div class="row mt-am-2">
        @if(!empty($story))
        @foreach($story as $item)
        @php
            $chap = explode('- ', $item->chapter[0]->title);
            $chap = end($chap);
            
        @endphp
        <div class="col-lg-2 col-6 mt-2">
                <div class="card p-0 ml-2">
                    {!! genImage($item->thumbnail, 194, 259, 'img-fluid', $item->title) !!}
                    <div class="card-body dark-linear position-absolute fixed-bottom">
                        <p class="p-0 m-0 text-white border-bottom">{{$item->title}}</p>
                        <p class="p-0 m-0 text-info">{{$item->categories[0]->title}}</p>
                        <p class="p-0 m-0 text_secondary">{{$chap}}</p>
                    </div>
                </div>
            </div>
            @endforeach
        @endif
    </div>
    </div>
@endsection