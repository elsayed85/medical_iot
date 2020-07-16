<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <style>
        span.logo-text {
    color: #fff;
    font-size: 29px;
    font-weight: bold;
    font-family: sans-serif;
    position: relative;
    top: 6px;
    text-shadow: 0px 2px 5px #e74424;
}
    </style>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/favicon.png">
    <title>@yield('title')</title>
    @yield('css')
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body>
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <div class="preloader">
            <div class="lds-ripple">
                <div class="lds-pos"></div>
                <div class="lds-pos"></div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Main wrapper - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <div id="main-wrapper">
            <header class="topbar">
                <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                    <div class="navbar-header">
                        <!-- This is for the sidebar toggle which is visible on mobile only -->
                        <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
                        <!-- ============================================================== -->
                        <!-- Logo -->
                        <!-- ============================================================== -->
                        <a class="navbar-brand" href="{{route('home')}}" style="display: block;
    width: 100%;">
                            <!-- Logo icon -->
                            <b class="logo-icon">
                                <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                                <!-- Dark Logo icon -->
                                <!-- Light Logo icon -->
                                <img src="https://image.flaticon.com/icons/svg/119/119058.svg" alt="homepage" class="light-logo" style="width: 48px;" />
                            </b>
                            <!--End Logo icon -->
                            <!-- Logo text -->
                        </a>
                        <!-- ============================================================== -->
                        <!-- End Logo -->
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        <!-- Toggle which is visible on mobile only -->
                        <!-- ============================================================== -->
                        <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i class="ti-more"></i></a>
                    </div>
                    <!-- ============================================================== -->
                    <!-- End Logo -->
                    <!-- ============================================================== -->
                    <div class="navbar-collapse collapse" id="navbarSupportedContent">
                        <!-- ============================================================== -->
                        <!-- toggle and nav items -->
                        <!-- ============================================================== -->
                        <ul class="navbar-nav float-left mr-auto">
                            <li class="nav-item d-none d-md-block"><a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)" data-sidebartype="mini-sidebar"><i class="mdi mdi-menu font-24"></i></a></li>
                            <!-- ============================================================== -->
                            <!-- ============================================================== -->
                            <!-- ============================================================== -->
                            <!-- ============================================================== -->
                            <!-- Search -->
                            <!-- ============================================================== -->
                            <li class="nav-item search-box"> <a class="nav-link waves-effect waves-dark" href="javascript:void(0)"><i class="ti-search"></i></a>
                            <form class="app-search position-absolute" action="{{route("search")}}" method="GET">
                                    <input type="text" name="name" class="form-control" placeholder="Search &amp; enter"> <a class="srh-btn"><i class="ti-close"></i></a>
                                </form>
                            </li>
                        </ul>
                        <!-- ============================================================== -->
                        <!-- Right side toggle and nav items -->
                        <!-- ============================================================== -->
                        <ul class="navbar-nav float-right">
                            <!-- ============================================================== -->
                            <!-- create new -->
                            <!-- Comment -->
                            <!-- ============================================================== -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-bell font-24"></i>
                                    
                                </a>
                                <div class="dropdown-menu dropdown-menu-right mailbox animated bounceInDown">
                                    <span class="with-arrow"><span class="bg-primary"></span></span>
                                    <ul class="list-style-none">
                                        <li>
                                            <div class="drop-title bg-primary text-white">
                                                <h4 class="m-b-0 m-t-5">{{count(Auth::user()->families)}} New</h4>
                                                <span class="font-light">Family</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="message-center notifications">
                                                @foreach (Auth::user()->families as $mem)
                                                <a href="javascript:void(0)" class="message-item">
                                                    <span class="btn btn-primary btn-circle">
                                                        @if($mem->user->geneder == 'male')
                                                        <i class="icon-user"></i>
                                                        @else
                                                        <i class="icon-user-female"></i>
                                                        @endif
                                                        </span>
                                                    <span class="mail-contnet">
                                                        <h5 class="message-title">{{$mem->user->name}}</h5> 
                                                        @if(count($mem->user->lastBpm($mem->user->id)))
                                                        <span class="mail-desc">my last Bpm is {{$mem->user->lastBpm($mem->user->id)['bpm']}}</span> 
                                                        <span class="time">{{$mem->user->lastBpm($mem->user->id)['created_at']->diffforhumans()}}</span> 
                                                        @endif
                                                    </span>
                                                </a>
                                                @endforeach
                                            </div>
                                        </li>
                                        <li>
                                            <a class="nav-link text-center m-b-5" href="{{route('family')}}"> <strong>Check all Family</strong> <i class="fa fa-angle-right"></i> </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <!-- ============================================================== -->
                            <!-- End Comment -->
                            <!-- ============================================================== -->
                            <!-- ============================================================== -->

                            <!-- ============================================================== -->
                            <!-- ============================================================== -->
                            <!-- User profile and search -->
                            <!-- ============================================================== -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="{{Auth::user()->avatar != null ? Auth::user()->avatar : "https://ui-avatars.com/api/?size=500&name=" . Auth::user()->name}}" alt="user" class="rounded-circle" width="31">
                                    </a>
                                <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">
                                    <span class="with-arrow"><span class="bg-primary"></span></span>
                                    <div class="d-flex no-block align-items-center p-15 bg-primary text-white m-b-10">
                                        <div class=""><img src="{{Auth::user()->avatar != null ? Auth::user()->avatar : "https://ui-avatars.com/api/?size=500&name=" . Auth::user()->name}}" alt="user" class="rounded-circle" width="60"></div>
                                        <div class="m-l-10">
                                            <h4 class="m-b-0">{{Auth::user()->name}}</h4>
                                            <p class=" m-b-0">{{Auth::user()->email}}</p>
                                        </div>
                                    </div>
                                    <a class="dropdown-item" href="{{ route('user_profile') }}"><i class="ti-user m-r-5 m-l-5"></i> My Profile</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{route("logout")}}"><i class="fa fa-power-off m-r-5 m-l-5"></i> Logout</a>
                                </div>
                            </li>
                            <!-- ============================================================== -->
                            <!-- User profile and search -->
                            <!-- ============================================================== -->
                        </ul>
                    </div>
                </nav>
            </header>
            <aside class="left-sidebar">
                    <!-- Sidebar scroll-->
                    <div class="scroll-sidebar">
                        <!-- Sidebar navigation-->
                        <nav class="sidebar-nav">
                            <ul id="sidebarnav">
                                <!-- User Profile-->
                                <li>
                                    <!-- User Profile-->
                                    <div class="user-profile d-flex no-block dropdown mt-3">
                                        <div class="user-pic"><img src="{{Auth::user()->avatar != null ? Auth::user()->avatar : "https://ui-avatars.com/api/?size=500&name=" . Auth::user()->name}}" alt="users" class="rounded-circle" width="40" /></div>
                                        <div class="user-content hide-menu ml-2">
                                            <a href="javascript:void(0)" class="" id="Userdd" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <h5 class="mb-0 user-name font-medium">{{Auth::user()->name}} <i class="fa fa-angle-down"></i></h5>
                                            <span class="op-5 user-email">{{Auth::user()->email}}</span>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="Userdd">
                                            <a class="dropdown-item" href="{{ route('user_profile') }}"><i class="ti-user mr-1 ml-1"></i> My Profile</a>
                                                <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="{{route("logout")}}"><i class="fa fa-power-off mr-1 ml-1"></i> Logout</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End User Profile-->
                                </li>
                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route('home')}}" aria-expanded="false"><i class="fas fa-home"></i><span class="hide-menu">home</span></a></li>
                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route('user_profile')}}" aria-expanded="false"><i class="fas fa-user-circle"></i><span class="hide-menu">profile</span></a></li>
                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route('heartModel')}}" aria-expanded="false"><i class="fas fa-heartbeat"></i><span class="hide-menu">My heart model</span></a></li>
                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route("family")}}" aria-expanded="false"><i class="fas fa-users"></i><span class="hide-menu">my family</span></a></li>
                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route("doctor.index")}}" aria-expanded="false"><i class="fas fa-user-md"></i><span class="hide-menu">my Doctors</span></a></li>
                            <li class="nav-small-cap"><i class="mdi mdi-dots-horizontal"></i> <span class="hide-menu">Api</span></li>
                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route('user_api')}}" aria-expanded="false"><i class="mdi mdi-content-paste"></i><span class="hide-menu">API</span></a></li>
                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route("logout")}}" aria-expanded="false"><i class="mdi mdi-directions"></i><span class="hide-menu">Log Out</span></a></li>
                            </ul>
                        </nav>
                        <!-- End Sidebar navigation -->
                    </div>
                    <!-- End Sidebar scroll-->
            </aside>
            @yield('main') 
        </div>


    <div class="chat-windows"></div>
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="/assets/libs/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="/assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="/assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- apps -->
    <script src="/dist/js/app.min.js"></script>
    <!-- minisidebar -->
    <script>
            $(function() {
                "use strict";
                $("#main-wrapper").AdminSettings({
                    Theme: false, // this can be true or false ( true means dark and false means light ),
                    Layout: 'vertical',
                    LogoBg: 'skin1', // You can change the Value to be skin1/skin2/skin3/skin4/skin5/skin6 
                    NavbarBg: 'skin6', // You can change the Value to be skin1/skin2/skin3/skin4/skin5/skin6
                    SidebarType: 'mini-sidebar', // You can change it full / mini-sidebar / iconbar / overlay
                    SidebarColor: 'skin1', // You can change the Value to be skin1/skin2/skin3/skin4/skin5/skin6
                    SidebarPosition: false, // it can be true / false ( true means Fixed and false means absolute )
                    HeaderPosition: false, // it can be true / false ( true means Fixed and false means absolute )
                    BoxedLayout: false, // it can be true / false ( true means Boxed and false means Fluid ) 
                });
            });
            </script>
    <script src="/dist/js/app-style-switcher.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <!--Wave Effects -->
    <script src="/dist/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="/dist/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="/dist/js/custom.min.js"></script>
    @yield('js')
</body>

</html>