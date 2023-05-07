@extends('layouts.master')

@section('title', $title)

@push('style')
<link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/charts/apexcharts.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/pages/dashboard-ecommerce.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/plugins/charts/chart-apex.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css')}}">
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
            @include('partials.message')
            <!-- Dashboard Ecommerce Starts -->
            <section>
                <div class="row match-height">
                    <div class="col-12">
                        <div class="row match-height">
                            <!-- Earnings Card -->
                            <div class="col-md-4 col-12">
                                <div class="card earnings-card">
                                    <div class="card-header border-bottom">
                                        <h4 class="card-title">Visitors</h4>
                                        <div class="d-flex align-items-center">
                                            <p class="card-text font-small-2 mr-25 mb-0">This Month</p>
                                        </div>
                                    </div>
                                    <div class="card-body mt-2">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="font-small-2">Total</div>
                                                <h5 class="mb-1"><span id="total_visitor_value">0</span></h5>
                                                <div class="font-small-2">
                                                    <div class="d-flex align-items-center mr-2">
                                                        <span class="bullet bullet-success font-small-3 mr-50 cursor-pointer"></span>
                                                        <span>Unique</span>
                                                    </div>
                                                </div>
                                                <h5 class="mb-1"><span id="unique_download_value">0</span></h5>
                                                <div class="font-small-2">
                                                    <div class="d-flex align-items-center mr-2">
                                                        <span class="bullet bullet-info font-small-3 mr-50 cursor-pointer"></span>
                                                        <span>Repeat</span>
                                                    </div>
                                                </div>
                                                <h5 class="mb-1"><span id="repeat_download_value">0</span></h5>
                                            </div>
                                            <div class="col-6">
                                                <div id="visitors-chart"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="card earnings-card">
                                    <div class="card-header border-bottom">
                                        <h4 class="card-title">Earnings</h4>
                                        <div class="d-flex align-items-center">
                                            <p class="card-text font-small-2 mr-25 mb-0">This Month</p>
                                        </div>
                                    </div>
                                    <div class="card-body mt-2">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="font-small-2">
                                                    <div class="d-flex align-items-center mr-2">
                                                        <span class="bullet bullet-success font-small-3 mr-50 cursor-pointer"></span>
                                                        <span>Visitors</span>
                                                    </div>
                                                </div>
                                                <h5 class="mb-1">$<span id="visitor_download_value">0</span></h5>
                                                <div class="font-small-2">
                                                    <div class="d-flex align-items-center mr-2">
                                                        <span class="bullet bullet-info font-small-3 mr-50 cursor-pointer"></span>
                                                        <span>Referrals</span>
                                                    </div>
                                                </div>
                                                <h5 class="mb-1">$<span id="referrals_value">0</span></h5>
                                            </div>
                                            <div class="col-6">
                                                <div id="earningsChart"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="card earnings-card">
                                    <div class="card-header border-bottom">
                                        <h4 class="card-title">Withdraw Request</h4>
                                        <div class="d-flex align-items-center">
                                            <p class="card-text font-small-2 mr-25 mb-0">This Month</p>
                                        </div>
                                    </div>
                                    <div class="card-body mt-2">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="font-small-2">
                                                    <div class="d-flex align-items-center mr-2">
                                                        <span class="bullet bullet-info font-small-3 mr-50 cursor-pointer"></span>
                                                        <span>Processing</span>
                                                    </div>
                                                </div>
                                                <h5 class="mb-1">$<span id="processing_value">0</span></h5>
                                                <div class="font-small-2">
                                                    <div class="d-flex align-items-center mr-2">
                                                        <span class="bullet bullet-success font-small-3 mr-50 cursor-pointer"></span>
                                                        <span>Complete</span>
                                                    </div>
                                                </div>
                                                <h5 class="mb-1">$<span id="complete_value">0</span></h5>
                                                <div class="font-small-2">
                                                    <div class="d-flex align-items-center mr-2">
                                                        <span class="bullet bullet-danger font-small-3 mr-50 cursor-pointer"></span>
                                                        <span> Cancel/Return</span>
                                                    </div>
                                                </div>
                                                <h5 class="mb-1">$<span id="process_failed_value">0</span></h5>
                                            </div>
                                            <div class="col-6">
                                                <div id="withdraw-request-chart"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/ Earnings Card -->
                        </div>
                    </div>
                </div>
            </section>
            <!-- Dashboard Ecommerce ends -->
            <section>
                <div class="row match-height">
                    <div class="col-12">
                        <div class="card card-company-table">
                            <div class="card-header border-bottom">
                                <h4 class="card-title">Visitor Statistics</h4>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table ">

                                        <tbody id="statistics_table_body">

                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row match-height">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header border-bottom">
                                <h4 class="card-title">All Withdrawal Request</h4>
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

