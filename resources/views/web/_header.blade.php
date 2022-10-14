<div>

    <nav class="navbar p-0 navbar-expand-lg navbar-dark bg_primary main-navigation">
        <div class="container-lg">
            <button class="navbar-toggler py-2 my-3" type="button">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="overlay d-flex d-lg-none"> </div>
            <a href="/" class="text-center mx-auto mx-lg-0"> <img class="top-bar-logo" src="img/logo.png"> </a>
            <div class="navbar-collapse collapse order-lg-2 bg_primary pb-3 pb-lg-0 d-lg-flex w-100 d-lg-block">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item ms-3">
                        <a class="nav-link active text-nowrap" aria-current="page" href="#">TRANG CHỦ</a>
                    </li>
                    <li class="nav-item ms-3">
                        <a class="nav-link text-uppercase text-nowrap" href="#">TRUYỆN MỚI</a>
                    </li>
                    <li class="nav-item ms-3 text-uppercase">
                        <a class="nav-link" href="#">BXH</a>
                    </li>
                    <li class="nav-item ms-3">
                        <a class="nav-link text-uppercase text-nowrap" href="#">LỌC TRUYỆN</a>
                    </li>
                    <li class="nav-item ms-3 dropdown">
                        <a class="bg_primary border-0 dropdown-toggle nav-link text-uppercase text-nowrap" href="#"
                            role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            Thể loại
                        </a>
                        <ul class="dropdown-menu bg_secondary text-white mt-3" aria-labelledby="dropdownMenuLink">
                            <div class="d-flex w-100 h-50 text-white">
                                <div class="col-4">
                                    <li><a class="dropdown-item text-white hover-dr"
                                            href="#">Drama</a></li>
                                    <li><a class="dropdown-item text-white hover-dr"
                                            href="#">Ecchi</a></li>
                                    <li><a class="dropdown-item text-white hover-dr"
                                            href="#">Ecchi</a></li>
                                </div>

                                <div class="col-4">
                                    <li><a class="dropdown-item text-white hover-dr"
                                            href="#">Teacher</a></li>
                                    <li><a class="dropdown-item text-white hover-dr"
                                            href="#">Gangbang</a></li>
                                    <li><a class="dropdown-item text-white hover-dr"
                                            href="#">Shounen</a></li>
                                </div>

                                <div class="col-4">
                                    <li><a class="dropdown-item text-white hover-dr"
                                            href="#">Hentai</a></li>
                                    <li><a class="dropdown-item text-white hover-dr"
                                            href="#">Horror</a></li>
                                    <li><a class="dropdown-item text-white hover-dr"
                                            href="#">Drama</a></li>
                                </div>

                            </div>
                        </ul>
                    </li>
                </ul>
                <div class="h-100 align-items-center">
                    <form class="d-flex mt-3">
                        <div class="d-flex">
                            <input type="text" class="form-control w-50 rounded-pill-left ms-3 border-0 border-right-none bg-grey1"
                                placeholder="search" aria-label="search" aria-describedby="basic-addon2">
                            <div class="input-group-append h-100">
                                <button
                                    class="input-group-text rounded-pill-right bg-white shadow-none border-0 border-left-none h-100 bg-grey1"
                                    id="basic-addon2"><i class="icon-search fs-16"></i></button>
                            </div>
                        </div>
                    </form>

                </div>
                <div class="navbar-nav">
                    <div class="input-group-text bg_primary border-0 p-0">
                        <a href="#" class="h-100 text-decoration-none ms-3"><span
                                class="icon-history text-white"></span><span
                                class="ms-2 text-light mt-1 fs-18">History</span></a>
                    </div>
                    <div class="input-group-text bg_primary border-0 p-0">
                        <a href="#" class="h-100 text-decoration-none ms-3"><span
                                class="icon-mobile2 text-white"></span><span class="ms-2 text-light mt-1 fs-18">Get
                                App</span></a>
                    </div </div>
                </div>
            </div>
        </div>
        {{-- mobile --}}
        <div class="sidebar order-lg-2 bg-dark d-lg-none d-block w-100 sidebar pb-3 pb-lg-0">
            <div class="align-items-center ms-3">
                <form class="d-flex mt-3" style="heigth:1rem">
                    <div class="d-flex">
                        <input type="text" class="form-control fs-22 w-75 rounded-pill-left border-0 border-right-none"
                            placeholder="search" aria-label="search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button
                                class="input-group-text rounded-pill-right bg-white shadow-none border-0 border-left-none h-100"
                                id="basic-addon2"><i class="icon-search fs-20"></i></button>
                        </div>
                    </div>
                </form>
            </div>
            <ul class="navbar-nav mb-2 mb-lg-0 pt-4 mt-4 border-top">
                <li class="nav-item ms-4">
                    <a class="nav-link active fs-22" aria-current="page" href="#">TRANG CHỦ</a>
                </li>
                <li class="nav-item ms-4 mt-1">
                    <a class="nav-link text-uppercase fs-22" href="#">TRUYỆN MỚI</a>
                </li>
                <li class="nav-item ms-4 text-uppercase mt-1">
                    <a class="nav-link fs-22" href="#">BXH</a>
                </li>
                <li class="nav-item ms-4 mt-1">
                    <a class="nav-link text-uppercase fs-22" href="#">LỌC TRUYỆN</a>
                </li>
                <li class="nav-item ms-4 dropdown mt-1">
                    <a class="bg_dark border-0 dropdown-toggle nav-link text-uppercase fs-22" href="#"
                        role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                        Thể loại
                    </a>
                    <ul class="dropdown-menu bg-dark text-white mt-1" aria-labelledby="dropdownMenuLink">
                        <div class="d-flex w-100 h-50 text-white">
                            <div class="col-12">
                                <li><a class="dropdown-item text-white hover-dr fs-20"
                                        href="#">Drama</a></li>
                                <li><a class="dropdown-item text-white hover-dr fs-20"
                                        href="#">Ecchi</a></li> 
                                <li><a class="dropdown-item text-white hover-dr fs-20"
                                        href="#">Ecchi</a></li>
                                <li><a class="dropdown-item text-white hover-dr fs-20"
                                        href="#">Teacher</a></li>
                                <li><a class="dropdown-item text-white hover-dr fs-20"
                                        href="#">Gangbang</a></li>
                                <li><a class="dropdown-item text-white hover-dr fs-20"
                                        href="#">Shounen</a></li>
                            </div>
                        </div>
                    </ul>
                </li>
            </ul>
            <div class="navbar-nav mt-4 border-top">
                <div class="input-group-text bg-dark border-0 p-0 mt-4">
                    <a href="#" class="h-100 text-decoration-none ms-4"><span
                            class="icon-history text-white fs-22"></span><span
                            class="ms-2 text-light mt-1 fs-22">History</span></a>
                </div>
                <div class="input-group-text bg-dark border-0 p-0 mt-4">
                    <a href="#" class="h-100 text-decoration-none ms-4"><span
                            class="icon-mobile2 text-white fs-22"></span><span class="ms-2 text-light mt-1 fs-22">Get
                            App</span></a>
                </div </div>
            </div>
        </div>
        {{-- mobile --}}
    </nav>
</div>
