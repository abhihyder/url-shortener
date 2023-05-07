@extends('layouts.master')

@section('title', 'Withdrawal Request')

@push('style')
@include('partials.dataTablesCSS')

<style>
    .select2-results__option {
        text-overflow: ellipsis;
        white-space: nowrap;
        overflow: hidden;
    }
</style>

@endpush

@section('content')
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <section id="dashboard-ecommerce">
                <div class="row match-height">
                    <!-- Medal Card -->
                    <div class="col-xl-3 col-md-6 col-12">
                        <div class="card">
                            <div class="card-body">
                                <h5>Balance</h5>
                                <p class="card-text font-small-3">Available</p>
                                <h3 class="mb-75 mt-2 pt-50">
                                    <a href="javascript:void(0);">$<span>{{number_format($wallet->available_balance,4)}}</span></a>

                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 col-12">
                        <div class="card ">
                            <div class="card-body">
                                <h5>Withdraw</h5>
                                <p class="card-text font-small-3">Processing</p>
                                <h3 class="mb-75 mt-2 pt-50">
                                    <a href="javascript:void(0);">$<span>{{number_format($processing_request,4)}}</span></a>
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 col-12">
                        <div class="card ">
                            <div class="card-body">
                                <h5>Withdraw</h5>
                                <p class="card-text font-small-3">Total</p>
                                <h3 class="mb-75 mt-2 pt-50">
                                    <a href="javascript:void(0);">$<span>{{number_format($wallet->total_withdraw,4)}}</span></a>
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 col-12">
                        <div class="card ">
                            <div class="card-body">
                                <h5>Earning</h5>
                                <p class="card-text font-small-3">Total</p>
                                <h3 class="mb-75 mt-2 pt-50">
                                    <a href="javascript:void(0);">$<span>{{number_format(($wallet->available_balance+$processing_request+$wallet->total_withdraw),4)}}</span></a>
                                </h3>
                            </div>
                        </div>
                    </div>

                </div>
            </section>
            <section id="ajax-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header border-bottom">
                                <h4 class="card-title">Withdrawal Request List</h4>
                                <div class="dt-buttons d-inline-flex">
                                    <button class="dt-button btn btn-primary" type="button" data-toggle="modal" data-target="#withdrawRequestModal"><span> Withdraw</span></button>
                                </div>
                            </div>
                            <div class="card-datatable pb-1 px-2">
                                <table class="table" id="withdrawal_datatables">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Date</th>
                                            <th>Payment Method</th>
                                            <th>Withdrawal Account</th>
                                            <th>Withdraw Amount</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <div class="card-body">
                                <ul>
                                    <li>Pending: The payment is being checked by our team.</li>
                                    <li>Approved: The payment has been approved and is waiting to be sent.</li>
                                    <li>Complete: The payment has been successfully sent to your payment account.</li>
                                    <li>Cancelled: The payment has been cancelled.</li>
                                    <li>Returned: The payment has been returned to your account.</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </section>
        </div>
    </div>
</div>
@endsection


