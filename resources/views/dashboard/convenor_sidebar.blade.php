<div class="col-md-3 left_col menu_fixed">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="{{url("/courseconvenor")}}" class="site_title"> <img src="{{asset('favicon.ico')}}" class="img-circle"><span>Mark System</span></a>
        </div>

        <div class="clearfix"></div>

        <br />

        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <hr/>
                <ul class="nav side-menu">
                    <li>
                        <a href="{{url('/courseconvenor')}}"><i class="fa fa-home"></i> Home</a>
                    </li>
                    <li>
                        <a href="{{url('/courseconvenor/convening_courses')}}"><i class="fa fa-book"></i> Convening Courses</a>
                    </li>
                    <li>
                        <a href="{{url('/courseconvenor/other_courses')}}"><i class="fa fa-book"></i> Other Courses</a>
                    </li>
                    <li>
                        <a href="{{url('/courseconvenor/search')}}"><i class="fa fa-search"></i> Search Marks</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /sidebar menu -->

        <!-- /menu footer buttons -->
        <div class="sidebar-footer hidden-small">
            <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Logout" href="{{ route('logout') }}"
               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </a>
        </div>
        <!-- /menu footer buttons -->
    </div>
</div>