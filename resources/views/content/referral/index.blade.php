@extends('layouts.master')

@section('title', 'Referred User')

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
            <section>

                @php $author = Auth::user(); @endphp
                <div class="row">
                    <div class="col-12 col-md-6">
                        <section id="multiple-column-form">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header border-bottom">
                                            <h4 class="card-title">Referrer Link</h4>
                                        </div>
                                        <div class="card-body mt-2">
                                            <div class="form">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" id="referrer_link" value="{{route('register')}}?ref={{$author->username}}" readonly />
                                                        </div>
                                                    </div>

                                                    <div class="col-12">
                                                        <button class="btn btn-primary" type="button" id="CopyReferrerLinkToClipBoard">Copy</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                    <div class="col-12 col-md-6">
                        <section id="multiple-column-form">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header border-bottom">
                                            <h4 class="card-title">Referrer Code</h4>
                                        </div>
                                        <div class="card-body mt-2">
                                            <div class="form">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" id="referrer_code" value="{{$author->username}}" readonly />
                                                        </div>
                                                    </div>

                                                    <div class="col-12">
                                                        <button class="btn btn-primary" type="button" id="CopyReferrerCodeToClipBoard">Copy</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
                <div class="row match-height">
                    <div class="col-12">
                        <div class="row match-height">
                            <!-- Earnings Card -->
                            <div class="col-md-6 col-12">
                                <div class="card">
                                    <div class="card-header border-bottom">
                                        <h4 class="card-title">Banner Link</h4>
                                    </div>
                                    <div class="card-body mt-2">
                                        <div class="form">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>Banner Name</label>
                                                        <select id="banner_name_list" class="form-control select2">
                                                            @foreach($banners as $banner)
                                                            <option value="{{$banner->id}}">{{$banner->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <textarea class="form-control" id="banner_link" cols="30" rows="10" readonly>

                                                            </textarea>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <button class="btn btn-primary" type="button" id="CopyBannerLinkToClipBoard">Copy</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="card">
                                    <div class="card-header border-bottom">
                                        <h4 class="card-title">Banner Preview</h4>
                                    </div>
                                    <div class="card-body mt-2">
                                        <div class="form">
                                            <input type="hidden" id="baseUrl" value="{{route('home')}}/">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <img src="{{asset('app-assets/images/banner/default.jpg')}}" id="banner-preview-img" class="rounded mr-50" alt="banner image" height="140" onerror="this.onerror=null;this.src='{{asset('app-assets/images/banner/default.jpg')}}';" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
             
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header border-bottom">
                                <h4 class="card-title">Referred User</h4>
                                <div class="d-flex">
                                    <input type="text" id="dateRangeValue" class="form-control flatpickr-range mr-1" placeholder="YYYY-MM-DD to YYYY-MM-DD" />
                                    <button type="button" onclick="referredUserDatatables()" class="btn btn-primary"><i data-feather='search'></i></button>
                                </div>
                            </div>
                            <div class="card-datatable pb-1  px-2">
                                <table class="table" id="referred_user_datatables">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Username</th>
                                            <th>Earning Disable</th>
                                            <th>Created</th>
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
    var banner_list = @json($banners);
    var banner_img_list = [];
    var banner_img_width = [];
    var banner_img_height = [];
    var baseUrl = $('#baseUrl').val();
    var referrer_link = "{{route('register')}}?ref={{$author->username}}";
    var defaultBanner = "{{asset('app-assets/images/banner/default.jpg')}}";
    $(document).ready(function() {
        referredUserDatatables();
        $('.flatpickr-range').flatpickr({
            mode: 'range'
        });
        $(".select2").select2({
            placeholder: 'Select One',
        })

        $('#banner_link').text('<!-- Banner Start -->\n<a href="' + referrer_link + '">\n<img src="' + defaultBanner + '"/>\n</a>\n<!-- Banner End -->');

        $.each(banner_list, function(key, banner) {
            banner_img_list[banner.id] = banner.file_path;
            banner_img_width[banner.id] = banner.width;
            banner_img_height[banner.id] = banner.height;
            if (key == 0) {
                $('#banner-preview-img').attr('src', baseUrl + banner.file_path);
                $('#banner-preview-img').css({
                    width: banner.width,
                    height: banner.height
                });
                $('#banner_link').text('<!-- Banner Start -->\n<a href="' + referrer_link + '">\n<img style="width: ' + banner.width + '; height: ' + banner.height + '" src="' + baseUrl + banner.file_path + '" onerror="this.onerror=null;this.src=\'' + defaultBanner + '\'"/>\n</a>\n<!-- Banner End -->');
            }
        });
    })

    function referredUserDatatables() {
        $('#referred_user_datatables').DataTable({
            destroy: true,
            processing: true,
            serverSide: true,
            displayLength: dataTableDisplayLength,
            lengthMenu: dataTableLengthMenu,
            ajax: {
                url: "{{route('referral.index')}}",
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
                    data: 'username',
                    name: 'username'
                },
                {
                    data: 'earning_disable',
                    name: 'earning_disable'
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

    $('#referred_user_datatables').on('length.dt', function(e, settings, len) {
        localStorage.setItem("datatable_length", len);
    });

    $('#banner_name_list').on('change', function(e) {
        e.preventDefault();
        let banner_id = $(this).val();
        $('#banner-preview-img').attr('src', baseUrl + banner_img_list[banner_id]);
        $('#banner-preview-img').css({
            width: banner_img_width[banner_id],
            height: banner_img_height[banner_id]
        });
        $('#banner_link').text('<!-- Banner Start -->\n<a href="' + referrer_link + '">\n<img style="width: ' + banner_img_width[banner_id] + '; height: ' + banner_img_height[banner_id] + '" src="' + baseUrl + banner_img_list[banner_id] + '" onerror="this.onerror=null;this.src=\'' + defaultBanner + '\'"/>\n</a>\n<!-- Banner End -->');
    });

    $("#CopyReferrerLinkToClipBoard").click(function() {
        let link = $("#referrer_link").val();
        copyToClipboard(link);
    });

    $("#CopyReferrerCodeToClipBoard").click(function() {
        let link = $("#referrer_code").val();
        copyToClipboard(link);
    });
    $("#CopyBannerLinkToClipBoard").click(function() {
        let link = $("#banner_link").text();
        copyToClipboard(link);
    });
</script>
@endpush