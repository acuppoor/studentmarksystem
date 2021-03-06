<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - Mark System{{--{{ config('app.name', 'Mark System') }}--}}</title>

    @include('include.default.bootstrap')
</head>
<body id="page-top">
    <div id="main_div" class="masthead">
        @include('include.default.nav')
        @yield('content')
    </div>
    @include('include.default.footer')
    @include('include.default.scripts')
</body>
</html>
