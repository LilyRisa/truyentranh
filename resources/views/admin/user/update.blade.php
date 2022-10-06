{{-- @extends('admin.layout')
@section('content')
    <main class="c-main">
        <div class="container-fluid">
            <div class="fade-in">
                <form method="post" action="">
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="card">
                                <div class="card-header"><strong>{{!empty($oneItem) ? 'Chỉnh sửa' : 'Thêm mới'}} thành viên</strong></div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Tài khoản</label>
                                                <input class="form-control" {{empty($oneItem) ? 'name=username required' : ''}} value="{{!empty($oneItem->username) ? $oneItem->username : ''}}" type="text" placeholder="Tài khoản">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Mật khẩu</label>
                                                <input class="form-control" {{empty($oneItem) ? 'required' : ''}} name="password" type="password" placeholder="Mật khẩu">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Xác nhận mật khẩu</label>
                                                <input class="form-control" {{empty($oneItem) ? 'required' : ''}} type="password" placeholder="Xác nhận mật khẩu">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="card">
                                <div class="card-header"><strong>Thông tin khác</strong></div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Chức vụ</label>
                                        <select name="group_id" class="form-control">
                                            @foreach($listGroup as $item)
                                            <option {{isset($oneItem->group_id) && $oneItem->group_id == $item->id ? 'selected' : ''}} value="{{$item->id}}">{{$item->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Trạng thái</label>
                                        <select name="status" class="form-control">
                                            <option {{isset($oneItem->status) && $oneItem->status == 1 ? 'selected' : ''}} value="1">Hoạt động</option>
                                            <option {{isset($oneItem->status) && $oneItem->status == 0 ? 'selected' : ''}} value="0">Không hoạt động</option>
                                        </select>
                                    </div>
                                    <div class="form-group float-right">
                                        <button type="submit" class="btn btn-primary">Lưu trữ</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection --}}


@extends('admin.layout')
@section('content')
    <main class="c-main">
        <div class="container-fluid">
            <div class="fade-in">
                <form method="post" action="">
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="card">
                                <div class="card-header"><strong>{{!empty($oneItem) ? 'Chỉnh sửa' : 'Thêm mới'}} thành viên</strong></div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Tài khoản</label>
                                                <input class="form-control" {{empty($oneItem) ? 'name=username required' : ''}} value="{{!empty($oneItem->username) ? $oneItem->username : ''}}" type="text" placeholder="Tài khoản">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input class="form-control" name="email" {{!empty($oneItem) ? 'disabled' : ''}} value="{{!empty($oneItem->email) ? $oneItem->email : ''}}" type="text" placeholder="Email">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Mật khẩu</label>
                                                <input class="form-control" {{empty($oneItem) ? 'required' : ''}} name="password" type="password" placeholder="Mật khẩu">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Xác nhận mật khẩu</label>
                                                <input class="form-control" {{empty($oneItem) ? 'required' : ''}} type="password" placeholder="Xác nhận mật khẩu">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Tên tác giả</label>
                                                <input class="form-control" name="fullname" value="{{$oneItem->fullname ?? ''}}" type="text" placeholder="Tên tác giả">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Url tác giả</label>
                                                <input class="form-control" name="slug" value="{{$oneItem->slug ?? ''}}" type="text" placeholder="Url tác giả">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Mô tả</label>
                                                <textarea class="form-control tiny-featured" rows="4" name="description">{{$oneItem->description ?? ''}}</textarea>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Facebook</label>
                                                <input class="form-control" name="option[facebook]" value="{{$oneItem->option->facebook ?? ''}}" type="text" placeholder="Facebook">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Twitter</label>
                                                <input class="form-control" name="option[twitter]" value="{{$oneItem->option->twitter ?? ''}}" type="text" placeholder="Twitter">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Instagram</label>
                                                <input class="form-control" name="option[instagram]" value="{{$oneItem->option->instagram ?? ''}}" type="text" placeholder="Instagram">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Reddit</label>
                                                <input class="form-control" name="option[reddit]" value="{{$oneItem->option->reddit ?? ''}}" type="text" placeholder="Reddit">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="card">
                                <div class="card-header"><strong>Thông tin khác</strong></div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Chức vụ</label>
                                        <select name="group_id" class="form-control">
                                            @foreach($listGroup as $item)
                                            <option {{isset($oneItem->group_id) && $oneItem->group_id == $item->id ? 'selected' : ''}} value="{{$item->id}}">{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Thumbnail</label>
                                        @if(!empty($oneItem->thumbnail))
                                            <img style="width: 150px; height:auto" src="{{$oneItem->thumbnail}}" id="lbl_img" class="img-fluid d-block" onclick="upload_file('chosefile','img')">
                                        @else
                                            <img style="width: 150px; height:auto" src="{{url('admin/images/no-image.jpg')}}" id="lbl_img" class="img-fluid d-block" onclick="upload_file('chosefile','img')">
                                        @endif
                                        <input type="hidden" name="thumbnail" id="hd_img" value="{{!empty($oneItem->thumbnail)? $oneItem->thumbnail: ''}}" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Trạng thái</label>
                                        <select name="status" class="form-control">
                                            <option {{isset($oneItem->status) && $oneItem->status == 1 ? 'selected' : ''}} value="1">Hoạt động</option>
                                            <option {{isset($oneItem->status) && $oneItem->status == 0 ? 'selected' : ''}} value="0">Không hoạt động</option>
                                        </select>
                                    </div>
                                    <div class="form-group float-right">
                                        <button type="submit" class="btn btn-primary">Lưu trữ</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection
