@extends('backend.doctor.layouts.master')
@push('css')
    <style>
        .yellow-status {
            /*background-color: #00d0f1;*/
            padding: 5px 10px;
            border-radius: 10px;
            font-weight: bold;
        }
        .green-status {
            background-color: green;
            padding: 5px 10px;
            font-weight: bold;
        }
        .red-status {
            background-color: red;
            padding: 5px 10px;
            font-weight: bold;
        }

    </style>
@endpush
@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Appointments</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                    <li class="breadcrumb-item active">Appointments</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->
    <div class="row">
        <div class="col-md-12">

            <!-- Recent Orders -->
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="datatable table table-hover table-center mb-0">
                            <thead>
                            <tr>
                                <th>Doctor Name</th>
                                <th>Speciality</th>
                                <th>Patient Name</th>
                                <th>Apointment Time</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                            @foreach($appointments as $appointment)
                                <tr>
                                    <!-- Doctor Details -->
                                    <td>
                                        <h2 class="table-avatar">
                                            <a href="" class="avatar avatar-sm mr-2">
                                                <img class="avatar-img rounded-circle"
                                                     src="{{ asset('backend') }}/{{ $appointment->doctor->profile->image ?? 'default-avatar.png' }}"
                                                     alt="Doctor Image">
                                            </a>
                                            <a href="">{{ $appointment->doctor->first_name ?? 'N/A' }} {{ $appointment->doctor->last_name ?? 'N/A' }}</a>
                                        </h2>
                                    </td>

                                    <td>{{ $appointment->doctor->profile->speciality->name ?? 'No Speciality' }}</td>
                                    <!-- Patient Details -->
                                    <td>
                                        <h2 class="table-avatar">
                                            <a href="profile.html" class="avatar avatar-sm mr-2">
                                                <img class="avatar-img rounded-circle"
                                                     src="{{ asset('backend') }}/{{ $appointment->patient->profile->image ?? 'default-avatar.png' }}"
                                                     alt="Patient Image">
                                            </a>
                                            <a href="profile.html">{{ $appointment->patient->first_name ?? 'N/A' }} {{ $appointment->patient->last_name ?? '' }}</a>
                                        </h2>
                                    </td>
                                    <!-- Appointment Date and Time -->
                                    <td>
                                        {{-- Get today's date and the current weekday --}}
                                        @php
                                            $today = \Carbon\Carbon::now(); // Today's date
                                            $todayWeekday = $today->format('l'); // Today's full weekday name (e.g., "Wednesday")

                                            // Day of the week from the appointment, e.g., "Friday"
                                            $appointmentDay = $appointment->day; // Appointment day from DB (e.g., "Friday")

                                            // Get the numeric representation of today's weekday and appointment weekday (0 = Sunday, 1 = Monday, etc.)
                                            $todayDayNumber = $today->dayOfWeek; // Sunday = 0, Monday = 1, ..., Saturday = 6
                                            $appointmentDayNumber = \Carbon\Carbon::parse($appointmentDay)->dayOfWeek;

                                            // Calculate the difference in days between today and the appointment day
                                            $diffDays = $appointmentDayNumber - $todayDayNumber;

                                            // If the appointment day has already passed this week, calculate the next week's appointment date
                                            if ($diffDays <= 0) {
                                                $diffDays += 7; // Move to the next week's same day
                                            }

                                            // Calculate the next occurrence of the appointment day
                                            $nextAppointmentDate = $today->addDays($diffDays)->format('M d, Y');
                                        @endphp

                                        {{-- Display the next appointment date --}}
                                        {{ $nextAppointmentDate }}

                                        <span class="text-primary d-block">
                                            {{ \Carbon\Carbon::parse($appointment->start_time)->format('h:i A') }} -
                                            {{ \Carbon\Carbon::parse($appointment->end_time)->format('h:i A') }}
                                        </span>
                                    </td>

                                    <td>

                                        <div class="status-toggle">
                                            @if($appointment->status == 'booked')
                                                <!-- If status is 'booked', only display the 'Booked' label with yellow badge -->
                                                <label class=" yellow-status">
                                                    Booked
                                                </label>
                                            @else
                                                <!-- If status is not 'booked', show checkbox with appropriate label -->
                                                <input type="checkbox"
                                                       id="status_{{ $appointment->id }}"
                                                       class="check"
                                                       data-appointment-id="{{ $appointment->id }}"
                                                    {{ $appointment->status == 'approved' ? 'checked' : '' }}>

                                                <label for="status_{{ $appointment->id }}"
                                                       class="checktoggle
                                                       {{ $appointment->status == 'approved' ? 'green-status' : '' }}
                                                       {{ $appointment->status == 'pending' ? 'red-status' : '' }}">
                                                    @if($appointment->status == 'approved')
                                                        Approved
                                                    @elseif($appointment->status == 'pending')
                                                        Pending
                                                    @else
                                                        Unknown
                                                    @endif
                                                </label>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach

                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /Recent Orders -->

        </div>
    </div>
@endsection
@push('js')
    <script>
        // Event listener for status toggle
        document.querySelectorAll('.check').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                const appointmentId = this.getAttribute('data-appointment-id');
                const status = this.checked ? 'approved' : 'pending';  // Assume toggling between 'booked' and 'pending'

                // Send AJAX request to update status in the backend
                fetch('/update-appointment-status', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'  // CSRF token for security
                    },
                    body: JSON.stringify({
                        appointment_id: appointmentId,
                        status: status
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        // Handle success or error
                        if (data.success) {
                            console.log('Status updated successfully');
                            // Optionally update the label or class dynamically
                        } else {
                            console.error('Error updating status');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });
        });
    </script>
@endpush
