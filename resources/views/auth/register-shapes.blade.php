@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ mix('dist/css/login-page-shapes.css') }}">
@endpush

@section('content')

    <div class="login-page-shapes d-flex " style="text-align:center">
        <form method="POST" action="{{ route('shapes.request-create-user') }}" class="content mt-5">
            <img loading="lazy" src="{{ asset('img/shapes_logo.png') }}" height="120px" alt="Shapes logo">
            @csrf
            <h2 class="text-center mb-5 mt-5 shapes-message">{{  __('auth.register_btn')}}</h2>
            <div class="mb-3">
                <label for="email" class="form-label">{{ __('auth.email_label') }}</label>
                <input type="email" name='email' class="form-control @error('email') is-invalid @enderror"
                       placeholder="{{  __('auth.type_mail')}}"
                       id="email" aria-describedby="emailHelp" required autocomplete="email" autofocus>
                @error('email')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mb-5">
                <label for="password" class="form-label">{{ __('auth.password_label') }}</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror"
                       placeholder="{{  __('auth.type_password')}}"
                       id="password" required autocomplete="current-password" name="password">

                @error('password')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">{{ __('auth.confirm_password_label') }}</label>
                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                       placeholder="{{  __('auth.confirm_password_label')}}"
                       id="password-confirm" required autocomplete="password-confirmation"
                       name="password_confirmation">

                @error('password_confirmation')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
            </div>
            <button type="submit"
                    class="btn btn-primary mb-5 mt-3 shapes-btn"> {{ __('auth.register_btn') }}</button>
            @if (Route::has('password.request'))
                <a class="btn btn-link shapes-message"
                   href="https://kubernetes.pasiphae.eu/shapes/asapa/auth/password/recovery">
                    {{ __('auth.forgot_password_link') }}
                </a>
            @endif
            <hr class="mt-1">
            <p class="text-center">  {{ __('auth.already_account') }}? <a
                    href="{{ route('shapes.login') }} "> {{ __('auth.login_btn')}} with SHAPES</a></p>
        </form>
    </div>
@endsection

