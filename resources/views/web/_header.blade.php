<div>
  
<nav class="navbar p-0 navbar-expand-lg navbar-dark bg_primary">
    <div class="container-lg">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03"
        aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <a href="/"> <img class="top-bar-logo" src="img/logo.png"> </a>
      <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item ms-3">
            <a class="nav-link active" aria-current="page" href="#">TRANG CHỦ</a>
          </li>
          <li class="nav-item ms-3">
            <a class="nav-link text-uppercase" href="#">TRUYỆN MỚI</a>
          </li>
          <li class="nav-item ms-3 text-uppercase">
            <a class="nav-link" href="#">BXH</a>
          </li>
          <li class="nav-item ms-3">
            <a class="nav-link text-uppercase" href="#">LỌC TRUYỆN</a>
          </li>
          <li class="nav-item ms-3 dropdown">
            <a class="bg_primary border-0 dropdown-toggle nav-link text-uppercase" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
              Thể loại
            </a>
            <ul class="dropdown-menu bg_secondary text-white mt-3" aria-labelledby="dropdownMenuLink">
              <div class="d-flex w-100 h-50 text-white">
                <div class="col-4">
              <li><a class="dropdown-item text-uppercase text-white hover-dr" href="#">Drama</a></li>
              <li><a class="dropdown-item text-uppercase text-white hover-dr" href="#">Ecchi</a></li>
              <li><a class="dropdown-item text-uppercase text-white hover-dr" href="#">Ecchi</a></li>
              </div>

              <div class="col-4">
              <li><a class="dropdown-item text-uppercase text-white hover-dr" href="#">teacher</a></li>
              <li><a class="dropdown-item text-uppercase text-white hover-dr" href="#">gangbang</a></li>
              <li><a class="dropdown-item text-uppercase text-white hover-dr" href="#">shounen</a></li>
              </div>

              <div class="col-4">
              <li><a class="dropdown-item text-uppercase text-white hover-dr" href="#">hentai</a></li>
              <li><a class="dropdown-item text-uppercase text-white hover-dr" href="#">horror</a></li>
              <li><a class="dropdown-item text-uppercase text-white hover-dr" href="#">drama</a></li>
              </div>

              </div>
            </ul>
          </li>
            
          
          



        </ul>
        <div class="h-100 align-items-center">
          <form class="d-flex mt-3">
            <div class="d-flex">
              <input type="text" class="form-control w-50 rounded-pill-left border-0 border-right-none" placeholder="search"
                aria-label="search" aria-describedby="basic-addon2">
              <div class="input-group-append h-100">
                <button class="input-group-text rounded-pill-right bg-white shadow-none border-0 border-left-none h-100" id="basic-addon2"><i class="icon-search fs-16"></i></button>
              </div>
            </div>
    </nav>
 
    <div class="modal" id="menuMobile">
        <div class="modal-dialog my-0">
            <div class="modal-content animate-left-right border-0">

                <!-- Modal Header -->
                <div class="modal-header px-2 flex-wrap">
                    <form action="{{ env('APP_URL') }}" method="get" class="border rounded-pill pl-3 pr-2 d-flex justify-content-between col-10">
                        <input name="s" class="form-control border-0 w-75" placeholder="Search..." type="text" value="" autocomplete="off">
                        <button type="submit" class="btn">
                            <i class="icon-search"></i>
                        </button>
                    </form>
                    <button type="button" class="close col-2 p-0 m-0 font-38" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body px-0">
                    <ul class="nav flex-column">
                        <li class="nav-item px-2 py-1 @if(empty($oneItem->slug)) active @endif">
                            <a class="nav-link text-black1 font-14 font-weight-bold position-relative" href="/">TRANG CHỦ</a>
                        </li>
                        @if(!empty($MainMenu))
                            @foreach($MainMenu as $value)
                                <li class="nav-item px-2 py-1 @if(!empty($value['children'])) dropdown d-flex flex-wrap @endif @if(!empty($oneItem->slug) && ("/$oneItem->slug/" == $value['url'])) active @endif">
                                    <a class="nav-link text-black1 font-14 font-weight-bold text-uppercase d-inline-block position-relative" href="{{ getUrlLink($value['url']) }}" title="{{$value['name']}}">{{$value['name']}}</a>
                                    @if(!empty($value['children']))
                                        <a href="javascript:;" class="btn px-lg-0 showSubmenuMobile">
                                            <i class="icon-cheveron-down"></i>
                                        </a>
                                        <div class="dropdown-content mx-2 bg-white">
                                            @foreach($value['children'] as $item)
                                                <a class="d-block font-13 text-grey1 text-decoration-none border-bottom px-3 py-2" href="{{ getUrlLink($item['url']) }}" title="{{$item['name']}}">{{$item['name']}}</a>
                                            @endforeach
                                        </div>
                                    @endif
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>


</div>
