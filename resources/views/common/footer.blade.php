<div class="footer-dark py-4">
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-md-3 item">
{{--                    <h3>{!! __('messages.services') !!}</h3>--}}
                    <h3>Services</h3>
                    <ul>
                        <li><a href="{{ route('resources.display') }}">{!! __('messages.exercises') !!}</a></li>
{{--                        <li><a href="#">{!! __('messages.content_guidelines') !!}</a></li>--}}
                    </ul>
                </div>
                <div class="col-sm-6 col-md-3 item">
                    <h3>About</h3>
                    <ul>
                        <li><a href="https://www.scify.gr/site/en/">{!! __('messages.team') !!} </a></li>
                        <li><a href="{{ config('app.url') }}">{!! __('messages.download-app') !!} {!! __('messages.dianoia') !!} </a></li>
                        <li><a href="https://www.scify.gr/site/en/contact" target="_blank">{!! __('messages.contact-us') !!} </a></li>
                    </ul>
                </div>
                <div class="col-md-6 item text">
                    <p><a href="https://www.scify.gr/site/en/who-we-are/scify" target="_blank">{!! __('messages.footer-scify') !!}
                </div>
            <div class="copyright">
                <h3 class="m-0">Created by <a href="https://www.scify.gr/site/en/">SciFY</a> @ {{ now()->year }}</h3>
                <h3>version <b>{{ config('app.version') }}</b></h3>
            </div>
        </div>
    </footer>
</div>
