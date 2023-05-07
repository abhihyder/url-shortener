<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="author" content="PIXINVENT">
    <meta name="theme_change_url" content="{{route('user.theme') }}">
    <title>@yield('title',config('app.name', 'URL Shortener')) - {{config('app.name', 'URL Shortener')}}</title>
    <link rel="apple-touch-icon" href="{{asset('app-assets/images/ico/apple-icon-120.png')}}">
    <link rel="icon" href="{{asset('app-assets/images/logo/favicon.ico')}}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/vendors.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/core/menu/menu-types/vertical-menu.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/plugins/extensions/ext-component-toastr.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/extensions/toastr.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/file-uploaders/dropzone.min.css')}}">

    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/bootstrap-extended.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/colors.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/components.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/themes/dark-layout.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/themes/bordered-layout.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/themes/semi-dark-layout.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/fonts/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/plugins/forms/form-file-uploader.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/forms/wizard/bs-stepper.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/forms/select/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/plugins/forms/form-wizard.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/pages/ui-feather.css')}}">



    <!-- BEGIN: Page CSS-->
    @stack('style')
    <!-- END: Page CSS-->


    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css')}}">
    <!-- END: Custom CSS-->

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->
@php $auth=null; @endphp
@if(Auth::check())
@php $auth = Auth::user(); @endphp
@endif

<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static {{$auth->is_dark==1? 'dark-layout':''}}" data-open="click" data-menu="vertical-menu-modern" data-col="">

    <!-- BEGIN: Header-->
    @include('partials.navbar')
    <!-- END: Header-->


    <!-- BEGIN: Main Menu-->
    @include('partials.sidebar')
    <!-- END: Main Menu-->

    <!-- BEGIN: Content-->
    @yield('content')

    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <!-- BEGIN: Footer-->
    @include('partials.footer')
    <!-- END: Footer-->
    @yield('modal')
    <!-- BEGIN: Vendor JS-->
    <script src="{{asset('app-assets/vendors/js/vendors.min.js')}}"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="{{asset('app-assets/vendors/js/charts/apexcharts.min.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/extensions/toastr.min.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/file-uploaders/dropzone.min.js')}}"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{asset('app-assets/vendors/js/forms/wizard/bs-stepper.min.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/forms/select/select2.full.min.js')}}"></script>
    <script src="{{asset('app-assets/js/core/app-menu.js')}}"></script>
    <script src="{{asset('app-assets/js/core/app.js')}}"></script>
    <script src="{{asset('app-assets/js/scripts/forms/form-file-uploader.js')}}"></script>
    <script src="{{asset('app-assets/js/scripts/components/components-modals.js')}}"></script>
    <script src="{{asset('app-assets/js/scripts/pages/app-file-manager.js')}}"></script>
    <script src="{{asset('app-assets/js/scripts/forms/form-wizard.js')}}"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="{{asset('app-assets/js/custom/custom_functions.js')}}"></script>

    @stack('script')
    <!-- END: Page JS-->


    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{!! csrf_token() !!}"
                }
            });

            $('a[href="' + window.location.href + '"]').parent('li').addClass('active');
            $('a[href="' + window.location.href + '"]').parents('li.has-sub').addClass('open');
            $('[data-toggle="tooltip"]').tooltip();
        });

        $(window).on('load', function() {
            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
        })

        function copyToClipboard(value) {
            var tempInput = document.createElement('input');
            tempInput.value = value;
            document.body.appendChild(tempInput);
            tempInput.select();
            toastr['success'](tempInput.value.split("'")[1], 'Copied to clipboard! 📋', {
                closeButton: true,
                tapToDismiss: false,
            });
            document.execCommand('copy');
            document.body.removeChild(tempInput);
        }

        $("#CopyToClipBoard").click(function() {
            let link = $("#file_link").val();
            $("#copyFileLinkModal").modal("hide");
            copyToClipboard(link);
        });
    </script>
</body>
<!-- END: Body-->

</html>