@extends('backend.doctor.layouts.master')
@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="row">
        <div class="col-sm-12">
            <h3 class="page-title">Blog's List</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('doctors')}}">Dashboard</a></li>
                <li class="breadcrumb-item active">Blog</li>
                <li class="breadcrumb-item active"><a href="{{url('blogs/create')}}">Create</a></li>
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
                            <th>Title</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                        @foreach($blogs as $index => $blog)
                            <tr>
                                <td>{{$blog->doctor->first_name ?? ''}} {{$blog->doctor->last_name ?? ''}}</td>

                                <td>{{$blog->speciality->name ?? ''}} </td>
                                <td>{{$blog->title ?? ''}}</td>

                                <td>
                                    <div class="status-toggle">
                                        <input type="checkbox" id="status_{{ $blog->id }}" class="check" data-blog-id="{{ $blog->id }}" {{ $blog->status ? 'checked' : '' }}>
                                        <label for="status_{{ $blog->id }}" class="checktoggle">checkbox</label>
                                    </div>
                                </td>

                                <td>
                                    <div class="actions">
                                        <a class="btn btn-success shadow btn-xs sharp me-1 " href="{{route('blogs.show', [$blog->id])}}">
                                            <i class="fa fa-eye"></i>
                                        </a>

                                        <a class="btn btn-primary shadow btn-xs sharp me-1 " href="{{route('blogs.edit', [$blog->id])}}">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <!-- Form for Deleting Speciality -->
                                        <form class="deleteForm" style="display:inline" action="{{ route('blogs.destroy', [$blog->id]) }}" method="POST">
                                            {{ csrf_field() }}
                                            @method('DELETE')
                                            <button type="button" onclick="confirmDelete(this)" class="btn btn-danger shadow btn-xs sharp me-1">
                                                <i class="fe fe-trash"></i>
                                            </button>
                                        </form>
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

        $(document).on('change', '.status-toggle input', function() {
            var blogId = $(this).data('blog-id');
            var status = $(this).prop('checked') ? 1 : 0;

            console.log("Blog ID: " + blogId + " Status: " + status); // Check if event fires

            $.ajax({
                url: "{{url('update-blog-status')}}",
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    blog_id: blogId,
                    status: status
                },
                success: function(response) {
                    console.log("Response: ", response); // Debugging response
                    if (response.msg) {
                        Swal.fire({
                            icon: 'success', // You can use 'success', 'error', 'warning', etc.
                            title: 'Success!',
                            text: response.msg,  // The message from the server
                            confirmButtonText: 'Okay'
                        });
                    }
                },
                error: function(response) {
                    console.log("Error: ", response); // Check for AJAX errors
                }
            });
        });


    </script>
@endpush
