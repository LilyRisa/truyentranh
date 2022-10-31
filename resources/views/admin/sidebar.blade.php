<div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
    <div class="c-sidebar-brand d-lg-down-none">
        <svg class="c-sidebar-brand-full" width="118" height="46" alt="CoreUI Logo">
            <use xlink:href="/admin/images/icon-svg/coreui.svg#full"></use>
        </svg>
        <svg class="c-sidebar-brand-minimized" width="46" height="46" alt="CoreUI Logo">
            <use xlink:href="/admin/images/icon-svg/coreui.svg#signet"></use>
        </svg>
    </div>
    <ul class="c-sidebar-nav ps ps--active-y">
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="/admin/home">
                <svg class="c-sidebar-nav-icon">
                    <use xlink:href="/admin/images/icon-svg/free.svg#cil-speedometer"></use>
                </svg>
                Dashboard
            </a>
        </li>
        @if(!empty($permission['category']))
        <li class="c-sidebar-nav-item c-sidebar-nav-dropdown">
            <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
                <svg class="c-sidebar-nav-icon">
                    <use xlink:href="/admin/images/icon-svg/free.svg#cil-list"></use>
                </svg>
                Quản lý Chuyên mục
            </a>
            <ul class="c-sidebar-nav-dropdown-items">
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/admin/category?category_post=0"><span class="c-sidebar-nav-icon"></span> Danh sách</a></li>
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/admin/category/update"><span class="c-sidebar-nav-icon"></span> Thêm mới</a></li>
{{--                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/admin/category/author"><span class="c-sidebar-nav-icon"></span> Tác giả chuyên mục</a></li>--}}
            </ul>
        </li>
        @endif
        @if(!empty($permission['post']))
        <li class="c-sidebar-nav-item c-sidebar-nav-dropdown @if(getCurrentController() == 'post') c-show @endif">
            <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
                <svg class="c-sidebar-nav-icon">
                    <use xlink:href="/admin/images/icon-svg/free.svg#cil-description"></use>
                </svg>
                Quản lý Bài viết
            </a>
            <ul class="c-sidebar-nav-dropdown-items">
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link @if(!empty($_GET['status']) && empty($_GET['hen_gio'])) c-active @endif" href="/admin/post?status=1"><span class="c-sidebar-nav-icon"></span> Bài viết đã đăng</a></li>
{{--                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link @if(!empty($_GET['status']) && !empty($_GET['hen_gio'])) c-active @endif" href="/admin/post?status=1&hen_gio=1"><span class="c-sidebar-nav-icon"></span> Bài viết hẹn giờ</a></li>--}}
{{--                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link {{ request()->is('admin/post') && isset($_GET['status']) && $_GET['status'] == 0 ? 'c-active' : '' }}" href="/admin/post?status=0"><span class="c-sidebar-nav-icon"></span> Bài viết lưu nháp</a></li>--}}
{{--                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link {{ request()->is('admin/post/da-ga') && !isset($_GET['status']) ? 'c-active' : '' }}" href="/admin/post/da-ga"><span class="c-sidebar-nav-icon"></span> Bài viết đá gà </a></li>--}}
{{--                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link {{ request()->is('admin/post/da-ga') && isset($_GET['status']) && $_GET['status'] == 0 ? 'c-active' : '' }}" href="/admin/post/da-ga?status=0"><span class="c-sidebar-nav-icon"></span> Bài viết đá gà lưu nháp</a></li>--}}
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/admin/post/update"><span class="c-sidebar-nav-icon"></span> Thêm mới</a></li>
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/admin/tag"><span class="c-sidebar-nav-icon"></span> Quản lý tag</a></li>
                {{-- <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link {{request()->is('admin/video') ? 'c-active' : ''}}" href="{{route('video').'?is_status=1'}}"><span class="c-sidebar-nav-icon"></span> Quản lý video</a></li> --}}
            </ul>
        </li>
        @endif

        @if(!empty($permission['story']))
        <li class="c-sidebar-nav-item c-sidebar-nav-dropdown @if(getCurrentController() == 'story') c-show @endif">
            <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
                <svg class="c-sidebar-nav-icon">
                    <use xlink:href="/admin/images/icon-svg/free.svg#cil-book"></use>
                </svg>
                Quản lý truyện
            </a>
            <ul class="c-sidebar-nav-dropdown-items">
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link @if(!empty($_GET['status']) && empty($_GET['hen_gio'])) c-active @endif" href="/admin/story?status=1"><span class="c-sidebar-nav-icon"></span> Danh sách truyện</a></li>
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link @if(!empty($_GET['status']) && empty($_GET['hen_gio'])) c-active @endif" href="/admin/chapter?status=1"><span class="c-sidebar-nav-icon"></span> Danh sách chapter</a></li>
{{--                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link @if(!empty($_GET['status']) && !empty($_GET['hen_gio'])) c-active @endif" href="/admin/post?status=1&hen_gio=1"><span class="c-sidebar-nav-icon"></span> Bài viết hẹn giờ</a></li>--}}
{{--                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link {{ request()->is('admin/post') && isset($_GET['status']) && $_GET['status'] == 0 ? 'c-active' : '' }}" href="/admin/post?status=0"><span class="c-sidebar-nav-icon"></span> Bài viết lưu nháp</a></li>--}}
{{--                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link {{ request()->is('admin/post/da-ga') && !isset($_GET['status']) ? 'c-active' : '' }}" href="/admin/post/da-ga"><span class="c-sidebar-nav-icon"></span> Bài viết đá gà </a></li>--}}
{{--                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link {{ request()->is('admin/post/da-ga') && isset($_GET['status']) && $_GET['status'] == 0 ? 'c-active' : '' }}" href="/admin/post/da-ga?status=0"><span class="c-sidebar-nav-icon"></span> Bài viết đá gà lưu nháp</a></li>--}}
                {{-- <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link {{request()->is('admin/video') ? 'c-active' : ''}}" href="{{route('video').'?is_status=1'}}"><span class="c-sidebar-nav-icon"></span> Quản lý video</a></li> --}}
            </ul>
        </li>
        @endif


        @if(!empty($permission['page']))
            <li class="c-sidebar-nav-item c-sidebar-nav-dropdown @if(getCurrentController() == 'page') c-show @endif">
                <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
                    <svg class="c-sidebar-nav-icon">
                        <use xlink:href="/admin/images/icon-svg/free.svg#cil-notes"></use>
                    </svg>
                    Quản lý Page tĩnh
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link @if(!empty($_GET['status'])) c-active @endif" href="/admin/page?status=1"><span class="c-sidebar-nav-icon"></span> Page tĩnh đã đăng</a></li>
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link @if(isset($_GET['status']) && $_GET['status'] == 0) c-active @endif" href="/admin/page?status=0"><span class="c-sidebar-nav-icon"></span> Page tĩnh lưu nháp</a></li>
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/admin/page/update"><span class="c-sidebar-nav-icon"></span> Thêm mới</a></li>
                </ul>
            </li>
        @endif

        @if(!empty($permission['post']))
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link"
                   href="#"
                   onclick="MyWindow=window.open('https://thichdammy.com/admin/libraries/elfinder/file-elfinder.php?mode=chosefile&control=img#elf_l1_Lw','MyWindow','width=800,height=600'); return false;">
                    <svg class="c-sidebar-nav-icon">
                        <use xlink:href="/admin/images/icon-svg/free.svg#cil-image-plus"></use>
                    </svg>
                    Quản lý Media
                </a>
            </li>
        @endif

        @if(!empty($permission['shortcode']))
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="/admin/shortcode">
                <svg class="c-sidebar-nav-icon">
                    <use xlink:href="/admin/images/icon-svg/free.svg#cil-tag"></use>
                </svg>
                Quản lý short code
            </a>
        </li>
        @endif

        @if(!empty($permission['googleindex']))
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href="/admin/google_index">
                    <svg class="c-sidebar-nav-icon">
                        <use xlink:href="/admin/images/icon-svg/free.svg#cil-audio"></use>
                    </svg>
                    Google index
                </a>
            </li>
        @endif

        @if(!empty($permission['internallink']))
                <li class="c-sidebar-nav-item c-sidebar-nav-dropdown">
                    <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
                        <svg class="c-sidebar-nav-icon">
                            <use xlink:href="/admin/images/icon-svg/free.svg#cil-touch-app"></use>
                        </svg>
                        Internal Link
                    </a>
                    <ul class="c-sidebar-nav-dropdown-items">
                        <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/admin/internal_link"><span class="c-sidebar-nav-icon"></span> Danh sách </a></li>
                        <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/admin/internal_link/update"><span class="c-sidebar-nav-icon"></span> Thêm mới</a></li>
                    </ul>
                </li>
            @endif

        @if(!empty($permission['banner']))
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href="/admin/banner">
                    <svg class="c-sidebar-nav-icon">
                        <use xlink:href="/admin/images/icon-svg/free.svg#cil-terrain"></use>
                    </svg>
                    Quản lý Banner
                </a>
            </li>
        @endif
        @if(!empty($permission['user']))
        <li class="c-sidebar-nav-item c-sidebar-nav-dropdown">
            <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
                <svg class="c-sidebar-nav-icon">
                    <use xlink:href="/admin/images/icon-svg/free.svg#cil-user"></use>
                </svg>
                Quản lý Thành viên
            </a>
            <ul class="c-sidebar-nav-dropdown-items">
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/admin/user"><span class="c-sidebar-nav-icon"></span> Danh sách</a></li>
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/admin/user/update"><span class="c-sidebar-nav-icon"></span> Thêm mới</a></li>
            </ul>
        </li>
        @endif
        @if(!empty($permission['group']))
        <li class="c-sidebar-nav-item c-sidebar-nav-dropdown">
            <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
                <svg class="c-sidebar-nav-icon">
                    <use xlink:href="/admin/images/icon-svg/free.svg#cil-lock-locked"></use>
                </svg>
                Quản lý Nhóm quyền
            </a>
            <ul class="c-sidebar-nav-dropdown-items">
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/admin/group"><span class="c-sidebar-nav-icon"></span> Danh sách</a></li>
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/admin/group/update"><span class="c-sidebar-nav-icon"></span> Thêm mới</a></li>
            </ul>
        </li>
        @endif
        @if(!empty($permission['site_setting']))
            <li class="c-sidebar-nav-item c-sidebar-nav-dropdown">
                <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
                    <svg class="c-sidebar-nav-icon">
                        <use xlink:href="/admin/images/icon-svg/free.svg#cil-settings"></use>
                    </svg>
                    Cài đặt chung
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/admin/redirect"><span class="c-sidebar-nav-icon"></span> Cấu hình Redirect</a></li>
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/admin/menu"><span class="c-sidebar-nav-icon"></span> Cấu hình Menu</a></li>
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/admin/site_setting/update"><span class="c-sidebar-nav-icon"></span> Thông tin trang</a></li>
{{--                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/admin/site_setting/daga"><span class="c-sidebar-nav-icon"></span> Cấu hình đá gà</a></li>--}}
                </ul>
            </li>
        @endif
    </ul>
    <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent" data-class="c-sidebar-minimized"></button>
</div>
