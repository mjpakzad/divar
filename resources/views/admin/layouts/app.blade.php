<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('admin.layouts.meta')
    @include('admin.layouts.styles')
    @yield('meta')
    @yield('styles')
</head>
<body class="nav-md">
<div class="container body">
    <div class="main_container">
        @include('admin.layouts.sidebar')
        @include('admin.layouts.header')
        <div class="right_col" role="main">
            @include('admin.layouts.partials.callout')
            @include('admin.layouts.partials.input-errors')
            @yield('content')
        </div>
        @include('admin.layouts.footer')
    </div>
</div>
@include('admin.layouts.partials.lockscreen')
@include('admin.layouts.scripts')
@include('admin.layouts.partials.message')
@yield('scripts')
</body>
</html>
