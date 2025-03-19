@extends('website.layouts.master')

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <style>
        /* Custom styles for highlighted appointment */
        .timing.selected {
            background-color: #007bff; /* Highlight color */
            color: white;
            border-radius: 5px;
            padding: 5px 10px;
        }

        .timing.selected span {
            font-weight: bold;
        }
    </style>
@endpush

@section('content')
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="booking-doc-info">
                                <a href="doctor-profile.html" class="booking-doc-img">
                                    <img src="{{asset('backend')}}/img/doctors/doctor-thumb-02.jpg" alt="User Image">
                                </a>
                                <div class="booking-info">
                                    <h4><a href="doctor-profile.html">Dr. {{$doctor->first_name}} {{$doctor->last_name}}</a></h4>
                                    <div class="rating">
                                        <i class="fas fa-star filled"></i>
                                        <i class="fas fa-star filled"></i>
                                        <i class="fas fa-star filled"></i>
                                        <i class="fas fa-star filled"></i>
                                        <i class="fas fa-star"></i>
                                        <span class="d-inline-block average-rating">35</span>
                                    </div>
                                    <p class="text-muted mb-0"><i class="fas fa-map-marker-alt"></i> {{$doctor->profile->address}}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-4 col-md-6">
                            <h4 class="mb-1">{{ \Carbon\Carbon::now()->format('d F Y') }}</h4>
                            <p class="text-muted">{{ \Carbon\Carbon::now()->format('l') }}</p>
                        </div>
                        <div class="col-12 col-sm-8 col-md-6 text-sm-end">
                            <div class="bookingrange btn btn-white btn-sm mb-3">
                                <i class="far fa-calendar-alt me-2"></i>
                                <span>Select Date Range</span>
                                <i class="fas fa-chevron-down ms-2"></i>
                            </div>
                        </div>
                    </div>

                    <div class="card booking-schedule schedule-widget">
                        <div class="schedule-header">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="day-slot">
                                        <ul>
                                            <!-- Left Arrow (Previous Week) -->
                                            <li class="left-arrow">
                                                <a href="#"><i class="fa fa-chevron-left"></i></a>
                                            </li>

                                            @foreach(range(0, 6) as $i)
                                                @php
                                                    // Get the current date for the loop, starting from Monday
                                                    $date = \Carbon\Carbon::now()->startOfWeek()->addDays($i);
                                                @endphp
                                                <li>
                                                    <span>{{ $date->format('D') }}</span> <!-- Day (Mon, Tue, etc.) -->
                                                    <span class="slot-date">{{ $date->format('d M') }} <small class="slot-year">{{ $date->format('Y') }}</small></span> <!-- Date (e.g., 11 Nov 2019) -->
                                                </li>
                                            @endforeach

                                            <!-- Right Arrow (Next Week) -->
                                            <li class="right-arrow">
                                                <a href="#"><i class="fa fa-chevron-right"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="schedule-cont">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="time-slot">
                                        <ul class="clearfix">
                                            @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                                <li class="{{ $day == 'Sunday' ? 'closed' : '' }}">
                                                    @if($day != 'Sunday')
                                                        <!-- Start Time -->
                                                        <a class="timing" href="#"
                                                           data-doctor-id="{{ $doctor->id }}"
                                                           data-day="{{ $day }}"
                                                           data-start-time="{{ \Carbon\Carbon::parse($doctor->profile->start_date)->format('g:i A') }}"
                                                           data-end-time="{{ \Carbon\Carbon::parse($doctor->profile->end_date)->format('g:i A') }}">
                                                            <span>{{ \Carbon\Carbon::parse($doctor->profile->start_date)->format('g:i A') }}</span>
                                                        </a>
                                                        <!-- End Time -->
                                                        <a class="timing" href="#"
                                                           data-doctor-id="{{ $doctor->id }}"
                                                           data-day="{{ $day }}"
                                                           data-start-time="{{ \Carbon\Carbon::parse($doctor->profile->start_date)->format('g:i A') }}"
                                                           data-end-time="{{ \Carbon\Carbon::parse($doctor->profile->end_date)->format('g:i A') }}">
                                                            <span>{{ \Carbon\Carbon::parse($doctor->profile->end_date)->format('g:i A') }}</span>
                                                        </a>
                                                    @else
                                                        <!-- Sunday is closed -->
                                                        <a class="timing" href="#">
                                                            <span>Closed</span>
                                                        </a>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Hidden form to submit the booking -->
                        <form id="booking-form" action="{{ route('book_appointment', ['doctor_id' => $doctor->id]) }}" method="POST" style="display: none;">
                            @csrf
                            <input type="hidden" name="day" id="booking-day">
                            <input type="hidden" name="start_time" id="booking-start-time">
                            <input type="hidden" name="end_time" id="booking-end-time">
                            <input type="hidden" name="patient_id" id="booking-patient-id" value="{{ auth()->user()->id }}">
                            <button type="submit" id="submit-booking" style="display: none;">Book Appointment</button>
                        </form>
                    </div>

                    <div class="submit-section proceed-btn text-end">
                        <!-- Book Appointment button (hidden initially) -->
                        <button id="book-appointment-button" class="btn btn-primary" style="display:none;">Book Appointment</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <!-- Include Moment.js -->
    <script src="{{asset('website')}}/js/moment.min.js"></script>
    <!-- Include Date Range Picker JS -->
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script>
        $(document).ready(function() {
            // Date Range Picker
            if ($('.bookingrange').length > 0) {
                var start = moment().subtract(6, 'days');
                var end = moment();

                function booking_range(start, end) {
                    $('.bookingrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                }

                $('.bookingrange').daterangepicker({
                    startDate: start,
                    endDate: end,
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    }
                }, booking_range);

                booking_range(start, end);
            }

            // When a time slot is clicked
            $(document).on('click', '.timing', function(e) {
                e.preventDefault(); // Prevent default behavior

                // Get doctor_id, day, start_time, and end_time from data attributes
                var doctor_id = $(this).data('doctor-id');
                var day = $(this).data('day');
                var start_time = $(this).data('start-time');
                var end_time = $(this).data('end-time');

                // Remove "selected" class from all time slots
                $('.timing').removeClass('selected');

                // Add "selected" class to the clicked time slot
                $(this).addClass('selected');

                // Set the hidden input values in the form
                $('#booking-day').val(day);
                $('#booking-start-time').val(start_time);
                $('#booking-end-time').val(end_time);

                // Show the "Book Appointment" button
                $('#book-appointment-button').show();  // Show Book Appointment button
            });

            // When the "Book Appointment" button is clicked
            $('#book-appointment-button').click(function() {
                // Hide the "Proceed to Pay" button
                $('#proceed-button').hide();

                // Submit the booking form
                $('#booking-form').submit();
            });
        });
    </script>
@endpush
