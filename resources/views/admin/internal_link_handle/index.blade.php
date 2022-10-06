@extends('admin.layout')
@section('content')
    <main class="c-main">
        <div class="container-fluid">
            <div class="fade-in">
                <div class="card">
                    <div class="card-header">
                        Danh sách Internal Link
                        <div class="card-header-actions pr-1">
                            <a href="/admin/internal_link/update"><button class="btn btn-block btn-primary btn-sm mr-3" type="button">Thêm mới</button></a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="setting">
                            <div class="d-flex my-3">                             
                                <div class="col col-3">
                                    <label for="">Mật độ</label>
                                    <input type="text" name="matdo" class="form-control" value="{{$setting[1]->setting}}">
                                </div>
                                <div class="col col-3">
                                    <label for="">Số lượng link</label>
                                    <input type="text" name="soluong" class="form-control" value="{{$setting[0]->setting}}">
                                </div>

                                <div class="col col-3 d-flex align-items-end">
                                    <input type="submit" class="btn btn-success" value="cập nhật">
                                </div>
                            </div>
                        </form>
                        <table class="table table-striped table-bordered datatable">
                            <thead>
                            <tr>
                                <th class="text-center w-5">ID</th>
                                <th>Tiêu đề</th>
{{--                                <th>Trạng thái </th>--}}
                                <th>Từ khóa</th>
                                <th>Đường dẫn</th>
                                <th class="text-center w-15">Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($listItem)) @foreach($listItem as $item)
                                <tr>
                                    <td class="text-center">{{$item->id}}</td>
                                    <td>{{$item->title}}</td>
{{--                                    <td>{{$item->is_status}}</td>--}}
                                    <td>{{$item->keyword}}</td>
                                    <td>{{$item->href}}</td>
                                    <td class="text-center">
                                        <a class="btn btn-info" href="/admin/internal_link/update/{{$item->id}}"><svg class="c-icon"><use xlink:href="/admin/images/icon-svg/free.svg#cil-pencil"></use></svg></a>
                                        <a class="btn btn-danger" onclick="return confirm('Bạn có chắc muốn xóa?')" href="/admin/internal_link/delete/{{$item->id}}"><svg class="c-icon"><use xlink:href="/admin/images/icon-svg/free.svg#cil-trash"></use></svg></a>
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
