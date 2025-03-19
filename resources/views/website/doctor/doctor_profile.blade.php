@extends('website.layouts.master')
@push('css')
    <style>
        .open-status {
            font-weight: bold;
            margin-right: 10px;
        }

        .open-status .badge.bg-success-light {
            background-color: #28a745;  /* Green for Open */
        }

        .open-status .badge.bg-danger-light {
            background-color: #dc3545;  /* Red for Closed */
        }

        .listing-day.current .day {
            font-weight: bold;
            color: #007bff;  /* Highlight today's day */
        }

        .listing-day.closed .time {
            color: #dc3545;  /* Red color for Closed */
        }

        /* Style for filled stars (golden stars) */
        .filled {
            color: #FFD700;  /* Golden color */
        }

        /* Optional: Style for empty stars (light gray color for unfilled stars) */
        .fas.fa-star {
            color: #d3d3d3;  /* Light gray for empty stars */
        }

        /* Optional: Half-star color */
        .fas.fa-star-half-alt {
            color: #FFD700;  /* Golden color for half stars */
        }
}

    </style>
@endpush
@section('content')

    <div class="breadcrumb-bar">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-12 col-12">
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('website')}}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Doctor Profile</li>
                        </ol>
                    </nav>
                    <h2 class="breadcrumb-title">Doctor Profile</h2>
                </div>
            </div>
        </div>
    </div>


    <div class="content">
        <div class="container">

            <div class="card">
                <div class="card-body">
                    <div class="doctor-widget">
                        <div class="doc-info-left">
                            <div class="doctor-img">
                                <img src="{{asset('backend')}}/{{$users->profile->image}}" class="img-fluid" alt="User Image">
                            </div>
                            <div class="doc-info-cont">
                                <h4 class="doc-name">Dr.{{$users->first_name}} {{$users->last_name}}</h4>
                                <p class="doc-speciality">{{$users->profile->speciality->name }}</p>
                                @if($speciality)
                                <p class="doc-department"><img src="{{asset('backend')}}/{{$speciality->image}}" class="img-fluid" alt="Speciality">{{ $speciality->name }}</p>
                                @else
                                    <p>No speciality associated with your profile.</p>
                                @endif

                                <div class="doctor-rating">
                                    @php
                                        // Calculate full stars, half stars, and empty stars for the average rating
                                        $fullStars = floor($averageRating);  // Full stars
                                        $halfStar = ($averageRating - $fullStars) >= 0.5 ? 1 : 0;  // Half star logic
                                        $emptyStars = 5 - ($fullStars + $halfStar);  // Empty stars
                                    @endphp

                                        <!-- Display full stars -->
                                    @for($i = 1; $i <= $fullStars; $i++)
                                        <i class="fas fa-star filled"></i>
                                    @endfor

                                    <!-- Display half star if needed -->
                                    @if($halfStar)
                                        <i class="fas fa-star-half-alt filled"></i>
                                    @endif

                                    <!-- Display empty stars -->
                                    @for($i = 1; $i <= $emptyStars; $i++)
                                        <i class="fas fa-star"></i>
                                    @endfor

                                    <span class="d-inline-block average-rating">({{ number_format($averageRating, 1) }})</span>
                                </div>

                                <div class="clinic-details">
                                    <p class="doc-location"><i class="fas fa-map-marker-alt"></i> {{$users->profile->address}} - <a href="javascript:void(0);">Get Directions</a></p>
                                    <ul class="clinic-gallery">
                                        @foreach($users->attachments as $attachment)
                                            <li>
                                                <a href="{{ asset('backend')}}/{{$attachment->file }}" data-fancybox="gallery">
                                                    <img src="{{ asset('backend')}}/{{$attachment->file }}" alt="Feature">
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>

                            </div>
                        </div>
                        <div class="doc-info-right">
                            <div class="clini-infos">
                                <ul>
                                    <li><i class="far fa-thumbs-up"></i> 99%</li>
                                    <li><i class="far fa-comment"></i>{{$reviewCount}} Feedback</li>
                                    <li><i class="fas fa-map-marker-alt"></i>{{$users->profile->address}}</li>
                                    <li><i class="far fa-money-bill-alt"></i> {{$users->profile->fees}} per hour </li>
                                </ul>
                            </div>
                            <div class="doctor-action">
                                <a href="javascript:void(0)" class="btn btn-white fav-btn">
                                    <i class="far fa-bookmark"></i>
                                </a>
                                <a href="chat.html" class="btn btn-white msg-btn">
                                    <i class="far fa-comment-alt"></i>
                                </a>
                                <a href="javascript:void(0)" class="btn btn-white call-btn" data-bs-toggle="modal" data-bs-target="#voice_call">
                                    <i class="fas fa-phone"></i>
                                </a>
                                <a href="javascript:void(0)" class="btn btn-white call-btn" data-bs-toggle="modal" data-bs-target="#video_call">
                                    <i class="fas fa-video"></i>
                                </a>
                            </div>
                            <div class="clinic-booking">
                                <a class="apt-btn" href="{{route('booking', [$users->id])}}">Book Appointment</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="card">
                <div class="card-body pt-0">

                    <nav class="user-tabs mb-4">
                        <ul class="nav nav-tabs nav-tabs-bottom nav-justified">
                            <li class="nav-item">
                                <a class="nav-link active" href="#doc_overview" data-bs-toggle="tab">Overview</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#doc_reviews" data-bs-toggle="tab">Reviews</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#doc_business_hours" data-bs-toggle="tab">Business Hours</a>
                            </li>
                        </ul>
                    </nav>


                    <div class="tab-content pt-0">

                        <div role="tabpanel" id="doc_overview" class="tab-pane fade show active">
                            <div class="row">
                                <div class="col-md-12 col-lg-9">

                                    <div class="widget about-widget">
                                        <h4 class="widget-title">About Me</h4>
                                        <p> {{$users->profile->about}}</p>
                                    </div>


                                    <div class="widget education-widget">
                                        <h4 class="widget-title">Education</h4>
                                        <div class="experience-box">
                                            <ul class="experience-list">
                                                @foreach ($users->educations as $education)  <!-- Loop through all education records of the user -->
                                                <li>
                                                    <div class="experience-user">
                                                        <div class="before-circle"></div>
                                                    </div>
                                                    <div class="experience-content">
                                                        <div class="timeline-content">
                                                            <a href="#/" class="name">{{ $education->university }}</a>  <!-- Display the university name -->
                                                            <div>{{ $education->field }}</div>  <!-- Display the field of study -->
                                                            <span class="time">{{ $education->university_start_date }} - {{ $education->university_end_date }}</span>  <!-- Display the start and end dates -->
                                                        </div>
                                                    </div>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="widget experience-widget">
                                        <h4 class="widget-title">Work & Experience</h4>
                                        <div class="experience-box">
                                            <ul class="experience-list">
                                                @foreach ($users->experiences as $experience)  <!-- Loop through all work experience records of the user -->
                                                <li>
                                                    <div class="experience-user">
                                                        <div class="before-circle"></div>
                                                    </div>
                                                    <div class="experience-content">
                                                        <div class="timeline-content">
                                                            <a href="#/" class="name">{{ $experience->hospital_name }}</a>  <!-- Display the hospital name -->
                                                            <span class="time">{{ $experience->start_date }} - {{ $experience->end_date }} ({{ \Carbon\Carbon::parse($experience->start_date)->diffInYears(\Carbon\Carbon::parse($experience->end_date)) }} years)</span>  <!-- Display the start and end dates with years difference -->
                                                        </div>
                                                    </div>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>


                        <div role="tabpanel" id="doc_reviews" class="tab-pane fade">

                            <div class="widget review-listing">
                                <ul class="comments-list">

                                    <ul>
                                        @foreach($reviews as $review)
                                            <li>
                                                <div class="comment">
                                                    <img class="avatar avatar-sm rounded-circle" alt="User Image" src="{{ asset('backend')}}/{{$review->patient->profile->image}}">
                                                    <div class="comment-body">
                                                        <div class="meta-data">
                                                            <span class="comment-author">{{ $review->patient->first_name }} {{ $review->patient->last_name }}</span>
                                                            <span class="comment-date">Reviewed {{ $review->created_at->diffForHumans() }}</span>
                                                            <div class="review-count rating">
                                                                    @php
                                                                        // Extract the numeric rating from the string (e.g., "star-4" -> 4)
                                                                        $rating = (int) str_replace('star-', '', $review->rating);
                                                                    @endphp

                                                                    @for($i = 1; $i <= 5; $i++)
                                                                        <i class="fas fa-star {{ $i <= $rating ? 'filled' : '' }}"></i>
                                                                    @endfor
                                                                    <span class="d-inline-block average-rating">({{ $rating }})</span>
                                                            </div>
                                                        </div>
                                                        <p class="recommended">
                                                            <i class="far fa-thumbs-up"></i> I recommend the doctor
                                                        </p>
                                                        <p class="comment-content">
                                                            {{ $review->description }}
                                                        </p>
                                                        <div class="comment-reply">
                                                            <p class="recommend-btn">
                                                                <span>Recommend?</span>
                                                                <a href="#" class="like-btn">
                                                                    <i class="far fa-thumbs-up"></i> Yes
                                                                </a>
                                                                <a href="#" class="dislike-btn">
                                                                    <i class="far fa-thumbs-down"></i> No
                                                                </a>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </ul>

                            </div>


                            <div class="write-review">
                                <h4>Write a review for <strong>Dr. {{$users->first_name}} {{$users->last_name}} </strong></h4>

                                <form action="{{ route('review') }}" method="POST">
                                    @csrf

                                    <!-- Hidden field for doctor_id -->
                                    <input type="hidden" name="doctor_id" value="{{ $users->id }}">

                                    <div class="form-group">
                                        <label>Review</label>
                                        <div class="star-rating">
                                            @for ($i = 5; $i >= 1; $i--)
                                                <input id="star-{{ $i }}" type="radio" name="rating" value="star-{{ $i }}" {{ old('rating') == "star-{$i}" ? 'checked' : '' }}>
                                                <label for="star-{{ $i }}" title="{{ $i }} star{{ $i > 1 ? 's' : '' }}">
                                                    <i class="active fa fa-star"></i>
                                                </label>
                                            @endfor
                                        </div>
                                        @error('rating')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Title of your review</label>
                                        <input class="form-control" type="text" name="title" placeholder="If you could say it in one sentence, what would you say?" value="{{ old('title') }}">
                                        @error('title')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Your review</label>
                                        <textarea id="review_desc" maxlength="100" class="form-control" name="review_desc">{{ old('review_desc') }}</textarea>
                                        <div class="d-flex justify-content-between mt-3">
                                            <small class="text-muted"><span id="chars">100</span> characters remaining</small>
                                        </div>
                                        @error('review_desc')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <hr>

                                    <div class="form-group">
                                        <div class="terms-accept">
                                            <div class="custom-checkbox">
                                                <input type="checkbox" id="terms_accept" name="terms_accept" {{ old('terms_accept') ? 'checked' : '' }}>
                                                <label for="terms_accept">I have read and accept <a href="{{route('term_conditions')}}">Terms &amp; Conditions</a></label>
                                            </div>
                                            @error('terms_accept')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="submit-section">
                                        <button type="submit" class="btn btn-primary submit-btn">Add Review</button>
                                    </div>
                                </form>
                            </div>


                        </div>


                        <div role="tabpanel" id="doc_business_hours" class="tab-pane fade">
                            <div class="row">
                                <div class="col-md-6 offset-md-3">

                                    <div class="widget business-widget">
                                        <div class="widget-content">
                                            <div class="listing-hours">
                                                @php
                                                    $daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                                                    $currentDayIndex = \Carbon\Carbon::now()->dayOfWeek; // Get today's index
                                                    $currentTime = \Carbon\Carbon::now(); // Current time to compare with business hours
                                                @endphp

                                                    <!-- Today's Entry with "Open Now" or "Closed" -->
                                                <div class="listing-day current">
                                                    <div class="day">Today <span>{{ \Carbon\Carbon::now()->format('d M Y') }}</span></div>
                                                    <div class="time-items">
                                                        @php
                                                            // Assuming 'start_date' and 'end_date' are valid DateTime values
                                                            $startTime = \Carbon\Carbon::parse($users->profile->start_date);
                                                            $endTime = \Carbon\Carbon::parse($users->profile->end_date);
                                                            $startTimeFormatted = $startTime->format('h:i A');
                                                            $endTimeFormatted = $endTime->format('h:i A');
                                                        @endphp
                                                            <!-- Check if the current time is within the open hours for today -->
                                                        @if($currentTime->between($startTime, $endTime))
                                                            <span class="open-status"><span class="badge bg-success-light">Open Now</span></span>
                                                        @else
                                                            <span class="open-status"><span class="badge bg-danger-light">Closed</span></span>
                                                        @endif
                                                        <span class="time">{{ $startTimeFormatted }} - {{ $endTimeFormatted }}</span>
                                                    </div>
                                                </div>

                                                <!-- Loop through the rest of the days of the week -->
                                                @foreach($daysOfWeek as $index => $day)
                                                    @if($index != $currentDayIndex) <!-- Skip today, as it's already displayed -->
                                                    <div class="listing-day @if($day == 'Sunday') closed @endif">
                                                        <div class="day">{{ $day }}</div>
                                                        <div class="time-items">
                                                            @if($day == 'Sunday')
                                                                <span class="time"><span class="badge bg-danger-light">Closed</span></span>
                                                            @else
                                                                <span class="time">{{ $startTimeFormatted }} - {{ $endTimeFormatted }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
