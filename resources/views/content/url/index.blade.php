@extends('layouts.master')

@section('title', 'Shorten URL')

@push('style')
<link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css')}}">
@include('partials.dataTablesCSS')
<style>
    .ellipsis-row {
        text-overflow: ellipsis;
        white-space: nowrap;
        overflow: hidden;
        max-width: 140px;
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
        <div class="content-body" style="display:flex">
            @include('partials.message')
            <section>
                <div class="row match-height">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-header border-bottom">
                                <h4 class="card-title">All Shorten URL</h4>
                                <div class="d-flex">
                                    <button type="button" onclick="createShortenUrl()" class="btn btn-primary"><i data-feather='link'></i> Create Shorten</button>
                                </div>
                            </div>
                            <div class="card-datatable pb-1 px-2">
                                <table class="table" id="shorten_url_datatables">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>QR Code</th>
                                            <th>Name</th>
                                            <th>Url</th>
                                            <th>Shorten Url</th>
                                            <th>Access Key</th>
                                            <th>Expire At</th>
                                            <th>Created At</th>
                                            <th>Visitors</th>
                                            <th>Status</th>
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
<div class="modal fade text-left" id="newShortenerModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title shortenModalTitle">Create Shorten URL</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form form-vertical" id="createShortenForm">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="id">
                    <div class="form-group">
                        <label class="form-label" for="name">Name <span>*</span></label>
                        <input class="form-control " type="text" name="name" placeholder="John Doe" aria-describedby="name" autofocus="" tabindex="1" />
                        <small id="name-error" class="text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="url">URL <span>*</span></label>
                        <input class="form-control " type="url" name="url" placeholder="https://example.com/hello-world" aria-describedby="email" tabindex="2" />
                        <small id="url-error" class="text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="username">Access Code</label>
                        <input class="form-control " type="text" name="access_code" placeholder="1a2b3c4d" aria-describedby="username" tabindex="1" />
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="username">Expire Date</label>
                        <input class="form-control date-picker" id="expire_date" type="text" name="expire_date" placeholder="20-04-2023" aria-describedby="username" tabindex="1" />
                    </div>

                    <div class="form-group">
                        <label for="contact-info-vertical">Status</label>
                        <select class="select2 form-control" name="status">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                        <small id="status-error" class="text-danger"></small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" data-rel="store" id="submitCreateShortenForm">Create</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="{{asset('app-assets/vendors/js/pickers/pickadate/picker.js')}}"></script>
<script src="{{asset('app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js')}}"></script>
<script src="{{asset('app-assets/vendors/js/moment/moment.js')}}"></script>
@include('partials.dataTablesJS')
<script>
    $(document).ready(function() {
        shortenUrlDatatables();
        $('.flatpickr-range').flatpickr({
            mode: 'range'
        });
    })

    function shortenUrlDatatables() {
        $('#shorten_url_datatables').DataTable({
            destroy: true,
            processing: true,
            serverSide: true,
            displayLength: dataTableDisplayLength,
            lengthMenu: dataTableLengthMenu,
            ajax: {
                url: "{{route('shorten-url.index')}}",
                type: "GET",
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'qr_code_path',
                    name: 'qr_code_path'
                },
                {
                    data: 'name',
                    name: 'name',
                    className:'ellipsis-row'
                },
                {
                    data: 'url',
                    name: 'url',
                    className:'ellipsis-row'
                },
                {
                    data: 'url_code',
                    name: 'url_code'
                },
                {
                    data: 'access_code',
                    name: 'access_code'
                },
                {
                    data: 'expire_date',
                    name: 'expire_date'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'total_visitor',
                    name: 'total_visitor'
                },
                {
                    data: 'status',
                    name: 'status'
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
    }

    $('#shorten_url_datatables').on('length.dt', function(e, settings, len) {
        localStorage.setItem("datatable_length", len);
    });

    $("#submitCreateShortenForm").click(function(event) {
        event.preventDefault();
        let storeUrl = "{{route('shorten-url.store')}}";
        let updateUrl = "{{route('shorten-url.update')}}";
        $("small.text-danger").text('');
        $.ajax({
            type: "POST",
            dataType: "json",
            url: $(this).data('rel') == "store" ? storeUrl : updateUrl,
            data: $("#createShortenForm").serialize(),
            success: function(response) {
                $('#createShortenForm')[0].reset();
                $('.select2').trigger('change');
                $('#newShortenerModal').modal('hide');
                shortenUrlDatatables();
            },
            error: function(reject) {
                let error = $.parseJSON(reject.responseText);
                if (reject.status === 422 || reject.status === 403) {

                    $.each(error.message, function(key, val) {
                        $("small#" + key + "-error").text(val[0]);
                    });
                } else {}
            }
        });
    });

    function createShortenUrl() {
        $('.shortenModalTitle').text('Create Shorten URL');
        $('#createShortenForm')[0].reset();
        $('.select2').trigger('change');
        $('#submitCreateShortenForm').data('rel', 'store');
        $('#newShortenerModal').modal('show');
    }

    function editShorten(id) {
        $("small.text-danger").text('');
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "{{url('shorten-url')}}/" + id,
            success: function(response) {
                let data = response.data;
                for (const key in data) {
                    let value = data[key];
                    if (key == 'expire_date' && value) value = moment(value).format('DD-MM-YYYY');
                    $("#createShortenForm").find("[name='" + key + "']").val(value);
                }
                $('.shortenModalTitle').text('Edit Shorten URL');
                $('.select2').trigger('change');
                $('#submitCreateShortenForm').data('rel', 'update');
                $('#newShortenerModal').modal('show');
            },
            error: function(reject) {

            }
        });
    }

    $(document).on("click", ".copyLinkToClipBoard", function() {
        let link = $(this).data('link');
        copyToClipboard(link);
    });

    function changeStatus(id) {}
</script>
@endpush