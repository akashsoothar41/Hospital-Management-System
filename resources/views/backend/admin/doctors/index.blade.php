@extends('backend.admin.layouts.master')
@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Doctor's List</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('doctors')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Doctor</li>
                    <li class="breadcrumb-item active"><a href="{{url('doctors/create')}}">Create</a></li>
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
                                <th>Name</th>
                                <th>Speciality</th>
                                <th>Member Since</th>
                                <th>Fees</th>
                                <th>Account Status</th>

                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                @foreach($doctors as $index => $doctor)
                                <tr>
                                    <td>
                                        <h2 class="table-avatar">
                                            <a href="" class="avatar avatar-sm mr-2">
                                                <img class="avatar-img rounded-circle" src="{{asset('backend')}}/{{$doctor->profile->image ?? ''}}" alt="User Image">
                                            </a>
                                            <a href="">{{$doctor->first_name}}  {{$doctor->last_name}}</a>
                                        </h2>
                                    </td>

                                    <td>{{$doctor->profile->speciality->name ?? ''}}</td>

                                    <td>
                                        {{$doctor->created_at->format('M d, Y')}} <br>
                                        <small>{{ $doctor->created_at->format('H:i') }}</small>
                                    </td>

                                    <td>{{$doctor->profile->fees ?? ''}}</td>

                                    <td>
                                        <div class="status-toggle">
                                            <input type="checkbox" id="status_{{ $doctor->id }}" class="check" data-doctor-id="{{ $doctor->id }}" {{ $doctor->status ? 'checked' : '' }}>
                                            <label for="status_{{ $doctor->id }}" class="checktoggle">checkbox</label>
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
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            // When the checkbox is toggled
            $('.status-toggle input').change(function() {
                var doctorId = $(this).data('doctor-id'); // Get the doctor ID
                var status = $(this).prop('checked') ? 1 : 0; // Determine new status (1 for checked, 0 for unchecked)

                // Send AJAX request to update the status in the database
                $.ajax({
                    url: '/update-doctor-status', // Define your route
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}', // Add CSRF token for security
                        doctor_id: doctorId,
                        status: status
                    },
                    success: function(response) {
                        console.log("Response: ", response); // Debugging response
                        if (response.msg) {
                            Swal.fire({
                                icon: "{{Session::get('type')}}",
                                title: "{{Session::get('title')}}",
                                text: "{{Session::get('msg')}}",
                                showConfirmButton: false,
                                timer: 5000
                            });


                        }
                    },
                    error: function(response) {
                        // Handle errors (e.g., show an error notification)
                        console.log(response.msg);
                    }
                });
            });
        });
    </script>
@endpush
