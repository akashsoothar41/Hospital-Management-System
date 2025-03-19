@extends('backend.doctor.layouts.master')
@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <style>
        .certificate-preview {
            margin-top: 10px;
        }

        .certificate-preview-image {
            margin-right: 10px;
            border: 1px solid #ddd;
            padding: 5px;
            max-width: 100px;
            max-height: 100px;
        }

    </style>
@endpush
@section('content')
    <div class="col-xl-12 d-flex">
        <div class="card flex-fill">
            <div class="card-header">
                <h4 class="card-title">Update Profile</h4>
            </div>
            <div class="card-body">
                <form id="myForm" action="{{route('update_profile')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- Personal Information Section -->
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5>Personal Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group row mb-3">
                                        <label class="col-lg-4 col-form-label">First Name</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" value="{{ old('first_name', $user->first_name) }}" name="first_name" id="first_name">
                                        </div>
                                        @error('first_name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label class="col-lg-4 col-form-label">Last Name</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" value="{{ old('last_name', $user->last_name) }}" name="last_name" id="last_name">
                                        </div>
                                        @error('last_name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label class="col-lg-4 col-form-label">Age</label>
                                        <div class="col-lg-8">
                                            <input type="number" class="form-control" value="{{ old('age', $user->profile->age) }}" name="age" id="age">
                                        </div>
                                        @error('age')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group row mb-3">
                                        <label for="speciality_id" class="col-lg-4 col-form-label">Specialty</label>
                                        <div class="col-lg-8">
                                            <select class="form-control" name="speciality_id" id="speciality_id">
                                                <option value="">Select Specialty</option>
                                                @foreach($specialties as $specialty) <!-- Loop through the specialties passed from the controller -->
                                                <option value="{{ $specialty->id }}"
                                                        @if(auth()->user()->profile && auth()->user()->profile->speciality_id == $specialty->id) selected @endif>
                                                    {{ $specialty->name }}
                                                </option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-3">
                                        <label class="col-lg-4 col-form-label">Date of Birth</label>
                                        <div class="col-lg-8">
                                            <input type="date" class="form-control" value="{{ old('date_of_birth', $user->profile->date_of_birth) }}" name="date_of_birth" id="date_of_birth">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label class="col-lg-4 col-form-label">Gender</label>
                                        <div class="col-lg-8">
                                            <select class="form-control" name="gender" id="gender">
                                                <option value="male" {{ $user->profile->gender == 'male' ? 'selected' : '' }}>Male</option>
                                                <option value="female" {{ $user->profile->gender == 'female' ? 'selected' : '' }}>Female</option>
                                                <option value="other" {{ $user->profile->gender == 'other' ? 'selected' : '' }}>Other</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information Section -->
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5>Contact Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group row mb-3">
                                        <label class="col-lg-4 col-form-label">Phone Number</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" value="{{ old('phone_number', $user->profile->phone_number) }}" name="phone_number" id="phone_number">
                                        </div>
                                    </div>
                                    @error('phone_number')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group row mb-3">
                                        <label class="col-lg-4 col-form-label">Email Address</label>
                                        <div class="col-lg-8">
                                            <input type="email" class="form-control" value="{{ old('email', $user->email) }}" name="email" id="email">
                                        </div>
                                        @error('email')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group row mb-3">
                                        <label class="col-lg-4 col-form-label">Address</label>
                                        <div class="col-lg-8">
                                            <textarea class="form-control" name="address" id="address">{{ old('address', $user->profile->address) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group row mb-3">
                                        <label class="col-lg-4 col-form-label">Emergency Contact</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" value="{{ old('emergency_contact', $user->profile->emergency_contact) }}" name="emergency_contact" id="emergency_contact">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Information Section -->
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5>Additional Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group row mb-3">
                                        <label class="col-lg-4 col-form-label">About</label>
                                        <div class="col-lg-8">
                                            <textarea class="form-control" name="about" id="about">{{ old('about', $user->profile->about) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group row mb-3">
                                        <label class="col-lg-4 col-form-label">Profile Image</label>
                                        <div class="col-lg-8">
                                            <!-- Input for file upload -->
                                            <div class="form-group">
                                                <input type="file" class="form-control" name="image" id="image" onchange="previewImage(event)">
                                            </div>

                                            <!-- Display the existing image or a placeholder if not present -->
                                            <div class="form-group">
                                                <label for="preview">Current Profile Image</label>
                                                <div id="image-container">
                                                    @if($user->profile->image) <!-- Check if user has an existing profile image -->
                                                    <img id="preview" src="{{ asset('backend')}}/{{$user->profile->image}}" alt="Profile Image" style="max-width: 40%; height: auto;">
                                                    @else
                                                        <img id="preview" src="https://via.placeholder.com/150" alt="No image" style="max-width: 100%; height: auto;">
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group row mb-3">
                                        <label class="col-lg-4 col-form-label">Password</label>
                                        <div class="col-lg-8">
                                            <!-- Password field for updating password -->
                                            <input type="password" class="form-control" name="password" id="password" placeholder="Enter new password">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group row mb-3">
                                        <label class="col-lg-4 col-form-label">Fees</label>
                                        <div class="col-lg-8">
                                            <input type="number" class="form-control" value="{{ old('fees', $user->profile->fees) }}" name="fees" id="fees">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="card mb-3">
                        <div class="card-header">
                            <h5>Working Hours</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Start Time Input -->
                                <div class="col-lg-6">
                                    <div class="form-group row mb-3">
                                        <label class="col-lg-4 col-form-label">Start Time</label>
                                        <div class="col-lg-8">
                                            <!-- Use old() for previously entered value or the database value if no old input is available -->
                                            <input type="time" class="form-control" value="{{ old('work_start_time', $user->profile->start_time ?? '') }}" name="work_start_time" id="work_start_time">

                                        </div>
                                    </div>
                                </div>

                                <!-- End Time Input -->
                                <div class="col-lg-6">
                                    <div class="form-group row mb-3">
                                        <label class="col-lg-4 col-form-label">End Time</label>
                                        <div class="col-lg-8">
                                            <!-- Use old() for previously entered value or the database value if no old input is available -->
                                            <input type="time" class="form-control" value="{{ old('work_end_time', $user->profile->end_time ?? '') }}" name="work_end_time" id="work_end_time">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="card mb-3">
                        <div class="card-header">
                            <h5>Experience</h5>
                        </div>
                        <div class="card-body" id="experience-container">
                            <div id="experience-fields">
                                <!-- Iterate over the experiences passed from the controller -->
                                @foreach ($user->experiences as $index => $experience)
                                    <div class="card mb-3" id="experience-entry-{{ $index }}">
                                        <div class="card-header">
                                            <h6>Experience Entry #{{ $index + 1 }}</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group row mb-3">
                                                <label class="col-lg-2 col-form-label">Hospital Name</label>
                                                <div class="col-lg-4">
                                                    <input type="text" class="form-control" name="hospital_name[]" id="hospital_name_{{ $index }}"
                                                           value="{{ old('hospital_name.' . $index, $experience->hospital_name) }}">
                                                </div>
                                                <label class="col-lg-2 col-form-label">Position</label>
                                                <div class="col-lg-4">
                                                    <input type="text" class="form-control" name="position[]" id="position_{{ $index }}"
                                                           value="{{ old('position.' . $index, $experience->position) }}">
                                                </div>
                                            </div>
                                            <div class="form-group row mb-3">
                                                <label class="col-lg-2 col-form-label">Start Date</label>
                                                <div class="col-lg-4">
                                                    <input type="date" class="form-control" name="start_date[]" id="start_date_{{ $index }}"
                                                           value="{{ old('start_date.' . $index, $experience->start_date) }}">
                                                </div>
                                                <label class="col-lg-2 col-form-label">End Date</label>
                                                <div class="col-lg-4">
                                                    <input type="date" class="form-control" name="end_date[]" id="end_date_{{ $index }}"
                                                           value="{{ old('end_date.' . $index, $experience->end_date) }}">
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-danger close-experience">
                                                <i class="fas fa-close"></i> Remove
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <button type="button" id="add-experience" class="btn btn-info mb-3">
                                <i class="fas fa-plus"></i> Add Experience
                            </button>
                        </div>
                    </div>


                    <div class="card mb-3">
                        <div class="card-header">
                            <h5>Education</h5>
                        </div>
                        <div class="card-body" id="education-container">
                            <div id="education-fields">
                                <!-- Iterate over existing education records -->
                                @foreach ($user->educations as $index => $education)
                                    <div class="card mb-3">
                                        <div class="card-header">
                                            <h6>Education Entry #{{ $index + 1 }}</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group row mb-3">
                                                <label class="col-lg-2 col-form-label">University</label>
                                                <div class="col-lg-4">
                                                    <input type="text" class="form-control" name="university[{{ $index }}]"
                                                           value="{{ old('university.' . $index, $education->university) }}">
                                                </div>
                                                <label class="col-lg-2 col-form-label">Field of Study</label>
                                                <div class="col-lg-4">
                                                    <input type="text" class="form-control" name="field[{{ $index }}]"
                                                           value="{{ old('field.' . $index, $education->field) }}">
                                                </div>
                                            </div>
                                            <div class="form-group row mb-3">
                                                <label class="col-lg-2 col-form-label">Start Date</label>
                                                <div class="col-lg-4">
                                                    <input type="date" class="form-control" name="university_start_date[{{ $index }}]"
                                                           value="{{ old('university_start_date.' . $index, $education->university_start_date) }}">
                                                </div>
                                                <label class="col-lg-2 col-form-label">End Date</label>
                                                <div class="col-lg-4">
                                                    <input type="date" class="form-control" name="university_end_date[{{ $index }}]"
                                                           value="{{ old('university_end_date.' . $index, $education->university_end_date) }}">
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-danger close-education">
                                                <i class="fas fa-close"></i> Remove
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Button to dynamically add new education entries -->
                            <button type="button" id="add-education" class="btn btn-info mb-3">
                                <i class="fas fa-plus"></i> Add Education
                            </button>
                        </div>
                    </div>
                        <div class="card mb-3">
                            <div class="card-header">
                                <h5> Attachments</h5>
                            </div>
                            <div class="card-body" id="education-container">
                                <!-- Attachment Field -->
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-11">
                                            <input class="form-control" type="file" name="attachments[]" required>
                                        </div>
                                        <div class="col-md-1">
                                            <button class="btn btn-sm btn-info add_attachment"><span class="fa fa-plus"></span></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Save Profile</button>

                </form>
            </div>
        </div>
    </div>


@endsection
@push('js')
    <script>

        document.addEventListener('DOMContentLoaded', function() {
            // Function to add a new education entry
            document.getElementById('add-education').addEventListener('click', function() {
                // Create a new education entry dynamically with unique names and ids
                var educationIndex = document.querySelectorAll('#education-fields .card').length;
                var newEducation = document.createElement('div');
                newEducation.classList.add('card', 'mb-3');

                newEducation.innerHTML = `
            <div class="card-header">
                <h6>Education Entry #${educationIndex + 1}</h6>
            </div>
            <div class="card-body">
                <div class="form-group row mb-3">
                    <label class="col-lg-2 col-form-label">University</label>
                    <div class="col-lg-4">
                        <input type="text" class="form-control" name="university[${educationIndex}]" id="university[${educationIndex}]">
                    </div>
                    <label class="col-lg-2 col-form-label">Field of Study</label>
                    <div class="col-lg-4">
                        <input type="text" class="form-control" name="field[${educationIndex}]" id="field[${educationIndex}]">
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-lg-2 col-form-label">Start Date</label>
                    <div class="col-lg-4">
                        <input type="date" class="form-control" name="university_start_date[${educationIndex}]" id="university_start_date[${educationIndex}]">
                    </div>
                    <label class="col-lg-2 col-form-label">End Date</label>
                    <div class="col-lg-4">
                        <input type="date" class="form-control" name="university_end_date[${educationIndex}]" id="university_end_date[${educationIndex}]">
                    </div>
                </div>
                <button type="button" class="btn btn-danger close-education">
                    <i class="fas fa-close"></i> Remove
                </button>
            </div>
        `;
                document.getElementById('education-fields').appendChild(newEducation);
            });

            // Remove education entry when close-education button is clicked
            document.body.addEventListener('click', function(e) {
                if (e.target.classList.contains('close-education')) {
                    e.target.closest('.card').remove();
                }
            });

            // Certificate preview functionality
            document.body.addEventListener('change', function(e) {
                if (e.target.matches('[id^="certificate"]')) {
                    var files = e.target.files;
                    var previewContainer = e.target.closest('.form-group').querySelector('.certificate-preview');

                    // Clear previous previews
                    if (previewContainer) {
                        previewContainer.innerHTML = '';
                    }

                    // Show the preview of selected files
                    for (var i = 0; i < files.length; i++) {
                        var file = files[i];
                        var reader = new FileReader();
                        reader.onload = function(event) {
                            var img = document.createElement('img');
                            img.src = event.target.result;
                            img.width = 100; // You can adjust the width if necessary
                            previewContainer.appendChild(img);
                        };
                        reader.readAsDataURL(file);
                    }
                }
            });
        });



        document.addEventListener('DOMContentLoaded', function() {
            // Function to add a new experience entry
            document.getElementById('add-experience').addEventListener('click', function() {
                // Calculate the index for the new experience entry
                var experienceIndex = document.querySelectorAll('#experience-fields .card').length;

                // Create a new experience entry dynamically
                var newExperience = document.createElement('div');
                newExperience.classList.add('card', 'mb-3');
                newExperience.id = `experience-entry-${experienceIndex}`;

                newExperience.innerHTML = `
            <div class="card-header">
                <h6>Experience Entry #${experienceIndex + 1}</h6>
            </div>
            <div class="card-body">
                <div class="form-group row mb-3">
                    <label class="col-lg-2 col-form-label">Hospital Name</label>
                    <div class="col-lg-4">
                        <input type="text" class="form-control" name="hospital_name[]" id="hospital_name_${experienceIndex}">
                    </div>
                    <label class="col-lg-2 col-form-label">Position</label>
                    <div class="col-lg-4">
                        <input type="text" class="form-control" name="position[]" id="position_${experienceIndex}">
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-lg-2 col-form-label">Start Date</label>
                    <div class="col-lg-4">
                        <input type="date" class="form-control" name="start_date[]" id="start_date_${experienceIndex}">
                    </div>
                    <label class="col-lg-2 col-form-label">End Date</label>
                    <div class="col-lg-4">
                        <input type="date" class="form-control" name="end_date[]" id="end_date_${experienceIndex}">
                    </div>
                </div>
                <button type="button" class="btn btn-danger close-experience">
                    <i class="fas fa-close"></i> Remove
                </button>
            </div>
        `;

                document.getElementById('experience-fields').appendChild(newExperience);
            });

            // Remove experience entry when close-experience button is clicked
            document.body.addEventListener('click', function(e) {
                if (e.target.classList.contains('close-experience')) {
                    e.target.closest('.card').remove();
                }
            });
        });



        $(document).ready(function () {
            // jQuery Validation
            $('#myForm').validate({
                rules: {
                    first_name: {
                        required: true,
                        minlength: 2
                    },
                    last_name: {
                        required: true,
                        minlength: 2
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    phone_number: {
                        minlength: 10,
                    },
                    date_of_birth: {
                        required: true,
                        date: true
                    },
                    gender: {
                        required: true
                    },
                    // Validate Array Fields
                    'hospital_name[]': {
                        required: true,
                        minlength: 1
                    },
                    'position[]': {
                        minlength: 1
                    },
                    'start_date[]': {
                        minlength: 1
                    },
                    'end_date[]': {
                        minlength: 1
                    },
                    'university[]': {
                        minlength: 1
                    },
                    'field[]': {
                        minlength: 1
                    },
                    'university_start_date[]': {
                        date: true
                    },
                    'university_end_date[]': {
                        required: true,
                        date: true
                    },
                    age: {
                        required:true,
                    },
                    work_start_time: {
                        required: true,
                    },
                    work_end_time: {
                        required: true,
                    },
                    address: {
                        required: true,
                    },
                    about: {
                        required: true,
                    },

                },
                messages: {
                    first_name: {
                        required: "Please enter the first name",
                        minlength: "First name must be at least 2 characters"
                    },
                    last_name: {
                        required: "Please enter the last name",
                        minlength: "Last name must be at least 2 characters"
                    },
                    email: {
                        required: "Please enter the email",
                        email: "Please enter a valid email address"
                    },
                    phone_number: {
                        minlength: "Phone number must be at least 10 digits",
                    },
                    date_of_birth: {
                        required: "Please enter the date of birth",
                        date: "Please enter a valid date"
                    },
                    gender: {
                        required: "Please select the gender"
                    },
                    // Array Fields Error Messages
                    'hospital_name[]': {
                        required: "Please enter at least one hospital name"
                    },
                    'position[]': {
                        required: "Please enter at least one position"
                    },
                    'start_date[]': {
                        required: "Please enter at least one start date"
                    },
                    'end_date[]': {
                        required: "Please enter at least one end date"
                    },
                    'university[]': {
                        required: "Please enter at least one university"
                    },
                    'field[]': {
                        required: "Please enter at least one field"
                    },
                    'university_start_date[]': {
                        required: "Please provide a university start date",
                        date: "Please enter a valid date"
                    },
                    'university_end_date[]': {
                        required: "Please provide a university end date",
                        date: "Please enter a valid date"
                    },
                    address: {
                        required: 'Please write a address'
                    },
                    about: {
                        required: 'Please write a about'
                    },
                    age: {
                        required: "Please enter the age"
                    },
                    work_start_time: {
                        requires: 'Please select start time',
                    },
                    work_end_time: {
                        requires: 'Please select end time',
                    },
                },
                errorElement: "span",
                errorPlacement: function (error, element) {
                    error.addClass("invalid-feedback");
                    element.closest('.mb-3').append(error);
                },
                highlight: function (element) {
                    $(element).addClass("is-invalid").removeClass("is-valid");
                },
                unhighlight: function (element) {
                    $(element).removeClass("is-invalid").addClass("is-valid");
                }
            });
        });

        // Image preview function
        function previewImage(event) {
            var reader = new FileReader();

            // Once the file is read, set the result (base64 data) to the image preview
            reader.onload = function () {
                var output = document.getElementById('imagePreview');
                output.src = reader.result; // Set the src of the image to the result
            };

            // Read the file if there is one
            if (event.target.files[0]) {
                reader.readAsDataURL(event.target.files[0]); // Start reading the file
            }
        }

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


    </script>
@endpush
