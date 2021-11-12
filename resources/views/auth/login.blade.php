@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ mix('dist/css/login-page.css') }}">
@endpush

@section('content')
{{--    <div class="container py-5">--}}
{{--        <div class="row justify-content-center py-5">--}}
{{--            <div class="col-md-8 pt-5">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">{{ __('Login') }}</div>--}}

{{--                    <div class="card-body">--}}
{{--                        <form method="POST" action="{{ route('login') }}">--}}
{{--                            @csrf--}}

{{--                            <div class="form-group row mb-2">--}}
{{--                                <label for="email"--}}
{{--                                       class="col-md-4 col-form-label text-md-right">{{ __('auth.email_label') }}</label>--}}

{{--                                <div class="col-md-6">--}}
{{--                                    <input id="email" type="email"--}}
{{--                                           class="form-control @error('email') is-invalid @enderror" name="email"--}}
{{--                                           value="{{ old('email') }}" required autocomplete="email" autofocus>--}}

{{--                                    @error('email')--}}
{{--                                    <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $message }}</strong>--}}
{{--                                    </span>--}}
{{--                                    @enderror--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <div class="form-group row mb-4">--}}
{{--                                <label for="password"--}}
{{--                                       class="col-md-4 col-form-label text-md-right">{{ __('auth.password_label') }}</label>--}}

{{--                                <div class="col-md-6">--}}
{{--                                    <input id="password" type="password"--}}
{{--                                           class="form-control @error('password') is-invalid @enderror" name="password"--}}
{{--                                           required autocomplete="current-password">--}}

{{--                                    @error('password')--}}
{{--                                    <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $message }}</strong>--}}
{{--                                    </span>--}}
{{--                                    @enderror--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <div class="form-group row mb-4">--}}
{{--                                <div class="col-md-6 offset-md-4">--}}
{{--                                    <div class="form-check">--}}
{{--                                        <input class="form-check-input" type="checkbox" name="remember"--}}
{{--                                               id="remember" {{ old('remember') ? 'checked' : '' }}>--}}

{{--                                        <label class="form-check-label" for="remember">--}}
{{--                                            {{ __('auth.remember_me_label') }}--}}
{{--                                        </label>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <div class="form-group row mb-0">--}}
{{--                                <div class="col-md-8 offset-md-4">--}}
{{--                                    <button type="submit" class="btn btn-primary">--}}
{{--                                        {{ __('auth.login_btn') }}--}}
{{--                                    </button>--}}

{{--                                    @if (Route::has('password.request'))--}}
{{--                                        <a class="btn btn-link" href="{{ route('password.request') }}">--}}
{{--                                            {{ __('auth.forgot_password_link') }}--}}
{{--                                        </a>--}}
{{--                                    @endif--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </form>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="row justify-content-center mt-3">--}}
{{--                <a class="btn btn-link" style="color: darkred;}" href="{{ route('register') }} ">--}}
{{--                    {{ __('auth.register_btn') }}--}}
{{--                </a>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
<main>
    <div class="login-page d-flex align-items-center">
        <form method="POST" action="{{ route('login') }}" class="content">
            @csrf
            <h2 class="text-center mb-5">{{ __('Login') }}</h2>
            <div class="mb-3">
                <label for="email" class="form-label">{{ __('auth.email_label') }}</label>
                <input type="email" name='email' class="form-control @error('email') is-invalid @enderror" placeholder="Πληκτρολογήστε το mail σας"
                       id="email" aria-describedby="emailHelp" required autocomplete="email" autofocus>
                @error('email')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mb-5">
                <label for="password" class="form-label">{{ __('auth.password_label') }}</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Πληκτρολογήστε τον κωδικό πρόσβασής σας"
                       id="password" required autocomplete="current-password" name="password">

                @error('password')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
            </div>
            <p class="text-center mt-5 ">Με την σύνδεσής σας αποδέχεστε τους <a href="#">όρους χρήσης</a>.</p>
            <button type="submit" class="btn btn-primary mb-5 mt-3"> {{ __('auth.login_btn') }}</button>
            @if (Route::has('password.request'))
                <a class="btn btn-link" href="{{ route('password.request') }}">
                    {{ __('auth.forgot_password_link') }}
                </a>
            @endif
            <hr class="mt-5">
            <p class="text-center"> Δεν έχετε λογαριασμό; <a href="{{ route('register') }} ">Κάντε εγγραφή εδώ.</a></p>
        </form>
    </div>
</main>
@endsection


