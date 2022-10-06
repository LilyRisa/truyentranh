@extends('web.layout')
@section('main')

<div class="bg-detail d-flex justify-content-center bg_secondary w-100 max-100 h-20">
    <div class="d-flex bg-white mt-auto container h-75">
        <img src="img/book1.jpeg" alt="" class="img-fluid ms-4 rounded-top" style="max-height: 22rem; margin-top:-2rem;">
        <div class="ms-4 mt-4 d-flex"> 
           <ul class="w-75">
                <li class="list-unstyled d-flex"><span class="fs-25">Title <span class="fs-13 ms-4 text_secondary">Đang tiến hành</span></span></li>
                <li class="list-unstyled"><p class="fs-13 text-secondary">Author: histod</p></li>
                <li class="list-unstyled d-flex mt-1"><div class="rounded-pill border px-1">tag1</div> <div class="rounded-pill ms-2 border px-1">tag213</div> <div class="rounded-pill ms-2 border px-1">tag1212</div></li>
                <li class="list-unstyled mt-3"><span>An old MMORPG called Live Dungeon. Before the service was terminated, Kyotani Tsutomu made full use of 5 notebook PCs to clear the game and was invited to a different world. And then, Tsutomu was speechless when he saw a live rel</span></li>
                <li class="list-unstyled d-flex mt-5"><a class="btn btn-secondary bg_secondary text-white border-0">Đọc truyện</a> <a class="btn btn-secondary ms-2 border-0"><i class="icon-star-full text_secondary"></i> Thêm vào tủ</a></li>
           </ul>
           <ul>
            <li class="list-unstyled d-flex mt-5">
                <div class="d-flex mt-2 pt-1">
                <i class="icon-star-full text_secondary"></i>
                <i class="icon-star-full text_secondary ps-1"></i>
                <i class="icon-star-full text_secondary ps-1"></i>
                <i class="icon-star-full text_secondary ps-1"></i>
                <i class="icon-star-full text_secondary ps-1"></i>
                </div>
                <p class="fs-25 ps-2">5.0</p>
            </li>
            <li class="list-unstyled d-flex">
                <i class="icon-facebook1 text-primary"></i>
                <i class="icon-twitter1 ms-2 text-primary"></i>
                <i class="icon-youtube2 ms-2 text-danger"></i>
            </li>
           </ul>
        </div>
    </div>
</div>
<div class="container bg-white">
    <div class="row mt-0 pt-3">
    <div class="col-lg-9">
        <div class="d-flex container mt-2">
        <p class="">
            Chương (321)
        </p>
        <p class="ms-auto">
            Cập nhật lần cuối 25/12/2021
        </p>
    </div>

        
    <div class="col-12 container">
        <ul class="list-unstyled row">
            @for($i=0;$i<16;$i++)
            <li class="col-6"><div class="list-group-item bg-light my-1 mx-0"><p>Ch.132</p><p class="small text-secondary">12/05/2022</p></div></li>
            @endfor
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