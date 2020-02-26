<header class="main-header">
    <!-- Logo -->
    @if(\Illuminate\Support\Facades\Auth::check())
    <a href="{{url('/')}}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>CP</b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">ClearPath</span>
    </a>
        @else
        <a href="{{url()->current()}}" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>CP</b></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg">ClearPath</span>
        </a>

    @endif
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        @if(\Illuminate\Support\Facades\Auth::check())
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{{asset('public/images/user2-160x160.jpg')}}" class="user-image" alt="User Image">
                        <span class="hidden-xs">ClearPath</span>
                    </a>
                    <ul class="dropdown-menu scale-up">
                        <!-- User image -->

                        <!-- Menu Footer-->
                        <li class="user-footer">
{{--                            <div class="pull-left">--}}
{{--                                <a href="#" class="btn btn-default btn-flat">Profile</a>--}}
{{--                            </div>--}}
                            <div class="pull-right">
                                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();"
                                   class="btn btn-default btn-flat" data-toggle="tooltip" title="" data-original-title="Logout">Sign out</a>

                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
            @endif
    </nav>
</header>
