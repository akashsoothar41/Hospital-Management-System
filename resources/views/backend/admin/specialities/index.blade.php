@extends('backend.admin.layouts.master')
@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-7 col-auto">
                <h3 class="page-title">Specialties</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('admin') }}">Dashboard</a></li>
                    <li class="breadcrumb-item ">Specialties/</li>
                    <li>
                        <a class="breadcrumb-item" href="#add_Specialties" data-toggle="modal">  Add Specialty</a>
                    </li>
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
                                <th>#</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th class="text-right">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($specialities as $index => $speciality)
                                <tr>
                                    <td>{{++$index}}</td>
                                    <td>
                                        <h2 class="table-avatar">
                                            <a href="profile.html" class="avatar avatar-sm mr-2">
                                                <img class="avatar-img" src="{{ asset('backend') }}/{{$speciality->image}}" alt="Specialty">
                                            </a>
                                            <a href="profile.html">{{$speciality->name}}</a>
                                        </h2>
                                    </td>
                                    <td>
                                        <div class="status-toggle">
                                            <input type="checkbox" id="status_{{ $speciality->id }}" class="check" data-speciality-id="{{ $speciality->id }}" {{ $speciality->status ? 'checked' : '' }}>
                                            <label for="status_{{ $speciality->id }}" class="checktoggle"></label>
                                        </div>
                                    </td>

                                    <td class="text-right">
                                        <div class="actions">
                                            <!-- Edit Button -->
{{--                                            <a href="#" class="btn btn-primary shadow btn-xs sharp me-1" data-bs-toggle="modal" data-target=".edit_specialties_details" data-id="{{$speciality->id}}" aria-label="Edit Speciality">--}}
{{--                                                <i class="fa fa-pencil"></i>--}}
{{--                                            </a>--}}

                                            <button class="btn btn-primary shadow btn-xs sharp me-1 edit_specialtity" data-id="{{$speciality->id??''}}">
                                                <i class="fa fa-pencil"></i>
                                            </button>
                                            <!-- Form for Deleting Speciality -->
                                            <form class="deleteForm" style="display:inline" action="{{ route('specialities.destroy', [$speciality->id]) }}" method="POST">
                                                {{ csrf_field() }}
                                                @method('DELETE')
                                                <button type="button" onclick="confirmDelete(this)" class="btn btn-danger shadow btn-xs sharp me-1">
                                                    <i class="fe fe-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>

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

    <!-- Add Specialty Modal -->
    <div class="modal fade" id="add_Specialties" aria-hidden="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Specialty</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('specialities') }}" method="POST" enctype="multipart/form-data" id="specialtyForm">
                        @csrf
                        <div class="row form-row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Specialty</label>
                                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
                                    @error('name')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Image</label>
                                    <input type="file" name="image" id="image" class="form-control">
                                    @error('image')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control" name="status" id="status">
                                        <option value="" {{ old('status') == null ? 'selected' : '' }}>--Select Status--</option>
                                        <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Inactive</option>
                                    </select>

                                    @error('status')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add Specialty Modal -->

    <!-- Edit Specialty Details Modal -->
    <div class="modal edit_specialties_details" id="edit_specialties_details" aria-hidden="true" role="dialog">
    </div>
    <!-- /Edit Specialty Details Modal -->

@endsection

@push('js')
    <script>
        $(document).on('click', '.edit_specialtity', function() {
            var specialityId = $(this).attr('data-id');
            if(specialityId){
                $.ajax({
                    url: '/specialities/' + specialityId + '/edit',
                    method: 'GET',
                    success: function(data) {
                        $('.edit_specialties_details').html(data);
                        $('.edit_specialties_details').modal('show');
                    },
                    error: function(){
                        alert('Error retrieving specialty data');
                    }
                });
            }
        });

        // Reset Add Modal on Close
        $('#add_Specialties').on('hidden.bs.modal', function () {
            $('#name').val('');
            $('#image').val('');
            $('#status').val('1');
        });

        // Reset Edit Modal on Close
        $('#edit_specialties_details').on('hidden.bs.modal', function () {
            $('#edit_name').val('');
            $('#edit_image').val('');
            $('#edit_status').val('1');
            $('#edit_image_preview').hide();
        });

        $(document).ready(function() {
            // When the checkbox is toggled
            $('.status-toggle input').change(function() {
                var specialityId = $(this).data('speciality-id'); // Get the speciality ID (not doctorId, since you're dealing with specialities)
                var status = $(this).prop('checked') ? 1 : 0; // Determine new status (1 for checked, 0 for unchecked)

                // Send AJAX request to update the status in the database
                $.ajax({
                    url: '/update-speciality-status/' + specialityId, // Dynamically insert the speciality ID into the URL
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}', // CSRF token for security
                        status: status // Send the new status
                    },
                    success: function(response) {
                        // You can handle success (e.g., show a notification or update the UI)
                        if(response.success) {
                            console.log(response.msg); // Optionally display success message
                        } else {
                            console.log('Error: ' + response.msg); // Handle any errors sent from the server
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle any errors during the AJAX request
                        console.error('Request failed: ' + error);
                    }
                });
            });
        });




        // SweetAlert2 confirmation for delete action
        function confirmDelete(current) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Cancel',
                confirmButtonText: 'Yes, delete it!',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $(current).closest('form').submit();
                }
            });
        }



        $(document).ready(function() {
            // Apply validation to the form
            $("#specialtyForm").validate({
                rules: {
                    name: {
                        required: true,
                    },
                    image: {
                        required:true,
                    },
                    status: {
                        required: true // Ensure the status is selected
                    }
                },
                messages: {
                    name: {
                        required: "Please enter a category name",
                    },
                    image: {
                        required: "Please select the image",
                    },
                    status: {
                        required: "Please select a status"
                    }
                },
                submitHandler: function(form) {
                    form.submit(); // Proceed with the form submission if valid
                }
            });
        });
    </script>
@endpush
