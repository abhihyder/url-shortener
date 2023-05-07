@extends('layouts.master')

@section('title', 'Payment Method')

@push('style')
@include('partials.dataTablesCSS')
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
                                <h4 class="card-title">Payment Method List</h4>
                                <div class="dt-buttons d-inline-flex">
                                    <button class="dt-button btn btn-primary" type="button" data-toggle="modal" data-target="#withdrawRequestModal"><span> Add Method</span></button>
                                </div>
                            </div>
                            <div class="card-datatable pb-1  px-2">
                                <table class="table" id="payment_method_datatables">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Payment Method</th>
                                            <th>Minimum Withdrawal Amount</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
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
                <h4 class="modal-title">Add Payment Method</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form form-vertical" id="addPamentMethodForm">
                    @csrf
                    @method('POST')
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>Name </label>
                                <input type="text" class="form-control" placeholder="Name" name="name" />
                                <small id="name-error" class="text-danger"></small>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>Minimum Withdrawal Amount</label>
                                <input type="number" class="form-control" placeholder="Min Withdrawal Amount" name="min_withdrawal_amount">
                                <small id="min_withdrawal_amount-error" class="text-danger"></small>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-dismiss="modal">Cancel</button>
                <button type="button" id="addPamentMethodSubmit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
</div>

@endsection
@push('script')
@include('partials.dataTablesJS')
<script>
    $(document).ready(function() {
        $('#payment_method_datatables').DataTable({
            destroy: true,
            processing: true,
            serverSide: true,
            displayLength: dataTableDisplayLength,
            lengthMenu: dataTableLengthMenu,
            ajax: {
                url: "{{route('admin.payment-method.index')}}",
                type: "GET",
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'min_withdrawal_amount',
                    name: 'min_withdrawal_amount'
                },
                {
                    data: 'action',
                    name: 'action',
                    className: 'text-center',
                    orderable: false,
                    searchable: false
                },
            ],
            dom: dataTableDom,
            buttons: dataTableButtonsWhenHasAction,
            columnDefs: [{
                targets: '_all',
                defaultContent: 'N/A'
            }],
        });
    })

    $('#payment_method_datatables').on('length.dt', function(e, settings, len) {
        localStorage.setItem("datatable_length", len);
    });

    $("#addPamentMethodSubmit").click(function(event) {
        event.preventDefault();
        $("small.text-danger").text('');
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{route('admin.payment-method.store')}}",
            data: $("#addPamentMethodForm").serialize(),
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