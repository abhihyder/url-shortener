@extends('layouts.master')

@section('title', 'Withdrawal Method')

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
                                <h4 class="card-title">Withdrawal Method List</h4>
                            </div>
                            <div class="card-datatable pb-1  px-2">
                                <table class="table" id="withdrawal_datatables">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Payment Method</th>
                                            <th>Withdrawal Account</th>
                                            <th>Address 1</th>
                                            <th>Country</th>
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

@push('script')
@include('partials.dataTablesJS')
<script>
    $(document).ready(function() {
        $('#withdrawal_datatables').DataTable({
            destroy: true,
            processing: true,
            serverSide: true,
            displayLength: dataTableDisplayLength,
            lengthMenu: dataTableLengthMenu,
            ajax: {
                url: "{{route('withdrawal-method.index')}}",
                type: "GET",
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'payment_method_id',
                    name: 'payment_method_id'
                },
                {
                    data: 'withdrawal_account',
                    name: 'withdrawal_account'
                },
                {
                    data: 'address_1',
                    name: 'address_1'
                },
                {
                    data: 'country_id',
                    name: 'country_id'
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
    
    $('#withdrawal_datatables').on('length.dt', function(e, settings, len) {
        localStorage.setItem("datatable_length", len);
    });
</script>
@endpush