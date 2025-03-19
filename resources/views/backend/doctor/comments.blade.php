@extends('backend.doctor.layouts.master')
@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Comments</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('doctors')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Comments</li>
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
                                <th>Commented By </th>
                                <th>Message</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th class="text-right">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($comments as $comment)
                                <tr>
                                    <!-- Patient Information -->
                                    <td>
                                        <h2 class="table-avatar">
                                            <!-- Dynamically populate the patient's profile picture and name -->
                                            <a href="" class="avatar avatar-sm mr-2">
                                                <img class="avatar-img rounded-circle" src="{{ asset('backend/'.$comment->user->profile->image) }}" alt="Patient Image">
                                            </a>
                                            <a href="">
                                                    {{ $comment->user->first_name }} {{ $comment->user->last_name }}  <!-- Otherwise, show the patient's full name -->
                                            </a>
                                        </h2>
                                    </td>

                                    <!-- Description -->
                                    <td>
                                        {{ Str::limit($comment->message, 40, ' [Read more]') }}
                                    </td>


                                    <!-- Date and Time -->
                                    <td>
                                        {{ \Carbon\Carbon::parse($comment->created_at)->format('d M Y') }} <br>
                                        <small>{{ \Carbon\Carbon::parse($comment->created_at)->format('h:i A') }}</small>
                                    </td>

                                    <td>
                                        <div class="status-toggle">
                                            <input type="checkbox" id="status_{{ $comment->id }}" class="check" data-comment-id="{{ $comment->id }}" {{ $comment->status ? 'checked' : '' }}>
                                            <label for="status_{{ $comment->id }}" class="checktoggle">checkbox</label>
                                        </div>
                                    </td>

                                    <!-- Actions (Delete) -->
                                    <td class="text-right">
                                        <div class="actions">
                                            <!-- Delete action with dynamic confirmation -->
                                            <a class="btn btn-sm bg-danger-light" href="javascript:void(0);" onclick="confirmDelete(this)">
                                                <i class="fe fe-trash"></i> Delete
                                            </a>
                                            <!-- Hidden Delete Form (only submits on confirmation) -->
                                            <form action="{{ route('delete_comment', $comment->id) }}" method="POST" style="display:none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
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
                    // Find the form associated with the delete button and submit it
                    $(current).closest('div.actions').find('form').submit();
                }
            });
        }

        $(document).on('change', '.status-toggle input', function() {
            var commentId = $(this).data('comment-id');
            var status = $(this).prop('checked') ? 1 : 0;

            console.log("Comment ID: " + commentId + " Status: " + status);

            $.ajax({
                url: '/update-comment-status',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    comment_id: commentId,
                    status: status
                },
                success: function(response) {
                    console.log(response);
                    if(response.msg) {
                        // Use SweetAlert to show the success message
                        Swal.fire({
                            icon: 'success', // You can use 'success', 'error', 'warning', etc.
                            title: 'Success!',
                            text: response.msg,  // The message from the server
                            confirmButtonText: 'Okay'
                        });
                    }
                },
                error: function(response) {
                    console.log(response);
                    // Optionally, you can add an error alert here using SweetAlert
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!',
                        confirmButtonText: 'Try Again'
                    });
                }
            });
        });



    </script>

@endpush
