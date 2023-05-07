@extends('layouts.master')

@section('title', 'Referral Earning')

@push('style')
@include('partials.dataTablesCSS')
<link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css')}}">
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
                                <h4 class="card-title">Referral Earning</h4>
                                <div class="d-flex">
                                    <input type="text" id="dateRangeValue" class="form-control flatpickr-range mr-1" placeholder="YYYY-MM-DD to YYYY-MM-DD" />
                                    <button type="button" onclick="referralEarningDatatables()" class="btn btn-primary"><i data-feather='search'></i></button>
                                </div>
                            </div>
                            <div class="card-datatable pb-1  px-2">
                                <table class="table" id="referral_earning_datatables">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Username</th>
                                            <th>Amount</th>
                                            <th>Date</th>
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
<script src="{{asset('app-assets/vendors/js/pickers/pickadate/picker.js')}}"></script>
<script src="{{asset('app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js')}}"></script>
<script>
    $(document).ready(function() {
        referralEarningDatatables();
        $('.flatpickr-range').flatpickr({
            mode: 'range'
        });
    })

    function referralEarningDatatables() {
        $('#referral_earning_datatables').DataTable({
            destroy: true,
            processing: true,
            serverSide: true,
            displayLength: dataTableDisplayLength,
            lengthMenu: dataTableLengthMenu,
            ajax: {
                url: "{{route('referral.earning')}}",
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
                    data: 'referred_user',
                    name: 'referred_user'
                },
                {
                    data: 'amount',
                    name: 'amount'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
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


    $('#referral_earning_datatables').on('length.dt', function(e, settings, len) {
        localStorage.setItem("datatable_length", len);
    });

    $("#CopyReferrerLinkToClipBoard").click(function() {
        let link = $("#referrer_link").val();
        copyToClipboard(link);
    });

    $("#CopyReferrerCodeToClipBoard").click(function() {
        let link = $("#referrer_code").val();
        copyToClipboard(link);
    });
</script>
@endpush