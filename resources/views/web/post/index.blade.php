@extends('web.layout')
@section('main')
<div class="container">
    <div class="position-relative w-100 d-flex" style="height: 2rem">
        <div class="bg-1 pt-2 ps-1"><a class="text-decoration-none text-white" href="/"><i class="icon-home pt-2 hover-info"></i></a></div>

        <div class=" triangle-right-1 bd-1 bg-2" style=""></div>
        <div class="bg-2 text-white pt-1 ps-1"><a class="text-decoration-none text-white hover-info" href="#">Tin tức</a></div>
        @if(!empty($breadcrumb))
        @foreach ($breadcrumb as $key => $value)
            <div class="  {{ $key != (count($breadcrumb) -1) ? 'triangle-right-2 bd-2 bg-3' : ' triangle-right-3 bd-3'}} " style=""></div>
            <div class="{{ $key != (count($breadcrumb) -1) ? 'bg-3' : ''}} text-white pt-1 ps-1"><a class="text-decoration-none {{ $key != (count($breadcrumb) -1) ? 'text-white' : 'text-infor'}}  hover-info" href="{{$value['item']}}">{{$value['name']}} </a></div>
        @endforeach
        @endif
        </div>

    <h1 class="fs-22 mt-5">{{$oneItem->title}}</h1>
    <p>{{$time}}</p>

    <div class="content" id="table-of-content">
        {!! replaceSrcImg($oneItem->content) !!}
    </div>
</div>
@endsection