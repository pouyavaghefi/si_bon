<!DOCTYPE html>
<html dir="rtl" lang="fa-IR">
<head>
    @include('frontend.layouts.init.meta')
    <title>@yield('pageTitle')</title>
    @include('frontend.layouts.init.head')
    @stack('styles')
</head>

<body>

<div class="page-wrapper">
    @include('frontend.layouts.includes.header')
</div>

<div class="head-b-padd"></div>

@yield('wrapper')

@include('frontend.layouts.includes.overalls.footer')
@include('frontend.layouts.init.js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@stack('scripts')
</body>
</html>
