@if(isset($_COOKIE[config('cookies_consent.cookie_prefix')
. 'cookies_consent_targeting']))
    @if(config('app.google_tag_manager_id'))
        <!-- Google Tag Manager -->
        <script async
                src="https://www.googletagmanager.com/gtag/js?id={{ config('app.google_tag_manager_id') }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }

            gtag('js', new Date());

            gtag('config', '{{ config('app.google_tag_manager_id') }}');
        </script>
        <!-- End Google Tag Manager -->
    @endif
@endif
