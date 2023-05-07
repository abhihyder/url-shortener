@extends('layouts.landing_master')

@section('title', 'How it works')

@push('style')
<style>
    .primary-background {
        background: #877DF2;
    }
</style>
@endpush

@section('content')


<!--====== ABOUT PART START ======-->

<section class="about-area pt-100">
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

<section id="facts" class="video-counter pt-70 pb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="video-content mt-50 wow fadeIn" data-wow-duration="1s" data-wow-delay="0.5s">
                    <img class="dots" src="{{asset('app-assets/landing-page/images/dots.svg')}}" alt="dots">
                    <div class="video-wrapper">
                        <div class="video-image">
                            <img src="{{asset('app-assets/landing-page/images/video.png')}}" alt="video">
                        </div>
                        <div class="video-icon">
                            <a href="https://www.youtube.com/watch?v=r44RKWyfcFw" class="video-popup"><i class="lni-play"></i></a>
                        </div>
                    </div> <!-- video wrapper -->
                </div> <!-- video content -->
            </div>
            <div class="col-lg-6">
                <div class="counter-wrapper mt-50 wow fadeIn" data-wow-duration="1s" data-wow-delay="0.8s">
                    <div class="counter-content">
                        <div class="section-title">
                            <div class="line"></div>
                            <h3 class="title">How <span> it works</span></h3>
                        </div> <!-- section title -->
                        <p class="text">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, seiam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.</p>
                    </div> <!-- counter content -->
                  
                </div> <!-- counter wrapper -->
            </div>
        </div> <!-- row -->
    </div> <!-- container -->
</section>


<!--====== ABOUT PART ENDS ======-->
@endsection

@push('script')
@endpush