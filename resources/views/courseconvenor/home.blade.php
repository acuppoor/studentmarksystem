@extends('include_home.main')
@section('page_title')
    Home
@endsection
@section('sidebar')
    @include('include_home.convenor_sidebar')
@endsection

@section('navbar_title')
    <ul class="nav navbar-nav navbar-left">
        <li class="">
            <a href="{{url('/courseconvenor')}}" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <h4><i class="fa fa-home"></i>&nbsp;Home</h4>
            </a>
        </li>
    </ul>
@endsection

@section('content')
    <div class="right_col" role="main">
        <div class="row">
        </div>
    </div>
@endsection


{{--
@extends('layouts.dashboard.main')

@section('title')
    Dashboard
@endsection

@section('content')
<div class="wrapper">
--}}
{{--    @include('include.dashboard.sidepanel')--}}{{--


    <div class="sidebar" data-background-color="black" data-active-color="danger">
        <div class="sidebar-wrapper">
            <div class="logo">
                <a href="/" class="simple-text">
                    <img src="{{url('images/uct.png')}}" style="width: 50px; height: 50px">
                    &nbsp;
                    Mark System
                </a>
            </div>
            <ul class="nav">
                <li class="active">
                    <a href="/courseconvenor">
                        <i class="ti-panel"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li>
                    <a href="/courseconvenor/convenor_courses">
                        <i class="ti-panel"></i>
                        <p>Convening Courses</p>
                    </a>
                </li>
                <li>
                    <a href="/courseconvenor/courses">
                        <i class="ti-panel"></i>
                        <p>Courses</p>
                    </a>
                </li>
                <li>
                    <a href="/courseconvenor/searchmarks">
                        <i class="ti-panel"></i>
                    <p>Search Marks</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="main-panel">
        @include('include.dashboard.nav')
        <div class="row" style="background-color: whitesmoke">
            <div class="card">
                <div class="col-md-12">
                    / <a href="">Dashboard</a>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
--}}
