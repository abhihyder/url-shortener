@extends('layouts.master')

@section('title', 'Visitors')

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
        <div class="content-body">
            @include('partials.message')
            <section>
                <div class="row match-height">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header border-bottom">
                                <h4 class="card-title">Visitors</h4>
                            </div>
                            <div class="card-datatable pb-1 px-2">
                                <table class="table" id="visitor_datatables">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Name</th>
                                            <th>Url</th>
                                            <th>Shorten Url</th>
                                            <th>IP</th>
                                            <th>OS</th>
                                            <th>Browser</th>
                                            <th>Unique</th>
                                            <th>Payment</th>
                                            <th>Created At</th>
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
                        <input class="form-control " type="text" name="url" placeholder="https://example.com/hello-world" aria-describedby="email" tabindex="2" />
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
        visitorDatatables();
        $('.flatpickr-range').flatpickr({
            mode: 'range'
        });
    })

    function visitorDatatables() {
        $('#visitor_datatables').DataTable({
            destroy: true,
            processing: true,
            serverSide: true,
            displayLength: dataTableDisplayLength,
            lengthMenu: dataTableLengthMenu,
            ajax: {
                url: "{{route('visitor.index')}}",
                type: "GET",
                data: {
                    shorten_url_id: '{{$shorten_url_id}}',
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'url_name',
                    name: 'url_name',
                    className: 'ellipsis-row'
                },
                {
                    data: 'url',
                    name: 'url',
                    className: 'ellipsis-row'
                },
                {
                    data: 'url_code',
                    name: 'url_code'
                },
                {
                    data: 'ip',
                    name: 'ip'
                },
                {
                    data: 'os',
                    name: 'os'
                },
                {
                    data: 'browser',
                    name: 'browser'
                },
                {
                    data: 'is_unique',
                    name: 'is_unique'
                },
                {
                    data: 'payment',
                    name: 'payment'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                }
            ],
            dom: dataTableDom,
            buttons: dataTableButtons,
            columnDefs: [{
                targets: '_all',
                defaultContent: 'N/A'
            }],
        });
    }

    $('#visitor_datatables').on('length.dt', function(e, settings, len) {
        localStorage.setItem("datatable_length", len);
    });
</script>
@endpush