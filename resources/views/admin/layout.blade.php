<!DOCTYPE html>
<html lang="{{str_replace('_', '-', app()->getLocale())}}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/admin/css/coreui/coreui.min.css">
    <link rel="stylesheet" href="/admin/css/custom.css?2">
    <link rel="stylesheet" href="/admin/css/toastr.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="/admin/css/tagify.css">
    <link rel="stylesheet" href="/admin/css/coreui/coreui-chartjs.css">
    <link rel="shortcut icon" href="{{url('images/favicon.png')}}" />
    <link rel="apple-touch-icon" href="{{url('images/favicon.png')}}" />
    <title>{{!empty(getCurrentControllerTitle()) ? 'Quản lý '.getCurrentControllerTitle() : 'Admin'}}</title>
</head>
<body>
@include('admin.sidebar')
<div class="c-wrapper c-fixed-components">
    @include('admin.header')
    <div class="c-body">
        @yield('content')
        @include('admin.footer')
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="/admin/js/coreui/coreui.bundle.min.js"></script>
<script src="/admin/js/toastr.js"></script>
<script src="/admin/js/speakingurl.min.js"></script>
<script src="/admin/js/jquery.stringtoslug.min.js"></script>
<script src="/admin/js/jQuery.tagify.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="/admin/js/upload.js"></script>
<script src="/admin/js/custom.js?v=251199"></script>
<script src="/admin/js/tinymce.min.js"></script>
<script src="/admin/js/tiny_full_featured.js"></script>
<script src="/admin/js/jquery.nestable.js"></script>
<script src="/admin/js/seo_tool.js" defer></script>
<script src="/admin/js/coreui/simplebar.min.js"></script>
<script src="/admin/js/coreui/chart.min.js"></script>
<script src="/admin/js/coreui/coreui-chartjs.js"></script>
<script src="/admin/js/coreui/coreui-utils.js"></script>
@yield('script')
</body>
</html>
