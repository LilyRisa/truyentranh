@extends('web.layout')
@section('main')

@php
    $title = explode('- ', $oneItem->title);
    $chap = end($title);
    unset($title[count($title)-1]);
    $title = implode(" ",$title);
@endphp

<div class="container">
    {{-- bread-cum --}}
    <div class="position-relative w-100 d-flex" style="height: 2rem">
    <div class="bg-1 pt-2 ps-1"><a class="text-decoration-none text-white" href="#"><i class="icon-home pt-2 hover-info"></i></a></div>
    <div class=" triangle-right-1 bd-1 bg-2" style=""></div>
    <div class="bg-2 text-white pt-1 ps-1"><a class="text-decoration-none text-white hover-info" href="{{getUrlCate($oneItem->story->categories[0])}}">{{$oneItem->story->categories[0]->title}}</a></div>
    <div class=" triangle-right-2 bd-2 bg-3" style=""></div>
    <div class="bg-3 text-white pt-1 ps-1"><a class="text-decoration-none text-white hover-info" href="{{getUrlStory($oneItem->story)}}">{{$oneItem->story->title}}</a></div>
    <div class=" triangle-right-3 bd-3" style=""></div>
    <div class="text-info pt-1 ps-1"><a class="text-decoration-none text-info" href="#">{{$oneItem->title}}</a></div>
    </div>

    <div class="">
        <div class="pt-5"><p class="d-inline fs-25">{{$title}}</p><p class="px-2 d-inline">-</p><p class="text_secondary d-inline">{{$chap}}</p><p class="px-2 d-inline">-</p><p class="text-secondary d-inline">(Cập nhật lúc {{$oneItem->update_origin}})</p> </div>
    </div>

    <div class="bg-grey1 text-center mt-4">
        <div><p class="mb-0 pt-4">Nếu không xem được vui lòng đổi "server" khác để có trải nghiệm tốt hơn</p>
            <p class="text-danger p-0">Hướng dẫn khắc phục lỗi nếu ảnh bị lỗi ở tất cả các tập</p>
        </div>
        <button class="btn btn-success">Server VIP</button>
        <button class="btn btn-warning">Báo lỗi</button>

        <div class="w-100 bg_secondary text-center mt-2 py-1">Sử dụng mũi tên trái (<-) hoặc phải (->) để chuyển chapter</div>

        <div class="mt-4 pb-3 d-flex justify-content-center align-items-center">
            <a class="text-decoration-none text-danger " href="#"><i class="icon-home fs-25"></i></a>
            <a class="text-decoration-none text-danger ms-2" href="#"><i class="icon-menu1 fs-25"></i></a>
            <a class="text-decoration-none text-danger ms-2" href="#"><i class="icon-spinner11 fs-25"></i></a>

            <a class="btn text-white btn-change-chapter w-5 ms-2 {{!empty($before) ? 'btn-danger' : 'btn-secondary'}}" href="{{!empty($before) ? getUrlChapter($before) : '#' }}" {!! !empty($before) ? '' : 'style="pointer-events: none"' !!}><i class="icon-keyboard_arrow_left fs-25"></i></a>
            <select class="form-select d-inline w-25 border_secondary pt-1 ms-2" name="" id="" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                @foreach ($list as $item)
                    @php
                        $title_chap = explode('- ', $item->title);
                        $title_chap = end($title_chap);

                    @endphp     
                    <option value="{{getUrlChapter($item)}}" {{$oneItem->id == $item->id ? 'selected' : ''}}>{{$title_chap}}</option>
                @endforeach
            </select>
            <a class="btn text-white btn-change-chapter w-5 ms-2 {{!empty($after) ? 'btn-danger' : 'btn-secondary'}}" href="{{!empty($after) ? getUrlChapter($after) : '#' }}" {!! !empty($after) ? '' : 'style="pointer-events: none"' !!}><i class="icon-keyboard_arrow_right fs-25"></i></a>
            <a class="btn btn-success ms-2"> <i class="icon-heart"></i> Theo dõi</a>
        </div>

    </div>

    <div class="bg-white px-lg-5 mt-3 w-100 max-100 content-reading">
        {!! str_replace('src="//','src="/img-proxy=//',$oneItem->content) !!}
    </div>

    <div class="text-center mt-4">
        <button class="btn btn-primary btn-change-chapter w-10"><i class="icon-keyboard_arrow_left  fs-25"></i></button>
        <button class="btn btn-primary btn-change-chapter w-10 ms-2"><i class="icon-keyboard_arrow_right w-10 fs-25"></i></button>
    </div>
</div>


@endsection