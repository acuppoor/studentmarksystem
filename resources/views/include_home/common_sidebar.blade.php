<div class="col-md-3 left_col menu_fixed">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="{{route("home")}}" class="site_title"> <img src="{{asset('favicon.ico')}}" class="img-circle"><span>Mark System</span></a>
        </div>

        <div class="clearfix"></div>

        <br />

        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <hr/>
                @yield('sidebar_content')
            </div>
        </div>
        <!-- /sidebar menu -->



        <!-- /menu footer buttons -->
        <div class="sidebar-footer hidden-small">
            {{--<a data-toggle="tooltip" data-placement="top" title="Logout" href="{{ route('logout') }}"
               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </a>--}}
            <button class="btn btn-danger form-control" type="button" id="reloadPageButton" style="display: none">
                <i class="glyphicon glyphicon-repeat"></i>
                Reload Page</button>
        </div>
        <!-- /menu footer buttons -->
    </div>
</div>