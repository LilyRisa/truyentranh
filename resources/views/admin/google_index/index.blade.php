@extends('admin.layout')
@section('content')
    <main class="c-main">
        <div class="container-fluid">
            <div class="fade-in">
                <div class="card">
                    <div class="card-header">
                        Google index
                    </div>
                    <div class="card-body">
                        <div class="">
                            <div class="mx-2 col-6 form-group">
                                <label for=""></label>
                                <input type="text" id="url" class="form-control" placeholder="url">
                            </div>
                            <div class="mx-2 col-6 form-group">
                                <button class="btn btn-secondary mr-2 check_index" onclick="googleIndex('check', this)"><img src="{{asset('admin/images/icon-svg/loading.svg')}}" width="20px" height="20px" style="display: none"> Check</button>
                                <button class="btn btn-success mx-2 update_index" onclick="googleIndex('update', this)"><img src="{{asset('admin/images/icon-svg/loading.svg')}}" width="20px" height="20px" style="display: none"> Update index</button>
                                <button class="btn btn-danger mx-2 delete_index" onclick="googleIndex('delete', this)"><img src="{{asset('admin/images/icon-svg/loading.svg')}}" width="20px" height="20px" style="display: none"> Delete index</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
