@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ mix('dist/css/homepage.css') }}">
    <title> About Page</title>
@endpush

@section('content')

<header class="mt-5 mb-5" style="text-align: center">
    <h1 style="text-decoration:underline;">{{__('messages.marketplace')}} </h1>
</header>
<main>
<div class="container" style="margin-bottom: 100px; margin-top: 60px">
    <p>
        DiAnoia is an application developed by SciFY aiming to support people with incipient dementia as well as their carers without using pharmaceutical means.
    </p>
    <p>
        DiAnoia Marketplace is an online platform that is complementary to the application and offered for free in four languages: The Marketplace allows private and professional caregivers to view and share useful mental exercises for their patients or themselves. Registered users can post their own exercises to the platform that others can view and rate.
    </p>
</div>


    <div class="container">
        <div class="row align-items-center mb-5" >

            <hr>


            <div class="col-6">
                <iframe height="315" width="560" src="https://www.youtube.com/embed/hNHfDPX5jDM" title="Dianoia Marketplace"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
            <div class="col-6">
                <h2  style="text-align: center"> <u>Walkthrough</u></h2>
                <p>
                    Dianoia Marketplace is an online application implemented and available for free by the non-profit SciFY so that everyone can create and share their own free content for the Dianoia application.  The content of Dianoia Marketplace is mainly aimed at people that take care of people/patients with onset dementia or/and Alzheimer’s.  People with onset dementia, due to the progressive decline of their mental abilities, have the need for appropriate care at every stage. The caregivers feel that they have a great responsibility for their care.
                </p>
            </div>
        </div>
        <hr>
        <div class="row align-items-center mt-5"  >


            <div class="col-6">
                <img src={{asset("img/points-of-support.jpg")}} class="mt-3"  height="150px" alt="points-of-support image">
            </div>

            <div class="col-6">
                <h2 style="text-align: center"><u>Funding</u></h2>
                <p>
                    The project "DiAnoia" was implemented under the "Points of Support" program, which is co-funded by TIMA Charitable Foundation, John S. Latsis Public Benefit Foundation, Hellenic Hope charity and Bodossakis Foundation.
                </p>
            </div>
        </div>
        <div class="row align-items-center mt-1"  >
            <div class="col-3">
                <img alt="EU Logo" title="" src="img/eu_logo.jpg" style="width:auto;height:60px ; display: block; float: right ; padding-right:75pt ">
            </div>
            <div class="col-3">
                <img alt="Shapes Logo" title="" src="img/shapes_logo.png" style="width:auto;height:60px;  float: left; padding-right:75pt;  display: block; background: white;">
            </div>
            <div class="col-6">
                <p>
                    This project has received funding from the European Union's Horizon 2020 research and innovation programme under grant agreement No. 857159.
                </p>
            </div>
        </div>


        <hr>
        <div class="row align-items-center mt-5 " style="text-align: center" >
            <h2 class="mb-5"><u>Learn More</u></h2>
            <div class="col-4">
                <ul>
                    <li><a href="{{route('content-guidelines')}}"> {{__('messages.content-guidelines')}} </a></li>
                </ul>
            </div>
            <div class="col-4">
                <ul>
                    <li><a href="{{app()->getLocale() .'/privacy-policy'}}"  target="_blank">{!! __('messages.privacy-policy') !!}</a></li>
                </ul>
            </div>
            <div class="col-4">
                <ul>
                    <li><a href="{{'/terms-of-use' }}">{!! __('messages.terms-of-use') !!}</a></li>
                </ul>
            </div>


        </div>


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
