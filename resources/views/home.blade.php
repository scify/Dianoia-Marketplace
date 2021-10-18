
@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ mix('dist/css/home.css') }}">
@endpush

@section('content')
<div class="container h-100">
    <div class="row h-100 align-items-center">
        <div class="col h-100">
            <div class="container h-100">
                <div class="row align-items-center h-100">
                    <div class="col-6">
                        <h1>DiAnoia Landing Page</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script src="{{ mix('dist/js/home.js') }}"></script>
@endpush
