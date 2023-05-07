@extends('layouts.master')

@section('title', 'Add Withdrawal Method')

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
            <form id="addWithdrawalMethodForm">
                @csrf
                @method('POST')
                <section id="basic-vertical-layouts">
                    <div class="card">
                        <div class="card-header border-bottom">
                            <h4 class="card-title">Withdrawal Method Add</h4>
                        </div>
                        <div class="card-body">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form form-vertical">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label>Payment Method </label>
                                                            <select class="select2 form-control" name="payment_method">
                                                                <option value="">Select One</option>
                                                                @foreach ($payment_methods as $method)
                                                                <option value="{{$method->id}}">{{$method->name}}</option>
                                                                @endforeach
                                                            </select>
                                                            <small id="payment_method-error" class="text-danger"></small>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="table-responsive">
                                                <table class="table ">
                                                    <thead>
                                                        <tr>
                                                            <th>Payment Method</th>
                                                            <th>Minimum Withdrawal Amount</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($payment_methods as $method)
                                                        <tr>
                                                            <td>{{$method->name}}</td>
                                                            <td>${{$method->min_withdrawal_amount}}</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>
                                        <div class="col-12 mt-2">
                                            <div class="form form-vertical">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label >Withdrawal Account</label>
                                                            <textarea name="withdrawal_account" class="form-control" rows="5"></textarea>
                                                            <small id="withdrawal_account-error" class="text-danger"></small>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <label>- For PayPal, add your email.</label><br>
                                                        <label>- For Perfect Money: U1234567, John Adpaylink (Your Name) (If You from India Use this Payment Method)</label><br>
                                                        <label>- BANK TRANSFER IS JUST AVAILABLE FOR INDONESIAN PUBLISHERS. (Bank/No.Rek/an)</label><br>
                                                        <label>- OVO/DANA/Gopay - (just for Indonesia) Ketikkan. No. Hp/Nama ( 081****/Nama anda) </label><br>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </section>
                <section id="multiple-column-form">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Billing Address</h4>
                                </div>
                                <div class="card-body">
                                    <div class="form">
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="first-name-column">First Name</label>
                                                    <input type="text" class="form-control" placeholder="First Name" name="first_name" />
                                                    <small id="first_name-error" class="text-danger"></small>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="last-name-column">Last Name</label>
                                                    <input type="text" class="form-control" placeholder="Last Name" name="last_name" />
                                                    <small id="last_name-error" class="text-danger"></small>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>Address 1</label>
                                                    <input type="text" class="form-control" placeholder="Address 1" name="address_1" />
                                                    <small id="address_1-error" class="text-danger"></small>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>Address 2</label>
                                                    <input type="text" class="form-control" placeholder="Address 2" name="address_2" />
                                                    <small id="address_2-error" class="text-danger"></small>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="city-column">City</label>
                                                    <input type="text" id="city-column" class="form-control" placeholder="City" name="city" />
                                                    <small id="city-error" class="text-danger"></small>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="city-column">State</label>
                                                    <input type="text" class="form-control" placeholder="State" name="state" />
                                                    <small id="state-error" class="text-danger"></small>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="city-column">ZIP</label>
                                                    <input type="text" class="form-control" placeholder="ZIP" name="zip" />
                                                    <small id="zip-error" class="text-danger"></small>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="country-floating">Country</label>

                                                    <select class="select2 form-control" name="country">
                                                        <option value="">Country</option>
                                                        @foreach ($countries as $country)
                                                        <option value="{{$country->id}}">{{$country->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <small id="country-error" class="text-danger"></small>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="company-column">Phone</label>
                                                    <input type="text" class="form-control" name="phone" placeholder="Phone" />
                                                    <small id="phone-error" class="text-danger"></small>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <button type="button" id="addWithdrawalSubmit" class="btn btn-primary mr-1">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </form>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="{{asset('app-assets/vendors/js/forms/select/select2.full.min.js')}}"></script>
<script>
    $(document).ready(function() {
        $(".select2").select2({
            placeholder: 'Select One',
        })
    })

    $("#addWithdrawalSubmit").click(function(event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{route('withdrawal-method.store')}}",
            data: $("#addWithdrawalMethodForm").serialize(),
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