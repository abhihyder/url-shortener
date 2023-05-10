@extends('layouts.master')

@section('title', 'Statistics')

@push('style')
<link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/pages/dashboard-ecommerce.css')}}">

@endpush

@section('content')
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <!-- Dashboard Ecommerce Starts -->
            <section id="dashboard-ecommerce">
                <div class="row match-height">
                    <!-- Statistics Card -->
                    <div class="col-12">
                        <div class="card card-statistics">
                            <div class="card-header">
                                <h4 class="card-title">Statistics</h4>
                                <div class="d-flex align-items-center">
                                    <!-- <p class="card-text font-small-2 mr-25 mb-0">Updated 1 month ago</p> -->
                                </div>
                            </div>
                            <div class="card-body statistics-body">
                                <div class="row">
                                    <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-0">
                                        <div class="media">
                                            <div class="avatar bg-light-primary mr-2">
                                                <div class="avatar-content">
                                                    <i data-feather="link" class="avatar-icon"></i>
                                                </div>
                                            </div>
                                            <div class="media-body my-auto">
                                                <h4 class="font-weight-bolder mb-0"><span id="unique_visitors">0</span></h4>
                                                <h6 class="font-weight-bolder mt-1">Unique Visitor</h6>
                                                <p class="card-text font-small-3 mb-0">This Month</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-0">
                                        <div class="media">
                                            <div class="avatar bg-light-info mr-2">
                                                <div class="avatar-content">
                                                    <i data-feather="dollar-sign" class="avatar-icon"></i>
                                                </div>
                                            </div>
                                            <div class="media-body my-auto">
                                                <h4 class="font-weight-bolder mb-0">$<span id="current_balance">0</span></h4>
                                                <h6 class="font-weight-bolder mt-1">Balance</h6>
                                                <p class="card-text font-small-3 mb-0">Available</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-sm-0">
                                        <div class="media">
                                            <div class="avatar bg-light-danger mr-2">
                                                <div class="avatar-content">
                                                    <i data-feather="dollar-sign" class="avatar-icon"></i>
                                                </div>
                                            </div>
                                            <div class="media-body my-auto">
                                                <h4 class="font-weight-bolder mb-0">$<span id="withdraw_processing">0</span></h4>
                                                <h6 class="font-weight-bolder mt-1">Withdraw</h6>
                                                <p class="card-text font-small-3 mb-0">Processing</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-sm-6 col-12">
                                        <div class="media">
                                            <div class="avatar bg-light-success mr-2">
                                                <div class="avatar-content">
                                                    <i data-feather="dollar-sign" class="avatar-icon"></i>
                                                </div>
                                            </div>
                                            <div class="media-body my-auto">
                                                <h4 class="font-weight-bolder mb-0">$<span id="total_earning">0</span></h4>
                                                <h6 class="font-weight-bolder mt-1">Earning</h6>
                                                <p class="card-text font-small-3 mb-0">Total</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ Statistics Card -->
                </div>

                <div class="row match-height">
                    <!-- Company Table Card -->
                    <div class="col-12">
                        <div class="card card-company-table">
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
                    <!--/ Company Table Card -->

                </div>
            </section>
            <!-- Dashboard Ecommerce ends -->

        </div>
    </div>
</div>
@endsection

@push('script')
<script src="{{asset('app-assets/js/custom/statistics_table.js')}}"></script>
<script>
    var day_list;
    $(document).ready(function() {
        fetch_statistics_data();
    });

    function fetch_statistics_data() {
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{route('user.statistics-data')}}",
            data: {
                _token: "{{ csrf_token()}}"
            },
            success: function(response) {
                let visitors = response.data.visitors;
                let days = response.data.days;
                let wallet = response.data.wallet;
                let processing_request = response.data.processing_request;
                if (wallet) {
                    let earning = parseFloat(parseFloat(wallet.available_balance) + parseFloat(wallet.total_withdraw) + parseFloat(processing_request)).toFixed(4)
                    $("#current_balance").text(digitFormat(parseFloat(wallet.available_balance).toFixed(4)));
                    $("#withdraw_processing").text(digitFormat(parseFloat(processing_request).toFixed(4)));
                    $("#total_earning").text(digitFormat(earning));
                }
                generateStatisticsTableBody(days, visitors);
            },
            error: function(reject) {

            }
        });
    }

</script>
@endpush