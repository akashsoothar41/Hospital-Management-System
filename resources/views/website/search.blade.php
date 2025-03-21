@extends('website.layouts.master')
@section('content')
    <div class="breadcrumb-bar">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-8 col-12">
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Search</li>
                        </ol>
                    </nav>
                    <h2 class="breadcrumb-title">Search Results for {{ request()->input('query') }}</h2>
                </div>
                <div class="col-md-4 col-12 d-md-block d-none">
                    <div class="sort-by">
                        <span class="sort-title">Sort by</span>
                        <span class="sortby-fliter">
                        <select class="select form-select">
                        <option>Select</option>
                        <option class="sorting">Rating</option>
                        <option class="sorting">Popular</option>
                        <option class="sorting">Latest</option>
                        <option class="sorting">Free</option>
                        </select>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 col-lg-4 col-xl-3 theiaStickySidebar">

                    <div class="card search-filter">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Search Filter</h4>
                        </div>
                        <div class="card-body">
                            <div class="filter-widget">
                                <div class="cal-icon">
                                    <input type="text" class="form-control datetimepicker" placeholder="Select Date">
                                </div>
                            </div>
                            <div class="filter-widget">
                                <h4>Gender</h4>
                                <div>
                                    <label class="custom_check">
                                        <input type="checkbox" name="gender_type" checked>
                                        <span class="checkmark"></span> Male Doctor
                                    </label>
                                </div>
                                <div>
                                    <label class="custom_check">
                                        <input type="checkbox" name="gender_type">
                                        <span class="checkmark"></span> Female Doctor
                                    </label>
                                </div>
                            </div>
                            <div class="filter-widget">
                                <h4>Select Specialist</h4>
                                <div>
                                    <label class="custom_check">
                                        <input type="checkbox" name="select_specialist" checked>
                                        <span class="checkmark"></span> Urology
                                    </label>
                                </div>
                                <div>
                                    <label class="custom_check">
                                        <input type="checkbox" name="select_specialist" checked>
                                        <span class="checkmark"></span> Neurology
                                    </label>
                                </div>
                                <div>
                                    <label class="custom_check">
                                        <input type="checkbox" name="select_specialist">
                                        <span class="checkmark"></span> Dentist
                                    </label>
                                </div>
                                <div>
                                    <label class="custom_check">
                                        <input type="checkbox" name="select_specialist">
                                        <span class="checkmark"></span> Orthopedic
                                    </label>
                                </div>
                                <div>
                                    <label class="custom_check">
                                        <input type="checkbox" name="select_specialist">
                                        <span class="checkmark"></span> Cardiologist
                                    </label>
                                </div>
                                <div>
                                    <label class="custom_check">
                                        <input type="checkbox" name="select_specialist">
                                        <span class="checkmark"></span> Cardiologist
                                    </label>
                                </div>
                            </div>
                            <div class="btn-search">
                                <button type="button" class="btn w-100">Search</button>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-12 col-lg-8 col-xl-9">

                    @foreach ($users as $user)
                        <div class="card">
                            <div class="card-body">
                                <div class="doctor-widget">
                                    <div class="doc-info-left">
                                        <div class="doctor-img">
                                            <!-- Doctor's Profile Image -->
                                            <a href="{{ route('doctor_profile', $user->id) }}">
                                                <img src="{{ asset('backend/' . $user->profile->image) }}" class="img-fluid" alt="User Image">
                                            </a>
                                        </div>
                                        <div class="doc-info-cont">
                                            <h4 class="doc-name">
                                                <a href="{{ route('doctor_profile', $user->id) }}">
                                                    {{ $user->first_name }} {{ $user->last_name }}
                                                </a>
                                            </h4>
                                            <!-- Display the doctor's specialties -->
                                            <p class="doc-speciality">
                                                {{ $user->profile->speciality ? $user->profile->speciality->name : 'No specialty assigned' }}
                                            </p>
                                            <h5 class="doc-department">
                                                <img src="{{ asset('website/img/specialities/specialities-05.png') }}" class="img-fluid" alt="Speciality">
                                                {{ $user->profile->speciality->name ?? 'Specialty not assigned' }}
                                            </h5>
                                            <div class="rating">
                                                @php
                                                    $averageRating = $user->reviews->avg('rating'); // Calculate average rating
                                                @endphp
                                                @for ($i = 0; $i < 5; $i++)
                                                    <i class="fas fa-star{{ $i < $averageRating ? ' filled' : '' }}"></i>
                                                @endfor
                                                <span class="d-inline-block average-rating">({{ $user->reviews->count() }})</span>
                                            </div>
                                            <div class="clinic-details">
                                                <p class="doc-location">
                                                    <i class="fas fa-map-marker-alt"></i>
                                                    {{ $user->profile->address ?? 'No address available' }}
                                                </p>
{{--                                                <ul class="clinic-gallery">--}}
{{--                                                    @forelse ($user->doctor_attachments as $attachment)--}}
{{--                                                        <li>--}}
{{--                                                            <a href="{{ asset('backend/' . $attachment->image) }}" data-fancybox="gallery">--}}
{{--                                                                <img src="{{ asset('backend/' . $attachment->image) }}" alt="Feature">--}}
{{--                                                            </a>--}}
{{--                                                        </li>--}}
{{--                                                    @empty--}}
{{--                                                        <li>No images available</li>--}}
{{--                                                    @endforelse--}}
{{--                                                </ul>--}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="doc-info-right">
                                        <div class="clini-infos">
                                            <ul>
                                                <li><i class="far fa-thumbs-up"></i> 98%</li>
                                                <li><i class="far fa-comment"></i> {{ $user->reviews->count() }} Feedback</li>
                                                <li><i class="fas fa-map-marker-alt"></i> {{ $user->profile->address ?? 'No address available' }}</li>
                                                <li><i class="far fa-money-bill-alt"></i> ${{ $user->profile->fees }} <i class="fas fa-info-circle" data-bs-toggle="tooltip" title="Lorem Ipsum"></i></li>
                                            </ul>
                                        </div>
                                        <div class="clinic-booking">
                                            <a class="view-pro-btn" href="{{ route('doctor_profile', $user->id) }}">View Profile</a>
                                            <a class="apt-btn" href="{{ route('booking', $user->id) }}">Book Appointment</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach



                    <div class="load-more text-center">
                        <a class="btn btn-primary btn-sm" href="javascript:void(0);">Load More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
