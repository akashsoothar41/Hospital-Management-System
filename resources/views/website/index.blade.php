@extends('website.layouts.master')
@section('content')
    <section class="home-section-fifteen">
        <div class="container">
            <div class="row ">
                <div class="col-lg-6">
                    <div class="home-fifteen-banner aos" data-aos="fade-up">
                        <img src="{{asset('website')}}/img/home-15-banner-2.png" alt="">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="title-block aos" data-aos="fade-up" data-aos-delay="100">
                        <h2>Search Doctor,</h2>
                        <h2>Make an Appointment</h2>
                        <p>Discover the best doctors, clinic & hospital nearest to you.</p>
                    </div>
                    <!-- Form starts here -->
                    <form action="{{ route('search') }}" method="GET" class="locations-search aos" data-aos="fade-up" data-aos-delay="300">
                        @csrf
                        <div class="row">
                            <div class="col-lg-4 col-md-4">
                                <div class="input-group mb-2">
                                    <span class="input-group-text" id="basic-addon2"><i class="feather-map-pin"></i></span>
                                    <input type="text" class="form-control placeholder-css" name="location" id="location" placeholder="Search location" aria-label="Location" aria-describedby="basic-addon2">
                                </div>
                                <p>Based on your Location</p>
                            </div>
                            <div class="col-lg-8 col-md-8">
                                <div class="input-group mb-2">
                                    <span class="input-group-text" id="basic-addon3"><i class="feather-search"></i></span>
                                    <input type="text" class="form-control placeholder-css" name="query" id="search_term" placeholder="Search Doctors, Clinics, Hospitals, Diseases Etc" aria-label="Search term" aria-describedby="basic-addon3">
                                </div>
                                <p>Ex: Dentist, Sugar Check-up etc.</p>
                            </div>
                        </div>
                        <div class="make-appointment-btn aos" data-aos="fade-up" data-aos-delay="500">
                            <button type="submit" class="btn btn-primary">Make Appointment <i class="feather-arrow-right ms-1"></i></button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </section>


    <section class="home-fifteen-looking-section">
        <div class="container">
            <div class="row aos" data-aos="fade-up">
                <div class="col-lg-12">
                    <div class="home-fifteen-section-title text-center">
                        <h2>Clinic and <span>Specialities</span></h2>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="looking-for-container aos" data-aos="fade-up" data-aos-delay="200">
                        <div class="looking-for-box">
                            <div class="look-for-box-icon">
                                <img src="{{asset('website')}}/img/icons/set-bed.svg" class="img-fluid" alt="">
                            </div>
                            <h5>Visit a Doctor</h5>
                            <p>We hire the best specialists to deliver top-notch diagnostic services for you.</p>
                            <a href="">Book Now<i class="feather-arrow-right ms-1"></i></a>
                            <div class="looking-box-count">
                                <h2>01</h2>
                            </div>
                        </div>
                        <div class="background-hover-motion">
                            <img src="{{asset('website')}}/img/rotate-bg.png" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="looking-for-container aos" data-aos="fade-up" data-aos-delay="400">
                        <div class="looking-for-box">
                            <div class="look-for-box-icon">
                                <img src="{{asset('website')}}/img/icons/tablet-blue.svg" class="img-fluid" alt="">
                            </div>
                            <h5>Find a Pharmacy</h5>
                            <p>We provide the a wide range of medical services, so every person could have the opportunity.</p>
                            <a href="">Book Now<i class="feather-arrow-right ms-1"></i></a>
                            <div class="looking-box-count">
                                <h2>02</h2>
                            </div>
                        </div>
                        <div class="background-hover-motion">
                            <img src="{{asset('website')}}/img/rotate-bg.png" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="looking-for-container aos" data-aos="fade-up" data-aos-delay="600">
                        <div class="looking-for-box">
                            <div class="look-for-box-icon">
                                <img src="{{asset('website')}}/img/icons/test-tubes.svg" class="img-fluid" alt="">
                            </div>
                            <h5>Find a Lab</h5>
                            <p>We use the first-class medical equipment for timely diagnostics of various diseases.</p>
                            <a href="">Book Now<i class="feather-arrow-right ms-1"></i></a>
                            <div class="looking-box-count">
                                <h2>03</h2>
                            </div>
                        </div>
                        <div class="background-hover-motion">
                            <img src="{{asset('website')}}/img/rotate-bg.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="gallery-tab-section aos" data-aos="fade-up">
        <div class="water-mark-icons">
            <img src="{{asset('website')}}/img/poour-doctor-watermark-2.png" alt="">
            <img src="{{asset('website')}}/img/our-doctor-watermark.png" alt="">
            <img src="{{asset('website')}}/img/rotate-bg.png" alt="">
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="home-fifteen-section-title text-center">
                        <h2>Clinic and <span>Specialities</span></h2>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="button-group filters-button-group">
                        <button class="button is-checked" data-filter="*">All</button>
                        <button class="button" data-filter=".neurology">Neurology</button>
                        <button class="button" data-filter=".orthopedic">Orthopedic</button>
                        <button class="button" data-filter=".cardiologist">Cardiologist</button>
                        <button class="button" data-filter=".dentist">Dentist</button>
                        <button class="button" data-filter=".urology">Urology</button>
                    </div>

                    <div id="grid-container" class="transitions-enabled fluid masonry js-masonry grid">
                        @foreach($specialties as $specialty)
                            <!-- Dynamically adding class based on the name of the specialty -->
                            <article class="{{ strtolower($specialty->name) }} over-box">
                                <img style="width:250px;" src="{{ asset('backend')}}/{{ $specialty->image }}" class="img-responsive" />
                                <div class="gallery-after">
                                    <div class="gallery-after-content">
                                        <div class="gallery-hover-text">
                                            <h6>{{ $specialty->name }}</h6>
                                            <p>{{ $specialty->name }}</p>
                                        </div>
                                        <i class="feather-link"></i>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>


            </div>
        </div>
    </section>


    <section class="home-fifteen-why-us">
        <div class="water-mark-icons">
            <img src="{{asset('website')}}/img/why-us-water-mark.png" alt="">
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-lg-12 aos" data-aos="fade-up">
                            <div class="home-fifteen-section-title">
                                <h2>Why <span>Choose Us</span></h2>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="why-us-paragraph aos" data-aos="fade-up" data-aos-delay="200">
                                <p>
                                    Choose us for your healthcare needs because we prioritize your well-being above all. With a team of experienced professionals, state-of-the-art technology, and a commitment to personalized care, we ensure the highest standards of treatment and support. Our user-friendly platform offers reliable information, easy access to services, and a focus on patient satisfaction. Trust us to be your partner in health, providing expert care every step of the way.
                                </p>
                            </div>
                            <div class="why-us-points aos" data-aos="fade-up" data-aos-delay="400">
                                <ul>
                                    <li>We provide high-quality services for the whole family.</li>
                                    <li>Risus commodo viverra maecenas</li>
                                    <li>Your health is our top priority</li>
                                    <li>Affordable medical, dental and women's health care.</li>
                                    <li>Quis ipsum suspendisse ultrices gravida.</li>
                                    <li>We provide high-quality services for the whole family.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 aos" data-aos="fade-up" data-aos-delay="500">
                    <div class="why-us-container-img">
                        <img src="{{asset('website')}}/img/why-us-pics.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="home-fifteen-book-doctor">
        <div class="water-mark-icons">
            <img src="{{asset('website')}}/img/poour-doctor-watermark-2.png" alt="">
            <img src="{{asset('website')}}/img/our-doctor-watermark.png" alt="">
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="home-fifteen-section-title text-center">
                        <h2>Book <span>Our Doctor</span></h2>
                        <p class="mb-0">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>
                    </div>
                </div>
                <div class="book-doctor-container">
                    <div class="row">
                        <div class="col-lg-12 aos" data-aos="fade-up">
                            <div class="doctor-sliders owl-carousel owl-theme">
                            @foreach($doctors as $doctor)
                                <div class="profile-widget">
                                    <div class="doc-img">
                                        <a href="{{route('doctor_profile', [$doctor->id])}}">
                                            <img class="img-fluid" alt="User Image" src="{{asset('backend')}}/{{$doctor->profile->image}}">
                                        </a>
                                        <a href="javascript:void(0)" class="fav-btn"> <i class="far fa-bookmark"></i>
                                        </a>
                                    </div>
                                    <div class="pro-content">
                                        <h3 class="title">
                                            <a href="{{route('doctor_profile', [$doctor->id])}}">{{$doctor->first_name}} {{$doctor->last_name}}</a>
                                            <i class="fas fa-check-circle verified"></i>
                                        </h3>
                                        <p class="speciality">{{$doctor->speciality->name?? ''}}</p>
                                        <ul class="available-info">
                                            <li> <i class="feather-map-pin"></i>{{$doctor->profile->address?? ''}}</li>
                                            <li> <i class="feather-calendar"></i> Availibility {{ \Carbon\Carbon::parse($doctor->profile->start_date)->format('h:i A') }} -
                                                {{ \Carbon\Carbon::parse($doctor->profile->end_date)->format('h:i A') }}</li>
                                            <li> <i class="feather-dollar-sign"></i> {{$doctor->profile->fees?? ''}}	<i class="fas fa-info-circle" data-bs-toggle="tooltip" title="Lorem Ipsum"></i>
                                            </li>
                                        </ul>
                                        <div class="row row-sm">
                                            <div class="col-6"> <a href="{{route('doctor_profile', [$doctor->id])}}" class="btn view-btn">View Profile</a>
                                            </div>
                                            <div class="col-6"> <a href="{{route('booking', [$doctor->id])}}" class="btn book-btn">Book Now</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="home-fifteen-view-btn aos" data-aos="fade-up">
                        <a href="#">View More <i class="feather-arrow-right ms-1"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="home-fifteen-features">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 aos" data-aos="fade-up">
                    <div class="home-fifteen-section-title text-center">
                        <h2>Availabe Features in<span> Our Clinic</span></h2>
                        <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>
                    </div>
                </div>
                <div class="feature-container-box">
                    <div class="row">
                        <div class="col-lg-2 col-md-4 col-sm-6 aos" data-aos="fade-up" data-aos-delay="300">
                            <a href="#">
                                <div class="features-container">
                                    <div class="our-features-img">
                                        <img src="{{asset('website')}}/img/services/features-01.svg" class="img-fluid" alt="">
                                    </div>
                                    <h4 class="mb-0">Operation</h4>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-2 col-md-4 col-sm-6 aos" data-aos="fade-up" data-aos-delay="500">
                            <a href="#">
                                <div class="features-container">
                                    <div class="our-features-img">
                                        <img src="{{asset('website')}}/img/services/features-02.svg" class="img-fluid" alt="">
                                    </div>
                                    <h4 class="mb-0">Medical</h4>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-2 col-md-4 col-sm-6 aos" data-aos="fade-up" data-aos-delay="700">
                            <a href="#">
                                <div class="features-container">
                                    <div class="our-features-img">
                                        <img src="{{asset('website')}}/img/services/features-03.svg" class="img-fluid" alt="">
                                    </div>
                                    <h4 class="mb-0">Patient Ward</h4>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-2 col-md-4 col-sm-6 aos" data-aos="fade-up" data-aos-delay="900">
                            <a href="#">
                                <div class="features-container">
                                    <div class="our-features-img">
                                        <img src="{{asset('website')}}/img/services/features-05.svg" class="img-fluid" alt="">
                                    </div>
                                    <h4 class="mb-0">Test Room</h4>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-2 col-md-4 col-sm-6 aos" data-aos="fade-up" data-aos-delay="1100">
                            <a href="#">
                                <div class="features-container">
                                    <div class="our-features-img">
                                        <img src="{{asset('website')}}/img/services/features-06.svg" class="img-fluid" alt="">
                                    </div>
                                    <h4 class="mb-0">ICU</h4>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-2 col-md-4 col-sm-6 aos" data-aos="fade-up" data-aos-delay="1300">
                            <a href="#">
                                <div class="features-container">
                                    <div class="our-features-img">
                                        <img src="{{asset('website')}}/img/services/features-04.svg" class="img-fluid" alt="">
                                    </div>
                                    <h4 class="mb-0">Laboratory</h4>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="home-fifteen-view-btn aos" data-aos="fade-up" data-aos-delay="1300">
                        <a href="#">View More <i class="feather-arrow-right ms-1"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="newsletter-container">
        <div class="container">
            <div class="newsletter-box">
                <div class="row">
                    <div class="col-lg-8 col-md-12">
                        <div class="newsletter-content-box">
                            <h3 class=" aos" data-aos="fade-up">Grab Our Newsletter</h3>
                            <p class=" aos" data-aos="fade-up" data-aos-delay="300">To receive latest offers and discounts from the shop.</p>
                            <form action="{{ route('subscribe') }}" method="POST">
                                @csrf
                                <div class="newsletter-input-section aos" data-aos="fade-up" data-aos-delay="500">
                                    <input type="email" name="email" placeholder="Enter Your Email Address" required>
                                    <button class="btn btn-secondary" type="submit"
                                            style="font-size: 18px;  color: #0071DC;    font-weight: 700; padding: 14px 50px; transition: all 0.5s; margin-left: 12px; background-color: #FFFFFF; box-shadow: inset 0 0 0 #0071dc;  border: 1px solid #FFFFFF; border-radius: 8px;">Subscribe
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="newsletter-container-img text-end aos" data-aos="fade-up">
                            <img src="{{asset('website')}}/img/newsletter-bg.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="home-fifteen-blog-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 aos" data-aos="fade-up">
                    <div class="home-fifteen-section-title text-center">
                        <h2>Our <span>Blogs</span></h2>
                        <p class="mb-0">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>
                    </div>
                </div>
                <div class="blog-container-box">
                    <div class="row justify-content-center">
                        @foreach($blogs as $blog)
                            <div class="col-lg-4 col-md-6 aos" data-aos="fade-up" data-aos-delay="200">
                                <div class="blog-inner-box">
                                    <!-- Link to blog detail page with blog id -->
                                    <a href="{{ route('blog_detail', ['id' => $blog->id]) }}">
                                        <div class="blog-img-box">
                                            <img src="{{ asset('backend/'.$blog->attachment->file ?? 'No Image') }}" style="width: 400px" class="img-fluid equal-img" alt="">
                                        </div>
                                    </a>
                                    <div class="blog-inner-content">
                                        <!-- Blog Title -->
                                        <a href="{{ route('blog_detail', ['id' => $blog->id]) }}">
                                            {{ \Illuminate\Support\Str::limit($blog->title, 25) }}
                                        </a>
                                        <div class="blog-profile-box d-flex align-items-center">
                                            <!-- Doctor Profile Image and Name -->
                                            <a href="{{ route('doctor_profile', ['id' => $blog->doctor->id]) }}">
                                                <div class="blog-avatar">
                                                    <img src="{{ asset('backend/'.$blog->doctor->profile->image) }}" class="img-fluid rounded-circle" alt="">
                                                </div>
                                            </a>
                                            <a href="{{ route('doctor_profile', ['id' => $blog->doctor->id]) }}" class="mb-0 ms-3">
                                                Dr. {{ $blog->doctor->first_name }} {{ $blog->doctor->last_name }}
                                            </a>
                                        </div>
                                        <!-- Formatted Date -->
                                        <p class="mb-0"><i class="feather-clock me-2"></i> {{ \Carbon\Carbon::parse($blog->created_at)->format('j M y') }}</p>
                                    </div>
                                    <div class="blog-category-btn">
                                        <!-- Category Button, replace with dynamic category if necessary -->
                                        <a href="">General</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="home-fifteen-view-btn aos" data-aos="fade-up" data-aos-delay="800">
                        <a href="blog-grid.html">View More <i class="feather-arrow-right ms-1"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
