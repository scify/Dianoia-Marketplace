@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{mix('dist/css/tutorial.css')}}">
@endpush
@section('content')
    <div id="tutorial-page" class="container my-5 py-3">
        <div class="row">
            <div class="col-12 mx-auto mb-3 text-center">
                <h1>{!! __('messages.tutorial_title') !!}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col mx-auto">
                <div class="container-fluid">
                    <div class="row mb-3">
                        <div class="col">
                            <h3>{{ __('messages.tutorial_video_prompt') }}</h3>
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col">
                            <iframe width="760" height="515" src="{{ __('messages.tutorial_video_link') }}"
                                    title="YouTube video player" frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen></iframe>
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-12 mb-3">
                            <p>{!! __('messages.tutorial_1') !!}</p>
                        </div>
                        <div class="col-12">
                            <img src="{{ asset('img/tutorial/' . app()->getLocale() . '/1.png') }}"
                                 alt="screenshot 1" class="w-100">
                        </div>
                        <div class="col-12">
                            <img src="{{ asset('img/tutorial/' . app()->getLocale() . '/2.png') }}"
                                 alt="screenshot 2" class="w-100">
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-12 mb-3">
                            <p>{!! __('messages.tutorial_2') !!}</p>
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-12 mb-3">
                            <p>{!! __('messages.tutorial_3') !!}</p>
                        </div>
                        <div class="col-12">
                            <img src="{{ asset('img/tutorial/' . app()->getLocale() . '/3.png') }}"
                                 alt="screenshot 4" class="w-100">
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-12 mb-3">
                            <p>{!! __('messages.tutorial_4') !!}</p>
                        </div>
                        <div class="col-12">
                            <img src="{{ asset('img/tutorial/' . app()->getLocale() . '/4.png') }}"
                                 alt="screenshot 5" class="w-100">
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-12 mb-3">
                            <p>{!! __('messages.tutorial_5') !!}</p>
                        </div>
                        <div class="col-12">
                            <img src="{{ asset('img/tutorial/' . app()->getLocale() . '/5.png') }}"
                                 alt="screenshot 5" class="w-100">
                        </div>
                        <div class="col-12">
                            <img src="{{ asset('img/tutorial/' . app()->getLocale() . '/6.png') }}"
                                 alt="screenshot 6" class="w-100">
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-12 mb-3">
                            <p>{!! __('messages.tutorial_6') !!}</p>
                        </div>
                        <div class="col-12">
                            <img src="{{ asset('img/tutorial/' . app()->getLocale() . '/7.png') }}"
                                 alt="screenshot 7" class="w-100">
                        </div>
                        <div class="col-12">
                            <img src="{{ asset('img/tutorial/' . app()->getLocale() . '/8.png') }}"
                                 alt="screenshot 8" class="w-100">
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-12 mb-3">
                            <p>{!! __('messages.tutorial_7') !!}</p>
                        </div>
                        <div class="col-12">
                            <img src="{{ asset('img/tutorial/' . app()->getLocale() . '/9.png') }}"
                                 alt="screenshot 4" class="w-100">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
