@extends('layouts.master')

@section('title', 'Banner')

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
                                <h4 class="card-title">Banner List</h4>
                                <div class="d-flex">
                                    <button type="button" class="btn btn-primary" onclick="addBanner()">Add Banner</button>
                                </div>
                            </div>
                            <div class="card-datatable pb-1  px-2">
                                <table class="table" id="banner_datatables">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Banner</th>
                                            <th>Name</th>
                                            <th>Created</th>
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
<div class="modal fade text-left" id="addBannerModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="addBannerModalTitle">Add Banner</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addBannerForm">
                @csrf
                @method('POST')
                <input type="hidden" id="baseUrl" value="{{route('home')}}/">
                <input type="hidden" id="bannerFormType" name="form_type" value="store">
                <input type="hidden" id="banner_id" name="banner_id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>Banner Name</label>
                                <input type="text" placeholder="Banner Name" id="banner_name" class="form-control" name="banner_name" />
                                <small id="banner_name-error" class="text-danger"></small>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>Width</label>
                                <input type="text" placeholder="200px" id="width" class="form-control" name="width" />
                                <small id="width-error" class="text-danger"></small>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>Height</label>
                                <input type="text" placeholder="100px" id="height" class="form-control" name="height" />
                                <small id="height-error" class="text-danger"></small>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>Banner Image</label>
                                <div class="media">
                                    <a href="javascript:void(0);" class="mr-25">

                                        <img src="{{asset('app-assets/images/banner/dark_white.jpg')}}" id="banner-upload-img" class="rounded mr-50" alt="banner image" height="100" />
                                    </a>
                                    <!-- upload and reset button -->
                                    <div class="media-body mt-75 ml-1">
                                        <label for="banner-upload" class="btn btn-sm btn-primary mb-75 mr-75">Upload</label>
                                        <input type="file" name="banner" id="banner-upload" hidden accept="image/*" />
                                        <p>Allowed JPG, JPEG or PNG. Max size of 1000KB</p>
                                    </div>
                                </div>
                                <small id="banner-error" class="text-danger"></small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="submitBannerForm">
                        <span class="spinner-border spinner-border-sm d-none" id="spinnerSpan" role="status" aria-hidden="true"></span>
                        <span class="ml-25 align-middle" id="buttonText">Save</span>
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

@endsection

@push('script')
@include('partials.dataTablesJS')
<script>
    var banner_datatables;
    var baseUrl = $('#baseUrl').val();
    $(document).ready(function() {
        $('#banner-upload').change(function() {
            let reader = new FileReader();
            reader.onload = (e) => {
                $('#banner-upload-img').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        });
        bannerDatatables();
    })

    function bannerDatatables() {
        banner_datatables = $('#banner_datatables').DataTable({
            destroy: true,
            processing: true,
            serverSide: true,
            displayLength: dataTableDisplayLength,
            lengthMenu: dataTableLengthMenu,
            ajax: {
                url: "{{route('banner.index')}}",
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
                    data: 'banner_img',
                    name: 'banner_img'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
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

    function addBanner() {
        $("#addBannerModal").modal("show");
    }

    $('#banner_datatables').on('length.dt', function(e, settings, len) {
        localStorage.setItem("datatable_length", len);
    });

    $("#addBannerForm").submit(function(event) {
        event.preventDefault();
        let bannerFormType = $('#bannerFormType').val();

        $('.text-danger').text(' ');
        $('#spinnerSpan').removeClass('d-none');
        $('#buttonText').text('Saving...');
        $("#submitBannerForm").attr('disabled', true);
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{route('banner.store')}}",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                $('#spinnerSpan').addClass('d-none');
                $('#buttonText').text('Save');
                $("#submitBannerForm").attr('disabled', false);
                $("#addBannerModal").modal("hide");
                if (bannerFormType == 'store') {
                    $('#banner_datatables').DataTable().ajax.reload();
                } else {
                    $('#banner_datatables').DataTable().ajax.reload(null, false);
                }
            },
            error: function(reject) {
                let errors = $.parseJSON(reject.responseText);
                if (reject.status === 422 || reject.status === 403) {

                    $.each(errors.message, function(key, val) {
                        $("small#" + key + "-error").text(val[0]);
                    });
                } else if (reject.status === 400) {
                    $('#banner_name-error').text(errors.error.message);
                }
                $('#spinnerSpan').addClass('d-none');
                $('#buttonText').text('Save');
                $("#submitBannerForm").attr('disabled', false);
            }
        });
    });

    $(document).on("click", ".edit_banner_data", function() {
        let tr = $(this).closest('tr');
        let row = banner_datatables.row(tr);
        $("#addBannerModalTitle").text("Edit Banner");
        $('#bannerFormType').val('update');
        $('#banner_id').val(row.data().id);
        $('#banner_name').val(row.data().name);
        $('#width').val(row.data().width);
        $('#height').val(row.data().height);
        $('#banner-upload-img').attr('src', baseUrl + row.data().file_path);
        $("#addBannerModal").modal("show");
    });

    $('#addBannerModal').on('hidden.bs.modal', function() {
        $("#addBannerModalTitle").text("Add Banner");
        $('.text-danger').text(' ');
        $('#bannerFormType').val('store');
        $('#banner_id').val('');
        $('#banner_name').val('');
        $('#banner-upload-img').attr("src", "{{asset('app-assets/images/banner/dark_white.jpg')}}");
    })
</script>
@endpush