<nav class="navbar navbar-expand-lg  fixed-top   navbar-light">
    <div class="container">
        <a class="navbar-brand" href="{{ route('homepage') }}" tabindex="-1">
            <img
                loading="lazy"
                src="{{ asset('img/dianoia_logo.png') }}" height="100px" alt="Marketplace logo">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown navbar-item-dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false"> {{__('messages.dianoia')}}
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item"
                               href="{{route('homepage')}}">{{__('messages.marketplace')}}</a>
                        </li>
                        <li><a class="dropdown-item"
                            href="{{ !Request::is('home') ? route('homepage') : '' }}#downloadMobileAppBtn">{{__('messages.mobile-app')}}</a>
                        </li>
                        <li><a class="dropdown-item" id="patientsDropdownItem"
                               href="{{ !Request::is('home') ? route('homepage') : '' }}#patientsInfo">{{__('messages.patients')}}</a>
                        </li>
                        <li><a class="dropdown-item" id="carersDropdownItem"
                               href="{{ !Request::is('home') ? route('homepage') : '' }}#carersInfo">{{__('messages.carers')}}</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ UrlMatchesMenuItem("about") }}"  href="{{ route('about')}}">
                        About
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ UrlMatchesMenuItem("tutorial") }}"  href="{{ route('tutorial')}}">
                        Tutorial
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"  id="mobileAppDropdownItem" href="{{ !Request::is('home') ? route('homepage') : '' }}#downloadMobileAppBtn">
                        {{__('messages.mobile-app')}}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ UrlMatchesMenuItem("resources.display") }}"
                       href="{{route('resources.display')}}">
                        {{__('messages.exercises')}}
                    </a>
                </li>
                @guest()
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            {!! __('auth.login_btn')!!}/{!! __('auth.register_btn')!!}
                        </a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                           data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#">
                                    {!! __('messages.user') !!}
                                </a>
                            </li>
                            @can('manage-platform')
                                <li>
                                    <a class="dropdown-item {{ UrlMatchesMenuItem("administration.users.index")}}"
                                       href="{{ route('administration.users.index') }}">
                                        User Management
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item {{ UrlMatchesMenuItem("administration.exercises_management")}}"
                                       href="{{ route('administration.exercises_management') }}">
                                        Exercises Management
                                    </a>
                                </li>
                            @endcan
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item"
                                   href="{{route('resources.my_profile')}}">   {!! __('messages.edit-profile') !!}</a>
                            </li>
                            <li><a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('auth.logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>

                    </li>
                @endguest
                <a href="{{route('content-guidelines')}}">
                    <i class="fa fa-question-circle " title="Content Guidelines" aria-hidden="true" style="font-size:24px;color:#3F51B5;padding:7px"></i>
                </a>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        <img
                            loading="lazy"
                            src="{{ asset('img/lang/' . \Illuminate\Support\Facades\App::getLocale() . '.png') }}"
                            height="20px" alt="Language">
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="{{ route('set-lang-locale', 'en') }}">
                                <img
                                    loading="lazy"
                                    class="mr-2"
                                    src="{{ asset('img/lang/en.png') }}"
                                    height="20px" alt="English">
                                {{__('messages.English')}}
                            </a>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('set-lang-locale', 'el') }}">
                                <img
                                    loading="lazy"
                                    class="mr-2"
                                    src="{{ asset('img/lang/el.png') }}"
                                    height="20px" alt="Greek">
                            {{__('messages.????????????????')}}
                            </a>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('set-lang-locale', 'it') }}">
                                <img
                                    loading="lazy"
                                    class="mr-2"
                                    src="{{ asset('img/lang/it.png') }}"
                                    height="20px" alt="Italian">
                                {{__('messages.Italian')}}
                            </a>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('set-lang-locale', 'sp') }}">
                                <img
                                    loading="lazy"
                                    class="mr-2"
                                    src="{{ asset('img/lang/sp.png') }}"
                                    height="20px" alt="Italian">
                                {{__('messages.Spanish')}}
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
@push('scripts')
    <script src="{{ mix('dist/js/create-edit-resource.js') }}"></script>
@endpush

