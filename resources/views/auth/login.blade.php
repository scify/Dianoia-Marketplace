@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ mix('dist/css/login-page.css') }}">
@endpush

@section('content')
<main>
    <div class="login-page d-flex align-items-center">
        <form method="POST" action="{{ route('login') }}" class="content">
            @csrf
            <h2 class="text-center mb-5 mt-5">{{  __('auth.login_btn')}}</h2>
            <div class="mb-3">
                <label for="email" class="form-label">{{ __('auth.email_label') }}</label>
                <input type="email" name='email' class="form-control @error('email') is-invalid @enderror" placeholder="{{  __('auth.type_mail')}}"
                       id="email" aria-describedby="emailHelp" required autocomplete="email" autofocus>
                @error('email')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mb-5">
                <label for="password" class="form-label">{{ __('auth.password_label') }}</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="{{  __('auth.type_password')}}"
                       id="password" required autocomplete="current-password" name="password">

                @error('password')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
            </div>
{{--            <p class="text-center mt-5 ">Με την σύνδεσής σας αποδέχεστε τους <a href="#">όρους χρήσης</a>.</p>--}}
            <button type="submit" class="btn btn-primary mb-5 mt-3"> {{ __('auth.login_btn') }}</button>

            <div>
                <a class="btn btn-link" href="{{ route('shapes.login') }}">
                    Login with SHAPES
                </a>
                <img alt="Shapes Logo" title="" src="img/shapes_logo.png" style="width:70px">
            </div>



            @if (Route::has('password.request'))
                <a class="btn btn-link" href="{{ route('password.request') }}">
                    {{ __('auth.forgot_password_link') }}
                </a>
            @endif
            <hr class="mt-5">
            <p class="text-center">  {{ __('auth.no_account') }}<a href="{{ route('register') }} ">{{ __('auth.register_here') }}</a></p>
        </form>
    </div>
</main>
@endsection


