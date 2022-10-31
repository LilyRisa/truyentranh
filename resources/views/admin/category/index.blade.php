@extends('admin.layout')
@section('content')
    <main class="c-main">
        <div class="container-fluid">
            <div class="fade-in">
                <div class="card">
                    <div class="card-header">
                        {{$category_post == 1 ? 'Danh sách chuyên mục bài viết' : 'Danh sách chuyên mục truyện'}}
                        
                        <div class="card-header-actions pr-1">
                            <a href="/admin/category/update"><button class="btn btn-block btn-primary btn-sm mr-3" type="button">Thêm mới</button></a>
                        </div>
                    </div>
                    <div class="px-4">
                        <div class="col-6 px-0">
                            <label for="">Loại chuyên mục</label>
                            <select class="form-control" onchange="this.options[this.selectedIndex].value && (window.location = '/admin/category?category_post='+this.options[this.selectedIndex].value);">
                                <option value="0" {{$category_post == 0 ? 'selected' : ''}}>Chuyên mục truyện</option>
                                <option value="1" {{$category_post == 1 ? 'selected' : ''}}>Chuyên mục bài viết</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered datatable">
                            <thead>
                            <tr>
                                <th class="text-center w-5">ID</th>
                                <th>Tiêu đề</th>
                                <th>Loại chuyên mục</th>
                                <th class="text-center w-15">Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                                @if(!empty($listItem)) @foreach($listItem as $item)
                                <tr>
                                    <td class="text-center">{{$item->id}}</td>
                                    <td><a target="_blank" href="{{getUrlCate($item, 0)}}">{{$item->title}}</a> - @if($category_post == 1)<span class="text-success">{{$item->count_post}} bài viết</span> @else <span class="text-success">{{$item->count_story}} truyện</span> @endif</td>
                                    <td class="text-center">{{$category_post == 1 ? 'Chuyên mục bài viết' : 'Chuyên mục truyện'}}</td>
                                    <td class="text-center">
                                        <a class="btn btn-info" href="/admin/category/update/{{$item->id}}"><svg class="c-icon"><use xlink:href="/admin/images/icon-svg/free.svg#cil-pencil"></use></svg></a>
                                        <a class="btn btn-danger" onclick="return confirm('Bạn có chắc muốn xóa?')" href="/admin/category/delete/{{$item->id}}"><svg class="c-icon"><use xlink:href="/admin/images/icon-svg/free.svg#cil-trash"></use></svg></a>
                                    </td>
                                </tr>
                                @endforeach @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
