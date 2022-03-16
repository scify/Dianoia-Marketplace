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
        <div class="row align-items-center mt-5" style="text-align: center"  >
            <p style="text-align: left!important;" > {!! __('messages.about_development_text') !!}</p>

            <div class="col-6">
                <div>
                    <img src={{asset("img/scify_logo_big.png")}} height="150px" alt="scify logo" style="margin-left:auto;margin-right:auto;display:block">
                </div>
                <div class="mt-5">
                    <img src={{asset("img/eu_logo.jpg")}}  alt="EU-logo"  style="width:auto; height:40pt; margin-left:auto;margin-right:auto;display:block">
                </div>
            </div>

            <div class="col-6">
                <div>
                    <img src={{asset("img/alzheimer_athens.png")}} height="150px" alt="Alzheimer Athens"  style="margin-left:auto;margin-right:auto;display:block">
                </div>
                <div class="mt-5">
                    <img src={{asset("img/shapes_logo.png")}} alt="Shapes-Logo" style="width:auto; height:40pt; margin-left:auto;margin-right:auto;display:block">
                </div>
            </div>
            <p style="font-size:10pt; margin-top: 20pt">
                This project has received funding from the European Union's Horizon 2020 research and innovation programme under grant agreement No. 857159.
            </p>
        </div>


        {{--        <div class="row align-items-center" style="padding:40pt" >--}}

        {{--            <hr>--}}


        {{--            <div class="col-6">--}}
        {{--                <iframe height="315" width="560" src="https://www.youtube.com/embed/hNHfDPX5jDM" title="Dianoia Marketplace"--}}
        {{--                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>--}}
        {{--            </div>--}}
        {{--            <div class="col-6">--}}
        {{--                <h2  style="text-align: center"> <u>Walkthrough</u></h2>--}}
        {{--                <p>--}}
        {{--                    Dianoia Marketplace is an online application implemented and available for free by the non-profit SciFY so that everyone can create and share their own free content for the Dianoia application.  The content of Dianoia Marketplace is mainly aimed at people that take care of people/patients with onset dementia or/and Alzheimer’s.  People with onset dementia, due to the progressive decline of their mental abilities, have the need for appropriate care at every stage. The caregivers feel that they have a great responsibility for their care.--}}
        {{--                </p>--}}
        {{--            </div>--}}
        {{--        </div>--}}
        {{--        <hr>--}}


        {{--        <hr>--}}
        {{--        <div class="row align-items-center mt-5 " style="text-align: center" >--}}
        {{--            <h2 class="mb-5"><u>Learn More</u></h2>--}}
        {{--            <div class="col-4">--}}
        {{--                <ul>--}}
        {{--                    <li><a href="{{route('content-guidelines')}}"> {{__('messages.content-guidelines')}} </a></li>--}}
        {{--                </ul>--}}
        {{--            </div>--}}
        {{--            <div class="col-4">--}}
        {{--                <ul>--}}
        {{--                    <li><a href="{{app()->getLocale() .'/privacy-policy'}}"  target="_blank">{!! __('messages.privacy-policy') !!}</a></li>--}}
        {{--                </ul>--}}
        {{--            </div>--}}
        {{--            <div class="col-4">--}}
        {{--                <ul>--}}
        {{--                    <li><a href="{{'/terms-of-use' }}">{!! __('messages.terms-of-use') !!}</a></li>--}}
        {{--                </ul>--}}
        {{--            </div>--}}


        {{--        </div>--}}


    </div>
</main>


{{--    [link για terms and conditions-privacy policy]--}}
    {{--    [link για content guidelines]--}}
    {{--    [link για gdpr]--}}

    {{--    Κείμενο για χρηματοδότηση από “Σημεία Στήριξης” https://www.scify.gr/site/el/impact-areas/assistive-technologies/dianoia--}}

    {{--    Κείμενο για χρηματοδότηση από SHAPES--}}

@endsection
@push('scripts')
    <script src="{{ mix('dist/js/home.js') }}"></script>
@endpush
