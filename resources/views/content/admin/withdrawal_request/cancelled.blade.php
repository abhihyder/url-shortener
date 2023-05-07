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
                                <h4 class="card-title">Cancelled Withdrawal Request</h4>
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
                url: "{{route('admin.withdrawal-request.cancelled')}}",
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
            ],
            dom: dataTableDom,
            buttons: dataTableButtons,
            columnDefs: [{
                targets: '_all',
                defaultContent: 'N/A'
            }],
        });
    }

    $('#withdrawal_request_datatables').on('length.dt', function(e, settings, len) {
        localStorage.setItem("datatable_length", len);
    });
</script>
@endpush