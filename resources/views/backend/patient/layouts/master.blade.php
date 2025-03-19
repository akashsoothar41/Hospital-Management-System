<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from dreamguys.co.in/demo/doccure/admin/blank-page.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 30 Nov 2019 04:12:53 GMT -->

<!-- Mirrored from www.templateshub.net/demo/doccure-doctor-appointment-booking-bootstrap-template-admin-dashboard/admin/blank-page.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 02 May 2024 16:24:35 GMT -->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Patient Portal</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('backend')}}/img/favicon.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('backend')}}/css/bootstrap.min.css">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{asset('backend')}}/css/font-awesome.min.css">

    <!-- Feathericon CSS -->
    <link rel="stylesheet" href="{{asset('backend')}}/css/feathericon.min.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{asset('backend')}}/css/style.css">

    <!--[if lt IE 9]>
    {{--    <script src="{{asset('backend')}}/js/html5shiv.min.js"></script>--}}
{{--    <script src="{{asset('backend')}}/js/respond.min.js"></script>--}}
    <![endif]-->

    <style>
        .error {
            color: red;
            font-size: 12px;
        }
    </style>
    @stack('css')
</head>
<body>

<!-- Main Wrapper -->
<div class="main-wrapper">

    <!-- Header -->
    <div class="header">

        <!-- Logo -->
        <div class="header-left">
            <a href="{{route('website')}}" class="logo">
                <img src="{{asset('backend')}}/img/logo.png" alt="Logo">
            </a>
            <a href="{{route('website')}}" class="logo logo-small">
                <img src="{{asset('backend')}}/img/logo-small.png" alt="Logo" width="30" height="30">
            </a>
        </div>
        <!-- /Logo -->

        <a href="javascript:void(0);" id="toggle_btn">
            <i class="fe fe-text-align-left"></i>
        </a>

        <div class="top-nav-search">
            <form>
                <input type="text" class="form-control" placeholder="Search here">
                <button class="btn" type="submit"><i class="fa fa-search"></i></button>
            </form>
        </div>

        <!-- Mobile Menu Toggle -->
        <a class="mobile_btn" id="mobile_btn">
            <i class="fa fa-bars"></i>
        </a>
        <!-- /Mobile Menu Toggle -->

        <!-- Header Right Menu -->
        <ul class="nav user-menu">

            <!-- Notifications -->
            <li class="nav-item dropdown noti-dropdown">
                <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                    <i class="fe fe-bell"></i> <span class="badge badge-pill">3</span>
                </a>
                <div class="dropdown-menu notifications">
                    <div class="topnav-dropdown-header">
                        <span class="notification-title">Notifications</span>
                        <a href="javascript:void(0)" class="clear-noti"> Clear All </a>
                    </div>
                    <div class="noti-content">
                        <ul class="notification-list">
                            <li class="notification-message">
                                <a href="#">
                                    <div class="media">
												<span class="avatar avatar-sm">
													<img class="avatar-img rounded-circle" alt="User Image" src="{{asset('backend')}}/img/doctors/doctor-thumb-01.jpg">
												</span>
                                        <div class="media-body">
                                            <p class="noti-details"><span class="noti-title">Dr. Ruby Perrin</span> Schedule <span class="noti-title">her appointment</span></p>
                                            <p class="noti-time"><span class="notification-time">4 mins ago</span></p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="notification-message">
                                <a href="#">
                                    <div class="media">
												<span class="avatar avatar-sm">
													<img class="avatar-img rounded-circle" alt="User Image" src="{{asset('backend')}}/img/patients/patient1.jpg">
												</span>
                                        <div class="media-body">
                                            <p class="noti-details"><span class="noti-title">Charlene Reed</span> has booked her appointment to <span class="noti-title">Dr. Ruby Perrin</span></p>
                                            <p class="noti-time"><span class="notification-time">6 mins ago</span></p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="notification-message">
                                <a href="#">
                                    <div class="media">
												<span class="avatar avatar-sm">
													<img class="avatar-img rounded-circle" alt="User Image" src="{{asset('backend')}}/img/patients/patient2.jpg">
												</span>
                                        <div class="media-body">
                                            <p class="noti-details"><span class="noti-title">Travis Trimble</span> sent a amount of $210 for his <span class="noti-title">appointment</span></p>
                                            <p class="noti-time"><span class="notification-time">8 mins ago</span></p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="notification-message">
                                <a href="#">
                                    <div class="media">
												<span class="avatar avatar-sm">
													<img class="avatar-img rounded-circle" alt="User Image" src="{{asset('backend')}}/img/patients/patient3.jpg">
												</span>
                                        <div class="media-body">
                                            <p class="noti-details"><span class="noti-title">Carl Kelly</span> send a message <span class="noti-title"> to his doctor</span></p>
                                            <p class="noti-time"><span class="notification-time">12 mins ago</span></p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="topnav-dropdown-footer">
                        <a href="#">View all Notifications</a>
                    </div>
                </div>
            </li>
            <!-- /Notifications -->

            <!-- User Menu -->
            <li class="nav-item dropdown has-arrow">
                <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                    <span class="user-img"><img class="rounded-circle" src="{{asset('backend')}}/{{Auth::user()->profile->image ?? ''}}" width="31" alt="Ryan Taylor"></span>
                </a>
                <div class="dropdown-menu">
                    <div class="user-header">
                        <div class="avatar avatar-sm">
                            <img src="{{asset('backend')}}/{{Auth::user()->profile->image ?? ''}}" alt="User Image" class="avatar-img rounded-circle">
                        </div>
                        <div class="user-text">
                            <h6>{{ Auth::user()->first_name ?? '' }} {{ Auth::user()->last_name ?? '' }}</h6>
                            <p class="text-muted mb-0">Patient</p>
                        </div>
                    </div>
                    <a class="dropdown-item" href="{{route('patient_profile')}}">My Profile</a>
                    <a class="dropdown-item" href="settings.html">Settings</a>
                    <a class="dropdown-item" href="{{route('logout')}}">Logout</a>
                </div>
            </li>
            <!-- /User Menu -->

        </ul>
        <!-- /Header Right Menu -->

    </div>
    <!-- /Header -->

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-inner slimscroll">
            <div id="sidebar-menu" class="sidebar-menu">
                <ul>
                    <li class="{{ request()->routeIs('patient') ? 'active' : '' }}">
                        <a href="{{ route('patient') }}"><i class="fe fe-home"></i> <span>Dashboard</span></a>
                    </li>
                    <li class="{{ request()->routeIs('patient_appointments') ? 'active' : '' }}">
                        <a href="{{ route('patient_appointments') }}"><i class="fe fe-layout"></i> <span>Appointments</span></a>
                    </li>

                </ul>

            </div>
        </div>
    </div>
    <!-- /Sidebar -->

    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content container-fluid">

            @yield('content')

        </div>
        <!-- /Main Wrapper -->

        <!-- jQuery -->
        <script src="{{asset('backend')}}/js/jquery-3.2.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

        <!-- Bootstrap Core JS -->
        <script src="{{asset('backend')}}/js/popper.min.js"></script>
        <script src="{{asset('backend')}}/js/bootstrap.min.js"></script>

        <!-- Slimscroll JS -->
        <script src="{{asset('backend')}}/plugins/slimscroll/jquery.slimscroll.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- Custom JS -->
        <script  src="{{asset('backend')}}/js/script.js"></script>

        @if(Session::has('msg'))
            <script>
                Swal.fire({
                    icon: "{{Session::get('type')}}",
                    title: "{{Session::get('title')}}",
                    text: "{{Session::get('msg')}}",
                    showConfirmButton: false,
                    timer: 5000
                });
            </script>
@endif


@stack('js')

</html>
