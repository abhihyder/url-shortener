@extends('layouts.master')

@section('title', 'Withdrawal Request')

@push('style')
@include('partials.dataTablesCSS')
<link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css')}}">
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

            <section id="ajax-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header border-bottom">
                                <h4 class="card-title">Pending Withdrawal Request</h4>
                                <div class="d-flex">
                                    <input type="text" id="dateRangeValue" class="form-control flatpickr-range mr-1" placeholder="YYYY-MM-DD to YYYY-MM-DD" />
                                    <button type="button" onclick="withdrawalRequestDatatables()" class="btn btn-primary"><i data-feather='search'></i></button>
                                </div>
                            </div>
                            <div class="card-datatable pb-1 px-2">
                                <table class="table" id="withdrawal_request_datatables">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Date</th>
                                            <th>User</th>
                                            <th>Payment Method</th>
                                            <th>Withdrawal Account</th>
                                            <th>Withdraw Amount</th>
                                            <th>Status</th>
                                            <th>Action</th>
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
<div class="modal fade text-left" id="processingWithdrawRequestModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Withdraw Request Processing</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="processingWithdrawRequestForm">
                    @csrf
                    @method('POST')
                    <input type="hidden" id="withdraw_request_id" name="withdraw_request_id">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>Status</label>
                                <select class="select2 form-control" name="status">
                                    <option value="1">Approved</option>
                                    <option value="3">Cancelled</option>
                                    <option value="4">Returned</option>
                                </select>
                                <small id="status-error" class="text-danger"></small>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>Note</label>
                                <textarea class="form-control" placeholder="Note" name="note" rows="2">
                                </textarea>
                                <small id="note-error" class="text-danger"></small>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>Transaction ID</label>
                                <input type="text" class="form-control" placeholder="Transaction ID" name="transaction_id" />
                                <small id="transaction_id-error" class="text-danger"></small>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="submitProcessingWithdrawRequest">
                    <span class="spinner-border spinner-border-sm d-none" id="spinnerSpan" role="status" aria-hidden="true"></span>
                    <span class="ml-25 align-middle" id="buttonText">Save</span>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
@include('partials.dataTablesJS')
<script src="{{asset('app-assets/vendors/js/pickers/pickadate/picker.js')}}"></script>
<script src="{{asset('app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js')}}"></script>
<script>
    $(document).ready(function() {
        withdrawalRequestDatatables();
        $('.flatpickr-range').flatpickr({
            mode: 'range'
        });
    })

    function withdrawalRequestDatatables() {
        $('#withdrawal_request_datatables').DataTable({
            destroy: true,
            processing: true,
            serverSide: true,
            displayLength: dataTableDisplayLength,
            lengthMenu: dataTableLengthMenu,
            ajax: {
                url: "{{$datatable_url}}",
                type: "GET",
                data: {
                    date_range: $("#dateRangeValue").val()
                }
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
                    data: 'user',
                    name: 'user'
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
                {
                    data:'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            dom: dataTableDom,
            buttons: dataTableButtonsWhenHasAction,
            columnDefs: [{
                targets: '_all',
                defaultContent: 'N/A'
            }],
        });
    }

    $('#withdrawal_request_datatables').on('length.dt', function(e, settings, len) {
        localStorage.setItem("datatable_length", len);
    });

    function changeStatus(id) {
        $("#withdraw_request_id").val(id);
        $("#processingWithdrawRequestModal").modal("show");
    }

    $("#submitProcessingWithdrawRequest").click(function(event) {
        event.preventDefault();
        $('#spinnerSpan').removeClass('d-none');
        $('#buttonText').text('Processing...');
        $(this).attr('disabled', true);
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{$update_url}}",
            data: $("#processingWithdrawRequestForm").serialize(),
            success: function(response) {
                toastr['success'](
                    "Withdraw request status updated!",
                    "Success!", {
                        closeButton: true,
                    }
                );
                $('#spinnerSpan').addClass('d-none');
                $('#buttonText').text('Save');
                $("#submitProcessingWithdrawRequest").attr('disabled', false);
                $('#processingWithdrawRequestModal').modal('hide');
                $('#withdrawal_request_datatables').DataTable().ajax.reload(null, false);
            },
            error: function(reject) {
                toastr['error'](
                    "Something went wrong!",
                    "Opps!!!", {
                        closeButton: true,
                    }
                );
                $('#spinnerSpan').addClass('d-none');
                $('#buttonText').text('Save');
                $("#submitProcessingWithdrawRequest").attr('disabled', false);
                let errors = $.parseJSON(reject.responseText);
                if (reject.status === 422 || reject.status === 403) {
                    $.each(errors.error.message, function(key, val) {
                        $("small#" + key + "-error").text(val[0]);
                    });
                } else if (reject.status === 400) {
                    // $('#withdraw_amount-error').text(errors.error.message);
                }
            }
        });
    });

    $('#processingWithdrawRequestModal').on('hidden.bs.modal', function() {
        $("#processingWithdrawRequestForm")[0].reset();
        $(".select2").trigger('change');
    })
</script>
@endpush