@section('modal')
<div class="modal fade text-left" id="withdrawRequestModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Withdraw Request</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="withdrawRequestForm">
                    @csrf
                    @method('POST')
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>Payment Method</label>
                                <select class="select2 form-control" name="payment_method" id="payment_method">
                                    @foreach ($withdrawal_methods as $withdrawal_method)
                                    <option value="{{$withdrawal_method[0]->paymentMethod->id}}">{{$withdrawal_method[0]->paymentMethod->name}}</option>
                                    @endforeach
                                </select>
                                <small id="payment_method-error" class="text-danger"></small>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>Withdrawal Account</label>
                                <select class="select2 form-control" name="withdrawal_method" id="withdrawal_method">
                                    @if(count($withdrawal_methods)>0)
                                    @foreach (array_values(current($withdrawal_methods))[0] as $method)
                                    <option value="{{$method->id}}">{{$method->withdrawal_account}}</option>
                                    @endforeach
                                    @endif
                                </select>
                                <small id="withdrawal_method-error" class="text-danger"></small>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>Withdrawal Account (Details)</label>
                                <textarea class="form-control" placeholder="Withdraw Account" name="withdraw_account" id="withdraw_account" cols="30" rows="3" readonly>
                                </textarea>
                                <small id="withdraw_account-error" class="text-danger"></small>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>Withdraw Amount</label>
                                <input type="number" class="form-control" placeholder="Availabe Balance ${{number_format($wallet->available_balance,4)}}" name="withdraw_amount" id="withdraw_amount" />
                                <small id="withdraw_amount-error" class="text-danger"></small>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="submitWithdrawRequest">
                    <span class="spinner-border spinner-border-sm d-none" id="spinnerSpan" role="status" aria-hidden="true"></span>
                    <span class="ml-25 align-middle" id="buttonText">Request</span>
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')
@include('partials.dataTablesJS')
<script>
    var available_balance = "{{$wallet->available_balance}}";
    var auth_user_id = "{{Auth::user()->id}}";
    var withdrawal_methods = @json($withdrawal_methods);
    var min_withdrawal_amount = [];
    available_balance = parseFloat(available_balance);
    $(document).ready(function() {

        $(".select2").select2({
            placeholder: 'Select One',
        })
        $.each(withdrawal_methods, function(index, withdrawal_method) {
            min_withdrawal_amount[withdrawal_method[0].payment_method.id] = parseFloat(withdrawal_method[0].payment_method.min_withdrawal_amount).toFixed(4);
        });
        initial_check();
        $('#withdrawal_datatables').DataTable({
            destroy: true,
            processing: true,
            serverSide: true,
            displayLength: dataTableDisplayLength,
            lengthMenu: dataTableLengthMenu,
            ajax: {
                url: "{{route('withdrawal-request.index')}}",
                type: "GET",
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'payment_method',
                    name: 'payment_method'
                },
                {
                    data: 'withdrawal_account',
                    name: 'withdrawal_account'
                },
                {
                    data: 'request_amount',
                    name: 'request_amount'
                },
                {
                    data: 'status',
                    name: 'status'
                },
            ],
            dom: dataTableDom,
            buttons: dataTableButtons,
            columnDefs: [{
                targets: '_all',
                defaultContent: 'N/A'
            }],
        });
    })

    $('#withdrawal_datatables').on('length.dt', function(e, settings, len) {
        localStorage.setItem("datatable_length", len);
    });

    $('#payment_method').change(function(e) {
        e.preventDefault();
        $('#payment_method-error').text('');
        $('#withdraw_account').text('');
        $('#withdrawal_method').html('');
        let id = $(this).val();
        let min_amount = min_withdrawal_amount[id];
        if (available_balance >= min_amount) {
            $('#submitWithdrawRequest').attr('disabled', false);
            let where = "payment_method_id=" + id + " and user_id=" + auth_user_id;
            $.ajax({
                type: "POST",
                dataType: "html",
                url: "{{route('common.table-data')}}",
                data: {
                    table: 'withdrawal_methods',
                    column: 'withdrawal_account',
                    where: where,
                    selected: null,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    $('#withdrawal_method').html(response);
                    let text = $("#withdrawal_method option:selected").text();
                    $('#withdraw_account').text(text);
                }
            });
        } else {
            $('#payment_method-error').text("You don't have sufficient balance! Minimum amount $" + min_amount + ".");
            $('#submitWithdrawRequest').attr('disabled', true);
        }


    });

    $('#withdrawal_method').change(function(e) {
        e.preventDefault();
        let text = $("#withdrawal_method option:selected").text();
        $('#withdraw_account').text(text);
    });

    $("#submitWithdrawRequest").click(function(event) {
        event.preventDefault();
        $('#withdraw_amount-error').text('');
        let payment_method = $('#payment_method').val();
        let min_amount = min_withdrawal_amount[payment_method];
        let amount = parseFloat($("#withdraw_amount").val());
        if (amount) {
            if (amount >= min_amount) {
                if (amount > available_balance) {
                    toastr['error'](
                        "Something went wrong!",
                        "Opps!!!", {
                            closeButton: true,
                        }
                    );
                    $('#withdraw_amount-error').text("You can't withdraw more then $" + available_balance);
                } else {
                    $('#spinnerSpan').removeClass('d-none');
                    $('#buttonText').text('Processing...');
                    $(this).attr('disabled', true);
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "{{route('withdrawal-request.store')}}",
                        data: $("#withdrawRequestForm").serialize(),
                        success: function(response) {
                            toastr['success'](
                                'Withdraw request done!',
                                'Success!', {
                                    closeButton: true,
                                }
                            );
                            $('#spinnerSpan').addClass('d-none');
                            $('#buttonText').text('Request');
                            $("#submitWithdrawRequest").attr('disabled', false);
                            let url = window.location.href;
                            window.location.href = url;
                        },
                        error: function(reject) {
                            $('#spinnerSpan').addClass('d-none');
                            $('#buttonText').text('Request');
                            $("#submitWithdrawRequest").attr('disabled', false);
                            let errors = $.parseJSON(reject.responseText);
                            if (reject.status === 422 || reject.status === 403) {

                                $.each(errors.error.message, function(key, val) {
                                    $("small#" + key + "-error").text(val[0]);
                                });
                            } else if (reject.status === 400) {
                                $('#withdraw_amount-error').text(errors.error.message);
                            }
                        }
                    });
                }
            } else if (amount <= min_amount) {
                toastr['error'](
                    "Something went wrong!",
                    "Opps!!!", {
                        closeButton: true,
                    }
                );
                $('#withdraw_amount-error').text("You can't withdraw less then $" + min_amount);
            }
        } else {
            toastr['error'](
                "Something went wrong!",
                "Opps!!!", {
                    closeButton: true,
                }
            );
            $('#withdraw_amount-error').text("Withdraw amount can't be empty");
        }
    });

    function initial_check() {
        let payment_method = $('#payment_method').val();
        let min_amount = min_withdrawal_amount[payment_method];
        if (available_balance < min_amount) {
            $('#payment_method-error').text("You don't have sufficient balance! Minimum amount $" + min_amount + ".");
            $('#submitWithdrawRequest').attr('disabled', true);
        }
        let text = $("#withdrawal_method option:selected").text();
        $('#withdraw_account').text(text);
    }
</script>
@endpush