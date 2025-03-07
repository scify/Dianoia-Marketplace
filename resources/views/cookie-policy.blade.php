@extends('layouts.app')
@push('css')
    <title>Cookie Policy</title>
    <x-laravel-cookie-guard-scripts></x-laravel-cookie-guard-scripts>
@endpush

@section('content')
    <header class="mt-5 mb-5" style="text-align: center">
        <h1 style="text-decoration:underline;">{{__('messages.marketplace')}} </h1>
    </header>
    <main style="padding-bottom: 100px">
        <div class="container">
            <div class="row align-items-center mt-5">
                <x-laravel-cookie-guard-page></x-laravel-cookie-guard-page>
            </div>
        </div>
    </main>
@endsection
