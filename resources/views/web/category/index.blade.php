@extends('web.layout')
@section('main')


    {{-- bread-cum --}}
    <div class="bg-grey1">
        <div class="container d-flex bg-grey1">
            <div class="d-inline">
                <div class="fs-18 fw-bold mt-2">Sắp xếp theo</div> 
                <div class="mt-2"> 
                    <p class="d-inline text-secondary"> Chữ cái đầu tiên </p>
                    <p class="d-inline ms-2 text-secondary"> Lượt đọc </p>
                    <p class="d-inline ms-2 text-secondary"> Đánh giá </p>
                    <p class="d-inline ms-2 text-secondary"> Số tập </p>
                </div>
            </div>
            <div class="d-inline ms-auto">
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
                @for($i=0;$i<16;$i++)
                <div class="col-2 text-center text-secondary mt-2">Thể loại</div>
                @endfor
            </div>
        </div>
    </div>
    <div class="container mt-2">
    <div class="row justify-content-between mt-am-2">
        @for($i=0;$i<24;$i++)
        <div class="col-lg-2 col-6 mt-2">
                <div class="card p-0 ml-2">
                    <img src="img/book1.jpeg" class="card-img-top w-100 img-fluid" alt="book1">
                    <div class="card-body dark-linear position-absolute fixed-bottom">
                        <p class="p-0 m-0 text-white border-bottom">Senju harasama</p>
                        <p class="p-0 m-0 text-info">Manhwa</p>
                        <p class="p-0 m-0 text_secondary">Chap 12</p>
                    </div>
                </div>
            </div>
        @endfor
    </div>
    </div>
@endsection