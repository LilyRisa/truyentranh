@extends('admin.layout')
@section('content')
    <main class="c-main">
        <div class="container-fluid">
            <div class="fade-in">
                <form method="post" action="">
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="card">
                                <div class="card-header"><strong>{{!empty($oneItem) ? 'Chỉnh sửa' : 'Thêm mới'}} Thông tin trang</strong></div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Tiêu đề trang</label>
                                                <input class="form-control" name="site_title" value="{{!empty($oneItem->site_title) ? $oneItem->site_title : ''}}" type="text" placeholder="Tiêu đề trang">
                                            </div>
                                            <div class="form-group">
                                                <label>Mô tả trang</label>
                                                <textarea class="form-control" name="site_description" rows="4" placeholder="Mô tả trang">{{!empty($oneItem->site_description) ? $oneItem->site_description : ''}}</textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Keyword trang</label>
                                                <textarea class="form-control" name="site_keyword" rows="4" placeholder="Keyword trang">{{!empty($oneItem->site_keyword) ? $oneItem->site_keyword : ''}}</textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Meta Head</label>
                                                <textarea class="form-control" name="meta_head" rows="4" placeholder="Meta head">{{!empty($oneItem->meta_head) ? $oneItem->meta_head : ''}}</textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Meta Head amp page</label>
                                                <textarea class="form-control" name="meta_head_amp" rows="4" placeholder="meta head amp">{{!empty($oneItem->meta_head_amp) ? $oneItem->meta_head_amp : ''}}</textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Text home</label>
                                                <textarea class="form-control" name="text_home" rows="4" placeholder="Text home">{{!empty($oneItem->text_home) ? $oneItem->text_home : ''}}</textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Thông tin Footer</label>
                                                <textarea class="form-control tiny-featured" name="site_content_footer" rows="4" placeholder="Thông tin Footer">{{!empty($oneItem->site_content_footer) ? $oneItem->site_content_footer : ''}}</textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Mã DMCA</label>
                                                <textarea class="form-control tiny-featured" name="site_dmca" rows="4" placeholder="Mã DMCA">{{!empty($oneItem->site_dmca) ? $oneItem->site_dmca : ''}}</textarea>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-12">
                                                    <label>Địa chỉ</label>
                                                    <input class="form-control" name="address" value="{{!empty($oneItem->address) ? $oneItem->address : ''}}" type="text" placeholder="Địa chỉ">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                    <label>Địa chỉ</label>
                                                    <input class="form-control" name="site_address" value="{{!empty($oneItem->site_address) ? $oneItem->site_address : ''}}" type="text" placeholder="Địa chỉ">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3">
                                                    <label>Email</label>
                                                    <input class="form-control" name="site_email" value="{{!empty($oneItem->site_email) ? $oneItem->site_email : ''}}" type="text" placeholder="Email">
                                                </div>
                                                <div class="col-md-3">
                                                    <label>Hotline</label>
                                                    <input class="form-control" name="site_hotline" value="{{!empty($oneItem->site_hotline) ? $oneItem->site_hotline : ''}}" type="text" placeholder="Hotline">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                        
                                                <div class="col-md-4">
                                                    <label>Youtube</label>
                                                    <input type="text" class="form-control" name="site_youtube" value="{{!empty($oneItem->site_youtube) ? $oneItem->site_youtube : ''}}" placeholder="Youtube" >
                                                </div>
                                                <div class="col-md-4">
                                                    <label>Twitter</label>
                                                    <input type="text" class="form-control" name="site_twitter" value="{{!empty($oneItem->site_twitter) ? $oneItem->site_twitter : ''}}" placeholder="Twitter" >
                                                </div>
                                                <div class="col-md-4">
                                                    <label>Facebook</label>
                                                    <input type="text" class="form-control" name="site_facebook" value="{{!empty($oneItem->site_facebook) ? $oneItem->site_facebook : ''}}" placeholder="Facebook" >
                                                </div>
                                                <div class="col-md-4">
                                                    <label>Instagram</label>
                                                    <input type="text" class="form-control" name="site_instagram" value="{{!empty($oneItem->site_instagram) ? $oneItem->site_instagram : ''}}" placeholder="Instagram" >
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <label>Thông tin text sidebar</label>
                                                <textarea class="form-control tiny-featured" name="text_sidebar" rows="4" placeholder="Thông tin Footer">{{!empty($oneItem->text_sidebar) ? $oneItem->text_sidebar : ''}}</textarea>
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
                                        <label>Logo</label>
                                        
                                        @if(!empty($oneItem->thumbnail))
                                            <img src="{{'/img/thumb/'.$oneItem->thumbnail}}" id="lbl_img" class="img-fluid d-block" >
                                        @else
                                            <img src="{{url('admin/images/no-image.jpg')}}" id="lbl_img" class="img-fluid d-block" >
                                        @endif
                                        <input type="hidden" name="site_logo" id="hd_img" value="{{!empty($oneItem->thumbnail)? $oneItem->thumbnail: ''}}" required>
                                        <div id="progress-wrp" style="display: none">
                                            <div class="progress-bar"></div>
                                            <div class="status">0%</div>
                                        </div>
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
