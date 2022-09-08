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
<div class="container bg-primary">
    <div class="row">
    <div class="col-lg-9">
        <span class="">
            Chương (321)
        </span>
        <p class="text-end p-0">
            Cập nhật lần cuối 25/12/2021
        </p>
    </div>
    <div class="col-lg-3">
        Cùng tác giả
    </div>
    </div>
</div>

@endsection