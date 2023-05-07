@extends('layouts.master')

@section('title', 'File')

@push('style')
<link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/plugins/forms/pickers/form-pickadate.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/plugins/forms/pickers/form-flat-pickr.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/plugins/forms/form-validation.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/pages/app-file-manager.css')}}">
@endpush

@section('content')
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <!-- <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Account</h2>

                    </div>
                </div>
            </div>
        </div> -->
        <div class="content-body">
            <!-- account setting page -->
            <section id="page-account-settings">
                <div class="row">
                    <!-- left menu section -->
                    <div class="col-md-3 mb-2 mb-md-0">
                        <ul class="nav nav-pills flex-column nav-left">
                            <!-- general -->
                            <li class="nav-item">
                                <a class="nav-link active" id="account-pill-general" data-toggle="pill" href="#account-vertical-general" aria-expanded="true">
                                    <i data-feather="user" class="font-medium-3 mr-1"></i>
                                    <span class="font-weight-bold">General</span>
                                </a>
                            </li>
                            <!-- change password -->
                            <li class="nav-item">
                                <a class="nav-link" id="account-pill-password" data-toggle="pill" href="#account-vertical-password" aria-expanded="false">
                                    <i data-feather="lock" class="font-medium-3 mr-1"></i>
                                    <span class="font-weight-bold">Change Password</span>
                                </a>
                            </li>

                        </ul>
                    </div>
                    <!--/ left menu section -->

                    <!-- right content section -->
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-body">
                                <div class="tab-content">
                                    <!-- general tab -->
                                    <div role="tabpanel" class="tab-pane active" id="account-vertical-general" aria-labelledby="account-pill-general" aria-expanded="true">
                                        <!-- header media -->

                                        <!-- form -->
                                        <form class="validate-form mt-2" id="changeInfoForm">
                                            @csrf
                                            @method('POST')
                                            <div class="media">
                                                <a href="javascript:void(0);" class="mr-25">
                                                    @if($profile->file_path)
                                                    <img src="{{asset('/').$profile->file_path}}" id="account-upload-img" class="rounded mr-50" alt="profile image" height="80" width="80" />
                                                    @else
                                                    <img src="{{asset('app-assets/images/avatars/default.png')}}" id="account-upload-img" class="rounded mr-50" alt="profile image" height="80" width="80" />
                                                    @endif
                                                </a>
                                                <!-- upload and reset button -->
                                                <div class="media-body mt-75 ml-1">
                                                    <label for="account-upload" class="btn btn-sm btn-primary mb-75 mr-75">Upload</label>
                                                    <input type="file" name="file" id="account-upload" hidden accept="image/*" />
                                                    <p>Allowed JPG, JPEG or PNG. Max size of 500KB</p>
                                                    <small id="file-error" class="text-danger"></small>
                                                </div>
                                                <!--/ upload and reset button -->
                                            </div>

                                            <div class="row mt-2">
                                                <div class="col-12 col-sm-6">
                                                    <div class="form-group">
                                                        <label for="account-username">Username</label>
                                                        <input type="text" class="form-control" name="username" placeholder="Username" value="{{$profile->username}}" />
                                                    </div>
                                                    <small id="username-error" class="text-danger"></small>
                                                </div>
                                                <div class="col-12 col-sm-6">
                                                    <div class="form-group">
                                                        <label for="account-name">Name</label>
                                                        <input type="text" class="form-control" name="name" placeholder="Name" value="{{$profile->name}}" />
                                                    </div>
                                                    <small id="name-error" class="text-danger"></small>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="account-e-mail">E-mail</label>
                                                        <input type="email" class="form-control" name="email" placeholder="Email" value="{{$profile->email}}" />
                                                    </div>
                                                    <small id="email-error" class="text-danger"></small>
                                                </div>

                                                <div class="col-12">
                                                    <button type="submit" class="btn btn-primary mt-2 mr-1">Save changes</button>
                                                </div>
                                            </div>
                                        </form>
                                        <!--/ form -->
                                    </div>
                                    <!--/ general tab -->

                                    <!-- change password -->
                                    <div class="tab-pane fade" id="account-vertical-password" role="tabpanel" aria-labelledby="account-pill-password" aria-expanded="false">
                                        <!-- form -->
                                        <form class="validate-form" id="changePassForm">
                                            @csrf
                                            @method('POST')
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="account-old-password">Old Password</label>
                                                        <div class="input-group form-password-toggle input-group-merge">
                                                            <input type="password" class="form-control" name="old_password" placeholder="Old Password" />
                                                            <div class="input-group-append">
                                                                <div class="input-group-text cursor-pointer">
                                                                    <i data-feather="eye"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <small id="old_password-error" class="text-danger"></small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 col-sm-6">
                                                    <div class="form-group">
                                                        <label for="account-new-password">New Password</label>
                                                        <div class="input-group form-password-toggle input-group-merge">
                                                            <input type="password" name="new_password" class="form-control" placeholder="New Password" />
                                                            <div class="input-group-append">
                                                                <div class="input-group-text cursor-pointer">
                                                                    <i data-feather="eye"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <small id="new_password-error" class="text-danger"></small>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-sm-6">
                                                    <div class="form-group">
                                                        <label for="account-retype-new-password">Retype New Password</label>
                                                        <div class="input-group form-password-toggle input-group-merge">
                                                            <input type="password" class="form-control" name="confirm_password" placeholder="New Password" />
                                                            <div class="input-group-append">
                                                                <div class="input-group-text cursor-pointer"><i data-feather="eye"></i></div>
                                                            </div>
                                                        </div>
                                                        <small id="confirm_password-error" class="text-danger"></small>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <button type="submit" class="btn btn-primary mr-1 mt-1">Save changes</button>
                                                </div>
                                            </div>
                                        </form>
                                        <!--/ form -->
                                    </div>
                                    <!--/ change password -->

                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ right content section -->
                </div>
            </section>
            <!-- / account setting page -->

        </div>
    </div>
</div>
@endsection


@push('script')
<script src="{{asset('app-assets/vendors/js/forms/select/select2.full.min.js')}}"></script>
<script src="{{asset('app-assets/vendors/js/forms/validation/jquery.validate.min.js')}}"></script>
<script src="{{asset('app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js')}}"></script>
<script src="{{asset('app-assets/js/scripts/pages/page-account-settings.js')}}"></script>
<script>
    $(document).ready(function() {
        $('#account-upload').change(function() {
            let reader = new FileReader();
            reader.onload = (e) => {
                $('#account-upload-img').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        });
    });

    $("#changeInfoForm").submit(function(event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{route('user.change-info')}}",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                let url = window.location.href;
                window.location.href = url;
            },
            error: function(reject) {
                let errors = $.parseJSON(reject.responseText);
                if (reject.status === 422 || reject.status === 403) {

                    $.each(errors.error.message, function(key, val) {
                        $("small#" + key + "-error").text(val[0]);
                    });
                }
            }
        });
    });

    $("#changePassForm").submit(function(event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{route('user.change-pass')}}",
            data: $("#changePassForm").serialize(),
            success: function(response) {
                let url = window.location.href;
                window.location.href = url;
            },
            error: function(reject) {
                let errors = $.parseJSON(reject.responseText);
                if (reject.status === 422 || reject.status === 403) {

                    $.each(errors.error.message, function(key, val) {
                        $("small#" + key + "-error").text(val[0]);
                    });
                }
            }
        });
    });
</script>
@endpush