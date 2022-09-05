@extends('web.layout');
@section('main')
<div>
    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="img/img1.jpeg" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item">
          <img src="img/img2.jpeg" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item">
          <img src="img/img3.jpeg" class="d-block w-100" alt="...">
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
      <ul class="content-center text-center mt-3">
        <li class="list-inline-item text-uppercase ms-3"><a class="text-decoration-none text-dark" href="#">DRAMA</a></li>
        <li class="list-inline-item text-uppercase ms-3"><a class="text-decoration-none text-dark" href="#">ECCHI</a></li>
        <li class="list-inline-item text-uppercase ms-3"><a class="text-decoration-none text-dark" href="#">comedy</a></li>
        <li class="list-inline-item text-uppercase ms-3"><a class="text-decoration-none text-dark" href="#">fantasy</a></li>
        <li class="list-inline-item text-uppercase ms-3"><a class="text-decoration-none text-dark" href="#">school life</a></li>
        <li class="list-inline-item text-uppercase ms-3"><a class="text-decoration-none text-dark" href="#">shoujo</a></li>
        <li class="list-inline-item text-uppercase ms-3"><a class="text-decoration-none text-dark" href="#">shounen</a></li>
        <li class="list-inline-item text-uppercase ms-3"><a class="text-decoration-none text-dark" href="#">sport</a></li>
        <li class="list-inline-item ms-3"><button class="btn bg-white all-button text-uppercase text_secondary">all
            manga</button></li>
      </ul>

    </div>
  </div>


  <div class="main container">
    <div class="section-1 mt-5 row">

      <div class="col-lg-9">
        <p class="fs-16 text-uppercase">
          truyện hot!
        </p>
        <div class="row justify-content-between">
          <div class="col-lg-3 ">
            <div class="card p-0 ml-2">
              <img src="img/book1.jpeg" class="card-img-top w-100 img-fluid" alt="book1">
              <div class="card-body dark-linear position-absolute fixed-bottom">
                <p class="p-0 m-0 text-white border-bottom">Senju harasama</p>
                <p class="p-0 m-0 text-info">Manhwa</p>
                <p class="p-0 m-0 text_secondary">Chap 12</p>
              </div>
            </div>
          </div>
          <div class="col-lg-3 ">
            <div class="card p-0 ml-2">
              <img src="img/book1.jpeg" class="card-img-top w-100 img-fluid" alt="book1">
              <div class="card-body dark-linear position-absolute fixed-bottom">
                <p class="p-0 m-0 text-white border-bottom">Senju harasama</p>
                <p class="p-0 m-0 text-info">Manhwa</p>
                <p class="p-0 m-0 text_secondary">Chap 12</p>
              </div>
            </div>
          </div>
          <div class="col-lg-3 ">
            <div class="card p-0 ml-2">
              <img src="img/book1.jpeg" class="card-img-top w-100 img-fluid" alt="book1">
              <div class="card-body dark-linear position-absolute fixed-bottom">
                <p class="p-0 m-0 text-white border-bottom">Senju harasama</p>
                <p class="p-0 m-0 text-info">Manhwa</p>
                <p class="p-0 m-0 text_secondary">Chap 12</p>
              </div>
            </div>
          </div>
          <div class="col-lg-3 ">
            <div class="card p-0 ml-2">
              <img src="img/book1.jpeg" class="card-img-top w-100 img-fluid" alt="book1">
              <div class="card-body dark-linear position-absolute fixed-bottom">
                <p class="p-0 m-0 text-white border-bottom">Senju harasama</p>
                <p class="p-0 m-0 text-info">Manhwa</p>
                <p class="p-0 m-0 text_secondary">Chap 12</p>
              </div>
            </div>
          </div>

          <div class="col-lg-3 mt-2">
            <div class="card p-0 ml-2">
              <img src="img/book1.jpeg" class="card-img-top w-100 img-fluid" alt="book1">
              <div class="card-body dark-linear position-absolute fixed-bottom">
                <p class="p-0 m-0 text-white border-bottom">Senju harasama</p>
                <p class="p-0 m-0 text-info">Manhwa</p>
                <p class="p-0 m-0 text_secondary">Chap 12</p>
              </div>
            </div>
          </div>

          <div class="col-lg-3 mt-2">
            <div class="card p-0 ml-2">
              <img src="img/book1.jpeg" class="card-img-top w-100 img-fluid" alt="book1">
              <div class="card-body dark-linear position-absolute fixed-bottom">
                <p class="p-0 m-0 text-white border-bottom">Senju harasama</p>
                <p class="p-0 m-0 text-info">Manhwa</p>
                <p class="p-0 m-0 text_secondary">Chap 12</p>
              </div>
            </div>
          </div>

          <div class="col-lg-3 mt-2">
            <div class="card p-0 ml-2">
              <img src="img/book1.jpeg" class="card-img-top w-100 img-fluid" alt="book1">
              <div class="card-body dark-linear position-absolute fixed-bottom">
                <p class="p-0 m-0 text-white border-bottom">Senju harasama</p>
                <p class="p-0 m-0 text-info">Manhwa</p>
                <p class="p-0 m-0 text_secondary">Chap 12</p>
              </div>
            </div>
          </div>

          <div class="col-lg-3 mt-2">
            <div class="card p-0 ml-2">
              <img src="img/book1.jpeg" class="card-img-top w-100 img-fluid" alt="book1">
              <div class="card-body dark-linear position-absolute fixed-bottom">
                <p class="p-0 m-0 text-white border-bottom">Senju harasama</p>
                <p class="p-0 m-0 text-info">Manhwa</p>
                <p class="p-0 m-0 text_secondary">Chap 12</p>
              </div>
            </div>
          </div>

        </div>
      </div>


      <div class="col-lg-3">
        <p class="fs-16 ms-2">BXH</p>
        <div class="ms-2 mt-2 pb-2 border-bottom row">
          <div class="col-1 p-0">
            <p class="text-start text-danger">01</p>
          </div>
          <div class="col-3"><img src="img/book1.jpeg" class="img-fluid"></div>
          <div class="col-8">
            <div class="m-0 p-0">Tên truyện</div>
            <div class="row mt-2">
              <div class="col-6 fs-12">Chương 123</div>
              <div class="col-6 text-end fs-12 fst-italic">10002</div>
            </div>
          </div>
        </div>

        <div class="ms-2 pb-2 border-bottom mt-2 row">
          <div class="col-1 p-0">
            <p class="text-start text-success">02</p>
          </div>
          <div class="col-3"><img src="img/book1.jpeg" class="img-fluid"></div>
          <div class="col-8">
            <div class="m-0 p-0">Tên truyện</div>
            <div class="row mt-2">
              <div class="col-6 fs-12">Chương 123</div>
              <div class="col-6 text-end fs-12 fst-italic">10002</div>
            </div>
          </div>
        </div>

        <div class="ms-2 pb-2 border-bottom mt-2 row">
          <div class="col-1 p-0">
            <p class="text-start text-primary">03</p>
          </div>
          <div class="col-3"><img src="img/book1.jpeg" class="img-fluid"></div>
          <div class="col-8">
            <div class="m-0 p-0">Tên truyện</div>
            <div class="row mt-2">
              <div class="col-6 fs-12">Chương 123</div>
              <div class="col-6 text-end fs-12 fst-italic">10002</div>
            </div>
          </div>
        </div>

        <div class="ms-2 pb-2 border-bottom mt-2 row">
          <div class="col-1 p-0">
            <p class="text-start text-secondary">04</p>
          </div>
          <div class="col-3"><img src="img/book1.jpeg" class="img-fluid"></div>
          <div class="col-8">
            <div class="m-0 p-0">Tên truyện</div>
            <div class="row mt-2">
              <div class="col-6 fs-12">Chương 123</div>
              <div class="col-6 text-end fs-12 fst-italic">10002</div>
            </div>
          </div>
        </div>

        <div class="ms-2 pb-2 border-bottom mt-2 row">
          <div class="col-1 p-0">
            <p class="text-start text-secondary">05</p>
          </div>
          <div class="col-3"><img src="img/book1.jpeg" class="img-fluid"></div>
          <div class="col-8">
            <div class="m-0 p-0">Tên truyện</div>
            <div class="row mt-2">
              <div class="col-6 fs-12">Chương 123</div>
              <div class="col-6 text-end fs-12 fst-italic">10002</div>
            </div>
          </div>
        </div>
        

        <div class="ms-2 pb-2 border-bottom mt-2 row">
          <div class="col-1 p-0">
            <p class="text-start text-secondary">06</p>
          </div>
          <div class="col-3"><img src="img/book1.jpeg" class="img-fluid"></div>
          <div class="col-8">
            <div class="m-0 p-0">Tên truyện</div>
            <div class="row mt-2">
              <div class="col-6 fs-12">Chương 123</div>
              <div class="col-6 text-end fs-12 fst-italic">10002</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="section-2 mt-5">
      <p class="fs-16 text-uppercase">
        truyện hot!
      </p>

      <div class="row justify-content-between">
        <div class="col-lg-2">
          <div class="card">
            <img src="img/book3.jpeg" width="200" height="200"
              class="card-img-top rounded-circle w-100 h-100 p-0 img-fluid px-2" alt="book1" />
            <div class="card-body justify-content-center">
              <h5 class="card-title text-center">Card title</h5>
              <div class="w-100 d-flex justify-content-center">
                <a href="#" class="btn btn-secondary">Đọc truyện</a>
              </div>
            </div>
          </div>


        </div>


        <div class="col-lg-2">
          <div class="card">
            <img src="img/book3.jpeg" width="200" height="200"
              class="card-img-top rounded-circle w-100 h-100 p-0 img-fluid px-2" alt="book1" />
            <div class="card-body justify-content-center">
              <h5 class="card-title text-center">Card title</h5>
              <div class="w-100 d-flex justify-content-center">
                <a href="#" class="btn btn-secondary">Đọc truyện</a>
              </div>
            </div>
          </div>


        </div>

        <div class="col-lg-2">
          <div class="card">
            <img src="img/book3.jpeg" width="200" height="200"
              class="card-img-top rounded-circle w-100 h-100 p-0 img-fluid px-2" alt="book1" />
            <div class="card-body justify-content-center">
              <h5 class="card-title text-center">Card title</h5>
              <div class="w-100 d-flex justify-content-center">
                <a href="#" class="btn btn-secondary">Đọc truyện</a>
              </div>
            </div>
          </div>


        </div>

        <div class="col-lg-2">
          <div class="card">
            <img src="img/book3.jpeg" width="200" height="200"
              class="card-img-top rounded-circle w-100 h-100 p-0 img-fluid px-2" alt="book1" />
            <div class="card-body justify-content-center">
              <h5 class="card-title text-center">Card title</h5>
              <div class="w-100 d-flex justify-content-center">
                <a href="#" class="btn btn-secondary">Đọc truyện</a>
              </div>
            </div>
          </div>


        </div>

        <div class="col-lg-2">
          <div class="card">
            <img src="img/book3.jpeg" width="200" height="200"
              class="card-img-top rounded-circle w-100 h-100 p-0 img-fluid px-2" alt="book1" />
            <div class="card-body justify-content-center">
              <h5 class="card-title text-center">Card title</h5>
              <div class="w-100 d-flex justify-content-center">
                <a href="#" class="btn btn-secondary">Đọc truyện</a>
              </div>
            </div>
          </div>


        </div>

        <div class="col-lg-2">
          <div class="card">
            <img src="img/book3.jpeg" width="200" height="200"
              class="card-img-top rounded-circle w-100 h-100 p-0 img-fluid px-2" alt="book1" />
            <div class="card-body justify-content-center">
              <h5 class="card-title text-center">Card title</h5>
              <div class="w-100 d-flex justify-content-center">
                <a href="#" class="btn btn-secondary">Đọc truyện</a>
              </div>
            </div>
          </div>


        </div>

      </div>
    </div>

    <div class="section-3 mt-5">
      <img src="img/section3.jpg" class="w-100 img-fluid">
    </div>

    <div class="section-4 mt-5 row">

      <div class="col-lg-9">
        <p class="fs-16 text-uppercase">
          truyện hot!
        </p>
        <div class="row justify-content-between">
          <div class="col-lg-3 ">
            <div class="card p-0 ml-2">
              <img src="img/book1.jpeg" class="card-img-top w-100 img-fluid" alt="book1">
              <div class="card-body dark-linear position-absolute fixed-bottom">
                <p class="p-0 m-0 text-white border-bottom">Senju harasama</p>
                <p class="p-0 m-0 text-info">Manhwa</p>
                <p class="p-0 m-0 text_secondary">Chap 12</p>
              </div>
            </div>
          </div>
          <div class="col-lg-3 ">
            <div class="card p-0 ml-2">
              <img src="img/book1.jpeg" class="card-img-top w-100 img-fluid" alt="book1">
              <div class="card-body dark-linear position-absolute fixed-bottom">
                <p class="p-0 m-0 text-white border-bottom">Senju harasama</p>
                <p class="p-0 m-0 text-info">Manhwa</p>
                <p class="p-0 m-0 text_secondary">Chap 12</p>
              </div>
            </div>
          </div>
          <div class="col-lg-3">
            <div class="card p-0 ml-2">
              <img src="img/book1.jpeg" class="card-img-top w-100 img-fluid" alt="book1">
              <div class="card-body dark-linear position-absolute fixed-bottom">
                <p class="p-0 m-0 text-white border-bottom">Senju harasama</p>
                <p class="p-0 m-0 text-info">Manhwa</p>
                <p class="p-0 m-0 text_secondary">Chap 12</p>
              </div>
            </div>
          </div>
          <div class="col-lg-3 ">
            <div class="card p-0 ml-2">
              <img src="img/book1.jpeg" class="card-img-top w-100 img-fluid" alt="book1">
              <div class="card-body dark-linear position-absolute fixed-bottom">
                <p class="p-0 m-0 text-white border-bottom">Senju harasama</p>
                <p class="p-0 m-0 text-info">Manhwa</p>
                <p class="p-0 m-0 text_secondary">Chap 12</p>
              </div>
            </div>
          </div>
          <div class="col-lg-3 mt-2">
            <div class="card p-0 ml-2">
              <img src="img/book1.jpeg" class="card-img-top w-100 img-fluid" alt="book1">
              <div class="card-body dark-linear position-absolute fixed-bottom">
                <p class="p-0 m-0 text-white border-bottom">Senju harasama</p>
                <p class="p-0 m-0 text-info">Manhwa</p>
                <p class="p-0 m-0 text_secondary">Chap 12</p>
              </div>
            </div>
          </div>
          <div class="col-lg-3 mt-2">
            <div class="card p-0 ml-2">
              <img src="img/book1.jpeg" class="card-img-top w-100 img-fluid" alt="book1">
              <div class="card-body dark-linear position-absolute fixed-bottom">
                <p class="p-0 m-0 text-white border-bottom">Senju harasama</p>
                <p class="p-0 m-0 text-info">Manhwa</p>
                <p class="p-0 m-0 text_secondary">Chap 12</p>
              </div>
            </div>
          </div>
          <div class="col-lg-3 mt-2">
            <div class="card p-0 ml-2">
              <img src="img/book1.jpeg" class="card-img-top w-100 img-fluid" alt="book1">
              <div class="card-body dark-linear position-absolute fixed-bottom">
                <p class="p-0 m-0 text-white border-bottom">Senju harasama</p>
                <p class="p-0 m-0 text-info">Manhwa</p>
                <p class="p-0 m-0 text_secondary">Chap 12</p>
              </div>
            </div>
          </div>
          <div class="col-lg-3 mt-2">
            <div class="card p-0 ml-2">
              <img src="img/book1.jpeg" class="card-img-top w-100 img-fluid" alt="book1">
              <div class="card-body dark-linear position-absolute fixed-bottom">
                <p class="p-0 m-0 text-white border-bottom">Senju harasama</p>
                <p class="p-0 m-0 text-info">Manhwa</p>
                <p class="p-0 m-0 text_secondary">Chap 12</p>
              </div>
            </div>
          </div>
          <div class="col-lg-3 mt-2">
            <div class="card p-0 ml-2">
              <img src="img/book1.jpeg" class="card-img-top w-100 img-fluid" alt="book1">
              <div class="card-body dark-linear position-absolute fixed-bottom">
                <p class="p-0 m-0 text-white border-bottom">Senju harasama</p>
                <p class="p-0 m-0 text-info">Manhwa</p>
                <p class="p-0 m-0 text_secondary">Chap 12</p>
              </div>
            </div>
          </div>
          <div class="col-lg-3 mt-2">
            <div class="card p-0 ml-2">
              <img src="img/book1.jpeg" class="card-img-top w-100 img-fluid" alt="book1">
              <div class="card-body dark-linear position-absolute fixed-bottom">
                <p class="p-0 m-0 text-white border-bottom">Senju harasama</p>
                <p class="p-0 m-0 text-info">Manhwa</p>
                <p class="p-0 m-0 text_secondary">Chap 12</p>
              </div>
            </div>
          </div>
          <div class="col-lg-3 mt-2">
            <div class="card p-0 ml-2">
              <img src="img/book1.jpeg" class="card-img-top w-100 img-fluid" alt="book1">
              <div class="card-body dark-linear position-absolute fixed-bottom">
                <p class="p-0 m-0 text-white border-bottom">Senju harasama</p>
                <p class="p-0 m-0 text-info">Manhwa</p>
                <p class="p-0 m-0 text_secondary">Chap 12</p>
              </div>
            </div>
          </div>
          <div class="col-lg-3 mt-2">
            <div class="card p-0 ml-2">
              <img src="img/book1.jpeg" class="card-img-top w-100 img-fluid" alt="book1">
              <div class="card-body dark-linear position-absolute fixed-bottom">
                <p class="p-0 m-0 text-white border-bottom">Senju harasama</p>
                <p class="p-0 m-0 text-info">Manhwa</p>
                <p class="p-0 m-0 text_secondary">Chap 12</p>
              </div>
            </div>
          </div>
          <div class="col-lg-3 mt-2">
            <div class="card p-0 ml-2">
              <img src="img/book1.jpeg" class="card-img-top w-100 img-fluid" alt="book1">
              <div class="card-body dark-linear position-absolute fixed-bottom">
                <p class="p-0 m-0 text-white border-bottom">Senju harasama</p>
                <p class="p-0 m-0 text-info">Manhwa</p>
                <p class="p-0 m-0 text_secondary">Chap 12</p>
              </div>
            </div>
          </div>
          <div class="col-lg-3 mt-2">
            <div class="card p-0 ml-2">
              <img src="img/book1.jpeg" class="card-img-top w-100 img-fluid" alt="book1">
              <div class="card-body dark-linear position-absolute fixed-bottom">
                <p class="p-0 m-0 text-white border-bottom">Senju harasama</p>
                <p class="p-0 m-0 text-info">Manhwa</p>
                <p class="p-0 m-0 text_secondary">Chap 12</p>
              </div>
            </div>
          </div>
          <div class="col-lg-3 mt-2">
            <div class="card p-0 ml-2">
              <img src="img/book1.jpeg" class="card-img-top w-100 img-fluid" alt="book1">
              <div class="card-body dark-linear position-absolute fixed-bottom">
                <p class="p-0 m-0 text-white border-bottom">Senju harasama</p>
                <p class="p-0 m-0 text-info">Manhwa</p>
                <p class="p-0 m-0 text_secondary">Chap 12</p>
              </div>
            </div>
          </div>
          <div class="col-lg-3 mt-2">
            <div class="card p-0 ml-2">
              <img src="img/book1.jpeg" class="card-img-top w-100 img-fluid" alt="book1">
              <div class="card-body dark-linear position-absolute fixed-bottom">
                <p class="p-0 m-0 text-white border-bottom">Senju harasama</p>
                <p class="p-0 m-0 text-info">Manhwa</p>
                <p class="p-0 m-0 text_secondary">Chap 12</p>
              </div>
            </div>
          </div>
          

        </div>

        <button>Xem thêm <i class=""></i></button>

        <div class="bg-info p-2 mt-5 rounded">
          <p class="p-0 text-uppercase">Từ khóa hot!</p>
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
        <div class="mt-5">
        <a href="#" class="">
          <img src="img/end.jpg" class="w-100 max-100 m-0 p-0 rounded img-fluid" alt="">
        </a>
      </div>
      </div>


      <div class="col-lg-3">
        <p class="fs-16 ms-2 text-uppercase">Truyện xu hướng</p>
        <div class="ms-2 mt-2 pb-2 border-bottom row">
          <div class="col-1 p-0 mt-1 bg-danger rounded sq-2">
            <p class="text-center text-white">01</p>
          </div>
          <div class="col-11">
            <div class="m-0 p-0">Tên truyện</div>
            <div class="row">
              <div class="col-6 fs-12">Chương 123</div>
              <div class="col-6 text-end fs-12 fst-italic">10002</div>
            </div>
          </div>
        </div>

        <div class="ms-2 pb-2 border-bottom mt-2 row">
          <div class="col-1 p-0 mt-1 bg-success rounded sq-2">
            <p class="text-center text-white">02</p>
          </div>
          <div class="col-11">
            <div class="m-0 p-0">Tên truyện</div>
            <div class="row">
              <div class="col-6 fs-12">Chương 123</div>
              <div class="col-6 text-end fs-12 fst-italic">10002</div>
            </div>
          </div>
        </div>

        <div class="ms-2 pb-2 border-bottom mt-2 row">
          <div class="col-1 p-0 mt-1 bg-primary rounded sq-2">
            <p class="text-center text-white">03</p>
          </div>
          <div class="col-11">
            <div class="m-0 p-0">Tên truyện</div>
            <div class="row">
              <div class="col-6 fs-12">Chương 123</div>
              <div class="col-6 text-end fs-12 fst-italic">10002</div>
            </div>
          </div>
        </div>

        <div class="ms-2 pb-2 border-bottom mt-2 row">
          <div class="col-1 p-0 mt-1 bg-secondary rounded sq-2">
            <p class="text-center text-white">04</p>
          </div>

          <div class="col-11">
            <div class="m-0 p-0">Tên truyện</div>
            <div class="row">
              <div class="col-6 fs-12">Chương 123</div>
              <div class="col-6 text-end fs-12 fst-italic">10002</div>
            </div>
          </div>
        </div>

        <div class="ms-2 pb-2 border-bottom mt-2 row">
          <div class="col-1 p-0 h-50 mt-1 bg-secondary rounded sq-2">
            <p class="text-center text-white">05</p>
          </div>
          <div class="col-11">
            <div class="m-0 p-0">Tên truyện</div>
            <div class="row">
              <div class="col-6 fs-12">Chương 123</div>
              <div class="col-6 text-end fs-12 fst-italic">10002</div>
            </div>
          </div>
        </div>

        <div class="ms-2 pb-2 border-bottom mt-2 row">
          <div class="col-1 p-0 h-50 mt-1 bg-secondary rounded sq-2">
            <p class="text-center text-white">06</p>
          </div>
          <div class="col-11">
            <div class="m-0 p-0">Tên truyện</div>
            <div class="row">
              <div class="col-6 fs-12">Chương 123</div>
              <div class="col-6 text-end fs-12 fst-italic">10002</div>
            </div>
          </div>
        </div>

        <div class="ms-2 pb-2 border-bottom mt-2 row">
          <div class="col-1 p-0 h-50 mt-1 bg-secondary rounded sq-2">
            <p class="text-center text-white">07</p>
          </div>
          <div class="col-11">
            <div class="m-0 p-0">Tên truyện</div>
            <div class="row">
              <div class="col-6 fs-12">Chương 123</div>
              <div class="col-6 text-end fs-12 fst-italic">10002</div>
            </div>
          </div>
        </div>

        <div class="ms-2 pb-2 border-bottom mt-2 row">
          <div class="col-1 p-0 h-50 mt-1 bg-secondary rounded sq-2">
            <p class="text-center text-white">08</p>
          </div>
          <div class="col-11">
            <div class="m-0 p-0">Tên truyện</div>
            <div class="row">
              <div class="col-6 fs-12">Chương 123</div>
              <div class="col-6 text-end fs-12 fst-italic">10002</div>
            </div>
          </div>
        </div>

        <div class="ms-2 pb-2 border-bottom mt-2 row">
          <div class="col-1 p-0 h-50 mt-1 bg-secondary rounded sq-2">
            <p class="text-center text-white">09</p>
          </div>
          <div class="col-11">
            <div class="m-0 p-0">Tên truyện</div>
            <div class="row">
              <div class="col-6 fs-12">Chương 123</div>
              <div class="col-6 text-end fs-12 fst-italic">10002</div>
            </div>
          </div>
        </div>

        <div class="ms-2 pb-2 border-bottom mt-2 row">
          <div class="col-1 p-0 h-50 mt-1 bg-secondary rounded sq-2">
            <p class="text-center text-white">10</p>
          </div>
          <div class="col-11">
            <div class="m-0 p-0">Tên truyện</div>
            <div class="row">
              <div class="col-6 fs-12">Chương 123</div>
              <div class="col-6 text-end fs-12 fst-italic">10002</div>
            </div>
          </div>
        </div>

        <div class="ms-2 pb-2 border-bottom mt-2 row">
          <div class="col-1 p-0 h-50 mt-1 bg-secondary rounded sq-2">
            <p class="text-center text-white">11</p>
          </div>
          <div class="col-11">
            <div class="m-0 p-0">Tên truyện</div>
            <div class="row">
              <div class="col-6 fs-12">Chương 123</div>
              <div class="col-6 text-end fs-12 fst-italic">10002</div>
            </div>
          </div>
        </div>

        <div class="ms-2 pb-2 border-bottom mt-2 row">
          <div class="col-1 p-0 h-50 mt-1 bg-secondary rounded sq-2">
            <p class="text-center text-white">12</p>
          </div>
          <div class="col-11">
            <div class="m-0 p-0">Tên truyện</div>
            <div class="row">
              <div class="col-6 fs-12">Chương 123</div>
              <div class="col-6 text-end fs-12 fst-italic">10002</div>
            </div>
          </div>
        </div>

        <div class="ms-2 pb-2 border-bottom mt-2 row">
          <div class="col-1 p-0 h-50 mt-1 bg-secondary rounded sq-2">
            <p class="text-center text-white">13</p>
          </div>
          <div class="col-11">
            <div class="m-0 p-0">Tên truyện</div>
            <div class="row">
              <div class="col-6 fs-12">Chương 123</div>
              <div class="col-6 text-end fs-12 fst-italic">10002</div>
            </div>
          </div>
        </div>

        <p class="ms-2 p-0 mt-2 text-uppercase">
          truyện theo chủ đề
        </p>
        <div class="w-100">
          <a href="#" class="ms-2">
            <img src="img/category1.jpg" alt="" class="img-fluid w-100 max-100">
          </a>
        </div>
        
        <div class="w-100 mt-2">
          <a href="#" class="ms-2">
            <img src="img/category1.jpg" alt="" class="img-fluid w-100 max-100">
          </a>
        </div>

        <div class="w-100 mt-2">
          <a href="#" class="ms-2">
            <img src="img/category1.jpg" alt="" class="img-fluid w-100 max-100">
          </a>
        </div>
      </div>
    </div>
  </div>
@endsection
