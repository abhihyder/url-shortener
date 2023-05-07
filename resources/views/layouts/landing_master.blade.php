<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">

    <!--====== Title ======-->
    <title>@yield('title',config('app.name', 'URL Shortener')) - {{config('app.name', 'URL Shortener')}}</title>

    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="home-url" content="{{route('home') }}">

    <!--====== Favicon Icon ======-->
    <link rel="icon" href="{{asset('app-assets/images/logo/favicon.ico')}}">

    <!--====== Animate CSS ======-->
    <link rel="stylesheet" href="{{ asset('app-assets/landing-page/css/animate.css')}}">

    <!--====== Magnific Popup CSS ======-->
    <link rel="stylesheet" href="{{ asset('app-assets/landing-page/css/magnific-popup.css')}}">

    <!--====== Slick CSS ======-->
    <link rel="stylesheet" href="{{ asset('app-assets/landing-page/css/slick.css')}}">

    <!--====== Line Icons CSS ======-->
    <link rel="stylesheet" href="{{ asset('app-assets/landing-page/css/LineIcons.css')}}">

    <!--====== Font Awesome CSS ======-->
    <link rel="stylesheet" href="{{ asset('app-assets/landing-page/css/font-awesome.min.css')}}">

    <!--====== Bootstrap CSS ======-->
    <link rel="stylesheet" href="{{ asset('app-assets/landing-page/css/bootstrap.min.css')}}">

    <!--====== Default CSS ======-->
    <link rel="stylesheet" href="{{ asset('app-assets/landing-page/css/default.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/fonts/font-awesome/css/font-awesome.min.css')}}">

    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/file-uploaders/dropzone.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/plugins/forms/form-file-uploader.css')}}">

    @stack('style')
    <!--====== Style CSS ======-->
    <link rel="stylesheet" href="{{ asset('app-assets/landing-page/css/style.css')}}">

</head>

