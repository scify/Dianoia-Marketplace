@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ mix('dist/css/login-page.css') }}">
@endpush

@section('content')
    <div class="login-page d-flex align-items-center">
        <form method="POST" action="{{ route('register') }}" class="content">
            @csrf
            <h2 class="text-center mb-5 mt-5">{{  __('auth.register_btn')}}</h2>

            <div class="mb-3">
                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('auth.name_label') }}</label>
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                       placeholder="{{  __('auth.type_name')}}"
                       name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                @error('name')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>


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
            <div class="mb-3">
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
                       id="password-confirm" required autocomplete="password-confirmation" name="password_confirmation">

                @error('password_confirmation')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
            </div>
            <div class="form-group row mb-4">
                <div class="col-md-6">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember"
                               id="remember" {{ old('remember') ? 'checked' : '' }}>

                        <label class="form-check-label" for="remember">
                            {{ __('auth.remember_me_label') }}
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row mb-4">
                <div class="col">
                    <select class="form-select" aria-label="user_role" name="role" style="font-size: inherit;">
                        @foreach ($viewModel->roles as $role)
                            <option value="{{$role->id}}"> {{trans('messages.'.$role->name)}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mb-1 mt-3"> {{ __('auth.register_btn') }}</button>

            <p class="text-left mt-5">  {{ __('auth.already_account') }}: <a
                    href="{{ route('login') }} ">{{ __('auth.login_btn') }}</a></p>


            <hr class="mt-5">
            <div style="text-align: center">
                <a class="btn btn-success" href="{{ route('shapes.login') }}">Login / Register with a SHAPES account</a>
                <img alt="Shapes Logo" title="" src="img/shapes_logo.png" style="width:70px">
                <p style="font-size:small; font-style: italic; margin-top: 1rem">Create an account shared across all
                    SHAPES - powered
                    platforms</p>
            </div>


        </form>
    </div>
@endsection
