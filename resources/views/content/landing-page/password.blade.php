@extends('layouts.landing_master')

@section('title', 'Protected URL')

@push('style')
<style>
    .primary-background {
        background: #877DF2;
    }
</style>
@endpush

@section('content')

<div class="header-hero bg_cover" style="background-color:#877DF2;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="header-hero-content text-center">
                    <h3 class="header-sub-title wow fadeInUp" data-wow-duration="1.3s" data-wow-delay="0.2s">Protected Shorten URL</h3>
                    <p class="text wow fadeInUp" data-wow-duration="1.3s" data-wow-delay="0.8s">Please enter access key to procced</p>

                    <div class="row justify-content-center">
                        <div class="col-4">
                            <div class="subscribe-form mt-50">
                                <form action="{{route('visitor.access_code')}}" id="accessCodeForm" method="POST">
                                    @csrf
                                    @method('POST')
                                    <input type="hidden" name="url_code" value="{{$url_code}}">
                                    <input type="text" name="access_code" placeholder="Enter access key">
                                </form>
                            </div>
                        </div>
                    </div>
                    <a href="javascript:;" onclick="$('#accessCodeForm').submit();" class="main-btn wow fadeInUp" data-wow-duration="1.3s" data-wow-delay="1.1s"><i class="fas fa-link mr-2"></i>Procced</a>
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