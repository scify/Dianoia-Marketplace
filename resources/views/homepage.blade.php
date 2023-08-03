@extends('layouts.app')
@push('css')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{--    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"--}}
    {{--          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">--}}
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600" rel="stylesheet">
    <link rel="stylesheet" href="{{mix('dist/css/homepage.css')}}">
    <title>dianoia marketplace</title>
@endpush

@section('content')

    <header class="header">
        <div class="header__title content">
            <h1 class="mb-3">
                {!!__('messages.marketplace')!!}
            </h1>
            <div class="header__text-box row">
                <div class="col-12">
                    <div class="header__text-box-1 row">
                        <div class="col">
                            {!!__('messages.intro')!!}
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row">
                        <div class="header__text-box-2 col-md-6 col-sm-12">
                            <a href="{{route('resources.create')}}">  {!!__('messages.create-content')!!}</a>
                        </div>
                        <div class="header__text-box-3 col-md-6 col-sm-12">
                            <a href="{{url("https://www.scify.gr/site/el/impact-areas/assistive-technologies/dianoia")}}"
                               target="_blank" rel="noopener noreferrer">{{__('messages.learn-more-mobile')}}</a>
                        </div>
                    </div>
                </div>

            </div>


        </div>
    </header>
    <main>
        <div class="mobile-app d-flex align-items-center" id="downloadMobileAppBtn">
            <div class="mobile-app__text content">
                <h1 class="mb-5"> {{__('messages.mobile-app')}} </h1>
                <p>
                    {!!__('messages.app-description')!!}
                </p>

                <a href="https://play.google.com/store/apps/details?id=org.scify.dianoia.app&hl={{ app()->getLocale() }}"
                   class="mt-5 btn btn--primary" style="margin:5px;" target="_blank">{{__('messages.download-app')}}</a>
                <a href="https://dianoia-app.scify.org/" class="mt-5 btn btn--primary" style="margin:5px;"
                   target="_blank">{{__('messages.dianoia-web-version')}}</a>

            </div>
        </div>

        <div class="patient d-flex align-items-center" id="patientsInfo">
            <div class="patient__text content">
                <h1 class="mb-5">{{__('messages.help-patient')}}</h1>
                <p class="mb-5">
                    {{__('messages.app-description-2')}}
                </p>
                <p class="mb-5">{!!__('messages.exercises-tutorial')!!}</p>
                <a href="{{route('resources.display',['preselect_type_name' => 'patient'])}}"
                   class="mt-5 btn btn--tertiary" target="_blank"><b>{{__('messages.see-exercises')}}</b></a>

            </div>

        </div>
        <div class="carer d-flex align-items-center" id="carersInfo">
            <div class="carer__text content">

                <h1 class="mb-5">{{__('messages.carer-teaser')}}</h1>
                <p class="mb-5">{{__('messages.carer-motivation')}}</p>
                <a href="{{route('resources.display',['preselect_type_name' => 'carer'])}}"
                   class="mb-5 mt-3 btn btn--tertiary" target="_blank"><b>{{__('messages.see-what-is-offered')}}</b></a>
            </div>
        </div>
    </main>

@endsection
@push('scripts')
    <script src="{{ mix('dist/js/create-edit-resource.js') }}"></script>
@endpush
