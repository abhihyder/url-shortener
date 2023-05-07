@extends('layouts.master')

@section('title', 'Add User')

@push('style')
@endpush

@section('content')
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <section id="basic-vertical-layouts">
                <div class="card">
                    <div class="card-header border-bottom">
                        <h4 class="card-title">Add User</h4>
                    </div>
                    <div class="card-body">
                        <div class="card">
                            <div class="card-body">
                                <div class="row justify-content-center">
                                    <div class="col-md-6 col-12">
                                        <form class="form form-vertical" id="addUserForm">
                                            @csrf
                                            @method('POST')
                                            <div class="form-group">
                                                <label class="form-label" for="username">Name</label>
                                                <input class="form-control " type="text" name="name" placeholder="John Doe" aria-describedby="name" autofocus="" tabindex="1" />
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label" for="username">Username</label>
                                                <input class="form-control " id="username" type="text" name="username" placeholder="johndoe" aria-describedby="username" tabindex="1" />
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label" for="email">Email</label>
                                                <input class="form-control " id="email" type="text" name="email" placeholder="john@example.com" aria-describedby="email" tabindex="2" />
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label" for="password">Password</label>
                                                <div class="input-group input-group-merge form-password-toggle">
                                                    <input class="form-control form-control-merge " id="password" type="password" name="password" placeholder="············" aria-describedby="password" tabindex="3" />
                                                    <div class="input-group-append">
                                                        <span class="input-group-text cursor-pointer">
                                                            <i data-feather="eye"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <small id="password-error" class="text-danger"></small>
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
                                                <small id="password_confirmation-error" class="text-danger"></small>
                                            </div>
                                            <div class="form-group">
                                                <label for="contact-info-vertical">Role</label>
                                                <select class="select2 form-control" name="role">
                                                    <option value="">Select One</option>
                                                    @foreach ($roles as $role)
                                                    <option value="{{$role->id}}">{{$role->name}}</option>
                                                    @endforeach
                                                </select>
                                                <small id="role-error" class="text-danger"></small>
                                            </div>
                                            <div class="form-group">
                                                <label for="contact-info-vertical">Status</label>
                                                <select class="select2 form-control" name="status">
                                                    <option value="1">Active</option>
                                                    <option value="0">Inactive</option>
                                                </select>
                                                <small id="status-error" class="text-danger"></small>
                                            </div>
                                            <div class="form-group">
                                                <label for="contact-info-vertical">Earning Disable</label>
                                                <select class="select2 form-control" name="earning_disable">
                                                    <option value="0">No</option>
                                                    <option value="1">Yes</option>
                                                </select>
                                                <small id="earning_disable-error" class="text-danger"></small>
                                            </div>
                                            <div class="form-group">
                                                <button type="button" id="addUserSubmit" class="btn btn-primary mr-1">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    $("#addUserSubmit").click(function(event) {
        event.preventDefault();
        $("small.text-danger").text('');
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{route('admin.user.store')}}",
            data: $("#addUserForm").serialize(),
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
                } else {}
            }
        });
    });
</script>
@endpush