<div class="footer-dark py-5">
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-md-3 item">
                    <h3>{!! __('messages.useful-links') !!}</h3>
                    <ul>
                        <li><a href="{{ route('resources.display') }}">{!! __('messages.exercises') !!}</a></li>
                        <li><a href="{{ route('about') }}"> About </a></li>
                        <li><a href="https://www.scify.gr/site/el/impact-areas/assistive-technologies/dianoia#download"   target="_blank">{{__('messages.download-app')}}</a></li>
                        <li><a href="https://dianoia-app.scify.org/"  target="_blank">{{__('messages.dianoia-web-version')}}</a></li>
                        <li><a href="{{route('content-guidelines')}}"> {{__('messages.content-guidelines')}} </a></li>
                    </ul>
                </div>
                <div class="col-md-3 col-sm-6 item">
                    <h3>Dianoia Marketplace</h3>
                    <ul>
                        <li><a href="https://www.scify.gr/site/en/">{!! __('messages.team') !!} </a></li>
                        <li><a href="https://www.scify.gr/site/en/contact" target="_blank">{!! __('messages.contact-us') !!} </a></li>
                        <li><a href="{{'/terms-of-use' }}">{!! __('messages.terms-of-use') !!}</a></li>
                        <li><a href="{{route('privacy-policy')}}"  target="_blank">{!! __('messages.privacy-policy') !!}</a></li>
                    </ul>
                </div>
                <div class="col-md-6 item text">
                    <h3>{!! __('messages.Organization') !!}</h3>
                    <p style="font-size: small; color:whitesmoke!important"><a href="https://www.scify.gr/site/en/who-we-are/scify" target="_blank" >{!! __('messages.footer-scify') !!}
                </div>
<!--            <div class="copyright">-->
<!--                <h3 class="m-0">Created by <a href="https://www.scify.gr/site/en/">SciFY</a> @ {{ now()->year }}</h3>-->
<!--                <h3>version <b>{{ config('app.version') }}</b></h3>-->
<!---->
<!--            </div>-->
            <div class="col-md-6 col-sm-6 item text" style="margin-left: auto; margin-right: 0;">

                <div class="copyright" style="float:left!important">
                    <h3 class="m-0">Created by <a href="https://www.scify.gr/site/en/">SciFY</a> @ {{ now()->year }}</h3>
                    <h3>version <b>{{ config('app.version') }}</b></h3>

                </div>
            </div>
            <div class="col-md-6 col-sm-6 item text" style="margin-left: auto; margin-right: 0;">

                <div>
                    <img alt="EU Logo" title="" src="{{asset("img/eu_logo.jpg")}}" style="width:70px;height:50px;float:right;display:block;margin-right:100px">
                    <img alt="Shapes Logo" title="" src="{{asset("img/shapes_logo.png")}}"  style="width:70px;height:50px; float: right; display: block; background: white; margin-right:10px;">
                </div>
                <p style="font-size: small; color:white!important">This project has received funding from the European Union's Horizon 2020 research and innovation programme under grant agreement No. 857159.</p>
            </div>
        </div>
        </div>
    </footer>
</div>
