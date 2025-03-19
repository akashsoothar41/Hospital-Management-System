@extends('backend.admin.layouts.master')
@section('content')
    @push('css')
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
        <style>
            /* Custom CSS for form alignment */
            .form-container {
                width: 100%;
                margin: 0 auto;
                padding: 30px;
            }
            .form-control {
                border-radius: 5px;
                box-shadow: none;
                padding: 10px;
            }
            .mb-3 {
                margin-bottom: 20px;
            }
            .card-body {
                padding: 25px;
            }
            #image-container {
                text-align: center;
            }
            .btn {
                margin-top: 20px;
                width: 100%;
            }

            /* Full width adjustments for form */
            .col-lg-6 {
                width: 100%;
                padding-right: 15px;
                padding-left: 15px;
            }

            .form-group {
                width: 100%;
            }

            /* Adjust card to full width */
            .card {
                width: 100%;
                margin: 0 auto;
            }

            /* Add padding and margin adjustments */
            .card-body {
                padding: 30px;
            }
        </style>
    @endpush
    <div class="form-container">
        <div class="col-xl-12 d-flex">
            <div class="card flex-fill">
                <div class="card-header">
                    <h4 class="card-title">Update Profile</h4>
                </div>
                <div class="card-body">
                    <form id="myForm" action="{{ route('admin_update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <!-- First Name -->
                                <div class="form-group row mb-3">
                                    <label class="col-lg-4 col-form-label">First Name</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name', $user->first_name) }}" name="first_name" id="first_name">
                                    </div>
                                    @error('first_name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Last Name -->
                                <div class="form-group row mb-3">
                                    <label class="col-lg-4 col-form-label">Last Name</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name', $user->last_name) }}" name="last_name" id="last_name">
                                    </div>
                                    @error('last_name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Age -->
                                <div class="form-group row mb-3">
                                    <label class="col-lg-4 col-form-label">Age</label>
                                    <div class="col-lg-8">
                                        <input type="number" class="form-control @error('age') is-invalid @enderror" value="{{ old('age', $user->profile->age) }}" name="age" id="age">
                                    </div>
                                    @error('age')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Date of Birth -->
                                <div class="form-group row mb-3">
                                    <label class="col-lg-4 col-form-label">Date of Birth</label>
                                    <div class="col-lg-8">
                                        <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" value="{{ old('date_of_birth', $user->profile->date_of_birth) }}" name="date_of_birth" id="date_of_birth">
                                    </div>
                                    @error('date_of_birth')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Gender -->
                                <div class="form-group row mb-3">
                                    <label class="col-lg-4 col-form-label">Gender</label>
                                    <div class="col-lg-8">
                                        <select class="form-control @error('gender') is-invalid @enderror" name="gender" id="gender">
                                            <option value="male" {{ $user->profile->gender == 'male' ? 'selected' : '' }}>Male</option>
                                            <option value="female" {{ $user->profile->gender == 'female' ? 'selected' : '' }}>Female</option>
                                            <option value="other" {{ $user->profile->gender == 'other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                    </div>
                                    @error('gender')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Phone Number -->
                                <div class="form-group row mb-3">
                                    <label class="col-lg-4 col-form-label">Phone Number</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control @error('phone_number') is-invalid @enderror" value="{{ old('phone_number', $user->profile->phone_number) }}" name="phone_number" id="phone_number">
                                    </div>
                                    @error('phone_number')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Emergency Contact -->
                                <div class="form-group row mb-3">
                                    <label class="col-lg-4 col-form-label">Emergency Contact</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control @error('emergency_contact') is-invalid @enderror" value="{{ old('emergency_contact', $user->profile->emergency_contact) }}" name="emergency_contact" id="emergency_contact">
                                    </div>
                                    @error('emergency_contact')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Address -->
                                <div class="form-group row mb-3">
                                    <label class="col-lg-4 col-form-label">Address</label>
                                    <div class="col-lg-8">
                                        <textarea class="form-control @error('address') is-invalid @enderror" name="address" id="address">{{ old('address', $user->profile->address) }}</textarea>
                                    </div>
                                    @error('address')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <!-- Email -->
                                <div class="form-group row mb-3">
                                    <label class="col-lg-4 col-form-label">Email</label>
                                    <div class="col-lg-8">
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" name="email" id="email">
                                    </div>
                                    @error('email')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Password -->
                                <div class="form-group row mb-3">
                                    <label class="col-lg-4 col-form-label">Password</label>
                                    <div class="col-lg-8">
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password">
                                    </div>
                                    @error('password')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- About -->
                                <div class="form-group row mb-3">
                                    <label class="col-lg-4 col-form-label">About</label>
                                    <div class="col-lg-8">
                                        <textarea class="form-control @error('about') is-invalid @enderror" name="about" id="about">{{ old('about', $user->profile->about) }}</textarea>
                                    </div>
                                    @error('about')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Profile Image -->
                                <div class="form-group row mb-3">
                                    <label class="col-lg-4 col-form-label">Profile Image</label>
                                    <div class="col-lg-8">
                                        <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" id="image" onchange="previewImage(event)">
                                    </div>
                                    @error('image')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div id="image-container">
                                    @if($user->profile->image)
                                        <img id="preview" src="{{ asset('backend') }}/{{$user->profile->image}}" alt="Profile Image" style="max-width: 40%; height: auto;">
                                    @else
                                        <img id="preview" src="https://via.placeholder.com/150" alt="No image" style="max-width: 100%; height: auto;">
                                    @endif
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Profile</button>

                    </form>
                </div>
            </div>
        </div>
    </div>


    @push('js')
        <script>
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
                            required: true,
                            minlength: 10
                        },
                        date_of_birth: {
                            required: true,
                            date: true
                        },
                        gender: {
                            required: true
                        },
                        address: {
                            required: true
                        },
                        about: {
                          required: true
                        },
                        age: {
                            required: true
                        }
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
                            required: "Please provide a phone number",
                            minlength: "Phone number must be at least 10 digits"
                        },
                        date_of_birth: {
                            required: "Please provide a date of birth",
                            date: "Please enter a valid date"
                        },
                        gender: {
                            required: "Please select the gender"
                        },
                        address: {
                            required: 'Please write an address'
                        },
                        about: {
                            required: 'Please write about'
                        },
                        age: {
                            required: "Please enter the age"
                        }
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
                reader.onload = function () {
                    var output = document.getElementById('preview');
                    output.src = reader.result;
                };
                if (event.target.files[0]) {
                    reader.readAsDataURL(event.target.files[0]);
                }
            }
        </script>
    @endpush
@endsection
