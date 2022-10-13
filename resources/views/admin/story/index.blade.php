@extends('admin.layout')
@section('content')
    <main class="c-main">
        <div class="container-fluid">
            <div class="fade-in">
                <div class="card">
                    <div class="card-header">
                        Danh sách bài viết ({{$total}})
                        <div class="card-header-actions pr-1">
                            <a href="/admin/story/update"><button class="btn btn-block btn-primary btn-sm mr-3" type="button">Thêm mới</button></a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="get" action="">
                            <div class="form-group row">
                                <div class="col-4">
                                    <input type="text" name="title" class="form-control" value="{{isset($_GET['title'])? $_GET['title'] : ''}}" placeholder="Tiêu đề">
                                </div>
                                <div class="col-3">
                                    <input type="text" name="time_range" class="form-control datetimes" data-date="{{isset($_GET['time_range'])? $_GET['time_range'] : ''}}" value="{{isset($_GET['time_range'])? $_GET['time_range'] : ''}}" placeholder="Khoảng thời gian">
                                </div>
                                <div class="col-2">
                                    <select name="category_id" class="form-control">
                                        <option value="">Chuyên mục chính</option>
                                        @foreach($categoryTree as $item)
                                            <option value="{{$item['id']}}" {{!empty($_GET['category_id']) && $item['id'] == $_GET['category_id'] ? 'selected': ''}}>{{$item['title']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-2">
                                    <select name="user_id" class="form-control">
                                        <option value="">Thành viên</option>
                                        @foreach($listUser as $item)
                                            <option value="{{$item['id']}}" {{!empty($_GET['user_id']) && $item['id'] == $_GET['user_id'] ? 'selected': ''}}>{{$item['username']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <input type="hidden" name="status" value="{{$_GET['status']}}">
                                @if(isset($_GET['hen_gio']))
                                <input type="hidden" name="hen_gio" value="{{$_GET['hen_gio']}}">
                                @endif
                                
                            </div>
                            <div class="form-group row">
                                <div class="d-flex col-2 ml-auto">
                                    <input type="submit" class="btn btn-success" value="Tìm kiếm">
                                    <input id="reset_form" class="btn btn-primary col-6 ml-3" value="Reset bộ lọc">
                                </div>
                            </div>
                         
                                
                            
                        </form>
                        <table class="table table-striped table-bordered datatable">
                            <thead>
                            <tr>
                                <th class="text-center w-5">ID</th>
                                <th>Tiêu đề</th>
                                <th class="text-center w-15">Chuyên mục</th>
                                <th class="text-center w-15">Số chapter</th>
                                <th class="text-center w-10">Ngày tạo</th>
                                <th class="text-center w-10">Điểm SEO</th>
                                <th class="text-center w-10">Thumbnail</th>
                                <th class="text-center w-10">Nổi bật trang chủ</th>
                                {{--<th class="text-center w-10">Link</th>--}}
                                <th class="text-center w-15">Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($listItem)) @foreach($listItem as $item)
                            <tr>
                                <td class="text-center align-middle">{{$item->id}}</td>
                                <td class="align-middle"><a target="_blank" rel="nofollow" href="{{ getUrlPost($item, 0) }}">{!! $item->title !!}</a></td>
                                <td class="text-center align-middle">{{$item->categories[0]->title ?? ''}}</td>
                                <td class="text-center align-middle">{{count($item->chapter)}}</td>
                                <td class="text-center align-middle">{{date('d-m-Y H:i', strtotime($item->created_at))}}</td>
                                <td class="text-center align-middle"><span class="@if(empty($item->seo_score)) @elseif($item->seo_score <= 60) bg-danger @elseif($item->seo_score >= 61 && $item->seo_score <= 89) bg-warning @else bg-success @endif text-white p-2">{{$item->seo_score ?? ''}}</span></td>
                                <td class="text-center align-middle"><img src="{{getThumbnail($item->thumbnail)}}" width="100px" height="100px" style="object-fit: cover"></td>
                                <td class="text-center">
                                   <a href="#" class="home_feature star_home" data-id="{{$item->id}}" style="{{$item->is_feature_home ? 'color: yellow;' : ''}}">
                                    <svg class="c-icon">
                                        <use xlink:href="/admin/images/icon-svg/free.svg#cil-star"></use>
                                    </svg>
                                   </a>
                                </td>
                                <td class="text-center">
                                    <a class="btn btn-info" href="/admin/story/update/{{$item->id}}">
                                        <svg class="c-icon">
                                            <use xlink:href="/admin/images/icon-svg/free.svg#cil-pencil"></use>
                                        </svg>
                                    </a>
                                    <a class="btn btn-danger" onclick="return confirm('Bạn có chắc muốn xóa?')"
                                       href="/admin/story/delete/{{$item->id}}">
                                        <svg class="c-icon">
                                            <use xlink:href="/admin/images/icon-svg/free.svg#cil-trash"></use>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                            @endforeach @endif
                            </tbody>
                        </table>
                        @php init_cms_pagination($page, $pagination) @endphp
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
