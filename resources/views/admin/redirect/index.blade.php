@extends('admin.layout')
@section('content')
    <main class="c-main">
        <div class="container-fluid">
            <div class="fade-in">
                <div class="card">
                    <div class="card-header">
                        Danh sách Link
                        <div class="card-header-actions pr-1">
                            <a href="/admin/redirect/update"><button class="btn btn-block btn-primary btn-sm mr-3" type="button">Thêm mới</button></a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered datatable">
                            <thead>
                            <tr>
                                <th>Link gốc</th>
                                <th>Link mới</th>
                                <th class="text-center w-15">Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($listItem)) @foreach($listItem as $item)
                            <tr>
                                <td>{{$item->original_url}}</td>
                                <td>{{$item->target_url}}</td>
                                <td class="text-center">
                                    <a class="btn btn-info" href="/admin/redirect/update/{{$item->id}}">
                                        <svg class="c-icon">
                                            <use xlink:href="/admin/images/icon-svg/free.svg#cil-pencil"></use>
                                        </svg>
                                    </a>
                                    <a class="btn btn-danger" onclick="return confirm('Bạn có chắc muốn xóa?')"
                                       href="/admin/redirect/delete/{{$item->id}}">
                                        <svg class="c-icon">
                                            <use xlink:href="/admin/images/icon-svg/free.svg#cil-trash"></use>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                            @endforeach @endif
                            </tbody>
                        </table>
                        <ul class="pagination">
                            @if($page > 1)
                                <li class="page-item">
                                    <a class="page-link" href="/admin/redirect/{{$page-1}}">Prev</a>
                                </li>
                            @endif
                            @for($i = 1; $i <= $pagination; $i++)
                                <li class="page-item @if($i == $page) active @endif">
                                    <a class="page-link" href="/admin/redirect/{{$i}}">{{$i}}</a>
                                </li>
                            @endfor
                            <li class="page-item">
                                <a class="page-link" href="/admin/redirect/{{$page+1}}">Next</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
