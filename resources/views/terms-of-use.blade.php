@extends('layouts.app')
@push('css')
@endpush

@include Route().App::currentLocale();

@push('scripts')
    <script src="{{ mix('dist/js/content-guidelines.js') }}"></script>
@endpush
