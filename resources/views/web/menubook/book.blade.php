@extends('web.layout')
@section('main')

<div class="container">
    {{-- bread-cum --}}
    <div class="position-relative w-100 d-flex" style="height: 2rem">
    <div class="bg-1 pt-1 ps-1"><a class="text-decoration-none text-white" href="#"><i class="icon-home pt-2"></i></a></div>
    <div class=" triangle-right-1 bd-1 bg-2" style=""></div>
    <div class="bg-2 text-white pt-1 ps-1"><a class="text-decoration-none text-white" href="#">Drama</a></div>
    <div class=" triangle-right-2 bd-2 bg-3" style=""></div>
    <div class="bg-3 text-white pt-1 ps-1"><a class="text-decoration-none text-white" href="#">Lòng trung thành với kẻ ác</a></div>
    <div class=" triangle-right-3 bd-3" style=""></div>
    <div class="text-info pt-1 ps-1"><a class="text-decoration-none text-info" href="#">Lòng trung thành với kẻ ác - Tập 14</a></div>
    </div>

    <div class="">
        <div class="pt-5"><p class="d-inline fs-18">Lòng trung thành với kẻ ác</p><p class="px-2 d-inline">-</p><p class="text_secondary d-inline">Chapter 1</p><p class="px-2 d-inline">-</p><p class="text-secondary d-inline">(Cập nhật lúc 16:57 13-08-2022)</p> </div>
    </div>

    <div class="bg-grey1 text-center mt-4">
        <div><p class="mb-0 pt-4">Nếu không xem được vui lòng đổi "serve" khác để có trải nghiệm tốt hơn</p>
            <p class="text-danger p-0">Hướng dẫn khắc phục lỗi nếu ảnh bị lỗi ở tất cả các tập</p>
        </div>
        <button class="btn btn-success">Server VIP</button>
        <button class="btn btn-warning">Báo lỗi</button>

        <div class="w-100 bg_secondary text-center mt-2 py-1">Sử dụng mũi tên trái (<-) hoặc phải (->) để chuyển chapter</div>

        <div class="mt-4 pb-3">
            <a class="text-decoration-none text-danger" href="#"><i class="icon-home"></i></a>
            <a class="text-decoration-none text-danger" href="#"><i class="icon-home"></i></a>
            <a class="text-decoration-none text-danger" href="#"><i class="icon-home"></i></a>

            <button class="btn btn-danger text-white"><i class="icon-home"></i></button>
            <select class="form-select d-inline w-25" name="" id="">
                <option value="">Chương 1</option>
                <option value="">Chương 2</option>
                <option value="">Chương 3</option>
            </select>
            <button class="btn btn-danger text-white"><i class="icon-home"></i></button>
            <button class="btn btn-success">Theo dõi</button>
        </div>

    </div>

    <div class="bg-secondary mt-3 w-100 max-100 content-reading">
        <img src="img/book1.jpeg" class="" alt="">
    </div>

    <div class="text-center mt-4">
        <button class="btn btn-primary"><i class="icon-home"></i></button>
        <button class="btn btn-primary"><i class="icon-home"></i></button>
    </div>
</div>


@endsection