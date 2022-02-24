@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ mix('dist/css/form-new-exercise.css') }}">
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
    <script src="{{ mix('dist/js/create-edit-resource.js') }}"></script>
@endpush
