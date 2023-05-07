@extends('layouts.master')

@section('title', 'File')

@push('style')
<link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/plugins/extensions/ext-component-sweet-alerts.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/pages/app-file-manager.css')}}">
@endpush
@isset($folder_id)
@section('folder_id')
{{$folder_id}}
@endsection
@endisset
@section('content')
<div class="app-content content file-manager-application">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    @include('partials.message')
    <div class="content-area-wrapper container-xxl p-0">

        <div class="content-right" style="width:100%">
            <div class="content-wrapper container-xxl p-0">
                <div class="content-header row">
                </div>
                <div class="content-body">
                    <!-- overlay container -->
                    <div class="body-content-overlay"></div>

                    <!-- file manager app content starts -->
                    <div class="file-manager-main-content">
                        <!-- search area start -->
                        <div class="file-manager-content-header d-flex justify-content-start align-items-center">
                            <div class="d-flex align-items-center" style="width:100%">

                                <div class="input-group input-group-merge shadow-none m-0 flex-grow-1">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text border-0">
                                            <i data-feather="search"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control files-filter border-0 bg-transparent" placeholder="Search" />
                                </div>
                            </div>
                        </div>
                        <div class="file-manager-content-header d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <div class="row breadcrumbs-top">
                                    <div class="col-12">
                                        <div class="breadcrumb-wrapper">
                                            <ol class="breadcrumb">
                                                @isset($parent_folder)
                                                <li class="breadcrumb-item"><a href="{{route('file.index') }}">My Drive</a>
                                                </li>
                                                @php $last_index = array_key_last($parent_folder); @endphp
                                                @foreach($parent_folder as $key=>$folder)
                                                @if($key==$last_index)
                                                <li class="breadcrumb-item active">{{$folder['name']}}
                                                </li>
                                                @else
                                                <li class="breadcrumb-item"><a href="{{route('folder.index',encrypted_value($folder['id']))}}">{{$folder['name']}}</a>
                                                </li>
                                                @endif
                                                @endforeach
                                                @else
                                                <li class="breadcrumb-item active">My Drive
                                                </li>
                                                @endisset
                                            </ol>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="file-actions custom-font-size">
                                    <div class="dropdown d-inline-block">
                                        <i class="font-medium-2 cursor-pointer" data-feather="more-vertical" role="button" id="fileActions" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        </i>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="fileActions">

                                            <a class="dropdown-item" href="javascript:;" onclick="moveMultipleFile()">
                                                <i data-feather="folder-plus" class="cursor-pointer mr-50"></i>
                                                <span class="align-middle">Move</span>
                                            </a>
                                            <a class="dropdown-item" href="javascript:;" onclick="deleteMultipleFile()">
                                                <i data-feather="trash" class="cursor-pointer mr-50"></i>
                                                <span class="align-middle">Delete</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="btn-group btn-group-toggle view-toggle ml-50  custom-font-size" data-toggle="buttons">
                                    <div class="mb-0 create-folder-button">
                                        <i data-feather="folder-plus" class="mr-25 cursor-pointer "></i>
                                    </div>
                                </div>
                                <div class="btn-group btn-group-toggle view-toggle ml-50" data-toggle="buttons">
                                    <label class="btn btn-outline-primary p-50 btn-sm active">
                                        <input type="radio" name="view-btn-radio" data-view="grid" checked />
                                        <i data-feather="grid"></i>
                                    </label>
                                    <label class="btn btn-outline-primary p-50 btn-sm">
                                        <input type="radio" name="view-btn-radio" data-view="list" />
                                        <i data-feather="list"></i>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <!-- search area ends here -->

                        <div class="file-manager-content-body">


                            <!-- Folders Container Starts -->
                            <div class="view-container">
                                <h6 class="files-section-title mt-25 mb-75">Folders</h6>
                                <div class="files-header">
                                    <h6 class="font-weight-bold mb-0">Filename</h6>
                                    <div>
                                        <h6 class="font-weight-bold file-item-size d-inline-block mb-0">Size</h6>
                                        <h6 class="font-weight-bold file-last-modified d-inline-block mb-0">Last modified</h6>
                                        <h6 class="font-weight-bold d-inline-block mr-1 mb-0">Actions</h6>
                                    </div>
                                </div>
                                @php $i=0; @endphp
                                @if(count($folders)>0)
                                @foreach ($folders as $folder)
                                <div class="card file-manager-item folder folder-container" ondblclick="openFolder('{{$i}}')">
                                    <div class="custom-control custom-checkbox">
                                        <!-- <input type="checkbox" class="custom-control-input" id="customCheckFolder{{$i}}" /> -->
                                        <input type="hidden" id="encryptedFolderUrl{{$i}}" value="{{route('folder.index',encrypted_value($folder->id))}}">
                                        <!-- <label class="custom-control-label" for="customCheckFolder{{$i}}"></label> -->
                                    </div>
                                    <div class="card-img-top file-logo-wrapper custom-font-size">
                                        <div class="dropdown float-right folder-options" style="opacity: 0">

                                            <div class="dropdown d-inline-block">
                                                <i class="font-medium-2 cursor-pointer" data-feather="more-vertical" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                </i>
                                                <div class="dropdown-menu dropdown-menu-right">

                                                    <a class="dropdown-item" href="{{route('folder.index',encrypted_value($folder->id))}}">
                                                        <i data-feather="folder" class="cursor-pointer mr-50"></i>
                                                        <span class="align-middle">Open folder</span>
                                                    </a>
                                                    <a class="dropdown-item" href="javascript:;" onclick="moveFolder('{{encrypted_value($folder->id)}}')">
                                                        <i data-feather="folder-plus" class="cursor-pointer mr-50"></i>
                                                        <span class="align-middle">Move to</span>
                                                    </a>
                                                    <a class="dropdown-item" href="javascript:;" onclick="renameFolder('{{encrypted_value($folder->id)}}', '{{$folder->name}}')">
                                                        <i data-feather="edit" class="align-middle mr-50"></i>
                                                        <span class="align-middle">Rename</span>
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item" href="javascript:;" onclick="deleteFolder('{{encrypted_value($folder->id)}}')">
                                                        <i data-feather="trash" class="align-middle mr-50"></i>
                                                        <span class="align-middle">Delete</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-center w-100">
                                            <i data-feather="folder" style="height: 32px !important; width: 32px !important;"></i>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="content-wrapper">
                                            <p class="card-text file-name mb-0" title="{{$folder->name}}">{{$folder->name}}</p>
                                            <p class="card-text file-size mb-0">{{formatFileSizeUnits($folder->file_size)}}</p>
                                            <p class="card-text file-date">{{date('d M Y', strtotime($folder->updated_at))}}</p>
                                        </div>
                                        <small class="file-accessed text-muted">Last modified: {{ $folder->updated_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                                @php $i++; @endphp
                                @endforeach
                                @else
                                Folder not found!
                                @endif
                                <div class="d-none flex-grow-1 align-items-center no-result mb-3">
                                    <i data-feather="alert-circle" class="mr-50"></i>
                                    No Results
                                </div>
                            </div>
                            <!-- /Folders Container Ends -->

                            <!-- Files Container Starts -->
                            <div class="view-container" style="margin-bottom: 100px !important;">
                                <h6 class="files-section-title mt-2 mb-75">Files</h6>
                                @if(count($files)>0)
                                @foreach ($files as $file)
                                <div class="card file-manager-item file file-container fileContainerSection" data-id="{{encrypted_value($file->id)}}">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheckFile{{$i}}" />
                                        <label class="custom-control-label" for="customCheckFile{{$i}}"></label>
                                    </div>
                                    <div class="card-img-top file-logo-wrapper custom-font-size">
                                        <div class="dropdown float-right file-options" style="opacity: 0">
                                            <div class="dropdown d-inline-block">
                                                <i class="font-medium-2 cursor-pointer" data-feather="more-vertical" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                </i>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="javascript:;" onclick="shareFile('{{route('file.download',encrypted_value($file->id))}}')">
                                                        <i data-feather="share-2" class="align-middle mr-50"></i>
                                                        <span class="align-middle">Share</span>
                                                    </a>
                                                    <a class="dropdown-item" href="javascript:;" onclick="moveFile('{{encrypted_value($file->id)}}')">
                                                        <i data-feather="folder-plus" class="cursor-pointer mr-50"></i>
                                                        <span class="align-middle">Move to</span>
                                                    </a>
                                                    <a class="dropdown-item" href="javascript:;" onclick="renameFile('{{encrypted_value($file->id)}}', '{{$file->name}}')">
                                                        <i data-feather="edit" class="align-middle mr-50"></i>
                                                        <span class="align-middle">Rename</span>
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item" href="javascript:;" onclick="deleteFile('{{encrypted_value($file->id)}}')">
                                                        <i data-feather="trash" class="align-middle mr-50"></i>
                                                        <span class="align-middle">Delete</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-center w-100">
                                            <img src="{{asset('app-assets/images/svg/'.$file->extension.'.svg')}}" onerror="this.onerror=null;this.src='{{asset('app-assets/images/svg/file.svg')}}';" alt="file-icon" height="48" />
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="content-wrapper">
                                            <p class="card-text file-name mb-0" title="{{$file->name}}">{{$file->name}}</p>
                                            <p class="card-text file-size mb-0">{{ formatFileSizeUnits($file->file_size) }}</p>
                                            <p class="card-text file-date">{{ $file->updated_at->diffForHumans() }}</p>
                                        </div>
                                        <small class="file-accessed text-muted">Last modified: {{ $file->updated_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                                @php $i++; @endphp
                                @endforeach
                                @else
                                File not found!
                                @endif
                                <div class="d-none flex-grow-1 align-items-center no-result mb-3">
                                    <i data-feather="alert-circle" class="mr-50"></i>
                                    No Results
                                </div>
                            </div>
                            <!-- /Files Container Ends -->
                        </div>
                    </div>
                    <!-- file manager app content ends -->

                    <!-- File Info Sidebar Starts-->
                    <div class="modal modal-slide-in fade show" id="app-file-manager-info-sidebar">
                        <div class="modal-dialog sidebar-lg">
                            <div class="modal-content p-0">
                                <div class="modal-header d-flex align-items-center justify-content-between mb-1 p-2">
                                    <h5 class="modal-title">menu.js</h5>
                                    <div>
                                        <i data-feather="trash" class="cursor-pointer mr-50" data-dismiss="modal"></i>
                                        <i data-feather="x" class="cursor-pointer" data-dismiss="modal"></i>
                                    </div>
                                </div>
                                <div class="modal-body flex-grow-1 pb-sm-0 pb-1">
                                    <ul class="nav nav-tabs tabs-line" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#details-tab" role="tab" aria-controls="details-tab" aria-selected="true">
                                                <i data-feather="file"></i>
                                                <span class="align-middle ml-25">Details</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#activity-tab" role="tab" aria-controls="activity-tab" aria-selected="true">
                                                <i data-feather="activity"></i>
                                                <span class="align-middle ml-25">Activity</span>
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="details-tab" role="tabpanel" aria-labelledby="details-tab">
                                            <div class="d-flex flex-column justify-content-center align-items-center py-5">
                                                <img src="{{asset('app-assets/images/icons/js.png')}}" alt="file-icon" height="64" />
                                                <p class="mb-0 mt-1">54kb</p>
                                            </div>
                                            <h6 class="file-manager-title my-2">Settings</h6>
                                            <ul class="list-unstyled">
                                                <li class="d-flex justify-content-between align-items-center mb-1">
                                                    <span>File Sharing</span>
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input" id="sharing" />
                                                        <label class="custom-control-label" for="sharing"></label>
                                                    </div>
                                                </li>
                                                <li class="d-flex justify-content-between align-items-center mb-1">
                                                    <span>Synchronization</span>
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input" checked id="sync" />
                                                        <label class="custom-control-label" for="sync"></label>
                                                    </div>
                                                </li>
                                                <li class="d-flex justify-content-between align-items-center mb-1">
                                                    <span>Backup</span>
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input" id="backup" />
                                                        <label class="custom-control-label" for="backup"></label>
                                                    </div>
                                                </li>
                                            </ul>
                                            <hr class="my-2" />
                                            <h6 class="file-manager-title my-2">Info</h6>
                                            <ul class="list-unstyled">
                                                <li class="d-flex justify-content-between align-items-center">
                                                    <p>Type</p>
                                                    <p class="font-weight-bold">JS</p>
                                                </li>
                                                <li class="d-flex justify-content-between align-items-center">
                                                    <p>Size</p>
                                                    <p class="font-weight-bold">54kb</p>
                                                </li>
                                                <li class="d-flex justify-content-between align-items-center">
                                                    <p>Location</p>
                                                    <p class="font-weight-bold">Files > Documents</p>
                                                </li>
                                                <li class="d-flex justify-content-between align-items-center">
                                                    <p>Owner</p>
                                                    <p class="font-weight-bold">Sheldon Cooper</p>
                                                </li>
                                                <li class="d-flex justify-content-between align-items-center">
                                                    <p>Modified</p>
                                                    <p class="font-weight-bold">12th Aug, 2020</p>
                                                </li>

                                                <li class="d-flex justify-content-between align-items-center">
                                                    <p>Created</p>
                                                    <p class="font-weight-bold">01 Oct, 2019</p>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="tab-pane fade" id="activity-tab" role="tabpanel" aria-labelledby="activity-tab">
                                            <h6 class="file-manager-title my-2">Today</h6>
                                            <div class="media align-items-center mb-2">
                                                <div class="avatar avatar-sm mr-50">
                                                    <img src="{{asset('app-assets/images/avatars/5-small.png')}}" alt="avatar" width="28" />
                                                </div>
                                                <div class="media-body">
                                                    <p class="mb-0">
                                                        <span class="font-weight-bold">Mae</span>
                                                        shared the file with
                                                        <span class="font-weight-bold">Howard</span>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="media align-items-center">
                                                <div class="avatar avatar-sm bg-light-primary mr-50">
                                                    <span class="avatar-content">SC</span>
                                                </div>
                                                <div class="media-body">
                                                    <p class="mb-0">
                                                        <span class="font-weight-bold">Sheldon</span>
                                                        updated the file
                                                    </p>
                                                </div>
                                            </div>
                                            <h6 class="file-manager-title mt-3 mb-2">Yesterday</h6>
                                            <div class="media align-items-center mb-2">
                                                <div class="avatar avatar-sm bg-light-success mr-50">
                                                    <span class="avatar-content">LH</span>
                                                </div>
                                                <div class="media-body">
                                                    <p class="mb-0">
                                                        <span class="font-weight-bold">Leonard</span>
                                                        renamed this file to
                                                        <span class="font-weight-bold">menu.js</span>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="media align-items-center">
                                                <div class="avatar avatar-sm mr-50">
                                                    <img src="{{asset('app-assets/images/portrait/small/avatar-s-1.jpg')}}" alt="Avatar" width="28" />
                                                </div>
                                                <div class="media-body">
                                                    <p class="mb-0">
                                                        <span class="font-weight-bold">You</span>
                                                        shared this file with Leonard
                                                    </p>
                                                </div>
                                            </div>
                                            <h6 class="file-manager-title mt-3 mb-2">3 days ago</h6>
                                            <div class="media">
                                                <div class="avatar avatar-sm mr-50">
                                                    <img src="{{asset('app-assets/images/portrait/small/avatar-s-1.jpg')}}" alt="Avatar" width="28" />
                                                </div>
                                                <div class="media-body">
                                                    <p class="mb-50">
                                                        <span class="font-weight-bold">You</span>
                                                        uploaded this file
                                                    </p>
                                                    <img src="{{asset('app-assets/images/icons/js.png')}}" alt="Avatar" class="mr-50" height="24" />
                                                    <span class="font-weight-bold">app.js</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- File Info Sidebar Ends -->

                    <!-- File Dropdown Starts-->
                    <div class="dropdown-menu dropdown-menu-right file-dropdown">
                        <a class="dropdown-item" href="javascript:void(0);">
                            <i data-feather="eye" class="align-middle mr-50"></i>
                            <span class="align-middle">Preview</span>
                        </a>
                        <a class="dropdown-item" href="javascript:void(0);">
                            <i data-feather="user-plus" class="align-middle mr-50"></i>
                            <span class="align-middle">Share</span>
                        </a>
                        <a class="dropdown-item" href="javascript:void(0);">
                            <i data-feather="copy" class="align-middle mr-50"></i>
                            <span class="align-middle">Make a copy</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="javascript:void(0);">
                            <i data-feather="edit" class="align-middle mr-50"></i>
                            <span class="align-middle">Rename</span>
                        </a>
                        <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#app-file-manager-info-sidebar">
                            <i data-feather="info" class="align-middle mr-50"></i>
                            <span class="align-middle">Info</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="javascript:void(0);">
                            <i data-feather="trash" class="align-middle mr-50"></i>
                            <span class="align-middle">Delete</span>
                        </a>
                        <a class="dropdown-item" href="javascript:void(0);">
                            <i data-feather="alert-circle" class="align-middle mr-50"></i>
                            <span class="align-middle">Report</span>
                        </a>
                    </div>
                    <!-- /File Dropdown Ends -->

                    <!-- Create New Folder Modal Starts-->
                    <div class="modal fade" id="new-folder-modal">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">New Folder</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <input type="text" class="form-control" value="New folder" placeholder="Untitled folder" />
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary mr-1" data-dismiss="modal">Create</button>
                                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Create New Folder Modal Ends -->

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('modal')
<div class="modal fade text-left" id="createFolderModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Create Folder</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="createFolderForm">
                    @csrf
                    @method("POST")
                    @isset($folder_id)
                    <input type="hidden" name="parent_id" value="{{$folder_id}}">
                    @else
                    <input type="hidden" name="parent_id" value="{{encrypted_value(0)}}">
                    @endisset
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <input type="text" class="form-control" name="name" placeholder="Enter folder name" required>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="submitCreateFolder">Create</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade text-left" id="editFolderModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Rename Folder</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editFolderForm">
                    @csrf
                    @method("POST")
                    <input type="hidden" id="edit_folder_id" name="folder_id">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <input type="text" class="form-control" id="edit_folder_name" name="name" placeholder="Enter folder name" required>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="submitEditFolder">Rename</button>
            </div>
        </div>
    </div>
</div>

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

<div class="modal fade text-left" id="copyFileLinkModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Share File</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">

                        <div class="input-group">
                            <input type="text" class="form-control" id="file_link" name="name" placeholder="Button on right" aria-describedby="button-addon2" />
                            <div class="input-group-append" id="button-addon2">
                                <button class="btn btn-primary" type="button" id="CopyToClipBoard">Copy</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" target="_blank" class="btn btn-primary" id="fb_share"><i data-feather="facebook" class="align-middle"></i> Facebook</a>
                <a href="#" target="_blank" class="btn btn-primary" id="twitter_share"><i data-feather="twitter" class="align-middle"></i> Twitter</a>

            </div>
        </div>
    </div>
</div>

<div class="modal fade text-left" id="moveFileModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="moveFileTitle">
                    @isset($folder_id)
                    <i class="fas fa-arrow-left go_to_back" data-id="{{$folder_id}}" style="font-size:16px; margin-right: 5px; cursor: pointer;"></i>
                    @endisset
                    Move To
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="moveFileForm">
                    @csrf
                    @method("POST")
                    <input type="hidden" id="moving_file_id" name="moving_file_id">
                    <input type="hidden" id="moving_folder_id" name="moving_folder_id">
                    <input type="hidden" id="move_to_folder_id" name="move_to_folder_id">
                </form>
                <div class="row">
                    <div class="col-12">
                        <div class="list-group" role="tablist" id="moveFolderList">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" data-type="file" id="submitMoveFile" disabled>Move</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="{{asset('app-assets/vendors/js/extensions/sweetalert2.all.min.js')}}"></script>
<script>
    $(".create-folder-button").click(function() {
        $("#createFolderModal").modal("show");
    });

    $("#submitCreateFolder").click(function(event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{route('folder.store')}}",
            data: $("#createFolderForm").serialize(),
            success: function(response) {
                $("#createFolderModal").modal("hide");
                let url = window.location.href;
                window.location.href = url;
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

    $("#submitEditFolder").click(function(event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{route('folder.update')}}",
            data: $("#editFolderForm").serialize(),
            success: function(response) {
                $("#editFolderModal").modal("hide");
                let url = window.location.href;
                window.location.href = url;
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

    $("#submitEditFile").click(function(event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{route('file.update')}}",
            data: $("#editFileForm").serialize(),
            success: function(response) {
                $("#editFileModal").modal("hide");
                let url = window.location.href;
                window.location.href = url;
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

    $("#submitMoveFile").click(function(event) {
        event.preventDefault();

        let file_url = "{{route('file.move')}}";
        let multiple_file_url = "{{route('file.multiple-move')}}";
        let folder_url = "{{route('folder.move')}}";
        let moving_url = file_url;
        let moving_type = $(this).data('type');

        if (moving_type == 'folder') {
            moving_url = folder_url;
        } else if (moving_type == 'multiple-file') {
            moving_url = multiple_file_url;
        }

        $.ajax({
            type: "POST",
            dataType: "json",
            url: moving_url,
            data: $("#moveFileForm").serialize(),
            success: function(response) {
                $("#moveFileModal").modal("hide");
                let url = window.location.href;
                window.location.href = url;
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

    $(document).on('click', '.move_to_folder_list', function(event) {
        event.preventDefault();
        $("#move_to_folder_id").val($(this).data('id'));
        $("#submitMoveFile").attr('disabled', false);
    });

    $(document).on('click', '.go_to_inner_folder', function(event) {
        event.preventDefault();
        fetch_folder_list($(this).parent().data('id'));
    });

    $(document).on('click', '.go_to_back', function(event) {
        event.preventDefault();
        fetch_folder_list($(this).data('id'), 'back');
    });

    function openFolder(sl) {
        window.location.href = $("#encryptedFolderUrl" + sl).val();
    }

    function renameFolder(encrypted_id, name) {
        $("#edit_folder_id").val(encrypted_id);
        $("#edit_folder_name").val(name);
        $("#editFolderModal").modal("show");
    }

    function renameFile(encrypted_id, name) {
        $("#edit_file_id").val(encrypted_id);
        $("#edit_file_name").val(name);
        $("#editFileModal").modal("show");
    }

    function moveFolder(encrypted_id) {
        $("#moving_folder_id").val(encrypted_id);
        $("#submitMoveFile").attr('data-type', 'folder');
        fetch_folder_list($("#currentFolderId").val());
        $("#moveFileModal").modal("show");
    }

    function moveFile(encrypted_id) {
        $("#moving_file_id").val(encrypted_id);
        $("#submitMoveFile").attr('data-type', 'file');
        fetch_folder_list($("#currentFolderId").val());
        $("#moveFileModal").modal("show");
    }

    $('#moveFileModal').on('hidden.bs.modal', function() {
        $("#moving_folder_id").val('');
        $("#moving_file_id").val('');
        $("#move_to_folder_id").val('');
    })

    function moveMultipleFile() {
        let selected_id = [];
        $('.fileContainerSection').each(function(index) {
            if ($(this).hasClass('selected')) {
                selected_id.push($(this).data('id'))
            }
        });
        fetch_folder_list($("#currentFolderId").val());
        $("#moving_file_id").val(selected_id.join());
        $("#submitMoveFile").attr('data-type', 'multiple-file');
        $("#moveFileModal").modal("show");
    }

    function deleteMultipleFile() {
        let selected_id = [];
        $('.fileContainerSection').each(function(index) {
            if ($(this).hasClass('selected')) {
                selected_id.push($(this).data('id'))
            }
        });

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
                    url: "{{route('file.multiple-delete')}}",
                    data: {
                        file_id: selected_id.join(),
                        _token: "{{ csrf_token()}}"
                    },
                    success: function(response) {
                        let url = window.location.href;
                        window.location.href = url;
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
                    url: "{{route('file.delete')}}",
                    data: {
                        file_id: encrypted_id,
                        _token: "{{ csrf_token()}}"
                    },
                    success: function(response) {
                        let url = window.location.href;
                        window.location.href = url;
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

    function deleteFolder(encrypted_id) {
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
                    url: "{{route('folder.delete')}}",
                    data: {
                        folder_id: encrypted_id,
                        _token: "{{ csrf_token()}}"
                    },
                    success: function(response) {
                        let url = window.location.href;
                        window.location.href = url;
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

    function shareFile(link) {
        $("#file_link").val(link);
        $("#fb_share").attr('href', 'https://www.facebook.com/sharer/sharer.php?u=' + link);
        $("#twitter_share").attr('href', 'https://twitter.com/intent/tweet?url=' + link);
        $("#copyFileLinkModal").modal("show");
    }

    function fetch_folder_list(parent_id, type = null) {
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{route('folder.inner-folder')}}",
            data: {
                current_folder_id: parent_id,
                moving_folder_id: $("#moving_folder_id").val(),
                type: type,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                let content = '';

                if (response.success.data.parent_id) {
                    $("#moveFileTitle").html('<i class="fas fa-arrow-left go_to_back" data-id="' + response.success.data.parent_id + '" style="font-size:16px; margin-right: 5px; cursor: pointer;"></i> Move To');
                } else {
                    content += '<a class="list-group-item list-group-item-action move_to_folder_list" data-id="' + response.success.data.encrypted_zero + '" data-toggle="list" role="tab" aria-controls="home"><i class="fas fa-folder" style="font-size:20px; margin-right: 5px;"></i>My Drive</a>';

                    $("#moveFileTitle").html('Move To');
                }

                $.each(response.success.data.folders, function(key, folder) {
                    content += '<a class="list-group-item list-group-item-action move_to_folder_list" data-id="' + folder.encrypted_id + '" data-toggle="list" role="tab" aria-controls="home"><i class="far fa-folder" style="font-size:20px; margin-right: 5px;"></i>' + folder.name + ' <button class="btn btn-flat-secondary btn-sm float-right go_to_inner_folder"><i class="fas fa-chevron-right"></i></button></a>';
                });

                $("#moveFolderList").html(content);


                $("#submitMoveFile").attr('disabled', true);

            },
            error: function(reject) {
                let errors = $.parseJSON(reject.responseText);
                console.log(errors);
            }
        });
    }
</script>
@endpush