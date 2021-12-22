<div class="footer-dark py-5">
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-md-3 item">
{{--                    <h3>{!! __('messages.services') !!}</h3>--}}
                    <h3>{!! __('messages.useful-links') !!}</h3>
                    <ul>
                        <li><a href="{{ route('resources.display') }}">{!! __('messages.exercises') !!}</a></li>
                        <li><a href="https://www.scify.gr/site/el/impact-areas/assistive-technologies/dianoia#download"   target="_blank">{{__('messages.download-app')}}</a></li>
                        <li><a href="https://dianoia-app.scify.org/"  target="_blank">{{__('messages.dianoia-web-version')}}</a></li>

                        {{--                        <li><a href="#">{!! __('messages.content_guidelines') !!}</a></li>--}}
                    </ul>
                </div>
                <div class="col-sm-6 col-md-3 item">
                    <h3>{!! __('messages.people') !!}</h3>
                    <ul>
                        <li><a href="https://www.scify.gr/site/en/">{!! __('messages.team') !!} </a></li>
                        <li><a href="https://www.scify.gr/site/en/contact" target="_blank">{!! __('messages.contact-us') !!} </a></li>
                    </ul>
                </div>
                <div class="col-md-6 item text">
                    <h3>{!! __('messages.Organization') !!}</h3>
                    <p style="font-size: small; color:whitesmoke!important"><a href="https://www.scify.gr/site/en/who-we-are/scify" target="_blank" >{!! __('messages.footer-scify') !!}
                </div>
            <div class="copyright">
                <h3 class="m-0">Created by <a href="https://www.scify.gr/site/en/">SciFY</a> @ {{ now()->year }}</h3>
                <h3>version <b>{{ config('app.version') }}</b></h3>
            </div>
        </div>
    </footer>
</div>
