@extends('layouts.landing_master')

@section('title', 'About')

@push('style')
<style>
    .primary-background {
        background: #877DF2;
    }
</style>
@endpush

@section('content')
<!--====== ABOUT PART START ======-->

<section id="about" class="about-area pt-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="about-content mt-50 wow fadeInLeftBig" data-wow-duration="1s" data-wow-delay="0.5s">
                    <div class="section-title">
                        <div class="line"></div>
                        <h3 class="title">Quick & Easy <span>to Use Bootstrap Template</span></h3>
                    </div> <!-- section title -->
                    <p class="text">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, seiam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing.</p>

                </div> <!-- about content -->
            </div>
            <div class="col-lg-6">
                <div class="about-image text-center mt-50 wow fadeInRightBig" data-wow-duration="1s" data-wow-delay="0.5s">
                    <img src="{{asset('app-assets/landing-page/images/header-hero.png')}}" alt="about">
                </div> <!-- about image -->
            </div>
        </div> <!-- row -->
    </div> <!-- container -->
    <div class="about-shape-1">
        <img src="{{asset('app-assets/landing-page/images/about-shape-1.svg')}}" alt="shape">
    </div>
</section>

<!--====== ABOUT PART ENDS ======-->
<section class="about-area pt-70">
    <div class="about-shape-2">
        <img src="{{asset('app-assets/landing-page/images/about-shape-2.svg')}}" alt="shape">
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-6 order-lg-last">
                <div class="about-content mt-50 wow fadeInLeftBig" data-wow-duration="1s" data-wow-delay="0.5s">
                    <div class="section-title">
                        <div class="line"></div>
                        <h3 class="title">Modern design <span> with Essential Features</span></h3>
                    </div> <!-- section title -->
                    <p class="text">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, seiam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing.</p>
                </div> <!-- about content -->
            </div>
            <div class="col-lg-6 order-lg-first">
                <div class="about-image text-center mt-50 wow fadeInRightBig" data-wow-duration="1s" data-wow-delay="0.5s">
                    <img src="{{asset('app-assets/landing-page/images/about2.svg')}}" alt="about">
                </div> <!-- about image -->
            </div>
        </div> <!-- row -->
    </div> <!-- container -->
</section>


<section class="about-area pt-70">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="about-content mt-50 wow fadeInLeftBig" data-wow-duration="1s" data-wow-delay="0.5s">
                    <div class="section-title">
                        <div class="line"></div>
                        <h3 class="title"><span>Crafted for</span> SaaS, App and Software Landing Page</h3>
                    </div> <!-- section title -->
                    <p class="text">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, seiam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing.</p>

                </div> <!-- about content -->
            </div>
            <div class="col-lg-6">
                <div class="about-image text-center mt-50 wow fadeInRightBig" data-wow-duration="1s" data-wow-delay="0.5s">
                    <img src="{{asset('app-assets/landing-page/images/about3.svg')}}" alt="about">
                </div> <!-- about image -->
            </div>
        </div> <!-- row -->
    </div> <!-- container -->
    <div class="about-shape-1">
        <img src="{{asset('app-assets/landing-page/images/about-shape-1.svg')}}" alt="shape">
    </div>
</section>

<!--====== ABOUT PART START ======-->

<section class="about-area pt-70 pb-100">
    <div class="about-shape-2">
        <img src="{{asset('app-assets/landing-page/images/about-shape-2.svg')}}" alt="shape">
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-6 order-lg-last">
                <div class="counter-wrapper mt-50 wow fadeIn" data-wow-duration="1s" data-wow-delay="0.8s">
                    <div class="counter-content">
                        <div class="section-title">
                            <div class="line"></div>
                            <h3 class="title">Cool facts <span> this about app</span></h3>
                        </div> <!-- section title -->
                        <p class="text">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, seiam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.</p>
                    </div> <!-- counter content -->
                    <div class="row no-gutters">
                        <div class="col-4">
                            <div class="single-counter counter-color-1 d-flex align-items-center justify-content-center">
                                <div class="counter-items text-center">
                                    <span class="count"><span class="counter">125</span>K</span>
                                    <p class="text">Downloads</p>
                                </div>
                            </div> <!-- single counter -->
                        </div>
                        <div class="col-4">
                            <div class="single-counter counter-color-2 d-flex align-items-center justify-content-center">
                                <div class="counter-items text-center">
                                    <span class="count"><span class="counter">87</span>K</span>
                                    <p class="text">Active Users</p>
                                </div>
                            </div> <!-- single counter -->
                        </div>
                        <div class="col-4">
                            <div class="single-counter counter-color-3 d-flex align-items-center justify-content-center">
                                <div class="counter-items text-center">
                                    <span class="count"><span class="counter">4.8</span></span>
                                    <p class="text">User Rating</p>
                                </div>
                            </div> <!-- single counter -->
                        </div>
                    </div> <!-- row -->
                </div>
            </div>
            <div class="col-lg-6 order-lg-first">
                <div class="about-image text-center mt-50 wow fadeInRightBig" data-wow-duration="1s" data-wow-delay="0.5s">
                    <img src="{{asset('app-assets/landing-page/images/about1.svg')}}" alt="about">
                </div> <!-- about image -->
            </div>
        </div> <!-- row -->
    </div> <!-- container -->
</section>


<!--====== ABOUT PART START ======-->


<!--====== ABOUT PART ENDS ======-->
@endsection

@push('script')
@endpush