@extends('layouts.auth_master')

@section('title', 'Register')

@push('style')
<link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/core/menu/menu-types/vertical-menu.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/plugins/forms/form-validation.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/pages/page-auth.css')}}">
@endpush
@section('content')
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <div class="auth-wrapper auth-v2">
                <div class="auth-inner row m-0">
                    <!-- Brand logo--><a class="brand-logo" href="{{route('home')}}">
                        <img style="max-width:120px;" src="{{ asset('app-assets/images/logo/logo.png')}}" alt="Logo">
                        <!-- <h2 class="brand-text text-primary ml-1">{{config('app.name')}}</h2> -->
                    </a>
                    <!-- /Brand logo-->
                    <!-- Left Text-->
                    <div class="d-none d-lg-flex col-lg-8 align-items-center p-5">
                        <div class="w-100 d-lg-flex align-items-center justify-content-center px-5"><img class="img-fluid" src="{{asset('app-assets/images/pages/register-v2.svg')}}" alt="Register V2" /></div>
                    </div>
                    <!-- /Left Text-->
                    <!-- Register-->
                    <div class="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-5">
                        <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
                            <h2 class="card-title font-weight-bold mb-1">Welcome to {{config('app.name')}}!</h2>
                            <p class="card-text mb-2">Please sign-up your account and start the adventure</p>
                            <form id="registretionForm" class="auth-register-form mt-2" action="{{route('register')}}" method="POST">
                                @csrf

                                <div class="form-group">
                                    <label class="form-label" for="username">Username</label>
                                    <input class="form-control {{ $errors->has('username') ? ' is-invalid' : '' }}" id="username" type="text" name="username" placeholder="johndoe" aria-describedby="username" value="{{ old('username')}}" autofocus="" tabindex="1" />
                                    @if ($errors->has('username'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('username') }}
                                    </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="email">Email</label>
                                    <input class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" id="email" type="text" name="email" placeholder="john@example.com" aria-describedby="email" value="{{ old('email')}}" tabindex="2" />
                                    @if ($errors->has('email'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('email') }}
                                    </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="password">Password</label>
                                    <div class="input-group input-group-merge form-password-toggle">
                                        <input class="form-control form-control-merge {{ $errors->has('password') ? ' is-invalid' : '' }}" id="password" type="password" name="password" placeholder="············" aria-describedby="password" tabindex="3" />
                                        <div class="input-group-append">
                                            <span class="input-group-text cursor-pointer">
                                                <i data-feather="eye"></i>
                                            </span>
                                        </div>
                                        @if ($errors->has('password'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('password') }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="password">Confirm Password</label>
                                    <div class="input-group input-group-merge form-password-toggle">
                                        <input class="form-control form-control-merge" id="password_confirmation" type="password" name="password_confirmation" placeholder="············" aria-describedby="password" tabindex="3" />
                                        <div class="input-group-append">
                                            <span class="input-group-text cursor-pointer">
                                                <i data-feather="eye"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="referrer">Referrer</label>
                                    <input class="form-control {{ $errors->has('referrer') ? ' is-invalid' : '' }}" id="referrer" type="text" name="referrer" placeholder="john" aria-describedby="referrer" value="{{ old('referrer')??$ref}}" tabindex="2" />
                                    @if ($errors->has('referrer'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('referrer') }}
                                    </div>
                                    @endif
                                </div>
                                <!-- <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" id="privacy-policy" type="checkbox" tabindex="4" />
                                        <label class="custom-control-label" for="privacy-policy">I agree to<a href="javascript:void(0);">&nbsp;privacy policy & terms</a></label>
                                    </div>
                                </div> -->
                                <button class="btn btn-primary btn-block" tabindex="5">Sign up</button>
                            </form>
                            <p class="text-center mt-2">
                                <span>Already have an account?</span>
                                <a href="{{route('login')}}">
                                    <span>&nbsp;Sign in instead</span>
                                </a>
                            </p>
                        </div>
                    </div>
                    <!-- /Register-->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')

<script src="{{asset('app-assets/js/scripts/pages/page-auth-register.js')}}"></script>

<script>
    $("#registretionForm").submit(function(event) {
        $("#recaptchaError").addClass("d-none");
        var recaptcha = $("#g-recaptcha-response").val();
        if (recaptcha === "") {
            event.preventDefault();
            $("#recaptchaError").removeClass("d-none");
        }
    });

    function successCallbackFunction() {
        $("#recaptchaError").addClass("d-none");
    }
</script>
@endpush