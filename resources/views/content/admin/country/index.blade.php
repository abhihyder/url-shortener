@extends('layouts.master')

@section('title', 'Dashboard')

@push('style')

<link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/vendors.min.css')}}">
@endpush

@section('content')
@php $auth=null; @endphp
@if(Auth::check())
@php $auth = Auth::user(); @endphp
@endif
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">

        <div class="content-body">
            <!-- Ajax Sourced Server-side -->
            <section>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header border-bottom">
                                <h4 class="card-title">Country Wise Rate</h4>
                                @if($auth)
                                @if($auth->role_id == 1)
                                <div class="dt-action-buttons text-right">
                                    <div class="dt-buttons d-inline-flex">
                                        <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#addCountryModal">Add New</button>
                                    </div>
                                </div>
                                @endif
                                @endif

                            </div>
                            <div class="card-datatable">
                                <form id="rateForm">
                                    @csrf
                                    @method('POST')
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Desktop Rate</th>
                                                <th>Mobile Rate</th>
                                                <th>Name</th>
                                                <th>Desktop Rate</th>
                                                <th>Mobile Rate</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><input type="hidden" name="country_id[]" value="{{$global_rate->id}}" />{{$global_rate->name}}</td>
                                                <td><input type="number" class="form-control" name="desktop_rate[]" placeholder="Desktop" value="{{$global_rate->desktop_rate}}" {{$auth->role_id == 1?'':'readonly'}} /></td>
                                                <td><input type="number" class="form-control" name="mobile_rate[]" placeholder="Mobile" value="{{$global_rate->mobile_rate}}" {{$auth->role_id == 1?'':'readonly'}} /></td>
                                                @php $i=1; @endphp
                                                @foreach ($countries as $country)
                                                @php
                                                $loop_no = $i % 2;
                                                @endphp

                                                @if($loop_no ==1)
                                                <td><input type="hidden" name="country_id[]" value="{{$country->id}}" />{{$country->name}}</td>
                                                <td><input type="number" class="form-control" name="desktop_rate[]" placeholder="Desktop" value="{{$country->desktop_rate}}" {{$auth->role_id == 1?'':'readonly'}} /></td>
                                                <td><input type="number" class="form-control" name="mobile_rate[]" placeholder="Mobile" value="{{$country->mobile_rate}}" {{$auth->role_id == 1?'':'readonly'}} /></td>
                                            </tr>
                                            @else
                                            <tr>
                                                <td><input type="hidden" name="country_id[]" value="{{$country->id}}" />{{$country->name}}</td>
                                                <td><input type="number" class="form-control" name="desktop_rate[]" placeholder="Desktop" value="{{$country->desktop_rate}}" {{$auth->role_id == 1?'':'readonly'}} /></td>
                                                <td><input type="number" class="form-control" name="mobile_rate[]" placeholder="Mobile" value="{{$country->mobile_rate}}" {{$auth->role_id == 1?'':'readonly'}} /></td>
                                                @endif
                                                @php $i++; @endphp
                                                @endforeach
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                            @if($auth)
                            @if($auth->role_id == 1)
                            <div class="card-footer border-bottom">
                                <div class="dt-action-buttons text-right">
                                    <div class="dt-buttons d-inline-flex">
                                        <button class="btn btn-primary" id="saveRateChanges" type="button">Save Changes</button>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @endif
                        </div>
                    </div>
                </div>
            </section>

            <!--/ Ajax Sourced Server-side -->

        </div>
    </div>
</div>
@endsection

@section('modal')
<div class="modal fade text-left" id="addCountryModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Country</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form form-horizontal" id="addCountryForm">
                    @csrf
                    @method('POST')
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group row">
                                <div class="col-sm-3 col-form-label">
                                    <label for="first-name">Name</label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="name" placeholder="Name" />
                                    <small id="name-error" class="text-danger"></small>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group row">
                                <div class="col-sm-3 col-form-label">
                                    <label for="email-id">Country Code</label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="country_code" placeholder="Code" />
                                    <small id="country_code-error" class="text-danger"></small>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group row">
                                <div class="col-sm-3 col-form-label">
                                    <label for="contact-info">Desktop Rate</label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" name="desktop_rate" placeholder="Desktop Rate" />
                                    <small id="desktop_rate-error" class="text-danger"></small>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group row">
                                <div class="col-sm-3 col-form-label">
                                    <label for="contact-info">Mobile Rate</label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" name="mobile_rate" placeholder="Mobile Rate" />
                                    <small id="mobile_rate-error" class="text-danger"></small>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="submitAddCountryForm">Save</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')
@if($auth)
@if($auth->role_id == 1)

<script>
    $("#saveRateChanges").click(function(event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{route('admin.country.change-rate')}}",
            data: $("#rateForm").serialize(),
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

    $("#submitAddCountryForm").click(function(event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{route('admin.country.store')}}",
            data: $("#addCountryForm").serialize(),
            success: function(response) {
                $("#addCountryModal").modal("hide");
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
@endif
@endif
@endpush