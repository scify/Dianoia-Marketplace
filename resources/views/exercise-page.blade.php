@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{mix('dist/css/exercise-template.css')}}">
    <link rel="stylesheet" href="{{mix('dist/css/exercise-page.css')}}">
@endpush

@section('content')

    <main>
        <div class="row mt-5">
            <div class="col">
                <exercises-with-filters
                    :resources-route="'{{ route('resources.get') }}'"
                    :creation-route="'{{route('resources.create')}}'"
                    :user='@json($user)'
                    :resources-statuses='@json($viewModel->types)'
                    :is-admin="'{{$viewModel->isAdmin}}'"
                    :approve-resources="{{0}}">
                </exercises-with-filters>
            </div>
        </div>
    </main>


@endsection

@push('scripts')

    <script src="{{ mix('dist/js/create-edit-resource.js') }}"></script>
@endpush
