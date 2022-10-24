@extends('web.layout')
@section('main')
    <div class="container mt-5">
    <div class="row justify-content-between mt-am-2">
        <div class="col-lg-8 row">
            <div class="col-lg-12 col-12 mt-2">
                <div class="card mb-3">
                    <div class="row g-0">
                      <div class="col-md-4">
                        <img src="/img/book1.jpeg" style="height: 100%" class="img-fluid rounded-start" alt="...">
                      </div>
                      <div class="col-md-8">
                        <div class="card-body">
                          <h5 class="card-title">Long Đàm</h5>
                          <p class="card-text"><small class="text-muted">Thứ 4, 22/11/2022</small></p>
                          <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                          <button class="btn bg_secondary text-white">Đọc ngay</button>
                         
                        </div>
                      </div>
                    </div>
                  </div>
            </div>
            @for($i=0;$i<24;$i++)
                <div class="col-lg-6 col-12 mt-2">
                    <div class="card mb-3">
                        <div class="row g-0">
                          <div class="col-md-5">
                            <img src="/img/book1.jpeg" style="height: 100%" class="img-fluid rounded-start" alt="...">
                          </div>
                          <div class="col-md-7">
                            <div class="card-body">
                              <h5 class="card-title">Đồng chí</h5>
                              <p class="card-text"><small class="text-muted">Thứ 4, 22/11/2022</small></p>
                              <p class="card-text max-line-3">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                              <button class="btn text-white bg_secondary">Đọc ngay</button>
                              
                            </div>
                          </div>
                        </div>
                      </div>
                </div>
            @endfor

            <div class="text-center">
                <button class="btn btn-secondary bg-white text-dark mt-2">Xem thêm <span class="icon-arrow_forward_ios"></span></button>
            </div>
        </div>
        
        <div class="col-lg-4">

            <div class="blog-post">
                <!-- Search -->
                <h2>Tìm kiếm</h2>
                        <form action="" method="get" class="input-group search-text">
                    <input type="text" class="form-control search" name="product_search" placeholder="Tìm kiếm..">
                    <span class="input-group-btn">
                        <button class="btn btn-default btn-search" type="submit"><i class="fa fa-search"></i></button>
                    </span>
                </form>        
                <!-- Recent Posts -->
                <h2>Bài viết mới nhất</h2>
                        <ul class="list-unstyled">
                            <li class="list-unstyled">
                                <a href="text-decoration">Truyện đam mỹ hay nhất 2021</a>
                            </li>
                            <li class="list-unstyled">
                                <a href="text-decoration">Truyện đam mỹ hay nhất 2022</a>
                            </li>
                            </ul>
                        <!-- Tags -->
                <h2>Tags</h2>
                        <div class="tags">
                            </div>
                    </div>
        </div>
    </div>
    </div>
@endsection