@extends('layouts.master')

@section('title', 'Manage File')

@push('style')
@include('partials.dataTablesCSS')
<link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/plugins/extensions/ext-component-sweet-alerts.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css')}}">
<style>
    .fileName {
        text-overflow: ellipsis;
        white-space: nowrap;
        overflow: hidden;
        max-width: 180px;
    }

    .fileLink{
        min-width: 140px;
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

            <section>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header border-bottom">
                                <h4 class="card-title">Manage File</h4>
                                <div class="d-flex">
                                    <input type="text" id="dateRangeValue" class="form-control flatpickr-range mr-1" placeholder="YYYY-MM-DD to YYYY-MM-DD" />
                                    <button type="button" onclick="fileListDatatables()" class="btn btn-primary"><i data-feather='search'></i></button>
                                </div>
                            </div>
                            <div class="card-datatable pb-1 px-2">
                                <table class="table" id="file_list_datatables">
                                    <thead>
                                        <tr>
                                            <th>
                                                <div class="custom-control custom-checkbox"> <input class="custom-control-input dt-checkboxes-all" type="checkbox" value="" id="checkbox-all" /><label class="custom-control-label" for="checkbox-all"></label></div>
                                            </th>
                                            <th>SL</th>
                                            <th>File Name</th>
                                            <th>Link</th>
                                            <th>Username</th>
                                            <th>Created</th>
                                            <th>
                                                <div class="btn-group customBtnGroup">
                                                    <button type="button" class="btn btn-outline-secondary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                       Bulk Action
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item delete_all_file" href="javascript:;">Bulk Delete</a>
                                                    </div>
                                                </div>
                                            </th>
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
<div class="modal fade text-left" id="editFileModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Rename File</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editFileForm">
                    @csrf
                    @method("POST")
                    <input type="hidden" id="edit_file_id" name="file_id">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <input type="text" class="form-control" id="edit_file_name" name="name" placeholder="Enter folder name" required>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="submitEditFile">Rename</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')
@include('partials.dataTablesJS')

<script src="{{asset('app-assets/vendors/js/pickers/pickadate/picker.js')}}"></script>
<script src="{{asset('app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js')}}"></script>
<script src="{{asset('app-assets/vendors/js/extensions/sweetalert2.all.min.js')}}"></script>
<script>
    $(document).ready(function() {
        fileListDatatables();
        $('.flatpickr-range').flatpickr({
            mode: 'range'
        });
    })

    function fileListDatatables() {
        $('#file_list_datatables').DataTable({
            destroy: true,
            processing: true,
            serverSide: true,
            displayLength: dataTableDisplayLength,
            lengthMenu: dataTableLengthMenu,
            ajax: {
                url: "{{route('admin.file.manage')}}",
                type: "GET",
                data: {
                    date_range: $("#dateRangeValue").val()
                }
            },
            columns: [{
                    data: 'checkbox',
                    name: 'checkbox',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'name',
                    name: 'name',
                    className: 'fileName'
                },
                {
                    data: 'link',
                    name: 'link', 
                    className: 'fileLink'
                },
                {
                    data: 'username',
                    name: 'username'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
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
            buttons: dataTableButtons,
            columnDefs: [{
                targets: '_all',
                defaultContent: 'N/A'
            }],
        });
    }

    $('#file_list_datatables').on('length.dt', function(e, settings, len) {
        localStorage.setItem("datatable_length", len);
    });

    $(document).on("change", ".dt-checkboxes-all", function() {
        if (this.checked) {
            // Iterate each checkbox
            $('.dt-checkboxes:checkbox').each(function() {
                this.checked = true;
            });
        } else {
            $('.dt-checkboxes:checkbox').each(function() {
                this.checked = false;
            });
        }

    });

    $(document).on("click", ".delete_all_file", function() {
        let selected_id = []
        $('.dt-checkboxes:checkbox').each(function() {
            if (this.checked) {
                selected_id.push($(this).val());
            }
        });

        if (selected_id.length > 0) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-outline-danger ml-1'
                },
                buttonsStyling: false
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "{{route('admin.file.bulk-delete')}}",
                        data: {
                            file_id: selected_id,
                            _token: "{{ csrf_token()}}"
                        },
                        success: function(response) {
                            $('#file_list_datatables').DataTable().ajax.reload(null, false);
                        },
                        error: function(reject) {
                            toastr['error'](
                                "Something went wrong!",
                                "Oops!!!", {
                                    closeButton: true,
                                }
                            );
                        }
                    });
                }
            });
        } else {
            toastr['error'](
                "Please select at least one!",
                "Error!!!", {
                    closeButton: true,
                }
            );
        }

    });

    $(document).on("click", ".copyLinkToClipBoard", function() {
        let link = $(this).data('link');
        copyToClipboard(link);
    });

    $(document).on("click", ".edit_file_name", function() {
        let encrypted_id = $(this).data('id');
        let name = $(this).data('name');
        renameFile(encrypted_id, name);
    });

    $(document).on("click", ".delete_this_file", function() {
        let encrypted_id = $(this).data('id');
        deleteFile(encrypted_id);
    });

    function renameFile(encrypted_id, name) {
        $("#edit_file_id").val(encrypted_id);
        $("#edit_file_name").val(name);
        $("#editFileModal").modal("show");
    }

    $("#submitEditFile").click(function(event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{route('admin.file.update')}}",
            data: $("#editFileForm").serialize(),
            success: function(response) {
                $("#editFileModal").modal("hide");
                $('#file_list_datatables').DataTable().ajax.reload(null, false);
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

    function deleteFile(encrypted_id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            customClass: {
                confirmButton: 'btn btn-primary',
                cancelButton: 'btn btn-outline-danger ml-1'
            },
            buttonsStyling: false
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{route('admin.file.delete')}}",
                    data: {
                        file_id: encrypted_id,
                        _token: "{{ csrf_token()}}"
                    },
                    success: function(response) {
                        $('#file_list_datatables').DataTable().ajax.reload(null, false);
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
            }
        });
    }
</script>
@endpush