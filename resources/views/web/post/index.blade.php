@extends('web.layout')
@section('main')
    <div>
        <section class="single-cover data-bg-image" data-bg-image="{{ $oneItem->thumbnail }}"
            style="background-image: linear-gradient( rgb(0 0 0 / 23%), rgba(0, 0, 0, 0.7) ), url('{{ $oneItem->thumbnail }}');">
            <div class="container-xl">
                <div class="cover-content post">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/" class="text-white">Trang chủ</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{ $breadcrumb[0]['item'] }}">{{ $breadcrumb[0]['name'] }}</a></li>
                            <li class="breadcrumb-item text-gray1 active" aria-current="page">{{ $oneItem->meta_title }}
                            </li>
                        </ol>
                    </nav>
                    <div class="post-header">
                        <h1 class="title mt-0 mb-3 text-white">{{ $oneItem->title }}</h1>
                        <ul class="meta list-inline mb-0">
                            <li class="list-inline-item">
                                <a href="#" class="text-grey1">
                                    {!! genImage($oneItem->user->thumbnail, 100, 100, 'img-fluid rounded-circle', $oneItem->user->username) !!}
                                    <span class="text-grey ms-2">{{ $oneItem->user->username }}</span></a>
                            </li>
                            <li class="list-inline-item">{{ $time }}</li>

                            <div class="list-inline-item">
                                @include('web.block._vote', ['data' => $oneItem, 'd_inline' => true])
                            </div>
                    </div>
                </div>
                </ul>
            </div>
    </div>
    </div>
    </section>

    <div class="container-lg row">
        <div class="content col-lg-8 mt-5" id="table-of-content">
            {!! replaceSrcImg($oneItem->content) !!}
        </div>
        {{-- <div class="content" >
        {!! replaceSrcImg($oneItem->content) !!}
    </div> --}}

        @include('web.block._sidebar')
    </div>
    </div>
@endsection
