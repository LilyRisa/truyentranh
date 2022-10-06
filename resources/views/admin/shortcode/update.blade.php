@extends('admin.layout')
@section('content')
    <main class="c-main bg-white">
        <div class="container-fluid">
            <div class="fade-in">
                <form method="post" action="">
                    <div class="row">
                        <div class="col-md-8 pr-0">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#info" role="tab" aria-controls="info">Thông tin</a></li>
                            </ul>
                        </div>
                        <div class="col-md-4 border-bottom">
                            <button type="submit" class="btn btn-primary float-right">Lưu trữ</button>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane active" id="info" role="tabpanel">
                            <div class="row py-2">
                                <div class="col-sm-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-12">

                                                    <div class="form-group">
                                                        <label>Slug</label>
                                                        <div class="d-flex align-items-center">
                                                            <span class="d-flex align-items-stretch mr-3" style="font-size: 25px">[</span><input type="text" name="slug" style="height: calc(0.5em + 0.75rem + 1px)" class="form-control" value="{{!empty($oneItem->slug) ? $oneItem->slug : ''}}"><span class="d-flex align-items-stretch ml-3" style="font-size: 25px">]</span>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <div class="col-md-6">
                                                            <label>status</label>
                                                            <select name="status" class="form-control">
                                                                <option {{isset($oneItem->status) && $oneItem->status == 1 ? 'selected' : ''}} value="1">active</option>
                                                                <option {{isset($oneItem->status) && $oneItem->status == 0 ? 'selected' : ''}} value="0">disable</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Nội dung</label>
                                                        <textarea id="full-featured" class="form-control" name="content">{{!empty($oneItem->content) ? $oneItem->content : ''}}</textarea>
                                                    </div>

                                                </div>
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
