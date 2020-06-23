<!DOCTYPE html>

<html>
<head>
    <meta charset="UTF-8"/>
    <title>@yield('title')</title>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>
    <script src="{{ asset('/assets/files/jquery/jquery-2.1.1.min.js') }}"></script>
    <script src="{{ asset('/assets/files/bootstrap/css/bootstrap.min.js') }}"></script>
    <link href="{{ asset('/assets/files/bootstrap/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('/bootstrap/files/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <script src="{{ asset('/assets/files/common.js') }}"></script>
    <script src="{{ asset('/assets/files/select2/js/select2.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/main.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main-front.css') }}">
    @yield('header')
    <style type="text/css">
        .pull-right {
            float: left !important;
        }
    </style>
</head>
<header id="header" class="navbar navbar-static-top">
    <div id="header-logo">
        <a href="">
            <img class="logo" typeof="foaf:Image" src="{{asset('image/logo-orange.svg')}}" alt="IDPay logo">
        </a>
    </div>


    {{--<div id="title-header"> آزمایشگاه سرویس پرداخت</div>--}}


</header>
<body>


<div class="container">

    @yield('content')

</div>



</body>
</html>

<style>

    .text-left {
        text-align: left;
    }
    کدهایی که باید تغییر دهید در قسمت زیر نمایش داده شده است :
    html {
        direction: rtl;
    }
    body {
        direction: rtl;
    }
    button,
    input,
    optgroup,
    select,
    textarea {
        direction: rtl;
    }
    @media (min-width: 768px) {
        .dl-horizontal dt {
            float: right;
        }
    }
    .col-xs-1, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9, .col-xs-10, .col-xs-11, .col-xs-12 {
        float: right;
    }
    @media (min-width: 768px) {
        .col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12 {
            float: right;
        }
    }
    @media (min-width: 992px) {
        .col-md-1, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11, .col-md-12 {
            float: right;
        }
    }
    @media (min-width: 1200px) {
        .col-lg-1, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-10, .col-lg-11, .col-lg-12 {
            float: right;
        }
    }
    .dropdown-menu {
        float: right;
    }
    .btn-group > .btn,
    .btn-group-vertical > .btn {
        float: right;
    }
    .btn-toolbar .btn,
    .btn-toolbar .btn-group,
    .btn-toolbar .input-group {
        float: right;
    }
    .btn-group > .btn-group {
        float: right;
    }
    .input-group .form-control {
        float: right;
    }
    .nav-tabs > li {
        float: right;
    }
    .nav-pills > li {
        float: right;
    }
    @media (min-width: 768px) {
        .navbar-header {
            float: right;
        }
    }
    .navbar-brand {
        float: right;
    }
    @media (min-width: 768px) {
        .navbar-nav {
            float: right;
        }
        .navbar-nav> li {
            float: right;
        }
    }
    @media (min-width: 768px) {
        .navbar-text {
            float: right;
        }
    }
    .pagination > li > a,
    .pagination > li > span {
        float: right;
    }
    .pager .previous > a,
    .pager .previous > span {
        float: right;
    }
    .progress-bar {
        float: right;
    }
    .popover {
        text-align: right;
    }
    caption {
        text-align: right;
    }
    th {
        text-align: right;
    }
    .dropdown-menu {
        text-align: right;
    }
    .tooltip {
        text-align: right;
    }

</style>
