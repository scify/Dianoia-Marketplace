@extends('layouts.app')
@push('css')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600" rel="stylesheet">
    <link rel="stylesheet" href="{{mix('dist/css/homepage.css')}}">
    <title>dianoia marketplace</title>
@endpush

@section('content')


    <header class="header">
        <div class="header__title content">
            <h1 class="mb-3">
                διΆνοια Marketplace.
            </h1>
            <div class="header__text-box row">
                <div class="col-12">
                    <div class="header__text-box-1 row">
                        <div class="col">
{{--                            {{__('messages.intro')}}--}}
                            Βοηθάς άνθρωπο με αρχόμενη άνοια;<br /><br />
                            <ul>
                                <li>- Βρες νοητικές ασκήσεις και δραστηριότητες που μπορείτε να απολαύσετε από κοινού
                                </li>
                                <li>- Δημιούργησε το δικό σου υλικό</li>
                                <li>- Βρες συμβουλές για να φροντίσεις… εσένα που φροντίζεις!</li>
                            </ul>



                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row">
                        <div class="header__text-box-2 col-md-6 col-sm-12">
{{--                            <a href="#">   <b><u> {{__('messages.create-content')}}</u></b></a>--}}
                            Δημιούργησε     <a href="{{route('resources.create')}}">   <b><u>νέο περιεχόμενο</u></b></a>
                        </div>
                        <div class="header__text-box-3 col-md-6 col-sm-12">
                            <a href="#">{{__('messages.learn-more-mobile')}}</a>
                        </div>
                    </div>
                </div>

            </div>


        </div>
    </header>
    <main>
        <div class="mobile-app d-flex align-items-center">
            <div class="mobile-app__text content">
                <h1 class="mb-5"> {{__('messages.mobile-app')}} </h1>
                <p>
                    {{__('messages.app-description')}}
                </p>
                <p class="mb-5">
                    {{__('messages.app-description-2')}}
                </p>

                <a href="#" class="mt-5 btn btn--primary" target="_blank"> {{__('messages.download-app')}}</a>
            </div>
        </div>

        <div class="patient d-flex align-items-center">
            <div class="patient__text content">
                <h1 class="mb-5">{{__('messages.help-patient')}}</h1>
                <p class="mb-5">{{__('messages.exercises-tutorial')}}</p>
{{--                <p>Μπορείς επίσης να δημιουργήσεις τις δικές σου ασκήσεις και αν θέλεις να τις μοιραστείς με την--}}
{{--                    κοινότητα.--}}
{{--                </p>--}}
                <a href="#" class="mt-5 btn btn--tertiary" target="_blank">{{__('messages.see-exercises')}}</a>

            </div>

        </div>
        <div class="carer mt-5 d-flex align-items-center">
            <!--     <img class="img-fluid" loading="lazy" src="/img/grandmother-flowers.png" alt="title-image"> -->
            <div class="carer__text content">

                <h1 class="mb-5">{{__('messages.carer-teaser')}}</h1>
                <p class="mb-5">{{__('messages.carer-motivation')}}</p>
                <a href="#" class="mt-5 btn btn--tertiary" target="_blank">{{__('messages.see-what-is-offered')}}</a>
            </div>
        </div>
    </main>
@endsection
@push('scripts')
    <script src="{{ mix('dist/js/home.js') }}"></script>
@endpush
