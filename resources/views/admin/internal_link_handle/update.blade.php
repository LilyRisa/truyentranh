@extends('admin.layout')
@section('content')
    <main class="c-main bg-white">
        <div class="container-fluid">
            <div class="fade-in">
                <form method="post" action="">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header"><strong>{{!empty($oneItem) ? 'Chỉnh sửa' : 'Thêm mới'}} Internal Link</strong>{!!!empty($oneItem)  !!}</div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Tiêu đề</label>
                                                <input class="form-control" required name="title" value="{{!empty($oneItem->title) ? $oneItem->title : ''}}" type="text" placeholder="Tiêu đề">
                                            </div>
                                            <div class="form-group">
                                                <label>Trạng thái</label>
                                                <select name="is_status" class="form-control">
                                                    <option {{isset($oneItem->is_status) && $oneItem->is_status == 1 ? 'selected' : ''}} value="1">Công khai</option>
                                                    <option {{isset($oneItem->is_status) && $oneItem->is_status == 0 ? 'selected' : ''}} value="0">Bản nháp</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Từ khóa</label>
                                                <input class="form-control tags" required name="keyword" value="{{!empty($oneItem->keyword) ? $oneItem->keyword : ''}}" type="text" placeholder="Từ khóa">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Đường dẫn</label>
                                                <input class="form-control" required name="href" value="{{!empty($oneItem->href) ? $oneItem->href : ''}}" type="text" placeholder="Đường dẫn">
                                            </div>
                                            <div class="form-group">
                                                <label>Thuộc tính thẻ</label>
                                                <select name="is_tab" class="form-control">
                                                    <option {{isset($oneItem->is_tab) && $oneItem->is_tab == 1 ? 'selected' : ''}} value="1">Follow</option>
                                                    <option {{isset($oneItem->is_tab) && $oneItem->is_tab == 0 ? 'selected' : ''}} value="0">No Follow</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Cửa sổ khi click link</label>
                                                <select name="is_tag" class="form-control">
                                                    <option {{isset($oneItem->is_tag) && $oneItem->is_tag == 1 ? 'selected' : ''}} value="1">Bật</option>
                                                    <option {{isset($oneItem->is_tag) && $oneItem->is_tag == 0 ? 'selected' : ''}} value="0">Tắt</option>
                                                </select>
                                            </div>
                                            <div class="form-group float-right">
                                                <button type="submit" class="btn btn-primary">Lưu trữ</button>
                                            </div>
                                        </div>
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
