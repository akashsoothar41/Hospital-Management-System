@extends('backend.admin.layouts.master')
@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="row">
        <div class="col-sm-12">
            <h3 class="page-title">Reviews</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin')}}">Dashboard</a></li>
                <li class="breadcrumb-item active">Reviews</li>
            </ul>
        </div>
    </div>
</div>
<!-- /Page Header -->

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="datatable table table-hover table-center mb-0">
                        <thead>
                        <tr>
                            <th>Patient Name</th>
                            <th>Doctor Name</th>
                            <th>Ratings</th>
                            <th>Description</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th class="text-right">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($reviews as $review)
                            <tr>
                                <!-- Patient Information -->
                                <td>
                                    <h2 class="table-avatar">
                                        <!-- Dynamically populate the patient's profile picture and name -->
                                        <a href="" class="avatar avatar-sm mr-2">
                                            <img class="avatar-img rounded-circle" src="{{ asset('backend/'.$review->patient->profile->image) }}" alt="Patient Image">
                                        </a>
                                        <a href="">
                                            @if(Auth::user()->id == $review->patient->id)
                                                You  <!-- If the patient is the logged-in user -->
                                            @else
                                                {{ $review->patient->first_name }} {{ $review->patient->last_name }}  <!-- Otherwise, show the patient's full name -->
                                            @endif
                                        </a>
                                    </h2>
                                </td>

                                <!-- Doctor Information (Check if doctor exists) -->
                                <td>
                                    @if ($review->doctor)
                                        <h2 class="table-avatar">
                                            <!-- Dynamically populate the doctor's profile picture and name -->
                                            <a href="" class="avatar avatar-sm mr-2">
                                                <img class="avatar-img rounded-circle" src="{{ asset('backend')}}/{{$review->doctor->profile->image}}" alt="Doctor Image">
                                            </a>
                                            <a href="">{{ $review->doctor->first_name }} {{ $review->doctor->last_name }}</a>
                                        </h2>
                                    @else
                                        <!-- Show message when no doctor is assigned -->
                                        <span>No Doctor Assigned</span>
                                    @endif
                                </td>

                                <td>
                                    @php
                                        // Assume $review->rating is something like 'star-4'
                                        $rating = (int) substr($review->rating, -1); // Extracts last character (e.g., 'star-4' -> 4)
                                    @endphp

                                    @for ($i = 0; $i < 5; $i++)
                                        @if ($i < $rating)
                                            <i class="fe fe-star text-warning"></i> <!-- Filled star -->
                                        @else
                                            <i class="fe fe-star-o text-secondary"></i> <!-- Empty star -->
                                        @endif
                                    @endfor
                                </td>




                                <!-- Description -->
                                <td>
                                    {{ Str::limit($review->description, 40, ' [Read more]') }}
                                </td>


                                <!-- Date and Time -->
                                <td>
                                    {{ \Carbon\Carbon::parse($review->created_at)->format('d M Y') }} <br>
                                    <small>{{ \Carbon\Carbon::parse($review->created_at)->format('h:i A') }}</small>
                                </td>

                                <td>
                                    <div class="status-toggle">
                                        <input type="checkbox" id="status_{{ $review->id }}" class="check" data-review-id="{{ $review->id }}" {{ $review->status ? 'checked' : '' }}>
                                        <label for="status_{{ $review->id }}" class="checktoggle">checkbox</label>
                                    </div>
                                </td>

                                <!-- Actions (Delete) -->
                                <td class="text-right">
                                    <div class="actions">
                                        <!-- Delete action with dynamic modal -->
                                        <a class="btn btn-sm bg-danger-light" data-toggle="modal" href="#delete_modal_{{ $review->id }}">
                                            <i class="fe fe-trash"></i> Delete
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            // When the checkbox is toggled
            $('.status-toggle input').change(function() {
                var reviewId = $(this).data('review-id');
                var status = $(this).prop('checked') ? 1 : 0;

                console.log("Review ID: " + reviewId + " Status: " + status); // Debugging log

                $.ajax({
                    url: '/update-review-status', // Define your route
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}', // CSRF token
                        review_id: reviewId,          // Send the review ID
                        status: status
                    },
                    success: function(response) {
                        console.log(response); // Check the response
                        if(response.msg) {
                            // Use SweetAlert to show the success message
                            Swal.fire({
                                icon: 'success', // You can use 'success', 'error', 'warning', etc.
                                title: 'Success!',
                                text: response.msg,  // The message from the server
                                confirmButtonText: 'Okay'
                            });// Optionally show success message
                        }
                    },
                    error: function(response) {
                        console.log(response); // Check the error
                    }
                });
            });
        });
    </script>

    @endpush
