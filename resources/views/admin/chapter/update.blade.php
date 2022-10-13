@extends('admin.layout')
@section('content')
    <main class="c-main bg-white">
        <div class="container-fluid">
            <div class="fade-in">
                <form class="form-post" method="post" action="">
                    <input type="hidden" name="url_referer" value="{{$url_referer}}">
                    <div class="row">
                        <div class="col-md-8 pr-0">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#seo" role="tab" aria-controls="seo">Nội dung </a></li>
                            
                            </ul>
                        </div>
                        <div class="col-md-4 border-bottom">
                            @empty($oneItem)
                                {{-- <button type="button" class="btn btn-danger float-right save-draft">Lưu nháp</button> --}}
                                <button type="submit" class="btn btn-primary float-right mr-3">Đăng bài</button>
                            @else
                                <button type="submit" class="btn btn-primary float-right mr-3">Lưu trữ</button>
                            @endempty
                        </div>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane active" id="seo" role="tabpanel">
                            <div class="row py-2">
                                <div class="col-sm-8">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label>Tiêu đề</label>
                                                        <input class="form-control" required name="title" value="{!! !empty($oneItem->title) ? $oneItem->title : '' !!}" type="text" placeholder="Tiêu đề">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Mô tả</label>
                                                        <textarea class="form-control tiny-featured" rows="4" name="description">{{!empty($oneItem->description) ? $oneItem->description : ''}}</textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Nội dung</label>
                                                        <textarea id="full-featured" class="form-control" name="content">{{!empty($oneItem->content) ? str_replace('src="//','src="/img-proxy=//',$oneItem->content) : ''}}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label>
                                                    Tiêu đề SEO
                                                    <span class="text-danger" id="title-count-text">
                                                    <span>Độ dài hiện tại: </span>
                                                    <span id="title-count">0</span> ký tự</span>
                                                </label>
                                                <input class="form-control" name="meta_title" value="{{!empty($oneItem->meta_title) ? $oneItem->meta_title : ''}}" type="text" placeholder="Tiêu đề SEO">
                                            </div>
                                            
                                            <div class="form-group">
                                                <label>
                                                    Mô tả SEO
                                                    <span class="text-danger" id="description-count-text">
                                                <span>Độ dài hiện tại: </span>
                                                <span id="description-count">0</span> ký tự
                                            </span>
                                                </label>
                                                <textarea class="form-control" name="meta_description" rows="4" placeholder="Mô tả SEO">{{!empty($oneItem->meta_description) ? $oneItem->meta_description : ''}}</textarea>
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
