@extends('layouts.app')
@push('css')
    @vite('resources/sass/form-new-exercise.scss')
@endpush
@section('content')

    <div class="container" style="height:90rem" >
    <header class=" d-flex justify-content-center">
        <div class="header__title content" style="margin-top: 20rem">
            <row><h1 class="mb-3 align-content-center">
                    Coming Soon...
                </h1>
            </row>
            <row>
                <em>You may close this tab if you wish.</em>
            </row>
        </div>
    </header>
    </div>

@endsection
@push('scripts')
    @vite('resources/js/create-edit-resource.js')
@endpush
