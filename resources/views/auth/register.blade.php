@extends('website.layouts.master')
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="account-content">
                        <div class="row align-items-center justify-content-center">
                            <div class="col-md-7 col-lg-6 login-left">
                                <img src="{{ asset('website') }}/img/login-banner.png" class="img-fluid" alt="Doccure Register">
                            </div>
                            <div class="col-md-12 col-lg-6 login-right">
                                <div class="login-header">
                                    <h3>Patient Register</h3>
                                </div>

                                <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group form-focus">
                                        <input type="text" name="first_name" class="form-control floating">
                                        <label class="focus-label">First Name</label>
                                        @if ($errors->has('first_name'))
                                            <div class="text-danger">{{ $errors->first('first_name') }}</div>
                                        @endif
                                    </div>

                                    <div class="form-group form-focus">
                                        <input type="email" name="email" class="form-control floating">
                                        <label class="focus-label">Email</label>
                                        @if ($errors->has('email'))
                                            <div class="text-danger">{{ $errors->first('email') }}</div>
                                        @endif
                                    </div>

                                    <div class="form-group form-focus">
                                        <input type="password" name="password" class="form-control floating">
                                        <label class="focus-label">Password</label>
                                        @if ($errors->has('password'))
                                            <div class="text-danger">{{ $errors->first('password') }}</div>
                                        @endif
                                    </div>

                                    <div class="form-group form-focus">
                                        <input type="file" name="image" class="form-control floating" accept="image/*">
                                        <label class="focus-label">Profile</label>
                                    </div>

                                    <a class="forgot-link" href="{{route('login')}}">Already have an account?</a>

                                    <button class="btn btn-primary w-100 btn-lg login-btn" type="submit">Signup</button>
                                </form>

                                    <div class="login-or">
                                        <span class="or-line"></span>
                                        <span class="span-or">or</span>
                                    </div>

                                    <div class="row form-row social-login">
                                        <div class="col-6">
                                            <a href="#" class="btn btn-facebook w-100"><i class="fab fa-facebook-f me-1"></i> Login with Facebook</a>
                                        </div>
                                        <div class="col-6">
                                            <a href="#" class="btn btn-google w-100"><i class="fab fa-google me-1"></i> Login with Google</a>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
