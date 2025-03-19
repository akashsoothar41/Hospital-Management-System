@extends('backend.doctor.layouts.master')
@push('css')
    <style>
        .bootstrap-tagsinput{
            width: 100% !important;
            display: block !important;
        }
    </style>
@endpush
@section('content')
    <div class="col-xl-12 d-flex">
        <div class="card flex-fill">
            <div class="card-header">
                <h4 class="card-title">Update Blog</h4>
            </div>
                <div class="card-body">
                    <form id="postForm" action="{{ url('blogs/' . $blog->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Category Field -->
                        <div class="form-group">
                            <label class="control-label">Speciality</label>
                            <select class="form-control" name="speciality_id" required>
                                <option value="">Select Speciality</option>
                                @foreach($specialities as $speciality)
                                    <option value="{{ $speciality->id }}" {{ $speciality->id == $blog->speciality_id ? 'selected' : '' }}>
                                        {{ $speciality->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Title Field -->
                        <div class="form-group">
                            <label class="control-label">Title</label>
                            <input class="form-control" type="text" name="title" value="{{ $blog->title }}" placeholder="Enter title" required>
                        </div>

                        <!-- Description Field -->
                        <div class="form-group">
                            <label class="control-label">Description</label>
                            <textarea class="form-control" id="summernote" name="description" rows="4" placeholder="Enter description" required>{{ $blog->description }}</textarea>
                        </div>

                        <!-- Attachment Field -->
                        <div class="form-group">
                            <label class="control-label">Attachment</label>
                            <div class="row">
                                <div class="col-md-11">
                                    <input class="form-control" type="file" name="attachment[]" multiple>
                                </div>
                                <div class="col-md-1">
                                    <button style="background-color: #0dd9f9" class="btn btn-sm btn-info add_attachment"><span class="fa fa-plus"></span></button>
                                </div>
                            </div>
                        </div>

                        <!-- Display Existing Attachments with Previews -->
                        @if($blog->attachments->isNotEmpty())
                            <div class="form-group">
                                <label>Existing Attachments:</label>
                                <div class="row">
                                    @foreach($blog->attachments as $attachment)
                                        @php
                                            // Get the file extension and path
                                            $extension = pathinfo($attachment->file, PATHINFO_EXTENSION);
                                            $attachmentPath = asset('backend/' . $attachment->file);
                                        @endphp

                                        <div class="col-md-3 text-center mb-3">
                                            @if(in_array($extension, ['jpg', 'jpeg', 'png', 'gif']))
                                                <!-- Image preview -->
                                                <img src="{{ $attachmentPath }}" alt="Attachment Image" style="max-width: 100%; height: 100px;">
                                            @elseif(in_array($extension, ['pdf']))
                                                <!-- PDF preview using embedded viewer -->
                                                <iframe src="{{ $attachmentPath }}" width="100%" height="100px"></iframe>
                                            @else
                                                <!-- Document icon for other file types -->
                                                <a href="{{ $attachmentPath }}" target="_blank">
                                                    <img src="{{ asset('path/to/icons/document-icon.png') }}" alt="Document Icon" style="max-width: 50px; height: auto;">
                                                    <div>{{ $attachment->file }}</div>
                                                </a>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Tag Field -->
                        <div class="form-group">
                            <label class="control-label">Tags</label>
                            <input class="form-control" type="text" name="tags" value="{{ $tags }}" data-role="tagsinput" placeholder="Enter tags comma-separated" required>
                        </div>

                        <!-- Status Field -->
                        <div class="form-group">
                            <label class="control-label">Status</label>
                            <select class="form-control" name="status" required>
                                <option value="" disabled>Select status</option>
                                <option value="1" {{ $blog->status == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $blog->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group">
                            <button style="background-color: #0dd9f9"  type="submit" class="btn">Update</button>
                        </div>
                    </form>
                </div>
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
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-lite.min.js"></script>

<!-- Bootstrap Tags Input CSS and JS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        // Initialize Summernote
        $('#summernote').summernote({
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
                        <input class="form-control" type="file" name="attachment[]" required>
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
