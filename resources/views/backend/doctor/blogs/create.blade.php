@extends('backend.doctor.layouts.master')
@push('css')
    <style>
        .bootstrap-tagsinput{
            width: 100% !important;
            display: block !important;
        }
    </style>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-lite.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css">
@endpush
@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="row">
        <div class="col-sm-12">
            <h3 class="page-title">Add Blog</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('doctors')}}">Dashboard</a></li>
                <li class="breadcrumb-item active">blog</li>
                <li class="breadcrumb-item active">Create</li>
            </ul>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body mt-2">
                <form id="postForm" action="{{ url('blogs') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- Category Field -->
                    <div class="form-group">
                        <label class="control-label">Speciality</label>
                        <select class="form-control" name="speciality_id" required>
                            <option value="">Select Speciality</option>
                            @foreach($specialities as $speciality)
                                <option value="{{ $speciality->id }}">{{ $speciality->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Title Field -->
                    <div class="form-group">
                        <label class="control-label">Title</label>
                        <input class="form-control" type="text" name="title" placeholder="Enter title" required>
                    </div>

                    <!-- Description Field -->
                    <div class="form-group">
                        <label class="control-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter description" required></textarea>
                    </div>

                    <!-- Attachment Field -->
                    <div class="form-group">
                        <label class="control-label">Attachment</label>
                        <div class="row">
                            <div class="col-md-11">
                                <input class="form-control" type="file" name="attachments[]" required>
                            </div>
                            <div class="col-md-1">
                                <button style="background-color: #0dd9f9" class="btn btn-sm btn-info add_attachment"><span class="fa fa-plus"></span></button>
                            </div>
                        </div>
                    </div>

                    <!-- Tag Field -->
                    <div class="form-group">
                        <label class="control-label">Tags</label>
                        <input class="form-control" type="text" name="tags" placeholder="Enter tags comma-separated" data-role="tagsinput" required>
                    </div>

                    <!-- Status Field -->
                    <div class="form-group">
                        <label class="control-label">Status</label>
                        <select class="form-control" name="status" required>
                            <option value="" disabled selected>Select status</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                    <!-- Submit Button -->
                    <div class="form-group">
                        <button style="background-color: #0dd9f9" type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('css')
<style>
    /* Customize tag colors */
    .bootstrap-tagsinput .tag {
        background-color: #0dd9f9; /* Set your desired background color */
        color: #fff; /* Text color */
        padding: 5px;
        border-radius: 3px;
    }

    /* Customize the close (X) button color */
    .bootstrap-tagsinput .tag [data-role="remove"] {
        color: #fff; /* Color of the "X" for removal */
        opacity: 0.7;
    }
    .bootstrap-tagsinput .tag [data-role="remove"]:hover {
        opacity: 1;
    }
</style>
@endpush
@push('js')
<!-- Summernote CSS and JS -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-lite.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#description').summernote({
            placeholder: 'Type your content here...',
            tabsize: 2,
            height: 300,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });

        // Add new attachment input
        $(".add_attachment").click(function(e) {
            e.preventDefault();
            let attachmentHtml = `
                <div class="row attachment-row">
                    <div class="col-md-11">
                        <input class="form-control" type="file" name="attachments[]" required>
                    </div>
                    <div class="col-md-1">
                        <button class="btn btn-sm btn-danger remove_attachment"><span class="fa fa-minus"></span></button>
                    </div>
                </div>
            `;
            $(this).closest(".form-group").append(attachmentHtml);
        });

        // Remove attachment input
        $(document).on("click", ".remove_attachment", function(e) {
            e.preventDefault();
            $(this).closest(".attachment-row").remove();
        });
    });
</script>
@endpush
