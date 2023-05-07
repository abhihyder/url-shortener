@extends('layouts.master')

@section('title', 'User Lst')

@push('style')
@include('partials.dataTablesCSS')
<link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/plugins/extensions/ext-component-sweet-alerts.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css')}}">
<style>
    .status-badge {
        cursor: pointer;
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
            <section>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header border-bottom">
                                <h4 class="card-title">User List</h4>
                                <div class="d-flex">
                                    <input type="text" id="dateRangeValue" class="form-control flatpickr-range mr-1" placeholder="YYYY-MM-DD to YYYY-MM-DD" />
                                    <button type="button" onclick="userListDatatables()" class="btn btn-primary"><i data-feather='search'></i></button>
                                </div>
                            </div>
                            <div class="card-datatable pb-1 px-2">
                                <table class="table" id="user_list_datatables">
                                    <thead>
                                        <tr>
                                            <th>
                                                <div class="custom-control custom-checkbox"> <input class="custom-control-input dt-checkboxes-all" type="checkbox" value="" id="checkbox-all" /><label class="custom-control-label" for="checkbox-all"></label></div>
                                            </th>
                                            <th>SL</th>
                                            <th>Username</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Plan</th>
                                            <th>Expiration</th>
                                            <th>Login IP</th>
                                            <th>Register IP</th>
                                            <th>Status</th>
                                            <th>Earning Disable</th>
                                            <th>Modified</th>
                                            <th>Created</th>
                                            <th>
                                                <div class="btn-group customBtnGroup">
                                                    <button type="button" class="btn btn-outline-secondary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Bulk Action
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item user_status_active" href="javascript:;">Status Active</a>
                                                        <a class="dropdown-item user_status_inactive" href="javascript:;">Status Inactive</a>
                                                        <a class="dropdown-item user_earning_enable" href="javascript:;">Earning Enable</a>
                                                        <a class="dropdown-item user_earning_disable" href="javascript:;">Earning Disable</a>
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item delete_bulk_user" href="javascript:;">Delete</a>
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
<div class="modal fade text-left" id="editUserModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit User</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form form-vertical" id="editUserForm">
                    @csrf
                    @method("POST")
                    <input type="hidden" id="edit_user_id" name="id">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="first-name-vertical">Name</label>
                                <input type="text" id="edit_user_name" class="form-control" name="name" placeholder="Name">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="contact-info-vertical">Role</label>
                                <select class="select2 form-control" name="role" id="edit_user_role">
                                    <option value="">Select One</option>
                                    @foreach ($roles as $role)
                                    <option value="{{$role->id}}">{{$role->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="contact-info-vertical">Status</label>
                                <select class="select2 form-control" name="status" id="edit_user_status">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="contact-info-vertical">Earning Disable</label>
                                <select class="select2 form-control" name="earning_disable" id="edit_user_earning_disable">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="password-vertical">New Password</label>
                                <input type="text" class="form-control" name="new_password" placeholder="Password">
                                <small class="">Enter new password if want to reset.</small>
                                <br>
                                <small id="new_password-error" class="text-danger"></small>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="submitEditUser">
                    <span class="spinner-border spinner-border-sm d-none" id="spinnerSpan" role="status" aria-hidden="true"></span>
                    <span class="ml-25 align-middle" id="buttonText">Save</span>
                </button>
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
<script src="{{asset('app-assets/vendors/js/forms/select/select2.full.min.js')}}"></script>

<script>
    $(document).ready(function() {
        userListDatatables();
        $('.flatpickr-range').flatpickr({
            mode: 'range'
        });

        $(".select2").select2({
            placeholder: 'Select One',
        })
    })

    function userListDatatables() {
        $('#user_list_datatables').DataTable({
            destroy: true,
            processing: true,
            serverSide: true,
            displayLength: dataTableDisplayLength,
            lengthMenu: dataTableLengthMenu,
            ajax: {
                url: "{{route('admin.user.index')}}",
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
                    data: 'username',
                    name: 'username'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'role_name',
                    name: 'role_name'
                },
                {
                    data: "plan",
                    defaultContent: "Default"
                },
                {
                    data: "expiration",
                    defaultContent: ""
                },
                {
                    data: 'login_ip',
                    name: 'login_ip'
                },
                {
                    data: 'register_ip',
                    name: 'register_ip'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'earning_disable',
                    name: 'earning_disable'
                },

                {
                    data: 'updated_at',
                    name: 'updated_at'
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
            buttons: dataTableButtonsWhenHasAction,
            columnDefs: [{
                targets: '_all',
                defaultContent: 'N/A'
            }],
        });
    }

    $('#user_list_datatables').on('length.dt', function(e, settings, len) {
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

    $(document).on("click", ".delete_bulk_user", function() {
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
                        url: "{{route('admin.user.bulk-delete')}}",
                        data: {
                            user_id: selected_id,
                            _token: "{{ csrf_token()}}"
                        },
                        success: function(response) {
                            $('#user_list_datatables').DataTable().ajax.reload(null, false);
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

    $(document).on("click", ".user_status_active", function() {
        let url = "{{route('admin.user.bulk-change-status')}}";
        let selected_id = get_selected_id()

        if (selected_id.length > 0) {
            bulkChanges(selected_id, 1, url);
        } else {
            toastr['error'](
                "Please select at least one!",
                "Error!", {
                    closeButton: true,
                }
            );
        }
    });

    $(document).on("click", ".user_status_inactive", function() {
        let url = "{{route('admin.user.bulk-change-status')}}";
        let selected_id = get_selected_id()

        if (selected_id.length > 0) {
            bulkChanges(selected_id, 0, url);
        } else {
            toastr['error'](
                "Please select at least one!",
                "Error!", {
                    closeButton: true,
                }
            );
        }

    });

    $(document).on("click", ".user_earning_enable", function() {
        let url = "{{route('admin.user.bulk-earning-enable-disable')}}";
        let selected_id = get_selected_id()

        if (selected_id.length > 0) {
            bulkChanges(selected_id, 0, url);
        } else {
            toastr['error'](
                "Please select at least one!",
                "Error!", {
                    closeButton: true,
                }
            );
        }

    });

    $(document).on("click", ".user_earning_disable", function() {
        let url = "{{route('admin.user.bulk-earning-enable-disable')}}";
        let selected_id = get_selected_id()

        if (selected_id.length > 0) {
            bulkChanges(selected_id, 1, url);
        } else {
            toastr['error'](
                "Please select at least one!",
                "Error!", {
                    closeButton: true,
                }
            );
        }
    });

    function get_selected_id() {
        let selected_id = []
        $('.dt-checkboxes:checkbox').each(function() {
            if (this.checked) {
                selected_id.push($(this).val());
            }
        });
        return selected_id;
    }

    function bulkChanges(user_id, status, url) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You will be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, change it!',
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
                    url: url,
                    data: {
                        user_id: user_id,
                        status: status,
                        _token: "{{ csrf_token()}}"
                    },
                    success: function(response) {
                        $('#user_list_datatables').DataTable().ajax.reload(null, false);
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
    }

    $(document).on("click", ".edit_this_user", function() {
        let id = $(this).data('id');
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{route('admin.user.get-user')}}",
            data: {
                id: id,
                _token: "{{ csrf_token()}}"
            },
            success: function(response) {
                let user = response.success.data;
                $("#edit_user_id").val(user.id);
                $("#edit_user_name").val(user.name);
                $("#edit_user_role").val(user.role_id);
                $("#edit_user_status").val(user.status);
                $("#edit_user_earning_disable").val(user.earning_disable);
                $(".select2").trigger('change');
                $("#editUserModal").modal("show");
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
    });

    $(document).on("click", ".delete_this_file", function() {
        let encrypted_id = $(this).data('id');
        deleteFile(encrypted_id);
    });

    function changeStatus(id, status) {
        let url = "{{route('admin.user.change-status')}}";
        bulkChanges(id, status, url)
    }

    function changeEarningStatus(id, status) {
        let url = "{{route('admin.user.earning-enable-disable')}}";
        bulkChanges(id, status, url);
    }

    $("#submitEditUser").click(function(event) {
        event.preventDefault();
        $('small.text-danger').text(' ');
        $('#spinnerSpan').removeClass('d-none');
        $('#buttonText').text('Processing...');
        $(this).attr('disabled', true);
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{route('admin.user.update')}}",
            data: $("#editUserForm").serialize(),
            success: function(response) {
                toastr['success'](
                    'User updated successfully!',
                    'Success!', {
                        closeButton: true,
                    }
                );
                $('#spinnerSpan').addClass('d-none');
                $('#buttonText').text('Save');
                $("#submitEditUser").attr('disabled', false);
                $("#editUserModal").modal("hide");
                $('#user_list_datatables').DataTable().ajax.reload(null, false);
            },
            error: function(reject) {
                $('#spinnerSpan').addClass('d-none');
                $('#buttonText').text('Save');
                $("#submitEditUser").attr('disabled', false);
                let errors = $.parseJSON(reject.responseText);
                if (reject.status === 422 || reject.status === 403) {

                    $.each(errors.error.message, function(key, val) {
                        $("small#" + key + "-error").text(val[0]);
                    });
                }
                toastr['error'](
                    "Something went wrong!",
                    "Oops!!!", {
                        closeButton: true,
                    }
                );
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
                        $('#user_list_datatables').DataTable().ajax.reload(null, false);
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