<body>
    <!--[if IE]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
  <![endif]-->


    <!--====== PRELOADER PART START ======-->

    <div class="preloader">
        <div class="loader">
            <div class="ytp-spinner">
                <div class="ytp-spinner-container">
                    <div class="ytp-spinner-rotator">
                        <div class="ytp-spinner-left">
                            <div class="ytp-spinner-circle"></div>
                        </div>
                        <div class="ytp-spinner-right">
                            <div class="ytp-spinner-circle"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--====== PRELOADER PART ENDS ======-->

    <!--====== HEADER PART START ======-->

    <header class="header-area">
        <div class="navbar-area primary-background">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <nav class="navbar navbar-expand-lg">
                            <a class="navbar-brand" href="{{route('home') }}">
                                <img style="max-width:120px" src="{{ asset('app-assets/images/logo/logo.png')}}" alt="Logo">
                            </a>
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="toggler-icon"></span>
                                <span class="toggler-icon"></span>
                                <span class="toggler-icon"></span>
                            </button>

                            <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent">
                                <ul id="nav" class="navbar-nav ml-auto">

                                    @auth
                                    <li class="nav-item mb-2">
                                        <a class="main-btn wow fadeInUp" data-wow-duration="1.3s" data-wow-delay="1.1s" href="{{ route('shorten-url.index') }}"> <i class="fas fa-link mr-2"></i> Shorten URL</a>
                                    </li>
                                    @else
                                    <li class="nav-item">
                                        <a class="main-btn wow fadeInUp" data-wow-duration="1.3s" data-wow-delay="1.1s" href="{{ route('login') }}"> <i class="fas fa-sign-in-alt mr-2"></i> Sign In</a>
                                    </li>

                                    @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="main-btn wow fadeInUp" data-wow-duration="1.3s" data-wow-delay="1.1s" href="{{ route('register') }}"><i class="fas fa-user-plus mr-2"></i>Sign Up</a>
                                    </li>
                                    @endif
                                    @endauth
                                </ul>
                            </div> <!-- navbar collapse -->

                        </nav> <!-- navbar -->
                    </div>
                </div> <!-- row -->
            </div> <!-- container -->
        </div> <!-- navbar area -->
    </header>

    <!--====== HEADER PART ENDS ======-->
    @yield('content')

    <!--====== FOOTER PART START ======-->

    <footer class="footer-area pt-10">
        <div class="container">

            <div class="footer-copyright">
                <div class="row">
                    <div class="col-md-5">
                        <div class="copyright d-sm-flex justify-content-between">
                            <div class="copyright-content">
                                <p class="text">Designed and Developed by <a href="https://www.linkedin.com/in/tofayelhyder" target="_blank" rel="nofollow">Tofayel Hyder</a></p>
                            </div> <!-- copyright content -->
                        </div> <!-- copyright -->
                    </div>
                    <div class="col-md-7">
                        <nav class="navbar p-0">
                            <ul class="nav nav-pills ml-auto">
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="{{route('about')}}">About</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="{{route('how-it-work')}}">How it Works</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="{{route('faq')}}">FAQ</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="{{route('terms-and-condition')}}">Terms and Conditions</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div> <!-- row -->
            </div> <!-- footer copyright -->
        </div> <!-- container -->
    </footer>

    <!--====== FOOTER PART ENDS ======-->

    <!--====== BACK TOP TOP PART START ======-->

    <a href="#" class="back-to-top"><i class="lni-chevron-up"></i></a>

    <!--====== Jquery js ======-->
    <script src="{{ asset('app-assets/landing-page/js/vendor/jquery-1.12.4.min.js')}}"></script>
    <script src="{{ asset('app-assets/landing-page/js/vendor/modernizr-3.7.1.min.js')}}"></script>

    <!--====== Bootstrap js ======-->
    <script src="{{ asset('app-assets/landing-page/js/popper.min.js')}}"></script>
    <script src="{{ asset('app-assets/landing-page/js/bootstrap.min.js')}}"></script>

    <!--====== Plugins js ======-->
    <script src="{{ asset('app-assets/landing-page/js/plugins.js')}}"></script>

    <!--====== Slick js ======-->
    <script src="{{ asset('app-assets/landing-page/js/slick.min.js')}}"></script>

    <!--====== Ajax Contact js ======-->
    <script src="{{ asset('app-assets/landing-page/js/ajax-contact.js')}}"></script>

    <!--====== Counter Up js ======-->
    <script src="{{ asset('app-assets/landing-page/js/waypoints.min.js')}}"></script>
    <script src="{{ asset('app-assets/landing-page/js/jquery.counterup.min.js')}}"></script>

    <!--====== Magnific Popup js ======-->
    <script src="{{ asset('app-assets/landing-page/js/jquery.magnific-popup.min.js')}}"></script>

    <!--====== Scrolling Nav js ======-->
    <script src="{{ asset('app-assets/landing-page/js/jquery.easing.min.js')}}"></script>
    <script src="{{ asset('app-assets/landing-page/js/scrolling-nav.js')}}"></script>

    <!--====== wow js ======-->
    <script src="{{ asset('app-assets/landing-page/js/wow.min.js')}}"></script>

    <!--====== Particles js ======-->
    <script src="{{ asset('app-assets/landing-page/js/particles.min.js')}}"></script>

    <!--====== Main js ======-->
    <script src="{{ asset('app-assets/landing-page/js/main.js')}}"></script>

    <script src="{{asset('app-assets/vendors/js/file-uploaders/dropzone.min.js')}}"></script>
    <script src="{{asset('app-assets/js/scripts/forms/form-file-uploader.js')}}"></script>
    <script src="{{asset('app-assets/js/scripts/components/components-modals.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/clipboard@2.0.8/dist/clipboard.min.js"></script>
    @stack('script')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{!! csrf_token() !!}"
                }
            });
        });

        function copy_to_clipboard(value) {
            new ClipboardJS('.' + value);
        }

    </script>
</body>

</html>