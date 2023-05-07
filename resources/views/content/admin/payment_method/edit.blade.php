@extends('layouts.master')

@section('title', 'Edit Payment Method')

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
                        <h4 class="card-title">Payment Method Edit</h4>
                    </div>
                    <div class="card-body">
                        <div class="card">
                            <div class="card-body">
                                <div class="row justify-content-center">
                                    <div class="col-md-6 col-12">
                                        <form class="form form-vertical" id="editPamentMethodForm">
                                            @csrf
                                            @method('POST')
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>Name </label>
                                                        <input type="text" class="form-control" placeholder="Name" name="name" value="{{$paymentMethod->name}}" {{$paymentMethod->id==1?'readonly':''}} />
                                                        <small id="name-error" class="text-danger"></small>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>Minimum Withdrawal Amount</label>
                                                        <input type="number" class="form-control" placeholder="Min Withdrawal Amount" name="min_withdrawal_amount" value="{{$paymentMethod->min_withdrawal_amount}}">
                                                        <small id="min_withdrawal_amount-error" class="text-danger"></small>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <button type="button" id="editPamentMethodSubmit" class="btn btn-primary mr-1">Submit</button>
                                                </div>
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
    $("#editPamentMethodSubmit").click(function(event) {
        event.preventDefault();
        $("small.text-danger").text('');
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{route('admin.payment-method.update', $paymentMethod->id)}}",
            data: $("#editPamentMethodForm").serialize(),
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