@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ mix('dist/css/homepage.css') }}">
    <title> About Page</title>
@endpush

@section('content')
    <header class="mt-5 mb-5" style="text-align: center">
        <h1 style="text-decoration:underline;">{{__('messages.marketplace')}} </h1>
    </header>
    <main style="padding-bottom: 100px">
        <div class="container">
            <div class="row align-items-center mt-5" style="text-align: center">
                <p style="text-align: left!important;"> {!! __('messages.about_development_text') !!}</p>
                <div class="col-6">
                    <div>
                        <img src="{{asset("img/scify_logo_big.png")}}" height="150px" alt="scify logo"
                             style="margin-left:auto;margin-right:auto;display:block">
                    </div>
                    <div class="mt-5">
                        <img src="{{asset("img/eu_logo.jpg")}}" alt="EU-logo"
                             style="width:auto; height:40pt; margin-left:auto;margin-right:auto;display:block">
                    </div>
                </div>
                <div class="col-6">
                    <div>
                        <img src="{{asset("img/alzheimer_athens.png")}}" height="150px" alt="Alzheimer Athens"
                             style="margin-left:auto;margin-right:auto;display:block">
                    </div>
                    <div class="mt-5">
                        <img src="{{asset("img/shapes_logo.png")}}" alt="Shapes project Logo"
                             style="width:auto; height:40pt; margin-left:auto;margin-right:auto;display:block">
                    </div>
                </div>
                <p style="font-size:10pt; margin-top: 20pt">
                    {{__('messages.funding-footer')}}
                </p>
            </div>
            <hr>
            <div class="row align-items-center mt-5 " style="text-align: center">
                <h2 class="mb-5"><u>Learn More</u></h2>
                <div class="col-4">
                    <ul>
                        <li><a href="{{route('content-guidelines')}}"> {{__('messages.content-guidelines')}} </a></li>
                    </ul>
                </div>
                <div class="col-4">
                    <ul>
                        <li><a href="{{ __('messages.privacy-policy-link') }}"
                               target="_blank">{!! __('messages.privacy-policy') !!}</a></li>
                    </ul>
                </div>
                <div class="col-4">
                    <ul>
                        <li><a href="{{ __('messages.terms-of-service-link') }}"
                               target="_blank">{!! __('messages.terms-of-use') !!}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </main>

@endsection
@push('scripts')
    <script src="{{ mix('dist/js/home.js') }}"></script>
@endpush
