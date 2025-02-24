<div class="footer-dark py-5" id="footer">
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-md-3 item">
                    <h3>{!! __('messages.useful-links') !!}</h3>
                    <ul>
                        <li><a href="{{ route('resources.display') }}">{!! __('messages.exercises') !!}</a></li>
                        <li><a href="{{ route('about') }}">{!! __('messages.about') !!}</a></li>
                        <li>
                            <a href="https://play.google.com/store/apps/details?id=org.scify.dianoia.app&hl={{ app()->getLocale() }}"
                               target="_blank">{{__('messages.download-app')}}</a></li>
                        <li><a href="https://dianoia-app.scify.org/"
                               target="_blank">{{__('messages.dianoia-web-version')}}</a></li>
                        <li><a href="{{route('content-guidelines')}}"> {{__('messages.content-guidelines')}} </a></li>
                        <li><a href="javascript:void(0);" onclick="toggleCookieBanner()"
                               onkeyup="if (event.key === 'Enter') toggleCookieBanner()"
                               role="button" aria-label="{{ __('cookies_consent::messages.cookies_settings') }}">
                                {{ __('cookies_consent::messages.cookies_settings') }}
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-3 col-sm-6 item">
                    <h3>Dianoia Marketplace</h3>
                    <ul>
                        <li><a target="_blank" href="https://www.scify.org/en/">{!! __('messages.team') !!} </a></li>
                        <li><a href="https://scify.org/en/#footer-form"
                               target="_blank">{!! __('messages.contact-us') !!} </a></li>
                        <li><a href="{{ __('messages.terms-of-service-link') }}"
                               target="_blank">{!! __('messages.terms-of-use') !!}</a></li>
                        <li><a href="{{ __('messages.privacy-policy-link') }}"
                               target="_blank">{!! __('messages.privacy-policy') !!}</a></li>
                        <li><a href="{{ __('messages.cookies-policy-link') }}"
                               target="_blank">{!! __('messages.cookies-policy') !!}</a></li>
                    </ul>
                </div>
                <div class="col-md-6 item text">
                    <h3>{!! __('messages.Organization') !!}</h3>
                    <p style="font-size: small; color:whitesmoke!important">
                        {!! __('messages.footer-scify') !!}
                    </p>
                </div>
                <div class="col-md-6 col-sm-6 item text" style="margin-left: auto; margin-right: 0;">

                    <div class="copyright">
                        <p class="m-0">Created by <a target="_blank" href="https://www.scify.org/en/">SciFY</a>
                            @ {{ now()->year }}
                        </p>
                        <p>version <b>{{ config('app.version') }}</b></p>

                    </div>
                </div>
                <div class="col-md-6 col-sm-6 item text" style="margin-left: auto; margin-right: 0;">
                    <div>
                        <img alt="EU Logo" title="" src="{{asset("img/eu_logo.jpg")}}"
                             style="width:70px;height:50px;float:right;display:block;margin-right:100px">
                        <img alt="Shapes Logo" title="" src="{{asset("img/shapes_logo.png")}}"
                             style="width:70px;height:50px; float: right; display: block; background: white; margin-right:10px;">
                    </div>
                    <p style="font-size: small; color:white!important">
                        {{__('messages.funding-footer')}}
                    </p>
                </div>
            </div>
        </div>
    </footer>
</div>
