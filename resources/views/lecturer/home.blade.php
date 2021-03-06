@extends('include_home.main')
@section('page_title')
    Home
@endsection
@section('sidebar')
    @include('include_home.lecturer_sidebar')
@endsection

@section('navbar_title')
    <ul class="nav navbar-nav navbar-left">
        <li class="">
            <a href="{{url('/lecturer')}}" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <h4><i class="fa fa-home"></i>&nbsp;Home</h4>
            </a>
        </li>
    </ul>
@endsection

@section('content')
    <div class="right_col" role="main">
        <div class="row">
            <div class="row">

                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2><a href="{{route('other_courses')}}">Course Management</a></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-down"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content"  style="display: block">
                            <div class="dashboard-widget-content">
                                <ul class="list-unstyled timeline widget">
                                    @if(\Illuminate\Support\Facades\Auth::user()->role_id == 4)
                                        <li>
                                            <div class="block">
                                                <div class="block_content">
                                                    <h2 class="title">
                                                        <a>Convenor Courses</a>
                                                    </h2>
                                                    <p class="excerpt">
                                                        The <a href="{{route('convening_courses')}}">Convening Courses</a> page contains a list of courses
                                                        for which you are a covnenor. Clicking on a course will nnavigate to the course-management page of the course
                                                        where participants, coursework, subcoursework, sections and marks can be managed.
                                                    </p>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                    <li>
                                        <div class="block">
                                            <div class="block_content">
                                                <h2 class="title">
                                                    <a>Lecturing Courses</a>
                                                </h2>
                                                <p class="excerpt">
                                                    The <a href="{{route('lecturer_courses')}}">Lecturing Courses</a> page contains a list of
                                                    courses for which you are listed as a lecturer. Clicking on a course will navigate to the
                                                    course-management page where participants, coursework, subcoursework and sections can be viewed.
                                                    Marks (except final grade) can be uploaded through a file or can be manually updated one by one.
                                                </p>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="block">
                                            <div class="block_content">
                                                <h2 class="title">
                                                    <a>Other Courses</a>
                                                </h2>
                                                <p class="excerpt">
                                                    The <a href="{{route('other_courses')}}">Other Courses</a> page contains a list of
                                                    courses which are available your departments and for which you are not listed as a lecturer nor a convenor.
                                                    Clicking on a course will navigate to the course-management page where
                                                    participants, coursework, subcoursework, sections and marks can be viewed only.
                                                </p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2><a href="{{route('search_marks')}}">Viewing Students Marks</a></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-down"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content" style="display: block">
                            <div class="dashboard-widget-content">
                                <ul class="list-unstyled timeline widget">
                                    <li>
                                        <div class="block">
                                            <div class="block_content">
                                                <h2 class="title">
                                                    <a>Searching</a>
                                                </h2>
                                                <p class="excerpt">
                                                    A student number/employee ID is compulsory for the search. Only records which matches the
                                                    student number/employee ID exactly will be returned. Other filters such as course code,
                                                    year and department are optional.
                                                </p>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="block">
                                            <div class="block_content">
                                                <h2 class="title">
                                                    <a>Viewing</a>
                                                </h2>
                                                <p class="excerpt">
                                                    If any record has been found, it will be displayed on the page. Each result if linked to a course.
                                                    The marks can be drilled down upto the section marks for the course.
                                                </p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection