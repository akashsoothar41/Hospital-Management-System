@extends('backend.doctor.layouts.master')
@push('css')
    <!-- Datatables CSS -->
    <link rel="stylesheet" href="{{asset('backend')}}/plugins/datatables/datatables.min.css">
@endpush
@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">List of Patient</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="">Dashboard</a></li>
                    <li class="breadcrumb-item active">Patient</li>
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
                        <div class="table-responsive">
                            <table class="datatable table table-hover table-center mb-0">
                                <thead>
                                <tr>
                                    <th>Patient ID</th>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>Phone</th>
                                    <th>Age</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                @foreach($appointments as $appointment)
                                    <tr>
                                        <!-- Patient ID -->
                                        <td>#PT0{{ $appointment->patient->id }}</td>

                                        <!-- Patient Name with Avatar -->
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="profile.html" class="avatar avatar-sm mr-2">
                                                    <img class="avatar-img rounded-circle" src="{{ asset('backend') }}/{{ $appointment->patient->profile->image ?? '' }}" alt="User Image">
                                                </a>
                                                <a href="profile.html">{{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}</a>
                                            </h2>
                                        </td>

                                        <!-- Address -->
                                        <td>{{ $appointment->patient->profile->address ?? 'N/A' }}</td>

                                        <!-- Phone Number -->
                                        <td>{{ $appointment->patient->profile->phone_number ?? 'N/A' }}</td>

                                        <!-- Age (calculated based on the 'dob' in the profile) -->
                                        <td>{{$appointment->patient->profile->age ?? 'N/A' }}</td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <!-- Datatables JS -->
    <script src="{{asset('backend')}}/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{asset('backend')}}/plugins/datatables/datatables.min.js"></script>
@endpush