@push('script')
<script src="{{asset('app-assets/js/custom/custom_chart_render.js')}}"></script>
<script src="{{asset('app-assets/js/custom/statistics_table.js')}}"></script>
<script src="{{asset('app-assets/vendors/js/pickers/pickadate/picker.js')}}"></script>
<script src="{{asset('app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js')}}"></script>
@include('partials.dataTablesJS')
<script>
    $(document).ready(function() {
        fetch_dashboard_data();
        fetch_statistics_data();

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
                url: "{{$withdrawalRequestUrl}}",
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

    function fetch_dashboard_data() {
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{$dashboardDataUrl}}",
            data: {
                _token: "{{ csrf_token()}}",
                user:"{{$user}}",
            },
            success: function(response) {
                let total_visitor = response.success.data.visitors[0].total_visitor ?? 0;
                let total_payment = response.success.data.visitors[0].total_payment ?? 0;
                let total_unique = response.success.data.visitors[0].total_unique ?? 0;
                let total_refferals = response.success.data.referral_earnings;
                let complete = response.success.data.complete;
                let processing = response.success.data.processing;
                let process_failed = response.success.data.process_failed;

                $("#total_visitor_value").text(digitFormat(total_visitor));
                $("#unique_download_value").text(digitFormat(total_unique));
                $("#repeat_download_value").text(digitFormat(parseInt(total_visitor) - parseInt(total_unique)));
                $("#visitor_download_value").text(digitFormat(parseFloat(total_payment).toFixed(3)));
                $("#referrals_value").text(digitFormat(parseFloat(total_refferals).toFixed(3)));
                $("#complete_value").text(digitFormat(parseFloat(complete).toFixed(3)));
                $("#processing_value").text(digitFormat(parseFloat(processing).toFixed(3)));
                $("#process_failed_value").text(digitFormat(parseFloat(process_failed).toFixed(3)));

                // withdraw chart start ------------------------------------
                let withdraw_request = parseFloat(parseFloat(complete) + parseFloat(processing) + parseFloat(process_failed));

                let withdrawRequestPer = [];
                withdrawRequestPer.push(percentageCalculate(processing, withdraw_request));
                withdrawRequestPer.push(percentageCalculate(complete, withdraw_request));
                withdrawRequestPer.push(percentageCalculate(process_failed, withdraw_request));

                let withdrawRequestChart = document.querySelector('#withdraw-request-chart');
                let withdrawRequestLabels = ['Processing', 'Complete', 'Cancel/Return'];
                let withdrawRequestColors = ['#00CFE8', '#28C76F', '#EA5455'];

                donutChartRender(withdrawRequestChart, withdrawRequestPer, withdrawRequestLabels, withdrawRequestColors);
                // withdraw chart end ------------------------------------

                // download chart start ------------------------------------
                let downloadPer = [];
                downloadPer.push(percentageCalculate(total_unique, total_visitor));
                downloadPer.push((percentageCalculate((total_visitor - total_unique), total_visitor)));
                let downloadChart = document.querySelector('#visitors-chart');
                let downloadLabels = ['Unique', 'Repeat'];
                let downloadColors = ['#28C76F', '#00CFE8'];
                donutChartRender(downloadChart, downloadPer, downloadLabels, downloadColors);
                // download chart end ------------------------------------

                // earning chart start ------------------------------------
                let totalPaymentForVisitor = parseFloat(parseFloat(total_payment) + parseFloat(total_refferals));
                let earningPer = [];
                earningPer.push(percentageCalculate(total_payment, totalPaymentForVisitor));
                earningPer.push(percentageCalculate(total_refferals, totalPaymentForVisitor));
                let earningChart = document.querySelector('#earningsChart');
                let earningLabels = ['Visitors', 'Refferals'];
                let earningColors = ['#28C76F', '#00CFE8'];
                donutChartRender(earningChart, earningPer, earningLabels, earningColors);
                // earning chart end ------------------------------------

            },
            error: function(reject) {

            }
        });
    }

    function fetch_statistics_data() {
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{$statisticsDataUrl}}",
            data: {
                _token: "{{ csrf_token()}}",
                user:"{{$user}}",
            },
            success: function(response) {
                let visitors = response.success.data.visitors;
                let days = response.success.data.days;
                generateStatisticsTableBody(days, visitors);
            },
            error: function(reject) {

            }
        });
    }

    function changeStatus(id) {}
</script>
@endpush