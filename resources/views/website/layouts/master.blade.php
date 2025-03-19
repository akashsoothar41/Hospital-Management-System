<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from doccure-html.dreamguystech.com/template/index-fifteen.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 02 Dec 2022 22:18:19 GMT -->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Doccure</title>

    <link type="image/x-icon" href="{{asset('website')}}/img/favicon.png" rel="icon">

    <link rel="stylesheet" href="{{asset('website')}}/css/bootstrap.min.css">

    <link rel="stylesheet" href="{{asset('website')}}/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="{{asset('website')}}/plugins/fontawesome/css/all.min.css">

    <link rel="stylesheet" href="{{asset('website')}}/css/feather.css">

    <link rel="stylesheet" href="{{asset('website')}}/css/owl.carousel.min.css">

    <link rel="stylesheet" href="{{asset('website')}}/css/aos.css">

    <link rel="stylesheet" href="{{asset('website')}}/css/style.css">

</head>
<body class="home-fifteen">

<div class="main-wrapper">

    <header class="header">
        <div class="container">
            <div class="nav-bg-fifteen">
                <nav class="navbar navbar-expand-lg header-nav nav-transparent">
                    <div class="navbar-header">
                        <a id="mobile_btn" href="javascript:void(0);">
                            <span class="bar-icon">
                                <span></span>
                                <span></span>
                                <span></span>
                            </span>
                        </a>
                        <a href="{{route('website')}}" class="navbar-brand logo">
                            <img src="{{asset('website')}}/img/logo-2.png" class="img-fluid" alt="Logo">
                        </a>
                    </div>
                    <div class="main-menu-wrapper">
                        <div class="menu-header">
                            <a href="{{route('website')}}" class="menu-logo">
                                <img src="{{asset('website')}}/img/logo-2.png" class="img-fluid" alt="Logo">
                            </a>
                            <a id="menu_close" class="menu-close" href="javascript:void(0);"> <i class="fas fa-times"></i>
                            </a>
                        </div>
                        <ul class="main-nav black-font">
                            <li> <a href="{{route('website')}}" target="_blank">Home</a>
                            </li>
{{--                            <li class="has-submenu menu-effect"><a href="#">Doctors <i class="fas fa-chevron-down"></i></a>--}}
{{--                                <ul class="submenu">--}}
{{--                                    <li><a href="doctor-dashboard.html">Doctor Dashboard</a>--}}
{{--                                    </li>--}}
{{--                                    <li><a href="appointments.html">Appointments</a>--}}
{{--                                    </li>--}}
{{--                                    <li><a href="schedule-timings.html">Schedule Timing</a>--}}
{{--                                    </li>--}}
{{--                                    <li><a href="my-patients.html">Patients List</a>--}}
{{--                                    </li>--}}
{{--                                    <li><a href="patient-profile.html">Patients Profile</a>--}}
{{--                                    </li>--}}
{{--                                    <li><a href="chat-doctor.html">Chat</a>--}}
{{--                                    </li>--}}
{{--                                    <li><a href="invoices.html">Invoices</a>--}}
{{--                                    </li>--}}
{{--                                    <li><a href="doctor-profile-settings.html">Profile Settings</a>--}}
{{--                                    </li>--}}
{{--                                    <li><a href="reviews.html">Reviews</a>--}}
{{--                                    </li>--}}
{{--                                    <li><a href="doctor-register.html">Doctor Register</a>--}}
{{--                                    </li>--}}
{{--                                </ul>--}}
{{--                            </li>--}}

                            <li class="login-link"> <a href="{{route('login')}}">Login / Signup</a>
                            </li>
                        </ul>
                    </div>
                    <ul class="nav header-navbar-rht">
                        @if(Auth::check())
                            @if(Auth::user()->role == 'admin')
                                <li class="nav-item">
                                    <a class="nav-link btn-five btn-fifteen" href="{{ route('admin') }}">Dashboard</a>
                                </li>
                            @elseif(Auth::user()->role == 'patient')
                                <li class="nav-item">
                                    <a class="nav-link btn-five btn-fifteen" href="{{ route('patient') }}">Dashboard</a>
                                </li>
                            @elseif(Auth::user()->role == 'doctor')
                                <li class="nav-item">
                                    <a class="nav-link btn-five btn-fifteen" href="{{ url('doctors') }}">Dashboard</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item">
                                <a class="nav-link btn-five btn-fifteen" href="{{ route('login') }}">Sign In</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link btn-five-light btn-fifteen-light" href="{{ route('register') }}">Sign Up</a>
                            </li>
                        @endif
                    </ul>

                </nav>
            </div>
        </div>
    </header>


@yield('content')

    <section class="home-fifteen-footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="home-fifteen-footer-block">
                        <div class="foot-title">
                            <a href="#"><img src="{{asset('website')}}/img/logo-2.png" alt=""></a>
                        </div>
                        <p>
                            Thank you for visiting our site. We are committed to providing you with the best in healthcare information and services. Explore our resources to find expert advice, comprehensive care options, and support tailored to your needs.
                        </p>
                        <div class="foot-social-icons">
                            <a href="#" class="me-3"><i class="feather-facebook"></i></a>
                            <a href="#" class="me-3"><i class="feather-instagram"></i></a>
                            <a href="#" class="me-3"><i class="feather-linkedin"></i></a>
                            <a href="#"><i class="feather-twitter"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="home-fifteen-footer-block">
                        <div class="foot-title">
                            <h6>For Users</h6>
                        </div>
                        <div class="foot-list">
                            <ul>
                                <li><a href="{{route('login')}}">Login</a></li>
                                <li><a href="{{route('register')}}">Register</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="home-fifteen-footer-block">
                        <div class="foot-title">
                            <h6>Contact Us</h6>
                        </div>
                        <div class="foot-list-address">
                            <p>3556 Beech Street, San Francisco, California, CA 94108.</p>
                            <p> +1 315 369 5943</p>
                            <p><a href="https://doccure-html.dreamguystech.com/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="fc98939f9f898e99bc99849d918c9099d29f9391">[email&#160;protected]</a></p>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="foot-line">
            <div class="row">
                <div class="col-lg-12">
                    <div class="foot-copy-rights">
                        <p class="mb-0">© 2024 Doccure. All rights reserved.</p>
                        <div class="foot-terms-policy">
                            <a href="{{route('term_conditions')}}">Terms and Conditions</a><span> | </span>
                            <a href="{{route('policy')}}">Policy</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>



</script><script src="{{asset('website')}}/js/jquery-3.6.0.min.js"></script>

<script src="{{asset('website')}}/js/bootstrap.bundle.min.js"></script>

<script src="{{asset('website')}}/js/owl.carousel.min.js"></script>

<script src="{{asset('website')}}/js/slick.js"></script>

<script src="{{asset('website')}}/js/feather.min.js"></script>

<script src="{{asset('website')}}/js/aos.js"></script>

<script src="{{asset('website')}}/js/isotope.pkgd.min.js"></script>

<script src="{{asset('website')}}/js/script.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Custom JS -->
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
</body>


<!-- Mirrored from doccure-html.dreamguystech.com/template/index-fifteen.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 02 Dec 2022 22:18:41 GMT -->
</html>
