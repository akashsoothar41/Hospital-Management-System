@extends('backend.patient.layouts.master')
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
                                        @php
                                            $today = \Carbon\Carbon::now();
                                            $todayWeekday = $today->format('l');
                                            $appointmentDay = $appointment->day;
                                            $todayDayNumber = $today->dayOfWeek;
                                            $appointmentDayNumber = \Carbon\Carbon::parse($appointmentDay)->dayOfWeek;
                                            $diffDays = $appointmentDayNumber - $todayDayNumber;
                                            if ($diffDays <= 0) {
                                                $diffDays += 7;
                                            }
                                            $nextAppointmentDate = $today->addDays($diffDays)->format('M d, Y');
                                        @endphp
                                        {{ $nextAppointmentDate }}
                                        <span class="text-primary d-block">
                                            {{ \Carbon\Carbon::parse($appointment->start_time)->format('h:i A') }} -
                                            {{ \Carbon\Carbon::parse($appointment->end_time)->format('h:i A') }}
                                        </span>
                                    </td>

                                    <td>
                                        @if ($appointment->status == 'booked')
                                            <span class="badge bg-success">Booked</span>
                                        @elseif ($appointment->status == 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif ($appointment->status == 'approved')
                                            <span class="badge">
                                            <!-- Pay Now Button -->
                                            <a class="btn btn-link" style="background-color: #00d0f1; color: white;" href="{{ route('create-payment-intent', ['doctor_fees' => $appointment->doctor->profile->fees, 'appointment_id' => $appointment->id]) }}">Pay Now</a>
                                        </span>
                                        @else
                                            <span class="badge bg-secondary">Unknown</span>
                                        @endif
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
