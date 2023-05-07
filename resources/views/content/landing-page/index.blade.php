@extends('layouts.landing_master')

@section('title', 'URL shortener and sharing')

@push('style')

@endpush

@section('content')

<div class="header-hero bg_cover" style="background-color:#877DF2;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="header-hero-content text-center">
                    <h3 class="header-sub-title wow fadeInUp" data-wow-duration="1.3s" data-wow-delay="0.2s">Free Simple URL shortener and sharing</h3>
                    <p class="text wow fadeInUp" data-wow-duration="1.3s" data-wow-delay="0.8s">Let's short your URL, and share any platform </p>
                    <a href="{{ route('shorten-url.index') }}" class="main-btn wow fadeInUp" data-wow-duration="1.3s" data-wow-delay="1.1s"><i class="fas fa-link mr-2"></i>Start Shorting</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="header-hero-image text-center wow fadeIn" data-wow-duration="1.3s" data-wow-delay="1.4s">
                    <img src="{{ asset('app-assets/landing-page/images/header-hero.png')}}" alt="hero" style="opacity:0">
                </div>
            </div>
        </div>
    </div>
    <div id="particles-1" class="particles"></div>
</div>

@endsection

@push('script')
@endpush